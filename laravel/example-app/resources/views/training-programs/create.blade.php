<!-- resources/views/training-programs/create.blade.php -->
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Додати програму тренувань</title>
</head>
<body>
    <h1>Додати нову програму тренувань</h1>
    <form action="{{ route('training-programs.store') }}" method="POST">
        @csrf
        <label for="name">Назва програми</label>
        <input type="text" name="name" id="name" required>
        
        <label for="description">Опис програми</label>
        <textarea name="description" id="description" required></textarea>
        
        <button type="submit">Додати програму</button>
    </form>
</body>
</html>
