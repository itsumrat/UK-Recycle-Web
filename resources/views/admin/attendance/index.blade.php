@extends('admin.layouts.app')
@section('title')
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card ">
            <div class="card-header ">
                <h5 class="card-title">Attendance List</h5>
                <div class="d-flex flex-column align-items-end">

                <!-- <form action="" method="post">
    @csrf
    <div class="form-group">
        <label for="export_type">Select Export Type:</label>
        <select name="export_type" id="export_type" class="form-control">
            <option value="daily">Daily</option>
            <option value="weekly">Weekly</option>
            <option value="monthly">Monthly</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Export</button>
</form> -->


            <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                    <i class="fa fa-calendar"></i>&nbsp;<span></span> <i class="fa fa-caret-down"></i>
                </div>
                <button id="exportBtn" class="btn btn-primary">Export to CSV</button>

            </div>
            </div>
            <div class="card-body ">

                <label for="datepicker">Filter by Date:</label>
                <input type="text" id="datepicker">
                <table id="attendanceTable" class="display">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Total hr</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ( $attendances as $attendance)
                            <tr>
                                <td>{{ date('Y-m-d', strtotime($attendance->date)) }}</td>
                                <td>
                                    {{ $attendance->user->name }}
                                    <br><span class="badge badge-info">{{ $attendance->user->uid }}</span>
                                </td>
                                <td>{{ $attendance->check_in }}</td>
                                <td>{{ $attendance->check_out }}</td>
                                <td>

                                    @if($attendance->check_out != null)
                                        @php 
                                            $start  = $attendance->date.' '.$attendance->check_in;
                                            $end    = $attendance->date.' '.$attendance->check_out;
                                            // echo $start->diffInHours($end) . ':' . $start->diff($end)->format('%I:%S');
                                            $start_time = new DateTime($attendance->check_in);
                                            $end_time = new DateTime($attendance->check_out);
                                            $diff = $end_time->diff($start_time);
                                        
                                            if($diff->format('%H:%I') > 8){
                                                echo 8;
                                            }else{
                                                echo $diff->format('%H:%I');
                                            }
                                              
                                        @endphp
                                    @endif
                                </td>
                                <td>
                                    @if($attendance->status == 0 )
                                        Absent
                                    @elseif($attendance->status == 1)
                                        Present 
                                    @else
                                        Holiday
                                    @endif
                                    
                                </td>
                                <td>
                                    <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $attendance->id }}" data-original-title="Edit" class="edit pr-2 editAttData"><i class="nc-icon nc-tag-content"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
                            <label>Status</label>
                            <select class="status form-control" id="status" name="status">
                                <option value="-1">Select Status</option>
                            </select>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>

