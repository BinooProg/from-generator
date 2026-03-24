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

        .email-header {
            padding: 32px;
            border-bottom: 1px solid #e5e5e5;
        }

        .logo {
            font-size: 18px;
            font-weight: 600;
            letter-spacing: -0.025em;
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
            background-color: #171717;
            color: #ffffff;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            letter-spacing: 0.01em;
            border: 2px solid #171717;
            transition: all 0.2s ease;
        }

        .button:hover {
            background-color: #262626;
            border-color: #262626;
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

        .icon-box {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            border: 2px solid #171717;
            margin-bottom: 24px;
        }

        @media only screen and (max-width: 600px) {
            .email-wrapper {
                padding: 20px 10px;
            }

            .email-header {
                padding: 24px 20px;
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
            <!-- Header -->
            <div class="email-header">
                <div class="logo">FORM / GENERATOR</div>
            </div>

            <!-- Body -->
            <div class="email-body">
                <div class="icon-box">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                </div>

                <h1 class="heading">
                    Verify your <strong>email address</strong>
                </h1>

                <p class="text">
                    Welcome to Form Generator. To complete your registration and start building beautiful forms,
                    please verify your email address by clicking the button below.
                </p>

                <div class="button-container">
                    <a href="{{ $url }}" class="button">
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
