@extends('layouts.app')

@section('title', $page_title)

@push('styles')
<link href="css/daterangepicker.min.css" rel="stylesheet" type="text/css" />
@endpush

@section('content')
<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        <!--begin::Notice-->
        <div class="card card-custom gutter-b">
            <div class="card-header flex-wrap py-5">
                <div class="card-title">
                    <h3 class="card-label"><i class="{{ $page_icon }} text-primary"></i> {{ $sub_title }}</h3>
                </div>
                <div class="card-toolbar">
                    <button type="button" id="print-report" class="btn btn-primary btn-sm font-weight-bolder"> 
                        <i class="fas fa-print"></i> Print</button>

                </div>
            </div>

        </div>
        <!--end::Notice-->
        <!--begin::Card-->
        <div class="card card-custom">
            <div class="card-header flex-wrap py-5">
                <form method="POST" id="form-filter" class="col-md-12 px-0">
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="name">Choose Your Date</label>
                            <div class="input-group">
                                <input type="text" class="form-control daterangepicker-filed" value="{{ date('Y-m-d').' To '.date('Y-m-d') }}">
                                <input type="hidden" id="start_date" name="start_date" value="{{ date('Y-m-d') }}">
                                <input type="hidden" id="end_date" name="end_date" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div style="margin-top:28px;">    
                                <div style="margin-top:28px;">    
                                    <button id="btn-filter" class="btn btn-primary btn-sm btn-elevate btn-icon mr-2 float-left" type="button"
                                    data-toggle="tooltip" data-theme="dark" title="Search" onclick="report()">
                                    <i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <!--begin: Datatable-->
                <div id="kt_datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div id="report" style="width: 100%;margin:0;padding:0;" class="row">
                        
                    </div>
                    <div class="col-md-12 d-none" id="table-loader" style="position: absolute;top:120px;left:0;">
                        <div style="width: 120px;
                        height: 70px;
                        background: white;
                        text-align: center;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        border: 1px solid #ddd;
                        border-radius: 5px;
                        margin: 0 auto;">
                            <i class="fas fa-spinner fa-spin fa-3x fa-fw text-primary"></i>
                        </div>
                    </div>
                </div>
                <!--end: Datatable-->
            </div>
        </div>
        <!--end::Card-->
    </div>
</div>

@endsection

@push('scripts')
<script src="js/jquery.printarea.js"></script>
<script src="js/moment.js"></script>
<script src="js/knockout-3.4.2.js"></script>
<script src="js/daterangepicker.min.js"></script>
<script>
$('.daterangepicker-filed').daterangepicker({
    callback: function(startDate, endDate, period){
        var start_date = startDate.format('YYYY-MM-DD');
        var end_date   = endDate.format('YYYY-MM-DD');
        var title      = start_date + ' To ' + end_date;
        $(this).val(title);
        $('input[name="start_date"]').val(start_date);
        $('input[name="end_date"]').val(end_date);
    }
});

$(document).on('click','#print-report',function(){
    var mode = 'iframe'; // popup
    var close = mode == "popup";
    var options = {
        mode: mode,
        popClose: close
    };
    $("#report").printArea(options);
});

report();
function report()
{
    var start_date   = $('input[name="start_date"]').val();
    var end_date     = $('input[name="end_date"]').val();

    $.ajax({
        url:"{{ url('balance-sheet/report') }}",
        type:"POST",
        data:{start_date:start_date,end_date:end_date,_token:_token},
        beforeSend: function(){
            $('#table-loader').removeClass('d-none');
        },
        complete: function(){
            $('#table-loader').addClass('d-none');
        },
        success:function(data){
            $('#report').empty();
            $('#report').append(data);
        },
        error: function (xhr, ajaxOption, thrownError) {
            console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr.responseText);
        }
    });
}


</script>
@endpush