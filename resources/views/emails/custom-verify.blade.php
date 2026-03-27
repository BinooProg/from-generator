<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email Address</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            background-color: #fafafa;
            color: #171717;
            line-height: 1.6;
        }

        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .email-container {
            background-color: #ffffff;
            border: 1px solid #e5e5e5;
        }

        .brand-label {
            font-size: 18px;
            font-weight: 600;
            letter-spacing: -0.02em;
            line-height: 1;
            margin-bottom: 24px;
            color: #171717;
        }

        .email-body {
            padding: 48px 32px;
        }

        .heading {
            font-size: 28px;
            font-weight: 300;
            letter-spacing: -0.025em;
            margin-bottom: 12px;
            color: #171717;
        }

        .heading strong {
            font-weight: 600;
        }

        .text {
            font-size: 15px;
            color: #525252;
            font-weight: 300;
            margin-bottom: 24px;
        }

        .button-container {
            margin: 32px 0;
        }

        .button {
            display: inline-block;
            padding: 14px 32px;
            background-color: #ffffff;
            color: #171717;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            letter-spacing: 0.01em;
            border: 2px solid #171717;
            transition: all 0.2s ease;
        }

        .button:hover {
            background-color: #f5f5f5;
            border-color: #171717;
            color: #171717;
        }

        .divider {
            margin: 32px 0;
            height: 1px;
            background-color: #e5e5e5;
        }

        .secondary-text {
            font-size: 14px;
            color: #737373;
            font-weight: 300;
            line-height: 1.7;
        }

        .link-text {
            color: #171717;
            text-decoration: underline;
            word-break: break-all;
        }

        .email-footer {
            padding: 32px;
            background-color: #fafafa;
            border-top: 1px solid #e5e5e5;
            text-align: center;
        }

        .footer-text {
            font-size: 13px;
            color: #737373;
            font-weight: 300;
        }

        @media only screen and (max-width: 600px) {
            .email-wrapper {
                padding: 20px 10px;
            }

            .email-body {
                padding: 32px 20px;
            }

            .email-footer {
                padding: 24px 20px;
            }

            .heading {
                font-size: 24px;
            }

            .button {
                display: block;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div class="email-wrapper">
        <div class="email-container">
            <!-- Body -->
            <div class="email-body">
                <p class="brand-label"
                    style="font-size: 18px; font-weight: 600; letter-spacing: -0.02em; line-height: 1; margin-bottom: 24px; color: #171717;">
                    Form Generator
                </p>

                <h1 class="heading">
                    Verify your <strong>email address</strong>
                </h1>

                <p class="text">
                    Welcome to Form Generator. To complete your registration and start building beautiful forms,
                    please verify your email address by clicking the button below.
                </p>

                <div class="button-container">
                    <a href="{{ $url }}" class="button"
                        style="display: inline-block; padding: 14px 32px; background-color: #ffffff; color: #171717 !important; text-decoration: none; font-size: 14px; font-weight: 600; letter-spacing: 0.01em; border: 2px solid #171717;">
                        Verify Email Address
                    </a>
                </div>

                <div class="divider"></div>

                <p class="secondary-text">
                    If you're having trouble clicking the button, copy and paste the URL below into your web browser:
                </p>

                <p class="secondary-text" style="margin-top: 16px;">
                    <a href="{{ $url }}" class="link-text">{{ $url }}</a>
                </p>

                <div class="divider"></div>

                <p class="secondary-text">
                    If you did not create an account, no further action is required.
                </p>
            </div>

            <!-- Footer -->
            <div class="email-footer">
                <p class="footer-text">
                    © {{ date('Y') }} Form Generator. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>

</html>
