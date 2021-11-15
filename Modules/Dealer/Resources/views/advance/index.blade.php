@extends('layouts.app')

@section('title', $page_title)

@push('styles')
<link href="plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
<link href="css/daterangepicker.min.css" rel="stylesheet" type="text/css" />
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
                    @if (permission('dealer-advance-add'))
                    <a href="javascript:void(0);" onclick="showAdvanceFormModal('Add New Dealer Advance','Save')" class="btn btn-primary btn-sm font-weight-bolder"> 
                        <i class="fas fa-plus-circle"></i> Add New</a>
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
                        <div class="form-group col-md-4">
                            <label for="name">Choose Your Date</label>
                            <div class="input-group">
                                <input type="text" class="form-control daterangepicker-filed">
                                <input type="hidden" id="start_date" name="start_date" >
                                <input type="hidden" id="end_date" name="end_date" >
                            </div>
                        </div>

                        <x-form.selectbox labelName="Dealer" name="dealer_id" col="col-md-4" class="selectpicker" onchange="getUpazilaList(this.value,1)" >
                            @if (!$dealers->isEmpty())
                            @foreach ($dealers as $dealer)
                            <option value="{{ $dealer->id }}">{{ $dealer->name }}</option>
                            @endforeach
                            @endif
                        </x-form.selectbox>

                        <div class="col-md-4">
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
                                        @if (permission('dealer-advance-bulk-delete'))
                                        <th>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="select_all" onchange="select_all()">
                                                <label class="custom-control-label" for="select_all"></label>
                                            </div>
                                        </th>
                                        @endif
                                        <th>Sl</th>
                                        <th>Name</th>
                                        <th>Mobile No.</th>
                                        <th>District</th>
                                        <th>Upazila</th>
                                        <th>Area</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Payment Method</th>
                                        <th>Account Name</th>
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
@include('dealer::advance.modal')
@endsection

