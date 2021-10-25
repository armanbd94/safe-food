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
                    <a href="{{ route('opening.stock') }}" class="btn btn-warning btn-sm font-weight-bolder"> 
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
                            <h6>Opening No.: {{ $opening_stock->opening_no }}</h6>
                            <h6>Warehouse: {{ $opening_stock->warehouse->name }}</h6>
                            <h6>Date: {{ date('d-M-Y',strtotime($opening_stock->date)) }}</h6>
                        </div>

                        <div class="col-md-12 pt-5">
                            <table class="table table-bordered" id="product_table">
                                <thead class="bg-primary">
                                    <th width="35%">Name</th>
                                    <th width="10%" class="text-center">Unit</th>
                                    <th width="10%" class="text-center">Qty</th>
                                    <th width="10%" class="text-right">Price</th>
                                    <th width="10%" class="text-right">Tax</th>
                                    <th width="15%" class="text-right">Sub Total</th>
                                </thead>
                                <tbody>
                                    @if (!$opening_stock->products->isEmpty())
                                        @foreach ($opening_stock->products as $key => $opening_stock_product)
                                            @php
                                                $base_unit = DB::table('units')->find($opening_stock_product->pivot->base_unit_id);
                                                $unit_name = $base_unit ? $base_unit->unit_name.' ('.$base_unit->unit_code.')' : '';
                                            @endphp
                                            <tr>
                                                <td>{{  $opening_stock_product->name.' - ('.$opening_stock_product->code.')' }}</td>
                                                <td class="text-center">{{ $unit_name }}</td>
                                                <td class="text-center">{{ $opening_stock_product->pivot->base_unit_qty }}</td>
                                                <td class="text-right">{{ $opening_stock_product->pivot->base_unit_price }}</td>
                                                <td class="text-right">{{ number_format($opening_stock_product->pivot->tax,2,'.','') }}</td>
                                                <td class="text-right">{{ number_format($opening_stock_product->pivot->total,2,'.','') }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot class="bg-primary">
                                    <th colspan="2" class="font-weight-bolder">Total</th>
                                    <th id="total-qty" class="text-center font-weight-bolder">{{ number_format($opening_stock->total_qty,2,'.','') }}</th>
                                    <th></th>
                                    <th id="total-tax" class="text-right font-weight-bolder">{{ number_format($opening_stock->total_tax,2,'.','') }}</th>
                                    <th id="total" class="text-right font-weight-bolder">{{ number_format($opening_stock->grand_total,2,'.','') }}</th>
                                </tfoot>
                            </table>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="shipping_cost">Note</label>
                            <p>{{ $opening_stock->note }}</p>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <thead class="bg-primary">
                                    <th><strong>Items</strong><span class="float-right" id="item">{{ $opening_stock->item.'('.$opening_stock->total_qty.')' }}</span></th>
                                    <th><strong>Grand Total</strong><span class="float-right" id="grand_total">{{ number_format($opening_stock->grand_total,2,'.','') }}</span></th>
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
