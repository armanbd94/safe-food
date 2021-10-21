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
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h3 class="py-3 bg-warning text-white" style="margin: 10px auto 10px auto;width:300px;">Production Materials</h3>
                        </div>
                        <div class="col-sm-12 table-responsive">
                            <table id="dataTable" class="table table-bordered table-hover">
                                <thead class="bg-primary">
                                    <tr>
                                        <th class="text-center">Sl</th>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th class="text-center">Unit</th>
                                        <th class="text-right">Cost</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total_material_cost = 0; @endphp
                                    @if (!$materials->isEMpty())
                                        @foreach ($materials as $key => $value)
                                            <tr>
                                                <td class="text-center">{{ $key+1 }}</td>
                                                <td>{{ $value->material_name }}</td>
                                                <td>{{ $value->material_code }}</td>
                                                <td class="text-center">{{ $value->unit_name }}</td>
                                                <td class="text-right">{{ number_format($value->cost,2,'.','') }}</td>
                                                <td class="text-center">{{ number_format($value->qty,2,'.','') }}</td>
                                                <td class="text-right">{{ number_format(($value->qty * $value->cost),2,'.','') }}</td>
                                            </tr>
                                            @php $total_material_cost += $value->qty * $value->cost; @endphp
                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr class="bg-primary">
                                        <th class="text-right" colspan="6">Total</th>
                                        <th class="text-right">{{ number_format($total_material_cost,2,'.','') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h3 class="py-3 bg-warning text-white" style="margin: 10px auto 10px auto;width:300px;">Production Finish Goods</h3>
                        </div>
                        <div class="col-sm-12 table-responsive">
                            <table id="dataTable" class="table table-bordered table-hover">
                                <thead class="bg-primary">
                                    <tr>
                                        <th class="text-center">Sl</th>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th class="text-center">Unit</th>
                                        <th class="text-right">Price</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total_product_cost = 0; @endphp
                                    @if (!$products->isEMpty())
                                        @foreach ($products as $key => $value)
                                            <tr>
                                                <td class="text-center">{{ $key+1 }}</td>
                                                <td>{{ $value->name }}</td>
                                                <td>{{ $value->code }}</td>
                                                <td class="text-center">{{ $value->unit_name }}</td>
                                                <td class="text-right">{{ number_format($value->price,2,'.','') }}</td>
                                                <td class="text-center">{{ number_format($value->qty,2,'.','') }}</td>
                                                <td class="text-right">{{ number_format($value->total,2,'.','') }}</td>
                                            </tr>
                                            @php $total_product_cost += $value->total; @endphp
                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr class="bg-primary">
                                        <th class="text-right" colspan="6">Total</th>
                                        <th class="text-right">{{ number_format($total_product_cost,2,'.','') }}</th>
                                    </tr>
                                </tfoot>
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
@endsection
