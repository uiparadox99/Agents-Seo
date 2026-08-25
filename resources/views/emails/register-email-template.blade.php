<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <title>Confirm your Agents PK account</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f1f1f1;
            font-family: Arial, Helvetica, sans-serif;
        }
        table {
            border-collapse: collapse;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
        }
        .header {
            background: #070c39;
            padding: 30px;
            text-align: center;
        }
        .content {
            padding: 30px;
            color: #333333;
            font-size: 15px;
            line-height: 22px;
        }
        .button {
            display: inline-block;
            padding: 12px 20px;
            background: #070c39;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
        }
        .footer {
            padding: 20px;
            font-size: 12px;
            color: #777777;
            text-align: center;
        }
    </style>
</head>

<body>

<!-- Preheader (REAL text, hidden) -->
<div style="display:none; max-height:0; overflow:hidden;">
Confirm your Agents PK account to complete registration.
</div>

<table width="100%">
    <tr>
        <td>
            <table class="container" width="100%">
                
                <!-- Header -->
                <tr>
                    <td class="header">
                        <!--<img src="./images/agents-logo.png"-->
                        <!--     alt="Agents PK"-->
                        <!--     width="160"-->
                        <!--     style="display:block;margin:auto;">-->
                        <h2>Agents PK</h2>
                    </td>
                </tr>

                <!-- Content -->
                <tr>
                    <td class="content">
                        <p>Hello {{ $name }},</p>

                        <p>
                            Thank you for registering on <strong>Agents PK</strong>.
                            To keep your account secure, please confirm your email address.
                        </p>

                        <p style="text-align:center; margin:30px 0;">
                            <a href="{{ url('account-activation/'.$token) }}" class="button">
                                Confirm my account
                            </a>
                        </p>

                        <p>
                            If you did not create this account, you can safely ignore this email.
                        </p>

                        <p>
                            Regards,<br>
                            <strong>Agents PK Team</strong>
                        </p>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td class="footer">
                        <p>
                            This email was sent by Agents PK<br>
                            <a href="https://agents.com.pk">https://agents.com.pk</a>
                        </p>

                        <p>
                            © {{ date('Y') }} Agents.com.pk. All rights reserved.
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>