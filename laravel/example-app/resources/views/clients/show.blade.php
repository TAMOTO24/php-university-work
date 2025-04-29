<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Інформація про клієнта</title>
    <style>
        body { font-family: sans-serif; padding: 20px; max-width: 600px; margin: auto; }
        .block { margin-top: 20px; }
    </style>
</head>
<body>
    <h1>Клієнт: {{ $client->first_name }} {{ $client->last_name }}</h1>

    <div class="block"><strong>Дата народження:</strong> {{ $client->dob }}</div>
    <div class="block"><strong>Тип абонемента:</strong> {{ $client->membership_type }}</div>

    <div class="block">
        <a href="{{ route('clients.index') }}">← Назад до списку</a>
    </div>
</body>
</html>
