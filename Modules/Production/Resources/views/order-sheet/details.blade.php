@extends('layouts.app')

@section('title', $page_title)

@push('styles')
<style>
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
                <div class="card-toolbar">
                    <!--begin::Button-->
                    <button type="button" class="btn btn-primary btn-sm mr-3" id="print-invoice"> <i class="fas fa-print"></i> Print</button>
                    
                    <a href="{{ route('production.order.sheet') }}" class="btn btn-warning btn-sm font-weight-bolder"> 
                        <i class="fas fa-arrow-left"></i> Back</a>
                    <!--end::Button-->
                </div>
            </div>
        </div>
        <!--end::Notice-->
        <!--begin::Card-->
        <div class="card card-custom" style="padding-bottom: 100px !important;">
            <div class="card-body" style="padding-bottom: 100px !important;">
                <div class="col-md-12 col-lg-12"  style="width: 100%;">
                    <div id="invoice">
                        <style>
                            body,html {
                                background: #fff !important;
                                -webkit-print-color-adjust: exact !important;
                            }

                            .invoice {
                                /* position: relative; */
                                background: #fff !important;
                                /* min-height: 680px; */
                            }

                            .invoice header {
                                padding: 10px 0;
                                margin-bottom: 20px;
                                border-bottom: 1px solid #036;
                            }

                            .invoice .company-details {
                                text-align: right
                            }

                            .invoice .company-details .name {
                                margin-top: 0;
                                margin-bottom: 0;
                            }

                            .invoice .contacts {
                                margin-bottom: 20px;
                            }

                            .invoice .invoice-to {
                                text-align: left;
                            }

                            .invoice .invoice-to .to {
                                margin-top: 0;
                                margin-bottom: 0;
                            }

                            .invoice .invoice-details {
                                text-align: right;
                            }

                            .invoice .invoice-details .invoice-id {
                                margin-top: 0;
                                color: #036;
                            }

                            .invoice main {
                                padding-bottom: 50px
                            }

                            .invoice main .thanks {
                                margin-top: -100px;
                                font-size: 2em;
                                margin-bottom: 50px;
                            }

                            .invoice main .notices {
                                padding-left: 6px;
                                border-left: 6px solid #036;
                            }

                            .invoice table {
                                width: 100%;
                                border-collapse: collapse;
                                border-spacing: 0;
                                margin-bottom: 20px;
                            }

                            .invoice table th {
                                background: #036;
                                color: #fff;
                                padding: 5px;
                                /* border-bottom: 1px solid #fff */
                            }

                            .invoice table td {
                                padding: 5px;
                                border: 1px solid #EBEDF3;
                                /* border-bottom: 1px solid #fff */
                            }

                            #info-table td{padding:0px !important;}

                            .invoice table th {
                                white-space: nowrap;
                            }

                            .invoice table td h3 {
                                margin: 0;
                                color: #036;
                            }

                            .invoice table .qty {
                                text-align: center;
                            }

                            .invoice table .price,
                            .invoice table .discount,
                            .invoice table .tax,
                            .invoice table .total {
                                text-align: right;
                            }

                            .invoice table .no {
                                color: #fff;
                                background: #036
                            }

                            .invoice table .total {
                                background: #036;
                                color: #fff
                            }

                            .invoice table tbody tr:last-child td {
                                border: none
                            }

                            .invoice table tfoot td {
                                background: 0 0;
                                border-bottom: none;
                                white-space: nowrap;
                                text-align: right;
                                padding: 10px 20px;
                                border-top: 1px solid #aaa;
                                font-weight: bold;
                            }

                            .invoice table tfoot tr:first-child td {
                                border-top: none
                            }

                            /* .invoice table tfoot tr:last-child td {
                                color: #036;
                                border-top: 1px solid #036
                            } */

                            .invoice table tfoot tr td:first-child {
                                border: none
                            }

                            .invoice footer {
                                width: 100%;
                                text-align: center;
                                color: #777;
                                border-top: 1px solid #aaa;
                                padding: 8px 0
                            }

                            .invoice a {
                                content: none !important;
                                text-decoration: none !important;
                                color: #036 !important;
                            }

                            .page-header,
                            .page-header-space {
                                height: 100px;
                            }

                            .page-footer,
                            .page-footer-space {
                                height: 20px;

                            }

                            .page-footer {
                                position: fixed;
                                bottom: 0;
                                width: 100%;
                                text-align: center;
                                color: #777;
                                border-top: 1px solid #aaa;
                                padding: 8px 0
                            }

                            .page-header {
                                position: fixed;
                                top: 0mm;
                                width: 100%;
                                border-bottom: 1px solid black;
                            }

                            .page {
                                page-break-after: always;
                            }
                            .dashed-border{
                                width:180px;height:2px;margin:0 auto;padding:0;border-top:1px dashed #454d55 !important;
                            }

                            @media screen {
                                .no_screen {display: none;}
                                .no_print {display: block;}
                                thead {display: table-header-group;} 
                                tfoot {display: table-footer-group;}
                                button {display: none;}
                                body {margin: 0;}
                            }

                            @media print {

                                body,
                                html {
                                    /* background: #fff !important; */
                                    -webkit-print-color-adjust: exact !important;
                                    font-family: sans-serif;
                                    /* font-size: 12px !important; */
                                    margin-bottom: 100px !important;
                                }

                                .m-0 {
                                    margin: 0 !important;
                                }

                                h1,
                                h2,
                                h3,
                                h4,
                                h5,
                                h6 {
                                    margin: 0 !important;
                                }

                                .no_screen {
                                    display: block !important;
                                }

                                .no_print {
                                    display: none;
                                }

                                a {
                                    content: none !important;
                                    text-decoration: none !important;
                                    color: #036 !important;
                                }

                                .text-center {
                                    text-align: center !important;
                                }

                                .text-left {
                                    text-align: left !important;
                                }

                                .text-right {
                                    text-align: right !important;
                                }

                                .float-left {
                                    float: left !important;
                                }

                                .float-right {
                                    float: right !important;
                                }

                                .text-bold {
                                    font-weight: bold !important;
                                }

                                .invoice {
                                    /* font-size: 11px!important; */
                                    overflow: hidden !important;
                                    background: #fff !important;
                                    margin-bottom: 100px !important;
                                }

                                .invoice footer {
                                    position: absolute;
                                    bottom: 0;
                                    left: 0;
                                    /* page-break-after: always */
                                }

                                .invoice table td {border: 1px solid #EBEDF3;}
                                .invoice .product_table{font-size:12px !important;}

                                /* .invoice>div:last-child {
                                    page-break-before: always
                                } */
                                .hidden-print {
                                    display: none !important;
                                }
                                .dashed-border{
                                    width:180px;height:2px;margin:0 auto;padding:0;border-top:1px dashed #454d55 !important;
                                }
                            }

                            @page {
                                /* size: auto; */
                                margin: 5mm 5mm;

                            }
                        </style>
                        <div class="invoice overflow-auto">
                            <div>
                                <table>
                                    <tr>
                                        <td class="text-center">
                                            @if (config('settings.logo'))
                                            <a href="{{ url('dashboard') }}">
                                                <img src="{{ asset('storage/'.LOGO_PATH.config('settings.logo'))}}" style="max-width: 60px;" alt="Logo" />
                                            </a>
                                            @endif
                                            <h2 class="name m-0" style="text-transform: uppercase;"><b>{{ config('settings.title') ? config('settings.title') : env('APP_NAME') }}</b></h2>
                                            {{-- @if(config('settings.contact_no'))<p style="font-weight: normal;margin:0;"><b>Contact No.: </b>{{ config('settings.contact_no') }}, @if(config('settings.email'))<b>Email: </b>{{ config('settings.email') }}@endif</p>@endif --}}
                                            @if(config('settings.address'))<p style="font-weight: normal;margin:0;">{{ config('settings.address') }}</p>@endif
                                            <p class="name" style="margin-top:5px;font-weight: normal;margin:0;"><b>প্রোডাকশন অর্ডার শিট</b></p>
                                            <p style="font-weight: normal;margin:0;">তারিখ: {{ convert_bangla_number(date('d-m-Y',strtotime($order_sheet->order_date))) }}</p>
                                            <p style="font-weight: normal;margin:0;">অর্ডার শিট নং: {{ convert_bangla_number($order_sheet->sheet_no) }}</p>
                                        </td>
                                    </tr>
                                </table>
                                {{-- <div style="width: 100%;height:3px;border-top:1px solid #036;border-bottom:1px solid #036;"></div> --}}
                                <table border="0" cellspacing="0" cellpadding="0" class="product_table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Sl</th>
                                            <th>Name</th>
                                            <th class="text-center">Carton Size</th>
                                            <th class="text-center">Stock Quantity</th>
                                            <th class="text-center">Ordered Qunatity</th>
                                            <th class="text-center">Required Quantity</th>
                                            <th class="text-right">Price</th>
                                            <th class="text-right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!$order_sheet->products->isEmpty())
                                            @foreach ($order_sheet->products as $key => $item)
                                                <tr>
                                                    <td class="text-center">{{ $key+1 }}</td>
                                                    <td class="text-left">{{ $item->name }}</td>
                                                    <td class="text-center">{{ $item->unit->unit_name }}</td>
                                                    <td class="text-center">{{ $item->pivot->stock_qty.' '.$item->base_unit->unit_name }}</td>
                                                    <td class="text-center">{{ $item->pivot->ordered_qty.' '.$item->base_unit->unit_name }}</td>
                                                    <td class="text-center">{{ $item->pivot->required_qty.' '.$item->base_unit->unit_name }}</td>
                                                    <td class="text-right">{{ number_format($item->pivot->price,2,'.',',') }}</td>
                                                    <td class="text-right">{{ number_format($item->pivot->total,2,'.',',') }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        <tr>
                                            <td colspan="4" class="text-right"><p><b>Total</b></p></td>
                                            <td  class="text-center"><p><b>{{ $order_sheet->item.' ('.number_format($order_sheet->total_qty,2,'.','').')' }}</b></p></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-right"><p><b>{{ number_format($order_sheet->total,2,'.',',') }}</b></p></td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" class="text-right"><p><b>Commission</b></p></td>
                                            <td class="text-right"><p><b>{{ number_format($order_sheet->total_commission,2,'.',',') }}</b></p></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!--***********************-->

                        
                       

                    </div>
                </div>
            </div>
        </div>
        <!--end::Card-->
    </div>
</div>
@endsection

@push('scripts')
<script src="js/jquery.printarea.js"></script>
<script>
$(document).ready(function () {
    //QR Code Print
    $(document).on('click','#print-invoice',function(){
        var mode = 'iframe'; // popup
        var close = mode == "popup";
        var options = {
            mode: mode,
            popClose: close
        };
        $("#invoice").printArea(options);
    });
});

</script>
@endpush