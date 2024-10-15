@extends('admin.layouts.app')
@section('title')
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
        <div class="card ">
            <div class="card-header">
                <div class="row">
                    <div class="col">Delivery Out</div>
                    <div class="col-8 text-right">
                        <form method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="col-3">
                                    <label class="form-label">From Date</label>
                                    <input type="date" value="{{  isset($query['start_date']) ? date('Y-m-d', strtotime($query['start_date']))  : date('Y-m-01', strtotime(now())) }}" name="start_date" class="form-control">
                                </div>
                                <div class="col-3">
                                    <label class="form-label">To Date</label>
                                    <input type="date" value="{{  isset($query['end_date']) ? date('Y-m-d', strtotime($query['end_date']))  : date('Y-m-t', strtotime(now())) }}" name="end_date" class="form-control">
                                </div>


                                <div class="col mt-2">
                                    <div class="row">
                                        <div class="col"><input type="submit" name="submit" value="Submit" class="btn btn-primary btn-md btn-block" /></div>
                                        <div class="col"><input type="submit" name="csv" value="CSV" class="btn btn-success btn-md btn-block" /></div>
                                    </div>
                                </div>
                            </div>                           
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="deliveryInTable" class="display">
                    <thead>
                        <tr>
                            <th>Product Category</th>
                            <th>Measurement</th>
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
            </div>
        </div>
    </div>

</div>
@endsection