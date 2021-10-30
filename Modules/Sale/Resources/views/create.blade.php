@extends('layouts.app')

@section('title', $page_title)

@push('styles')
<link rel="stylesheet" href="css/jquery-ui.css" />
<link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
<style>
    .customer.table td{
        vertical-align: top !important;
        padding: 0 !important;
    }
    .product-select-box .bootstrap-select{width:300px !important;}
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
                                <label for="">Ordered By</label>
                                <select name="order_from" id="order_from" onchange="orderFrom(this.value)" class="form-control selectpicker">
                                    <option value="">Select Please</option>
                                    <option value="1">Depo</option>
                                    <option value="2">Direct Dealer</option>
                                </select>
                            </div>
                            <x-form.selectbox labelName="Depo" name="depo_id" col="col-md-4 depo d-none" required="required" class="fcs selectpicker">
                                @if (!$depos->isEmpty())
                                @foreach ($depos as $value)
                                <option value="{{ $value->id }}" data-commission="{{ $value->commission_rate }}">{{ $value->name.' - '.$value->mobile_no.' ('.$value->area_name.')' }}</option>
                                @endforeach
                                @endif
                            </x-form.selectbox>

                            <x-form.selectbox labelName="Dealer" name="dealer_id" col="col-md-4 dealer d-none" class="fcs selectpicker" onchange="getAreaList(this.value)">
                                @if (!$dealers->isEmpty())
                                @foreach ($dealers as $value)
                                <option value="{{ $value->id }}" data-commission="{{ $value->commission_rate }}">{{ $value->name.' - '.$value->mobile_no.' ('.$value->area_name.')'  }}</option>
                                @endforeach
                                @endif
                            </x-form.selectbox>
                            
                            <div class="form-group col-md-4">
                                <label for="document">Attach Document <i class="fas fa-info-circle" data-toggle="tooltip" data-theme="dark" title="Maximum Allowed File Size 5MB and Format (png,jpg,jpeg,svg,webp,pdf,csv,xlxs)"></i></label>
                                <input type="file" class="form-control fcs" name="document" id="document">
                            </div>

                            <div class="col-md-12">
                                <table class="table table-bordered" id="product_table">
                                    <thead class="bg-primary">
                                        <th>Name</th>
                                        <th class="text-center">Sale Unit</th>
                                        <th class="text-center">Available Qty</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-right">Price</th>
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
                                                    <option value="{{ $product->id }}" data-stockqty="{{ $product->qty ?? 0 }}" data-price="{{ $product->base_unit_price }}" data-unitid={{ $product->base_unit_id }}  data-unitname="{{ $product->unit_name }}" >{{ $product->name }}</option>
                                                @endforeach
                                                @endif
                                                </select>
                                            </td>
                                            <td class="unit_name_1 text-center" data-row="1"></td>
                                            <td class="stock_qty_1 text-center" data-row="1"></td>
                                            <td><input type="text" class="fcs form-control qty text-center" onkeyup="calculateRowTotal(this.value,1)" name="products[1][qty]" id="products_1_qty" data-row="1"></td>
                                            <td class="net_unit_price_1 text-right" data-row="1"></td>
                                            <td class="subtotal_1 text-right" data-row="1"></td>
                                            <td class="text-center"></td>
                                            <input type="hidden" class="sale_unit_id" name="products[1][sale_unit_id]"  id="products_1_sale_unit_id" data-row="1">
                                            <input type="hidden" class="stock_qty" name="products[1][stock_qty]" id="products_1_stock_qty"  data-row="1">
                                            <input type="hidden" class="net_unit_price" name="products[1][net_unit_price]" id="products_1_net_unit_price" data-row="1">
                                            <input type="hidden" class="subtotal" name="products[1][subtotal]" id="products_1_subtotal" data-row="1">
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="font-weight-bolder">Total</td>
                                            <td id="total-qty" class="text-center font-weight-bolder">0.00</td>
                                            <td></td>
                                            <td id="total" class="text-right font-weight-bolder">0.00</td>
                                            <td class="text-center"><button type="button" class="btn btn-success btn-md add-product"><i class="fas fa-plus"></i></button></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" rowspan="2">
                                                <div class="form-group col-md-12 mb-0">
                                                    <label for="shipping_cost">Note</label>
                                                    <textarea  class="fcs form-control" name="note" id="note" cols="30" rows="3"></textarea>
                                                </div>
                                            </td>
                                            <td class="text-right font-weight-bolder">Previous Due</td>
                                            <td><input type="text" class="fcs form-control text-right bg-secondary" name="previous_due" id="previous_due" placeholder="0.00" readonly></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right font-weight-bolder">Net Total</td>
                                            <td><input type="text" class="fcs form-control text-right bg-secondary" name="net_total" id="net_total" placeholder="0.00" readonly></td>
                                        </tr>
                                        <tr class="commission_row d-none">
                                            <td colspan="5" class="text-right font-weight-bolder">Commission <span id="commission"></span></td>
                                            <td>
                                                <input type="text" class="fcs form-control text-right bg-secondary" name="total_commission" id="total_commission" placeholder="0.00" readonly>
                                                <input type="hidden" class="fcs form-control" name="commission_rate" id="commission_rate" value="0" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">
                                                <div class="row">
                                                    <x-form.selectbox labelName="Payment Status" name="payment_status" required="required"  col="col-md-6 mb-0" class="fcs selectpicker">
                                                        @foreach (PAYMENT_STATUS as $key => $value)
                                                        <option value="{{ $key }}">{{ $value }}</option>
                                                        @endforeach
                                                    </x-form.selectbox>
                                                    <x-form.selectbox labelName="Payment Method" name="payment_method" onchange="account_list(this.value)" required="required"  col="col-md-6 payment_row d-none" class="selectpicker">
                                                        @foreach (SALE_PAYMENT_METHOD as $key => $value)
                                                        <option value="{{ $key }}">{{ $value }}</option>
                                                        @endforeach
                                                    </x-form.selectbox>
                                                </div>
                                            </td>
                                            <td class="text-right font-weight-bolder">Payable Amount</td>
                                            <td><input type="text" class="fcs form-control text-right bg-secondary" name="payable_amount" id="payable_amount" placeholder="0.00" readonly></td>
                                        </tr>
                                        <tr class="payment_row d-none">
                                            <td colspan="4" rowspan="2">
                                                <div class="row">
                                                    <x-form.selectbox labelName="Account" name="account_id" required="required"  col="col-md-6" class="fcs selectpicker"/>
                                                    <div class="form-group col-md-6 d-none reference_no">
                                                        <label for="reference_no">Reference No</label>
                                                        <input type="text" class="fcs form-control" name="reference_no" id="reference_no">
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-right font-weight-bolder">Paid Amount</td>
                                            <td>
                                                <div class="form-group mb-0">
                                                <input type="text" class="fcs form-control text-right" name="paid_amount" id="paid_amount" placeholder="0.00">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="payment_row d-none">
                                            <td class="text-right font-weight-bolder">Due Amount</td>
                                            <td><input type="text" class="fcs form-control bg-secondary text-right" name="due_amount" id="due_amount" placeholder="0.00" readonly></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            
                            
                            {{-- <div class="col-md-12">
                                <table class="table table-bordered">
                                    <thead class="bg-primary">
                                        <th><strong>Items</strong><span class="float-right" id="item">0(0)</span></th>
                                        <th><strong>Total</strong><span class="float-right" id="subtotal">0.00</span></th>
                                        <th><strong>Grand Total</strong><span class="float-right" id="grand_total">0.00</span></th>
                                        <th><strong>SR Commission</strong><span class="float-right" id="sr_commission">0.00</span></th>
                                    </thead>
                                </table>
                            </div> --}}
                            <div class="col-md-12">
                                <input type="hidden" name="total_qty">
                                <input type="hidden" name="total_price">
                                <input type="hidden" name="item">
                                <input type="hidden" name="grand_total">
                            </div>
                            {{-- <div class="payment col-md-12 d-none">
                                <div class="row">
                                    <div class="form-group col-md-4 required">
                                        <label for="previous_due">Previous Due</label>
                                        <input type="text" class="fcs form-control" name="previous_due" id="previous_due" readonly>
                                    </div>
                                    <div class="form-group col-md-4 required">
                                        <label for="net_total">Net Total</label>
                                        <input type="text" class="fcs form-control" name="net_total" id="net_total" readonly>
                                    </div>
                                    <div class="form-group col-md-4 required">
                                        <label for="paid_amount">Paid Amount</label>
                                        <input type="text" class="fcs form-control" name="paid_amount" id="paid_amount">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="due_amount">Due Amount</label>
                                        <input type="text" class="fcs form-control" name="due_amount" id="due_amount" readonly>
                                    </div>
                                    <x-form.selectbox labelName="Payment Method" name="payment_method" onchange="account_list(this.value)" required="required"  col="col-md-4" class="selectpicker">
                                        @foreach (SALE_PAYMENT_METHOD as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </x-form.selectbox>
                                    <x-form.selectbox labelName="Account" name="account_id" required="required"  col="col-md-4" class="fcs selectpicker"/>
                                    <div class="form-group required col-md-4 d-none reference_no">
                                        <label for="reference_no">Reference No</label>
                                        <input type="text" class="fcs form-control" name="reference_no" id="reference_no">
                                    </div>
                                </div>
                            </div> --}}

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
                let depo_id = document.getElementById('depo_id').value;
                if(depo_id)
                {
                    setProductDetails(1);
                }else{
                    $('#products_1_id').val('');
                    $('#products_1_id.selectpicker').selectpicker('refresh');
                    notification('error','Please at first select depo!');
                }
            }else if(order_from == 2)
            {
                let dealer_id = document.getElementById('dealer_id').value;
                if(dealer_id)
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
            notification('error','Please at first select order from!');
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
                                <option value="{{ $product->id }}" data-stockqty="{{ $product->qty ?? 0 }}" data-price="{{ $product->base_unit_price }}" data-unitid={{ $product->base_unit_id }}  data-unitname="{{ $product->unit_name }}" >{{ $product->name }}</option>
                            @endforeach
                            @endif
                            </select>
                        </td>
                        <td class="unit_name_${count} text-center" data-row="${count}"></td>
                        <td class="stock_qty_${count} text-center" data-row="${count}"></td>
                        <td><input type="text" class="fcs form-control qty text-center" onkeyup="calculateRowTotal(this.value,${count})" name="products[${count}][qty]" id="products_${count}_qty" data-row="${count}"></td>
                        <td class="net_unit_price_${count} text-right" data-row="${count}"></td>
                        <td class="subtotal_${count} text-right" data-row="${count}"></td>
                        <td class="text-center" data-row="${count}"><button type="button" class="btn btn-danger btn-md remove-product"><i class="fas fa-trash"></i></button></td>
                        <input type="hidden" class="sale_unit_id" name="products[${count}][sale_unit_id]"  id="products_${count}_sale_unit_id" data-row="${count}">
                        <input type="hidden" class="stock_qty" name="products[${count}][stock_qty]" id="products_${count}_stock_qty"  data-row="${count}">
                        <input type="hidden" class="net_unit_price" name="products[${count}][net_unit_price]" id="products_${count}_net_unit_price" data-row="${count}">
                        <input type="hidden" class="subtotal" name="products[${count}][subtotal]" id="products_${count}_subtotal" data-row="${count}">
                    </tr>`;
        $('#product_table tbody').append(html);
        $('#product_table .selectpicker').selectpicker();
    } 

    $('#depo_id').on('change',function(){
        let commission_rate = $('#depo_id option:selected').data('commission');
        if (commission_rate) {
            $('.commission_row').removeClass('d-none');
            $('#commission').text(`(${commission_rate}%)`);
            commission_rate > 0 ? $('#commission_rate').val(parseFloat(commission_rate)) : $('#commission_rate').val(0);
        } else {
            $('.commission_row').addClass('d-none');
            $('#commission_rate').val(0);
            $('#commission').text('');
        }
        $.get('{{ url("depo/previous-balance") }}/'+$('#depo_id option:selected').val(),function(data){
            console.log(data);
            $('#previous_due').val(parseFloat(data).toFixed(2));
        });
    });
    $('#deaaler_id').on('change',function(){
        let commission_rate = $('#deaaler_id option:selected').data('commission');
        if (commission_rate) {
            $('.commission_row').removeClass('d-none');
            $('#commission').text(`(${commission_rate}%)`);
            commission_rate > 0 ? $('#commission_rate').val(parseFloat(commission_rate)) : $('#commission_rate').val(0);
        } else {
            $('.commission_row').addClass('d-none');
            $('#commission_rate').val(0);
            $('#commission').text('');
        }
        $.get('{{ url("dealer/previous-balance") }}/'+$('#deaaler_id option:selected').val(),function(data){
            $('#previous_due').val(parseFloat(data).toFixed(2));
        });
    });
    $('#payment_status').on('change',function(){
        if($(this).val() != 3){
            $('.payment_row').removeClass('d-none');
        }else{
            $('#paid_amount').val(0);
            $('.payment_row').addClass('d-none');
        }
    });

    $('#payment_method').on('change',function(){
        if($(this).val() != 1){
            $('.reference_no').removeClass('d-none');
        }else{
            $('.reference_no').addClass('d-none');
        }
    });

    $('#paid_amount').on('input',function(){
        var payable_amount = parseFloat($('#payable_amount').val());
        var paid_amount = parseFloat($(this).val());
        
        if(paid_amount > payable_amount){
            $('#paid_amount').val(payable_amount.toFixed(2));
            paid_amount = payable_amount;
            notification('error','Paid amount cannot be bigger than payable amount');
        }
        $('#due_amount').val(parseFloat(payable_amount - paid_amount).toFixed(2));
        
    });
});

function setProductDetails(row)
{
    let unit_id = $(`#products_${row}_id option:selected`).data('unitid');
    let unit_name = $(`#products_${row}_id option:selected`).data('unitname');
    let price = $(`#products_${row}_id option:selected`).data('price');
    let stock_qty = $(`#products_${row}_id option:selected`).data('stockqty');

    $(`.unit_name_${row}`).text(unit_name);
    $(`.stock_qty_${row}`).text(stock_qty);
    $(`.net_unit_price_${row}`).text(parseFloat(price));
    $(`#products_${row}_sale_unit_id`).val(unit_id);
    $(`#products_${row}_stock_qty`).val(stock_qty);
    $(`#products_${row}_net_unit_price`).val(price);
}

