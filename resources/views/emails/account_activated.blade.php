<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Account Activated - HornTech</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f7f9; }
        .container { max-width: 600px; margin: 20px auto; padding: 40px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header { text-align: center; margin-bottom: 30px; }
        .header img { max-width: 150px; }
        h1 { color: #004161; font-size: 22px; margin-bottom: 20px; text-align: center; }
        .content { margin-bottom: 30px; }
        .details { background-color: #f8fafc; padding: 20px; border-radius: 6px; border-left: 4px solid #99CC33; margin: 20px 0; }
        .details p { margin: 8px 0; font-family: monospace; font-size: 15px; }
        .details label { font-weight: bold; color: #666; display: inline-block; width: 100px; }
        .footer { text-align: center; color: #777; font-size: 13px; margin-top: 40px; border-top: 1px solid #eee; padding-top: 20px; }
        .btn { display: inline-block; padding: 12px 24px; background-color: #004161; color: #ffffff !important; text-decoration: none; border-radius: 6px; font-weight: bold; margin-top: 20px; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <!-- You can add your logo here -->
            <h2 style="color: #004161; margin: 0;">HornTech</h2>
        </div>

        <!-- Verified Badge -->
        <div style="text-align:center; margin-bottom: 24px;">
            <span style="display:inline-flex; align-items:center; gap:6px; background-color:#f0fdf4; border:1px solid #86efac; color:#16a34a; padding:6px 16px; border-radius:999px; font-size:13px; font-weight:bold;">
                &#10003; Email Address Verified
            </span>
        </div>

        <p>Dear {{ $userName }},</p>

        <p>Greetings from HornTech.</p>

        <p>We are pleased to inform you that your HornTech ERP System has been successfully activated and your email address has been verified. Your organization can now access and utilize the system to manage your business operations efficiently.</p>

        <p>Please find your access details below:</p>

        <div class="details">
            <p><label>System URL:</label> <a href="{{ config('app.url') }}" style="color: #004161;">{{ config('app.url') }}</a></p>
            <p><label>Username:</label> <a href="mailto:{{ $username }}" style="color:#004161;">{{ $username }}</a></p>
            <p><label>Password:</label> {{ $password }}</p>
        </div>

        <p>We recommend that you change your password upon first login for security purposes.</p>

        <p style="text-align: center;">
            <a href="{{ config('app.url') }}/login" class="btn">Login to ERP System</a>
        </p>

        <p>If you require any assistance with setup, training, or configuration, please do not hesitate to contact our support team.</p>

        <p>Thank you for choosing HornTech.</p>

        <div class="footer">
            <p>Best regards,<br>
            <strong>HornTech Support Team</strong><br>
            HornTech LTD. | <a href="mailto:support@horntech.com" style="color: #777;">support@horntech.com</a></p>
        </div>
    </div>
</body>
</html>
