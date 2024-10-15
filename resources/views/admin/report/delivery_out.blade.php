@extends('admin.layouts.app')
@section('title')
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card card-user">
            <div class="card-header">
                <h5 class="card-title">Delivery Report</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="">

                    @csrf
                    <div class="form-row">
                        <div class="col-2">
                            <label class="form-label">From Date</label>
                            <input type="date" value="{{  isset($query['start_date']) ? date('Y-m-d', strtotime($query['start_date']))  : date('Y-m-01', strtotime(now())) }}" name="start_date" class="form-control">
                        </div>
                        <div class="col-2">
                            <label class="form-label">To Date</label>
                            <input type="date" value="{{  isset($query['end_date']) ? date('Y-m-d', strtotime($query['end_date']))  : date('Y-m-t', strtotime(now())) }}" name="end_date" class="form-control">
                        </div>
                        {{-- <div class="col">
                            <label>Customer</label>
                            <select class="customerName form-control" name="customer_id">
                                <option value="">Select One</option>
                                @foreach($customers as $key => $value)
                                <option {{ isset($query['customer_id']) && $query['customer_id'] == $value->id ? 'selected' : '' }} value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label class="form-label">Assigned to</label>
                            <select name="assigned_to" class="usersName form-control">
                                <option value="">Select</option>
                                @foreach($users as $key => $value)
                                <option {{ isset($query['assigned_to']) && $query['assigned_to'] == $value->id ? 'selected' : '' }} value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        
                    {{-- </div>
                    <div class="form-row mt-3"> --}}
                        <div class="col-2">
                            <label>Product Category</label>
                            <select class="productName form-control" name="category_id">
                                <option value="">Select One</option>
                                @foreach($categories as $key => $value)
                                <option {{ isset($query['category_id']) && $query['category_id'] == $value->id ? 'selected' : '' }} value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                            <label>Delivery Type</label>
                            <select class="form-control" name="delivery_type">
                                <option value="">Select</option>
                                @foreach($types as $key => $value)
                                <option {{ isset($query['delivery_type']) && $query['delivery_type'] == $value->id ? 'selected' : '' }} value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="col">
                            <label>Measurement</label>
                            <select class="form-control" name="measurement_type">
                                <option value="">Select</option>
                                @foreach($measurement_types as $key => $value)
                                <option {{ isset($query['measurement_type']) && $query['measurement_type'] == $value->id ? 'selected' : '' }} value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div> --}}
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
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card ">

            <div class="card-body ">
                <table id="deliveryOutTable" class="display">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Product Category</th>
                            <th>Customer</th>
                            <th>Measurement Type</th>
                                @foreach ($measurement_types as $measurement)
                                    <th>{{  $measurement->name }}</th>
                                @endforeach
                            <th>Assigned To</th>
                            <th>Added</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $key => $value)

                        <tr>

                            <td>
                                
                                    {{$value->delivery->delivery_out_id}}/{{ date('d-m-y', strtotime($value->date))}}/
                                    {{ !empty($value->delivery->customer) ? $value->delivery->customer->name : '' }}
                                
                            </td>
                            <td>{{$value->date}}</td>
                            <td>{{ $value->category->name }}</td>
                            <td>{{ optional($value->delivery->customer)->name ?? '' }}</td>
                            <td>{{ optional($value->measurements)->name ?? '' }}</td>
                                @foreach ($measurement_types as $measurement)
                                    @if($measurement->id == $value->measurement)
                                        <td>{{ $value->product_weight }}</td>
                                    @else
                                        <td>-</td>
                                    @endif
                                    
                                @endforeach
                        
                            <td>{{ $value->delivery->assignedTo->name }}</td>
                            <td>{{ $value->user->name }}</td>
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

@endsection