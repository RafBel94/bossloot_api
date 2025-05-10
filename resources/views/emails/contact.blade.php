<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nuevo mensaje de contacto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f4f4f4;
            padding: 10px 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .content {
            padding: 15px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            text-align: center;
            color: #777;
        }
        .image {
            max-width: 100%;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>New contact message</h2>
        </div>
        
        <div class="content">
            <p><strong>Name:</strong> {{ $name }}</p>
            <p><strong>Email:</strong> {{ $email }}</p>
            <p><strong>Subject:</strong> {{ $subject }}</p>
            <p><strong>Message:</strong></p>
            <p>{{ $messageContent }}</p>
            
            @if($imageUrl)
                <p><strong>Attached image:</strong></p>
                <img src="{{ $imageUrl }}" alt="Attached image" class="image">
            @endif
        </div>
        
        <div class="footer">
            <p>This message was sent through the application's contact form</p>
        </div>
    </div>
</body>
</html>