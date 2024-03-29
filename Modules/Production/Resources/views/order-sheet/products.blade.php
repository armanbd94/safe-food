<div class="col-md-12 text-center font-weight-bolder pb-5">
    <h3>Preoduction Order Sheet</h3>
    <h6>Order Date: {{ !empty($sale_list) ? $sale_list[0]->sale_date : date('Y-m-d') }}</h6>
    <h6>Delivery Date: {{ !empty($sale_list) ? $sale_list[0]->delivery_date : date('Y-m-d') }}</h6>
    <h6>Sheet No.: {{ $sheet_no }}</h6>
    <input type="hidden" name="sheet_no" value="{{ $sheet_no }}">
    <input type="hidden" name="order_date" value="{{ !empty($sale_list) ? $sale_list[0]->sale_date : date('Y-m-d') }}">
    <input type="hidden" name="delivery_date" value="{{ !empty($sale_list) ? $sale_list[0]->delivery_date : date('Y-m-d') }}">
</div>
<div class="col-sm-12">
    <table id="dataTable" class="table table-bordered table-hover">
        <thead class="bg-primary">
            <tr>
                <th class="text-center">Sl</th>
                <th>Name</th>
                <th class="text-center">Carton Size</th>
                <th class="text-center">Stock Quantity</th>
                <th class="text-center">Ordered Qunatity</th>
                <th class="text-center">Production Quantity</th>
                <th class="text-right">Total Order Value</th>
            </tr>
        </thead>
        <tbody>
        @if (!$products->isEmpty())
            @php
                $item = 0;
                $total_ordered_qty = $total_required_qty = 0;
                $total_order_value = 0;
            @endphp
            @foreach ($products as $key => $value)
            @php
                $required_qty = 0;
                $required_qty = ($value->stock_qty ? $value->stock_qty : 0) - $value->ordered_qty;
                $required_qty = $required_qty < 0 ?  str_replace('-','',$required_qty) : 0;
                $item++;
                $total_ordered_qty += $value->ordered_qty;
                $total_required_qty += $required_qty;
                $total_order_value += $value->total_order_value;
            @endphp
                <tr>
                    <td class="text-center">{{ $key+1 }}</td>
                    <td>{{ $value->name }}</td>
                    <td class="text-center">{{ $value->ctn_size }}</td>
                    <td class="text-center">{{ number_format(($value->stock_qty ?? 0),2,'.','') }}</td>
                    <td class="text-center">{{ number_format($value->ordered_qty,2,'.','') }}</td>
                    <td class="text-center">{{ number_format($required_qty,2,'.','') }}</td>
                    <td class="text-right">{{ number_format($value->total_order_value,2,'.',',') }}</td>
                    <input type="hidden" name="products[{{ $key+1 }}][id]" value="{{ $value->id }}">
                    <input type="hidden" name="products[{{ $key+1 }}][stock_qty]" value="{{ $value->stock_qty ?? 0 }}">
                    <input type="hidden" name="products[{{ $key+1 }}][ordered_qty]" value="{{ $value->ordered_qty }}">
                    <input type="hidden" name="products[{{ $key+1 }}][required_qty]" value="{{ $required_qty }}">
                    <input type="hidden" name="products[{{ $key+1 }}][total]" value="{{ $value->total_order_value }}">
                </tr>
            @endforeach
            <tr>
                <td colspan="4"><h6><b>Total</b></h6></td>
                <td class="text-center"><h6><b>{{ number_format($total_ordered_qty,2,'.','') }}</b></h6></td>
                <td class="text-center"><h6><b>{{ number_format($total_required_qty,2,'.','') }}</b></h6></td>
                <td class="text-right"><h6><b>{{ number_format($total_order_value,2,'.',',') }}</b></h6></td>
                <input type="hidden" name="item" value="{{ $item }}">
                <input type="hidden" name="total_qty" value="{{ $total_ordered_qty }}">
                <input type="hidden" name="total_order_value" value="{{ $total_order_value }}">
                <input type="hidden" name="total_commission" value="{{ $total_commission }}">
            </tr>
            <tr>
                <td colspan="6"><h6><b>Commission</b></h6></td>
                <td class="text-right"><h6><b>{{ number_format($total_commission,2,'.',',') }}</b></h6></td>
            </tr>
        @else 
        <tr><td colspan="7" class="text-danger font-weight-bolder">No Data Found</td></tr>
        @endif
        </tbody>
    </table>
    @if (!$sale_list->isEmpty())
        @foreach ($sale_list as $key => $sale)
        <input type="hidden" name="memos[{{ $key+1 }}][sale_id]" value="{{ $sale->id }}">
        @endforeach
    @endif
</div>

