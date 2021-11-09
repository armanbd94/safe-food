@extends('layouts.app')

@section('title', $page_title)

@push('styles')
<link rel="stylesheet" href="css/jquery-ui.css" />
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
                    <a href="{{ route('finish.goods.stock') }}" class="btn btn-warning btn-sm font-weight-bolder"> 
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
                    <form action="" id="store_form" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="update_id" value="{{ $adjustment->id }}">
                        <input type="hidden" name="warehouse_id" value="{{ $adjustment->warehouse_id }}">
                        <div class="row">
                            <div class="form-group col-md-4 required">
                                <label for="adjustment_no">Adjustment No.</label>
                                <input type="text" class="form-control" name="adjustment_no" id="adjustment_no" value="{{ $adjustment->adjustment_no }}" readonly />
                            </div>

                            <div class="form-group col-md-4 required">
                                <label for="date">Date</label>
                                <input type="text" class="form-control date" name="date" id="date" value="{{ $adjustment->date }}"  readonly />
                            </div>

                            <div class="col-md-12">
                                <table class="table table-bordered" id="product_table">
                                    <thead class="bg-primary">
                                        <th width="35%">Name</th>
                                        <th width="10%" class="text-center">Unit</th>
                                        <th width="10%" class="text-center">Qty</th>
                                        <th width="10%" class="text-right">Net Unit Cost</th>
                                        <th width="10%" class="text-right">Sub Total</th>
                                        <th class="text-center"><i class="fas fa-trash text-white"></i></th>
                                    </thead>
                                    <tbody>
                                        @if (!$adjustment->products->isEmpty())
                                            @foreach ($adjustment->products as $key => $adjustment_product)
                                            <tr>
                                                @php
                                                    // $base_unit = DB::table('units')->find($adjustment_product->pivot->base_unit_id);
                                                    // $unit_name = $base_unit ? $base_unit->unit_name.' ('.$base_unit->unit_code.')' : '';
                                                @endphp
                                                <td class="col-md-3">                                                
                                                    <select name="products[{{ $key+1 }}][id]" id="products_{{ $key+1 }}_id" class="fcs col-md-12 form-control selectpicker" onchange="setProductDetails({{ $key+1 }})"  data-live-search="true" data-row="{{ $key+1 }}">
                                                    @if (!$products->isEmpty())
                                                    <option value="">Please Select</option>
                                                    @foreach ($products as $product)
                                                        <option {{ $adjustment_product->id != $product->id ?: 'selected' }} value="{{ $product->id }}" data-unitid={{ $product->base_unit_id }}  data-unitname="{{ $product->unit_name }}" >{{ $product->name }}</option>
                                                    @endforeach
                                                    @endif
                                                    </select>
                                                </td>
                                                <td class="unit_name_{{ $key+1 }} text-center" data-row="{{ $key+1 }}">{{ $adjustment_product->base_unit->unit_name }}</td>
                                                <td><input type="text" class="fcs form-control base_unit_qty base_unit_qty_{{ $key+1 }} text-center" onkeyup="calculateRowTotal({{ $key+1 }})" value="{{ $adjustment_product->pivot->base_unit_qty }}" name="products[{{ $key+1 }}][base_unit_qty]" id="products_{{ $key+1 }}_base_unit_qty" data-row="{{ $key+1 }}"></td>
                                                <td><input type="text" class="form-control base_unit_cost base_unit_cost_{{ $key+1 }} text-center" onkeyup="calculateRowTotal({{ $key+1 }})" value="{{ $adjustment_product->pivot->base_unit_cost }}" name="products[{{ $key+1 }}][base_unit_cost]" id="products_{{ $key+1 }}_base_unit_cost" data-row="{{ $key+1 }}"></td>
                                                <td class="subtotal_{{ $key+1 }} text-right" data-row="{{ $key+1 }}">{{ number_format($adjustment_product->pivot->total_cost,2,'.','') }}</td>
                                                <td class="text-center">
                                                    @if ($key != 0)
                                                    <button type="button" class="btn btn-danger btn-md remove-product"><i class="fas fa-trash"></i></button>   
                                                    @endif
                                                </td>
                                                <input type="hidden" class="base_unit_id" name="products[{{ $key+1 }}][base_unit_id]"  id="products_{{ $key+1 }}_base_unit_id" data-row="{{ $key+1 }}"  value="{{ $adjustment_product->pivot->base_unit_id }}">
                                                <input type="hidden" class="subtotal" name="products[{{ $key+1 }}][subtotal]" id="products_{{ $key+1 }}_subtotal" data-row="{{ $key+1 }}" value="{{ number_format($adjustment_product->pivot->total_cost,2,'.','') }}">

                                            </tr>
                                            @endforeach 
                                        @endif
                                    </tbody>
                                    <tfoot class="bg-primary">
                                        <th colspan="2" class="font-weight-bolder">Total</th>
                                        <th id="total-qty" class="text-center font-weight-bolder">{{ $adjustment->total_qty }}</th>
                                        <th></th>
                                        <th id="total" class="text-right font-weight-bolder">{{ number_format($adjustment->total_cost,2,'.','') }}</th>
                                        <th class="text-center"><button type="button" class="btn btn-success btn-md add-product"><i class="fas fa-plus"></i></button></th>
                                    </tfoot>
                                </table>
                            </div>
                           
                           
                            <div class="form-group col-md-12">
                                <label for="shipping_cost">Note</label>
                                <textarea  class="form-control" name="note" id="note" cols="30" rows="3">{{ $adjustment->note }}</textarea>
                            </div>

                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <thead class="bg-primary">
                                        <th width="50%"><strong>Items</strong><span class="float-right" id="item">{{ $adjustment->item.'('.$adjustment->total_qty.')' }}</span></th>
                                        <th width="50%"><strong>Grand Total</strong><span class="float-right" id="total-cost">{{ number_format($adjustment->total_cost,2,'.','') }}</span></th>
                                    </thead>
                                </table>
                            </div>
                            <div class="col-md-12">
                                <input type="hidden" name="total_qty" value="{{ $adjustment->total_qty }}">
                                <input type="hidden" name="total_cost" value="{{ $adjustment->total_cost }}">
                                <input type="hidden" name="item" value="{{ $adjustment->item }}">
                            </div>
                            <div class="form-group col-md-12 text-center pt-5">
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
    $('.date').datetimepicker({format: 'YYYY-MM-DD',ignoreReadonly: true});
    var count = 1;
    @if (!$adjustment->products->isEmpty())
        count = "{{ count($adjustment->products) + 1 }}";
    @endif
    
    $('#product_table').on('click','.add-product',function(){
        if($('#products_1_id option:selected').val()){
            count++;
            product_row_add(count);
        }else{
            notification('error','Please select first row product!');
        }
    });   
    $('#product_table').on('click','.remove-product',function(){
        $(this).closest('tr').remove();
        calculateGrandTotal();
    });
    function product_row_add(count){
        var html =  `<tr>
                        <td class="col-md-3">                                                
                            <select name="products[${count}][id]" id="products_${count}_id" class="fcs col-md-12 form-control selectpicker" onchange="setProductDetails(${count})"  data-live-search="true" data-row="${count}">
                            @if (!$products->isEmpty())
                            <option value="">Please Select</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" data-unitid={{ $product->base_unit_id }}  data-unitname="{{ $product->unit_name }}" >{{ $product->name }}</option>
                            @endforeach
                            @endif
                            </select>
                        </td>
                        <td class="unit_name_${count} text-center" data-row="${count}"></td>
                        <td><input type="text" class="fcs form-control base_unit_qty base_unit_qty_${count} text-center" onkeyup="calculateRowTotal(${count})" name="products[${count}][base_unit_qty]" id="products_${count}_base_unit_qty" data-row="${count}"></td>
                        <td><input type="text" class="form-control base_unit_cost base_unit_cost_${count} text-center" onkeyup="calculateRowTotal(${count})" name="products[${count}][base_unit_cost]" id="products_${count}_base_unit_cost" data-row="${count}"></td>
                        <td class="subtotal_${count} text-right" data-row="${count}"></td>
                        <td class="text-center" data-row="${count}"><button type="button" class="btn btn-danger btn-md remove-product"><i class="fas fa-trash"></i></button></td>
                        <input type="hidden" class="base_unit_id" name="products[${count}][base_unit_id]"  id="products_${count}_base_unit_id" data-row="${count}">
                        <input type="hidden" class="subtotal" name="products[${count}][subtotal]" id="products_${count}_subtotal" data-row="${count}">
                    </tr>`
        $('#product_table tbody').append(html);
        $('#product_table .selectpicker').selectpicker();
    }
});

