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
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h6>Stock Out No.: {{ $stock_out->stock_out_no }}</h6>
                            <h6>Warehouse: {{ $stock_out->warehouse->name }}</h6>
                            <h6>Date: {{ date('d-M-Y',strtotime($stock_out->date)) }}</h6>
                        </div>

                        <div class="col-md-12 pt-5">
                            <table class="table table-bordered" id="product_table">
                                <thead class="bg-primary">
                                    <th>Material</th>
                                    <th class="text-center">Batch No.</th>
                                    <th class="text-center">Unit</th>
                                    <th class="text-right">Rate</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-right">Sub Total</th>
                                </thead>
                                <tbody>
                                    @if (!$stock_out->materials->isEmpty())
                                        @foreach ($stock_out->materials as $key => $stock_out_material)
                                            @php
                                                $base_unit = DB::table('units')->find($stock_out_material->unit_id);
                                                $unit_name = $base_unit ? $base_unit->unit_name.' ('.$base_unit->unit_code.')' : '';
                                            @endphp
                                            <tr>
                                                <td>{{  $stock_out_material->material->material_name.' - ('.$stock_out_material->material->material_code.')' }}</td>
                                                <td class="text-center">{{ $stock_out_material->batch_no }}</td>
                                                <td class="text-center">{{ $unit_name }}</td>
                                                <td class="text-right">{{ $stock_out_material->net_unit_cost }}</td>
                                                <td class="text-center">{{ $stock_out_material->qty }}</td>
                                                <td class="text-right">{{ number_format($stock_out_material->total,2,'.','') }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot class="bg-primary">
                                    <th colspan="4" class="font-weight-bolder">Total</th>
                                    <th id="total-qty" class="text-center font-weight-bolder">{{ number_format($stock_out->total_qty,2,'.','') }}</th>
                                    <th id="total" class="text-right font-weight-bolder">{{ number_format($stock_out->grand_total,2,'.','') }}</th>
                                </tfoot>
                            </table>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="shipping_cost">Note</label>
                            <p>{{ $stock_out->note }}</p>
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
                    </div>
                </div>
                <!--end: Datatable-->
            </div>
        </div>
        <!--end::Card-->
    </div>
</div>
@endsection
