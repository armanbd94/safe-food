@extends('layouts.app')

@section('title', $page_title)

@push('styles')
<link href="plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
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
                    @if (permission('dealer-add'))
                    <a href="javascript:void(0);" onclick="showDealerFormModal('Add New Dealer','Save')" class="btn btn-primary btn-sm font-weight-bolder"> 
                        <i class="fas fa-plus-circle"></i> Add New
                    </a>
                    @endif
                    <!--end::Button-->
                </div>
            </div>
        </div>
        <!--end::Notice-->
        <!--begin::Card-->
        <div class="card card-custom">
            <div class="card-header flex-wrap py-5">
                <form method="POST" id="form-filter" class="col-md-12 px-0">
                    <div class="row">
                        <x-form.textbox labelName="Dealer Name" name="name" col="col-md-3" placeholder="Enter name" />
                        <x-form.textbox labelName="Mobile No." name="mobile_no" col="col-md-3" placeholder="Enter mobile number" />
                        <x-form.textbox labelName="Email" name="email" col="col-md-3" placeholder="Enter email" />
                        <x-form.selectbox labelName="District" name="district_id" col="col-md-3" class="selectpicker" onchange="getUpazilaList(this.value,1)">
                            @if (!$districts->isEmpty())
                                @foreach ($districts as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            @endif
                        </x-form.selectbox>
                        <x-form.selectbox labelName="Upazila" name="upazila_id" col="col-md-3" class="selectpicker" onchange="getAreaList(this.value,1)"/>
                        <x-form.selectbox labelName="Area" name="area_id" col="col-md-3" class="selectpicker"/>

                        <x-form.selectbox labelName="Status" name="status" col="col-md-3" class="selectpicker">
                            <option value="1">Active</option>
                            <option value="2">Inactive</option>
                        </x-form.selectbox>

                        
                        <div class="col-md-3">
                            <div style="margin-top:28px;">     
                                    <button id="btn-reset" class="btn btn-danger btn-sm btn-elevate btn-icon float-right" type="button"
                                    data-toggle="tooltip" data-theme="dark" title="Reset">
                                    <i class="fas fa-undo-alt"></i></button>
    
                                    <button id="btn-filter" class="btn btn-primary btn-sm btn-elevate btn-icon mr-2 float-right" type="button"
                                    data-toggle="tooltip" data-theme="dark" title="Search">
                                    <i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <!--begin: Datatable-->
                <div id="kt_datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="dataTable" class="table table-bordered table-hover">
                                <thead class="bg-primary">
                                    <tr>
                                        @if (permission('dealer-bulk-delete'))
                                        <th>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="select_all" onchange="select_all()">
                                                <label class="custom-control-label" for="select_all"></label>
                                            </div>
                                        </th>
                                        @endif
                                        <th>Sl</th>
                                        <th>Dealer Name</th>
                                        <th>Mobile No.</th>
                                        <th>Email</th>
                                        <th>District</th>
                                        <th>Upazila</th>
                                        <th>Area</th>
                                        <th>Commission Rate(%)</th>
                                        <th>Balance</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--end: Datatable-->
            </div>
        </div>
        <!--end::Card-->
    </div>
</div>
@include('dealer::modal')
@include('dealer::view')
@endsection

@push('scripts')
<script src="plugins/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
<script src="js/spartan-multi-image-picker.min.js"></script>
<script>
var table;
$(document).ready(function(){

    table = $('#dataTable').DataTable({
        "processing": true, //Feature control the processing indicator
        "serverSide": true, //Feature control DataTable server side processing mode
        "order": [], //Initial no order
        "responsive": true, //Make table responsive in mobile device
        "bInfo": true, //TO show the total number of data
        "bFilter": false, //For datatable default search box show/hide
        "lengthMenu": [
            [5, 10, 15, 25, 50, 100, 1000, 10000, -1],
            [5, 10, 15, 25, 50, 100, 1000, 10000, "All"]
        ],
        "pageLength": 25, //number of data show per page
        "language": { 
            processing: `<i class="fas fa-spinner fa-spin fa-3x fa-fw text-primary"></i> `,
            emptyTable: '<strong class="text-danger">No Data Found</strong>',
            infoEmpty: '',
            zeroRecords: '<strong class="text-danger">No Data Found</strong>'
        },
        "ajax": {
            "url": "{{route('dealer.datatable.data')}}",
            "type": "POST",
            "data": function (data) {
                data.name        = $("#form-filter #name").val();
                data.mobile_no   = $("#form-filter #mobile_no").val();
                data.email       = $("#form-filter #email").val();
                data.area_id     = $("#form-filter #area_id").val();
                data.district_id = $("#form-filter #district_id").val();
                data.upazila_id  = $("#form-filter #upazila_id").val();
                data.status      = $("#form-filter #status").val();
                data._token      = _token;
            }
        },
        "columnDefs": [{
            @if (permission('dealer-bulk-delete'))
            "targets": [0,11],
            @else
            "targets": [10],
            @endif
                
                "orderable": false,
                "className": "text-center"
            },
            {
                @if (permission('dealer-bulk-delete'))
                "targets": [1,2,3,5,6,7,10],
                @else
                "targets": [0,1,2,4,5,6,9],
                @endif
                "className": "text-center"
            },
            {
                @if (permission('dealer-bulk-delete'))
                "targets": [8,9],
                @else
                "targets": [7,8],
                @endif
                "className": "text-right"
            },
            {
                @if (permission('dealer-bulk-delete'))
                "targets": [9],
                @else 
                "targets": [8],
                @endif
                "orderable": false,
            }
        ],
        "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6' <'float-right'B>>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'<'float-right'p>>>",

        "buttons": [
            {
                'extend':'colvis','className':'btn btn-secondary btn-sm text-white','text':'Column','columns': ':gt(0)'
            },
            {
                "extend": 'print',
                'text':'Print',
                'className':'btn btn-secondary btn-sm text-white',
                "title": "{{ $page_title }} List",
                "orientation": "landscape", //portrait
                "pageSize": "A4", //A3,A5,A6,legal,letter
                "exportOptions": {
                    @if (permission('dealer-bulk-delete'))
                    columns: ':visible:not(:eq(0),:eq(11))' 
                    @else 
                    columns: ':visible:not(:eq(10))' 
                    @endif
                },
                customize: function (win) {
                    $(win.document.body).addClass('bg-white');
                },
            },
            {
                "extend": 'csv',
                'text':'CSV',
                'className':'btn btn-secondary btn-sm text-white',
                "title": "{{ $page_title }} List",
                "filename": "{{ strtolower(str_replace(' ','-',$page_title)) }}-list",
                "exportOptions": {
                    @if (permission('dealer-bulk-delete'))
                    columns: ':visible:not(:eq(0),:eq(11))' 
                    @else 
                    columns: ':visible:not(:eq(10))' 
                    @endif
                }
            },
            {
                "extend": 'excel',
                'text':'Excel',
                'className':'btn btn-secondary btn-sm text-white',
                "title": "{{ $page_title }} List",
                "filename": "{{ strtolower(str_replace(' ','-',$page_title)) }}-list",
                "exportOptions": {
                    @if (permission('dealer-bulk-delete'))
                    columns: ':visible:not(:eq(0),:eq(11))' 
                    @else 
                    columns: ':visible:not(:eq(10))' 
                    @endif
                }
            },
            {
                "extend": 'pdf',
                'text':'PDF',
                'className':'btn btn-secondary btn-sm text-white',
                "title": "{{ $page_title }} List",
                "filename": "{{ strtolower(str_replace(' ','-',$page_title)) }}-list",
                "orientation": "landscape", //portrait
                "pageSize": "A4", //A3,A5,A6,legal,letter
                "exportOptions": {
                    @if (permission('dealer-bulk-delete'))
                    columns: ':visible:not(:eq(0),:eq(11))' 
                    @else 
                    columns: ':visible:not(:eq(10))' 
                    @endif
                },
            },
            @if (permission('dealer-bulk-delete'))
            {
                'className':'btn btn-danger btn-sm delete_btn d-none text-white',
                'text':'Delete',
                action:function(e,dt,node,config){
                    multi_delete();
                }
            }
            @endif
        ],
    });

    $('#btn-filter').click(function () {
        table.ajax.reload();
    });

    $('#btn-reset').click(function () {
        $('#form-filter')[0].reset();
        $('#form-filter #upazila_id,#form-filter #area_id').empty().append(`<option value="">Select Please</option>`);
        $('#form-filter .selectpicker').selectpicker('refresh');
        table.ajax.reload();
    });

    $(document).on('click', '#save-btn', function () {
        let form = document.getElementById('store_or_update_form');
        let formData = new FormData(form);
        let url = "{{route('dealer.store.or.update')}}";
        let id = $('#update_id').val();
        let method;
        if (id) {
            method = 'update';
        } else {
            method = 'add';
        }
        store_or_update_data(table, method, url, formData);
    });

    $(document).on('click', '.edit_data', function () {
        let id = $(this).data('id');
        $('#store_or_update_form')[0].reset();
        $('#store_or_update_form .select').val('');
        $('#store_or_update_form').find('.is-invalid').removeClass('is-invalid');
        $('#store_or_update_form').find('.error').remove();
        $('#store_or_update_form #areas,#store_or_update_form #upazila_id').empty().append(`<option value="">Select Please</option>`);
        if (id) {
            $.ajax({
                url: "{{route('dealer.edit')}}",
                type: "POST",
                data: { id: id,_token: _token},
                dataType: "JSON",
                success: function (data) {
                    if(data.status == 'error'){
                        notification(data.status,data.message)
                    }else{
                        $('#store_or_update_form #update_id').val(data.id);
                        $('#store_or_update_form #name').val(data.name);
                        $('#store_or_update_form #mobile_no').val(data.mobile_no);
                        $('#store_or_update_form #email').val(data.email);
                        $('#store_or_update_form #district_id').val(data.district_id);
                        $('#store_or_update_form #address').val(data.address);
                        $('#store_or_update_form #commission_rate').val(data.commission_rate);
                        $('#store_or_update_form .pbalance').addClass('d-none');
                        $('#store_or_update_form .selectpicker').selectpicker('refresh');

                        getUpazilaList(data.district_id,2,data.upazila_id);
                        getAreaList(data.upazila_id,2,data.area_id);
                        
                        $('#store_or_update_modal').modal({
                            keyboard: false,
                            backdrop: 'static',
                        });
                        $('#store_or_update_modal .modal-title').html( '<i class="fas fa-edit text-white"></i> <span>Edit ' + data.name + ' Data</span>');
                        $('#store_or_update_modal #save-btn').text('Update');
                    }
                    
                },
                error: function (xhr, ajaxOption, thrownError) {
                    console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr.responseText);
                }
            });
        }
    });

    $(document).on('click', '.view_data', function () {
        let id = $(this).data('id');
        let name = $(this).data('name');
        if (id) {
            $.ajax({
                url: "{{route('dealer.view')}}",
                type: "POST",
                data: { id: id,_token: _token},
                success: function (data) {
                    $('#view_modal #view-data').html('');
                    $('#view_modal #view-data').html(data);
                    $('#view_modal').modal({
                        keyboard: false,
                        backdrop: 'static',
                    });
                    $('#view_modal .modal-title').html('<i class="fas fa-eye text-white"></i> <span>View ' + name + ' Data</span>');
                },
                error: function (xhr, ajaxOption, thrownError) {
                    console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr.responseText);
                }
            });
        }
    });

    $(document).on('click', '.delete_data', function () {
        let id    = $(this).data('id');
        let name  = $(this).data('name');
        let row   = table.row($(this).parent('tr'));
        let url   = "{{ route('dealer.delete') }}";
        delete_data(id, url, table, row, name);
    });

    function multi_delete(){
        let ids = [];
        let rows;
        $('.select_data:checked').each(function(){
            ids.push($(this).val());
            rows = table.rows($('.select_data:checked').parents('tr'));
        });
        if(ids.length == 0){
            Swal.fire({
                type:'error',
                title:'Error',
                text:'Please checked at least one row of table!',
                icon: 'warning',
            });
        }else{
            let url = "{{route('dealer.bulk.delete')}}";
            bulk_delete(ids,url,table,rows);
        }
    }

    $(document).on('click', '.change_status', function () {
        let id     = $(this).data('id');
        let name   = $(this).data('name');
        let status = $(this).data('status');
        let row    = table.row($(this).parent('tr'));
        let url    = "{{ route('dealer.change.status') }}";
        change_status(id, url, table, row, name, status);
    });

});

