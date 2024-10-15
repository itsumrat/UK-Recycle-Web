<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Stock Develiry Out</title>
</head>
<body>
    <table id="deliveryInTable" class="display">
        <thead>
            <tr>
                <th>Product Category</th>
                <th>Mewasurment</th>
                <th>Weight In</th>
                <th>Weight Out</th>
                <th>Stock</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($stocks as $stock)
                <tr>
                    <td>{{ $stock->categories->name }}</td>
                    <td>{{ $stock->measurements->name }}</td>
                    <td>{{ $stock->total_weight_in }}</td>
                    <td> {{ $stock->total_weight_out }}</td>
                    <td>{{ ($stock->total_weight_in - $stock->total_weight_out) }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>