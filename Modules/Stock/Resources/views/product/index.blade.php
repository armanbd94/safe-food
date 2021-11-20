@extends('layouts.app')

@section('title', $page_title)

@push('styles')
<link href="css/jquery-ui.css" rel="stylesheet" type="text/css" />
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
            </div>
        </div>
        <!--end::Notice-->
        <!--begin::Card-->
        <div class="card card-custom">
            <div class="card-header flex-wrap py-5">
                <form method="POST" id="form-filter" class="col-md-12 px-0">
                    <div class="row justify-content-center">
                        <x-form.selectbox labelName="Category" name="category_id" col="col-md-4" class="selectpicker">
                            <option value="0" selected>All Category</option>
                            @if (!$categories->isEmpty())
                            @foreach ($categories as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                            @endif
                        </x-form.selectbox>
                        <x-form.selectbox labelName="Product" name="product_id" col="col-md-4" class="selectpicker">
                            @if (!$products->isEmpty())
                            @foreach ($products as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                            @endif
                        </x-form.selectbox>
                        <div class="col-md-4">
                            <div style="margin-top:28px;">      
                                    <button id="btn-reset" class="btn btn-danger btn-sm btn-elevate btn-icon float-right" type="button"
                                    data-toggle="tooltip" data-theme="dark" title="Reset">
                                    <i class="fas fa-undo-alt"></i></button>
    
                                    <button id="btn-filter" class="btn btn-primary btn-sm btn-elevate btn-icon mr-2 float-right" type="button"
                                    data-toggle="tooltip" data-theme="dark" title="Search" onclick="load_data()">
                                    <i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <!--begin: Datatable-->
                <div id="kt_datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row" style="position:relative;">
                        <div class="col-sm-12" id="product_list">

                        </div>
                        <div class="col-md-12 d-none" id="table-loader" style="position: absolute;top:120px;left:0;">
                            <div style="width: 120px;
                            height: 70px;
                            background: white;
                            text-align: center;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            border: 1px solid #ddd;
                            border-radius: 5px;
                            margin: 0 auto;">
                                <i class="fas fa-spinner fa-spin fa-3x fa-fw text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end: Datatable-->
            </div>
        </div>
        <!--end::Card-->
    </div>
</div>
@endsection

@push('scripts')
<script src="js/jquery.printarea.js"></script>
<script>
$(document).ready(function(){
    $('#btn-reset').click(function () {
        $('#form-filter')[0].reset();
        $('#form-filter .selectpicker').selectpicker('refresh');
        $('#product_list').html('');
    });

    
    $(document).on('click','#print-report',function(){
        var mode = 'iframe'; // popup
        var close = mode == "popup";
        var options = {
            mode: mode,
            popClose: close
        };
        $("#report").printArea(options);
    });

});

function load_data()
{

        $.ajax({
            url: "{{ route('product.stock.datatable.data') }}",
            type: "POST",
            data: {product_id:$('#product_id option:selected').val(),category_id:$('#category_id option:selected').val(),_token:_token},
            beforeSend: function(){
                $('#table-loader').removeClass('d-none');
            },
            complete: function(){
                $('#table-loader').addClass('d-none');
            },
            success: function (data) {
                $('#product_list').empty().html(data);
            },
            error: function (xhr, ajaxOption, thrownError) {
                console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr.responseText);
            }
        });
}
</script>
@endpush