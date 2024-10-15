@extends('admin.layouts.app')
@section('title')
@endsection
@section('content')
<div class="row">
    <div class="col-lg-3 col-md-4 col-sm-12">
        <div class="card card-stats">
            <div class="card-body ">
                <h5>Production</h5>
                <form action="{{ route('productions.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <input type="date" name="production_date" class="form-control" name="productionDate">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ID</label>
                        <input type="text" name="production_id" readonly class="form-control" value="{{ $pr ?? "
                            PR-000001" }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Assigned to</label>
                        <select name="assigned_to" class="usersName form-control">
                            <option value="">Select</option>
                            @foreach($users as $key=>$value)
                            <option value="{{$value->id}}">{{$value->name}}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Table</label>
                        <select name="table" class="tableName form-control">
                            <option value="">Select</option>
                            @foreach($tables as $key=>$value)
                            <option value="{{$value->id}}">{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-9 col-md-8 col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title">Production List</h5>
                    </div>
                    <div class="col-4 text-right">
                        <div id="reportrange"
                            style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                            <i class="fa fa-calendar"></i>&nbsp;<span></span> <i class="fa fa-caret-down"></i>
                        </div>
                        <button id="exportBtn" class="btn btn-primary">Export to CSV</button>
                    </div>

                </div>
            </div>
            <div class="card-body ">
                <table id="productionTable" class="display">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Table</th>
                            <th>Staff</th>
                            <th>Sack</th>
                            <th>Weight</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $key=>$value)

                        <tr>
                            <td>
                                <a href="#" class="view-transactions" data-delivery-id="{{ $value->id }}">
                                    {{$value->production_id}}/{{ date('d-m-Y', strtotime($value->production_date)) }}/{{
                                    !empty($value->assignedTo) ? $value->assignedTo->name : '' }}/{{
                                    !empty($value->tables) ? $value->tables->name : '-' }}
                                </a>
                            </td>
                            <td>{{$value->production_date}}</td>
                            <td>{{ !empty($value->tables) ? $value->tables->name : '-' }}</td>
                            <td>{{ !empty($value->assignedTo) ? $value->assignedTo->name : ''}}</td>
                            <td>{{ $value->trx_count }}</td>
                            <td>{{ $value->trx->isNotEmpty() ? $value->trx->sum('weight') : $value->weight }}</td>
                            <!--<td>{{$value->grades->name ?? ''}}</td>-->

                            <td>
                                <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $value->id }}"
                                    data-original-title="Edit" class="edit pr-2  editCustomersData">
                                    <i class="nc-icon nc-tag-content"></i>
                                </a>
                                <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $value->id }}"
                                    class="deleteCustomersData"><i class="nc-icon nc-basket"></i></a>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card ">
            <div class="card-header ">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title" id="din-trx-title"></h5>
                    </div>
                    <div class="col-3 text-right">
                        <a class="download btn btn-primary" id="exportBtn">Export to CSV</a>
                        {{-- <a class="btn btn-success btn-round" href="{{ url('/deliveryCsv') }}">CSV</a> --}}
                    </div>
                </div>
            </div>
            <div class="card-body ">
                <table id="transactionInTable" class="display">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Weight</th>
                            <th>Grade</th>
                            <!-- <th>Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <!-- <tr>
                        <td>DI00215-day-month-year/Supplier/1</td>
                        <td>15-12-2023</td>
                        <td>Pallet</td>
                        <td>Case 1</td>
                        <td>210</td>
                        <td>Micheal<br><span class="badge badge-info">12345</span></td>
                        <td>
                          <a href="#" class="pr-2"><i class="nc-icon nc-tag-content"></i></a>
                          <a href="#"><i class="nc-icon nc-basket"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>DI0021615122023/Johirul/2</td>
                        <td>15-12-2023</td>
                        <td>Pallet</td>
                        <td>Case 1</td>
                        <td>210</td>
                        <td>Micheal<br><span class="badge badge-info">12345</span></td>
                        <td>
                          <a href="#" class="pr-2"><i class="nc-icon nc-tag-content"></i></a>
                          <a href="#"><i class="nc-icon nc-basket"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>DI0021615122023/Johirul/3</td>
                        <td>15-12-2023</td>
                        <td>Pallet</td>
                        <td>Case 1</td>
                        <td>210</td>
                        <td>Micheal<br><span class="badge badge-info">12345</span></td>
                        <td>
                          <a href="#" class="pr-2"><i class="nc-icon nc-tag-content"></i></a>
                          <a href="#"><i class="nc-icon nc-basket"></i></a>
                        </td>
                    </tr> -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Grades Modal -->
