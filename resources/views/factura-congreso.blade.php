<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Formato de Pago #{{ $datos['id'] }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1e293b;
            --accent: #2563eb;
            --bg-light: #ffffff;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            color: #1a1a1a;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }

        .invoice-container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 30px;
            border: 1px solid #e2e8f0;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 20px;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-section img {
            height: 50px;
        }

        .company-details {
            text-align: right;
            font-size: 0.9em;
        }

        .document-title {
            text-align: center;
            font-size: 1.5em;
            font-weight: bold;
            margin: 20px 0;
            color: var(--primary);
        }

        .document-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 0.9em;
        }

        .qr-section {
            text-align: right;
            margin-left: 20px;
        }

        .qr-code {
            width: 100px;
            height: 100px;
            background-color: #f8fafc;
            padding: 10px;
            border: 1px solid #e2e8f0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table th {
            background-color: #f8fafc;
            color: var(--primary);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8em;
        }

        table th,
        table td {
            padding: 10px;
            border: 1px solid #e2e8f0;
            text-align: left;
        }

        .total-section {
            text-align: right;
            margin-top: 20px;
            padding: 15px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            font-size: 0.8em;
            color: #64748b;
            text-align: center;
        }

        .security-note {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            font-size: 0.8em;
            color: #64748b;
        }

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 6em;
            color: rgba(0, 0, 0, 0.03);
            pointer-events: none;
            z-index: -1;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <div class="watermark">UNISEC MÉXICO</div>

        <div class="header-section" style="display: flex; justify-content: space-between; align-items: center;">
            <div class="logo-section" style="display: flex; align-items: center; gap: 15px;">
                <img src="{{ public_path('images/logo.png') }}" alt="UNISEC-MX Logo" style="height: 50px;">
            </div>

            <div class="company-details" style="text-align: right;">
                <h2 style="margin: 0;">UNISEC-MX</h2>
                <p style="margin: 0;">CIRCUITO UNIVERSITARIO No. 1, RESIDENCIAL UNIVERSIDAD,<br>31125 CHIHUAHUA, CHIH,
                    MÉXICO</p>
            </div>
        </div>


        <div class="document-title">FORMATO DE PAGO</div>

        <div class="document-info">
            <div>
                <p><strong>N.° del formato de pago:</strong> #{{ str_pad($datos['id'], 4, '0', STR_PAD_LEFT) }}</p>
                <p><strong>Fecha del formato de pago:</strong>
                    {{ \Carbon\Carbon::parse($datos['fecha_pago'])->format('d M Y') }}</p>
            </div>
        </div>

        <!-- Información del Participante -->
        <div style="margin: 20px 0; padding: 15px; background-color: #f8fafc; border: 1px solid #e2e8f0;">
            <h3 style="margin: 0 0 10px 0; color: var(--primary); font-size: 1.1em;">INFORMACIÓN DEL PARTICIPANTE</h3>
            <div style="display: flex; justify-content: space-between; flex-wrap: wrap; gap: 20px;">
                <div style="flex: 1; min-width: 250px;">
                    <p style="margin: 5px 0;"><strong>Nombre completo:</strong> {{ $datos['usuario'] }}</p>
                    <p style="margin: 5px 0;"><strong>Correo electrónico:</strong> {{ $datos['email'] }}</p>
                    <p style="margin: 5px 0;"><strong>Tipo de participante:</strong> {{ $datos['tipo_participante'] ?? 'No especificado' }}</p>
                </div>
                <div style="flex: 1; min-width: 250px;">
                    <p style="margin: 5px 0;"><strong>Institución:</strong> {{ $datos['institucion'] ?? 'No especificada' }}</p>
                    @if(isset($datos['fecha_inscripcion']))
                    <p style="margin: 5px 0;"><strong>Fecha de inscripcion</strong> 
                        {{ \Carbon\Carbon::parse($datos['fecha_inscripcion'])->format('d/m/Y H:i:s') }}</p>
                    @endif
                </div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>N.°</th>
                    <th>DESCRIPCIÓN</th>
                    <th>PRECIO</th>
                    <th>IMPORTE($)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>{{ $datos['congreso'] }}</td>
                    <td>${{ number_format($datos['monto'], 2) }}</td>
                    <td>${{ number_format($datos['monto'], 2) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="total-section">
            <p style="margin: 5px 0;"><strong>Subtotal:</strong> ${{ number_format($datos['monto'], 2) }}</p>
            <p style="margin: 5px 0;"><strong>TOTAL:</strong> ${{ number_format($datos['monto'], 2) }} MXN</p>
        </div>

        <div class="security-note">
            <p style="margin: 0;"><strong>Información de Seguridad:</strong></p>
            <p style="margin: 5px 0;">ID de Transacción: {{ $datos['paypal_order_id'] }}</p>
            <p style="margin: 5px 0;">Método de Pago: {{ ucfirst($datos['metodo_pago']) }}</p>
            <p style="margin: 5px 0;">Estado: {{ ucfirst($datos['estado_pago']) }}</p>
            <p style="margin: 5px 0;">Fecha y Hora:
                {{ \Carbon\Carbon::parse($datos['create_time'])->format('d/m/Y H:i:s') }}</p>
        </div>

        <div class="footer">
            <p>Este documento es una representación impresa de un comprobante digital.</p>
            <p style="margin-top: 20px;">UNISEC México - Todos los derechos reservados © {{ date('Y') }}</p>
        </div>
    </div>
</body>

</html>