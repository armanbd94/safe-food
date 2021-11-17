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
                <div class="card-toolbar">
                    <!--begin::Button-->
                    <a href="{{ route('purchase.return') }}" class="btn btn-warning btn-sm font-weight-bolder"> 
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
                    <form id="purchase_return_form" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="supplier_id" value="{{ $purchase->supplier_id }}">
                            <input type="hidden" class="form-control" name="purchase_id" value="{{ $purchase->id }}" />

                            <div class="form-group col-md-3 required">
                                <label for="memo_no">Memo No.</label>
                                <input type="text" class="form-control" name="memo_no" id="memo_no" value="{{ $purchase->memo_no }}"  readonly />
                            </div>
                            <div class="form-group col-md-3 required">
                                <label for="purchase_date">Purchase Date</label>
                                <input type="text" class="form-control"  value="{{ $purchase->purchase_date }}" readonly />
                            </div>
                            <div class="form-group col-md-3 required">
                                <label for="return_date">Return Date</label>
                                <input type="text" class="form-control date" name="return_date" id="return_date" value="{{ date('Y-m-d') }}" readonly />
                            </div>
                            <div class="form-group col-md-3 required">
                                <label for="">Supplier Name</label>
                                <input type="text" class="form-control" name="supplier_name" value="{{ $purchase->supplier->name }}" readonly />
                            </div>

                            <div class="col-md-12">
                                <table class="table table-bordered" id="product_table">
                                    <thead class="bg-primary">
                                        <th >Name</th>
                                        <th  class="text-center">Unit</th>
                                        <th  class="text-center">Purchase Qty</th>
                                        <th  class="text-center">Return Qty</th>
                                        <th  class="text-right">Net Unit Cost</th>
                                        <th  class="text-right">Deduction(%)</th>
                                        <th  class="text-right">Subtotal</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @if (!$purchase->purchase_materials->isEmpty())
                                            @foreach ($purchase->purchase_materials as $key => $purchase_material)
                                                
                                            @endforeach
                                        @endif

                                        <tr>
                                            <td class="col-md-3">                                                
                                                <select name="materials[1][id]" id="materials_1_id" class="fcs col-md-12 form-control selectpicker" onchange="setMaterialDetails(1)"  data-live-search="true" data-row="1">
                                                @if (!$purchase->purchase_materials->isEmpty())
                                                <option value="">Please Select</option>
                                                @foreach ($purchase->purchase_materials as $key => $material)
                                                    @php
                                                         $return_qty = DB::table('purchase_return_materials as sp')
                                                        ->join('purchase_returns as sr','sp.purchase_return_id','=','sr.id')
                                                        ->where([['sp.product_id',$material->id],['sr.purchase_id',$sale->id]])
                                                        ->sum('sp.return_qty');
                                                        $unit_name = DB::table('units')->where('id',$material->pivot->purchase_unit_id)->value('unit_name');
                                                    @endphp
                                                    <option value="{{ $material->id }}" data-unitid={{ $material->pivot->purchase_unit_id }}  data-unitname="{{ $unit_name }}" 
                                                         data-purchaseqty="{{ ($material->pivot->qty - ($return_qty ?? 0)) }}" 
                                                        data-cost="{{ $material->pivot->net_unit_cost }}">{{ $material->name }}</option>
                                                @endforeach
                                                @endif
                                                </select>
                                            </td>
                                            <td class="unit_name_1 text-center" data-row="1"></td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                <input type="text" class="fcs form-control purchase_qty text-center custom-input bg-secondary" name="materials[1][purchase_qty]" id="materials_1_purchase_qty" data-row="1" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                <input type="text" class="fcs form-control return_qty text-center custom-input" onkeyup="calculateRowTotal(1)" name="materials[1][return_qty]" id="materials_1_return_qty" data-row="1">
                                                </div>
                                            </td>
                                            <td class="net_unit_cost_1 text-right" data-row="1"></td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                <input type="text" class="fcs form-control text-right custom-input" onkeyup="calculateRowTotal(1)" name="materials[1][deduction_rate]" id="materials_1_deduction_rate" data-row="1">
                                                </div>
                                            </td>
                                            <td class="subtotal_1 text-right" data-row="1"></td>
                                            <td class="text-center"></td>
                                            <input type="hidden" class="unit_id" name="materials[1][unit_id]"  id="materials_1_unit_id" data-row="1">
                                            <input type="hidden" class="net_unit_cost" name="materials[1][net_unit_cost]" id="materials_1_net_unit_cost" data-row="1">
                                            <input type="hidden" class="deduction_amount" name="materials[1][deduction_amount]" id="materials_1_deduction_amount" data-row="1">
                                            <input type="hidden" class="subtotal" name="materials[1][subtotal]" id="materials_1_subtotal" data-row="1">
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5" rowspan="4">
                                                <label  for="reason">Reason</label>
                                                <textarea class="form-control" name="reason" id="reason"></textarea><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-right font-weight-bolder"><b>Total</b></td>
                                            <td id="total-cost"  class="text-right font-weight-bolder">0.00</td>
                                            <td class="text-center"><button type="button" class="btn btn-success btn-sm add-product"><i class="fas fa-plus"></i></button></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right font-weight-bolder"><b>Total Deduction</b></td>
                                            <td id="total-deduction"  class="text-right font-weight-bolder">0.00</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right font-weight-bolder"><b>Grand Total</b></td>
                                            <td id="total"  class="text-right font-weight-bolder">0.00</td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="col-md-12">
                                <input type="hidden" name="item" id="item">
                                <input type="hidden" name="total_qty" id="total_qty">
                                <input type="hidden" name="total_cost" id="total_cost">
                                <input type="hidden" name="total_deduction" id="total_deduction">
                                <input type="hidden" name="grand_total" id="grand_total">
                            </div>
                            <div class="form-grou col-md-12 text-right pt-5">
                                <button type="button" class="btn btn-primary btn-sm mr-3" id="save-btn" onclick="save_data()">Return</button>
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
$(document).ready(function () {
    $('.date').datetimepicker({format: 'YYYY-MM-DD',ignoreReadonly: true});

    $('#save-btn').prop("disabled", true);
    $('input:checkbox').click(function () {
        if ($(this).is(':checked')) {
            $('#save-btn').prop("disabled", false);
        } else {
            if ($('.chk').filter(':checked').length < 1) {
                $('#save-btn').attr('disabled', true);
            }
        }
    });
});


