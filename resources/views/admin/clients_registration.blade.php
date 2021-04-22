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
        <li class="active">Client Reg.</li>
      </ol>
    </section>
    <div class="row">
      <div class="col-md-12 col-sm-12">
          <div class="back-bg" style="background-color:#fff; height: 64px; margin-top: 20px;">
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
          
        </div>
        <!-- <div class="alert alert-danger"><span class="glyphicon glyphicon-ok"></span><em></em></div> -->
      @endif
        <div class="row">
          <!-- ./col -->
          <div class ="col-md-3"></div>
          <!-- form -->
          <div class ="col-md-6 register" style="background: #fff;padding: 0 15px;">
            @if(!empty($client) && isset($client))
            <h2 style=" text-align: center;padding: 15px 0;">Update Client details</h2>
            @else
            <h2 style=" text-align: center;padding: 15px 0;">Register New Client</h2>
            @endif

            <!-- form for registration or update the client details -->
            {!! Form::open(['url' => 'data-submition-admin','enctype'=>'multipart/form-data']) !!}
            
              @if (isset($client[0]->id) && !empty($client[0]->id))
                {{ Form::hidden('id',  encrypt($client[0]->id)) }}
              @endif
              <!-- hidden field  for logind id-->
              {{ Form::hidden('user_id',  encrypt(auth('lg')->user()?auth('lg')->user()->id:(auth('admin')->user()?auth('admin')->user()->id:(auth('bdm')->user()?auth('bdm')->user()->id:"")))) }}
              <!-- hidden field for user type -->
              {{ Form::hidden('user_type',  encrypt(auth('lg')->user()?auth('lg')->user()->is_lg:(auth('admin')->user()?auth('admin')->user()->is_super:(auth('bdm')->user()?auth('bdm')->user()->is_bdm:"")))) }}
              
              <!-- field Client Name -->
              <div class="form-group" style="margin-bottom: 15px; font-size: 16px;">
                {{ Form::label('client_name', 'Client Name', ['class' => 'client_name']) }}
                <p class= "form-control-static has-feedback{{ $errors->has('client_name') ? 'has-error':''}}">
                  {{ Form::text('client_name',(!empty($client[0]->client_name))?$client[0]->client_name:old('client_name'),['class'=>'form-control','id'=>'client_name','placeholder'=>'Client Name']) }}
                </p> 
              </div>
              <!-- field Country -->
              <div class="form-group" style="margin-bottom: 15px; font-size: 16px;">
                {{ Form::label('country', 'Country', ['class' => 'country']) }}
                <p class= "form-control-static has-feedback{{ $errors->has('country') ? 'has-error':''}}">
                  {{ Form::text('country',(!empty($client[0]->country))?$client[0]->country:old('country'),['class'=>'form-control','id'=>'country','placeholder'=>'Country']) }}
                </p> 
              </div>
              <!-- field State -->
              <div class="form-group" style="margin-bottom: 15px; font-size: 16px;">
                {{ Form::label('state', 'State', ['class' => 'state']) }}
                <p class= "form-control-static has-feedback{{ $errors->has('state') ? 'has-error':''}}">
                  {{ Form::text('state',(!empty($client[0]->state))?$client[0]->state:old('state'),['class'=>'form-control','id'=>'state','placeholder'=>'State']) }}
                </p> 
              </div>
              <!-- field City -->
              <div class="form-group" style="margin-bottom: 15px; font-size: 16px;">
                {{ Form::label('city', 'City', ['class' => 'city']) }}
                <p class= "form-control-static has-feedback{{ $errors->has('city') ? 'has-error':''}}">
                  {{ Form::text('city',(!empty($client[0]->city))?$client[0]->city:old('city'),['class'=>'form-control','id'=>'city','placeholder'=>'City']) }}
                </p> 
              </div>
              <!-- Organization Name -->
              <div class="form-group" style="margin-bottom: 15px; font-size: 16px;">
                {{ Form::label('organization_name', 'Organization Name ', ['class' => 'organization_name']) }}
                <p class= "form-control-static has-feedback{{ $errors->has('organization_name') ? 'has-error':''}}">
                  {{ Form::text('organization_name',(!empty($client[0]->organization_name))?$client[0]->organization_name:old('organization_name'),['class'=>'form-control','id'=>'organization_name','placeholder'=>'Organization Name']) }}
                </p> 
              </div>
              <!-- field Mobile number -->
              <div class="form-group" style="margin-bottom: 15px; font-size: 16px;">
                {{ Form::label('mobile_no', 'Mobile Number', ['class' => 'mobile_no']) }}
                <p class= "form-control-static has-feedback{{ $errors->has('mobile_no') ? 'has-error':''}}">
                  {{ Form::number('mobile_no',(!empty($client[0]->mobile_no))?$client[0]->mobile_no:old('mobile_no'),['class'=>'form-control','id'=>'mobile_no','placeholder'=>'Mobile Number']) }}
                </p>  
              </div>
              <!-- field  email -->
              <div class="form-group" style="margin-bottom: 15px; font-size: 16px;">
                {{ Form::label('email_id', ' EmailId', ['class' => 'email_id']) }}
                <p class= "form-control-static has-feedback{{ $errors->has('email_id') ? 'has-error':''}}">
                  {{ Form::email('email_id',(!empty($client[0]->email_id))?$client[0]->email_id:old('email_id'),['class'=>'form-control','id'=>'email_id','placeholder'=>'Email Id']) }}
                </p>  
              </div>
              <!-- field Services -->
              <div class="form-group" style="margin-bottom: 15px; font-size: 16px;">
                {{ Form::label('services', 'Services (Looking For)', ['class' => 'services']) }}
                <p class= "form-control-static has-feedback{{ $errors->has('services') ? 'has-error':''}}">
                  {{ Form::text('services',(!empty($client[0]->services))?$client[0]->services:old('services'),['class'=>'form-control','id'=>'services','placeholder'=>'Services']) }}
                </p>  
              </div>
              <!-- field Requirement -->
              <div class="form-group" style="margin-bottom: 15px; font-size: 16px;">
                {{ Form::label('requirement', 'Requirement (Technologies)', ['class' => 'requirement']) }}
                <p class= "form-control-static has-feedback{{ $errors->has('requirement') ? 'has-error':''}}">
                  {{ Form::text('requirement',(!empty($client[0]->requirement))?$client[0]->requirement:old('requirement'),['class'=>'form-control','id'=>'requirement','placeholder'=>'Requirement']) }}
                </p>  
              </div>
              <!-- field Reference -->
              <div class="form-group" style="margin-bottom: 15px; font-size: 16px;">
                {{ Form::label('reference', 'Reference (If Any)', ['class' => 'reference']) }}
                <p class= "form-control-static has-feedback{{ $errors->has('reference') ? 'has-error':''}}">
                  {{ Form::text('reference',(!empty($client[0]->reference))?$client[0]->reference:old('reference'),['class'=>'form-control','id'=>'reference','placeholder'=>'Reference']) }}
                </p>  
              </div>
              <!-- field perposel Date -->
              <div class="form-group" style="margin-bottom: 15px; font-size: 16px;">
                {{ Form::label('proposal_date', 'Proposal Date', ['class' => 'proposal_date']) }}
                <p class= "form-control-static has-feedback{{ $errors->has('proposal_date') ? 'has-error':''}}">
                  {{ Form::text('proposal_date',(!empty($client[0]->proposal_date))?date('d-m-Y',strtotime($client[0]->proposal_date)):old('proposal_date'),['class'=>'form-control','id'=>'proposal_date','placeholder'=>'Perposel Date']) }}
                </p>  
              </div>
              <!-- field lead generate by -->
              <div class="form-group" style="margin-bottom: 15px; font-size: 16px;">
                {{ Form::label('lead_generate_by', 'Lead Generate By', ['class' => 'lead_generate_by']) }}
                <p class= "form-control-static has-feedback{{ $errors->has('lead_generate_by') ? 'has-error':''}}">
                  {{ Form::text('lead_generate_by',(!empty($client[0]->lead_generate_by))?$client[0]->lead_generate_by:old('lead_generate_by'),['class'=>'form-control','id'=>'lead_generate_by','placeholder'=>'Lead Generate By'])}}
                </p>
              </div>
              @if(!empty($client) && isset($client))

              @else
              <div class="form-group" style="margin-bottom: 15px; font-size: 16px;">
                {{ Form::label('remarks', 'Add new Remark', ['class' => 'remarks']) }}
                <p class= "form-control-static has-feedback{{ $errors->has('remarks') ? 'has-error':''}}">
                  {{ Form::textarea('remarks',old('remarks'),['class'=>'form-control','id'=>'remarks','placeholder'=>' Add Remark']) }}
                </p>
              </div>
              <!-- field Reminder Time -->
              <div class="form-group">
                {{ Form::label('reminder_time', 'Reminder Time', ['class' => 'reminder_time']) }}
                <div class='input-group date' id='datetimepicker2'>
                  {{ Form::text('reminder_time',(!empty($client[0]->reminder_time))?date('d-M-Y h:i:s',strtotime($client[0]->reminder_time)):old('reminder_time'),['class'=>'form-control','id'=>'reminder_time','placeholder'=>'Reminder Time']) }}
                  <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                  </span>
                </div>
              </div>
              @endif
              <!--field add remark  -->
              
              <!-- submit button -->
           
              <div class="form-group" style="margin-bottom: 15px; font-size: 16px;">
                
                {{ Form::submit(!empty($client)?'Update':'Submit',['class'=>'btn btn-success']) }}

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
  // $('#datetimepicker2').datetimepicker();
  $('#datetimepicker2').datetimepicker({
    useCurrent: false, //Important! See issue #1075
    minDate:new Date(),
    inline: false,
    sideBySide: true,
    format: 'DD-MM-YYYY HH:mm:ss'
  });
        
});
$('.datepicker').datepicker({
  
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
