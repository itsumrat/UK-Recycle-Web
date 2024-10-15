@extends('admin.layouts.app')
@section('title')
@endsection
@section('content')
<div class="row">
  <div class="col-lg-3 col-md-3 col-sm-12">
    <div class="card card-user">
      <div class="card-header">
        <h5 class="card-title">Add Case</h5>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('cases.store') }}">

          @csrf
          <div class="form-group">
            <label>Case</label>
            <input type="text" name="case_name" class="form-control" placeholder="Case">
          </div>
          <div class="form-group">
            <label>Weight (KG)</label>
            <input type="text" name="weight" class="form-control" placeholder="Weight">
          </div>
          <div class="update ml-auto mr-auto">
            <button type="submit" class="btn btn-primary btn-round">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-lg-9 col-md-9 col-sm-12">
    <div class="card ">
      <div class="card-header ">
        <h5 class="card-title">Case List</h5>
      </div>
      <div class="card-body ">
        <table id="caseTable" class="display">
          <thead>
            <tr>
              <th>ID/Name</th>
              <th>Weight (KG)</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($cases as $key=>$value)
            <tr>
              <td>{{$value->case_name}}</td>
              <td>{{$value->weight}}</td>
              <td>
                <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $value->id }}" data-original-title="Edit" class="edit  editCaseData">
                  <i class="nc-icon nc-tag-content"></i>
                </a>
                @if($value->status != 2)
                    <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $value->id }}" class="deleteData"><i class="nc-icon nc-basket"></i></a>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-3 col-md-3 col-sm-12">
    <div class="card card-user">
      <div class="card-header">
        <h5 class="card-title">Add Table</h5>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('tables.store') }}">
          @csrf
          <div class="form-group">
            <label>ID</label>
            <input type="text" name="table_id" class="form-control" placeholder="Table ID">
          </div>
          <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" placeholder="Table name">
          </div>
          <div class="update ml-auto mr-auto">
            <button type="submit" class="btn btn-primary btn-round">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-lg-9 col-md-9 col-sm-12">
    <div class="card ">
      <div class="card-header ">
        <h5 class="card-title">Table List</h5>
      </div>
      <div class="card-body ">
        <table id="tableList" class="display">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($tables as $key=>$value)

            <tr>
              <td>{{$value->table_id}}</td>
              <td>{{$value->name}}</td>
              <td>
                <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $value->id }}" data-original-title="Edit" class="edit  editTablesData">
                  <i class="nc-icon nc-tag-content"></i>
                </a>
                <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $value->id }}" class="deleteTablesData"><i class="nc-icon nc-basket"></i></a>

              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-3 col-md-3 col-sm-12">
    <div class="card card-user">
      <div class="card-header">
        <h5 class="card-title">Add Grade</h5>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('grades.store') }}">
          @csrf
          <div class="form-group">
            <label>ID</label>
            <input type="text" name="grade_id" class="form-control" placeholder="Grade ID">
          </div>
          <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" placeholder="Grade name">
          </div>
          <div class="form-group">
            <label>Weight</label>
            <input type="text" name="weight" class="form-control" placeholder="Grade weight">
          </div>
          <div class="ml-auto mr-auto">
            <button type="submit" class="btn btn-primary btn-round">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-lg-9 col-md-9 col-sm-12">
    <div class="card ">
      <div class="card-header ">
        <h5 class="card-title">Grade List</h5>
      </div>
      <div class="card-body ">
        <table id="gradeList" class="display">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Weight</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($grades as $key=>$value)

            <tr>
              <td>{{$value->grade_id}}</td>
              <td>{{$value->name}}</td>
              <td>{{$value->weight}}</td>
              <td>
                <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $value->id }}" data-original-title="Edit" class="edit  editGradesData">
                  <i class="nc-icon nc-tag-content"></i>
                </a>
                <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $value->id }}" class="deleteGradesData"><i class="nc-icon nc-basket"></i></a>

              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-3 col-md-3 col-sm-12">
    <div class="card card-user">
      <div class="card-header">
        <h5 class="card-title">Add Product Category</h5>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('product-categories.store') }}">
          @csrf
          <div class="form-group">
            <label>ID</label>
            <input type="text" name="category_id" class="form-control" placeholder="Category ID">
          </div>
          <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" placeholder="Category name">
          </div>
          <div class="update ml-auto mr-auto">
            <button type="submit" class="btn btn-primary btn-round">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-lg-9 col-md-9 col-sm-12">
    <div class="card ">
      <div class="card-header ">
        <h5 class="card-title">Product Category List</h5>
      </div>
      <div class="card-body ">
        <table id="prodCatTable" class="display">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($cats as $key=>$value)

            <tr>
              <td>{{$value->category_id}}</td>
              <td>{{$value->name}}</td>
              <td>
                <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $value->id }}" data-original-title="Edit" class="edit  editCatsData">
                  <i class="nc-icon nc-tag-content"></i>
                </a>
                <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $value->id }}" class="deleteCatsData"><i class="nc-icon nc-basket"></i></a>

              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-3 col-md-3 col-sm-12">
    <div class="card card-user">
      <div class="card-header">
        <h5 class="card-title">Delivery Type</h5>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('delivery-types.store') }}">
          @csrf
          <div class="form-group">
            <label>ID</label>
            <input type="text" name="delivery_type_id" class="form-control" placeholder="Delivery Type ID">
          </div>
          <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" placeholder="Name">
          </div>
          <div class="update ml-auto mr-auto">
            <button type="submit" class="btn btn-primary btn-round">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-lg-9 col-md-9 col-sm-12">
    <div class="card ">
      <div class="card-header ">
        <h5 class="card-title">Delivery Type List</h5>
      </div>
      <div class="card-body ">
        <table id="deliveryTypeTable" class="display">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($types as $key=>$value)

            <tr>
              <td>{{$value->delivery_type_id}}</td>
              <td>{{$value->name}}</td>
              <td>
              <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $value->id }}" data-original-title="Edit" class="edit pr-2  editTypeData">
                  <i class="nc-icon nc-tag-content"></i>
                </a>
                <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $value->id }}" class="deleteTypeData"><i class="nc-icon nc-basket"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-3 col-md-3 col-sm-12">
    <div class="card card-user">
      <div class="card-header">
        <h5 class="card-title">Measurement Type</h5>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('measurement-types.store') }}">
          @csrf
          <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" placeholder="Name">
          </div>
          <div class="update ml-auto mr-auto">
            <button type="submit" class="btn btn-primary btn-round">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-lg-9 col-md-9 col-sm-12">
    <div class="card ">
      <div class="card-header ">
        <h5 class="card-title">Measurement Type List</h5>
      </div>
      <div class="card-body ">
        <table id="measurementTypeTable" class="display">
          <thead>
            <tr>
              <th>Name</th>
              <!-- <th>Action</th> -->
            </tr>
          </thead>
          <tbody>
            @foreach ($measurement_types as $key=>$value)

            <tr>
              <td>{{$value->name}}</td>
              <!-- <td>
                <a href="#" class="pr-2"><i class="nc-icon nc-tag-content"></i></a>
                <a href="#"><i class="nc-icon nc-basket"></i></a>
              </td> -->
            </tr>
            @endforeach
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
              <label class="form-label">Case Name</label>
              <input type="text" name="case_name" id="case_name" class="form-control" placeholder="">
            </div>
            <div class="row">
              <label class="form-label">Weight</label>
              <input type="text" name="case_weight" id="case_weight" class="form-control" placeholder="">
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
<!-- Tables Modal -->
<div class="modal fade" id="tablesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="tablesEditForm" name="tablesEditForm" class="form-horizontal">
          <div class="modal-body">
            <input type="hidden" id="tid" name="id" value="">
            <div class="row">
              <label class="form-label">ID</label>
              <input type="text" name="table_id" id="table_id" class="form-control" placeholder="">
            </div>
            <div class="row">
              <label class="form-label">Name</label>
              <input type="text" name="table_name" id="table_name" class="form-control" placeholder="">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="gradeaveBtn">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- Grades Modal -->
