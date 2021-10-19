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
                        <input type="hidden" name="update_id">
                        <div class="row">
                            <div class="form-group col-md-4 required">
                                <label for="adjustment_no">Adjustment No.</label>
                                <input type="text" class="form-control" name="adjustment_no" id="adjustment_no" value="{{ $adjustment_no }}" readonly />
                            </div>

                            <x-form.selectbox labelName="Depo" name="warehouse_id" col="col-md-4" required="required" class="selectpicker">
                                @if (!$warehouses->isEmpty())
                                @foreach ($warehouses as $id => $name)
                                    <option value="{{ $id }}" {{ $id==1 ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                                @endif
                            </x-form.selectbox>

                            <div class="form-group col-md-12">
                                <label for="product_code_name">Select Product</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-barcode"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="product_code_name" id="product_code_name" placeholder="Please type product code and select...">
                                </div>
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
                                    </tbody>
                                    <tfoot class="bg-primary">
                                        <th colspan="2" class="font-weight-bolder">Total</th>
                                        <th id="total-qty" class="text-center font-weight-bolder">0</th>
                                        <th></th>
                                        <th id="total" class="text-right font-weight-bolder">0.00</th>
                                        <th></th>
                                    </tfoot>
                                </table>
                            </div>
                           
                           
                            <div class="form-group col-md-12">
                                <label for="shipping_cost">Note</label>
                                <textarea  class="form-control" name="note" id="note" cols="30" rows="3"></textarea>
                            </div>

                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <thead class="bg-primary">
                                        <th width="50%"><strong>Items</strong><span class="float-right" id="item">0.00</span></th>
                                        <th width="50%"><strong>Grand Total</strong><span class="float-right" id="total-cost">0.00</span></th>
                                    </thead>
                                </table>
                            </div>
                            <div class="col-md-12">
                                <input type="hidden" name="total_qty">
                                <input type="hidden" name="total_cost">
                                <input type="hidden" name="item">
                            </div>
                            <div class="form-group col-md-12 text-center pt-5">
                                <button type="button" class="btn btn-danger btn-sm mr-3"><i class="fas fa-sync-alt"></i> Reset</button>
                                <button type="button" class="btn btn-primary btn-sm mr-3" id="save-btn" onclick="store_data()"><i class="fas fa-save"></i> Submit</button>
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
<script>
$(document).ready(function () {


    $('#product_code_name').autocomplete({
        // source: "{{url('product-autocomplete-search')}}",
        source: function( request, response ) {
          // Fetch data
          $.ajax({
            url:"{{url('barcode/product-autocomplete-search')}}",
            type: 'post',
            dataType: "json",
            data: {
               _token: _token,
               search: request.term
            },
            success: function( data ) {
               response( data );
            }
          });
        },
        minLength: 3,
        response: function(event, ui) {
            if (ui.content.length == 1) {
                var data = ui.content[0].code;
                $(this).autocomplete( "close" );
                productSearch(data);
            };
        },
        select: function (event, ui) {
            // $('.product_search').val(ui.item.value);
            // $('.product_id').val(ui.item.id);
            var data = ui.item.code;
            productSearch(data);
        },
    }).data('ui-autocomplete')._renderItem = function (ul, item) {
        return $("<li class='ui-autocomplete-row'></li>")
            .data("item.autocomplete", item)
            .append(item.label)
            .appendTo(ul);
    };

    $('#product_table').on('click','.remove-product',function(){
        $(this).closest('tr').remove();
        calculateGrandTotal();
    });

    var count = 1;

    function productSearch(data) {
        $.ajax({
            url: '{{ route("barcode.search.product") }}',
            type: 'POST',
            data: {
                data: data,_token:_token
            },
            success: function(data) {
                var flag = 1;
                $('.product-code').each(function(i){
                    if($(this).val() == data.code){
                        notification('error','This product already added in table!');
                        flag = 0;
                    }
                });
                $('#product_code_name').val('');
                if(flag)
                {
                    var newRow = $(`<tr>`);
                    var cols = '';
                    cols += `<td>`+data.name+` (`+data.code+`)</td>`;
                    cols += `<td class="text-center">${data.base_unit_name}</td>`;
                    cols += `<td><input type="text" class="form-control base_unit_qty base_unit_qty_${count} text-center" onkeyup="calculateRowTotal(${count})" value="1" name="products[`+count+`][base_unit_qty]" id="products_`+count+`_base_unit_qty" data-row="${count}"></td>`;
                    cols += `<td><input type="text" class="form-control base_unit_cost base_unit_cost_${count} text-center" onkeyup="calculateRowTotal(${count})" value="0" name="products[`+count+`][base_unit_cost]" id="products_`+count+`_base_unit_cost" data-row="${count}"></td>`;
                    cols += `<td class="sub-total sub-total_${count} text-right" data-row="${count}"></td>`;
                    cols += `<td class="text-center"><button type="button" class="btn btn-danger btn-sm remove-product small-btn"><i class="fas fa-trash"></i></button></td>`;
                    
                    cols += `<input type="hidden" class="product-id product-id_${count}" name="products[`+count+`][id]" value="`+data.id+`" data-row="${count}">`;
                    cols += `<input type="hidden"  name="products[`+count+`][name]" value="`+data.name+`" data-row="${count}">`;
                    cols += `<input type="hidden" class="product-code product-code_${count}" name="products[`+count+`][code]" value="`+data.code+`" data-row="${count}">`;
                    cols += `<input type="hidden" class="product-unit product-unit_${count}" name="products[`+count+`][base_unit_id]" value="`+data.base_unit_id+`" data-row="${count}">`;
                    cols += `<input type="hidden" class="subtotal-value subtotal-value_${count}" name="products[`+count+`][subtotal]" data-row="${count}">`;
                    newRow.append(cols);
                    $('#product_table tbody').append(newRow);
                    calculateRowTotal(count);
                    count++;
                }
                
            }
        });
    }
});

function calculateRowTotal(row){ 

    let qty = parseFloat($(`#product_table .base_unit_qty_${row}`).val());
    let cost = parseFloat($(`#product_table .base_unit_cost_${row}`).val());
    if(qty == ''){qty = 0};
    if(cost == ''){cost = 0};
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
    $(`#product_table .sub-total_${row}`).text(parseFloat(subtotal).toFixed(2));
    $(`#product_table .subtotal-value_${row}`).val(subtotal);
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
    $('.subtotal-value').each(function() {
        total += parseFloat($(this).val());
    });
    $('#total').text(total.toFixed(2));
    $('#total-cost').text(total.toFixed(2));
    $('input[name="total_cost"]').val(total.toFixed(2));

    var item           = $('#product_table tbody tr:last').index();
    var total_qty      = parseFloat($('#total-qty').text());
    $('input[name="item"]').val(item);
    item = ++item + '(' + total_qty + ')';
    $('#item').text(item);
    

}


function store_data(){
    var rownumber = $('table#product_table tbody tr:last').index();
    if (rownumber < 0) {
        notification("error","Please insert product to order table!")
    }else{
        let form = document.getElementById('store_form');
        let formData = new FormData(form);
        let url = "{{route('finish.goods.stock.store')}}";
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