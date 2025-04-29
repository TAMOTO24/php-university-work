<!-- resources/views/trainers/index.blade.php -->
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Список тренерів</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
            max-width: 800px;
            margin: auto;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
        a {
            text-decoration: none;
            color: #007BFF;
        }
        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }
        form button {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
    <h1>Список тренерів</h1>

    <a href="{{ route('trainers.create') }}">
        <button>Додати нового тренера</button>
    </a>

    <table>
        <thead>
            <tr>
                <th>Ім'я</th>
                <th>Прізвище</th>
                <th>Спеціалізація</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($trainers as $trainer)
                <tr>
                    <td>{{ $trainer->first_name }}</td>
                    <td>{{ $trainer->last_name }}</td>
                    <td>{{ $trainer->specialization }}</td>
                    <td>
                        <a href="{{ route('trainers.show', $trainer->id) }}">Переглянути</a> | 
                        <a href="{{ route('trainers.edit', $trainer->id) }}">Редагувати</a> | 
                        <form action="{{ route('trainers.destroy', $trainer->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Видалити</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
