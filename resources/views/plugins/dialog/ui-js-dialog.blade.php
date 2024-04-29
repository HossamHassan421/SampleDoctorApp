<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
    function ui_form_dialog(form_element, message, title = '{{ trans('dashboard.confirmation') }}',
                            cancel_button = "{{ trans('dashboard.cancel_button') }}", ok_button = "{{ trans('dashboard.ok_button') }}") {
        $(form_element).submit(function (event) {
            var thisForm = $(this);
            event.preventDefault();
            $("<div>" + message + "</div>").dialog({
                resizable: false,
                modal: true,
                title: title,
                show: {
                    effect: "fade",
                    duration: 500
                },
                hide: {
                    effect: "fade",
                    duration: 500
                },
                position: {
                    my: "center",
                    at: "center",
                    of: window
                },
                buttons: [
                    {
                        text: cancel_button,
                        class: "btn btn-outline-secondary waves-effect",
                        click: function () {
                            $(this).dialog("close");
                        }
                    },
                    {
                        text: ok_button,
                        class: "btn btn-primary waves-effect",
                        click: function () {
                            thisForm.off("submit").submit();
                            $(this).dialog("close");
                        }
                    }
                ]
            });
        });
    }

    function ui_anchor_dialog(anchor_element, message, title = '{{ trans('dashboard.confirmation') }}',
                            cancel_button = "{{ trans('dashboard.cancel_button') }}", ok_button = "{{ trans('dashboard.ok_button') }}") {
        $(anchor_element).click(function (event) {
            var thisAnchor = $(this);
            event.preventDefault();
            $("<div>" + message + "</div>").dialog({
                resizable: false,
                modal: true,
                title: title,
                show: {
                    effect: "fade",
                    duration: 500
                },
                hide: {
                    effect: "fade",
                    duration: 500
                },
                position: {
                    my: "center",
                    at: "center",
                    of: window
                },
                buttons: [
                    {
                        text: cancel_button,
                        class: "btn btn-outline-secondary waves-effect",
                        click: function () {
                            $(this).dialog("close");
                        }
                    },
                    {
                        text: ok_button,
                        class: "btn btn-primary waves-effect",
                        click: function () {
                            window.location.href = thisAnchor.attr('href');
                            $(this).dialog("close");
                        }
                    }
                ]
            });
        });
    }
</script>
