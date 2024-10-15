<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>

    <body>
        <table id="deliveryOutTable" class="display">
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
                @foreach($deleveries as $key => $value)
                    <tr>
                        <td>{{ $value->delivery->delivery_out_id }}/ {{ ++$key }}</td>
                        <td>{{ $value->date }}</td>
                        <td>{{ !empty($value->category) ? $value->category->name : '' }}</td>
                        <td>{{ !empty($value->measurements) ? $value->measurements->name : '' }}</td>
                        <td>{{ !empty($value->cage) ? $value->cage->case_name : '' }}</td>
                        <td>{{ $value->product_weight }}</td>
                        <td>{{ !empty($value->user) ? $value->user->name : '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>

</html>