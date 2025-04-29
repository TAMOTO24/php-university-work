<!-- resources/views/payments/index.blade.php -->
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Список Платежів</title>
    <style>
        body { font-family: sans-serif; padding: 20px; max-width: 800px; margin: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 8px; text-align: left; border: 1px solid #ddd; }
        th { background-color: #f4f4f4; }
        a { text-decoration: none; color: #007BFF; }
        button { background-color: #28a745; color: white; border: none; padding: 10px 20px; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Список Платежів</h1>

    <a href="{{ route('payments.create') }}">
        <button>Додати Платіж</button>
    </a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Клієнт</th>
                <th>Сума</th>
                <th>Дата Платежу</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>{{ $payment->client->first_name }} {{ $payment->client->last_name }}</td>
                    <td>{{ $payment->amount }}</td>
                    <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d.m.Y') }}</td>
                    <td>
                        <a href="{{ route('payments.edit', $payment->id) }}">Редагувати</a> | 
                        <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background-color: #dc3545; color: white;">Видалити</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