<div class="modal fade" id="gradesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="gradesEditForm" name="gradesEditForm" class="form-horizontal">
          <div class="modal-body">
            <input type="hidden" id="gid" name="id" value="">
            <div class="row">
              <label class="form-label">ID</label>
              <input type="text" name="grade_id" id="grade_id" class="form-control" placeholder="">
            </div>
            <div class="row">
              <label class="form-label">Name</label>
              <input type="text" name="name" id="grade_name" class="form-control" placeholder="">
            </div>
            <div class="row">
              <label class="form-label">Weight</label>
              <input type="text" name="weight" id="grade_weight" class="form-control" placeholder="">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="gradesSaveBtn">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- Categories Modal -->
<div class="modal fade" id="catsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="catsEditForm" name="catsEditForm" class="form-horizontal">
          <div class="modal-body">
            <input type="hidden" id="catid" name="id" value="">
            <div class="row">
              <label class="form-label">ID</label>
              <input type="text" name="category_id" id="category_id" class="form-control" placeholder="">
            </div>
            <div class="row">
              <label class="form-label">Name</label>
              <input type="text" name="cat_name" id="cat_name" class="form-control" placeholder="">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="catsSaveBtn">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- Delivery Type Modal -->
<div class="modal fade" id="typeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="typeEditForm" name="typeEditForm" class="form-horizontal">
          <div class="modal-body">
            <input type="hidden" id="typeid" name="id" value="">
            <div class="row">
              <label class="form-label">ID</label>
              <input type="text" name="delivery_type_id" id="delivery_type_id" class="form-control" placeholder="">
            </div>
            <div class="row">
              <label class="form-label">Name</label>
              <input type="text" name="type_name" id="type_name" class="form-control" placeholder="">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="typeSaveBtn">Save changes</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
  //dELIVERY tYPE
  $(document).on('click', 'a.editTypeData', function() {
    var id = $(this).data('id');
    let url = "{{ route('delivery-types.edit', ':id') }}";
    $.ajax({
      type: 'GET',
      url: url.replace(':id', id),
      success: function(data) {
        console.log(data);
        $('#typeModal').modal('show');
        $('#typeid').val(data.data.id);
        $('#delivery_type_id').val(data.data.delivery_type_id);
        $('#type_name').val(data.data.name);
      }
    });
  });

  $('body').on('click', '#typeSaveBtn', function(event) {
    event.preventDefault()
    var id = $("#typeid").val();
    var name = $("#type_name").val();
    var delivery_type_id = $("#delivery_type_id").val();
    let url = "{{ route('delivery-types.update', ':id') }}";
    $.ajax({
      url: url.replace(':id', id),
      type: "POST",
      data: {
        'id': id,
        'name': name,
        'delivery_type_id': delivery_type_id,
        '_token': '{{ csrf_token() }}',
      },
      dataType: 'json',
      success: function(data) {
        $('#typeEditForm').trigger("reset");
        $('#typeModal').modal('hide');
        return location.reload();
      }
    });
  });

  $('body').on('click', '.deleteTypeData', function() {
    let id = $(this).data('id');

    let confirmData = confirm("Are you confirm to delete this data!");

    if (confirmData == true) {
      $.ajax({
        method: "get",
        url: "{{ url('delivery-types') }}/" + id + '/delete',
        success: function(res) {
          return location.reload();
        },
        error: function(xhr) {
          console.log("error");
        }
      });
    }

  });
  //Categories
  $(document).on('click', 'a.editCatsData', function() {
    var id = $(this).data('id');
    let url = "{{ route('product-categories.edit', ':id') }}";
    $.ajax({
      type: 'GET',
      url: url.replace(':id', id),
      success: function(data) {
        $('#catsModal').modal('show');
        $('#catid').val(data.data.id);
        $('#category_id').val(data.data.category_id);
        $('#cat_name').val(data.data.name);
      }
    });
  });

  $('body').on('click', '#catsSaveBtn', function(event) {
    event.preventDefault()
    var id = $("#catid").val();
    var name = $("#cat_name").val();
    var category_id = $("#category_id").val();
    let url = "{{ route('product-categories.update', ':id') }}";
    $.ajax({
      url: url.replace(':id', id),
      type: "POST",
      data: {
        'id': id,
        'name': name,
        'category_id': category_id,
        '_token': '{{ csrf_token() }}',
      },
      dataType: 'json',
      success: function(data) {
        $('#catsEditForm').trigger("reset");
        $('#catsModal').modal('hide');
        return location.reload();
      }
    });
  });

  $('body').on('click', '.deleteCatsData', function() {
    let id = $(this).data('id');

    let confirmData = confirm("Are you confirm to delete this data!");

    if (confirmData == true) {
      $.ajax({
        method: "get",
        url: "{{ url('product-categories') }}/" + id + '/delete',
        success: function(res) {
          return location.reload();
        },
        error: function(xhr) {
          console.log("error");
        }
      });
    }

  });
  //Grades
  $(document).on('click', 'a.editGradesData', function() {
    var id = $(this).data('id');
    let url = "{{ route('grades.edit', ':id') }}";
    $.ajax({
      type: 'GET',
      url: url.replace(':id', id),
      success: function(data) {
        console.log(data);
        $('#gradesModal').modal('show');
        $('#gid').val(data.data.id);
        $('#grade_name').val(data.data.name);
        $('#grade_id').val(data.data.grade_id);
        $('#grade_weight').val(data.data.weight);
      }
    });
  });

  $('body').on('click', '#gradesSaveBtn', function(event) {
    event.preventDefault()
    var id = $("#gid").val();
    var name = $("#grade_name").val();
    var grade_id = $("#grade_id").val();
    var weight = $("#grade_weight").val();
    let url = "{{ route('grades.update', ':id') }}";
    $.ajax({
      url: url.replace(':id', id),
      type: "POST",
      data: {
        'id': id,
        'name': name,
        'grade_id': grade_id,
        'weight': weight,
        '_token': '{{ csrf_token() }}',
      },
      dataType: 'json',
      success: function(data) {
        $('#gradesEditForm').trigger("reset");
        $('#gradesModal').modal('hide');
        return location.reload();
      }
    });
  });

  $('body').on('click', '.deleteGradesData', function() {
    let id = $(this).data('id');

    let confirmData = confirm("Are you confirm to delete this data!");

    if (confirmData == true) {
      $.ajax({
        method: "get",
        url: "{{ url('grades') }}/" + id + '/delete',
        success: function(res) {
          return location.reload();
        },
        error: function(xhr) {
          console.log("error");
        }
      });
    }

  });
  //Tables
  $(document).on('click', 'a.editTablesData', function() {
    var id = $(this).data('id');
    let url = "{{ route('tables.edit', ':id') }}";
    $.ajax({
      type: 'GET',
      url: url.replace(':id', id),
      success: function(data) {
        $('#tablesModal').modal('show');
        $('#tid').val(data.data.id);
        $('#table_name').val(data.data.name);
        $('#table_id').val(data.data.table_id);
      }
    });
  });

  $('body').on('click', '#tableSaveBtn', function(event) {
    event.preventDefault()
    var id = $("#tid").val();
    var name = $("#table_name").val();
    var table_id = $("#table_id").val();
    let url = "{{ route('tables.update', ':id') }}";
    $.ajax({
      url: url.replace(':id', id),
      type: "POST",
      data: {
        'id': id,
        'name': name,
        'table_id': table_id,
        '_token': '{{ csrf_token() }}',
      },
      dataType: 'json',
      success: function(data) {
        $('#tablesEditForm').trigger("reset");
        $('#tablesModal').modal('hide');
        return location.reload();
      }
    });
  });

  $('body').on('click', '.deleteTablesData', function() {
    let id = $(this).data('id');

    let confirmData = confirm("Are you confirm to delete this data!");

    if (confirmData == true) {
      $.ajax({
        method: "get",
        url: "{{ url('tables') }}/" + id + '/delete',
        success: function(res) {
          return location.reload();
        },
        error: function(xhr) {
          console.log("error");
        }
      });
    }

  });
  //Case List
  $(document).on('click', 'a.editCaseData', function() {
    var id = $(this).data('id');
    let url = "{{ route('cases.edit', ':id') }}";
    $.ajax({
      type: 'GET',
      url: url.replace(':id', id),
      success: function(data) {
        $('#caseModal').modal('show');
        $('#case_id').val(data.data.id);
        $('#case_name').val(data.data.case_name);
        $('#case_weight').val(data.data.weight);
      }
    });
  });

  $('body').on('click', '#caseSaveBtn', function(event) {
    event.preventDefault()
    var id = $("#case_id").val();
    var name = $("#case_name").val();
    var weight = $("#case_weight").val();
    let url = "{{ route('cases.update', ':id') }}";
    $.ajax({
      url: url.replace(':id', id),
      type: "POST",
      data: {
        'id': id,
        'case_name': name,
        'weight': weight,
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

  $('body').on('click', '.deleteData', function() {
    let id = $(this).data('id');

    let confirmData = confirm("Are you confirm to delete this data!");

    if (confirmData == true) {
      $.ajax({
        method: "get",
        url: "{{ url('cases') }}/" + id + '/delete',
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