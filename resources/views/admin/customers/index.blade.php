@extends('admin.layouts.app')
@section('title')
@endsection
@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card card-user">
            <div class="card-header">
                <h5 class="card-title">Add Customer</h5>
            </div>
            <div class="card-body">
            <form method="POST" action="{{ route('customers.store') }}">

@csrf
                    <div class="form-group">
                        <label>ID</label>
                        <input type="text" class="form-control" value="{{$cus}}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Customer name">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <textarea class="form-control" name="address" placeholder="Address"></textarea>
                    </div>
                    <div class="update ml-auto mr-auto">
                        <button type="submit" class="btn btn-primary btn-round">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-12">
        <div class="card">
            <div class="card-header ">
                <h5 class="card-title">Customer List</h5>
            </div>
            <div class="card-body ">
                <table id="customerTable" class="display">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $key=>$value)
                        <tr>
                            <td>{{$value->name}} <br><span class="badge badge-info">{{$value->customer_id}}</span></td>
                            <td>{{$value->email}}</td>
                            <td>{{$value->address}}</td>
                            <td>{{ \Carbon\Carbon::parse($value->created_at)->format('Y-m-d') }}</td>
                            <td>
                            <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $value->id }}" data-original-title="Edit" class="edit pr-2  editCustomersData">
                  <i class="nc-icon nc-tag-content"></i>
                </a>
                <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $value->id }}" class="deleteCustomersData"><i class="nc-icon nc-basket"></i></a>
              
                            </td>
                        </tr>
                        @endforeach
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
              <label class="form-label">Customer Name</label>
              <input type="text" name="name" id="customer_name" class="form-control" placeholder="">
            </div>
            <div class="row">
              <label class="form-label">Email</label>
              <input type="text" name="email" id="email" class="form-control" placeholder="">
            </div>
            <div class="row">
            <label>Address</label>
                        <textarea class="form-control" id="address" name="address" placeholder="Address"></textarea>
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
     //Grades
  $(document).on('click', 'a.editCustomersData', function() {
    var id = $(this).data('id');
    let url = "{{ route('customers.edit', ':id') }}";
    $.ajax({
      type: 'GET',
      url: url.replace(':id', id),
      success: function(data) {
        console.log(data);
        $('#customersModal').modal('show');
        $('#gid').val(data.data.id);
        $('#customer_name').val(data.data.name);
        $('#email').val(data.data.email);
        $('#address').val(data.data.address);
      }
    });
  });

  $('body').on('click', '#customersSaveBtn', function(event) {
    event.preventDefault()
    var id = $("#gid").val();
    var name = $("#customer_name").val();
    var email = $("#email").val();
    var address = $("#address").val();
    let url = "{{ route('customers.update', ':id') }}";
    $.ajax({
      url: url.replace(':id', id),
      type: "POST",
      data: {
        'id': id,
        'name': name,
        'address': address,
        'email': email,
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
        url: "{{ url('customers') }}/" + id + '/delete',
        success: function(res) {
          return location.reload();
        },
        error: function(xhr) {
          console.log("error");
        }
      });
    }

  });
</script>
@endsection