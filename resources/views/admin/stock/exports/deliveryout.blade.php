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
                @foreach ( $measurements as $measurement )
                    <th>{{ $measurement->name }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($deliveries as $delivery)
                <tr>
                    <th>{{ !empty($delivery->category) ? $delivery->category->name : '-' }}</th>
                    @foreach ( $measurements as $measurement )
                        <td>
                            @if(  $measurement->id == $delivery->measurement )
                                {{ $delivery->totalProduct }}
                            @else
                                -
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>