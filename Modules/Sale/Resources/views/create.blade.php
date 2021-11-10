@extends('layouts.app')

@section('title', $page_title)

@push('styles')
<link rel="stylesheet" href="css/jquery-ui.css" />
<link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
<style>
    .product-select-box .bootstrap-select{width:300px !important;}
    .table.table-bordered tfoot th, .table.table-bordered tfoot td{
        border: 1px solid #EBEDF3 !important;
    }
    .custom-input{width: 100px;};
</style>
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
                    <a href="{{ route('sale') }}" class="btn btn-warning btn-sm font-weight-bolder"> 
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
                    <form action="" id="sale_store_form" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="sale_id" id="sale_id" >
                            <input type="hidden" name="warehouse_id" id="warehouse_id" value="1">
                            <input type="hidden" name="depo_id" id="depo_id" >
                            <div class="form-group col-md-4 required">
                                <label for="memo_no">Memo No.</label>
                                <input type="text" class="fcs form-control" name="memo_no" id="memo_no" value="{{  $memo_no }}"/>
                            </div>
                            <div class="form-group col-md-4 required">
                                <label for="sale_date">Sale Date</label>
                                <input type="text" class="fcs form-control date" name="sale_date" id="sale_date" value="{{ date('Y-m-d') }}" readonly />
                            </div>
                            <div class="form-group col-md-4 required">
                                <label for="delivery_date">Delivery Date</label>
                                <input type="text" class="fcs form-control date" name="delivery_date" id="delivery_date" value="{{ date('Y-m-d') }}" readonly />
                            </div>
                            <div class="form-group col-md-4 required">
                                <label for="">Order Received From</label>
                                <select name="order_from" id="order_from" onchange="orderFrom(this.value)" class="form-control selectpicker">
                                    <option value="">Select Please</option>
                                    <option value="1">Depo Dealer</option>
                                    <option value="2">Direct Dealer</option>
                                </select>
                            </div>
                            <x-form.selectbox labelName="Dealer" name="depo_dealer_id" col="col-md-8 depo_dealer d-none" required="required" class="fcs selectpicker">
                                @if (!$dealers->isEmpty())
                                @foreach ($dealers as $value)
                                @if($value->type == 1)
                                <option value="{{ $value->id }}" data-commission="{{ $value->depo_commission_rate }}" data-depoid="{{ $value->depo_id }}" data-groupid="{{ $value->dealer_group_id }}">{{ $value->name.' - '.$value->mobile_no.' ('.$value->district_name.' - '.$value->area_name.')'  }}</option>
                                @endif
                                @endforeach
                                @endif
                            </x-form.selectbox>

                            <x-form.selectbox labelName="Dealer" name="direct_dealer_id" col="col-md-8 direct_dealer d-none" class="fcs selectpicker" required="required">
                                @if (!$dealers->isEmpty())
                                @foreach ($dealers as $value)
                                @if($value->type == 2)
                                <option value="{{ $value->id }}" data-commission="{{ $value->commission_rate }}" data-groupid="{{ $value->dealer_group_id }}">{{ $value->name.' - '.$value->mobile_no.' ('.$value->district_name.' - '.$value->area_name.')'  }}</option>
                                @endif
                                @endforeach
                                @endif
                            </x-form.selectbox>
                            

                            <div class="col-md-12 table-responsive">
                                <table class="table table-bordered" id="product_table">
                                    <thead class="bg-primary">
                                        <th>Name</th>
                                        <th class="text-center">Sale Unit</th>
                                        <th class="text-center">Carton Qty</th>
                                        <th class="text-center">Piece Qty</th>
                                        <th class="text-center">Free Qty</th>
                                        <th class="text-center">Carton Size</th>
                                        <th class="text-right">Per Piece Price</th>
                                        <th class="text-right">Subtotal</th>
                                        <th class="text-center"><i class="fas fa-trash text-white"></i></th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="col-md-3">                                                
                                                <select name="products[1][id]" id="products_1_id" class="fcs col-md-12 form-control selectpicker"  data-live-search="true" data-row="1">
                                                @if (!$products->isEmpty())
                                                <option value="0">Please Select</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}" data-baseunitid={{ $product->base_unit_id }}  data-baseunitname="{{ $product->base_unit->unit_name }}" 
                                                        data-unitid={{ $product->unit_id }}  data-unitname="{{ $product->unit->unit_name }}" 
                                                        data-unitoperator={{ $product->unit->operator }}  data-unitoperationvalue="{{ $product->unit->operation_value }}" 
                                                        @if (!$product->product_prices->isEmpty())
                                                            @foreach ($product->product_prices as $item)
                                                                {{ 'data-group'.$item->pivot->dealer_group_id.'baseunitprice='.$item->pivot->base_unit_price.' ' }}
                                                            @endforeach
                                                        @endif
                                                        >{{ $product->name }}</option>
                                                @endforeach
                                                @endif
                                                </select>
                                            </td>
                                            <td class="base_unit_name_1 text-center" data-row="1"></td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                <input type="text" class="fcs form-control unit_qty text-center custom-input" onkeyup="calculateRowTotal(this.value,1,1)" name="products[1][unit_qty]" id="products_1_unit_qty" data-row="1">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                <input type="text" class="fcs form-control qty text-center custom-input" onkeyup="calculateRowTotal(this.value,1,2)" name="products[1][qty]" id="products_1_qty" data-row="1">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                <input type="text" class="fcs form-control free_qty text-center custom-input" name="products[1][free_qty]" id="products_1_free_qty" data-row="1">
                                                </div>
                                            </td>
                                            <td class="unit_name_1 text-center" data-row="1"></td>
                                            <td class="net_unit_price_1 text-right" data-row="1"></td>
                                            <td class="subtotal_1 text-right" data-row="1"></td>
                                            <td class="text-center"></td>
                                            <input type="hidden" class="base_unit_id" name="products[1][base_unit_id]"  id="products_1_base_unit_id" data-row="1">
                                            <input type="hidden" class="unit_id" name="products[1][unit_id]"  id="products_1_unit_id" data-row="1">
                                            <input type="hidden" class="net_unit_price" name="products[1][net_unit_price]" id="products_1_net_unit_price" data-row="1">
                                            <input type="hidden" class="subtotal" name="products[1][subtotal]" id="products_1_subtotal" data-row="1">
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2" class="font-weight-bolder"></td>
                                            <td id="total-unit-qty" class="text-center font-weight-bolder">0.00</td>
                                            <td id="total-qty" class="text-center font-weight-bolder">0.00</td>
                                            <td id="total-free-qty" class="text-center font-weight-bolder">0.00</td>
                                            <td colspan="2" class="text-right font-weight-bolder">Grand Total</td>
                                            <td id="grand-total"  class="text-right font-weight-bolder">0.00</td>
                                            <td class="text-center"><button type="button" class="btn btn-success btn-md add-product"><i class="fas fa-plus"></i></button></td>
                                        </tr>
                                        <tr class="commission_row d-none">
                                            <td colspan="7" class="text-right font-weight-bolder" style="padding: 1rem 0.5rem !important;">Commission <span id="commission"></span></td>
                                            <td id="total-commission" class="text-right font-weight-bolder" style="padding: 1rem 0.5rem !important;">0.00</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" class="text-right font-weight-bolder" style="padding: 1rem 0.5rem !important;">Net Total</td>
                                            <td id="net-total" class="text-right font-weight-bolder" style="padding: 1rem 0.5rem !important;">0.00</td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            

                            <div class="col-md-12">
                                <input type="hidden" name="item" id="item">
                                <input type="hidden" name="total_unit_qty" id="total_unit_qty">
                                <input type="hidden" name="total_qty" id="total_qty">
                                <input type="hidden" name="total_free_qty" id="total_free_qty">
                                <input type="hidden" name="grand_total" id="grand_total">
                                <input type="hidden" name="total_commission" id="total_commission">
                                <input type="hidden" name="commission_rate" id="commission_rate" value="0">
                                <input type="hidden" name="net_total" id="net_total">
                            </div>

                            <div class="form-grou col-md-12 text-center pt-5">
                                <button type="button" class="btn btn-danger btn-sm mr-3" onclick="window.location.replace('{{ route("sale.add") }}');"><i class="fas fa-sync-alt"></i> Reset</button>
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
<script src="js/jquery-ui.js"></script>
<script src="js/moment.js"></script>
<script src="js/bootstrap-datetimepicker.min.js"></script>
<script>    
$("input,select,textarea").bind("keydown", function (e) {
    var keyCode = e.keyCode || e.which;
    if(keyCode == 13) {
        e.preventDefault();
        $('input, select, textarea')
        [$('input,select,textarea').index(this)+1].focus();
    }
});
   

