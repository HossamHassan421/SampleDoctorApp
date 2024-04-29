<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Doctor Account</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            font-size: 20px;

            @if(app()->getLocale() == 'ar')
            direction: rtl;
            text-align: right;
            @endif
        }

        h1 {
            color: #007bff;
        }

        p {
            line-height: 1.6;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        .footer {
            margin-top: 20px;
            background-color: #eee;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div class="container">

    <p>{{ __('doctor_emails.dear') }} {{ $doctor->name }},</p>

    <p>{{ __('doctor_emails.we_are_excited_to_have_you_on_board') }}</p>

    <p>{{ __('doctor_emails.the_user_name_is') }} {{ $doctor->email }}</p>
    <p>{{ __('doctor_emails.the_password_is') }} {{ $password }}</p>

    <p>{{ __('doctor_emails.to_get_started_simply_download_app') }}</p>
    <p>{{ __('doctor_emails.if_you_have_any_questions') }}</p>

    <div class="footer">
        <p>{{ __('doctor_emails.best_regards') }}, {{ __('doctor_emails.support_team') }}</p>
    </div>
</div>
</body>
</html>
