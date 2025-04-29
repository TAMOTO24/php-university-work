<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <title>Додати призначення</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
            max-width: 600px;
            margin: auto;
            background-color: #f9f9f9;
        }

        h1 {
            text-align: center;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input,
        select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            margin-top: 25px;
            padding: 10px 20px;
            background-color: #28a745;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        .errors {
            color: red;
        }
    </style>
</head>

<body>
    <h1>Додати нове призначення</h1>

    @if ($errors->any())
        <div class="errors">
            <strong>Помилки:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('appointments.store') }}">
        @csrf

        <label for="client_id">Клієнт</label>
        <select name="client_id" id="client_id" required>
            <option value="">-- Оберіть клієнта --</option>
            @foreach ($clients as $client)
                <option value="{{ $client->id }}">{{ $client->first_name }} {{ $client->last_name }}</option>
            @endforeach
        </select>

        <label for="trainer_id">Тренер</label>
        <select name="trainer_id" id="trainer_id" required>
            <option value="">-- Оберіть тренера --</option>
            @foreach ($trainers as $trainer)
                <option value="{{ $trainer->id }}">{{ $trainer->first_name }} {{ $trainer->last_name }}</option>
            @endforeach
        </select>

        <label for="program_id">Програма тренувань</label>
        <select name="program_id" id="program_id" required>
            <option value="">-- Оберіть програму --</option>
            @foreach ($programs as $program)
                <option value="{{ $program->id }}">{{ $program->name }}</option>
            @endforeach
        </select>

        <label for="appointment_date">Дата призначення</label>
        <input type="datetime-local" name="appointment_date" id="appointment_date" required>

        <button type="submit">Зберегти призначення</button>
    </form>
</body>

</html>