$(document).ready(function () {
    $('.date').datetimepicker({format: 'YYYY-MM-DD',ignoreReadonly: true});

    //Get customer group rate for special price
    $('#products_1_id').on('change',function(){
        let order_from = document.getElementById('order_from').value;
        if(order_from)
        {
            if(order_from == 1)
            {
                let depo_dealer_id = document.getElementById('depo_dealer_id').value;
                if(depo_dealer_id)
                {
                    setProductDetails(1);
                }else{
                    $('#products_1_id').val('');
                    $('#products_1_id.selectpicker').selectpicker('refresh');
                    notification('error','Please at first select dealer!');
                }
            }else if(order_from == 2)
            {
                let direct_dealer_id = document.getElementById('direct_dealer_id').value;
                if(direct_dealer_id)
                {
                    setProductDetails(1);
                }else{
                    $('#products_1_id').val('');
                    $('#products_1_id.selectpicker').selectpicker('refresh');
                    notification('error','Please at first select dealer!');
                }
            }
        }else{
            $('#products_1_id').val('');
            $('#products_1_id.selectpicker').selectpicker('refresh');
            notification('error','Please at first select order received from!');
        }
    });



    //Remove product from cart table
    $('#product_table').on('click','.remove-product',function(){
        $(this).closest('tr').remove();
        calculateTotal();
    });

    //Remove product from cart table
    var count = 1;
    $('#product_table').on('click','.add-product',function(){
        if($('#products_1_id option:selected').val()){
            count++;
            product_row_add(count);
        }else{
            notification('error','Please select first row product!');
        }
    });    
    function product_row_add(count){
        var html =  `<tr>
                        <td class="col-md-3">                                                
                            <select name="products[${count}][id]" id="products_${count}_id" class="fcs col-md-12 form-control selectpicker" onchange="setProductDetails(${count})"  data-live-search="true" data-row="${count}">
                            @if (!$products->isEmpty())
                            <option value="0">Please Select</option>
                            @foreach ($products as $product)
                            <option value="{{ $product->id }}"
                                                        data-baseunitid={{ $product->base_unit_id }}  data-baseunitname="{{ $product->base_unit->unit_name }}" 
                                                        data-unitid={{ $product->unit_id }}  data-unitname="{{ $product->unit->unit_name }}" 
                                                        data-unitoperator={{ $product->unit->operator }}  data-unitoperationvalue="{{ $product->unit->operation_value }}" 
                                                        @if (!$product->product_prices->isEmpty())
                                                            @foreach ($product->product_prices as $item)
                                                                {{ 'data-group'.$item->pivot->dealer_group_id.'baseunitprice='.$item->pivot->base_unit_price.' ' }}
                                                            @endforeach
                                                        @endif
                                                        >{{ $product->name }}</option>
                            @endforeach
                            @endif
                            </select>
                        </td>
                        <td class="base_unit_name_${count} text-center" data-row="${count}"></td>
                        <td>
                            <div class="d-flex justify-content-center">
                            <input type="text" class="fcs form-control unit_qty text-center custom-input" onkeyup="calculateRowTotal(this.value,${count},1)" name="products[${count}][unit_qty]" id="products_${count}_unit_qty" data-row="${count}">
                            </div>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center">
                            <input type="text" class="fcs form-control qty text-center custom-input" onkeyup="calculateRowTotal(this.value,${count},2)" name="products[${count}][qty]" id="products_${count}_qty" data-row="${count}">
                            </div>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center">
                            <input type="text" class="fcs form-control free_qty text-center custom-input" name="products[${count}][free_qty]" id="products_${count}_free_qty" data-row="${count}">
                            </div>
                        </td>
                        <td class="unit_name_${count} text-center" data-row="${count}"></td>
                        <td class="net_unit_price_${count} text-right" data-row="${count}"></td>
                        <td class="subtotal_${count} text-right" data-row="${count}"></td>
                        <td class="text-center" data-row="${count}"><button type="button" class="btn btn-danger btn-md remove-product"><i class="fas fa-trash"></i></button></td>
                        <input type="hidden" class="base_unit_id" name="products[${count}][base_unit_id]"  id="products_${count}_base_unit_id" data-row="${count}">
                        <input type="hidden" class="unit_id" name="products[${count}][unit_id]"  id="products_${count}_unit_id" data-row="${count}">
                        <input type="hidden" class="stock_qty" name="products[${count}][stock_qty]" id="products_${count}_stock_qty"  data-row="${count}">
                        <input type="hidden" class="net_unit_price" name="products[${count}][net_unit_price]" id="products_${count}_net_unit_price" data-row="${count}">
                        <input type="hidden" class="subtotal" name="products[${count}][subtotal]" id="products_${count}_subtotal" data-row="${count}">
                    </tr>`;
        $('#product_table tbody').append(html);
        $('#product_table .selectpicker').selectpicker();
    } 

    $('#depo_dealer_id').on('change',function(){
        let commission_rate = $('#depo_dealer_id option:selected').data('commission');
        $('#depo_id').val($('#depo_dealer_id option:selected').data('depoid'));
        if (commission_rate) {
            $('.commission_row').removeClass('d-none');
            $('#commission').text(`(${commission_rate}%)`);
            commission_rate > 0 ? $('#commission_rate').val(parseFloat(commission_rate)) : $('#commission_rate').val(0);
        } else {
            $('.commission_row').addClass('d-none');
            $('#commission_rate').val(0);
            $('#commission').text('');
        }
    });
    $('#direct_dealer_id').on('change',function(){
        let commission_rate = $('#direct_dealer_id option:selected').data('commission');
        $('#depo_id').val('');
        if (commission_rate) {
            $('.commission_row').removeClass('d-none');
            $('#commission').text(`(${commission_rate}%)`);
            commission_rate > 0 ? $('#commission_rate').val(parseFloat(commission_rate)) : $('#commission_rate').val(0);
        } else {
            $('.commission_row').addClass('d-none');
            $('#commission_rate').val(0);
            $('#commission').text('');
        }
    });

    $(document).on('keyup','.free_qty',function(){
        var total_free_qty = 0;
        $('.free_qty').each(function() {
            if($(this).val() == ''){
                total_free_qty += 0;
            }else{
                total_free_qty += parseFloat($(this).val());
            }
        });
        $('#total-free-qty').text(total_free_qty);
        $('input[name="total_free_qty"]').val(total_free_qty);
    });

});

