<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Response to Your Contact Form</title>
    <style>
        /* Base styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }
        
        /* Header styles */
        .email-header {
            background-color: #6c5ce7;
            padding: 20px;
            text-align: center;
            color: white;
        }
        
        .email-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        
        /* Content styles */
        .email-body {
            padding: 30px;
        }
        
        .intro {
            background-color: #f8f9fa;
            border-left: 4px solid #6c5ce7;
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 0 4px 4px 0;
        }
        
        .section-header {
            background-color: #f0f0f0;
            padding: 10px 15px;
            margin: 25px 0 15px 0;
            border-radius: 4px;
            font-size: 18px;
            font-weight: 600;
            color: #444;
            border-left: 4px solid #6c5ce7;
        }
        
        .message-details {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 4px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .message-details p {
            margin: 10px 0;
        }
        
        .message-content {
            background-color: #fff;
            border: 1px solid #e9ecef;
            border-radius: 4px;
            padding: 15px;
            margin-top: 10px;
        }
        
        .reply-box {
            background-color: #e8f4fd;
            border: 1px solid #bee5eb;
            border-radius: 4px;
            padding: 20px;
            margin: 25px 0;
        }
        
        /* Image styles */
        .image-container {
            text-align: center;
            margin: 20px 0;
        }
        
        .attached-image {
            max-width: 100%;
            max-height: 300px;
            border-radius: 6px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        /* Footer styles */
        .email-footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #e9ecef;
        }
        
        .disclaimer {
            padding: 10px;
            border: 1px dashed #ccc;
            margin-top: 15px;
            border-radius: 4px;
            background-color: #fff;
        }
        
        /* Responsive adjustments */
        @media screen and (max-width: 600px) {
            .container {
                width: 100%;
                margin: 0;
                border-radius: 0;
            }
            
            .email-body {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="email-header">
            <h1>We've Responded to Your Inquiry</h1>
        </div>
        
        <div class="email-body">
            <div class="intro">
                <p>Hello {{ $name }},</p>
                <p>Thank you for contacting us. An administrator has reviewed your message and provided a response below.</p>
            </div>
            
            <div class="section-header">
                Your Original Message
            </div>
            
            <div class="message-details">
                <p><strong>From:</strong> {{ $name }} ({{ $email }})</p>
                <p><strong>Subject:</strong> {{ $subject }}</p>
                <p><strong>Sent:</strong> {{ date('F j, Y, g:i a') }}</p>
                
                <p><strong>Message:</strong></p>
                <div class="message-content">
                    {{ $messageContent }}
                </div>
                
                @if($imageUrl)
                <div class="image-container">
                    <p><strong>Attached Image:</strong></p>
                    <img src="{{ $imageUrl }}" alt="Attached image" class="attached-image">
                </div>
                @endif
            </div>
            
            <div class="section-header">
                Our Response
            </div>
            
            <div class="reply-box">
                {{ $answer }}
            </div>
            
            <p>If you need any further assistance, please don't hesitate to contact us again through the application.</p>
        </div>
        
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} BossLoot | All Rights Reserved</p>
            
            <div class="disclaimer">
                <p>This is an automated message. Please do not reply directly to this email. If you have additional questions, please submit a new contact form through our application.</p>
            </div>
        </div>
    </div>
</body>
</html>