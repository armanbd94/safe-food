@extends('layouts.app')

@section('title', $page_title)

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
                    <a href="{{ route('product') }}" class="btn btn-warning btn-sm font-weight-bolder"> 
                        <i class="fas fa-arrow-left"></i> Back</a>
                    <!--end::Button-->
                </div>
            </div>
        </div>
        <!--end::Notice-->
        <!--begin::Card-->
        <div class="card card-custom" style="padding-bottom: 100px !important;">
            <div class="card-body">
                <form id="store_or_update_form" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-10">
                            <div class="row">
                                <input type="hidden" name="product_id" id="product_id">
                                <x-form.textbox labelName="Product Name" name="name" required="required" col="col-md-6" placeholder="Enter product name"/>
                                <x-form.selectbox labelName="Category" name="category_id" required="required" col="col-md-6" class="selectpicker">
                                    @if (!$categories->isEmpty())
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    @endif
                                </x-form.selectbox>
                                <x-form.selectbox labelName="Barcode Symbol" name="barcode_symbology" required="required" col="col-md-6" class="selectpicker">
                                    @foreach (BARCODE_SYMBOL as $key => $value)
                                        <option value="{{ $key }}" {{ ($key == 1) ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </x-form.selectbox> 
                                <div class="col-md-6 form-group required code">
                                    <label for="code">Barcode</label>
                                    <div class="input-group" id="code_section">
                                        <input type="text" class="form-control" name="code" id="code">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-primary" id="generate-code"  data-toggle="tooltip" data-theme="dark" title="Generate Code"
                                            style="border-top-right-radius: 0.42rem;border-bottom-right-radius: 0.42rem;border:0;cursor: pointer;">
                                                <i class="fas fa-retweet text-white"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-6 required">
                                    <label for="base_unit_id">Base Unit</label>
                                    <select name="base_unit_id" id="base_unit_id" onchange="populate_unit(this.value)" class="form-control selectpicker" data-live-search="true"  data-live-search-placeholder="Search">
                                        <option value="">Select Please</option>
                                        @if (!$units->isEmpty())
                                            @foreach ($units as $unit)
                                                @if ($unit->base_unit == null)
                                                <option value="{{ $unit->id }}">{{ $unit->unit_name.' ('.$unit->unit_code.')' }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
        
                                <div class="form-group col-md-6 required">
                                    <label for="unit_id">Unit</label>
                                    <select name="unit_id" id="unit_id" onchange="unit_price_calculation()"  class="form-control selectpicker" data-live-search="true"  data-live-search-placeholder="Search"></select>
                                </div>
        
                                {{-- <x-form.textbox labelName="Base Unit Price" name="base_unit_price" onkeyup="unitPriceCalculation()" required="required" col="col-md-6" />

                                <x-form.textbox labelName="Unit Price" name="unit_price" required="required" property="readonly" col="col-md-6" /> --}}
                                
                                <x-form.textbox labelName="Alert Quantity" name="alert_quantity"  col="col-md-6" />
        
                                <div class="col-md-6 form-group">
                                    <label for="tax_id">Product Tax</label>
                                    <select name="tax_id" id="tax_id" required="required" class="form-control selectpicker">
                                        <option value="0" selected>No Tax</option>
                                        @if (!$taxes->isEmpty())
                                            @foreach ($taxes as $tax)
                                                <option value="{{ $tax->id }}"  {{ isset($product) ? (($product->tax_id == $tax->id) ? 'selected' : '')  : '' }}>{{ $tax->name }}</option>
                                            @endforeach 
                                        @endif
                                    </select>
                                </div>
        
                                <div class="col-md-6 form-group">
                                    <label for="tax_method">Tax Method<span class="text-danger">*</span> <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top"
                                        data-theme="dark" title="Exclusive: Poduct price = Actual product price + Tax. Inclusive: Actual product price = Product price - Tax"></i></label>
                                    <select name="tax_method" id="tax_method" class="form-control selectpicker">
                                    @foreach (TAX_METHOD as $key => $value)
                                        <option value="{{ $key }}" 
                                       @if($key == 2){{ 'selected' }} @endif>{{ $value }}</option>
                                    @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 form-group required">
                                    <label for="has_opening_stock">Has opening stock?</label>
                                    <select name="has_opening_stock" id="has_opening_stock" class="form-control selectpicker" onchange="openingStockQty(this.value)">
                                        <option value="1">Yes</option>
                                        <option value="2" selected>No</option>
                                    </select>
                                </div>
                                <x-form.textbox labelName="Opening Stock Quantity" name="opening_stock_qty" col="col-md-6 opening_stock_qty d-none" required="required" placeholder="0"/>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="row">
                                <div class="form-group col-md-12 mb-0 text-center">
                                    <label for="logo" class="form-control-label">Product Image</label>
                                    <div class="col=md-12 px-0  text-center">
                                        <div id="image">
                        
                                        </div>
                                    </div>
                                    <div class="text-center"><span class="text-muted" style="font-size: 10px;">Maximum Allowed File Size 2MB and Format (png,jpg,jpeg,svg,webp)</span></div>
                                    <input type="hidden" name="old_image" id="old_image">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pt-5" id="material-section">
                            <div class="row" style="position: relative;border: 1px solid #E4E6EF;padding: 10px 0 0 0; margin: 0;border-radius:5px;">
                                <div style="width: 100px;background: #fa8c15;text-align: center;margin: 0 auto;color: white;padding: 5px 0;
                                    position: absolute;top:-16px;left:10px;"><i class="fas fa-coins text-white"></i> Price</div>
                                <div class="col-md-12 pt-5 material_section">
                                    @if (!$dealer_groups->isEmpty())
                                        @foreach ($dealer_groups as $key => $value)
                                        <div class="row">
                                            <div class="form-group col-md-4 required">
                                                @if($key == 0)<label for="prices_{{ $key+1 }}_base_unit_price" class="form-control-label">Group Name</label>@endif
                                                <input type="text" name="prices[{{ $key+1 }}][dealer_group_name]" id="prices_{{ $key+1 }}_dealer_group_name" class="form-control" value="{{ $value->group_name }}" readonly>
                                                <input type="hidden" name="prices[{{ $key+1 }}][dealer_group_id]"  value="{{ $value->id }}" id="prices_{{ $key+1 }}_dealer_group_id" class="form-control">
                                            </div>
                                            <div class="form-group col-md-4 required">
                                                @if($key == 0)<label for="prices_{{ $key+1 }}_base_unit_price" class="form-control-label">Base Unit Price</label>@endif
                                                <input type="text" name="prices[{{ $key+1 }}][base_unit_price]" id="prices_{{ $key+1 }}_base_unit_price" onkeyup="unitPriceCalculation({{ $key+1 }})" class="form-control base_price" data-key="{{ $key+1 }}">
                                            </div>
                                            <div class="form-group col-md-4 required">
                                                @if($key == 0)<label for="prices_{{ $key+1 }}_unit_price" class="form-control-label">Unit Price</label>@endif
                                                <input type="text" name="prices[{{ $key+1 }}][unit_price]" id="prices_{{ $key+1 }}_unit_price" class="form-control unit_price" readonly>
                                            </div>
                                        </div>
                                        @endforeach 
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-12 mt-5">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" id="description"></textarea>
                        </div>

                        <div class="form-group col-md-12 pt-5">
                            <button type="button" class="btn btn-primary btn-sm" id="save-btn-1" onclick="storeData(1)">Save</button>
                            <button type="button" class="btn btn-success btn-sm ml-3" id="save-btn-2" onclick="storeData(2)">Save & Add Another</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--end::Card-->
    </div>
</div>
@endsection

@push('scripts')
<script src="js/spartan-multi-image-picker.min.js"></script>
<script>
$(document).ready(function () {

    /** Start :: Product Image **/
    $("#image").spartanMultiImagePicker({
        fieldName:        'image',
        maxCount: 1,
        rowHeight:        '150px',
        groupClassName:   'col-md-12 col-sm-12 col-xs-12',
        maxFileSize:      '',
        dropFileLabel : "Drop Here",
        allowedExt: '',
        // onExtensionErr : function(index, file){
        //     Swal.fire({icon: 'error',title: 'Oops...',text: 'Only png,jpg,jpeg file format allowed!'});
        // },

    });

    $("input[name='image']").prop('required',true);

    $('.remove-files').on('click', function(){
        $(this).parents(".col-md-12").remove();
    });
    /** End :: Product Image **/


    //Generate Code
    $(document).on('click','#generate-code',function(){
        $.ajax({
            url: "{{ route('product.generate.code') }}",
            type: "GET",
            dataType: "JSON",
            beforeSend: function(){
                $('#generate-code').addClass('spinner spinner-white spinner-right');
            },
            complete: function(){
                $('#generate-code').removeClass('spinner spinner-white spinner-right');
            },
            success: function (data) {
                data ? $('#store_or_update_form #code').val(data) : $('#store_or_update_form #code').val('');
            },
            error: function (xhr, ajaxOption, thrownError) {
                console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr.responseText);
            }
        });
    });

});

function openingStockQty(value)
{
    value == 1 ? $('.opening_stock_qty').removeClass('d-none') : $('.opening_stock_qty').addClass('d-none');
}
function storeData(btn)
{
    let form = document.getElementById('store_or_update_form');
    let formData = new FormData(form);

    $.ajax({
        url: "{{route('product.store.or.update')}}",
        type: "POST",
        data: formData,
        dataType: "JSON",
        contentType: false,
        processData: false,
        cache: false,
        beforeSend: function(){
            $('#save-btn-'+btn).addClass('spinner spinner-white spinner-right');
        },
        complete: function(){
            $('#save-btn-'+btn).removeClass('spinner spinner-white spinner-right');
        },
        success: function (data) {
            $('#store_or_update_form').find('.is-invalid').removeClass('is-invalid');
            $('#store_or_update_form').find('.error').remove();
            if (data.status == false) {
                $.each(data.errors, function (key, value){
                    var key = key.split('.').join('_');
                    $('#store_or_update_form input#' + key).addClass('is-invalid');
                    $('#store_or_update_form textarea#' + key).addClass('is-invalid');
                    $('#store_or_update_form select#' + key).parent().addClass('is-invalid');
                    if(key == 'code'){
                        $('#store_or_update_form #' + key).parents('.form-group').append(
                        '<small class="error text-danger">' + value + '</small>');
                    }else{
                        $('#store_or_update_form #' + key).parent().append(
                        '<small class="error text-danger">' + value + '</small>');
                    }
                });
            } else {
                notification(data.status, data.message);
                if (data.status == 'success') {
                    if(btn == 1){
                        window.location.replace("{{ route('product') }}");
                    }else{
                        window.location.replace("{{ route('product.add') }}");
                    }
                }
            }
        },
        error: function (xhr, ajaxOption, thrownError) {
            console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr.responseText);
        }
    });
}
function populate_unit(unit_id)
{
    $.ajax({
        url:"{{ url('populate-unit') }}/"+unit_id,
        type:"GET",
        dataType:"JSON",
        success:function(data){
            var units = '';
            $.each(data, function(key, value) {
                units += '<option value="'+ key +'">'+ value +'</option>';
            });
            $('#unit_id').empty().append(units);
            $('#unit_id.selectpicker').selectpicker('refresh');
            $('.base_price,.unit_price').val('');
        },
    });
}

function unitPriceCalculation(key)
{
    let unit_id = document.getElementById('unit_id').value;
    let base_unit_price = document.getElementById(`prices_${key}_base_unit_price`).value;
    let unit_price = 0;
    if(unit_id)
    {
        $.ajax({
            url:"{{ url('unit-data') }}/"+unit_id,
            type:"GET",
            dataType:"JSON",
            success:function(data){
                if(data)
                {
                    if(data.operator == '*'){
                        unit_price =  (base_unit_price ? parseFloat(base_unit_price) : 0) * parseFloat(data.operation_value);
                    }else{
                        unit_price =  (base_unit_price ? parseFloat(base_unit_price) : 0) / parseFloat(data.operation_value);
                    }
                   
                }
                document.getElementById(`prices_${key}_unit_price`).value = parseFloat(unit_price).toFixed(2);
            },
        });
    }else{
        notification('error','Please select unit first!');
        document.getElementById(`prices_${key}_base_unit_price`).value = '';
    }
}

function unit_price_calculation()
{
    let unit_id = document.getElementById('unit_id').value;
    let base_unit_price = 0;
    let unit_price = 0;
    if(unit_id)
    {
        $.ajax({
            url:"{{ url('unit-data') }}/"+unit_id,
            type:"GET",
            dataType:"JSON",
            success:function(data){
                if(data)
                {
                    $('.base_price').each(function() {
                        var key = $(this).data('key');
                        if($(`#prices_${key}_base_unit_price`).val()){
                            base_unit_price = parseFloat($(`#prices_${key}_base_unit_price`).val());
                            if(data.operator == '*'){
                                unit_price =  (base_unit_price ? parseFloat(base_unit_price) : 0) * parseFloat(data.operation_value);
                            }else{
                                unit_price =  (base_unit_price ? parseFloat(base_unit_price) : 0) / parseFloat(data.operation_value);
                            }
                        }
                        document.getElementById(`prices_${key}_unit_price`).value = parseFloat(unit_price).toFixed(2);
                    }); 
                }
                
            },
        });
    }
    
    
}
</script>
@endpush