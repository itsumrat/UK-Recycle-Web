@extends('admin.layouts.app')
@section('title')
@endsection
@section('content')


<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card card-user">
            <div class="card-header">
                <h5 class="card-title">Supplier Report</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ url('report/supplier') }}">
                    @csrf
                    <div class="form-row">

                        <div class="col-2">
                            <label>Supplier</label>
                            <select class="productName form-control" name="supplier_id" id="supplier_id">
                                <option value="">Select One</option>
                                @foreach($suplliers as $key => $supllier)
                                    <option {{ $supplier_id == $supllier->id ? "SELECTED" : "" }} value="{{ $supllier->id }}">{{ $supllier->name }}</option>
                                @endforeach
                               
                            </select>
                        </div>

                        <div class="col-2">
                            <label class="form-label">From Date</label>
                            <input type="date" value="{{  isset($start_date) ? date('Y-m-d', strtotime($start_date))  : date('Y-m-01', strtotime(now())) }}" name="start_date" class="form-control">
                        </div>
                        <div class="col-2">
                            <label class="form-label">To Date</label>
                            <input type="date" value="{{  isset($end_date) ? date('Y-m-d', strtotime($end_date))  : date('Y-m-t', strtotime(now())) }}" name="end_date" class="form-control">
                        </div>

                        <div class="col-2">
                            <label>Status</label>
                            <select class="productName form-control" name="status">
                                <option value="">---</option>
                                <option {{ $status == "all" ? "SELECTED" : "" }} value="all">All</option>
                            </select>
                        </div>

                        <div class="col-2 mt-2">
                            <div class="row">
                                <div class="col"><input type="submit" name="submit" value="Submit" class="btn btn-primary btn-md btn-block" /></div>
                                {{-- <div class="col"><input type="submit" name="csv" value="CSV" class="btn btn-success btn-md btn-block" /></div> --}}
                            </div>
                        </div>


                    </div>
                   
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card ">
            <div class="card-body ">
                <table id="deliveryInTable" class="display">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            @foreach ($measurement_types as $measurement)
                                <th>{{ $measurement->name }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($deliveryIns as $k => $delivery)
                            <tr>
                                <td>{{ ++$k }}</td>
                                <td>{{ $delivery->category->name }}</td>
                                @foreach ($measurement_types as $measurement)
                                    <td>
                                        {{ \App\Http\Controllers\admin\ReportController::getSum($delivery->category_id, $measurement->id) }}
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>


@endsection

@section('scripts')
<script>

    $('#supplier_id').select2({
        placeholder: "Select a Supplier",
        allowClear: true
    });

</script>
@endsection