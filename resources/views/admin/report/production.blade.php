@extends('admin.layouts.app')
@section('title')
@endsection
@section('content')


<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card card-user">
            <div class="card-header">
                <h5 class="card-title">Production Report</h5>
            </div>
            <div class="p-4">
                <form action="" method="post">
                <div class="col-12">
                <div class="row">
                    @csrf

                    <div class="col px-1">
                        <label class="form-label">From Date</label>
                        <input type="date" name="start_date" class="form-control" value="{{  isset($query['start_date']) ? date('Y-m-d', strtotime($query['start_date']))  : date('Y-m-01', strtotime(now())) }}" >
                    </div>

                    <div class="col px-1">
                        <label class="form-label">To Date</label>
                        <input type="date" name="end_date" class="form-control" value="{{  isset($query['end_date']) ? date('Y-m-d', strtotime($query['end_date']))  : date('Y-m-t', strtotime(now())) }}">
                    </div>
                    
                    
                    {{-- <div class="col px-1">
                        <label class="form-label">Assigned to</label>
                        <select name="assigned_to" class="usersName form-control">
                            <option value="">Select</option>
                            @foreach($users as $key => $value)
                            <option {{ isset($query['assigned_to']) && $query['assigned_to'] == $value->id ? 'selected' : '' }} value="{{$value->id}}">{{$value->name}}</option>
                            @endforeach

                        </select>
                    </div> --}}
                    <div class="col px-1">
                        <label class="form-label">Table</label>
                        <select name="table" class="tableName form-control">
                            <option value="">Select</option>
                            @foreach($tables as $key => $value)
                            <option {{ isset($query['table']) && $query['table'] == $value->id ? 'selected' : '' }} value="{{$value->id}}">{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    

                     <div class="col mt-3">
                        <div class="row">
                            <div class="col-6 px-1"><input type="submit" name="submit" value="Submit" class="btn btn-sm btn-primary btn-md btn-block p-2" /></div>
                            <div class="col-6 px-1"><input type="submit" name="csv" value="CSV" class="btn btn-sm btn-success btn-md btn-block p-2" /></div>
                        </div>
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
                <table id="productionTable" class="display">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Table</th>
                            <th>Staff</th>
                            <th>Weight</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $key=>$value)

                        <tr>
                            <td>
                               
                                {{$value->production_id}}/{{ date('d-m-Y', strtotime($value->production_date)) }}/
                                {{ !empty($value->assignedTo) ? $value->assignedTo->name : '' }}/
                                {{ !empty($value->tables) ? $value->tables->name : '-' }}
                                
                            </td>
                            <td>{{$value->production_date}}</td>
                            <td>{{ !empty($value->tables) ? $value->tables->name : '-' }}</td>
                            <td>{{ !empty($value->assignedTo) ? $value->assignedTo->name : ''}}</td>
                            <td>{{ $value->trx->isNotEmpty() ? $value->trx->sum('weight') : $value->weight }}</td>
                            <!--<td>{{$value->grades->name ?? ''}}</td>-->

                           
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


</script>
@endsection