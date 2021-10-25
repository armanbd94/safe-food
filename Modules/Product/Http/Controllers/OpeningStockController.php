<?php

namespace Modules\Product\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use Modules\Product\Entities\OpeningStock;
use Modules\Product\Entities\WarehouseProduct;
use Modules\Product\Entities\OpeningStockProduct;
use Modules\Product\Http\Requests\OpeningStockFormRequest;

class OpeningStockController extends BaseController
{
    public function __construct(OpeningStock $model)
    {
        $this->model = $model;
    }
    
    public function index()
    {
        if(permission('opening-stock-access')){
            $this->setPageData('Manage Opening Stock','Manage Opening Stock','fas fa-shopping-cart',[['name' => 'Manage Opening Stock']]);
            $warehouses = DB::table('warehouses')->where('status',1)->pluck('name','id');
            return view('product::opening-stock.index',compact('warehouses'));
        }else{
            return $this->access_blocked();
        }
    }

    public function get_datatable_data(Request $request)
    {
        if($request->ajax()){
            if(permission('opening-stock-access')){

                if (!empty($request->opening_no)) {
                    $this->model->setOpeningNo($request->opening_no);
                }
                if (!empty($request->warehouse_id)) {
                    $this->model->setWarehouseID($request->warehouse_id);
                }
                if (!empty($request->from_date)) {
                    $this->model->setFromDate($request->from_date);
                }
                if (!empty($request->to_date)) {
                    $this->model->setToDate($request->to_date);
                }

                $this->set_datatable_default_properties($request);//set datatable default properties
                $list = $this->model->getDatatableList();//get table data
                $data = [];
                $no = $request->input('start');
                foreach ($list as $value) {
                    $no++;
                    $action = '';
                    if(permission('opening-stock-edit')){
                        $action .= ' <a class="dropdown-item" href="'.route("opening.stock.edit",$value->id).'">'.self::ACTION_BUTTON['Edit'].'</a>';
                    }

                    if(permission('opening-stock-view')){
                        $action .= ' <a class="dropdown-item view_data" href="'.route("opening.stock.view",$value->id).'">'.self::ACTION_BUTTON['View'].'</a>';
                    }
                    
                    if(permission('opening-stock-delete')){
                        $action .= ' <a class="dropdown-item delete_data"  data-id="' . $value->id . '" data-name="' . $value->adjustment_no . '">'.self::ACTION_BUTTON['Delete'].'</a>';
                    }
                    
                    $row = [];
                    if(permission('opening-stock-bulk-delete')){
                        $row[] = row_checkbox($value->id);//custom helper function to show the table each row checkbox
                    }
                    $products = '';
                    if(!$value->products->isEmpty())
                    {
                        $products .= '<ul style="list-style:none;margin:0;padding:0;">';
                        foreach ($value->products as $product) {
                            $products .= "<li class='text-left mb-3'>$product->name <span class='badge badge-primary float-right'>". $product->pivot->base_unit_qty." </span></li>";
                        }
                        $products .= '</ul>';
                    }
                    $row[] = $no;
                    $row[] = $value->opening_no;
                    $row[] = $value->warehouse->name;
                    $row[] = $value->item;
                    $row[] = $products;
                    $row[] = number_format($value->total_qty,2,'.','');
                    $row[] = number_format($value->grand_total,2,'.','');
                    $row[] = $value->created_by;
                    $row[] = date(config('settings.date_format'),strtotime($value->date));
                    $row[] = action_button($action);//custom helper function for action button
                    $data[] = $row;
                }
                return $this->datatable_draw($request->input('draw'),$this->model->count_all(),
                $this->model->count_filtered(), $data);
            }
        }else{
            return response()->json($this->unauthorized());
        }
    }

    public function create()
    {
        if(permission('opening-stock-add')){
            $this->setPageData('Product Opening Stock Form','Product Opening Stock Form','fas fa-adjust',[['name' => 'Product Opening Stock Form']]);
            $data = [
                'opening_no' => 'OP-'.date('ym').rand(1,999),
                'warehouses'    => DB::table('warehouses')->where('status',1)->pluck('name','id')
            ];
            return view('product::opening-stock.create',$data);
        }else{
            return $this->access_blocked();
        }
        
    }

