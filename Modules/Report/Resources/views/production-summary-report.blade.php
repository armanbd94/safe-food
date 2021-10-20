@extends('layouts.app')

@section('title', $page_title)

@push('styles')
<link href="css/daterangepicker.min.css" rel="stylesheet" type="text/css" />
<style>
    #summary_data .card-label{
        font-size: 18px !important;
        font-weight: bolder;
        text-align: center;
    }
    #summary_data .card-body{
        text-align: center;
    }
    #summary_data .card.card-custom .card-header{
        justify-content: center !important;
    }
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
            </div>
        </div>
        <!--end::Notice-->
        <!--begin::Card-->
        <div class="card card-custom">
            <div class="card-body">
                <!--begin: Datatable-->
                <div id="kt_datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="col-md-12 text-center">
                            <h2 class="text-danger"><b>Total Production Material Cost:</b> {{ $total_production_material_cost }} Tk</h2><br>
                            <h2 class="text-primary"><b>Total Production Finish Goods Value:</b> {{ $total_production_product_value }} Tk</h2>
                        
                    </div>
                </div>
                <!--end: Datatable-->
            </div>
        </div>
        <!--end::Card-->
    </div>
</div>
@endsection
