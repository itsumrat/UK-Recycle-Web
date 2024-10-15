<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Weight</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $k => $transaction)
                <tr>
                    <td>{{ $transaction->production->production_id }} / {{ ++$k  }}</td>
                    <td>{{ date('Y-m-d', strtotime($transaction->created_at)) }}</td>
                    <td>{{ $transaction->weight }}</td>
                    <td> {{ !empty($transaction->grades) ?  $transaction->grades->name : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>