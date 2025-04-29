<!-- resources/views/training-programs/edit.blade.php -->
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Редагувати програму тренувань</title>
</head>
<body>
    <h1>Редагувати програму тренувань</h1>
    <form action="{{ route('training-programs.update', $program->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="name">Назва програми</label>
        <input type="text" name="name" id="name" value="{{ $program->name }}" required>
        
        <label for="description">Опис програми</label>
        <textarea name="description" id="description" required>{{ $program->description }}</textarea>
        
        <button type="submit">Зберегти зміни</button>
    </form>

    <a href="{{ route('training-programs.index') }}">Назад до списку</a>
</body>
</html>
