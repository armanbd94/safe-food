<?php

namespace Modules\MaterialStockOut\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Setting\Entities\Warehouse;
use App\Http\Controllers\BaseController;
use Modules\MaterialStockOut\Entities\StockOut;
use Modules\Material\Entities\WarehouseMaterial;
use Modules\MaterialStockOut\Entities\StockOutMaterial;
use Modules\MaterialStockOut\Http\Requests\StockOutMaterialRequest;

class MaterialStockOutController extends BaseController
{
    private const STOCK_OUT_NO = 1001;
    public function __construct(StockOut $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if(permission('material-stock-out-access')){
            $this->setPageData('Manage Material Stock Out','Manage Material Stock Out','fas fa-shopping-cart',[['name' => 'Manage Material Stock Out']]);
            $warehouses = DB::table('warehouses')->where('status',1)->pluck('name','id');
            return view('materialstockout::index',compact('warehouses'));
        }else{
            return $this->access_blocked();
        }
    }

    public function get_datatable_data(Request $request)
    {
        if($request->ajax()){
            if(permission('material-stock-out-access')){

                if (!empty($request->stock_out_no)) {
                    $this->model->setStockOutNo($request->stock_out_no);
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
                    if(permission('material-stock-out-edit')){
                        $action .= ' <a class="dropdown-item" href="'.route("material.stock.out.edit",$value->id).'">'.self::ACTION_BUTTON['Edit'].'</a>';
                    }

                    if(permission('material-stock-out-view')){
                        $action .= ' <a class="dropdown-item view_data" href="'.route("material.stock.out.view",$value->id).'">'.self::ACTION_BUTTON['View'].'</a>';
                    }
                    
                    if(permission('material-stock-out-delete')){
                        $action .= ' <a class="dropdown-item delete_data"  data-id="' . $value->id . '" data-name="' . $value->stock_out_no . '">'.self::ACTION_BUTTON['Delete'].'</a>';
                    }
                    
                    $row = [];
                    if(permission('material-stock-out-bulk-delete')){
                        $row[] = row_checkbox($value->id);//custom helper function to show the table each row checkbox
                    }
                    $materials = '';
                    if(!$value->materials->isEmpty())
                    {
                        $materials .= '<ul style="list-style:none;margin:0;padding:0;">';
                        foreach ($value->materials as $material) {
                            $materials .= "<li class='text-left mb-3'>".$material->batch_no." - ".$material->material->material_name." <span class='badge badge-primary float-right'>". $material->qty." </span></li>";
                        }
                        $materials .= '</ul>';
                    }
                    $row[] = $no;
                    $row[] = $value->stock_out_no;
                    $row[] = $value->warehouse->name;
                    $row[] = $value->item;
                    $row[] = $materials;
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
        if(permission('material-stock-out-add')){
            $this->setPageData('Material Stock Out Create Form','Material Stock Out Create Form','fas fa-box-open',[['name' => 'Material Stock Out Create Form']]);
            $purchase = $this->model->select('stock_out_no')->orderBy('stock_out_no','desc')->first();
            $materials = DB::table('materials as m')
            ->join('units as u','m.unit_id','=','u.id')
            ->selectRaw('m.id,m.material_name,m.material_code,m.qty,m.cost,m.unit_id,u.unit_name')
            ->get();
            $data = [
                'warehouses'     => DB::table('warehouses')->where('status',1)->pluck('name','id'),
                'materials'      => $materials,
                'stock_out_no'   => $purchase ? $purchase->stock_out_no + 1 : self::STOCK_OUT_NO
            ];

            return view('materialstockout::create',$data);
        }else{
            return $this->access_blocked();
        }
        
    }

    public function store(StockOutMaterialRequest $request)
    {
        if($request->ajax()){
            if(permission('material-stock-out-add')){
                // dd($request->all());
                DB::beginTransaction();
                try {
                    $stock_out_data = [
                        'stock_out_no'  => $request->stock_out_no,
                        'date'          => $request->date,
                        'warehouse_id'  => $request->warehouse_id,
                        'item'          => $request->item,
                        'total_qty'     => $request->total_qty,
                        'grand_total'   => $request->grand_total,
                        'note'          => $request->note,
                        'created_by'    => auth()->user()->name
                    ];
                    $stock_out  = $this->model->create($stock_out_data);

                    $materials = [];
                    if($request->has('materials'))
                    {
                        foreach ($request->materials as $value) {
                            $materials[] = [
                                'stock_out_id'  => $stock_out->id,
                                'material_id'   => $value['id'],
                                'batch_no'      => $value['batch_no'],
                                'unit_id'       => $value['unit_id'],
                                'qty'           => $value['qty'],
                                'net_unit_cost' => $value['net_unit_cost'],
                                'total'         => $value['subtotal'],
                                'created_at'    => date('Y-m-d')
                            ];

                            $warehouse_material = WarehouseMaterial::where([
                                ['warehouse_id', $request->warehouse_id],
                                ['material_id', $value['id']],
                            ])->first();
                            if ($warehouse_material) {
                                $warehouse_material->qty -= $value['qty'];
                                $warehouse_material->update();
                            } 

                        }
                        if(count($materials) > 0)
                        {
                            StockOutMaterial::insert($materials);
                        }

                    }
                    $output  = $this->store_message($stock_out, null);
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
        if(permission('material-stock-out-view')){
            $this->setPageData('Material Stock Out Details','Material Stock Out Details','fas fa-box-open',[['name'=>'Material Stock Out','link' => route('material.stock.out')],['name' => 'Material Stock Out Details']]);
            $stock_out = $this->model->with(['warehouse:id,name','materials'])->find($id);
            return view('materialstockout::details',compact('stock_out'));
        }else{
            return $this->access_blocked();
        }
    }


    public function edit(int $id)
    {
        if(permission('material-stock-out-view')){
            $this->setPageData('Material Stock Out Details','Material Stock Out Details','fas fa-box-open',[['name'=>'Material Stock Out','link' => route('material.stock.out')],['name' => 'Material Stock Out Details']]);
            $materials = DB::table('materials as m')
            ->join('units as u','m.unit_id','=','u.id')
            ->selectRaw('m.id,m.material_name,m.material_code,m.qty,m.cost,m.unit_id,u.unit_name')
            ->get();
            $data = [
                'warehouses' => DB::table('warehouses')->where('status',1)->pluck('name','id'),
                'materials'  => $materials,
                'stock_out'  => $this->model->with(['warehouse:id,name','materials'])->find($id)
            ];
            return view('materialstockout::edit',$data);
        }else{
            return $this->access_blocked();
        }
    }



    public function delete(Request $request)
    {
        if($request->ajax()){
            if(permission('material-stock-out-delete')){
                DB::beginTransaction();
                try {
                    $stockOutData = $this->model->with('materials')->find($request->id);
                    if(!$stockOutData->materials->isEmpty())
                    {
                        foreach ($stockOutData->materials as  $stock_out_material) {
                            $warehouse_material = WarehouseMaterial::where([
                                ['warehouse_id', $stockOutData->warehouse_id],
                                ['material_id', $stock_out_material->material_id],
                            ])->first();
                            if ($warehouse_material) {
                                $warehouse_material->qty += $stock_out_material->qty;
                                $warehouse_material->update();
                            }
                        }
                        $stockOutData->materials()->delete();
                    }
                    $result = $stockOutData->delete();
                    $output = $result ? ['status' => 'success','message' => 'Data has been deleted successfully'] : ['status' => 'error','message' => 'Failed to delete data'];
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
            if(permission('material-stock-out-bulk-delete')){
                DB::beginTransaction();
                try {
                    foreach ($request->ids as $id) {
                        $stockOutData = $this->model->with('materials')->find($id);
                        if(!$stockOutData->materials->isEmpty())
                        {
                            foreach ($stockOutData->materials as  $stock_out_material) {
                                $warehouse_material = WarehouseMaterial::where([
                                    ['warehouse_id', $stockOutData->warehouse_id],
                                    ['material_id', $stock_out_material->material_id],
                                ])->first();
                                if ($warehouse_material) {
                                    $warehouse_material->qty += $stock_out_material->qty;
                                    $warehouse_material->update();
                                }
                            }
                            $stockOutData->materials()->delete();
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
