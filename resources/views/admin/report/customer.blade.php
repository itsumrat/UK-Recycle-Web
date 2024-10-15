@extends('admin.layouts.app')
@section('title')
@endsection
@section('content')


<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card card-user">
            <div class="card-header">
                <h5 class="card-title">Customer Report</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    @csrf
                    <div class="form-row">

                        <div class="col-2">
                            <label>Customer</label>
                            <select class="productName form-control" name="customer_id" id="customer_id">
                                <option value="">Select One</option>
                                @foreach($customers as $key => $customer)
                                    <option {{ $customer_id == $customer->id ? "SELECTED" : "" }} value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                                
                            </select>
                        </div>

                        <div class="col-2">
                            <label class="form-label">From Date</label>
                            <input type="date" value="{{  isset($query['start_date']) ? date('Y-m-d', strtotime($query['start_date']))  : date('Y-m-01', strtotime(now())) }}" name="start_date" class="form-control">
                        </div>
                        <div class="col-2">
                            <label class="form-label">To Date</label>
                            <input type="date" value="{{  isset($query['end_date']) ? date('Y-m-d', strtotime($query['end_date']))  : date('Y-m-t', strtotime(now())) }}" name="end_date" class="form-control">
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
                        @foreach ($deliveryOuts as $k => $delivery)
                            <tr>
                                <td>{{ ++$k }}</td>
                                <td>{{ $delivery->category->name }}</td>
                                @foreach ($measurement_types as $measurement)
                                    <td>
                                        {{ \App\Http\Controllers\admin\ReportController::getOutSum($delivery->category_id, $measurement->id) }}
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

        $('#customer_id').select2({
            placeholder: "Select a Customer",
            allowClear: true
        });

    </script>
@endsection