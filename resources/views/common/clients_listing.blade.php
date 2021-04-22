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
            <li class="active">Your Leads</li>
        </ol>
        </section>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="back-bg" style="background-color:#fff; height: 64px; margin-top: 20px;">
               
                
                @if(auth('admin')->user())
                    <a style="margin-top: 5px; padding: 10px 17px; float: right;b margin-right: 17px;" href="#"><button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal"><i class="fa fa-file-excel-o" aria-hidden="true"></i> &nbsp; Emport xls file</button></a>
                    <a style="margin-top: 5px; padding: 10px 17px; float: right;b margin-right: 17px;" href="{{route('download-file')}}"><button type="button" class="btn btn-warning"><i class="fa fa-file-text" aria-hidden="true"></i> &nbsp; Export xls file</button></a>
                @elseif(auth('lg')->user())
                    @php
                        $targetLeads = 1000;
                        $leftLeads = $targetLeads - count($allLeads?$allLeads:0);
                        $CreateLeadsPersentage = round(100 - $leftLeads/10);
                        $generatedLeads = count($allLeads?$allLeads:0);
                        $style = "style=width:"."$CreateLeadsPersentage"."%";
                    @endphp
                    
                    <p style ="margin-left: 8px;">Running progress bar according to your generated leads & <strong style="color:green;">Your target Leads: {{$leftLeads}}</strong> </p>
                    <div class="progress" style="width:99%; margin-left:6px;">
                        <div class="progress-bar progress-bar-info" {{$style}} >
                            Your Leads: {{$leftLeads}} 
                        </div>
                       
                    </div>
                @endif    
                </div>
            </div>
        </div>
        <!-- view list of agents -->
        <!-- Main content -->
        <section class="content">
            @if(Session::has('flash_message'))
            <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('flash_message') !!}</em></div>
            @elseif(Session::has('flash_error'))
            <div class="alert alert-danger"><span class="glyphicon glyphicon-ok"></span><em> {!! session('flash_error') !!}</em></div>
            @endif
            <table id="clients" class="stripe row-border order-column" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Client Name</th>
                        <th>Country</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Proposal Date</th>
                        <th>Services</th>
                        <th>Mobile No</th>
                        <th>Email Id</th>
                        <th>Organization</th>
                        <th>Requirement</th>
                        <th>Reference</th>
                        <th>Reminder Time</th>
                        <th>Created At</th>
                        @if(auth('admin')->user())
                        <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($allLeads) && isset($allLeads))
                        @foreach($allLeads as $key => $client)
                        @php $key++;@endphp
                            <tr>
                                <td>{{$key}}</td>
                                <td>{{$client->client_name ? ucfirst($client->client_name):"NA"}}</td>
                                <td>{{$client->country ? ucfirst($client->country):"NA"}}</td>
                                <td>{{$client->state ? ucfirst($client->state):"NA"}}</td>
                                <td>{{$client->city ? ucfirst($client->city):"NA"}}</td>
                                <td>{{$client->proposal_date ? date('d-M-Y',strtotime($client->proposal_date)) : "NA"}}</td>
                                <td>{{$client->services  ? ucfirst($client->services) : "NA"}}</td>
                                <td>{{$client->mobile_no ? $client->mobile_no : "NA"}}</td>
                                <td>{{$client->email_id  ? $client->email_id : "NA"}}</td>
                                <td>{{$client->organization_name ? $client->organization_name : "NA"}}</td>
                                <td>{{$client->requirement ? $client->requirement : "NA"}}</td>
                                <td>{{$client->reference ? $client->reference : "NA"}}</td>
                                <td>{{$client->reminder_time ? date('d-M-Y',strtotime($client->reminder_time)) .' At '. date('h:i',strtotime($client->reminder_time)): "NA"}}</td>
                                <td>{{$client->created_at ? date('d-M-Y',strtotime($client->created_at)) : "NA"}}</td>
                                @if($client->delete_status == '1' &&  auth('admin')->user())
                                <td>
                                    <a href="{{url('all-remarks/'.encrypt($client->id).'/'.$client->delete_status)}}"><i class="fa fa-eye"style="font-size:16px;color:blue" aria-hidden="true"></i></a>&nbsp;
                                    <a href="{{url('update-live-client/'.encrypt($client->id).'/'.$client->delete_status)}}"><i class="fa fa-pencil" style="font-size:16px;color:green" aria-hidden="true"></i></a>&nbsp;
                                    <a href="{{url('delete-live-client/'.encrypt($client->id).'/'.$client->delete_status)}}"><i class="fa fa-trash" style="font-size:16px;color:red" aria-hidden="true"></i></a>&nbsp;
                                </td>
                                @endif
                            </tr>
                        @endforeach 
                    @else
                    <tr>Clients not found</tr>  
                    @endif  
                </tbody> 
            </table>
        </section>    
        <!-- /.content -->
    </div>
    <!-- modal open for import file -->
   
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Import Bulk Data</h4>
                </div>
                <div class="modal-body">
                {!! Form::open(['url' => 'import-file','enctype'=>'multipart/form-data']) !!}
                    {{ Form::file('file',['class'=>' ']) }}   
                </div>
                <div class="modal-footer">
                    {{ Form::submit('Submit',['class'=>'btn btn-success']) }}
                    {{ Form::button('Cancel',['class'=>'btn btn-default','data-dismiss'=>'modal']) }}
                {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <!-- modal close -->
@endsection
@section('script')
<script>
 
    $(document).ready(function() {
        var table = $('#clients').removeAttr('width').DataTable({
            scrollY:        "400px",
            scrollX:        true,
            scrollCollapse: true,
            paging:         true,
            columnDefs: [
                { width: 200 }
            ],
            fixedColumns: true
        });
    });
</script>
@endsection	
 
