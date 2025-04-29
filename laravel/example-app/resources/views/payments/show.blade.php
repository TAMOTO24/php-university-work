<!-- resources/views/payments/show.blade.php -->
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Деталі Платежу</title>
    <style>
        body { font-family: sans-serif; padding: 20px; max-width: 600px; margin: auto; }
        h1 { font-size: 24px; }
        p { margin: 10px 0; }
        a { text-decoration: none; color: #007BFF; }
    </style>
</head>
<body>
    <h1>Деталі Платежу #{{ $payment->id }}</h1>

    <p><strong>Клієнт:</strong> {{ $payment->client->first_name }} {{ $payment->client->last_name }}</p>
    <p><strong>Сума:</strong> {{ $payment->amount }} грн</p>
    <p><strong>Дата Платежу:</strong> {{ \Carbon\Carbon::parse($payment->payment_date)->format('d.m.Y') }}</p>

    <a href="{{ route('payments.index') }}">Повернутись до списку</a>
</body>
</html>
