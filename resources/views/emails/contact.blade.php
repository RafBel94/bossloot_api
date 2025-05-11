<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
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
        
        .notification-badge {
            background-color: #ff4757;
            color: white;
            font-size: 14px;
            padding: 5px 10px;
            border-radius: 30px;
            margin-top: 10px;
            display: inline-block;
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
        
        .message-container {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 4px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .message-field {
            margin-bottom: 15px;
            border-bottom: 1px dashed #e9ecef;
            padding-bottom: 10px;
        }
        
        .message-field:last-child {
            border-bottom: none;
            padding-bottom: 0;
            margin-bottom: 0;
        }
        
        .field-label {
            font-weight: 600;
            color: #6c5ce7;
            display: block;
            margin-bottom: 5px;
        }
        
        .message-content {
            background-color: #fff;
            border: 1px solid #e9ecef;
            border-radius: 4px;
            padding: 15px;
            margin-top: 5px;
        }
        
        /* Image styles */
        .image-container {
            text-align: center;
            margin: 20px 0;
            background-color: #fff;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #e9ecef;
        }
        
        .attached-image {
            max-width: 100%;
            max-height: 300px;
            border-radius: 6px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        /* Action button */
        .action-container {
            text-align: center;
            margin: 30px 0;
        }
        
        .action-button {
            background-color: #6c5ce7;
            color: white;
            padding: 12px 25px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
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
        
        .timestamp {
            color: #999;
            font-size: 11px;
            margin-top: 10px;
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
            <h1>New Contact Form Submission</h1>
            <div class="notification-badge">Requires Attention</div>
        </div>
        
        <div class="email-body">
            <div class="intro">
                <p>A new contact form message has been submitted through the application. Please review the details below.</p>
            </div>
            
            <div class="message-container">
                <div class="message-field">
                    <span class="field-label">From:</span>
                    {{ $name }} <span style="color: #666;">&lt;{{ $email }}&gt;</span>
                </div>
                
                <div class="message-field">
                    <span class="field-label">Subject:</span>
                    {{ $subject }}
                </div>
                
                <div class="message-field">
                    <span class="field-label">Message:</span>
                    <div class="message-content">
                        {{ $messageContent }}
                    </div>
                </div>
                
                @if($imageUrl)
                <div class="message-field">
                    <span class="field-label">Attached Image:</span>
                    <div class="image-container">
                        <img src="{{ $imageUrl }}" alt="Attached image" class="attached-image">
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} BossLoot | Admin Notification</p>
            <div class="timestamp">
                Received on: {{ date('F j, Y, g:i a') }}
            </div>
        </div>
    </div>
</body>
</html>