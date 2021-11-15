<?php

namespace Modules\Production\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Sale\Entities\Sale;
use Illuminate\Support\Facades\DB;
use Modules\Product\Entities\Product;
use App\Http\Controllers\BaseController;
use Modules\Production\Entities\OrderSheet;
use Modules\Product\Entities\WarehouseProduct;

class ProductionOrderChallanController extends BaseController
{

    public function __construct(OrderSheet $model)
    {
        $this->model = $model;
    }

    public function index(int $id)
    {
        if(permission('production-order-sheet-access')){
            $this->setPageData('Order Challan','Order Challan','fas fa-file-export',[['name' => 'Order Challan']]);
            $data = [];
            $stock_out_products = 0;
            $order = DB::table('order_sheets')->find($id);
            if($order->delivery_status == 2){
                $products = DB::table('order_sheet_products as osp')
                ->join('products as p','osp.product_id','=','p.id')
                ->selectRaw('p.id,p.name,p.base_unit_qty as stock_qty,osp.ordered_qty,(ifnull(p.base_unit_qty,0) - osp.ordered_qty) as required_qty')
                ->where('osp.order_sheet_id',$id)
                ->having('required_qty','<',0)
                ->get();
    
                $stock_out_products = $products->count();
                $data['products']   = $products;
            }
            $data['stock_out_products'] = $stock_out_products;

            $challans = DB::table('order_sheet_memos as osm')
            ->selectRaw('s.depo_id,de.name as depo_name,IF(s.order_from=2,s.dealer_id,NULL) as dealer_id,IF(s.order_from=2,del.name,NULL) as dealer_name,
            d.name as district,a.name as area_name,sum(s.grand_total) as grand_total,s.commission_rate,sum(s.total_commission) as total_commission,sum(s.net_total) as net_total,s.order_from')
            ->join('sales as s','osm.sale_id','=','s.id')
            ->leftJoin('depos as de','s.depo_id','=','de.id')
            ->join('dealers as del','s.dealer_id','=','del.id')
            ->join('locations as d','s.district_id','=','d.id')
            ->join('locations as a','s.area_id','=','a.id')
            ->groupBy('s.district_id','s.depo_id')
            ->where('osm.order_sheet_id',$id)
            ->orderBy('s.district_id','asc')
            ->orderBy('s.created_at','asc')
            ->get();
            $challan_list = [];
            if(!$challans->isEmpty())
            {
                foreach ($challans as $key => $value) {
                    $challan_list[$value->district][] = [
                        "depo_id"          => $value->depo_id,
                        "depo_name"        => $value->depo_name,
                        "dealer_name"      => $value->dealer_name,
                        "dealer_id"        => $value->dealer_id,
                        "district"         => $value->district,
                        "area"             => $value->area_name,
                        "grand_total"      => $value->grand_total,
                        "commission_rate"  => $value->commission_rate,
                        "total_commission" => $value->total_commission,
                        "net_total"        => $value->net_total,
                        "order_from"       => $value->order_from,
                    ];
                }
            }
            
            $data['order_sheet']        = $order;
            $data['challan_list']       = $challan_list;
            $data['challans' ]          =  $challans;
       
            return view('production::challan.index',$data);
        }else{
            return $this->access_blocked();
        }
    }

    public function create()
    {
        if(permission('todays-production-order-sheet-access')){
            $this->setPageData('Today\'s Production Order Sheet','Today\'s Production Order Sheet','fas fa-file',[['name' => 'Today\'s Production Order Sheet']]);
            return view('production::order-sheet.create');
        }else{
            return $this->access_blocked(); 
        }
    }

    public function dealer_invoice(int $order_sheet_id, int $dealer_id, string $order_date, string $delivery_date)
    {
        
        $this->setPageData('Print Bill','Print Bill','fas fa-file',[['name' => 'Print Bill']]);

        $sale = Sale::with(['sale_products','dealer','district','upazila','area','memo'])
        ->whereHas('memo',function($q) use ($order_sheet_id){
            $q->where('order_sheet_id',$order_sheet_id);
        })
        ->where(['order_from'=>2,'dealer_id'=>$dealer_id,'sale_date'=>$order_date,'delivery_date'=>$delivery_date])
        ->first();

        return view('production::bill.dealer',compact('sale'));
    }

    public function depo_invoice(int $order_sheet_id, int $depo_id, string $order_date, string $delivery_date)
    {
        
        $this->setPageData('Print Bill','Print Bill','fas fa-file',[['name' => 'Print Bill']]);
        $depo_sale_data = DB::table('sales as s')
        ->selectRaw('de.name as depo_name,sum(s.grand_total) as grand_total,s.commission_rate,
        sum(s.total_commission) as total_commission,sum(s.net_total) as net_total,de.mobile_no,d.name as district,u.name as upazila,a.name as area,de.address,s.sale_date,s.delivery_date')
        ->leftJoin('order_sheet_memos as osm','s.id','=','osm.sale_id')
        ->leftJoin('depos as de','s.depo_id','=','de.id')
        ->leftJoin('locations as d','de.district_id','=','d.id')
        ->leftJoin('locations as u','de.upazila_id','=','u.id')
        ->leftJoin('locations as a','de.area_id','=','a.id')
        ->groupBy('s.depo_id')
        ->where(['s.order_from'=>1,'s.depo_id'=>$depo_id,'s.sale_date'=>$order_date,'s.delivery_date'=>$delivery_date,'osm.order_sheet_id'=>$order_sheet_id])
        ->first();
        $depo_sale_products = DB::table('sale_products as sp')
            ->join('sales as s','sp.sale_id','=','s.id')
            ->leftJoin('order_sheet_memos as osm','s.id','=','osm.sale_id')
            ->join('products as p','sp.product_id','=','p.id')
            ->join('units as bu','sp.base_unit_id','=','bu.id')
            ->join('units as u','p.unit_id','=','u.id')
            ->selectRaw('p.id,p.name,bu.unit_name as sale_unit,u.unit_name as ctn_size,SUM(sp.unit_qty) as unit_qty,
            SUM(sp.qty) as qty, SUM(sp.free_qty) as free_qty,sp.net_unit_price,sum(sp.total) as total_order_value')
            ->groupBy('sp.product_id')
            ->where(['s.order_from'=>1,'s.depo_id'=>$depo_id,'s.sale_date'=>$order_date,'s.delivery_date'=>$delivery_date,'osm.order_sheet_id'=>$order_sheet_id])
            ->orderBy('p.id','asc')
            ->get();

        $sales = Sale::with(['sale_products','dealer','district','upazila','area','memo'])
        ->whereHas('memo',function($q) use ($order_sheet_id){
            $q->where('order_sheet_id',$order_sheet_id);
        })
        ->where(['order_from'=>1,'depo_id'=>$depo_id,'sale_date'=>$order_date,'delivery_date'=>$delivery_date])
        ->get();
        
        return view('production::bill.depo',compact('depo_sale_data','depo_sale_products','sales'));
    }

    public function change_delivery_status(int $order_sheet_id)
    {

        DB::beginTransaction();
        try {
            $order_sheet = OrderSheet::with('products','memos')->find($order_sheet_id);
            if($order_sheet)
            {
                
                if(!$order_sheet->products->isEmpty())
                {
                    foreach ($order_sheet->products as $value) {
                        $product = Product::find($value->id);
                        if($product)
                        {
                            $product->base_unit_qty -= $value->pivot->ordered_qty;
                            $product->update();
                        }
                        $warehouse_product = WarehouseProduct::where(['warehouse_id'=>1,'product_id'=>$value->id])->first();
                        if($warehouse_product)
                        {
                            $warehouse_product->qty -= $value->pivot->ordered_qty;
                            $warehouse_product->update();
                        }
                    }
                }

                if(!$order_sheet->memos->isEmpty())
                {
                    foreach ($order_sheet->memos as $memo) {
                        Sale::find($memo->id)->update(['delivery_status'=>1]);
                    }
                }
                
                $order_sheet->delivery_status = 1;
                if($order_sheet->update())
                {
                    $output = ['status'=>'success','message'=>'Challam delivery status has been changed successfully!'];
                }else{
                    $output = ['status'=>'error','message'=>'Failed to change delivery status!'];
                }
            }else{
                $output = ['status'=>'error','message'=>'Failed to change delivery status!'];
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            $output = ['status'=>'error','message'=>$th->getMessage()];
        }
        return response()->json($output);
        
    }


}
