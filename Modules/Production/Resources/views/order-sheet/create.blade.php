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
                    <button type="button" class="btn btn-primary btn-sm font-weight-bolder save-btn d-none mr-3" onclick="store_data()"> 
                        <i class="fas fa-save"></i> Save</button>

                    <button type="button" class="btn btn-success btn-sm font-weight-bolder generate_sheet"> 
                        <i class="fab fa-superpowers"></i> Generate</button>
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
                    <form id="production-order-sheet" method="post">
                        @csrf
                        <div class="row">
                            
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
<script>
$(document).ready(function(){
    $(document).on('click','.generate_sheet',function(){
        $.ajax({
            url: "{{ url('production-order-sheet/generate') }}",
            type: "GET",
            beforeSend: function(){
                $('.generate_sheet').addClass('spinner spinner-white spinner-right');
            },
            complete: function(){
                $('.generate_sheet').removeClass('spinner spinner-white spinner-right');
            },
            success: function (data) {
                if(data == 'exist'){
                    $('.save-btn').addClass('d-none');
                    notification('error', 'Today\'s Production Order Sheet Already Generated Please Kindly Check Manage Production Order Sheet');
                }else{
                    $('#production-order-sheet .row').empty().append(data);
                    $('.save-btn').removeClass('d-none');
                }
            },
            error: function (xhr, ajaxOption, thrownError) {
                console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr.responseText);
            }
        });
    });
});

function store_data(){
    let form = document.getElementById('production-order-sheet');
    let formData = new FormData(form);
    let url = "{{url('production-order-sheet/store')}}";
    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        dataType: "JSON",
        contentType: false,
        processData: false,
        cache: false,
        beforeSend: function(){
            $('.save-btn').addClass('spinner spinner-white spinner-right');
        },
        complete: function(){
            $('.save-btn').removeClass('spinner spinner-white spinner-right');
        },
        success: function (data) {
            notification(data.status, data.message);
            if (data.status == 'success') {
                window.location.replace("{{ url('production-order-sheet/view') }}/"+data.sheet_id);
            }
        },
        error: function (xhr, ajaxOption, thrownError) {
            console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr.responseText);
        }
    });
}
</script>
@endpush