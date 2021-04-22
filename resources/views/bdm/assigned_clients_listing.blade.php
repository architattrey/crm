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
            <li class="active">Your Assigned Leads</li>
        </ol>
        </section>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="back-bg" style="background-color:#fff; height: 64px; margin-top: 20px;">
               
                
               </div>
            </div>
        </div>
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
          <strong>{!! session('flash_error') !!}</strong>
        </div>
        <!-- <div class="alert alert-danger"><span class="glyphicon glyphicon-ok"></span><em></em></div> -->
        @endif
        <!-- view list of agents -->
        <!-- Main content -->
        <section class="content">
             
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
                        <th>Change Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($assignedClients) && isset($assignedClients))
                        @foreach($assignedClients as $key => $client)
                        @php $key++;@endphp
                        @if($client->status == 0)
                            @php $bgcolor = "style='background-color:#e3ef8052;'"; @endphp
                        @elseif($client->status == 1)
                            @php $bgcolor = "style='background-color:#f3e4d1;'"; @endphp
                        @elseif($client->status == 2)
                            @php $bgcolor = "style='background-color:#fffdcabf;'"; @endphp
                        @elseif($client->status == 3)
                            @php $bgcolor = "style='background-color:#f3ec9e;'"; @endphp
                        @elseif($client->status == 4)
                            @php $bgcolor = "style='background-color:#cbe5f1;'"; @endphp
                        @elseif($client->status == 5)
                            @php $bgcolor = "style='background-color:#f1cbcb;'"; @endphp
                        @elseif($client->status == 6)
                            @php $bgcolor = "style='background-color:#80ef8352'"; @endphp
                        @endif
                            <tr <?= $bgcolor; ?>>
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
                                 
                                <td>
                                
                                @if($client->status == 0 || $client->status == 1 || $client->status == 2 || $client->status == 3 || $client->status == 4)
                                    <select class = 'status'>
                                        <option value = " ">{{$client->status == 1 ? 'Contacted' : ($client->status == 2 ? 'Quotation Sent' : ($client->status == 3 ? 'Negotiation' : ($client->status == 4 ? 'Important' : 'Select Status'))) }} </option>
                                        <option value = "{{$client->id.'-'.'1'}}">Contacted</option>
                                        <option value = "{{$client->id.'-'.'2'}}">Quotation Sent</option>
                                        <option value = "{{$client->id.'-'.'3'}}">Negotiation</option>
                                        <option value = "{{$client->id.'-'.'4'}}">Important</option>
                                        <option value = "{{$client->id.'-'.'5'}}">Irrelevant</option>
                                        <option value = "{{$client->id.'-'.'6'}}">Deal Done</option>
                                    </select> 
                                @elseif($client->status == 6)
                                    you have Achived this lead 
                                @elseif($client->status == 5)   
                                    you have Declined this lead 
                                @endif    
                                </td>
                                <td>
                                    <a href="{{url('all-remarks/'.encrypt($client->id).'/'.$client->delete_status)}}"><i class="fa fa-eye"style="font-size:16px;color:blue" aria-hidden="true"></i></a>&nbsp;
                                    <a href="{{url('update-live-client/'.encrypt($client->id).'/'.$client->delete_status)}}"><i class="fa fa-pencil" style="font-size:16px;color:green" aria-hidden="true"></i></a>&nbsp;
                                </td>
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
    // select bdm
    $(".status").change(function () {
        var data = this.value;
       
        $.ajax({
            type:'post',
            url: "{{URL::route('change-status')}}",
            data:{'data':data,"_token": "{{ csrf_token() }}"},
            dataType:'json',
            success: function(result){
                    alert(result.message);
                    location.reload();
            }
        });    
    });
</script>
@endsection	
 
