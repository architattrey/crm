@extends('admin.layouts.app')

@section('content')

 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add remarks</li>
      </ol>
    </section>
    <div class="row">
      <div class="col-md-12 col-sm-12">
          <div class="back-bg" style="background-color:#fff; height: 64px; margin-top: 20px;">
            <a style="margin-top: 5px; padding: 10px 17px; float: right;b margin-right: 17px;" href="{{url('all-remarks/'.encrypt($client[0]->id).'/'.$client[0]->delete_status)}}"><button type="button" class="btn btn-primary">Back</button></a>
          </div>
      </div>
    </div>

    <!-- Main content -->
    <section class="content">
      @if(Session::has('flash_message'))
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
            <span class="sr-only">Close</span>
          </button>
          <strong>{!! session('flash_message') !!}</strong>
        </div>  
        <!-- <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em></em></div> -->
      @elseif(Session::has('flash_error'))
      <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">×</span>
          <span class="sr-only">Close</span>
        </button>
        <strong> {!! session('flash_error') !!}</strong>
      </div>
      <!-- <div class="alert alert-danger"><span class="glyphicon glyphicon-ok"></span><em></em></div> -->
      @endif
        <div class="row">
          <!-- ./col -->
          <div class ="col-md-3"></div>
          <!-- form -->
          <div class ="col-md-6 register" style="background: #fff;padding: 0 15px;">
            <h2 style=" text-align: center;padding: 15px 0;">Add New Remark</h2>
            <!-- form for registration or update the client details -->
            {!! Form::open(['url' => 'remark-submition','enctype'=>'multipart/form-data']) !!}
            
              @if (isset($client[0]->id) && !empty($client[0]->id))

                {{ Form::hidden('client_id', $client[0]->id) }}

              @endif
   
              <!--field add remark  -->
              <div class="form-group" style="margin-bottom: 15px; font-size: 16px;">
                {{ Form::label('remarks', 'Add new Remark', ['class' => 'remarks']) }}
                <p class= "form-control-static has-feedback{{ $errors->has('remarks') ? 'has-error':''}}">
                  {{ Form::textarea('remarks',old('remarks'),['class'=>'form-control','id'=>'remarks','placeholder'=>' Add Remark']) }}
                </p>
              </div>
              <!-- field Reminder Time -->
              <div class="form-group">
                {{ Form::label('reminder_time', 'Reminder Time', ['class' => 'reminder_time']) }}
                <div class='input-group date' id='datetimepicker1'>
                  {{ Form::text('reminder_time',(!empty($client[0]->reminder_time))?date('d/M/Y h:i',strtotime($client[0]->reminder_time)):old('reminder_time'),['class'=>'form-control','id'=>'reminder_time','placeholder'=>'Reminder Time']) }}
                  <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                  </span>
                </div>
              </div>
              <!-- submit button -->
           
              <div class="form-group" style="margin-bottom: 15px; font-size: 16px;">
                
                {{ Form::submit('Submit',['class'=>'btn btn-success']) }}

              </div>
            {!! Form::close() !!}
            <!-- ./form close -->
          </div>
          <!-- ./form -->
          <div class ="col-md-3"></div>
            <!-- ./col -->
        </div>
        <div class="row">
        
        </div>
        <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
@section('script')
<script>

$(function(){
  $('#datetimepicker1').datetimepicker({
    useCurrent: false, //Important! See issue #1075
    minDate:new Date(),
    inline: false,
    sideBySide: true
  });
});
 
</script>
@endsection
@section('css')

<style>
.lead_generate_by {
  margin-left: 13px;
}
input{
  border-radius: 21px; height: 41px;
}
</style>
@endsection
