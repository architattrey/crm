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
                <li class="active">All remarks</li>
            </ol>
        </section>
      
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="back-bg" style="background-color:#fff; height: 64px; margin-top: 20px;">
                @if(!empty($client_id) && isset($client_id))
               
                <a style="margin-top: 5px; padding: 10px 17px; float: right;b margin-right: 17px;" href="{{url('add-remarks/'.$client_id)}}"><button type="button" class="btn btn-primary">Add New Remark</button></a>
                @endif
                </div>
            </div>
        </div>
        <br>
        <br>
        <div class="client" style ="border: 1px solid black; width: 99%;margin-left: 5px;background-color: #d1e8c5;">
            <table class="stripe row-border order-column" style="width:100%">
                    <thead>
                        <tr>
                            <th>Client Name</th>
                            <th>Proposal Date</th>
                            <th>Services</th>
                            <th>Mobile No</th>
                            <th>EmailId</th>
                            <th>Organization Name</th>
                            <th>Reminder Time</th>
                            <th>Reference</th>
                            <th>Created at</th>
                            
                        </tr>    
                    </thead>
                    <tbody>
                        <tr>
							
                            <td>{{(isset($remarks[0]['clients']->client_name) && !empty($remarks[0]['clients']->client_name))?$remarks[0]['clients']->client_name:"NA"}}</td>
                            <td>{{(isset($remarks[0]['clients']->proposal_date) && !empty($remarks[0]['clients']->proposal_date))?$remarks[0]['clients']->proposal_date:"NA"}}</td>
                            <td>{{(isset($remarks[0]['clients']->services) && !empty($remarks[0]['clients']->services))?$remarks[0]['clients']->services:"NA"}}</td>
                            <td>{{(isset($remarks[0]['clients']->mobile_no) && !empty($remarks[0]['clients']->mobile_no))?$remarks[0]['clients']->mobile_no:"NA"}}</td>
                            <td>{{(isset($remarks[0]['clients']->email_id) && !empty($remarks[0]['clients']->email_id))?$remarks[0]['clients']->email_id:"NA"}}</td>
                            <td>{{(isset($remarks[0]['clients']->organization_name) && !empty($remarks[0]['clients']->organization_name))?$remarks[0]['clients']->organization_name:"NA"}}</td>
                            <td>{{(isset($remarks[0]['clients']->reminder_time) && !empty($remarks[0]['clients']->reminder_time))?date('d-m-Y  h:i',strtotime($remarks[0]['clients']->created_at)):"NA"}}</td>
                            <td>{{(isset($remarks[0]['clients']->reference) && !empty($remarks[0]['clients']->reference))?$remarks[0]['clients']->reference:"NA"}}</td>
                            <td>{{(isset($remarks[0]['clients']->created_at) && !empty($remarks[0]['clients']->created_at))?date('d-m-Y',strtotime($remarks[0]['clients']->created_at)):"NA"}}</td>
                            
                        </tr>
                    </tbody>      
            </table>                
        </div>
        <br>
        <br>
       
        <!-- view list of remarks-->
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- ./col -->
                <div class ="col-md-2"></div>
                <!-- remark listing box -->
                <div class ="col-md-8 register" style="background: #fff;padding: 0 15px;">
                <h2 style=" text-align: center;padding: 15px 0;">All remarks</h2>
                <form>
                    @if(!empty($remarks) && isset($remarks))
                        @foreach($remarks as $key => $remark)
                            @php $key++; @endphp
                            <div class="form-group">
                                <label for="comment">{{date('d-m-Y',strtotime($remark->created_at)).' At '. date('h:i ',strtotime($remark->created_at))}} &nbsp;&nbsp;&nbsp;[ Client Name:&nbsp;  {{$remark->clients->client_name ? ucfirst($remark->clients->client_name): "NA" }}]</label>
                                <textarea disabled class="form-control" rows="5" id="comment">{{$remark->remarks ? ucfirst($remark->remarks): "NA" }}</textarea>
                            </div>
                        @endforeach
                    @else
                    <h4 style="text-align: center;padding: 15px 0;">No Remarks found</h4>
                    @endif
                </form>
                </div>
                <!-- ./col -->
                <div class ="col-md-2"></div>
            </div>
             
        </section>    
        <!-- /.content -->
    </div>
@endsection
 
 
