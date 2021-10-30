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
                    
                    <a href="{{ route('sale') }}" class="btn btn-warning btn-sm font-weight-bolder"> 
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
                                border-bottom: 1px solid #fff
                            }

                            .invoice table td {
                                padding: 5px;
                                border-bottom: 1px solid #fff
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
                                        </td>
                                    </tr>
                                </table>
                                <div style="width: 100%;height:3px;border-top:1px solid #036;border-bottom:1px solid #036;"></div>
                                <table style="margin-bottom: 0px;margin-top:10px;" id="info-table">
                                    <tr>
                                        <td width="40%">
                                            <table>
                                                <tr>
                                                    <td colspan="2"><b>Memo To</b></td>
                                                </tr>
                                                <tr>
                                                    <td>@if($sale->order_from == 1)<b>Depo Name</b>@else<b>Dealer Name</b>@endif</td>
                                                    <td><b>: </b> @if($sale->order_from == 1)<b>{{ $sale->depo->name }}</b>@else<b>{{ $sale->dealer->name }}</b>@endif</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Mobile No.</b></td>
                                                    <td><b>: </b> @if($sale->order_from == 1){{ $sale->depo->mobile_no }}@else{{ $sale->dealer->mobile_no }}@endif</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Area Name</b></td>
                                                    <td><b>: </b> {{ $sale->area->name }}</td>
                                                </tr>
                                                @if ($sale->order_from == 1)
                                                    @if($sale->depo->address)
                                                    <tr>
                                                        <td><b>Address</b></td>
                                                        <td><b>: </b>{{ $sale->depo->address }}</td>
                                                    </tr>
                                                    @endif
                                                @else 
                                                    @if($sale->dealer->address)
                                                    <tr>
                                                        <td><b>Address</b></td>
                                                        <td><b>: </b>{{ $sale->dealer->address }}</td>
                                                    </tr>
                                                    @endif
                                                @endif
                                            </table>
                                        </td>
                                        <td width="20%"></td>
                                        <td width="40%">
                                            <table>
                                                <tr>
                                                    <td colspan="2"></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Memo No.</b></td>
                                                    <td><b>: #{{ $sale->memo_no }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Order Date</b></td>
                                                    <td><b>: </b> {{ date('d-M-Y',strtotime($sale->sale_date)) }}</td>
                                                </tr>
                                                @if($sale->delivery_date)
                                                <tr>
                                                    <td><b>Delivery Date</b></td>
                                                    <td><b>: </b> {{ date('d-M-Y',strtotime($sale->delivery_date)) }}</td>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td><b>Payment Status</b></td>
                                                    <td><b>: </b>{{ $sale->payment_status ? PAYMENT_STATUS[$sale->payment_status] : 'N/A' }}</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <table border="0" cellspacing="0" cellpadding="0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">SL</th>
                                            <th class="text-left">NAME</th>
                                            <th class="text-center">QUANTITY</th>
                                            <th class="text-center">CARTON SIZE</th>
                                            <th class="text-right">PRICE</th>
                                            <th class="text-center">DAMAGE</th>
                                            <th class="text-right">SUBTOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!$sale->sale_products->isEmpty())
                                            @foreach ($sale->sale_products as $key => $item)
                                                @php
                                                    $unit_name = '';
                                                    if($item->pivot->sale_unit_id)
                                                    {
                                                        $unit_name = DB::table('units')->where('id',$item->pivot->sale_unit_id)->value('unit_name');
                                                    }
                                                @endphp
                                                <tr>
                                                    <td class="text-center no">{{ $key+1 }}</td>
                                                    <td class="text-left">{{ $item->name }}</td>
                                                    <td class="text-center qty">{{ $item->pivot->qty.' '.$unit_name }}</td>
                                                    <td class="text-center qty">{{ $item->unit->unit_name }}</td>
                                                    <td class="text-right price">{{ number_format($item->pivot->net_unit_price,2,'.',',') }}</td>
                                                    {{-- <td class="text-right discount">{{ number_format($item->pivot->discount,2,'.','') }}</td> --}}
                                                    {{-- <td class="text-right tax">{{ number_format($item->pivot->tax,2,'.','') }}</td> --}}
                                                    <td></td>
                                                    <td class="text-right total">
                                                        @if (config('settings.currency_position') == 2)
                                                            {{ number_format($item->pivot->total,2,'.',',') }} {{ config('settings.currency_symbol') }}
                                                        @else 
                                                            {{ config('settings.currency_symbol') }} {{ number_format($item->pivot->total,2,'.',',') }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        <tr>
                                            <td colspan="2" class="text-left no pl-3 font-weight-bolder">TOTAL</td>
                                            <td class="text-center no font-weight-bolder">{{ number_format($sale->total_qty,2,'.',',') }}</td>
                                            <td class="no"></td>
                                            <td class="no"></td>
                                            <td class="no"></td>
                                            <td class="text-right no font-weight-bolder">
                                                @if (config('settings.currency_position') == 2)
                                                    {{ number_format($sale->grand_total,2,'.','') }} {{ config('settings.currency_symbol') }}
                                                @else 
                                                    {{ config('settings.currency_symbol') }} {{ number_format($sale->grand_total,2,'.','') }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"></td>
                                            <td  class="text-right no font-weight-bolder">PREVIOUS DUE</td>
                                            <td class="text-right no font-weight-bolder">
                                                @if (config('settings.currency_position') == 2)
                                                    {{ number_format($sale->previous_due,2,'.','') }} {{ config('settings.currency_symbol') }}
                                                @else 
                                                    {{ config('settings.currency_symbol') }} {{ number_format($sale->previous_due,2,'.','') }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"></td>
                                            <td  class="text-right no font-weight-bolder">NET TOTAL</td>
                                            <td class="text-right no font-weight-bolder">
                                                @if (config('settings.currency_position') == 2)
                                                    {{ number_format($sale->net_total,2,'.','') }} {{ config('settings.currency_symbol') }}
                                                @else 
                                                    {{ config('settings.currency_symbol') }} {{ number_format($sale->net_total,2,'.','') }}
                                                @endif
                                            </td>
                                        </tr>
                                        @if($sale->total_commission)
                                        <tr>
                                            <td colspan="5"></td>
                                            <td  class="text-right no font-weight-bolder">COMMISSION ({{ $sale->commission_rate }}%)</td>
                                            <td class="text-right no font-weight-bolder">
                                                @if (config('settings.currency_position') == 2)
                                                    {{ number_format($sale->total_commission,2,'.','') }} {{ config('settings.currency_symbol') }}
                                                @else 
                                                    {{ config('settings.currency_symbol') }} {{ number_format($sale->total_commission,2,'.','') }}
                                                @endif
                                            </td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td colspan="5"></td>
                                            <td  class="text-right no font-weight-bolder">PAYABLE AMOUNT</td>
                                            <td class="text-right no font-weight-bolder">
                                                @if (config('settings.currency_position') == 2)
                                                    {{ number_format($sale->payable_amount,2,'.','') }} {{ config('settings.currency_symbol') }}
                                                @else 
                                                    {{ config('settings.currency_symbol') }} {{ number_format($sale->payable_amount,2,'.','') }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"></td>
                                            <td  class="text-right no font-weight-bolder">PAID AMOUNT</td>
                                            <td class="text-right no font-weight-bolder">
                                                @if (config('settings.currency_position') == 2)
                                                    {{ number_format($sale->paid_amount,2,'.','') }} {{ config('settings.currency_symbol') }}
                                                @else 
                                                    {{ config('settings.currency_symbol') }} {{ number_format($sale->paid_amount,2,'.','') }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"></td>
                                            <td  class="text-right no font-weight-bolder">DUE AMOUNT</td>
                                            <td class="text-right no font-weight-bolder">
                                                @if (config('settings.currency_position') == 2)
                                                    {{ number_format($sale->due_amount,2,'.','') }} {{ config('settings.currency_symbol') }}
                                                @else 
                                                    {{ config('settings.currency_symbol') }} {{ number_format($sale->due_amount,2,'.','') }}
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            

                                <table style="width: 100%;">
                                    <tr>
                                        <td class="text-center">
                                            <div class="font-size-10" style="width:250px;float:left;padding-top:50px;">
                                                <p style="margin:0;padding:0;"></p>
                                                <p class="dashed-border"></p>
                                                <p style="margin:0;padding:0;text-transform: capitalize;font-weight:normal;">ডেলিভারী ইনচার্জ</p>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="font-size-10" style="width:250px;padding-top:50px;margin:0 auto;">
                                                <p style="margin:0;padding:0;"></p> 
                                                <p class="dashed-border"></p>
                                                <p style="margin:0;padding:0;text-transform: capitalize;font-weight:normal;">গ্রহনকারীর স্বাক্ষর</p>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="font-size-10" style="width:250px;float:right;padding-top:50px;">
                                                <p style="margin:0;padding:0;"></p>
                                                <p class="dashed-border"></p>
                                                <p style="margin:0;padding:0;text-transform: capitalize;font-weight:normal;">অর্ডার গ্রহনকারী</p>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <table style="width: 100%;margin-top:10px;">
                                    <tr>
                                        <td class="text-center">
                                            <b>বিঃ দ্রঃ বিক্রিত পণ্য ফেরত যোগ্য নয়</b>
                                        </td>
                                    </tr>
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