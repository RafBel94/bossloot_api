<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email Address</title>
    <style>
        /* Base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        
        /* Main container */
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
        }
        
        /* Header section */
        .email-header {
            background-color: #6c5ce7;
            padding: 30px 0;
            text-align: center;
        }
        
        .email-header img {
            max-width: 200px;
            height: auto;
        }
        
        /* Body section */
        .email-body {
            padding: 40px 30px;
            text-align: center;
        }
        
        .title {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
            font-weight: 700;
        }
        
        .subtitle {
            font-size: 16px;
            color: #555;
            margin-bottom: 30px;
            font-weight: 400;
        }
        
        /* Verification button */
        .verification-button {
            display: inline-block;
            background-color: #6c5ce7;
            color: white;
            font-weight: 600;
            text-decoration: none;
            padding: 14px 35px;
            border-radius: 50px;
            margin: 25px 0;
            box-shadow: 0 4px 8px rgba(108, 92, 231, 0.3);
            transition: all 0.3s ease;
        }
        
        .verification-button:hover {
            background-color: #5649c0;
            box-shadow: 0 6px 12px rgba(108, 92, 231, 0.4);
        }
        
        /* Expiration notice */
        .expiration {
            font-size: 14px;
            color: #777;
            font-style: italic;
            margin-bottom: 25px;
        }
        
        /* Alternative link section */
        .alternative-link {
            margin: 20px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
            font-size: 13px;
        }
        
        .alternative-link p {
            margin-bottom: 10px;
            color: #666;
        }
        
        .link-url {
            word-break: break-all;
            color: #6c5ce7;
            font-size: 12px;
        }
        
        /* Footer section */
        .email-footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #eee;
        }
        
        .signature {
            margin-bottom: 15px;
            font-size: 15px;
            color: #555;
        }
        
        .company {
            font-weight: 600;
            color: #333;
        }
        
        .disclaimer {
            font-size: 12px;
            color: #999;
            margin-top: 15px;
        }
        
        /* Responsive adjustments */
        @media only screen and (max-width: 480px) {
            .email-container {
                width: 100%;
                margin: 0;
                border-radius: 0;
            }
            
            .email-body {
                padding: 30px 20px;
            }
            
            .title {
                font-size: 20px;
            }
            
            .verification-button {
                padding: 12px 25px;
                width: 80%;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            <img src="https://res.cloudinary.com/dlmbw4who/image/upload/v1742656623/bossloot-logo-full_ts0enf.png" alt="BossLoot Logo">
        </div>
        
        <div class="email-body">
            <h1 class="title">Verify Your Email Address</h1>
            <p class="subtitle">Thanks for signing up! Please verify your email address to access all features of BossLoot.</p>
            
            <a href="{{ $verificationUrl }}" class="verification-button">Verify My Email</a>
            
            <p class="expiration">This verification link will expire in {{ $expiresIn }} minutes.</p>
            
            <div class="alternative-link">
                <p>If the button above doesn't work, copy and paste this URL into your browser:</p>
                <div class="link-url">{{ $verificationUrl }}</div>
            </div>
            
            <p>If you did not create an account, no further action is required.</p>
        </div>
        
        <div class="email-footer">
            <p class="signature">Thanks,<br><span class="company">The BossLoot Team</span></p>
            
            <div class="disclaimer">
                &copy; {{ date('Y') }} BossLoot. All rights reserved.<br>
                This is an automated message. Please do not reply directly to this email.
            </div>
        </div>
    </div>
</body>
</html>