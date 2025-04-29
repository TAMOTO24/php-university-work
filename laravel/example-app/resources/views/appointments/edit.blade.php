<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редагувати зустріч</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            max-width: 600px;
            margin: auto;
        }
        label {
            display: block;
            margin-top: 15px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }
        button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <h1>Редагувати зустріч</h1>

    @if ($errors->any())
        <div class="error">
            <strong>Помилки:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('appointments.update', $appointment->id) }}">
        @csrf
        @method('PUT')

        <label for="client_id">Клієнт</label>
        <select name="client_id" id="client_id" required>
            <option value="">Оберіть клієнта</option>
            @foreach ($clients as $client)
                <option value="{{ $client->id }}" {{ $client->id == $appointment->client_id ? 'selected' : '' }}>
                    {{ $client->first_name }} {{ $client->last_name }}
                </option>
            @endforeach
        </select>

        <label for="trainer_id">Тренер</label>
        <select name="trainer_id" id="trainer_id" required>
            <option value="">Оберіть тренера</option>
            @foreach ($trainers as $trainer)
                <option value="{{ $trainer->id }}" {{ $trainer->id == $appointment->trainer_id ? 'selected' : '' }}>
                    {{ $trainer->first_name }} {{ $trainer->last_name }}
                </option>
            @endforeach
        </select>

        <label for="program_id">Програма тренування</label>
        <select name="program_id" id="program_id" required>
            <option value="">Оберіть програму тренування</option>
            @foreach ($programs as $program)
                <option value="{{ $program->id }}" {{ $program->id == $appointment->program_id ? 'selected' : '' }}>
                    {{ $program->name }}
                </option>
            @endforeach
        </select>

        <label for="appointment_date">Дата зустрічі</label>
        
        <input type="datetime-local" name="appointment_date" id="appointment_date" value="{{ old('appointment_date', $appointment_date) }}" required>

        <button type="submit">Зберегти зміни</button>
    </form>

    <a href="{{ route('appointments.index') }}">Повернутись до списку</a>
</body>
</html>