function calculateRowTotal(qty,row)
{
    let price = parseFloat($(`#products_${row}_net_unit_price`).val());
    let stock_qty = $(`#products_${row}_stock_qty`).val() ? parseFloat($(`#products_${row}_stock_qty`).val()) : 0;
    if(parseFloat(qty) < 1 || parseFloat(qty) == ''){
        qty = 1;
        $(`#products_${row}_qty`).val(qty);
        $(`.subtotal_${row}`).text(qty * price);
        $(`#products_${row}_subtotal`).val(qty * price);
        notification('error','Qunatity can\'t be less than 1');
    }
    // else if(parseFloat(qty) > stock_qty)
    //     qty = stock_qty;
    //     $(`#products_${row}_qty`).val(qty);
    //     $(`.subtotal_${row}`).text(qty * price);
    //     $(`#products_${row}_subtotal`).val(qty * price);
    //     notification('error','Qunatity must be less than or equal to stock available quantity');
    // }
    else{
        $(`.subtotal_${row}`).text(qty * price);
        $(`#products_${row}_subtotal`).val(qty * price);
    }
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
    $('input[name="total_price"]').val(total.toFixed(2));

    var item           = $('#product_table tbody tr:last').index()+1;
    $('#item').text(item + '(' + total_qty + ')');
    $('input[name="item"]').val(item);
    calculateNetTotal();
}
function calculateNetTotal()
{
    
    var grand_total  = parseFloat($('#total').text());
    var previous_due = parseFloat($('#previous_due').val());
    var net_total = grand_total + previous_due;
    
    var commission_rate = $('#commission_rate').val();
    if(!commission_rate){
        commission_rate = 0;
    }
    var total_commission = grand_total * (commission_rate/100);
    var payable_amount = net_total - total_commission;

   
    $('input[name="grand_total"]').val(grand_total.toFixed(2));
    $('input[name="net_total"]').val(net_total.toFixed(2));
    $('input[name="total_commission"]').val(total_commission.toFixed(2));
    $('#payable_amount').val(payable_amount.toFixed(2));

    var paid_amount =parseFloat($('#paid_amount').val());
    if(!paid_amount)
    {
        paid_amount = 0;
    }
    // if($('#payment_status option:selected').val() == 1)
    // {
    //     $('#paid_amount').val(net_total.toFixed(2));
    //     $('#due_amount').val(parseFloat(0).toFixed(2));
    // }else if($('#payment_status option:selected').val() == 2){
    //     var paid_amount = $('#paid_amount').val();
    //     $('#due_amount').val(parseFloat(net_total-paid_amount).toFixed(2));
    // }else{
        $('#due_amount').val(parseFloat(payable_amount - paid_amount).toFixed(2));
    // }
}

function account_list(payment_method)
{
    $.ajax({
        url: "{{route('account.list')}}",
        type: "POST",
        data: { payment_method: payment_method,_token: _token},
        success: function (data) {
            $('#sale_store_form #account_id').empty().html(data);
            $('#sale_store_form #account_id.selectpicker').selectpicker('refresh');
        },
        error: function (xhr, ajaxOption, thrownError) {
            console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr.responseText);
        }
    });
}
function orderFrom(value)
{
    if(value == 1){
        $('.depo').removeClass('d-none');
        $('.dealer').addClass('d-none');
        $('#dealer_id').val('');
        $('#dealer_id.selectpicker').selectpicker('refresh');
    }else{
        $('.depo').addClass('d-none');
        $('#depo_id').val('');
        $('#depo_id.selectpicker').selectpicker('refresh');
        $('.dealer').removeClass('d-none');
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