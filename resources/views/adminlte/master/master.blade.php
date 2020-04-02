<!DOCTYPE html>
<html lang="ar" dir="ltr">
<head>
   @include('adminlte.head.head')
    <style>
       .swal-wide{
  
    width:850px !important;
}
.swal-wide th{
   width:200px;
   text-align:center;
}
.swal-wide table{
  margin:auto;
}
    </style>
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">

   @include('adminlte.head.navhead')
    <!-- Left side column. contains the logo and sidebar -->
       @include('adminlte.sidbar.sidebar')

    <!-- Content Wrapper. Contains page content -->
       <div class="content-wrapper">

           @yield('content')
       </div>

    <!-- /.content-wrapper -->
       @include('adminlte.footer.footer')

  
</div>
<!-- ./wrapper -->

@include('adminlte.footer.js')

@yield('js')
</body>
</html>