function getUpazilaList(district_id,selector,upazila_id=''){
    $.ajax({
        url:"{{ url('district-id-wise-upazila-list') }}/"+district_id,
        type:"GET",
        dataType:"JSON",
        success:function(data){
            html = `<option value="">Select Please</option>`;
            $.each(data, function(key, value) {
                html += '<option value="'+ key +'">'+ value +'</option>';
            });
            if(selector == 1)
            {
                $('#form-filter #upazila_id').empty();
                $('#form-filter #upazila_id').append(html);
            }else{
                $('#store_or_update_form #upazila_id').empty();
                $('#store_or_update_form #upazila_id').append(html);
            }
            $('.selectpicker').selectpicker('refresh');
            if(upazila_id){
                $('#store_or_update_form #upazila_id').val(upazila_id);
                $('#store_or_update_form #upazila_id.selectpicker').selectpicker('refresh');
            }
      
        },
    });
}

function getAreaList(upazila_id,selector,area_id=''){
    $.ajax({
        url:"{{ url('upazila-id-wise-area-list') }}/"+upazila_id,
        dataType:"JSON",
        success:function(data){
            html = `<option value="">Select Please</option>`;
            $.each(data, function(key, value) {
                html += '<option value="'+ key +'">'+ value +'</option>';
            });
            if(selector == 1)
            {
                $('#form-filter #area_id').empty();
                $('#form-filter #area_id').append(html);
            }else{
                $('#store_or_update_form #area_id').empty();
                $('#store_or_update_form #area_id').append(html);
            }
            $('.selectpicker').selectpicker('refresh');
            if(area_id){
                $('#store_or_update_form #area_id').val(area_id);
                $('#store_or_update_form #area_id.selectpicker').selectpicker('refresh');
            }
      
        },
    });
}

function showDealerFormModal(modal_title, btn_text) {
    $('#store_or_update_form')[0].reset();
    $('#store_or_update_form #update_id').val('');
    $('#store_or_update_form').find('.is-invalid').removeClass('is-invalid');
    $('#store_or_update_form').find('.error').remove();
    $('#store_or_update_form #upazila_id,#store_or_update_form #area_id').empty().append(`<option value="">Select Please</option>`);
    $('#store_or_update_form .selectpicker').selectpicker('refresh');
    $('#store_or_update_form .pbalance').removeClass('d-none');
    $('#store_or_update_modal').modal({
        keyboard: false,
        backdrop: 'static',
    });
    $('#store_or_update_modal .modal-title').html('<i class="fas fa-plus-square text-white"></i> '+modal_title);
    $('#store_or_update_modal #save-btn').text(btn_text);
}


</script>
@endpush