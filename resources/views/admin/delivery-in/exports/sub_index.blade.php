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
                <th>Category</th>
                <th>Measurement Type</th>
                <th>Case</th>
                <th>Quantity</th>
                <th>Added</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($deleveries as $k => $delevery)
                <tr>
                    <td>{{ $delevery->delivery->delivery_in_id }}/{{ $delevery->serial_number }}</td>
                    <td>{{ $delevery->date }}</td>
                    <td>{{ !empty($delevery->category) ? $delevery->category->name : '-' }}</td>
                    <td>{{ !empty($delevery->measurements) ? $delevery->measurements->name : '-' }}</td>
                    <td>{{ !empty($delevery->cage) ?  $delevery->cage->case_name : '-' }}</td>
                    <td>{{ $delevery->product_weight }}</td>
                    <td>{{ !empty($delevery->user) ? $delevery->user->name : '-' }} <br><span class="badge badge-info">{{ !empty($delevery->user) ? $delevery->user->uid : '-' }}</span></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>