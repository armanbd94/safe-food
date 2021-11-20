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
                    <a href="{{ route('guest.gift') }}" class="btn btn-warning btn-sm font-weight-bolder"> 
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
                    <form action="" id="gift_store_form" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="gift_id" id="gift_id" >
                            <div class="form-group col-md-3 required">
                                <label for="voucher_no">Voucher No.</label>
                                <input type="text" class="fcs form-control" name="voucher_no" id="voucher_no" value="{{  $voucher_no }}"/>
                            </div>
                            <div class="form-group col-md-3 required">
                                <label for="date">Date</label>
                                <input type="text" class="fcs form-control date" name="date" id="date" value="{{ date('Y-m-d') }}" readonly />
                            </div>
                            <div class="form-group col-md-3 required">
                                <label for="guest_name">Guest Name</label>
                                <input type="text" class="fcs form-control" name="guest_name" id="guest_name" />
                            </div>
                            <div class="form-group col-md-3 required">
                                <label for="gift_from">Gift From</label>
                                <input type="text" class="fcs form-control" name="gift_from" id="gift_from" />
                            </div>


                            <div class="col-md-12 table-responsive">
                                <table class="table table-bordered" id="product_table">
                                    <thead class="bg-primary">
                                        <th>Name</th>
                                        <th class="text-center">Stock Qty</th>
                                        <th class="text-center">Piece Qty</th>
                                        <th class="text-center">Carton Size</th>
                                        <th class="text-center"><i class="fas fa-trash text-white"></i></th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="col-md-3">                                                
                                                <select name="products[1][id]" id="products_1_id" class="fcs col-md-12 form-control selectpicker" onchange="setProductDetails(1)"  data-live-search="true" data-row="1">
                                                @if (!$products->isEmpty())
                                                <option value="">Please Select</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}" data-stockqty="{{ $product->base_unit_qty }}" data-unitname="{{ $product->unit->unit_name }}">{{ $product->name }}</option>
                                                @endforeach
                                                @endif
                                                </select>
                                            </td>
                                            <td class="stock_qty_1 text-center" data-row="1"></td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                <input type="text" class="fcs form-control qty text-center custom-input" onkeyup="calculateTotal()" name="products[1][qty]" id="products_1_qty" data-row="1">
                                                </div>
                                            </td>
                                            <td class="unit_name_1 text-center" data-row="1"></td>
                                           
                                            <td class="text-center"></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2" class="font-weight-bolder"></td>
                                            <td id="total-qty" class="text-center font-weight-bolder">0.00</td>
                                            <td></td>
                                            <td class="text-center"><button type="button" class="btn btn-success btn-md add-product"><i class="fas fa-plus"></i></button></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            

                            <div class="col-md-12">
                                <input type="hidden" name="item" id="item">
                                <input type="hidden" name="total_qty" id="total_qty">
                            </div>

                            <div class="form-grou col-md-12 text-center pt-5">
                                <button type="button" class="btn btn-danger btn-sm mr-3" onclick="window.location.replace('{{ route("guest.gift.add") }}');"><i class="fas fa-sync-alt"></i> Reset</button>
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
                            <option value="">Please Select</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" data-stockqty="{{ $product->base_unit_qty }}"  data-unitname="{{ $product->unit->unit_name }}">{{ $product->name }}</option>
                            @endforeach
                            @endif
                            </select>
                        </td>
                        <td class="stock_qty_${count} text-center" data-row="1"></td>
                        <td>
                            <div class="d-flex justify-content-center">
                            <input type="text" class="fcs form-control qty text-center custom-input" onkeyup="calculateTotal()" name="products[${count}][qty]" id="products_${count}_qty" data-row="${count}">
                            </div>
                        </td>
                        <td class="unit_name_${count} text-center" data-row="${count}"></td>
                        <td class="text-center"><button type="button" class="btn btn-danger btn-md remove-product"><i class="fas fa-trash"></i></button></td>
                    </tr>`;
        $('#product_table tbody').append(html);
        $('#product_table .selectpicker').selectpicker();
    } 

});

function setProductDetails(row)
{
    let unit_name = $(`#products_${row}_id option:selected`).data('unitname');
    let stock_qty = $(`#products_${row}_id option:selected`).data('stockqty') ? parseFloat($(`#products_${row}_id option:selected`).data('stockqty')) : 0;
    $(`.unit_name_${row}`).text(unit_name);
    $(`.stock_qty_${row}`).text(stock_qty);
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

    var item = $('#product_table tbody tr:last').index()+1;
    $('input[name="item"]').val(item);

}



function store_data(){
    var rownumber = $('table#product_table tbody tr:last').index();
    if (rownumber < 0) {
        notification("error","Please insert product to order table!")
    }else{
        let form = document.getElementById('gift_store_form');
        let formData = new FormData(form);
        let url = "{{route('guest.gift.store')}}";
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
                $('#gift_store_form').find('.is-invalid').removeClass('is-invalid');
                $('#gift_store_form').find('.error').remove();
                if (data.status == false) {
                    $.each(data.errors, function (key, value) {
                        var key = key.split('.').join('_');
                        $('#gift_store_form input#' + key).addClass('is-invalid');
                        $('#gift_store_form textarea#' + key).addClass('is-invalid');
                        $('#gift_store_form select#' + key).parent().addClass('is-invalid');
                        $('#gift_store_form #' + key).parent().append(
                            '<small class="error text-danger">' + value + '</small>');
                    });
                } else {
                    notification(data.status, data.message);
                    if (data.status == 'success') {
                        window.location.replace("{{ url('guest-gift/details') }}/"+data.gift_id);
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