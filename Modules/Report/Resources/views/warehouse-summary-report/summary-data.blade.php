
<div class="col-md-6 mb-5">
    <div class="card card-custom card-border">
        <div class="card-header bg-primary">
            <div class="card-title text-center">
                <h2 class="card-label text-white">Total Purchase</h2>
            </div>
        </div>
        <div class="card-body">
            @if ($total_purchase)
                <h5>{{ number_format($total_purchase,2,'.',',') }} Tk</h5>
                @if($total_purchase > 0)
                <h5>{{ numberTowords($total_purchase) }} Taka</h5>
                @endif
            @else
            <h5>0.00 Tk</h5>
            <h5>Zero Taka</h5>
            @endif
        </div>
    </div>
</div>

<div class="col-md-6 mb-5">
    <div class="card card-custom card-border">
        <div class="card-header bg-primary">
            <div class="card-title text-center">
                <h2 class="card-label text-white">Total Sale</h2>
            </div>
        </div>
        <div class="card-body">
            @if ($total_sale)
                <h5>{{ number_format($total_sale,2,'.',',') }} Tk</h5>
                @if($total_sale > 0)
                <h5>{{ numberTowords($total_sale) }} Taka</h5>
                @endif
            @else
            <h5>0.00 Tk</h5>
            <h5>Zero Taka</h5>
            @endif
        </div>
    </div>
</div>

<div class="col-md-6 mb-5">
    <div class="card card-custom card-border">
        <div class="card-header bg-primary">
            <div class="card-title text-center">
                <h2 class="card-label text-white">Total Purchase Return</h2>
            </div>
        </div>
        <div class="card-body">
            @if ($total_purchase_return)
                <h5>{{ number_format($total_purchase_return,2,'.',',') }} Tk</h5>
                @if($total_purchase_return > 0)
                <h5>{{ numberTowords($total_purchase_return) }} Taka</h5>
                @endif
            @else
            <h5>0.00 Tk</h5>
            <h5>Zero Taka</h5>
            @endif
        </div>
    </div>
</div>

<div class="col-md-6 mb-5">
    <div class="card card-custom card-border">
        <div class="card-header bg-primary">
            <div class="card-title text-center">
                <h2 class="card-label text-white">Total Sale Return</h2>
            </div>
        </div>
        <div class="card-body">
            @if ($total_sale_return)
                <h5>{{ number_format($total_sale_return,2,'.',',') }} Tk</h5>
                @if($total_sale_return > 0)
                <h5>{{ numberTowords($total_sale_return) }} Taka</h5>
                @endif
            @else
            <h5>0.00 Tk</h5>
            <h5>Zero Taka</h5>
            @endif
        </div>
    </div>
</div>

<div class="col-md-6 mb-5">
    <div class="card card-custom card-border">
        <div class="card-header bg-primary">
            <div class="card-title text-center">
                <h2 class="card-label text-white">Total Product Damage</h2>
            </div>
        </div>
        <div class="card-body">
            @if ($total_damage)
                <h5>{{ number_format($total_damage,2,'.',',') }} Tk</h5>
                @if($total_damage > 0)
                <h5>{{ numberTowords($total_damage) }} Taka</h5>
                @endif
            @else
            <h5>0.00 Tk</h5>
            <h5>Zero Taka</h5>
            @endif
        </div>
    </div>
</div>

<div class="col-md-6 mb-5">
    <div class="card card-custom card-border">
        <div class="card-header bg-primary">
            <div class="card-title text-center">
                <h2 class="card-label text-white">Total Expense</h2>
            </div>
        </div>
        <div class="card-body">
            @if ($total_expense)
                <h5>{{ number_format($total_expense,2,'.',',') }} Tk</h5>
                @if($total_expense > 0)
                <h5>{{ numberTowords($total_expense) }} Taka</h5>
                @endif
            @else
            <h5>0.00 Tk</h5>
            <h5>Zero Taka</h5>
            @endif
        </div>
    </div>
</div>

<div class="col-md-6 mb-5">
    <div class="card card-custom card-border">
        <div class="card-header bg-primary">
            <div class="card-title text-center">
                <h2 class="card-label text-white">Supplier Total Due</h2>
            </div>
        </div>
        <div class="card-body">
            @if ($total_supplier_due)
                <h5>{{ number_format($total_supplier_due,2,'.',',') }} Tk</h5>
                @if($total_supplier_due > 0)
                <h5>{{ numberTowords($total_supplier_due) }} Taka</h5>
                @endif
            @else
            <h5>0.00 Tk</h5>
            <h5>Zero Taka</h5>
            @endif
        </div>
    </div>
</div>

<div class="col-md-6 mb-5">
    <div class="card card-custom card-border">
        <div class="card-header bg-primary">
            <div class="card-title text-center">
                <h2 class="card-label text-white">Depo Total Due</h2>
            </div>
        </div>
        <div class="card-body">
            @if ($total_depo_due)
                <h5>{{ number_format($total_depo_due,2,'.',',') }} Tk</h5>
                @if($total_depo_due > 0)
                <h5>{{ numberTowords($total_depo_due) }} Taka</h5>
                @endif
            @else
            <h5>0.00 Tk</h5>
            <h5>Zero Taka</h5>
            @endif
        </div>
    </div>
</div>

<div class="col-md-6 mb-5">
    <div class="card card-custom card-border">
        <div class="card-header bg-primary">
            <div class="card-title text-center">
                <h2 class="card-label text-white">Dealer Total Due</h2>
            </div>
        </div>
        <div class="card-body">
            @if ($total_dealer_due)
                <h5>{{ number_format($total_dealer_due,2,'.',',') }} Tk</h5>
                @if($total_dealer_due > 0)
                <h5>{{ numberTowords($total_dealer_due) }} Taka</h5>
                @endif
            @else
            <h5>0.00 Tk</h5>
            <h5>Zero Taka</h5>
            @endif
        </div>
    </div>
</div>
