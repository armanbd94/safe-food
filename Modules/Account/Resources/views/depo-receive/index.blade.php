@extends('layouts.app')

@section('title', $page_title)

@push('styles')
<link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
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
                
            </div>

        </div>
        <!--end::Notice-->
        <!--begin::Card-->
        <div class="card card-custom">
            <div class="card-body">
                <!--begin: Datatable-->
                <div id="kt_datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <form id="depo-receive-form" method="post">
                        @csrf
                        <div class="row">

                            <div class="form-group col-md-4 required">
                                <label for="voucher_no">Voucher No</label>
                                <input type="text" class="form-control" name="voucher_no" id="voucher_no" value="{{ $voucher_no }}" readonly />
                            </div>
                            <div class="form-group col-md-4 required">
                                <label for="voucher_date">Date</label>
                                <input type="text" class="form-control date" name="voucher_date" id="voucher_date" value="{{ date('Y-m-d') }}" readonly />
                            </div>
                            
                            <x-form.selectbox labelName="Depo" name="depo_id"  col="col-md-4" class="selectpicker"
                                onchange="dueAmount(this.value)">
                                @if (!$depos->isEmpty())
                                @foreach ($depos as $value)
                                <option value="{{ $value->id }}">{{ $value->name.' - '.$value->mobile_no.' | '.$value->district_name.' - '.$value->area_name }}</option>
                                @endforeach
                                @endif
                            </x-form.selectbox>

                            <div class="form-group col-md-4">
                                <label for="due_amount">Due Amount</label>
                                <input type="text" class="form-control"  id="due_amount" readonly />
                            </div>
                             <x-form.selectbox labelName="Payment Type" name="payment_type" required="required"  col="col-md-4" class="selectpicker">
                                @foreach (SALE_PAYMENT_METHOD as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </x-form.selectbox>
                            
                            <x-form.selectbox labelName="Account" name="account_id" required="required"  col="col-md-4" class="selectpicker"/>
                            <x-form.textbox labelName="Amount" name="amount" required="required" col="col-md-4" placeholder="0.00"/>
                            <x-form.textarea labelName="Remarks" name="remarks" col="col-md-12"/>
                            <div class="form-group col-md-12 pt-5">
                                <button type="button" class="btn btn-danger btn-sm mr-3"><i class="fas fa-sync-alt"></i> Reset</button>
                                <button type="button" class="btn btn-primary btn-sm mr-3" id="save-btn" onclick="store_data()"><i class="fas fa-save"></i> Save</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!--end: Datatable-->
            </div>
        </div>
        <!--end::Card-->
    </div>
</div>

@endsection

@push('scripts')
<script src="js/moment.js"></script>
<script src="js/bootstrap-datetimepicker.min.js"></script>
<script>
$('.date').datetimepicker({format: 'YYYY-MM-DD',ignoreReadonly: true});
$(document).on('change', '#payment_type', function () {
    $.ajax({
        url: "{{route('account.list')}}",
        type: "POST",
        data: { payment_method: $('#payment_type option:selected').val(),_token: _token},
        success: function (data) {
            $('#depo-receive-form #account_id').html('');
            $('#depo-receive-form #account_id').html(data);
            $('#depo-receive-form #account_id.selectpicker').selectpicker('refresh');
        },
        error: function (xhr, ajaxOption, thrownError) {
            console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr.responseText);
        }
    });
});
function dueAmount(depo_id)
{
    $.ajax({
        url: "{{url('depo/previous-balance')}}/"+depo_id,
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            data ? $('#due_amount').val(parseFloat(data).toFixed(2)) : $('#due_amount').val('0.00');
        },
        error: function (xhr, ajaxOption, thrownError) {
            console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr.responseText);
        }
    });
}

function store_data(){
    let form = document.getElementById('depo-receive-form');
    let formData = new FormData(form);
    let url = "{{url('depo-receive')}}";
    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        dataType: "JSON",
        contentType: false,
        processData: false,
        cache: false,
        beforeSend: function(){
            $('#save-btn').addClass('spinner spinner-white spinner-right');
        },
        complete: function(){
            $('#save-btn').removeClass('spinner spinner-white spinner-right');
        },
        success: function (data) {
            $('#depo-receive-form').find('.is-invalid').removeClass('is-invalid');
            $('#depo-receive-form').find('.error').remove();
            if (data.status == false) {
                $.each(data.errors, function (key, value) {
                    var key = key.split('.').join('_');
                    $('#depo-receive-form input#' + key).addClass('is-invalid');
                    $('#depo-receive-form textarea#' + key).addClass('is-invalid');
                    $('#depo-receive-form select#' + key).parent().addClass('is-invalid');
                    $('#depo-receive-form #' + key).parent().append(
                        '<small class="error text-danger">' + value + '</small>');
                });
            } else {
                notification(data.status, data.message);
                if (data.status == 'success' && data.supplier_transaction != '') {

                    window.location.replace("{{ url('depo-receive') }}/"+data.depo_transaction+'/'+$('#payment_type option:selected').val());
                    
                }
            }

        },
        error: function (xhr, ajaxOption, thrownError) {
            console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr.responseText);
        }
    });
}

</script>
@endpush