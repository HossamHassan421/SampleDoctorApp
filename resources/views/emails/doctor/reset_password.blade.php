<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Password Reset</title>
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

    <p>{{ __('doctor_emails.password_reset_this_inform_you') }}</p>

    <p>{{ __('doctor_emails.the_new_password_is') }} {{ $newPassword }}</p>

    <p>{{ __('doctor_emails.to_login_to_your_account_please_follow') }}</p>

    <p>{{ __('doctor_emails.to_login_to_your_account_steps') }}</p>
    <p>{{ __('doctor_emails.to_login_to_your_account_steps2') }}</p>
    <p>{{ __('doctor_emails.to_login_to_your_account_steps3') }}</p>

    <div class="footer">
        <p>{{ __('doctor_emails.best_regards') }}, {{ __('doctor_emails.support_team') }}</p>
    </div>
</div>
</body>
</html>
