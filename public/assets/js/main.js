$('#caseTable').DataTable();
$('#userTable').DataTable();
$('#tableList').DataTable();
$('#gradeList').DataTable();
$('#prodCatTable').DataTable();
$('#deliveryTypeTable').DataTable();
$('#productionTable').DataTable();
$('#customerTable').DataTable();
$('#measurementTypeTable').DataTable();
$('#attendanceTable').DataTable();
$('#deliveryInTable').DataTable({
  scrollX: true
});
$('#transactionInTable').DataTable({
  scrollX: true
});
$('#deliveryOutTable').DataTable({
  scrollX: true
});
$('#transactionOutTable').DataTable({
  scrollX: true
});
$('#creditTable').DataTable({
	ordering: false,
	searching: false, 
	paging: false,
	info: false
});
$('#stockTable').DataTable({
	paging: false,
    info: false
});

// $('.supplierName').select2({
//     placeholder: "Select a supplier",
//     allowClear: true
// });
// $('.customerName').select2({
//     placeholder: "Select a customer",
//     allowClear: true
// });
// $('.productName').select2({
//     placeholder: "Select a category",
//     allowClear: true
// });
// $('.employeeName').select2({
//     placeholder: "Select an employee",
//     allowClear: true
// });
// $('.usersName').select2({
//     placeholder: "Select an user",
//     allowClear: true
// });
// $('.tableName').select2({
//     placeholder: "Select a table",
//     allowClear: true
// });
// $('.gradeName').select2({
//     placeholder: "Select a grade",
//     allowClear: true
// });

// $('input[name="attendanceDate"]').daterangepicker({
//     singleDatePicker: true,
//     showDropdowns: true,
//     minYear: 2023,
//     locale: {
//         format: 'DD/MM/YYYY'
//     }
// });
// $('input[name="productionDate"]').daterangepicker({
//     singleDatePicker: true,
//     showDropdowns: true,
//     minYear: 2023,
//     locale: {
//         format: 'DD/MM/YYYY'
//     }
// });

$(function() {

  var start = moment().subtract(29, 'days');
  var end = moment();

  function cb(start, end) {
      $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
  }

  $('#reportrange').daterangepicker({
      startDate: start,
      endDate: end,
      ranges: {
         'Today': [moment(), moment()],
         'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
         'Last 7 Days': [moment().subtract(6, 'days'), moment()],
         'Last 30 Days': [moment().subtract(29, 'days'), moment()],
         'This Month': [moment().startOf('month'), moment().endOf('month')],
         'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      }
  }, cb);

  cb(start, end);

});