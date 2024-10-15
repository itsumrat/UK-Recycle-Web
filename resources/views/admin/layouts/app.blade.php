<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/wikipedia.ico">
    <link rel="icon" type="image/png" href="assets/img/wikipedia.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>UK Textile & Recycling</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <!-- CSS Files -->

    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/paper-dashboard.css?v=2.0.1')}}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link href="{{asset('assets/select2/css/select2.min.css')}}" rel="stylesheet" />

    <style>
        ul.nav li {
            list-style: none;
        }
    </style>

</head>
<body class="">
  <div class="wrapper ">
  @include('admin.layouts.sidebar')


    <div class="main-panel">
      <!-- Navbar -->
      @include('admin.layouts.navbar')
      <!-- End Navbar -->

      <div class="content">
      @yield('content')

      </div>
    </div>
  </div>

      <!--   Core JS Files   -->

  <script src="{{ asset('assets/js/core/jquery.min.js')}} "></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js')}} "></script>

  <script src="{{ asset('assets/js/core/popper.min.js')}} "></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <script src="{{ asset('assets/select2/js/select2.min.js')}} "></script>
  <script src="{{ asset('assets/js/paper-dashboard.js')}} "></script>
  <script src="{{ asset('assets/js/main.js')}} "></script>
  @yield('scripts')

</body>

</html>