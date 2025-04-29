<!-- resources/views/training-programs/index.blade.php -->
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Список Тренувальних Програм</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
            max-width: 800px;
            margin: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 8px;
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
    <h1>Список Тренувальних Програм</h1>

    <a href="{{ route('training-programs.create') }}">
        <button>Додати Тренувальну Програму</button>
    </a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Назва Програми</th>
                <th>Опис</th>
                <th>Тривалість</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($trainingPrograms as $program)
                <tr>
                    <td>{{ $program->id }}</td>
                    <td>{{ $program->name }}</td>
                    <td>{{ $program->description }}</td>
                    <td>{{ $program->duration }} хв</td>
                    <td>
                        <a href="{{ route('training-programs.edit', $program->id) }}">Редагувати</a> | 
                        <form action="{{ route('training-programs.destroy', $program->id) }}" method="POST" style="display:inline;">
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
