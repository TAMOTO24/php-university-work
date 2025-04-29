<!-- resources/views/trainers/show.blade.php -->
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Деталі тренера</title>
</head>
<body>
    <h1>Деталі тренера</h1>
    <p><strong>Ім'я:</strong> {{ $trainer->first_name }}</p>
    <p><strong>Прізвище:</strong> {{ $trainer->last_name }}</p>
    <p><strong>Спеціалізація:</strong> {{ $trainer->specialization }}</p>

    <a href="{{ route('trainers.edit', $trainer->id) }}">Редагувати</a>
    <form action="{{ route('trainers.destroy', $trainer->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit">Видалити</button>
    </form>

    <a href="{{ route('trainers.index') }}">Назад до списку</a>
</body>
</html>
