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
                <th>Product Category</th>
                <th>Customer</th>
                <th>Measurement Type</th>
                <th>Pallet</th>
                <th>Case</th>
                <th>Piece</th>
                <th>Assigned To</th>
                <th>Added</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($deleveries as $key => $value)
                <tr>

                    <td>
                        <a href="#" class="view-transactions" data-delivery-id="{{ $value->id }}">
                            {{ $value->delivery_out_id }}/{{ date('d-m-y', strtotime($value->date)) }}/
                            {{ !empty($value->customer) ? $value->customer->name : '' }} / {{ optional($value->measurement)->name ?? '' }}
                        </a>
                    </td>
                    <td>{{ $value->date }}</td>
                    <td>{{ optional($value->categories)->name ?? '' }}</td>
                    <td>{{ optional($value->customer)->name ?? '' }}</td>
                    <td>{{ optional($value->measurement)->name ?? '' }}</td>
                    @if ($value->measurement->name == 'Pallet')
                        <td>{{ $value->trx->sum('weight') ?? '' }}</td>
                    @else
                        <td></td>
                    @endif
                    @if ($value->measurement->name == 'Cage')
                        <td>{{ $value->trx->sum('weight') ?? '' }}</td>
                    @else
                        <td></td>
                    @endif
                    @if ($value->measurement->name == 'Piece')
                        <td>{{ $value->trx->sum('weight') ?? '' }}</td>
                    @else
                        <td></td>
                    @endif
                    <td>{{ optional($value->assignedTo)->name ?? '' }}</td>
                    <td>{{ optional($value->user)->name ?? '' }}</td>
                    <td>
                        <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $value->id }}"
                            data-original-title="Edit" class="edit pr-2  editDoutData">
                            <i class="nc-icon nc-tag-content"></i>
                        </a>
                        <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $value->id }}"
                            class="deleteDoutData"><i class="nc-icon nc-basket"></i></a>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