    public function store(OpeningStockFormRequest $request)
    {
        if($request->ajax()){
            if(permission('opening-stock-add')){
                // dd($request->all());
                DB::beginTransaction();
                try {
                    $opening_stock  = $this->model->create([
                        'opening_no'    => $request->opening_no,
                        'warehouse_id'  => $request->warehouse_id,
                        'item'          => $request->item,
                        'total_qty'     => $request->total_qty,
                        'total_tax'     => $request->total_tax,
                        'grand_total'   => $request->grand_total,
                        'date'          => $request->date,
                        'note'          => $request->note,
                        'created_by'    => auth()->user()->name
                    ]);

                    $products = [];
                    if($request->has('products'))
                    {
                        foreach ($request->products as $value) {
                            $products[] = [
                                'opening_stock_id'   => $opening_stock->id,
                                'product_id'      => $value['id'],
                                'base_unit_id'    => $value['base_unit_id'],
                                'base_unit_qty'   => $value['base_unit_qty'],
                                'base_unit_price' => $value['base_unit_price'],
                                'tax_rate'        => $value['tax_rate'],
                                'tax'             => $value['tax'],
                                'total'           => $value['subtotal'],
                                'created_at'      => date('Y-m-d')
                            ];

                            $warehouse_product = WarehouseProduct::where([
                                ['warehouse_id', $request->warehouse_id],
                                ['product_id', $value['id']],
                            ])->first();
                            if ($warehouse_product) {
                                $warehouse_product->qty += $value['base_unit_qty'];
                                $warehouse_product->update();
                            } else {
                                WarehouseProduct::create([
                                    'warehouse_id' => $request->warehouse_id,
                                    'product_id'   => $value['id'],
                                    'qty'          => $value['base_unit_qty'],
                                ]);
                            }

                        }
                        if(count($products) > 0)
                        {
                            OpeningStockProduct::insert($products);
                        }

                    }
                    $output  = $this->store_message($opening_stock, null);
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollback();
                    $output = ['status' => 'error','message' => $e->getMessage()];
                }
            }else{
                $output       = $this->unauthorized();
            }
            return response()->json($output);
        }else{
            return response()->json($this->unauthorized());
        }
    }


    public function show(int $id)
    {
        if(permission('opening-stock-view')){
            $this->setPageData('Opening Stock Details','Opening Stock Details','fas fa-file',[['name'=>'Opening Stock','link' => route('opening.stock')],['name' => 'Opening Stock Details']]);
            $opening_stock = $this->model->with(['warehouse:id,name','products'])->find($id);
            return view('product::opening-stock.details',compact('opening_stock'));
        }else{
            return $this->access_blocked();
        }
    }
    public function edit(int $id)
    {

        if(permission('opening-stock-edit')){
            $this->setPageData('Edit Product Opening Stock','Edit Product Opening Stock','fas fa-edit',[['name'=>'Opening Stock','link' => route('opening.stock')],['name' => 'Edit Product Opening Stock']]);
            $data = [
                'opening_stock'   => $this->model->with('products')->find($id),
                'warehouses'    => DB::table('warehouses')->where('status',1)->pluck('name','id')
            ];
            return view('product::opening-stock.edit',$data);
        }else{
            return $this->access_blocked();
        }
    }

