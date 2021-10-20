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
    .product-select-box,
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
                    <a href="{{ route('transfer') }}" class="btn btn-warning btn-sm font-weight-bolder"> 
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
                            <input type="hidden" name="update_id" id="update_id" value="{{ $transfer->id }}">
                            <div class="form-group col-md-3 required">
                                <label for="chalan_no">Chalan No.</label>
                                <input type="text" class="fcs form-control" name="chalan_no" id="chalan_no" value="{{  $transfer->chalan_no }}"/>
                            </div>
                            <div class="form-group col-md-3 required">
                                <label for="transfer_date">Transfer Date</label>
                                <input type="text" class="fcs form-control date" name="transfer_date" id="transfer_date" value="{{$transfer->transfer_date }}" readonly />
                            </div>
  
                            <div class="form-group col-md-3 required">
                                <label for="from_warehouse_id">From Warehouse</label>
                                <select class="fcs form-control" name="from_warehouse_id" id="from_warehouse_id">
                                    <option value="">Select Please</option>
                                    @if (!$warehouses->isEmpty())
                                    @foreach ($warehouses as $id => $name)
                                        <option value="{{ $id }}" {{ $transfer->from_warehouse_id != $id ?: 'selected' }}>{{ $name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group col-md-3 required">
                                <label for="to_warehouse_id">To Depo</label>
                                <select class="fcs form-control" name="to_warehouse_id" id="to_warehouse_id">
                                    <option value="">Select Please</option>
                                    @if (!$warehouses->isEmpty())
                                    @foreach ($warehouses as $id => $name)
                                        <option value="{{ $id }}" {{ $transfer->to_warehouse_id != $id ?: 'selected' }}>{{ $name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="col-md-12">
                                <table class="table table-bordered" id="product_table">
                                    <thead class="bg-primary">
                                        <th>Name</th>
                                        <th class="text-center">Code</th>
                                        <th class="text-center">Unit</th>
                                        <th class="text-center">Available Qty</th>
                                        <th class="text-center">Transfer Qty</th>
                                        <th class="text-right">Price</th>
                                        <th class="text-right">Tax</th>
                                        <th class="text-right">Subtotal</th>
                                        <th class="text-center"><i class="fas fa-trash text-white"></i></th>
                                    </thead>
                                    <tbody>
                                        @php
                                            $temp_unit_name = [];
                                            $temp_unit_operator = [];
                                            $temp_unit_operation_value = [];
                                        @endphp
                                        @if (!$transfer->transfer_products->isEmpty())
                                            @foreach ($transfer->transfer_products as $key => $transfer_product)
                                            <tr>
                                                @php
                                                    $tax = DB::table('taxes')->where('rate',$transfer_product->pivot->tax_rate)->first();

                                                    $units = DB::table('units')->where('base_unit',$transfer_product->pivot->unit_id)
                                                                                ->orWhere('id',$transfer_product->pivot->unit_id)
                                                                                ->get();
                                                    $warehouse_product = DB::table('warehouse_product')->where([
                                                                            ['warehouse_id', $transfer->from_warehouse_id],
                                                                            ['product_id',$transfer_product->pivot->product_id]
                                                                        ])->first();
                                                    $stock_qty = $transfer_product->pivot->qty + ($warehouse_product ? $warehouse_product->qty : 0);
                                                    
                                                    $unit_name            = [];
                                                    $unit_operator        = [];
                                                    $unit_operation_value = [];

                                                    if($units){
                                                        foreach ($units as $unit) {
                                                            if($transfer_product->pivot->transfer_unit_id == $unit->id)
                                                            {
                                                                array_unshift($unit_name,$unit->unit_name);
                                                                array_unshift($unit_operator,$unit->operator);
                                                                array_unshift($unit_operation_value,$unit->operation_value);
                                                            }else{
                                                                $unit_name           [] = $unit->unit_name;
                                                                $unit_operator       [] = $unit->operator;
                                                                $unit_operation_value[] = $unit->operation_value;
                                                            }
                                                        }

                                                        if($transfer_product->tax_method == 1){
                                                            $product_price = $transfer_product->pivot->price;
                                                        }else{
                                                            $product_price = $transfer_product->pivot->total / $transfer_product->pivot->qty;
                                                        }

                                                        if($unit_operator[0] == '*')
                                                        {
                                                            $product_price = $product_price * $unit_operation_value[0];
                                                        }else if($unit_operator[0] == '/')
                                                        {
                                                            $product_price = $product_price / $unit_operation_value[0];
                                                        }
                                                        
                                                        $temp_unit_name = $unit_name = implode(",",$unit_name).',';
                                                        $temp_unit_operator = $unit_operator = implode(",",$unit_operator).',';
                                                        $temp_unit_operation_value = $unit_operation_value = implode(",",$unit_operation_value).',';
                                                    }
                                                @endphp
                                                <td  data-row="{{ $key + 1 }}">{{ $transfer_product->name.' ('.$transfer_product->code.')' }}</td>
                                                <td class="product-code_tx_{{ $key + 1 }} text-center" id="products_code_{{ $key + 1 }}" data-row="{{ $key + 1 }}">{{ $transfer_product->code }}</td>
                                                <td class="unit-name_tx_{{ $key + 1 }} text-center" id="products_unit_{{ $key + 1 }}"  data-row="{{ $key + 1 }}"></td>
                                                <td class="available-qty_tx_{{ $key + 1 }} text-center" id="products_available_qty_{{ $key + 1 }}" data-row="{{ $key + 1 }}">{{ $stock_qty }}</td>
                                                <td><input type="text" class="form-control qty text-center" name="products[{{ $key + 1 }}][qty]" id="products_qty_{{ $key + 1 }}" value="{{ number_format($transfer_product->pivot->qty,2,'.','') }}" data-row="{{ $key + 1 }}"></td>
                                                <td><input type="text" readonly class="fcs text-right form-control net_unit_price" name="products[{{ $key + 1 }}][net_unit_price]" id="products_net_unit_price_{{ $key + 1 }}" value="{{ $product_price }}" data-row="{{ $key + 1 }}"></td>
                                                <td class="tax text-right" id="tax_tx_{{ $key + 1 }}" data-row="{{ $key + 1 }}">{{ number_format((float)$transfer_product->pivot->tax, 2, '.','') }}</td>
                                                <td class="sub-total text-right" id="sub_total_tx_{{ $key + 1 }}" data-row="{{ $key + 1 }}">{{ number_format((float)$transfer_product->pivot->total, 2, '.','') }}</td>
                                                
                                                <!-- <td class="text-center"><button type="button" class="btn btn-danger btn-md remove-product"><i class="fas fa-trash"></i></button></td> -->
                                                
                                                <input type="hidden" class="product-id_vl_{{ $key+1 }}" name="products[{{ $key + 1 }}][id]"  value="{{ $transfer_product->pivot->product_id }}" id="products_id_vl_{{ $key + 1 }}" data-row="{{ $key + 1 }}">
                                                <input type="hidden" class="product-code_vl_{{ $key+1 }}" name="products[{{ $key + 1 }}][code]" value="{{ $transfer_product->code }}" id="products_code_vl_{{ $key + 1 }}" data-row="{{ $key + 1 }}">
                                                <input type="hidden"   class="stock-qty_vl_{{ $key+1 }} form-control text-center" name="products[{{ $key+1 }}][stock_qty]"  value="{{ $stock_qty }}" id="products_stock_qty_{{ $key + 1 }}" data-row="{{ $key + 1 }}">
                                                <input type="hidden" class="transfer-unit_vl_{{ $key+1 }}" name="products[{{ $key+1 }}][unit]" value="{{ $unit_name }}" id="transfer_unit_vl_{{ $key + 1 }}" data-row="{{ $key + 1 }}">
                                                <input type="hidden" class="transfer-unit-operator_vl_{{ $key+1 }}"  value="{{ $unit_operator }}" id="transfer_unit_operator_vl_{{ $key + 1 }}" data-row="{{ $key + 1 }}">
                                                <input type="hidden" class="transfer-unit-operation-value_vl_{{ $key+1 }}"  value="{{ $unit_operation_value }}" id="transfer_unit_operation_value_vl_{{ $key + 1 }}" data-row="{{ $key + 1 }}">
                                                <input type="hidden" class="tax-rate" name="products[{{ $key+1 }}][tax_rate]" value="{{ $transfer_product->pivot->tax_rate }}" id="tax_rate_vl_{{ $key + 1 }}" data-row="{{ $key + 1 }}">
                                                @if ($tax)
                                                <input type="hidden" class="tax-name" value="{{ $tax->name }}" id="tax_name_vl_{{ $key + 1 }}" data-row="{{ $key + 1 }}">
                                                @else
                                                <input type="hidden" class="tax-name" value="No Tax" id="tax_name_vl_{{ $key + 1 }}" data-row="{{ $key + 1 }}">
                                                @endif
                                                <input type="hidden" class="tax-method" value="{{ $transfer_product->tax_method }}" id="tax_method_vl_{{ $key + 1 }}" data-row="{{ $key + 1 }}">
                                                <input type="hidden" class="tax-value" name="products[{{ $key+1 }}][tax]" value="{{ $transfer_product->pivot->tax }}" id="tax_value_vl_{{ $key + 1 }}" data-row="{{ $key + 1 }}">
                                                <input type="hidden" class="subtotal-value" name="products[{{ $key+1 }}][subtotal]" value="{{ $transfer_product->pivot->total }}" id="subtotal_value_vl_{{ $key + 1 }}" data-row="{{ $key + 1 }}">
                                            </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot class="bg-primary">
                                        <th colspan="4" class="font-weight-bolder">Total</th>
                                        <th id="total-qty" class="text-center font-weight-bolder">{{ $transfer->total_qty }}</th>
                                        <th></th>
                                        <th id="total-tax" class="text-right font-weight-bolder">{{ $transfer->total_tax }}</th>
                                        <th id="total" class="text-right font-weight-bolder">{{ $transfer->total_price }}</th>
                                        <th class="text-center"><button type="button" class="btn btn-success btn-md add-product"><i class="fas fa-plus"></i></button></th>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="col-md-12">
                                <div class="row justify-content-between">

                                    <div class="form-group col-md-3">
                                        <label for="shipping_cost">Shipping Cost</label>
                                        <input type="text" class="fcs form-control" value="{{ $transfer->shipping_cost }}" name="shipping_cost" id="shipping_cost"/>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="labor_cost">Labor Cost</label>
                                        <input type="text" class="fcs form-control" value="{{ $transfer->total_labor_cost }}" name="labor_cost" id="labor_cost"/>
                                    </div>

                                    <div class="form-group col-md-3 required">
                                        <label for="carried_by">Carried By</label>
                                        <input type="text" class="fcs form-control" value="{{ $transfer->carried_by }}" name="carried_by" id="carried_by">
                                    </div>

                                    <div class="form-group col-md-3 required">
                                        <label for="received_by">Received By</label>
                                        <input type="text" class="fcs form-control" value="{{ $transfer->received_by }}" name="received_by" id="received_by">
                                    </div>

                                </div>
                            </div>
                            
                            
                            <div class="form-group col-md-12">
                                <label for="shipping_cost">Note</label>
                                <textarea  class="fcs form-control" name="note" id="note" cols="30" rows="3">{{ $transfer->note }}</textarea>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <thead class="bg-primary">
                                        <th><strong>Items</strong><span class="float-right" id="item">{{ $transfer->item.'('.$transfer->total_qty.')' }}</span></th>
                                        <th><strong>Total</strong><span class="float-right" id="subtotal">{{ $transfer->total_price }}</span></th>
                                        <th><strong>Shipping Cost</strong><span class="float-right" id="shipping_total_cost">{{ $transfer->shipping_cost }}</span></th>
                                        <th><strong>Labor Cost</strong><span class="float-right" id="labor_total_cost">{{ $transfer->total_labor_cost }}</span></th>
                                        <th><strong>Grand Total</strong><span class="float-right" id="grand_total">{{ $transfer->grand_total }}</span></th>
                                    </thead>
                                </table>
                            </div>
                            <div class="col-md-12">
                                <input type="hidden" name="total_qty" value="{{ $transfer->total_qty }}">
                                <input type="hidden" name="total_tax" value="{{ $transfer->total_tax }}">
                                <input type="hidden" name="total_price" value="{{ $transfer->total_price }}">
                                <input type="hidden" name="item" value="{{ $transfer->item }}">
                                <input type="hidden" name="grand_total" value="{{ $transfer->grand_total }}">
                            </div>

                            <div class="form-grou col-md-12 text-center pt-5">
                                <button type="button" class="btn btn-danger btn-sm mr-3" onclick="window.location.replace('{{ route("transfer") }}');"><i class="fas fa-sync-alt"></i> Cancel</button>
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
   

    //$(document).fcs(".fcs");
    //array data depend on warehouse
    var product_array = [];
    var product_code  = [];
    var product_name  = [];
    var product_qty   = [];

    // array data with selection
    var product_price        = [];
    var tax_rate             = [];
    var tax_name             = [];
    var tax_method           = [];
    var unit_name            = [];
    var unit_operator        = [];
    var unit_operation_value = [];

    //temporary array
    var temp_unit_name            = [];
    var temp_unit_operator        = [];
    var temp_unit_operation_value = [];

    var rowindex;
    var customer_group_rate;
    var row_product_price;

$(document).ready(function () {
    $('.date').datetimepicker({format: 'YYYY-MM-DD',ignoreReadonly: true});

    var rownumber = $('#product_table tbody tr:last').index();

    for (rowindex = 0; rowindex <= rownumber; rowindex++) {
        
        product_price.push(parseFloat($('#product_table tbody tr:nth-child('+ (rowindex + 1) +')').find('.net_unit_price').val()));
        var quantity = parseFloat($('#product_table tbody tr:nth-child('+ (rowindex + 1) +')').find('.qty').val());
        product_qty.push(parseFloat($('#product_table tbody tr:nth-child('+ (rowindex + 1) +')').find('.stock-qty_vl_'+(rowindex + 1)).val()));
        tax_rate.push(parseFloat($('#product_table tbody tr:nth-child('+ (rowindex + 1) +')').find('.tax-rate').val()));
        tax_name.push($('#product_table tbody tr:nth-child('+ (rowindex + 1) +')').find('.tax-name').val());
        tax_method.push($('#product_table tbody tr:nth-child('+ (rowindex + 1) +')').find('.tax-method').val());
        temp_unit_name = $('#product_table tbody tr:nth-child('+ (rowindex + 1) +')').find('.transfer-unit_vl_'+(rowindex + 1)).val().split(',');
        unit_name.push($('#product_table tbody tr:nth-child('+ (rowindex + 1) +')').find('.transfer-unit_vl_'+(rowindex + 1)).val());
        unit_operator.push($('#product_table tbody tr:nth-child('+ (rowindex + 1) +')').find('.transfer-unit-operator_vl_'+(rowindex + 1)).val());
        unit_operation_value.push($('#product_table tbody tr:nth-child('+ (rowindex + 1) +')').find('.transfer-unit-operation-value_vl_'+(rowindex + 1)).val());
        $('#product_table tbody tr:nth-child('+ (rowindex + 1) +')').find('.transfer-unit_vl_'+(rowindex + 1)).val(temp_unit_name[0]);
        $('#product_table tbody tr:nth-child('+ (rowindex + 1) +')').find('.unit-name_vl_'+(rowindex + 1)).text(temp_unit_name[0]);
        $('#product_table tbody tr:nth-child('+ (rowindex + 1) +')').find('.unit-name_tx_'+(rowindex + 1)).text(temp_unit_name[0]);
    }
    console.log(temp_unit_name);

    //assigning value

    $('#item').text($('input[name="item"]').val() + '('+$('input[name="total_qty"]').val()+')');
    $('#subtotal').text(parseFloat($('input[name="total_price"]').val()).toFixed(2));

    $('#shipping_total_cost').text(parseFloat($('input[name="shipping_cost"]').val()).toFixed(2));
    if(!$('input[name="labor_cost"]').val())
    {
        $('input[name="labor_cost"]').val('0.00');
    }
    $('#labor_total_cost').text(parseFloat($('input[name="labor_cost"]').val()).toFixed(2));
    $('#grand_total').text(parseFloat($('input[name="grand_total"]').val()).toFixed(2));

    //Update product qty
    $('#product_table').on('keyup','.qty',function(){
        rowindex = $(this).closest('tr').index();
        let free_qty = $('#product_table tbody tr:nth-child('+(rowindex + 1)+') .free_qty').val();
        if(parseFloat($(this).val()) == ''){
            free_qty = 0;
        }
        if(parseFloat($(this).val()) < 1 && parseFloat($(this).val()) != ''){
            $('#product_table tbody tr:nth-child('+(rowindex + 1)+') .qty').val(1);
            notification('error','Qunatity can\'t be less than 1');
        }
        checkQuantity($(this).val(),true,free_qty,rowindex,input=2);
    });

    //Remove product from cart table
    $('#product_table').on('click','.remove-product',function(){
        rowindex = $(this).closest('tr').index();
        product_price.splice(rowindex,1);
        tax_rate.splice(rowindex,1);
        tax_name.splice(rowindex,1);
        tax_method.splice(rowindex,1);
        unit_name.splice(rowindex,1);
        unit_operator.splice(rowindex,1);
        unit_operation_value.splice(rowindex,1);
        $(this).closest('tr').remove();
        calculateTotal();
    });

    //Remove product from cart table
    @if (!$transfer->transfer_products->isEmpty())
    var count = {{ count($transfer->transfer_products) + 1 }};
    @else 
    var count = 1;
    @endif
    $('#product_table').on('click','.add-product',function(){
        count++;
        product_row_add(count);
    });    
    function product_row_add(count){
        var warehouse_id = document.getElementById('from_warehouse_id').value;
        if(warehouse_id){
            $.ajax({
                url: '{{ route("sale.warehouse.wise.products") }}',
                type: 'POST',
                data: {
                    _token:_token, warehouse_id: warehouse_id
                },
                success: function(data) {
                    console.log(data);
                    var newRow = $('<tr>');
                    var cols = '';
                    cols += `<td class="product-select-box"><select name="products[${count}][pro_id]" id="product_list_${count}" class="fcs selectpicker col-md-12  products-alls product_details_${count} form-control" onchange="getProductDetails(this,${count})" data-live-search="true" data-row="${count}">
                                ${data}
                                </select></td>`;
                    cols += `<td class="product-code_tx_${count} text-center" id="products_code_${count}" data-row="${count}"></td>`
                    cols += `<td class="unit-name_tx_${count} text-center" id="products_unit_${count}" data-row="${count}"></td>`;
                    cols += `<td class="available-qty_tx_${count} text-center" id="products_available_qty_${count}" data-row="${count}"></td>`;
                    cols += `<td><input type="text" class="fcs form-control qty text-center" name="products[${count}][qty]" id="products_qty_${count}" value="1" data-row="${count}"></td>`;
                    cols += `<td><input type="text" class="fcs text-right form-control net_unit_price" name="products[${count}][net_unit_price]" id="products_net_unit_price_${count}" data-row="${count}" readonly></td>`;
                    cols += `<td class="tax text-right" id="tax_tx_${count}" data-row="${count}"></td>`;
                    cols += `<td class="sub-total text-right" id="sub_total_tx_${count}" data-row="${count}"></td>`;
                    cols += `<td class="text-center" data-row="${count}"><button type="button" class="btn btn-danger btn-md remove-product"><i class="fas fa-trash"></i></button></td>`;
                    cols += `<input type="hidden" class="product-id_vl_${count}" name="products[${count}][id]" id="products_id_vl_${count}" data-row="${count}">`;
                    cols += `<input type="hidden" class="product-code_vl_${count}" name="products[${count}][code]" id="products_code_vl_${count}" data-row="${count}">`;
                    cols += `<input type="hidden" class="product-unit_vl_${count}" name="products[${count}][unit]" id="products_unit_vl_${count}">`;
                    cols += `<input type="hidden" class="stock-qty_vl_${count}" name="products[${count}][stock_qty]" id="products_stock_qty_${count}"  data-row="${count}">`;
                    cols += `<input type="hidden" class="tax-rate" name="products[${count}][tax_rate]" id="tax_rate_vl_${count}" data-row="${count}">`;
                    cols += `<input type="hidden" class="tax-value" name="products[${count}][tax]" id="tax_value_vl_${count}" data-row="${count}">`;
                    cols += `<input type="hidden" class="subtotal-value" name="products[${count}][subtotal]" id="subtotal_value_vl_${count}" data-row="${count}">`;

                    newRow.append(cols);
                    $('#product_table tbody').append(newRow);
                    $('#product_table .selectpicker').selectpicker();
                }
            });
        }else{
            notification('error','Please select from warehouse!');
        }
    } 
});
  
    function product_search(data,row) {
        rowindex = $('#product_list_'+row).closest('tr').index();
        var temp_data = $('#product_list_'+row).val();
        $.ajax({
            url: '{{ route("sale.product.search.with.id") }}',
            type: 'POST',
            data: {
                data: data,_token:_token,warehouse_id: document.getElementById('from_warehouse_id').value
            },
            success: function(data) {
                console.log(data);
                temp_unit_name = data.unit_name.split(',');
                $('#products_code_'+row).text(data.code);
                $('#products_unit_'+row).text(temp_unit_name[0]);
                $('#products_available_qty_'+row).text(data.qty);
                $('#products_net_unit_price_'+row).val(data.price);
                $('#tax_tx_'+row).text(data.tax_name);
                $('#products_id_vl_'+row).val(data.id);
                $('#products_code_vl_'+row).val(data.code);
                $('#products_unit_vl_'+row).val(temp_unit_name[0]);
                $('#products_stock_qty_'+row).val(data.qty);
                $('#tax_rate_vl_'+row).val(data.tax_rate);
                
                if(product_price[rowindex] == 'undefined'){
                    product_price.push(parseFloat(data.price));
                }else{
                    product_price[rowindex] = (parseFloat(data.price));
                }
                product_qty.push(data.qty);
                tax_rate.push(parseFloat(data.tax_rate));
                tax_name.push(data.tax_name);
                tax_method.push(data.tax_method);
                unit_name.push(data.unit_name);
                unit_operator.push(data.unit_operator);
                unit_operation_value.push(data.unit_operation_value);
                checkQuantity(1,true,0,rowindex,input=2);
            }
        });
        
    }
    function checkQuantity(sale_qty,flag,free_qty=0,rowindex,input=2){
            //alert(rowindex);

            //console.log(unit_operator);
            var operator = unit_operator[rowindex].split(',');
            var operation_value = unit_operation_value[rowindex].split(',');

            if(operator[0] == '*')
            {
                total_qty = sale_qty * operation_value[0];
            }else if(operator[0] == '/'){
                total_qty = sale_qty / operation_value[0];
            }
            if(parseFloat(total_qty) > parseFloat(product_qty[rowindex])){
                notification('error','Quantity exceed stock quantity');
                if(flag)
                {
                    sale_qty = sale_qty.substring(0,sale_qty.length - 1);
                    $('#product_table tbody tr:nth-child('+(rowindex + 1)+')').find('.qty').val(sale_qty);
                }else{
                    return;
                }
            }

            if(!flag)
            {
                $('#product_table tbody tr:nth-child('+(rowindex + 1)+')').find('.qty').val(sale_qty);
            }
            calculateProductData(sale_qty,rowindex,input);
    }

    function calculateProductData(quantity,rowindex,input=2){ 
        unitConversion(rowindex);

        $('#product_table tbody tr:nth-child('+(rowindex + 1)+')').find('.tax-rate').val(tax_rate[rowindex].toFixed(2));
        $('#product_table tbody tr:nth-child('+(rowindex + 1)+')').find('.unit-name').text(unit_name[rowindex].slice(0,unit_name[rowindex].indexOf(",")));

        if(tax_method[rowindex] == 1)
        {
            //alert(row_product_price);
            var net_unit_price = row_product_price - 0;
            var tax = net_unit_price * quantity * (tax_rate[rowindex]/100);
            var sub_total = (net_unit_price * quantity) + tax;
        }else{
            var sub_total_unit = row_product_price - 0;
            var net_unit_price = (100 / (100 + tax_rate[rowindex])) * sub_total_unit;
            var tax = (sub_total_unit - net_unit_price) * quantity;
            var sub_total = sub_total_unit * quantity;
        }

        $('#product_table tbody tr:nth-child('+(rowindex + 1)+')').find('td:nth-child(7)').text(tax.toFixed(2));
        $('#product_table tbody tr:nth-child('+(rowindex + 1)+')').find('.tax-value').val(tax.toFixed(2));
        $('#product_table tbody tr:nth-child('+(rowindex + 1)+')').find('td:nth-child(8)').text(sub_total.toFixed(2));
        $('#product_table tbody tr:nth-child('+(rowindex + 1)+')').find('.subtotal-value').val(sub_total.toFixed(2));

        calculateTotal();
    }

    function unitConversion(rowindex)
    {
        var row_unit_operator = unit_operator[rowindex].slice(0,unit_operator[rowindex].indexOf(','));
        var row_unit_operation_value = unit_operation_value[rowindex].slice(0,unit_operation_value[rowindex].indexOf(','));
        row_unit_operation_value = parseFloat(row_unit_operation_value);
        if(row_unit_operator == '*')
        {
            row_product_price = product_price[rowindex] * row_unit_operation_value;
        }else{
            row_product_price = product_price[rowindex] / row_unit_operation_value;
        }
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
        //sum of tax
        var total_tax = 0;
        $('.tax').each(function() {
            total_tax += parseFloat($(this).text());
        });
        $('#total-tax').text(total_tax.toFixed(2));
        $('input[name="total_tax"]').val(total_tax.toFixed(2));

        //sum of subtotal
        var total = 0;
        $('.sub-total').each(function() {
            total += parseFloat($(this).text());
        });
        $('#total').text(total.toFixed(2));
        $('input[name="total_price"]').val(total.toFixed(2));

        calculateGrandTotal();
    }
    function calculateGrandTotal()
    {
        var item           = $('#product_table tbody tr:last').index();
        var total_qty      = parseFloat($('#total-qty').text());
        var subtotal       = parseFloat($('#total').text());
        var shipping_cost  = parseFloat($('#shipping_cost').val());
        var labor_cost     = parseFloat($('#labor_cost').val());

        if(!shipping_cost){
            shipping_cost = 0.00;
        }
        if(!labor_cost){
            labor_cost = 0.00;
        }

        item = ++item + '(' + total_qty + ')';
        var grand_total = (subtotal + shipping_cost + labor_cost);
        $('#item').text(item);
        $('input[name="item"]').val($('#product_table tbody tr:last').index() + 1);
        $('#subtotal').text(subtotal.toFixed(2));
        $('#shipping_total_cost').text(shipping_cost.toFixed(2));
        $('#labor_total_cost').text(labor_cost.toFixed(2));
        $('#grand_total').text(grand_total.toFixed(2));
        $('input[name="grand_total"]').val(grand_total.toFixed(2));
    }


    $('input[name="shipping_cost"]').on('input',function(){
        calculateGrandTotal();
    });
    $('input[name="labor_cost"]').on('input',function(){
        calculateGrandTotal();
    });



function getProductDetails(value,rowindex){
    // alert($(value).val());
    product_search($(value).val(),rowindex);

}    
function loadProduct(warehouse_id=null,rowcount){

    $.ajax({
        url:"{{url('sale/product-select-search')}}",
        type: 'post',
        data: { _token: _token,warehouse_id:warehouse_id},
        success: function( data ) {
            var html = `<option value="">Select Please</option>`;
            $.each(data, function(key, value) {
                html += '<option value="'+ value.id +'">'+ value.label +'</option>';
            });

            $('#product_table #product_list_'+rowcount).empty().html(html);
            // $('#product_table .products-alls').selectpicker();
            $('#product_table #product_list_'+rowcount+'.selectpicker').selectpicker('refresh');
        },
        error: function (xhr, ajaxOption, thrownError) {
            console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr.responseText);
        }
    });
}

function store_data(){
    var rownumber = $('table#product_table tbody tr:last').index();
    if (rownumber < 0) {
        notification("error","Please insert product to order table!")
    }else{
        let form = document.getElementById('sale_store_form');
        let formData = new FormData(form);
        let url = "{{route('transfer.update')}}";
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
                        window.location.replace("{{ url('transfer') }}");
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