<?php

namespace Modules\Stock\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Material\Entities\Material;
use Modules\Setting\Entities\Warehouse;
use App\Http\Controllers\BaseController;
use Modules\Material\Entities\WarehouseMaterial;

class MaterialStockController extends BaseController
{

    public function __construct(WarehouseMaterial $model)
    {
        $this->model = $model;
    }
    public function index()
    {
        if(permission('material-stock-report-access')){
            $this->setPageData('Material Stock Report','Material Stock Report','fas fa-boxes',[['name' => 'Material Stock Report']]);
            $data = [
                'categories' => Category::where([['type',1],['status',1]])->get(),
                'materials' => DB::table('materials')->where('status',1)->pluck('material_name','id')
            ];
            return view('stock::material.index',$data);
        }else{
            return $this->access_blocked();
        }
    }

    public function get_material_stock_data(Request $request)
    {
        if($request->ajax())
        {

            $material_id = $request->material_id;
            $category_id = $request->category_id;
            $categories = Category::with('materials')
            ->where([['type',1],['status',1]])
            ->when($category_id, function($q) use ($category_id){
                $q->where('id',$category_id);
            });
            
            if($material_id){
                $categories->whereHas('materials',function($q) use ($material_id){
                    $q->where('id',$material_id);
                });
            }
            $categories = $categories->get();
            
            return view('stock::material.material-list',compact('categories','material_id'))->render();
        }
    }


}
