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
                    @if($stock_out_products == 0)
                        @if ($order_sheet->delivery_status == 2)
                            <button type="button" class="btn btn-success btn-sm font-weight-bolder mr-3"  id="change_status"> 
                            <i class="fas fa-truck"></i> Change Challan Delivery Status</button>
                        @endif
                        <button type="button" class="btn btn-primary btn-sm " id="print-invoice"> <i class="fas fa-print"></i> Print</button>
                    @endif
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
                        @if($stock_out_products > 0 && $order_sheet->delivery_status == 2)
                        <div class="col-md-12">
                            <h5 class="text-center"><i class="fas fa-exclamation-triangle text-warning"></i> এই চালান তৈরি করার জন্য যে পরিমাণ প্রোডাক্ট দরকার তা নেই। নিচে তার তালিকা দেয়া হল। <i class="fas fa-exclamation-triangle  text-warning"></i></h5>
                            <table id="dataTable" class="table table-bordered table-hover">
                                <thead class="bg-primary">
                                    <tr>
                                        <td class="text-center"></td>
                                        <td class="text-white"><b>নাম</b></td>
                                        <td class="text-center text-white"><b>স্টক</b></td>
                                        <td class="text-center text-white"><b>অর্ডার</b></td>
                                        <td class="text-center text-white"><b>প্রোডাকশন</b></td> 
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $key => $value)
                                        @php
                                            $required_qty = 0;
                                            $bg_color = '';
                                            $required_qty = ($value->stock_qty ? $value->stock_qty : 0) - $value->ordered_qty;
                                            if($required_qty < 0)
                                            {
                                                $required_qty = str_replace('-','',$required_qty);
                                                $bg_color = 'bg-danger text-white';
                                            }
                                        @endphp
                                        <tr class="{{ $bg_color }}">
                                            <td class="text-center">{{ convert_bangla_number($key+1) }}</td>
                                            <td>{{ $value->name }}</td>
                                            <td class="text-center">{{ convert_bangla_number(number_format(($value->stock_qty ?? 0),2,'.','')) }}</td>
                                            <td class="text-center">{{ convert_bangla_number(number_format($value->ordered_qty,2,'.','')) }}</td>
                                            <td class="text-center">{{ convert_bangla_number(number_format($required_qty,2,'.','')) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
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
                                        border-bottom: 1px solid #000;
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
                                        color: #000;
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
                                        border-left: 6px solid #000;
                                    }
        
                                    .invoice table {
                                        width: 100%;
                                        border-collapse: collapse;
                                        border-spacing: 0;
                                        margin-bottom: 20px;
                                    }
        
                                    .invoice table th {
                                        background: #000;
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
                                        color: #000;
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
                                        background: #000
                                    }
        
                                    .invoice table .total {
                                        background: #000;
                                        color: #fff
                                    }
        
                                    .invoice table tbody tr:last-child td {
                                        border: none
                                    }
                                    .invoice .challan_table td{
                                        border: 1px solid #000 !important;
                                    }
                                    .invoice .challan_table tbody tr:last-child td {
                                        border: 1px solid #000 !important;
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
                                        color: #000;
                                        border-top: 1px solid #000
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
                                        color: #000 !important;
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
                                        /* .no_print {display: block;} */
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
                                            /* margin-bottom: 100px !important; */
                                        }
                                        html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, font, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, dl, dt, dd, ol, ul, li, fieldset, form, label, legend,  {
                                            font-size: 10pt !important;
                                        }
                                        #product_table tbody td{
                                            font-size: 9pt !important;
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
                                            color: #000 !important;
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
                                                    <p class="name" style="margin-top:5px;font-weight: normal;margin:0;"><b>চালানের তালিকা</b></p>
                                                    
                                                    
                                                </td>
                                            </tr>
                                        </table>
                                        <table>
                                            <tr>
                                                <td class="text-left font-weight-bolder"><p style="margin:0;">চালান নং: {{ convert_bangla_number($order_sheet->sheet_no) }}</p></td>
                                                <td class="text-right font-weight-bolder"><p style="margin:0;">তারিখ: {{ convert_bangla_number(date('d-m-Y',strtotime($order_sheet->delivery_date))) }}</p></td>
                                            </tr>
                                        </table>
                                        @if (!$challans->isEmpty())
                                            @foreach ($challan_list as $key => $challan)
                                            <table cellspacing="0" cellpadding="0" class="challan_table">
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center"></td>
                                                        <td><b>{{ $key }} লাইন</b></td>
                                                        <td class="text-center"><b>এলাকার নাম</b></td>
                                                        <td class="text-center"><b>কমিশনের হার (%)</b></td>
                                                        <td class="text-center"><b>মোট বিক্রয়</b></td>
                                                        <td class="text-center"><b>মোট কমিশন</b></td> 
                                                        <td class="text-right"><b>সর্বমোট বিক্রয়</b></td>
                                                        <td class="text-right"><b>মোট জমা</b></td>
                                                        <td class="text-right"><b>মোট বকেয়া</b></td>
                                                        <td class="text-right"><b>লেনদেনের অবস্থা</b></td>
                                                        <td class="text-center no_print"><b>প্রিন্ট বিল</b></td>
                                                    </tr>

                                                    @foreach ($challan as $index => $value)
                                                        <tr>
                                                            <td class="text-center">{{ convert_bangla_number($index+1) }}</td>
                                                            <td class="text-left">{{ $value['order_from'] == 1 ? $value['depo_name'].' (ডিপো)' : $value['dealer_name'] }}</td>
                                                            <td class="text-center">{{ $value['area']}}</td>
                                                            <td class="text-center">{{ convert_bangla_carton_size($value['commission_rate'])}}</td>
                                                            <td class="text-right">{{ convert_bangla_carton_size(number_format($value['grand_total'],2,'.',','))}}</td>
                                                            <td class="text-right">{{ convert_bangla_carton_size(number_format($value['total_commission'],2,'.',','))}}</td>
                                                            <td class="text-right">{{ convert_bangla_carton_size(number_format($value['net_total'],2,'.',','))}}</td>
                                                            <td class="text-center"></td>
                                                            <td class="text-center"></td>
                                                            <td class="text-center"></td>
                                                            <td class="text-center no_print">
                                                                @if ($value['order_from'] == 1)
                                                                <a  class="btn btn-danger btn-sm text-white @if ($order_sheet->delivery_status == 2) {{ 'disabled' }} @endif" href="order/depo-bill/{{ $order_sheet->id }}/print/{{ $value['depo_id'] }}/{{ $order_sheet->order_date }}/{{ $order_sheet->delivery_date }}" target="_blank" style="color:white !important;"><i class="far fa-file-pdf"></i> ক্লিক করুন</a>
                                                                @else
                                                                <a  class="btn btn-danger btn-sm text-white @if ($order_sheet->delivery_status == 2) {{ 'disabled' }} @endif" href="order/dealer-bill/{{ $order_sheet->id }}/print/{{ $value['dealer_id'] }}/{{ $order_sheet->order_date }}/{{ $order_sheet->delivery_date }}" target="_blank" style="color:white !important;"><i class="far fa-file-pdf"></i> ক্লিক করুন</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            @endforeach
                                        @endif
                                        
                                                
                                            
                                        <table style="width: 100%;">
                                            <tr>
                                                <td>
                                                    <div class="font-size-10" style="width:250px;float:right;padding-top:20px;text-align:center;">
                                                        <p style="margin:0;padding:0;"></p>
                                                        <p class="dashed-border"></p>
                                                        <p style="margin:0;padding:0;text-transform: capitalize;font-weight:normal;">কর্তৃপক্ষের স্বাক্ষর</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
        
                            </div>
                        </div>
                        @endif 
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
    $(document).on('click','#print-invoice',function(){
        var mode = 'iframe'; // popup
        var close = mode == "popup";
        var options = {
            mode: mode,
            popClose: close
        };
        $("#invoice").printArea(options);
    });

    $(document).on('click','#change_status',function(){
        Swal.fire({
            title: 'Are you sure to change delivery status of this challan?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "{{ url('order-challan-change-delivery-status',$order_sheet->id) }}",
                    type: "GET",
                    dataType: "JSON",
                }).done(function (response) {
                    if (response.status == "success") {
                        Swal.fire("Status Changed", response.message, "success").then(function () {
                            window.location.replace("{{ url('production-order-challan',$order_sheet->id) }}");
                        });
                    }
                    if (response.status == "error") {
                        Swal.fire('Oops...', response.message, "error");
                    }
                }).fail(function () {
                    Swal.fire('Oops...', "Somthing went wrong with ajax!", "error");
                });
            }
        });
    });
});


</script>
@endpush