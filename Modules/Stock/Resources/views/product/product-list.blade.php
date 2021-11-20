@php
    $grand_total = 0;
@endphp
@if (!$categories->isEmpty())
    @foreach ($categories as $index => $category)
        @if (!$category->products->isEmpty())
            <div class="col-md-12 text-center"><h3 class="py-3 bg-warning text-white" style="max-width:300px;margin: 50px auto 10px auto;">{{ ($index+1).' : '.$category->name }}</h3></div>
            
            <table id="dataTable" class="table table-bordered table-hover mb-5">
                <thead class="bg-primary">
                    <tr>
                        <th>Sl</th>
                        <th>Product Name</th>
                        <th class="text-center">Carton Size</th>
                        <th class="text-center">Unit</th>
                        <th class="text-center">Stock Qty</th>
                        <th class="text-right">Price</th>
                        <th class="text-right">Stock Value</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @if ($product_id)
                        @foreach ($category->products as $key => $item)
                            @if ($product_id == $item->id)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td class="text-center">{{ convert_english_carton_size($item->unit->unit_name) }}</td>
                                <td class="text-center">{{ $item->base_unit->unit_name }}</td>
                                <td class="text-center">{{ $item->base_unit_qty ?? 0 }}</td>
                                <td class="text-right">{{ number_format($item->regular_price->unit_price,2,'.','') }}</td>
                                <td class="text-right">{{ number_format(($item->base_unit_qty * $item->regular_price->unit_price),2,'.','') }}</td>
                                @php
                                    $total += (($item->base_unit_qty ?? 0) * ($item->regular_price->unit_price));
                                @endphp
                            </tr>
                            @endif
                        @endforeach
                    @else
                    @foreach ($category->products as $key => $item)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $item->name }}</td>
                        <td class="text-center">{{ convert_english_carton_size($item->unit->unit_name) }}</td>
                        <td class="text-center">{{ $item->base_unit->unit_name }}</td>
                        <td class="text-center">{{ $item->base_unit_qty ?? 0 }}</td>
                        <td class="text-right">{{ number_format($item->regular_price->unit_price,2,'.','') }}</td>
                        <td class="text-right">{{ number_format(($item->base_unit_qty * $item->regular_price->unit_price),2,'.','') }}</td>
                        @php
                            $total += (($item->base_unit_qty ?? 0) * ($item->regular_price->unit_price));
                        @endphp
                    </tr>
                    @endforeach
                    @endif
                    
                    
                </tbody>
                <tfoot>
                    <tr class="bg-primary">
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th style="text-align: right !important;font-weight:bold;color:white;">Total</th>
                        <th style="text-align: right !important;font-weight:bold;color:white;">{{ number_format($total,2,'.','') }}</th>

                    </tr>
                </tfoot>
            </table>
            
            @php
                $grand_total += $total;
            @endphp
        @endif
    @endforeach
    <h3 class="bg-dark text-white font-weight-bolder p-3 text-right">Grand Total = {{ number_format($grand_total,2,'.','') }}</h3>
@else 
    <div class="col-md-12 text-center"><h3 class="py-3 bg-danger text-white">Stock Data is Empty</h3></div>
@endif 