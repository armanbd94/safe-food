<?php

namespace Modules\Stock\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Product\Entities\Product;
use Modules\Setting\Entities\Warehouse;
use App\Http\Controllers\BaseController;
use Modules\Product\Entities\WarehouseProduct;

class ProductStockController extends BaseController
{

    public function __construct(WarehouseProduct $model)
    {
        $this->model = $model;
    }
    public function index()
    {
        if(permission('product-stock-report-access')){
            $this->setPageData('Product Stock Report','Product Stock Report','fas fa-boxes',[['name' => 'Product Stock Report']]);
            $data = [
                'categories' => Category::where([['type',2],['status',1]])->get(),
                'products' => DB::table('products')->where('status',1)->pluck('name','id')
            ];
            return view('stock::product.index',$data);
        }else{
            return $this->access_blocked();
        }
    }

    public function get_product_stock_data(Request $request)
    {
        if($request->ajax())
        {
            $category_id = $request->category_id;
            $product_id   = $request->product_id;

            $categories = Category::with('products')
            ->where([['type',2],['status',1]])
            ->when($category_id, function($q) use ($category_id){
                $q->where('id',$category_id);
            });
            
            if($product_id){
                $categories->whereHas('products',function($q) use ($product_id){
                    $q->where('id',$product_id);
                });
            }
            $categories = $categories->get();

            return view('stock::product.product-list',compact('categories','product_id'))->render();
        }
    }


}
