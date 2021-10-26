<div class="col-md-12">
    <div class="row">
        <div class="table-responsive col-9">
            <table class="table table-borderless">
                <tr>
                    <td><b>Name</b></td><td><b>:</b></td><td>{{ $dealer->name }}</td>
                    <td><b>Type</b></td><td><b>:</b></td><td>{{ $dealer->type == 1 ? 'Depo Dealer' : 'Direct Dealer' }}</td>
                </tr>
                <tr>
                    <td><b>Mobile No.</b></td><td><b>:</b></td><td>{{ $dealer->mobile_no }}</td>
                    <td><b>Email</b></td><td><b>:</b></td><td>{!! $dealer->email ? $dealer->email : '<span class="label label-danger label-pill label-inline" style="min-width:70px !important;">No Email</span>' !!}</td>
                </tr>
                <tr>
                    <td><b>Commission Rate</b></td><td><b>:</b></td><td>{{  number_format($dealer->commission_rate,2,'.','')  }}%</td>
                    <td><b>Depo</b></td><td><b>:</b></td><td>{{  $dealer->depo->name  }}</td>
                    
                </tr>
                <tr>
                    <td><b>District</b></td><td><b>:</b></td><td>{{  $dealer->district->name  }}</td>
                    <td><b>Upazila</b></td><td><b>:</b></td><td>{{  $dealer->upazila->name  }}</td>
                    
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
        <div class="col-md-3 text-center">
            @if($dealer->avatar)
                <img src='storage/{{ SALESMEN_AVATAR_PATH.$dealer->avatar }}' alt='{{ $dealer->name }}' style='width:150px;'/>
            @else
                <img src='images/male.svg' alt='Default Image' style='width:150px;'/>
            @endif
        </div>
    </div>
</div>

<div class="col-md-12 mt-5">
    <div class="row" style="position: relative;border: 1px solid #E4E6EF;padding: 10px 0 0 0; margin: 0;border-radius:5px;">
        <div style="width: 100px;background: #fa8c15;text-align: center;margin: 0 auto;color: white;padding: 5px 0;
            position: absolute;top:-16px;left:10px;">Dealer Areas</div>
        <div class="col-md-12 pt-5">
            <ol style="padding-left: 25px;">
            @if (!$dealer->areas->isEmpty())
                @foreach ($dealer->areas as $area)               
                <li>{{ $area->name }}</li>
                @endforeach
            @endif
            </ol>
        </div>
    </div>
</div>