    public function update(OpeningStockFormRequest $request)
    {
        if($request->ajax()){
            if(permission('opening-stock-edit')){
                // dd($request->all());
                DB::beginTransaction();
                try {
                    $openingStockData = $this->model->with('products')->find($request->update_id);

                    if(!$openingStockData->products->isEmpty())
                    {
                        foreach ($openingStockData->products as  $opening_stock_product) {
                            $warehouse_product = WarehouseProduct::where([
                                ['warehouse_id', $openingStockData->warehouse_id],
                                ['product_id', $opening_stock_product->id],
                            ])->first();
                            if ($warehouse_product) {
                                $warehouse_product->qty -= $opening_stock_product->pivot->base_unit_qty;
                                $warehouse_product->update();
                            }
                        }
                    }

                    $products = [];
                    if($request->has('products'))
                    {
                        foreach ($request->products as $key => $value) {
                            $products[$value['id']] = [
                                'base_unit_id'    => $value['base_unit_id'],
                                'base_unit_qty'   => $value['base_unit_qty'],
                                'base_unit_price' => $value['base_unit_price'],
                                'tax_rate'        => $value['tax_rate'],
                                'tax'             => $value['tax'],
                                'total'           => $value['subtotal']
                            ];

                            $warehouse_product = WarehouseProduct::where([
                                ['warehouse_id', $request->warehouse_id],
                                ['product_id', $value['id']],
                            ])->first();
                            if ($warehouse_product) {
                                $warehouse_product->qty += $value['base_unit_qty'];
                                $warehouse_product->update();
                            } else {
                                WarehouseProduct::create([
                                    'warehouse_id' => $request->warehouse_id,
                                    'product_id'   => $value['id'],
                                    'qty'          => $value['base_unit_qty'],
                                ]);
                            }
                            
                        }
                        if(count($products) > 0)
                        {
                            $openingStockData->products()->sync($products);
                        }
                    }
                    $opening_stock = $openingStockData->update([
                        'warehouse_id' => $request->warehouse_id,
                        'item'         => $request->item,
                        'total_qty'    => $request->total_qty,
                        'total_tax'    => $request->total_tax,
                        'grand_total'  => $request->grand_total,
                        'date'         => $request->date,
                        'note'         => $request->note,
                        'modified_by'  => auth()->user()->name
                    ]);
                    $output  = $this->store_message($opening_stock, $request->update_id);
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollback();
                    $output = ['status' => 'error','message' => $e->getMessage()];
                }
            }else{
                $output       = $this->unauthorized();
            }
            return response()->json($output);
        }else{
            return response()->json($this->unauthorized());
        }
    }

    public function delete(Request $request)
    {
        if($request->ajax()){
            if(permission('opening-stock-delete')){
                DB::beginTransaction();
                try {
                    $openingStockData = $this->model->with('products')->find($request->id);
                    if(!$openingStockData->products->isEmpty())
                    {
                        foreach ($openingStockData->products as  $opening_stock_product) {
                            $warehouse_product = WarehouseProduct::where([
                                ['warehouse_id', $openingStockData->warehouse_id],
                                ['product_id', $opening_stock_product->id],
                            ])->first();
                            if ($warehouse_product) {
                                $warehouse_product->qty -= $opening_stock_product->pivot->base_unit_qty;
                                $warehouse_product->update();
                            }
                        }
                        $openingStockData->products()->detach();
                    }
                    $result = $openingStockData->delete();
                    $output = $result ? ['status' => 'success','message' => 'Data has been deleted successfully'] : ['status' => 'error','message' => 'failed to delete data'];
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollBack();
                    $output = ['status'=>'error','message'=>$e->getMessage()];
                }
                return response()->json($output);
            }else{
                $output = $this->access_blocked();
            }
            return response()->json($output);
        }else{
            return response()->json($this->access_blocked());
        }
    }

    public function bulk_delete(Request $request)
    {
        if($request->ajax()){
            if(permission('opening-stock-bulk-delete')){
                DB::beginTransaction();
                try {
                    foreach ($request->ids as $id) {
                        $openingStockData = $this->model->with('products')->find($id);
                        if(!$openingStockData->products->isEmpty())
                        {
                            foreach ($openingStockData->products as  $opening_stock_product) {
                                $warehouse_product = WarehouseProduct::where([
                                    ['warehouse_id', $openingStockData->warehouse_id],
                                    ['product_id', $opening_stock_product->id],
                                ])->first();
                                if ($warehouse_product) {
                                    $warehouse_product->qty -= $opening_stock_product->pivot->base_unit_qty;
                                    $warehouse_product->update();
                                }
                            }
                            $openingStockData->products()->detach();
                        }
                    }
                    $result = $this->model->destroy($request->ids);
                    $output = $result ? ['status' => 'success','message' => 'Data has been deleted successfully'] : ['status' => 'error','message' => 'failed to delete data'];
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollBack();
                    $output = ['status'=>'error','message'=>$e->getMessage()];
                }
            }else{
                $output = $this->access_blocked();
            }
            return response()->json($output);
        }else{
            return response()->json($this->access_blocked());
        }
    }
}