function setProductDetails(row)
{
    let base_unit_id   = $(`#products_${row}_id option:selected`).data('baseunitid');
    let unit_id        = $(`#products_${row}_id option:selected`).data('unitid');
    let unit_name      = $(`#products_${row}_id option:selected`).data('unitname');
    let price          = parseFloat($(`#products_${row}_id option:selected`).data('price'));
    let sold_qty       = parseFloat($(`#products_${row}_id option:selected`).data('soldqty'));

    $(`.unit_name_${row}`).text(unit_name);
    $(`.net_unit_price_${row}`).text(parseFloat(price));
    $(`#products_${row}_base_unit_id`).val(base_unit_id);
    $(`#products_${row}_net_unit_price`).val(price);
    $(`#products_${row}_sold_qty`).val(sold_qty);
}

function calculateRowTotal(row)
{
    let price = parseFloat($(`#products_${row}_net_unit_price`).val());
    let return_qty = parseFloat($(`#products_${row}_return_qty`).val());
    let deduction_rate = $(`#products_${row}_deduction_rate`).val() ? parseFloat($(`#products_${row}_deduction_rate`).val()) : 0;

    if(return_qty <= 0 || return_qty == ''){
        return_qty = 0;
        $(`#products_${row}_return_qty`).val('');
    }
    var subtotal = return_qty * price;
    let deduction_amount = subtotal * (deduction_rate/100);
    subtotal = subtotal - deduction_amount;
    $(`.subtotal_${row}`).text(subtotal.toFixed(2));
    $(`#products_${row}_deduction_amount`).val(deduction_amount.toFixed(2));
    $(`#products_${row}_subtotal`).val(subtotal.toFixed(2));
    calculateTotal();
}

function calculateTotal()
{
    //sum of qty
    var total_qty = 0;
    $('.return_qty').each(function() {
        if($(this).val() == ''){
            total_qty += 0;
        }else{
            total_qty += parseFloat($(this).val());
        }
    });

    $('input[name="total_qty"]').val(total_qty.toFixed(2));

    //sum of subtotal
    var total_deusction = 0;
    $('.deduction_amount').each(function() {
        if($(this).val() == ''){
            total_deusction += 0;
        }else{
            total_deusction += parseFloat($(this).val());
        }
    });
    $('#total-deduction').text(total_deusction.toFixed(2));
    $('input[name="total_deduction"]').val(total_deusction.toFixed(2));

    var total = 0;
    $('.subtotal').each(function() {
        total += parseFloat($(this).val());
    });
    $('#total-price').text(total.toFixed(2));
    $('input[name="total_price"]').val(total.toFixed(2));

    var grand_total = total - total_deusction;
    $('#total').text(parseFloat(grand_total).toFixed(2));
    $('input[name="grand_total"]').val(parseFloat(grand_total).toFixed(2));

    var item = $('#product_table tbody tr:last').index()+1;
    $('input[name="item"]').val(item);
}

function save_data(){
    var rownumber = $('table#product_table tbody tr:last').index();
    if (rownumber < 0) {
        notification("error","Please insert material to return table!")
    }else{
        let form = document.getElementById('purchase_return_form');
        let formData = new FormData(form);
        let url = "{{route('purchase.return.store')}}";
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
                $('#purchase_return_form').find('.is-invalid').removeClass('is-invalid');
                $('#purchase_return_form').find('.error').remove();
                if (data.status == false) {
                    $.each(data.errors, function (key, value) {
                        var key = key.split('.').join('_');
                        $('#purchase_return_form input#' + key).addClass('is-invalid');
                        $('#purchase_return_form textarea#' + key).addClass('is-invalid');
                        $('#purchase_return_form select#' + key).parent().addClass('is-invalid');
                        $('#purchase_return_form #' + key).parent().append(
                            '<small class="error text-danger">' + value + '</small>');
                    });
                } else {
                    notification(data.status, data.message);
                    if (data.status == 'success') {
                        window.location.replace("{{ route('purchase.return') }}");
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