@extends('layouts.app')

@section('title', $page_title)

@push('styles')
<link rel="stylesheet" href="css/jquery-ui.css" />
<link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
<style>
    .w18{width: 18%;}
</style>
@endpush

@section('content')
<div class="d-flex flex-column-fluid">
    @php
        $payment_method = $account_id = $reference_no = '';
        if($purchase->purchase_payments->isEmpty())
        {
            $account_id = $purchase->purchase_payments[0]->account_id;
            $reference_no = $purchase->purchase_payments[0]->reference_no;
        }
    @endphp
    <div class="container-fluid">
        <!--begin::Notice-->
        <div class="card card-custom gutter-b">
            <div class="card-header flex-wrap py-5">
                <div class="card-title">
                    <h3 class="card-label"><i class="{{ $page_icon }} text-primary"></i> {{ $sub_title }}</h3>
                </div>
                <div class="card-toolbar">
                    <!--begin::Button-->
                    <a href="{{ route('purchase') }}" class="btn btn-warning btn-sm font-weight-bolder"> 
                        <i class="fas fa-arrow-left"></i> Back</a>
                    <!--end::Button-->
                </div>
            </div>
        </div>
        <!--end::Notice-->
        <!--begin::Card-->
        <div class="card card-custom">
            <div class="card-body">
                <!--begin: Datatable-->
                <div id="kt_datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <form action="" id="purchase_store_form" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="purchase_id" id="purchase_id" value="{{ $purchase->id }}">
                        <input type="hidden" name="supplier_id" id="supplier_id" value="{{ $purchase->supplier_id }}">
                        <div class="row">
                            <div class="form-group col-md-4 required">
                                <label for="chalan_no">Memo No.</label>
                                <input type="text" class="form-control" name="memo_no" id="memo_no" value="{{ $purchase->memo_no }}" readonly />
                            </div>
                            <x-form.textbox labelName="Purchase Date" name="purchase_date" value="{{ date('Y-m-d') }}" required="required" class="date" col="col-md-4"/>
                            <x-form.textbox labelName="Supplier" name="supplier" value="{{ $purchase->supplier->name }}" required="required" property="readonly" col="col-md-4"/>



                            <div class="col-md-12 table-responsive">
                                <table class="table table-bordered" id="material_table">
                                    <thead class="bg-primary">
                                        <th>Name</th>
                                        <th class="text-center">Unit</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-right">Net Unit Cost</th>
                                        <th class="text-right">Subtotal</th>
                                        <th class="text-center"><i class="fas fa-trash text-white"></i></th>
                                    </thead>
                                    <tbody>
                                        @if(!$purchase->purchase_materials->isEmpty())
                                            @foreach($purchase->purchase_materials as $key => $value)
                                            @php
                                                $unit_name = DB::table('units')->where('id',$value->pivot->purchase_unit_id)->value('unit_name');
                                            @endphp
                                            <tr>
                                                <td class="col-md-3">                                                  
                                                    <select name="materials[{{ $key+1 }}][id]" id="materials_{{ $key+1 }}_id" class="fcs col-md-12 form-control selectpicker" onchange="setMaterialDetails({{ $key+1 }})"  data-live-search="true" data-row="{{ $key+1 }}">                                            
                                                        @if (!$materials->isEmpty())
                                                            <option value="0">Please Select</option>
                                                        @foreach ($materials as $material)
                                                            <option value="{{ $material->id }}" {{ $value->id == $material->id ? 'selected' : '' }} data-unitid="{{ $material->purchase_unit_id }}" 
                                                                data-unitname="{{ $material->purchase_unit->unit_name }}">{{ $material->material_name }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                </td>                                        
                                                <td class="unit_name_{{ $key+1 }} text-center" data-row="{{ $key+1 }}">{{ $unit_name }}</td>
                                                <td><input type="text" class="form-control qty text-center" value="{{ $value->pivot->qty }}" onkeyup="calculateRowTotal({{ $key+1 }})" name="materials[{{ $key+1 }}][qty]" id="materials_{{ $key+1 }}_qty"  data-row="{{ $key+1 }}"></td>
                                                <td><input type="text" class="text-right form-control net_unit_cost"  value="{{ number_format($value->pivot->net_unit_cost,2,'.','') }}" onkeyup="calculateRowTotal({{ $key+1 }})" name="materials[{{ $key+1 }}][net_unit_cost]" id="materials_{{ $key+1 }}_net_unit_cost" data-row="{{ $key+1 }}"></td>
                                                <td class="subtotal_{{ $key+1 }} text-right" data-row="{{ $key+1 }}">{{ number_format($value->pivot->total,2,'.','') }}</td>
                                                <td class="text-center">
                                                    @if($key != 0)
                                                    <button type="button" class="btn btn-danger btn-sm remove-material"><i class="fas fa-trash"></i></button>
                                                    @endif
                                                </td>
                                                <input type="hidden" id="materials_{{ $key+1 }}_purchase_unit_id" value="{{ $value->pivot->purchase_unit_id }}" name="materials[{{ $key+1 }}][purchase_unit_id]" data-row="{{ $key+1 }}">
                                                <input type="hidden" class="subtotal" id="materials_{{ $key+1 }}_subtotal" value="{{ number_format($value->pivot->total,2,'.','') }}" name="materials[{{ $key+1 }}][subtotal]" data-row="{{ $key+1 }}">
                                            </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2" class="font-weight-bolder">Total</td>
                                            <td id="total-qty" class="text-center font-weight-bolder">{{ $purchase->total_qty }}</td>
                                            <td></td>
                                            <td id="total" class="text-right font-weight-bolder">{{ number_format($purchase->grand_total,2,'.',',') }}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-success small-btn btn-sm add-material"><i class="fas fa-plus"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-right font-weight-bolder" colspan="4">Discount Amount</td>
                                            <td><input type="text" class="fcs form-control text-right" name="discount_amount" id="discount_amount" value="{{ number_format($purchase->discount_amount,2,'.','') }}" onkeyup="calculateNetTotal()" placeholder="0.00"></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right font-weight-bolder" colspan="4">Net Total</td>
                                            <td><input type="text" class="fcs form-control text-right bg-secondary" name="net_total" id="net_total" value="{{ number_format($purchase->net_total,2,'.','') }}" placeholder="0.00" readonly></td>
                                            <td></td>
                                        </tr>

                                    </tfoot>
                                </table>
                            </div>
                            <div class="col-md-12">
                                <input type="hidden" name="item" id="item" value="{{ $purchase->item }}">
                                <input type="hidden" name="total_qty" id="total_qty" value="{{ number_format($purchase->total_qty,2,'.','') }}">
                                <input type="hidden" name="grand_total" id="grand_total" value="{{ number_format($purchase->grand_total,2,'.','') }}">
                            </div>
                            

                            <div class="form-grou col-md-12 text-center pt-5">
                                <button type="button" class="btn btn-danger btn-sm mr-3"><i class="fas fa-sync-alt"></i> Reset</button>
                                <button type="button" class="btn btn-primary btn-sm mr-3" id="save-btn" onclick="store_data()"><i class="fas fa-save"></i> Update</button>
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
<script src="js/jquery-ui.js"></script>
<script src="js/moment.js"></script>
<script src="js/bootstrap-datetimepicker.min.js"></script>
<script>
$(document).ready(function () {
    $('.date').datetimepicker({format: 'YYYY-MM-DD'});

    $('#material_table').on('click','.remove-material',function(){
        $(this).closest('tr').remove();
        calculateTotal();
    });

    var count = 1;
    @if(!$purchase->purchase_materials->isEmpty())
    count = "{{ count($purchase->purchase_materials) }}";
    @endif
    $('#material_table').on('click','.add-material',function(){
        count++;
        material_row_add(count);
    }); 
       
    function material_row_add(count){
        var html = ` <tr>
                        <td class="col-md-3">                                                  
                            <select name="materials[${count}][id]" id="materials_${count}_id" class="fcs col-md-12 form-control selectpicker" onchange="setMaterialDetails(${count})"  data-live-search="true" data-row="${count}">                                            
                                @if (!$materials->isEmpty())
                                    <option value="0">Please Select</option>
                                @foreach ($materials as $material)
                                    <option value="{{ $material->id }}" data-unitid="{{ $material->purchase_unit_id }}" 
                                    data-unitname="{{ $material->purchase_unit->unit_name }}">{{ $material->material_name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </td>                                        
                        <td class="unit_name_${count} text-center" data-row="${count}"></td>
                        <td><input type="text" class="form-control qty text-center" onkeyup="calculateRowTotal(${count})" name="materials[${count}][qty]" id="materials_${count}_qty"  data-row="${count}"></td>
                        <td><input type="text" class="text-right form-control net_unit_cost" onkeyup="calculateRowTotal(${count})" name="materials[${count}][net_unit_cost]" id="materials_${count}_net_unit_cost" data-row="${count}"></td>
                        <td class="subtotal_${count} text-right" data-row="${count}"></td>
                        <td class="text-center"><button type="button" class="btn btn-danger btn-sm remove-material"><i class="fas fa-trash"></i></button></td>
                        <input type="hidden" id="materials_${count}_purchase_unit_id" name="materials[${count}][purchase_unit_id]" data-row="${count}">
                        <input type="hidden" class="subtotal" id="materials_${count}_subtotal" name="materials[${count}][subtotal]" data-row="${count}">
                    </tr>`;
        $('#material_table tbody').append(html);
        $('#material_table .selectpicker').selectpicker();
    } 

});

function setMaterialDetails(row){
    let unit_id = $(`#materials_${row}_id option:selected`).data('unitid');
    let unit_name = $(`#materials_${row}_id option:selected`).data('unitname');

    $(`.unit_name_${row}`).text(unit_name);
    $(`#materials_${row}_purchase_unit_id`).val(unit_id);
} 

function calculateRowTotal(row)
{
    let cost = $(`#materials_${row}_net_unit_cost`).val() ? parseFloat($(`#materials_${row}_net_unit_cost`).val()) : 0;
    let qty = $(`#materials_${row}_qty`).val() ? parseFloat($(`#materials_${row}_qty`).val()) : 0;
    if(qty < 0 || qty == ''){
        qty = 0;
        // $(`#materials_${row}_qty`).val('');
    }
    if(cost < 0 || cost == ''){
        cost = 0;
        // $(`#materials_${row}_net_unit_cost`).val('');
    }

    $(`.subtotal_${row}`).text((qty * cost).toFixed(2));
    $(`#materials_${row}_subtotal`).val((qty * cost).toFixed(2));
    
    calculateTotal();
}

function calculateTotal()
{
    //sum of qty
    var total_qty = 0;
    $('.qty').each(function() {
        if($(this).val() == ''){
            total_qty += 0;
        }else{
            total_qty += parseFloat($(this).val());
        }
    });
    $('#total-qty').text(total_qty);
    $('input[name="total_qty"]').val(total_qty);

    //sum of subtotal
    var total = 0;
    $('.subtotal').each(function() {
        total += parseFloat($(this).val());
    });
    $('#total').text(total.toFixed(2));
    $('input[name="grand_total"]').val(total.toFixed(2));

    var item = $('#material_table tbody tr:last').index()+1;
    $('input[name="item"]').val(item);
    calculateNetTotal();
}
function calculateNetTotal()
{
    var grand_total  = parseFloat($('#grand_total').val());
    var discount_amount = $('#discount_amount').val() ? parseFloat($('#discount_amount').val()) : 0;
    var net_total = grand_total - discount_amount;
    var paid_amount = $('#paid_amount').val() ? parseFloat($('#paid_amount').val()) : 0;
    var due_amount = net_total - paid_amount;
    $('#net_total').val(net_total.toFixed(2));
    $('#due_amount').val(due_amount.toFixed(2));
}

function account_list(payment_method)
{
    $.ajax({
        url: "{{route('account.list')}}",
        type: "POST",
        data: { payment_method: payment_method,_token: _token},
        success: function (data) {
            $('#purchase_store_form #account_id').empty().html(data);
            $('#purchase_store_form #account_id.selectpicker').selectpicker('refresh');
        },
        error: function (xhr, ajaxOption, thrownError) {
            console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr.responseText);
        }
    });
}

function store_data(){
    var rownumber = $('table#material_table tbody tr:last').index();
    if (rownumber < 0) {
        notification("error","Please insert material to order table!")
    }else{
        let form = document.getElementById('purchase_store_form');
        let formData = new FormData(form);
        let url = "{{route('purchase.update')}}";
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
                $('#purchase_store_form').find('.is-invalid').removeClass('is-invalid');
                $('#purchase_store_form').find('.error').remove();
                if (data.status == false) {
                    $.each(data.errors, function (key, value) {
                        var key = key.split('.').join('_');
                        $('#purchase_store_form input#' + key).addClass('is-invalid');
                        $('#purchase_store_form textarea#' + key).addClass('is-invalid');
                        $('#purchase_store_form select#' + key).parent().addClass('is-invalid');
                        $('#purchase_store_form #' + key).parent().append(
                            '<small class="error text-danger">' + value + '</small>');
                    });
                } else {
                    notification(data.status, data.message);
                    if (data.status == 'success') {
                        window.location.replace("{{ url('purchase') }}");
                        
                    }
                }

            },
            error: function (xhr, ajaxOption, thrownError) {
                console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr.responseText);
            }
        });
    }
    
}
</script>
@endpush