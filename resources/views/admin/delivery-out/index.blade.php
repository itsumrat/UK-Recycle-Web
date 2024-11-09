@extends('admin.layouts.app')
@section('title')
@endsection
@section('content')
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12">
    <div class="card card-user">
      <div class="card-header">
        <h5 class="card-title">Add Delivery Out</h5>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('delivery-out.store') }}">

          @csrf
          <div class="form-row">
            <div class="col">
              <label>ID</label>
              <input type="text" class="form-control" value="{{ $latstId }}/day-month-year/Customer" readonly>
            </div>
            <div class="col">
              <label>Customer</label>
              <select class="customerName form-control" name="customer_id">
                <option>Select One</option>
                @foreach($customers as $key=>$value)
                <option value="{{$value->id}}">{{$value->name}}</option>
                @endforeach
              </select>
            </div>
            <div class="col">
              <label class="form-label">Assigned to</label>
              <select name="assigned_to" class="usersName form-control">
                <option>Select</option>
                @foreach($users as $key=>$value)
                <option value="{{$value->id}}">{{$value->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-row mt-3">
            {{-- <div class="col">
              <label>Product Category</label>
              <select class="productName form-control" name="category_id">
                <option>Select One</option>
                @foreach($categories as $key=>$value)
                <option value="{{$value->id}}">{{$value->name}}</option>
                @endforeach
              </select>
            </div> --}}
            <div class="col">
              <label>Delivery Type</label>
              <select class="form-control" name="delivery_type">
                <option>Select</option>
                @foreach($types as $key=>$value)
                <option value="{{$value->id}}">{{$value->name}}</option>
                @endforeach
              </select>
            </div>
            <div class="col">
              <label>Measurement</label>
              <select class="form-control" name="measurement_type">
                <option>Select</option>
                @foreach($measurement_types as $key=>$value)
                <option value="{{$value->id}}">{{$value->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="update ml-auto mr-auto">
            <button type="submit" class="btn btn-primary btn-round">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-lg-12 col-md-12 col-sm-12">
    <div class="card ">
      <div class="card-header ">
        <div class="row">
            <h5 class="card-title col">Delivery Out</h5>
            <div class="col-3 text-right">
                <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                    <i class="fa fa-calendar"></i>&nbsp;<span></span> <i class="fa fa-caret-down"></i>
                </div>
                <button id="exportBtn" class="btn btn-primary">Export to CSV</button>
                {{-- <a class="btn btn-success btn-round" href="{{ url('/deliveryOutCsv') }}">CSV</a> --}}
            </div>
        </div>
        
      </div>
        
      <div class="card-body ">
        <table id="deliveryOutTable" class="display">
          <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
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
            @foreach($data as $key => $value)

            <tr>

                <td>
                    <a href="#" class="view-transactions" data-delivery-id="{{ $value->id }}">
                        {{$value->delivery_out_id}}/{{ date('d-m-y', strtotime($value->date))}}/
                        {{ !empty($value->customer) ? $value->customer->name : '' }} /{{ optional($value->measurement)->name ?? '' }}
                    </a>
                </td>
              <td>{{$value->date}}</td>
              <td>{{ optional($value->customer)->name ?? '' }}</td>
              <td>{{ optional($value->measurement)->name ?? '' }}</td>
              @if($value->measurement->name == 'Pallet')
              <td>{{$value->trx->sum('product_weight') ?? '' }}</td>
              @else
              <td></td>
              @endif
              @if($value->measurement->name == 'Cage')
              <td>{{$value->trx->sum('product_weight') ?? '' }}</td>
              @else
              <td></td>
              @endif
              @if($value->measurement->name == 'Piece')
              <td>{{$value->trx->sum('product_weight') ?? '' }}</td>
              @else
              <td></td>
              @endif
              <td>{{ optional($value->assignedTo)->name ?? '' }}</td>
              <td>{{ optional($value->user)->name ?? '' }}</td>
              <td>
              <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $value->id }}" data-original-title="Edit" class="edit pr-2  editDoutData">
                  <i class="nc-icon nc-tag-content"></i>
                </a>
                <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $value->id }}" class="deleteDoutData"><i class="nc-icon nc-basket"></i></a>
              
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
      <div class="card-header">
        <div class="row">
            <div class="col">
                <h5 class="card-title" id="din-trx-title"></h5>
            </div>
            <div class="col-3 text-right">
                <a class="download btn btn-primary " id="exportBtn">Export to CSV</a>
                {{-- <a class="btn btn-success btn-round" href="{{ url('/deliveryCsv') }}">CSV</a> --}}
            </div>
        </div>

    </div>
      <div class="card-body ">
        <table id="transactionOutTable" class="display">
          <thead>
            <tr>
              <th>ID</th>
              <th>Date</th>
              <th>Category</th>
              <th>Measurement Type</th>
              <th>Case</th>
              <th>Quantity</th>
              <th>Added</th>
              {{-- <th>Action</th> --}}
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Case List Modal -->
<div class="modal fade" id="caseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="caseEditForm" name="caseEditForm" class="form-horizontal">
          <div class="modal-body">
            <input type="hidden" id="case_id" name="id" value="">
            <div class="row">
              <label>Customer</label>
              <select class="customerName form-control" id="customer_id" name="customer_id">
                <option>Select One</option>
                @foreach($customers as $key=>$value)
                <option value="{{$value->id}}">{{$value->name}}</option>
                @endforeach
              </select>
            </div>
            <div class="row pt-2">
              <label class="form-label">Assigned to</label>
              <select name="assigned_to" class="usersName form-control" id="assigned_to">
                @foreach($users as $key=>$value)
                <option value="{{$value->id}}">{{$value->name}}</option>
                @endforeach
              </select>
            </div>
            <div class="row pt-2">
              <label>Product Category</label>
              <select class="productName form-control" name="category_id" id="category_id">
                <option>Select One</option>
                @foreach($categories as $key=>$value)
                <option value="{{$value->id}}">{{$value->name}}</option>
                @endforeach
              </select>
            </div>
            <div class="row pt-2">
              <label>Delivery Type</label>
              <select class="form-control" name="delivery_type" id="delivery_type">
                <option>Select</option>
                @foreach($types as $key=>$value)
                <option value="{{$value->id}}">{{$value->name}}</option>
                @endforeach
              </select>
            </div>
            <div class="row pt-2">
              <label>Measurement</label>
              <select class="form-control" name="measurement_type" id="measurement_type">
                <option>Select</option>
                @foreach($measurement_types as $key=>$value)
                <option value="{{$value->id}}">{{$value->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="caseSaveBtn">Save changes</button>
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
      var transactionsTable = $('#transactionOutTable'); // Assuming you have a table with id="transactions-table"
      var dinTrxTitle = $('#din-trx-title');

      $.ajax({
        url: '{{ url("/delivery-out/") }}/' + deliveryId,
        type: 'GET',
        success: function(response) {
          console.log(response);
          // Clear existing table rows
          transactionsTable.find('tbody').empty();

          $('.download').attr('href', 'delivery-out/' + deliveryId+'?download=csv')
          let i = 1;

          // Populate the table with the new transactions
          $.each(response.transactions, function(index, transaction) {
            // var cage = transaction.cage.case_name ? transaction.cage.case_name : 'N/A';
            // var cage = transaction.cage.case_name !== undefined && transaction.cage.case_name !== null
            //       ? transaction.cage.case_name
            //       : 'N/A';
                  var createdAtDate = new Date(transaction.date);
      var formattedDate = createdAtDate.toISOString().split('T')[0];
          //   transactionsTable.find('tbody').append(`
          //                   <tr>
          //                       <td>${transaction.delivery.delivery_out_id}/${transaction.serial_number}</td>
          //                       <td>${formattedDate}</td>
          //                       <td>${transaction.category?.name }</td>
          //                       <td>${transaction.measurements.name}</td>
          //                       <td>${transaction.cage?.case_name ?? 'N/A'}</td>
          //                       <td>${transaction.product_weight}</td>
          //                       <td>${transaction.user.name}<br><span class="badge badge-info">${transaction.user.uid}</span></td>
          //                       <td>
          //                         <a href="#" class="pr-2"><i class="nc-icon nc-tag-content"></i></a>
          //                         <a href="#"><i class="nc-icon nc-basket"></i></a>
          //                       </td>
          //                   </tr>
          //               `);
          //               dinTrxTitle.text(`Transactions of ${transaction.delivery.delivery_out_id}`);
          //               i++;
          // });
          transactionsTable.find('tbody').append(`
                            <tr>
                                <td>${transaction.delivery.delivery_out_id}/${transaction.serial_number}</td>
                                <td>${formattedDate}</td>
                                <td>${transaction.category?.name }</td>
                                <td>${transaction.measurements.name}</td>
                                <td>${transaction.cage?.case_name ?? 'N/A'}</td>
                                <td>${transaction.product_weight}</td>
                                <td>${transaction.user.name}<br><span class="badge badge-info">${transaction.user.uid}</span></td>
                            </tr>
                        `);
                        dinTrxTitle.text(`Transactions of ${transaction.delivery.delivery_out_id}`);
                        i++;
          });
        },
        error: function(error) {
          console.error(error);
        }
      });
    });
  });

      //Case List
      $(document).on('click', 'a.editDoutData', function() {
    var id = $(this).data('id');
    let url = "{{ route('delivery-out.edit', ':id') }}";
    $.ajax({
      type: 'GET',
      url: url.replace(':id', id),
      success: function(data) {
        //console.log(data);
        $('#caseModal').modal('show');
        $('#case_id').val(data.data.id);
        $('#customer_id').val(data.data.customer_id);
        $('#assigned_to').val(data.data.assigned_to);
        $('#category_id').val(data.data.category_id);
        $('#delivery_type').val(data.data.delivery_type);
        $('#measurement_type').val(data.data.Measurement_type);
      }
    });
  });

  $('body').on('click', '#caseSaveBtn', function(event) {
    event.preventDefault()
    var id = $("#case_id").val();
    var customer_id = $("#customer_id").val();
    var category_id = $("#category_id").val();
    var assigned_to = $("#assigned_to").val();
    var delivery_type = $("#delivery_type").val();
    var measurement_type = $("#measurement_type").val();
    let url = "{{ route('delivery-out.update', ':id') }}";
    $.ajax({
      url: url.replace(':id', id),
      type: "POST",
      data: {
        'id': id,
        'customer_id': customer_id,
        'category_id': category_id,
        'assigned_to': assigned_to,
        'delivery_type': delivery_type,
        'measurement_type': measurement_type,
        '_token': '{{ csrf_token() }}',
      },
      dataType: 'json',
      success: function(data) {
        $('#caseEditForm').trigger("reset");
        $('#caseModal').modal('hide');
        return location.reload();
      }
    });
  });

  $('body').on('click', '.deleteDoutData', function() {
    let id = $(this).data('id');

    let confirmData = confirm("Are you confirm to delete this data!");

    if (confirmData == true) {
      $.ajax({
        method: "get",
        url: "{{ url('delivery-out') }}/" + id + '/delete',
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
            url: "deliveryOutCsv", // Replace with the correct URL for your "attendant" route
            type: 'GET',
            data: {
                start_date: startDate,
                end_date: endDate
            },
            success: function(response) {
                // Create a hidden anchor element
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(new Blob([response]));
                link.setAttribute('download', 'delivery_out_csv.csv');

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