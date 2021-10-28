<div class="col-md-12">
    <div class="table-responsive col-9">
        <table class="table table-borderless">
            <tr>
                <td colspan="2"><b>Name</b></td><td><b>:</b></td><td>{{ $dealer->name }}</td>
            </tr>
            <tr>
                <td><b>Mobile No.</b></td><td><b>:</b></td><td>{{ $dealer->mobile_no }}</td>
                <td><b>Email</b></td><td><b>:</b></td><td>{!! $dealer->email ? $dealer->email : '<span class="label label-danger label-pill label-inline" style="min-width:70px !important;">No Email</span>' !!}</td>
                    
            </tr>
            <tr>
                <td><b>Commission Rate</b></td><td><b>:</b></td><td>{{  number_format($dealer->commission_rate,2,'.','')  }}%</td> 
                <td><b>District</b></td><td><b>:</b></td><td>{{  $dealer->district->name  }}</td>
                
            </tr>
            <tr>
                <td><b>Upazila</b></td><td><b>:</b></td><td>{{  $dealer->upazila->name  }}</td>
                <td><b>Area</b></td><td><b>:</b></td><td>{{  $dealer->area->name  }}</td>
            </tr>
            <tr>
                <td><b>Address</b></td><td><b>:</b></td><td>{{  $dealer->address  }}</td>
                <td><b>Status</b></td><td><b>:</b></td><td>{!! STATUS_LABEL[$dealer->status] !!}</td>
                
            </tr>
            <tr>
                <td><b>Created By</b></td><td><b>:</b></td><td>{{  $dealer->created_by  }}</td>
                <td><b>Modified By</b></td><td><b>:</b></td><td>{{  $dealer->modified_by  }}</td>
                
            </tr>
            <tr>
                <td><b>Create Date</b></td><td><b>:</b></td><td>{{  $dealer->created_at ? date(config('settings.date_format'),strtotime($dealer->created_at)) : ''  }}</td>
                <td><b>Modified Date</b></td><td><b>:</b></td><td>{{  $dealer->updated_at ? date(config('settings.date_format'),strtotime($dealer->updated_at)) : ''  }}</td>
            </tr>
        </table>
    </div>
</div>