function setProductDetails(row)
{
    let base_unit_id = $(`#products_${row}_id option:selected`).data('baseunitid');
    let unit_id = $(`#products_${row}_id option:selected`).data('unitid');
    let base_unit_name = $(`#products_${row}_id option:selected`).data('baseunitname');
    let unit_name = $(`#products_${row}_id option:selected`).data('unitname');
    let price = 0;
    let group_id = '';
    if($('#order_from option:selected').val() == 1)
    {
        group_id = $('#depo_dealer_id option:selected').data('groupid');
    }else{
        group_id = $('#direct_dealer_id option:selected').data('groupid');
    }
    price = parseFloat($(`#products_${row}_id option:selected`).data(`group${group_id}baseunitprice`));

    $(`.base_unit_name_${row}`).text(base_unit_name);
    $(`.unit_name_${row}`).text(unit_name);
    $(`.net_unit_price_${row}`).text(parseFloat(price));
    $(`#products_${row}_base_unit_id`).val(base_unit_id);
    $(`#products_${row}_unit_id`).val(unit_id);
    $(`#products_${row}_net_unit_price`).val(price);
}

function calculateRowTotal(qty,row,field)
{
    let price = parseFloat($(`#products_${row}_net_unit_price`).val());
    let operator = $(`#products_${row}_id option:selected`).data('unitoperator');
    let operation_value =  parseFloat($(`#products_${row}_id option:selected`).data('unitoperationvalue'));
    let unit_qty = 0;
    let base_unit_qty = 0;
    
   
    if(field == 1)
    {
        if(parseFloat(qty) < 1 || parseFloat(qty) == ''){
            qty = 1;
            $(`#products_${row}_unit_qty`).val(qty);
            calculateRowTotal(qty,row,1)
            notification('error','Carton Qunatity can\'t be less than 1');
        }
        if(operator == '*')
        {
            base_unit_qty = qty * operation_value;
        }else{
            base_unit_qty = qty / operation_value;
        }
        unit_qty = qty;
        $(`#products_${row}_qty`).val(base_unit_qty);
    }else{
        if(parseFloat(qty) < 1 || parseFloat(qty) == ''){
            qty = 1;
            $(`#products_${row}_qty`).val(qty);
            calculateRowTotal(qty,row,2)
            notification('error','Qunatity can\'t be less than 1');
        }
        if(operator == '*')
        {
            unit_qty = qty / operation_value;
        }else{
            unit_qty = qty * operation_value;
        }
        base_unit_qty = qty;
        $(`#products_${row}_unit_qty`).val(unit_qty.toFixed(2));
    }
    
    $(`.subtotal_${row}`).text(base_unit_qty * price);
    $(`#products_${row}_subtotal`).val(base_unit_qty * price);
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
    $('#total-qty').text(total_qty.toFixed(2));
    $('input[name="total_qty"]').val(total_qty.toFixed(2));

    var total_unit_qty = 0;
    $('.unit_qty').each(function() {
        if($(this).val() == ''){
            total_unit_qty += 0;
        }else{
            total_unit_qty += parseFloat($(this).val());
        }
    });
    $('#total-unit-qty').text(total_unit_qty.toFixed(2));
    $('input[name="total_unit_qty"]').val(total_unit_qty.toFixed(2));

    var total_free_qty = 0;
    $('.free_qty').each(function() {
        if($(this).val() == ''){
            total_free_qty += 0;
        }else{
            total_free_qty += parseFloat($(this).val());
        }
    });
    $('#total-free-qty').text(total_free_qty.toFixed(2));
    $('input[name="total_free_qty"]').val(total_free_qty.toFixed(2));

    //sum of subtotal
    var total = 0;
    $('.subtotal').each(function() {
        total += parseFloat($(this).val());
    });
    $('#grand-total').text(total.toFixed(2));
    $('input[name="grand_total"]').val(total.toFixed(2));

    var item           = $('#product_table tbody tr:last').index()+1;
    $('input[name="item"]').val(item);
    calculateNetTotal();
}
function calculateNetTotal()
{
    
    var grand_total  = parseFloat($('#grand_total').val());
    
    var commission_rate = $('#commission_rate').val();
    if(!commission_rate){
        commission_rate = 0;
    }
    var total_commission = grand_total * (commission_rate/100);
    var net_total = grand_total - total_commission;

    $('#total-commission').text(total_commission.toFixed(2));
    $('#net-total').text(net_total.toFixed(2));

    $('input[name="total_commission"]').val(total_commission.toFixed(2));
    $('input[name="net_total"]').val(net_total.toFixed(2));
}

