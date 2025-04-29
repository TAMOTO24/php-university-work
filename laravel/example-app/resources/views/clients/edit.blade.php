<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Редагувати клієнта</title>
    <style>
        body { font-family: sans-serif; padding: 20px; max-width: 600px; margin: auto; }
        label { display: block; margin-top: 15px; }
        input, select { width: 100%; padding: 8px; margin-top: 5px; }
        button { margin-top: 20px; padding: 10px 20px; }
    </style>
</head>
<body>
    <h1>Редагувати клієнта: {{ $client->first_name }} {{ $client->last_name }}</h1>

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

    <form method="POST" action="{{ route('clients.update', $client->id) }}">
        @csrf
        @method('PUT')

        <label for="first_name">Ім’я</label>
        <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $client->first_name) }}" required>

        <label for="last_name">Прізвище</label>
        <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $client->last_name) }}" required>

        <label for="dob">Дата народження</label>
        <input type="date" id="dob" name="dob" value="{{ old('dob', $client->dob) }}" required>

        <label for="membership_type">Тип абонемента</label>
        <input type="text" id="membership_type" name="membership_type" value="{{ old('membership_type', $client->membership_type) }}" required>

        <button type="submit">Зберегти зміни</button>
    </form>

    <div>
        <a href="{{ route('clients.index') }}">← Назад до списку</a>
    </div>
</body>
</html>