<!-- resources/views/appointments/index.blade.php -->
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Список записів</title>
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
    <h1>Список записів</h1>

    <a href="{{ route('appointments.create') }}">
        <button>Додати нову запис</button>
    </a>

    <table>
        <thead>
            <tr>
                <th>Клієнт</th>
                <th>Тренер</th>
                <th>Програма</th>
                <th>Дата запису</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->client->first_name }} {{ $appointment->client->last_name }}</td>
                    <td>{{ $appointment->trainer->first_name }} {{ $appointment->trainer->last_name }}</td>
                    <td>{{ $appointment->program->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d.m.Y H:i') }}</td>
                    <td>
                        <a href="{{ route('appointments.show', $appointment->id) }}">Переглянути</a> | 
                        <a href="{{ route('appointments.edit', $appointment->id) }}">Редагувати</a> | 
                        <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" style="display:inline;">
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
