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
                    <a href="{{ route('material.stock.out') }}" class="btn btn-warning btn-sm font-weight-bolder"> 
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
                        <input type="hidden" name="update_id" value="{{ $stock_out->id }}">
                        <input type="hidden" name="warehouse_id" value="{{ $stock_out->warehouse_id }}">
                        <div class="row">
                            <div class="form-group col-md-4 required">
                                <label for="stock_out_no">Stock Out No.</label>
                                <input type="text" class="form-control bg-secondary" name="stock_out_no" id="stock_out_no" value="{{ $stock_out->stock_out_no }}" readonly />
                            </div>
                            <div class="form-group col-md-4 required">
                                <label for="date">Date</label>
                                <input type="text" class="form-control date" name="date" id="date" value="{{ $stock_out->date }}"  readonly />
                            </div>

                            {{-- <x-form.selectbox labelName="Warehouse" name="warehouse_id" col="col-md-4" required="required" class="selectpicker">
                                @if (!$warehouses->isEmpty())
                                @foreach ($warehouses as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                                @endif
                            </x-form.selectbox> --}}

                            <div class="col-md-12">
                                <table class="table table-bordered" id="material_table">
                                    <thead class="bg-primary">
                                        <th>Name</th>
                                        <th class="text-center">Batch No.</th>
                                        <th class="text-center">Unit</th>
                                        <th class="text-center">Available Qty</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-right">Rate</th>
                                        <th class="text-right">Sub Total</th>
                                        <th class="text-center"><i class="fas fa-trash text-white"></i></th>
                                    </thead>
                                    <tbody>
                                        @if (!$stock_out->materials->isEmpty())
                                            @foreach ($stock_out->materials as $key => $value)
                                            <tr>
                                                <td class="col-md-3">                                                  
                                                    <select name="materials[{{ $key+1 }}][id]" id="materials_{{ $key+1 }}_id" class="fcs col-md-12 selectpicker form-control" onchange="calculateRowTotal({{ $key+1 }})"  data-live-search="true" data-row="{{ $key+1 }}">                                            
                                                        @if (!$materials->isEmpty())
                                                            <option value="0">Please Select</option>
                                                        @foreach ($materials as $material)
                                                            @php 
                                                            $stock_qty = DB::table('stock_out_materials')->where(['stock_out_id'=>$value->stock_out_id,'material_id'=>$material->id])->value('qty'); 
                                                            if (!$stock_qty) {
                                                                $stock_qty = 0;
                                                            }
                                                            @endphp
                                                            <option value="{{ $material->id }}" {{ $value->material_id != $material->id ?: 'selected'  }} data-rate="{{ $material->cost }}" data-qty="{{ $material->qty + $stock_qty  }}" data-unitid="{{ $material->unit_id }}" data-unitname="{{ $material->unit_name }}">{{ $material->material_name.' ('.$material->material_code.')' }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                </td>   
                                                <td><input type="text" class="form-control batch_no text-center" value="{{ $value->batch_no }}" name="materials[{{ $key+1 }}][batch_no]" id="materials_{{ $key+1 }}_batch_no" data-row="{{ $key+1 }}"></td>
                                                <td class="text-center" id="materials_{{ $key+1 }}_unit_name">{{ $value->material->unit->unit_name }}</td>
                                                <td class="text-center" id="materials_{{ $key+1 }}_stockqty">{{ $value->material->qty + $value->qty }}</td>
                                                <td><input type="text" class="form-control qty text-center"  value="{{ $value->qty }}" onkeyup="calculateRowTotal({{ $key+1 }})" name="materials[{{ $key+1 }}][qty]" id="materials_{{ $key+1 }}_qty" data-row="{{ $key+1 }}"></td>
                                                <td class="text-right" id="materials_{{ $key+1 }}_cost">{{ $value->net_unit_cost }}</td>
                                                <td class="text-right" id="materials_{{ $key+1 }}_total">{{ $value->total }}</td>
                                                
                                                <td class="text-center">
                                                    @if($key != 0)
                                                    <button type="button" class="btn btn-danger btn-sm remove" data-toggle="tooltip" 
                                                    data-placement="top" data-original-title="Remove">
                                                    <i class="fas fa-minus-square"></i>
                                                    </button>
                                                    @endif
                                                </td>
                                                <input type="hidden" class="form-control unit_id text-center" value="{{ $value->unit_id }}" name="materials[{{ $key+1 }}][unit_id]" id="materials_{{ $key+1 }}_unit_id" data-row="{{ $key+1 }}">
                                                <input type="hidden" class="form-control stock_qty text-center"  value="{{ $value->material->qty + $value->qty }}" name="materials[{{ $key+1 }}][stock_qty]" id="materials_{{ $key+1 }}_stock_qty" data-row="{{ $key+1 }}">
                                                <input type="hidden" class="form-control net_unit_cost text-center" value="{{ $value->net_unit_cost }}" name="materials[{{ $key+1 }}][net_unit_cost]" id="materials_{{ $key+1 }}_net_unit_cost" data-row="{{ $key+1 }}">
                                                <input type="hidden" class="form-control subtotal text-center" value="{{ $value->total }}" name="materials[{{ $key+1 }}][subtotal]" id="materials_{{ $key+1 }}_subtotal" data-row="{{ $key+1 }}">
                                            </tr>
                                            @endforeach
                                        @endif
                                        
                                    </tbody>
                                    <tfoot class="bg-primary">
                                        <th colspan="4" class="font-weight-bolder">Total</th>
                                        <th id="total-qty" class="text-center font-weight-bolder">{{ $stock_out->total_qty }}</th>
                                        <th></th>
                                        <th id="total" class="text-right font-weight-bolder">{{ $stock_out->grand_total }}</th>
                                        <th class="text-center"><button type="button" class="btn btn-success btn-sm" id="add-material"><i class="fas fa-plus-square"></i></button></th>
                                    </tfoot>
                                </table>
                            </div>
                           
                           
                            <div class="form-group col-md-12">
                                <label for="shipping_cost">Note</label>
                                <textarea  class="form-control" name="note" id="note" cols="30" rows="3">{{ $stock_out->note }}</textarea>
                            </div>

                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <thead class="bg-primary">
                                        <th width="30%"><strong>Items</strong><span class="float-right" id="item">{{ $stock_out->item.'('.$stock_out->total_qty.')' }}</span></th>
                                        <th width="40%"></th>
                                        <th width="30%"><strong>Grand Total</strong><span class="float-right" id="grand_total">{{ number_format($stock_out->grand_total,2,'.','') }}</span></th>
                                    </thead>
                                </table>
                            </div>
                            <div class="col-md-12">
                                <input type="hidden" name="total_qty" value="{{ $stock_out->total_qty }}">
                                <input type="hidden" name="total_cost" value="{{ $stock_out->grand_total }}">
                                <input type="hidden" name="item" value="{{ $stock_out->item }}">
                                <input type="hidden" name="grand_total" value="{{ $stock_out->grand_total }}">
                            </div>
                            <div class="form-grou col-md-12 text-center pt-5">
                                <a href="{{ route('material.stock.out') }}"  class="btn btn-danger btn-sm mr-3"><i class="fas fa-sync-alt"></i> Cancel</a>
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
<script src="js/moment.js"></script>
<script src="js/bootstrap-datetimepicker.min.js"></script>
<script>
$(document).ready(function () {
    $('.date').datetimepicker({format: 'YYYY-MM-DD',ignoreReadonly: true});

    @if (!$stock_out->materials->isEmpty())
    var count = {{ count($stock_out->materials) + 1 }};
    @else
    var count = 1;
    @endif

    function material_row_add(row){
        var html = `<tr>
                        <td class="col-md-3">                                                  
                            <select name="materials[${row}][id]" id="materials_${row}_id" class="fcs col-md-12 selectpicker form-control" onchange="calculateRowTotal(${row})"  data-live-search="true" data-row="${row}">                                            
                                @if (!$materials->isEmpty())
                                    <option value="0">Please Select</option>
                                @foreach ($materials as $material)
                                @php 
                                $stock_qty = DB::table('stock_out_materials')->where(['stock_out_id'=>$stock_out->id,'material_id'=>$material->id])->value('qty'); 
                                if (!$stock_qty) {
                                    $stock_qty = 0;
                                }
                                @endphp
                                <option value="{{ $material->id }}" data-rate="{{ $material->cost }}" data-qty="{{ $material->qty + $stock_qty }}" data-unitid="{{ $material->unit_id }}" data-unitname="{{ $material->unit_name }}">{{ $material->material_name.' ('.$material->material_code.')' }}</option>
                                @endforeach
                                @endif
                            </select>
                        </td>   
                        <td><input type="text" class="form-control batch_no text-center" name="materials[${row}][batch_no]" id="materials_${row}_batch_no" data-row="${row}"></td>
                        <td class="text-center" id="materials_${row}_unit_name"></td>
                        <td class="text-center" id="materials_${row}_stockqty"></td>
                        <td><input type="text" class="form-control qty text-center" onkeyup="calculateRowTotal(${row})" name="materials[${row}][qty]" id="materials_${row}_qty" data-row="${row}"></td>
                        <td class="text-right" id="materials_${row}_cost"></td>
                        <td class="text-right" id="materials_${row}_total"></td>
                        <td class="text-center"><button type="button" class="btn btn-danger btn-sm remove" data-toggle="tooltip" 
                            data-placement="top" data-original-title="Remove">
                            <i class="fas fa-minus-square"></i>
                        </button>
                        </td>
                        <input type="hidden" class="form-control unit_id text-center" name="materials[${row}][unit_id]" id="materials_${row}_unit_id" data-row="${row}">
                        <input type="hidden" class="form-control stock_qty text-center" name="materials[${row}][stock_qty]" id="materials_${row}_stock_qty" data-row="${row}">
                        <input type="hidden" class="form-control net_unit_cost text-center" name="materials[${row}][net_unit_cost]" id="materials_${row}_net_unit_cost" data-row="${row}">
                        <input type="hidden" class="form-control subtotal text-center" name="materials[${row}][subtotal]" id="materials_${row}_subtotal" data-row="${row}">
                        
                        
                    </tr>`;
        $('#material_table').append(html);
        $('.selectpicker').selectpicker('refresh');
    }

    $(document).on('click','#add-material',function(){
        count++;
        material_row_add(count);
    });
    $(document).on('click','.remove',function(){
        count--;
        $(this).closest('tr').remove();
    });

});

function calculateRowTotal(row)
{
    let net_unit_cost = parseFloat($(`#materials_${row}_id option:selected`).data('rate'));
    let stock_qty     = parseFloat($(`#materials_${row}_id option:selected`).data('qty'));
    let unit_name     = $(`#materials_${row}_id option:selected`).data('unitname');
    let unit_id       = $(`#materials_${row}_id option:selected`).data('unitid');
    if(!net_unit_cost)
    {
        net_unit_cost = 0;
    }

    let qty = $(`#materials_${row}_qty`).val() ? parseFloat($(`#materials_${row}_qty`).val()) : 0;
    let subtotal = net_unit_cost * qty;

    $(`#materials_${row}_unit_name`).text(unit_name);
    $(`#materials_${row}_unit_id`).val(unit_id);
    $(`#materials_${row}_stockqty`).text(stock_qty);
    $(`#materials_${row}_stock_qty`).val(stock_qty);
    $(`#materials_${row}_cost`).text(net_unit_cost);
    $(`#materials_${row}_net_unit_cost`).val(net_unit_cost);
    $(`#materials_${row}_total`).text(subtotal);
    $(`#materials_${row}_subtotal`).val(subtotal);

    calculateGrandTotal()
}

function calculateGrandTotal()
{
    var total_qty = 0;
    $('#material_table .qty').each(function() {
        if($(this).val() == ''){
            total_qty += 0;
        }else{
            total_qty += parseFloat($(this).val());
        }
    });
    $('#total-qty').text(total_qty);
    $('input[name="total_qty"]').val(total_qty);

    var total = 0;
    $('.subtotal').each(function() {
        if($(this).val() == ''){
            total += 0;
        }else{
            total += parseFloat($(this).val());
        }
    });
    $('#total').text(total.toFixed(2));
    $('input[name="total_cost"]').val(total.toFixed(2));

    var item           = $('#material_table tbody tr:last').index();
    item = ++item + '(' + total_qty + ')';
    $('#item').text(item);
    $('input[name="item"]').val($('#material_table tbody tr:last').index() + 1);
    $('#grand_total').text(total.toFixed(2));
    $('input[name="grand_total"]').val(total.toFixed(2));
}

function store_data(){
    var rownumber = $('table#material_table tbody tr:last').index();
    if (rownumber < 0) {
        notification("error","Please insert material to order table!")
    }else{
        let form = document.getElementById('store_form');
        let formData = new FormData(form);
        let url = "{{route('material.stock.out.update')}}";
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
                        window.location.replace("{{ route('material.stock.out') }}");
                        
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