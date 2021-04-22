<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>CRM | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  {!! Html::style( asset('public/bower_components/bootstrap/dist/css/bootstrap.min.css')) !!}
  {!! Html::style( asset('public/bower_components/font-awesome/css/font-awesome.min.css')) !!}
  {!! Html::style( asset('public/bower_components/Ionicons/css/ionicons.min.css')) !!}
  {!! Html::style( asset('public/dist/css/AdminLTE.min.css')) !!}
  {!! Html::style( asset('public/dist/css/skins/_all-skins.min.css')) !!}
  {!! Html::style( asset('public/bower_components/morris.js/morris.css')) !!}
  {!! Html::style( asset('public/bower_components/jvectormap/jquery-jvectormap.css')) !!}
  {!! Html::style( asset('public/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')) !!}
  {!! Html::style( asset('public/bower_components/bootstrap-daterangepicker/daterangepicker.css')) !!}
  {!! Html::style( asset('public/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')) !!}
   


  <!-- <link href="{{ asset('../bower_components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet"> -->
   
  <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
  <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">

  <script>var FULL_PATH = "<?=url('/')?>";</script>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">


  @include('admin.layouts.nav') 

  @include('admin.layouts.sidebar') 

  
   @yield('content')

  <!-- <footer class="main-footer">
    <div class="pull-right hidden-xs">
     
    </div>
    <center><strong>Copyright &copy; 2018-{{date('Y')}} </strong> All rights
    reserved.</center>
  </footer> -->

   
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="{{ asset('public/bower_components/jquery/dist/jquery.min.js') }}" rel="stylesheet"></script>
<script src="{{ asset('public/bower_components/jquery-ui/jquery-ui.min.js') }}" rel="stylesheet"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.12.0/validate.min.js"></script>
<script  src="{{ asset('public/bower_components/bootstrap/dist/js/bootstrap.min.js') }}" rel="stylesheet"></script>
<script  src="{{ asset('public/bower_components/raphael/raphael.min.js') }}" rel="stylesheet"></script>
<script  src="{{ asset('public/bower_components/raphael/raphael.min.js') }}" rel="stylesheet"></script>
<script  src="{{ asset('public/bower_components/morris.js/morris.min.js') }}" rel="stylesheet"></script>
<script  src="{{ asset('public/bower_components/moment/min/moment.min.js') }}" rel="stylesheet"></script>
<script  src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js" rel="stylesheet"></script>
<script  src="{{ asset('public/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}" rel="stylesheet"></script>
<script  src="{{ asset('public/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}" rel="stylesheet"></script>
<script  src="{{ asset('public/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}" rel="stylesheet"></script>
<script  src="{{ asset('public/bower_components/jquery-knob/dist/jquery.knob.min.js') }}" rel="stylesheet"></script>

<script  src="{{ asset('public/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}" rel="stylesheet"></script>
<script  src="{{ asset('public/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" rel="stylesheet"></script>
<script  src="{{ asset('public/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}" rel="stylesheet"></script>
<script  src="{{ asset('public/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}" rel="stylesheet"></script>
<script  src="{{ asset('public/bower_components/fastclick/lib/fastclick.js') }}" rel="stylesheet"></script>
<script  src="{{ asset('public/dist/js/adminlte.min.js') }}" rel="stylesheet"></script>
<script  src="{{ asset('public/dist/js/pages/dashboard.js') }}" rel="stylesheet"></script>
<script  src="{{ asset('public/dist/js/demo.js') }}" rel="stylesheet"></script>

<script  src="{{ asset('public/dist/js/custom.js') }}" rel="stylesheet"></script>

<script  src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>

 @yield('script')

</body>
</html>