<script>
    $(document).ready(function() {
        // Check if DataTable is already initialized
        if ($.fn.DataTable.isDataTable('#attendanceTable')) {
            // Destroy the existing DataTable instance
            $('#attendanceTable').DataTable().destroy();
        }
        var today = new Date();
        $("#datepicker").datepicker({
            dateFormat: "yy-mm-dd",
            defaultDate: today,
            maxDate: today
        });

        // Initialize DataTable with Date Range Filter
        var table = $('#attendanceTable').DataTable({
            "ajax": {
                "url": "attndata",
                "type": 'GET', // Replace with the correct URL for your "attendance" route
                "data": function(d) {
                    // Get the selected date
                    var selectedDate = $("#datepicker").datepicker("getDate");

                    // Check if the selected date is not null before converting
                    if (selectedDate) {
                        d.minDate = selectedDate.toISOString();
                    } else {
                        d.minDate = null;
                    }

                    // Check if the selected date is not null before setting maxDate
                    if (selectedDate) {
                        var maxDate = new Date(selectedDate);
                        maxDate.setDate(maxDate.getDate() + 1);
                        d.maxDate = maxDate.toISOString();
                    } else {
                        d.maxDate = null;
                    }
                },
                "dataSrc": "data" // The property in the returned JSON that contains the data array
            },
            "columns": [{
                    "data": "date"
                },
                {
                    "data": "user.name",
                    "render": function(data, type, row) {
                        if (row.user && row.user.uid) {
                            return data + '<br><span class="badge badge-info">' + row.user.uid + '</span>';
                        } else {
                            return data;
                        }
                    }
                },
                {
                    "data": "check_in"
                },
                {
                    "data": "check_out"
                },
                {
                    "data": "hours",
                    "render": function(data, type, row) {
                        // Calculate the difference in hours between check_out and check_in
                        var checkIn = moment(row.check_in, "HH:mm:ss");
                        var checkOut = moment(row.check_out, "HH:mm:ss");
                        var hoursDifference = checkOut.diff(checkIn, 'hours');

                        // Display the calculated hours
                        if (!isNaN(hoursDifference)) {
                            // Display the calculated hours
                            return hoursDifference;
                        } else {
                            // Return an empty string
                            return '';
                        }
                    }
                },
                {
                    "data": "status",
                    "render": function(data, type, row) {
                        // Check if the status is 1
                        if (data === 1) {
                            return "Present";
                        } else if (data === 2) {
                            return "Holiday";
                        } else {
                            return "Absent";
                        }

                    }
                },
                {
                    "data": "id",
                    "render": function(data, type, row) {
                        var id = row.id; // Define and assign the value of 'row.id' to 'id' variable
                        return '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' + id + '" data-original-title="Edit" class="edit pr-2 editAttData"><i class="nc-icon nc-tag-content"></i></a>';
                    }
                }
            ]
        });

        // Truncate time part from date values
        function truncateTimeFromDate(date) {
            return date.split(" ")[0]; // Get only the date part
        }


        // Add Date Range Filter to DataTable
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var minDate = $("#datepicker").datepicker("getDate");
                var maxDate = new Date(minDate);
                maxDate.setDate(maxDate.getDate() + 1);

                var currentDate = new Date(data[0]);

                return (currentDate >= minDate && currentDate < maxDate);
            }
        );
        // Set initial search value for today
        var todayFormatted = $.datepicker.formatDate("yy-mm-dd", today);
       // table.search(todayFormatted).draw();

        // Apply Date Range Filter on Datepicker change
        $("#datepicker").on("change", function() {
            table.search('').draw();

            table.draw();

            // Check if DataTable has no data
            if (table.data().count() === 0) {
                // Display a message or handle it accordingly
                console.log("No data available for the selected date range.");
            }
        });

                // Handle DateRangePicker change event
        $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
            $(this).find('span').html(picker.startDate.format('MMMM D, YYYY') + ' - ' + picker.endDate.format('MMMM D, YYYY'));
        });

        // Handle Clear button click
        $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
            $(this).find('span').html('Select Date Range');
        });

        // Handle Export button click
        $('#exportBtn').click(function() {
            var dateRange = $('#reportrange').find('span').text();
            var startDate = dateRange.split(' - ')[0];
            var endDate = dateRange.split(' - ')[1];
            
            if (startDate && endDate) {
    $.ajax({
        url: "export-attendance", // Replace with the correct URL for your "attendant" route
        type: 'GET',
        data: {
            start_date: startDate,
            end_date: endDate
        },
        success: function(response) {
            // Create a hidden anchor element
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(new Blob([response]));
            link.setAttribute('download', 'attendance.csv');

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

 else {
                alert('Please select a date range.');
            }
        });
    });


    //dELIVERY tYPE
    $(document).on('click', 'a.editAttData', function() {
        var id = $(this).data('id');
        let url = "{{ route('attendances.edit', ':id') }}";
        $.ajax({
            type: 'GET',
            url: url.replace(':id', id),
            success: function(data) {
                console.log(data);
                $('#typeModal').modal('show');
                $('#typeid').val(data.data.id);
                $('#status').val(data.data.status);
            }
        });
    });

    $('body').on('click', '#typeSaveBtn', function(event) {
        event.preventDefault()
        var id = $("#typeid").val();
        var status = $("#status").val();
        let url = "{{ route('attendances.update', ':id') }}";
        $.ajax({
            url: url.replace(':id', id),
            type: "POST",
            data: {
                'id': id,
                'status': status,
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
</script>
<script>
    // Function to populate the select element with status options
    function populateStatusOptions() {
        var statusSelect = document.getElementById("status");

        // Define status options
        var statusOptions = [{
                value: 0,
                text: "Absent"
            },
            {
                value: 1,
                text: "Present"
            },
            {
                value: 2,
                text: "Holiday"
            }
        ];

        // Populate select element with options
        statusOptions.forEach(function(option) {
            var optionElement = document.createElement("option");
            optionElement.value = option.value;
            optionElement.text = option.text;
            statusSelect.appendChild(optionElement);
        });
    }

    // Call the function to populate status options
    populateStatusOptions();
</script>
@endsection