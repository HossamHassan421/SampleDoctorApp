<script type="text/javascript">
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function isValidUrl(url) {
        var urlRegex = /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i;
        return urlRegex.test(url);
    }

    function checkImage(input, requiredWidth, requiredHeight) {
        if (input.files && input.files[0]) {
            var file = input.files[0];

            // Check if the file is an image.
            if (file.type.match('image.*')) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    // Create a new image to test dimensions
                    var img = new Image();

                    img.onload = function () {
                        // Check if width and height
                        var widthOk = !requiredWidth || img.width <= requiredWidth;
                        var heightOk = !requiredHeight || img.height <= requiredHeight;

                        if (widthOk && heightOk) {
                            console.log('The image is valid.');
                        } else {
                            var errorMsg = 'The image dimensions must not greater than ';
                            if (requiredWidth && requiredHeight) {
                                errorMsg += requiredWidth + 'x' + requiredHeight;
                            } else if (requiredWidth) {
                                errorMsg += 'width ' + requiredWidth + 'px';
                            } else if (requiredHeight) {
                                errorMsg += 'height ' + requiredHeight + 'px';
                            }
                            callToastr('error', '{{ trans('cms.toastr_error') }}', errorMsg);
                            // Clear the input
                            $(input).val('');
                        }
                    };
                    img.onerror = function () {
                        callToastr('error', '{{ trans('cms.toastr_error') }}', '{{trans('cms.please_upload_images_only')}}');
                        $(input).val('');
                    };
                    // Set the source of the image to the read data URL
                    img.src = e.target.result;
                };
                // Read the file as Data URL (Base64 encoded string of the file)
                reader.readAsDataURL(file);
            } else {
                callToastr('error', '{{ trans('cms.toastr_error') }}', '{{trans('cms.please_upload_images_only')}}');
                $(input).val('');
            }
        }
    }

    function maxNumber(obj, number) {
        if ($(obj).val() > number) {
            $(obj).val(number);
        } else if ($(obj).val() < 0) {
            $(obj).val(0);
        }
    }

    function preventNonNumeric(event) {
        // Get the character input from the keypress event
        var char = event.key;
        var value = event.target.value;
        var hasDecimalPoint = value.indexOf('.') !== -1;
        console.log(char, hasDecimalPoint);

        // Allow backspace, tab, enter, arrow keys, and delete keys
        if (
            event.keyCode === 8 || // Backspace
            event.keyCode === 9 || // Tab
            event.keyCode === 13 || // Enter
            (event.keyCode >= 37 && event.keyCode <= 40) || // Arrow keys
            event.keyCode === 46 || // Delete
            (event.keyCode >= 48 && event.keyCode <= 57) || // Top row numbers
            (event.keyCode >= 96 && event.keyCode <= 105) // Numeric keypad numbers
        ) {
            // Allow but do not prevent default
        } else if (char === '.' && !hasDecimalPoint) {
            // Allow one decimal point
        } else {
            // Prevent default if it's not a numeric character
            event.preventDefault();
        }
    }

    function truncateUp(obj, digits, numbersOnly = false) {
        if (numbersOnly) {
            if (!/^(?:\d+(?:\.\d*)?|\.\d+)$/.test($(obj).val())) {
                $(obj).val('');
            }
        }
        $(obj).val($(obj).val().substr(0, digits));
    }

    $(function () {
        $('.phone_number_digits').on('keydown', function (event) {
            preventNonNumeric(event);
        }).on('input', function () {
            truncateUp(this, 9); // truncate to 9 digits
        });

        $('.max_100_number').on('input', function () {
            maxNumber(this, 100);
        });

        $('.check_email').on('blur', function () {
            if ($(this).val().length && !isValidEmail($(this).val())) {
                callToastr('error', '{{ trans('cms.toastr_error') }}', '{{trans('cms.invalidate_email_format')}}');
                $(this).val('');
            }
        });

        $('.check_url').on('blur', function () {
            if ($(this).val().length && !isValidUrl($(this).val())) {
                callToastr('error', '{{ trans('cms.toastr_error') }}', '{{trans('cms.invalidate_url_format')}}');
                $(this).val('');
            }
        });

        $(".arabic_text").on("input", function () {
            var regex = /^[\u0600-\u06FF\s]+$/;
            var input = $(this).val();
            if (!regex.test(input)) {
                $(this).val(input.replace(/[^ء-ي\s]/g, ""));
            }
        });

        $('.english_text').on('input', function () {
            // Check if input value contains only English letters
            if (!/^[a-zA-Z\s]*$/g.test($(this).val())) {
                $(this).val($(this).val().slice(0, -1)); // remove last input character
            }
        });

        $("input[name='email']").on("input", function () {
            if (isValidEmail($(this).val())) {
                // Email format is valid
                $(this).removeClass('border-danger').addClass('border-success');
            } else {
                // Email format is invalid
                $(this).removeClass('border-success').addClass('border-danger');
            }
        });
    })
</script>