function calculateRowTotal(row){ 

let qty = parseFloat($(`#product_table .base_unit_qty_${row}`).val());
let cost = parseFloat($(`#product_table .base_unit_cost_${row}`).val());
if(!qty){qty = 0};
if(!cost){cost = 0};
if(qty < 0)
{
    notification('error','Quantity must be greater than 0');
    $(`#product_table .base_unit_qty_${row}`).val('');
    qty = 0;
}
if(cost < 0)
{
    notification('error','Quantity must be greater than 0');
    $(`#product_table .base_unit_cost_${row}`).val('');
    cost = 0;
}
console.log(qty,cost);
let subtotal = qty * cost;
console.log(subtotal);
$(`#product_table .subtotal_${row}`).text(parseFloat(subtotal).toFixed(2));
$(`#product_table #products_${row}_subtotal`).val(subtotal);
calculateGrandTotal();
}

function calculateGrandTotal()
{
//sum of qty
var total_qty = 0;
$('.base_unit_qty').each(function() {
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
$('#total-cost').text(total.toFixed(2));
$('input[name="total_cost"]').val(total.toFixed(2));

var item           = $('#product_table tbody tr:last').index();
item = ++item + '(' + total_qty + ')';
var total_qty      = parseFloat($('#total-qty').text());
$('#item').text(item);
$('input[name="item"]').val($('#product_table tbody tr:last').index()+1);


}
function setProductDetails(row)
{
let unit_id = $(`#products_${row}_id option:selected`).data('unitid');
let unit_name = $(`#products_${row}_id option:selected`).data('unitname');

$(`.unit_name_${row}`).text(unit_name);
$(`#products_${row}_base_unit_id`).val(unit_id);
}

function store_data(){
    var rownumber = $('table#product_table tbody tr:last').index();
    if (rownumber < 0) {
        notification("error","Please insert product to order table!")
    }else{
        let form = document.getElementById('store_form');
        let formData = new FormData(form);
        let url = "{{route('finish.goods.stock.update')}}";
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
                $('#store_form').find('.is-invalid').removeClass('is-invalid');
                $('#store_form').find('.error').remove();
                if (data.status == false) {
                    $.each(data.errors, function (key, value) {
                        var key = key.split('.').join('_');
                        $('#store_form input#' + key).addClass('is-invalid');
                        $('#store_form textarea#' + key).addClass('is-invalid');
                        $('#store_form select#' + key).parent().addClass('is-invalid');
                        $('#store_form #' + key).parent().append(
                            '<small class="error text-danger">' + value + '</small>');
                    });
                } else {
                    notification(data.status, data.message);
                    if (data.status == 'success') {
                        window.location.replace("{{ route('finish.goods.stock') }}");
                        
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