function orderFrom(value)
{
    if(value == 1){
        $('.depo_dealer').removeClass('d-none');
        $('.direct_dealer').addClass('d-none');
        $('#direct_dealer_id').val('');
        $('#direct_dealer_id.selectpicker').selectpicker('refresh');
    }else{
        $('.depo_dealer').addClass('d-none');
        $('#depo_dealer_id').val('');
        $('#depo_dealer_id.selectpicker').selectpicker('refresh');
        $('.direct_dealer').removeClass('d-none');
    }
    $('.commission_row').addClass('d-none');
    $('#commission_rate').val(0);
    $('#commission').text('');
    $('#previous_due').val(0);
}
function store_data(){
    var rownumber = $('table#product_table tbody tr:last').index();
    if (rownumber < 0) {
        notification("error","Please insert product to order table!")
    }else{
        let form = document.getElementById('sale_store_form');
        let formData = new FormData(form);
        let url = "{{route('sale.store')}}";
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
                $('#sale_store_form').find('.is-invalid').removeClass('is-invalid');
                $('#sale_store_form').find('.error').remove();
                if (data.status == false) {
                    $.each(data.errors, function (key, value) {
                        var key = key.split('.').join('_');
                        $('#sale_store_form input#' + key).addClass('is-invalid');
                        $('#sale_store_form textarea#' + key).addClass('is-invalid');
                        $('#sale_store_form select#' + key).parent().addClass('is-invalid');
                        $('#sale_store_form #' + key).parent().append(
                            '<small class="error text-danger">' + value + '</small>');
                    });
                } else {
                    notification(data.status, data.message);
                    if (data.status == 'success') {
                        window.location.replace("{{ url('sale/details') }}/"+data.sale_id);
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