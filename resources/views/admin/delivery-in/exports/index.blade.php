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
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Supplier</th>
            <th>Measurement Type</th>
            <th>Pallet</th>
            <th>Case</th>
            <th>Piece</th>
            <th>Assigned To</th>
            <th>Added</th>
        </tr>
        @foreach ($deleveries as $k => $delevery)
            <tr>
                <th>
                    {{$delevery->delivery_in_id}}/{{$delevery->date->format('d-m-Y')}}/{{$delevery->supplier->name ?? ''}}
                </th>
                <th>{{$delevery->date }}</th>
                <th>{{ $delevery->supplier->name }}</th>
                <th>{{ $delevery->measurement->name ?? '' }}</th>
                <th>
                    @if($delevery->measurement->name == 'Pallet')
                        {{ $delevery->trx->sum('weight') ?? '' }}
                    @endif
                </th>
                <th>
                    @if($delevery->measurement->name == 'Cage')
                        {{ $delevery->trx->sum('weight') ?? '' }}
                    @endif
                </th>
                <th>
                    @if($delevery->measurement->name == 'Piece')
                        {{ $delevery->trx->sum('weight') ?? '' }}
                    @endif
                </th>
                <th>{{ $delevery->assignedTo->name ?? '' }}</th>
                <th>{{ $delevery->user->name ?? '' }}</th>
            </tr>
        @endforeach
    </table>
</body>
</html>