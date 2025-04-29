<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Інформація про запис</title>
    <style>
        body { font-family: sans-serif; padding: 20px; max-width: 600px; margin: auto; }
        .block { margin-top: 20px; }
    </style>
</head>
<body>
    <h1>Запис для клієнта {{ $appointment->client->first_name }} {{ $appointment->client->last_name }}</h1>

    <div class="block"><strong>Тренер:</strong> {{ $appointment->trainer->first_name }} {{ $appointment->trainer->last_name }}</div>
    <div class="block"><strong>Програма тренувань:</strong> {{ $appointment->program->name }}</div>
    <div class="block"><strong>Дата запису:</strong> {{ $appointment->appointment_date }}</div>

    <div class="block">
        <a href="{{ route('appointments.index') }}">← Назад до списку</a>
    </div>
</body>
</html>
