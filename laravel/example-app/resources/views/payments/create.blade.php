<!-- resources/views/payments/create.blade.php -->
<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <title>Додати Платіж</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
            max-width: 600px;
            margin: auto;
        }

        label {
            display: block;
            margin-top: 15px;
        }

        input,
        select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }

        button {
            margin-top: 20px;
            padding: 10px 20px;
        }
    </style>
</head>

<body>
    <h1>Додати Платіж</h1>

    @if ($errors->any())
        <div style="color: red;">
            <strong>Помилки:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('payments.store') }}">
        @csrf

        <label for="client_id">Клієнт</label>
        <select name="client_id" id="client_id" required>
            <option value="">Виберіть клієнта</option>
            @foreach ($clients as $client)
                <option value="{{ $client->id }}">{{ $client->first_name }} {{ $client->last_name }}</option>
            @endforeach
        </select>

        <label for="amount">Сума</label>
        <input type="number" name="amount" id="amount" required step="0.01">

        <label for="payment_date">Час Платежу</label>
        <input type="time" name="payment_date" id="payment_date" required>

        <button type="submit">Зберегти</button>
    </form>
</body>

</html>