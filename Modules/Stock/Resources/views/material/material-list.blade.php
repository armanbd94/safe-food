@php
    $grand_total = 0;
@endphp
@if (!$categories->isEmpty())
    @foreach ($categories as $index => $category)
        @if (!$category->materials->isEmpty())
            <div class="col-md-12 text-center"><h3 class="py-3 bg-warning text-white" style="max-width:300px;margin: 50px auto 10px auto;">{{ ($index+1).' : '.$category->name }}</h3></div>
            
            <table id="dataTable" class="table table-bordered table-hover mb-5">
                <thead class="bg-primary">
                    <tr>
                        <th>Sl</th>
                        <th>Material Name</th>
                        <th class="text-center">Material Type</th>
                        <th class="text-center">Stock Unit</th>
                        <th class="text-center">Stock Qty</th>
                        <th class="text-right">Per Unit Cost</th>
                        <th class="text-right">Stock Value</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @if ($material_id)
                        @foreach ($category->materials as $key => $item)
                            @if ($material_id == $item->id)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $item->material_name }}</td>
                                <td class="text-center">{{ MATERIAL_TYPE[$item->type] }}</td>
                                <td class="text-center">{{ $item->unit->unit_name }}</td>
                                <td class="text-center">{{ $item->qty ?? 0 }}</td>
                                <td class="text-right">{{ number_format($item->cost,2,'.','') }}</td>
                                
                                <td class="text-right">{{ number_format(($item->qty * $item->cost),2,'.','') }}</td>
                                @php
                                    $total += (($item->qty ?? 0) * ($item->cost ?? 0));
                                @endphp
                            </tr>
                            @endif
                        @endforeach
                    @else
                    @foreach ($category->materials as $key => $item)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $item->material_name }}</td>
                        <td class="text-center">{{ MATERIAL_TYPE[$item->type] }}</td>
                        <td class="text-center">{{ $item->unit->unit_name }}</td>
                        <td class="text-center">{{ $item->qty ?? 0 }}</td>
                        <td class="text-right">{{ number_format($item->cost,2,'.','') }}</td>
                        
                        <td class="text-right">{{ number_format(($item->qty * $item->cost),2,'.','') }}</td>
                        @php
                            $total += (($item->qty ?? 0) * ($item->cost ?? 0));
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