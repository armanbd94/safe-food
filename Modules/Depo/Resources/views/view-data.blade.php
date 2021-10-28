<div class="col-md-12">
    <div class="table-responsive col-9">
        <table class="table table-borderless">
            <tr>
                <td><b>Name</b></td><td><b>:</b></td><td><b>{{ $depo->name }}</b></td>
                <td></td>
            </tr>
            <tr>
                <td><b>Mobile No.</b></td><td><b>:</b></td><td>{{ $depo->mobile_no }}</td>
                <td><b>Email</b></td><td><b>:</b></td><td>{!! $depo->email ? $depo->email : '<span class="label label-danger label-pill label-inline" style="min-width:70px !important;">No Email</span>' !!}</td>
                    
            </tr>
            <tr>
                <td><b>Commission Rate</b></td><td><b>:</b></td><td>{{  number_format($depo->commission_rate,2,'.','')  }}%</td> 
                <td><b>District</b></td><td><b>:</b></td><td>{{  $depo->district->name  }}</td>
                
            </tr>
            <tr>
                <td><b>Upazila</b></td><td><b>:</b></td><td>{{  $depo->upazila->name  }}</td>
                <td><b>Area</b></td><td><b>:</b></td><td>{{  $depo->area->name  }}</td>
            </tr>
            <tr>
                <td><b>Address</b></td><td><b>:</b></td><td>{{  $depo->address  }}</td>
                <td><b>Status</b></td><td><b>:</b></td><td>{!! STATUS_LABEL[$depo->status] !!}</td>
                
            </tr>
            <tr>
                <td><b>Created By</b></td><td><b>:</b></td><td>{{  $depo->created_by  }}</td>
                <td><b>Modified By</b></td><td><b>:</b></td><td>{{  $depo->modified_by  }}</td>
                
            </tr>
            <tr>
                <td><b>Create Date</b></td><td><b>:</b></td><td>{{  $depo->created_at ? date(config('settings.date_format'),strtotime($depo->created_at)) : ''  }}</td>
                <td><b>Modified Date</b></td><td><b>:</b></td><td>{{  $depo->updated_at ? date(config('settings.date_format'),strtotime($depo->updated_at)) : ''  }}</td>
            </tr>
        </table>
    </div>
</div>
