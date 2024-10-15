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
                    <th>Table</th>
                    <th>Staff</th>
                    <th>Sack</th>
                    @foreach ($grades as $grade)
                        <th>{{ $grade->grade_id }} ({{ $grade->name }})</th>
                    @endforeach
                    <th>Weight</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $key => $value)
                    <tr>
                        <td>{{$value->production_id}}/{{ date('d-m-Y', strtotime($value->production_date)) }}/{{ !empty($value->assignedTo) ? $value->assignedTo->name : '' }}/{{ !empty($value->tables) ? $value->tables->name : '-' }}</td>
                        <td>{{$value->production_date}}</td>
                        <td>{{ !empty($value->tables) ? $value->tables->name : '-' }}</td>
                        <td>{{ !empty($value->assignedTo) ? $value->assignedTo->name : ''}}</td>
                        <td>{{ $value->trx_count }}</td>
                        @foreach ($grades as $grade)
                            <td>
                                @php $totalProduct = App\Http\Controllers\ProductionController::getGradeWaysSum($value->id, $grade->id) @endphp
                                {{ $totalProduct }}
                                
                            </td>
                        @endforeach
                        <td>{{ $value->trx->isNotEmpty() ? $value->trx->sum('weight') : $value->weight }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>

</html>