<?php

namespace Modules\Production\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use Modules\Production\Entities\OrderSheet;

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
            $order = DB::table('order_sheets')->find($id);
            $products = DB::table('order_sheet_products as osp')
            ->join('products as p','osp.product_id','=','p.id')
            ->selectRaw('p.id,p.name,p.base_unit_qty as stock_qty,osp.ordered_qty,(ifnull(p.base_unit_qty,0) - osp.ordered_qty) as required_qty')
            ->where('osp.order_sheet_id',$id)
            ->having('required_qty','<',0)
            ->get();

            $stock_out_products = $products->count();

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
            

            $data = [
                'order_sheet'              => $order,
                'products'           => $products,
                'stock_out_products' => $stock_out_products,
                'challan_list'       => $challan_list,
                'challans'           =>  $challans
            ];
       
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


}