@push('scripts')
<script src="plugins/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
<script src="js/moment.js"></script>
<script src="js/knockout-3.4.2.js"></script>
<script src="js/daterangepicker.min.js"></script>
<script>
$('.daterangepicker-filed').daterangepicker({
    callback: function(startDate, endDate, period){
        var start_date = startDate.format('YYYY-MM-DD');
        var end_date   = endDate.format('YYYY-MM-DD');
        var title = start_date + ' To ' + end_date;
        $(this).val(title);
        $('input[name="start_date"]').val(start_date);
        $('input[name="end_date"]').val(end_date);
    }
});
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
            "url": "{{route('dealer.advance.datatable.data')}}",
            "type": "POST",
            "data": function (data) {
                data.dealer_id   = $("#form-filter #dealer_id").val();
                data.start_date  = $("#form-filter #start_date").val();
                data.end_date    = $("#form-filter #end_date").val();
                data._token      = _token;
            }
        },
        "columnDefs": [
            {
                @if (permission('dealer-advance-bulk-delete'))
                "targets": [0,11],
                @else
                "targets": [10],
                @endif
                "className": "text-center",
                "orderable":false
            },
            {
                @if (permission('dealer-advance-bulk-delete'))
                "targets": [1,2,3,4,5,6,8,9,10],
                @else
                "targets": [0,1,2,3,4,5,7,8,9],
                @endif
                "className": "text-center"
            },
            {
                @if (permission('dealer-advance-bulk-delete'))
                "targets": [7],
                @else
                "targets": [6],
                @endif
                "className": "text-right"
            },
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
                "orientation": "portrait", //portrait
                "pageSize": "A4", //A3,A5,A6,legal,letter
                "exportOptions": {
                    columns: function (index, data, node) {
                        @if (permission('dealer-advance-bulk-delete'))
                        columns: ':visible:not(:eq(0),:eq(11))' 
                        @else
                        columns: ':visible:not(:eq(10))' 
                        @endif
                    }
                },
                customize: function (win) {
                    $(win.document.body).addClass('bg-white');
                    $(win.document.body).find('table thead').css({'background':'#034d97'});
                    $(win.document.body).find('table tfoot tr').css({'background-color':'#034d97'});
                    $(win.document.body).find('h1').css('text-align', 'center');
                    $(win.document.body).find('h1').css('font-size', '15px');
                    $(win.document.body).find('table').css( 'font-size', 'inherit' );
                },
            },
            {
                "extend": 'csv',
                'text':'CSV',
                'className':'btn btn-secondary btn-sm text-white',
                "title": "{{ $page_title }} List",
                "filename": "{{ strtolower(str_replace(' ','-',$page_title)) }}-list",
                "exportOptions": {
                    columns: function (index, data, node) {
                        @if (permission('dealer-advance-bulk-delete'))
                        columns: ':visible:not(:eq(0),:eq(11))' 
                        @else
                        columns: ':visible:not(:eq(10))' 
                        @endif
                    }
                }
            },
            {
                "extend": 'excel',
                'text':'Excel',
                'className':'btn btn-secondary btn-sm text-white',
                "title": "{{ $page_title }} List",
                "filename": "{{ strtolower(str_replace(' ','-',$page_title)) }}-list",
                "exportOptions": {
                    columns: function (index, data, node) {
                        @if (permission('dealer-advance-bulk-delete'))
                        columns: ':visible:not(:eq(0),:eq(11))' 
                        @else
                        columns: ':visible:not(:eq(10))' 
                        @endif
                    }
                }
            },
            {
                "extend": 'pdf',
                'text':'PDF',
                'className':'btn btn-secondary btn-sm text-white',
                "title": "{{ $page_title }} List",
                "filename": "{{ strtolower(str_replace(' ','-',$page_title)) }}-list",
                "orientation": "portrait", //portrait
                "pageSize": "A4", //A3,A5,A6,legal,letter
                "exportOptions": {
                    columns: function (index, data, node) {
                        @if (permission('dealer-advance-bulk-delete'))
                        columns: ':visible:not(:eq(0),:eq(11))' 
                        @else
                        columns: ':visible:not(:eq(10))' 
                        @endif
                    }
                },
                customize: function(doc) {
                    doc.defaultStyle.fontSize = 7; //<-- set fontsize to 16 instead of 10 
                    doc.styles.tableHeader.fontSize = 7;
                    doc.pageMargins = [5,5,5,5];
                }  
            },
            @if (permission('dealer-advance-bulk-delete'))
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
        $('#form-filter .selectpicker').selectpicker('refresh');
        $('#form-filter #start_date').val('');
        $('#form-filter #end_date').val('');
        table.ajax.reload();
    });

    $(document).on('click', '#save-btn', function () {
        var dealer       = $('#store_or_update_form #dealer option:selected').val();
        var dealer_coaid = $('#store_or_update_form #dealer option:selected').data('coaid');
        var dealer_name  = $('#store_or_update_form #dealer option:selected').data('name');
        var amount         = $('#store_or_update_form #amount').val();
        var payment_method = $('#store_or_update_form #payment_method option:selected').val();
        var account_id    = $('#store_or_update_form #account_id option:selected').val();
        var warehouse_id    = $('#store_or_update_form #warehouse_id').val();
        var reference_number = '';
        if(payment_method != 1){
            reference_number = $('#store_or_update_form #reference_number').val();
        }
        let url = "{{route('dealer.advance.store.or.update')}}";
        let id = $('#update_id').val();
        let method;
        if (id) {
            method = 'update';
        } else {
            method = 'add';
        }

        $.ajax({
            url: url,
            type: "POST",
            data: {id:id,dealer:dealer,dealer_coaid:dealer_coaid,dealer_name:dealer_name,amount:amount,
                payment_method:payment_method,account_id:account_id,reference_number:reference_number,warehouse_id:warehouse_id,
               _token:_token},
            dataType: "JSON",
            beforeSend: function(){
                $('#save-btn').addClass('spinner spinner-white spinner-right');
            },
            complete: function(){
                $('#save-btn').removeClass('spinner spinner-white spinner-right');
            },
            success: function (data) {
                $('#store_or_update_form').find('.is-invalid').removeClass('is-invalid');
                $('#store_or_update_form').find('.error').remove();
                if (data.status == false) {
                    $.each(data.errors, function (key, value) {
                        $('#store_or_update_form input#' + key).addClass('is-invalid');
                        $('#store_or_update_form textarea#' + key).addClass('is-invalid');
                        $('#store_or_update_form select#' + key).parent().addClass('is-invalid');
                        $('#store_or_update_form #' + key).parent().append(
                        '<small class="error text-danger">' + value + '</small>');
                    });
                } else {
                    notification(data.status, data.message);
                    if (data.status == 'success') {
                        if (method == 'update') {
                            table.ajax.reload(null, false);
                        } else {
                            table.ajax.reload();
                        }
                        $('#store_or_update_modal').modal('hide');
                    }
                }
            },
            error: function (xhr, ajaxOption, thrownError) {
                console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr.responseText);
            }
        });
        
    });
    
    $(document).on('click', '.edit_data', function () {
        let id = $(this).data('id');
        $('#store_or_update_form')[0].reset();
        $('#store_or_update_form').find('.is-invalid').removeClass('is-invalid');
        $('#store_or_update_form').find('.error').remove();
        if (id) {
            $.ajax({
                url: "{{route('dealer.advance.edit')}}",
                type: "POST",
                data: { id: id,_token: _token},
                dataType: "JSON",
                success: function (data) {
                    if(data.status == 'error'){
                        notification(data.status,data.message)
                    }else{
                        $('#store_or_update_form #update_id').val(data.id);
                        $('#store_or_update_form #amount').val(data.amount);
                        $('#store_or_update_form #payment_method').val(data.payment_method);
                        if(data.payment_method == 1){
                            $('.reference_number').addClass('d-none');
                            $('#store_or_update_form #reference_number').val('');
                        }else{
                            $('.reference_number').removeClass('d-none');
                            $('#store_or_update_form #reference_number').val(data.cheque_no);
                        }
                        $('#store_or_update_form #warehouse_id').val(data.warehouse_id);
                        $('#store_or_update_form #dealer').val(data.dealer_id);
                        account_list(data.payment_method,data.account_id);
                        $('#store_or_update_form select#dealer').each(function(){
                            $('#store_or_update_form select#dealer option').each(function() {
                                if(!this.selected) {
                                    $(this).attr('disabled', true);
                                }
                            });
                        });
                        $('#store_or_update_form .selectpicker').selectpicker('refresh');
                        $('#store_or_update_modal').modal({
                            keyboard: false,
                            backdrop: 'static',
                        });
                        $('#store_or_update_modal .modal-title').html('<i class="fas fa-edit text-white"></i> <span>Edit ' + data.name + ' Data</span>');
                        $('#store_or_update_modal #save-btn').text('Update');
                    }
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
        let url   = "{{ route('dealer.advance.delete') }}";
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
            let url = "{{route('dealer.advance.bulk.delete')}}";
            bulk_delete(ids,url,table,rows);
        }
    }

    $(document).on('change', '#payment_method', function () {
        if($('#payment_method option:selected').val() == 1)
        {
            $('.reference_number').addClass('d-none');
        }else{
            $('.reference_number').removeClass('d-none');
        }
        account_list($('#payment_method option:selected').val());
    });
});
function account_list(payment_method,account_id='')
{
    $.ajax({
        url: "{{route('account.list')}}",
        type: "POST",
        data: { payment_method: payment_method,_token: _token},
        success: function (data) {
            $('#store_or_update_form #account_id').html('');
            $('#store_or_update_form #account_id').html(data);
            $('#store_or_update_form #account_id.selectpicker').selectpicker('refresh');
            if(account_id)
            {
                $('#store_or_update_form #account_id').val(account_id);
                $('#store_or_update_form #account_id.selectpicker').selectpicker('refresh');
            }
        },
        error: function (xhr, ajaxOption, thrownError) {
            console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr.responseText);
        }
    });
}


function showAdvanceFormModal(modal_title, btn_text) {
    $('#store_or_update_form')[0].reset();
    $('#store_or_update_form #update_id').val('');
    $('#store_or_update_form').find('.is-invalid').removeClass('is-invalid');
    $('#store_or_update_form').find('.error').remove();
    $('#store_or_update_form select#dealer').each(function(){
        $('#store_or_update_form select#dealer option').each(function() {
            $(this).attr('disabled', false);
        });
    });
    $('#store_or_update_form #account_id').empty();
    $('.reference_number').addClass('d-none');
    $('#store_or_update_form #reference_number').val('');
    $('#store_or_update_form select#dealer').val('');
    $('#store_or_update_form .selectpicker').selectpicker('refresh');
    $('#store_or_update_modal').modal({
        keyboard: false,
        backdrop: 'static',
    });
    $('#store_or_update_modal .modal-title').html('<i class="fas fa-plus-square text-white"></i> '+modal_title);
    $('#store_or_update_modal #save-btn').text(btn_text);
}
</script>
@endpush
