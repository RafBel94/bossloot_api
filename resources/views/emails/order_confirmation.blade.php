<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Pedido</title>
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
        
        /* Order items table */
        .order-items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        .order-items th, 
        .order-items td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }
        
        .order-items th {
            background-color: #f1f3f5;
            font-weight: 600;
            color: #495057;
        }
        
        .order-items tr:last-child td {
            border-bottom: none;
        }
        
        .order-total {
            text-align: right;
            font-weight: 600;
            font-size: 16px;
            color: #6c5ce7;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid #e9ecef;
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
            
            .order-items th, 
            .order-items td {
                padding: 8px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="email-header">
            <h1>Confirmación de Pedido</h1>
            <div class="notification-badge">¡Tu pedido ha sido confirmado!</div>
        </div>
        
        <div class="email-body">
            <div class="intro">
                <p>Hola {{ $name }},</p>
                <p>{{ $messageContent }}</p>
                <p>Si el producto satisface tus expectativas, por favor, no olvides dejar una reseña en nuestro sitio web y no dudes en contactar con nosotros si tienes algun problema.</p>
            </div>
            
            <div class="message-container">
                <div class="message-field">
                    <span class="field-label">Cliente:</span>
                    {{ $name }} <span style="color: #666;">&lt;{{ $email }}&gt;</span>
                </div>
                
                <div class="message-field">
                    <span class="field-label">Número de Pedido:</span>
                    #{{ $items->first()->order_id }}
                </div>
                
                <div class="message-field">
                    <span class="field-label">Detalles del Pedido:</span>
                    <div class="message-content">
                        <table class="order-items">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($convertedPrices[$item->id]['unit_price'], 2) }} {{ $currency }}</td>
                                    <td>{{ number_format($convertedPrices[$item->id]['total_price'], 2) }} {{ $currency }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        <div class="order-total">
                            Total: {{ number_format($convertedTotal, 2) }} {{ $currency }}
                        </div>
                    </div>
                </div>
                
                @if($imageUrl)
                <div class="message-field">
                    <span class="field-label">Imagen Adjunta:</span>
                    <div class="image-container">
                        <img src="{{ $imageUrl }}" alt="Imagen adjunta" class="attached-image">
                    </div>
                </div>
                @endif
            </div>
            
            <div class="action-container">
                <a href="{{ url('/mi-cuenta/pedidos') }}" class="action-button">Ver mis pedidos</a>
            </div>
        </div>
        
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} BossLoot | Gracias por tu compra</p>
            <div class="timestamp">
                Enviado el: {{ date('d/m/Y, H:i') }}
            </div>
        </div>
    </div>
</body>
</html>