<div class="modal fade" id="customersModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="customersEditForm" name="customersEditForm" class="form-horizontal">
                    <div class="modal-body">
                        <input type="hidden" id="gid" name="id" value="">
                        <div class="row">
                            <label class="form-label">Date</label>
                            <input type="date" id="production_date" name="production_date" class="form-control"
                                name="productionDate">
                        </div>
                        <div class="row">
                            <label class="form-label">Assigned to</label>
                            <select name="assigned_to" id="assigned_to" class="usersName form-control">
                                @foreach($users as $key=>$value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="row">
                            <label class="form-label">Table</label>
                            <select name="table" id="table" class="tableName form-control">
                                <option selected>Select</option>
                                @foreach($tables as $key=>$value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="customersSaveBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script>
    $(document).ready(function() {
    $(document).on('click', '.view-transactions', function(e) {
      e.preventDefault();
      var deliveryId = $(this).data('delivery-id');
      var transactionsTable = $('#transactionInTable'); // Assuming you have a table with id="transactions-table"
      var dinTrxTitle = $('#din-trx-title');
      $.ajax({
        url: "{{ url('/productions') }}/" + deliveryId,
        type: 'GET',
        success: function(response) {
          console.log(response);
          // Clear existing table rows
          transactionsTable.find('tbody').empty();
          $('.download').attr('href', 'productions/' + deliveryId+'?download=csv')
    // Initialize i to 1
    let i = 1;
          // Populate the table with the new transactions
          $.each(response.transactions, function(index, transaction) {
      // Convert created_at to a Date object and extract the date part

      var createdAtDate = new Date(transaction.created_at);
      var formattedDate = createdAtDate.toISOString().split('T')[0];

            transactionsTable.find('tbody').append(`
                            <tr>
                                <td>${transaction.production.production_id}/${i}</td>
                                <td>${formattedDate}</td>
                                <td>${transaction.weight}</td>
                                <td>${transaction.grades?.name ?? ''}</td>
                            </tr>
                        `);
                        dinTrxTitle.text(`Transactions of ${transaction.production.production_id}`);

                        i++;

          });

        },
        error: function(error) {
          console.error(error);
        }
      });
    });
  });
     //Grades
  $(document).on('click', 'a.editCustomersData', function() {
    var id = $(this).data('id');
    let url = "{{ route('productions.edit', ':id') }}";
    $.ajax({
      type: 'GET',
      url: url.replace(':id', id),
      success: function(data) {
        console.log(data);
        $('#customersModal').modal('show');
        $('#gid').val(data.data.id);
        $('#production_date').val(data.data.production_date);
        $('#table').val(data.data.table);
        $('#assigned_to').val(data.data.assigned_to);
      }
    });
  });

  $('body').on('click', '#customersSaveBtn', function(event) {
    event.preventDefault()
    var id = $("#gid").val();
    var production_date = $("#production_date").val();
    var table = $("#table").val();
    var assigned_to = $("#assigned_to").val();
    let url = "{{ route('productions.update', ':id') }}";
    $.ajax({
      url: url.replace(':id', id),
      type: "POST",
      data: {
        'id': id,
        'production_date': production_date,
        'table': table,
        'assigned_to': assigned_to,
        '_token': '{{ csrf_token() }}',
      },
      dataType: 'json',
      success: function(data) {
        $('#customersEditForm').trigger("reset");
        $('#customersModal').modal('hide');
        return location.reload();
      }
    });
  });

$('body').on('click', '.deleteCustomersData', function() {
    let id = $(this).data('id');

    let confirmData = confirm("Are you confirm to delete this data!");

    if (confirmData == true) {
      $.ajax({
        method: "get",
        url: "{{ url('productions') }}/" + id + '/delete',
        success: function(res) {
          return location.reload();
        },
        error: function(xhr) {
          console.log("error");
        }
      });
    }
});


// Handle Export button click
$('#exportBtn').click(function() {
    var dateRange = $('#reportrange').find('span').text();
    var startDate = dateRange.split(' - ')[0];
    var endDate = dateRange.split(' - ')[1];
    
    if (startDate && endDate) {
        $.ajax({
            url: "{{ url('/productionCsv') }}", // Replace with the correct URL for your "attendant" route
            type: 'GET',
            data: {
                start_date: startDate,
                end_date: endDate
            },
            success: function(response) {
                // Create a hidden anchor element
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(new Blob([response]));
                link.setAttribute('download', 'product_csv.csv');

                // Trigger the download
                document.body.appendChild(link);
                link.click();

                // Cleanup
                document.body.removeChild(link);
            },
            error: function(xhr, status, error) {
                // Handle the error response here
                console.error(xhr.responseText);
            }
        });
    }
});

</script>
@endsection