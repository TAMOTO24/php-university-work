<!-- resources/views/trainers/edit.blade.php -->
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Редагувати тренера</title>
</head>
<body>
    <h1>Редагувати тренера</h1>
    <form action="{{ route('trainers.update', $trainer->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="first_name">Імʼя</label>
        <input type="text" name="first_name" id="first_name" value="{{ $trainer->first_name }}" required>
        
        <label for="last_name">Прізвище</label>
        <input type="text" name="last_name" id="last_name" value="{{ $trainer->last_name }}" required>
        
        <label for="specialization">Спеціалізація</label>
        <input type="text" name="specialization" id="specialization" value="{{ $trainer->specialization }}" required>
        
        <button type="submit">Зберегти зміни</button>
    </form>
</body>
</html>
