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
                    <a href="{{ route('sale.return') }}" class="btn btn-warning btn-sm font-weight-bolder"> 
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
                    <form id="sale_update_form" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-3 required">
                                <label for="memo_no">Memo No.</label>
                                <input type="text" class="form-control bg-secondary" name="memo_no" value="{{ $sale->memo_no }}"  readonly />
                                <input type="hidden" class="form-control" name="sale_id" value="{{ $sale->id }}"  />
                                <input type="hidden" class="form-control" name="order_from" value="{{ $sale->order_from }}"  />
                                <input type="hidden" class="form-control" name="depo_id" value="{{ $sale->depo_id }}"  />
                                <input type="hidden" class="form-control" name="dealer_id" value="{{ $sale->dealer_id }}"  />
                            </div>
                            <div class="form-group col-md-3 required">
                                <label for="sale_date">Delivery Date</label>
                                <input type="text" class="form-control bg-secondary" value="{{ $sale->delivery_date }}" readonly />
                            </div>
                            <div class="form-group col-md-3 required">
                                <label for="return_date">Return Date</label>
                                <input type="text" class="form-control date" name="return_date" id="return_date" value="{{ date('Y-m-d') }}" readonly />
                            </div>
                            <div class="form-group col-md-3 required">
                                <label>Order Received From</label>
                                <input type="text" class="form-control bg-secondary" value="{{ $sale->order_from == 1 ? 'Depo Dealer' : 'Direct Dealer' }}" readonly />
                            </div>

                            <div class="form-group col-md-3 required">
                                <label for="customer_name">Dealer Name</label>
                                <input type="text" class="form-control  bg-secondary" value="{{ $sale->dealer->name }}" readonly />
                            </div>
                            

                            <div class="col-md-12">
                                <table class="table table-bordered" id="product_table">
                                    <thead class="bg-primary">
                                        <th>Name</th>
                                        <th class="text-center">Carton Size</th>
                                        <th class="text-center">Sold Qty</th>
                                        <th class="text-center">Return Qty</th>
                                        <th class="text-right">Price</th>
                                        <th class="text-right">Deduction(%)</th>
                                        <th class="text-right">Subtotal</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="col-md-3">                                                
                                                <select name="products[1][id]" id="products_1_id" class="fcs col-md-12 form-control selectpicker" onchange="setProductDetails(1)"  data-live-search="true" data-row="1">
                                                @if (!$sale->sale_products->isEmpty())
                                                <option value="">Please Select</option>
                                                @foreach ($sale->sale_products as $key => $product)
                                                    @php
                                                         $return_qty = DB::table('sale_return_products as sp')
                                                        ->join('sale_returns as sr','sp.sale_return_id','=','sr.id')
                                                        ->where([['sp.product_id',$product->id],['sr.sale_id',$sale->id]])
                                                        ->sum('sp.return_qty');
                                                    @endphp
                                                    <option value="{{ $product->id }}" data-baseunitid={{ $product->base_unit_id }}  data-baseunitname="{{ $product->base_unit->unit_name }}" 
                                                        data-unitid={{ $product->unit_id }}  data-unitname="{{ $product->unit->unit_name }}" data-soldqty="{{ ($product->pivot->qty + ($product->pivot->free_qty ?? 0) - ($return_qty ?? 0)) }}" 
                                                        data-price="{{ $product->pivot->net_unit_price }}">{{ $product->name }}</option>
                                                @endforeach
                                                @endif
                                                </select>
                                            </td>
                                            <td class="unit_name_1 text-center" data-row="1"></td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                <input type="text" class="fcs form-control sold_qty text-center custom-input bg-secondary" name="products[1][sold_qty]" id="products_1_sold_qty" data-row="1" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                <input type="text" class="fcs form-control return_qty text-center custom-input" onkeyup="calculateRowTotal(1)" name="products[1][return_qty]" id="products_1_return_qty" data-row="1">
                                                </div>
                                            </td>
                                            <td class="net_unit_price_1 text-right" data-row="1"></td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                <input type="text" class="fcs form-control text-right custom-input" onkeyup="calculateRowTotal(1)" name="products[1][deduction_rate]" id="products_1_deduction_rate" data-row="1">
                                                </div>
                                            </td>
                                            <td class="subtotal_1 text-right" data-row="1"></td>
                                            <td class="text-center"></td>
                                            <input type="hidden" class="base_unit_id" name="products[1][base_unit_id]"  id="products_1_base_unit_id" data-row="1">
                                            <input type="hidden" class="net_unit_price" name="products[1][net_unit_price]" id="products_1_net_unit_price" data-row="1">
                                            <input type="hidden" class="deduction_amount" name="products[1][deduction_amount]" id="products_1_deduction_amount" data-row="1">
                                            <input type="hidden" class="subtotal" name="products[1][subtotal]" id="products_1_subtotal" data-row="1">
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
                                            <td id="total-price"  class="text-right font-weight-bolder">0.00</td>
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
                                <input type="hidden" name="total_price" id="total_price">
                                <input type="hidden" name="total_deduction" id="total_deduction">
                                <input type="hidden" name="grand_total" id="grand_total">
                            </div>
                            <div class="form-grou col-md-12 text-center pt-5">
                                <button type="button" class="btn btn-danger btn-sm mr-3" onclick="window.location.replace('{{ route("damage") }}');"><i class="fas fa-times-circle"></i> Cancel</button>
                                <button type="button" class="btn btn-primary btn-sm mr-3" id="save-btn" onclick="save_data()"><i class="fas fa-save"></i> Save Return</button>
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
        var html = ` <tr>
                        <td class="col-md-3">                                                
                            <select name="products[${count}][id]" id="products_${count}_id" class="fcs col-md-12 form-control selectpicker" onchange="setProductDetails(${count})"  data-live-search="true" data-row="${count}">
                            @if (!$sale->sale_products->isEmpty())
                            <option value="">Please Select</option>
                            @foreach ($sale->sale_products as $key => $product)
                                @php
                                        $return_qty = DB::table('sale_return_products as sp')
                                    ->join('sale_returns as sr','sp.sale_return_id','=','sr.id')
                                    ->where([['sp.product_id',$product->id],['sr.sale_id',$sale->id]])
                                    ->sum('sp.return_qty');
                                @endphp
                                <option value="{{ $product->id }}" data-baseunitid={{ $product->base_unit_id }}  data-baseunitname="{{ $product->base_unit->unit_name }}" 
                                    data-unitid={{ $product->unit_id }}  data-unitname="{{ $product->unit->unit_name }}" data-soldqty="{{ ($product->pivot->qty + ($product->pivot->free_qty ?? 0) - ($return_qty ?? 0)) }}" 
                                    data-price="{{ $product->pivot->net_unit_price }}">{{ $product->name }}</option>
                            @endforeach
                            @endif
                            </select>
                        </td>
                        <td class="unit_name_${count} text-center" data-row="${count}"></td>
                        <td>
                            <div class="d-flex justify-content-center">
                            <input type="text" class="fcs form-control sold_qty text-center custom-input bg-secondary" name="products[${count}][sold_qty]" id="products_${count}_sold_qty" data-row="${count}" readonly>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center">
                            <input type="text" class="fcs form-control return_qty text-center custom-input" onkeyup="calculateRowTotal(${count})" name="products[${count}][return_qty]" id="products_${count}_return_qty" data-row="${count}">
                            </div>
                        </td>
                        <td class="net_unit_price_${count} text-right" data-row="${count}"></td>
                        <td>
                            <div class="d-flex justify-content-center">
                            <input type="text" class="fcs form-control text-right custom-input" onkeyup="calculateRowTotal(${count})" name="products[${count}][deduction_rate]" id="products_${count}_deduction_rate" data-row="${count}">
                            </div>
                        </td>
                        <td class="subtotal_${count} text-right" data-row="${count}"></td>
                        <td class="text-center"><button type="button" class="btn btn-danger btn-md remove-product"><i class="fas fa-trash"></i></button></td>
                        <input type="hidden" class="base_unit_id" name="products[${count}][base_unit_id]"  id="products_${count}_base_unit_id" data-row="${count}">
                        <input type="hidden" class="net_unit_price" name="products[${count}][net_unit_price]" id="products_${count}_net_unit_price" data-row="${count}">
                        <input type="hidden" class="deduction_amount" name="products[${count}][deduction_amount]" id="products_${count}_deduction_amount" data-row="${count}">
                        <input type="hidden" class="subtotal" name="products[${count}][subtotal]" id="products_${count}_subtotal" data-row="${count}">
                    </tr>`;
        $('#product_table tbody').append(html);
        $('#product_table .selectpicker').selectpicker();
    }

    //Remove product from cart table
    $('#product_table').on('click','.remove-product',function(){
        $(this).closest('tr').remove();
        calculateTotal();
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
        notification("error","Please insert product to return table!")
    }else{
        let form = document.getElementById('sale_update_form');
        let formData = new FormData(form);
        let url = "{{route('sale.return.store')}}";
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
                $('#sale_update_form').find('.is-invalid').removeClass('is-invalid');
                $('#sale_update_form').find('.error').remove();
                if (data.status == false) {
                    $.each(data.errors, function (key, value) {
                        var key = key.split('.').join('_');
                        $('#sale_update_form input#' + key).addClass('is-invalid');
                        $('#sale_update_form textarea#' + key).addClass('is-invalid');
                        $('#sale_update_form select#' + key).parent().addClass('is-invalid');
                        $('#sale_update_form #' + key).parent().append(
                            '<small class="error text-danger">' + value + '</small>');
                    });
                } else {
                    notification(data.status, data.message);
                    if (data.status == 'success') {
                        window.location.replace("{{ route('sale.return') }}");
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