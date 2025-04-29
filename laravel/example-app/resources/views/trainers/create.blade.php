<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; padding: 20px; max-width: 600px; margin: auto; }
        label { display: block; margin-top: 15px; }
        input, select { width: 100%; padding: 8px; margin-top: 5px; }
        button { margin-top: 20px; padding: 10px 20px; }
    </style>
</head>
<body>
    <h1>Додати нового тренера</h1>

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

    <form method="POST" action="{{ route('trainers.store') }}">
        @csrf

        <label for="first_name">Імʼя</label>
        <input type="text" name="first_name" id="first_name" required>

        <label for="last_name">Прізвище</label>
        <input type="text" name="last_name" id="last_name" required>

        <label for="specialization">Спеціалізація</label>
        <input type="text" name="specialization" id="specialization" required>

        <button type="submit">Зберегти</button>
    </form>
</body>
</html>
