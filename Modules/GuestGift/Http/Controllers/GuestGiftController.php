<?php

namespace Modules\GuestGift\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Product\Entities\Product;
use App\Http\Controllers\BaseController;
use Modules\GuestGift\Entities\GuestGift;
use Modules\Product\Entities\WarehouseProduct;
use Modules\GuestGift\Http\Requests\GuestGiftFormRequest;

class GuestGiftController extends BaseController
{
    public function __construct(GuestGift $model)
    {
        $this->model = $model;
    }
    
    public function index()
    {
        if(permission('guest-gift-access')){
            $this->setPageData('Manage Guest Gift','Manage Guest Gift','fas fa-gift',[['name' => 'Manage Guest Gift']]);
            return view('guestgift::index');
        }else{
            return $this->access_blocked();
        }

    }

    public function get_datatable_data(Request $request)
    {
        if($request->ajax()){
            if(permission('guest-gift-access')){
                if (!empty($request->voucher_no)) {
                    $this->model->setVoucherNo($request->voucher_no);
                }
                if (!empty($request->start_date)) {
                    $this->model->setFromDate($request->start_date);
                }
                if (!empty($request->end_date)) {
                    $this->model->setToDate($request->end_date);
                }


                $this->set_datatable_default_properties($request);//set datatable default properties
                $list = $this->model->getDatatableList();//get table data
                $data = [];
                $no = $request->input('start');
                foreach ($list as $value) {
                    $no++;
                    $action = '';
                    if (permission('guest-gift-edit')) {
                        $action .= ' <a class="dropdown-item" href="'.route("guest.gift.edit",$value->id).'">'.self::ACTION_BUTTON['Edit'].'</a>';
                    }
                    if (permission('guest-gift-view')) {
                        $action .= ' <a class="dropdown-item view_data" href="'.route("guest.gift.show",$value->id).'">'.self::ACTION_BUTTON['View'].'</a>';
                    }

                    if (permission('guest-gift-delete')) {
                        $action .= ' <a class="dropdown-item delete_data"  data-id="' . $value->id . '" data-name="' . $value->voucher_no . '">'.self::ACTION_BUTTON['Delete'].'</a>';
                    }

                    $row = [];
                    if(permission('guest-gift-bulk-delete')){
                        $row[] = row_checkbox($value->id);//custom helper function to show the table each row checkbox
                    }

                    $row[] = $no;
                    $row[] = $value->voucher_no;
                    $row[] = $value->guest_name;
                    $row[] = $value->gift_from;
                    $row[] = $value->item;
                    $row[] = $value->total_qty;
                    $row[] = date('d-M-Y',strtotime($value->date));
                    $row[] = $value->created_by;
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
        if(permission('guest-gift-add')){
            $this->setPageData('Add Guest Gift','Add Guest Gift','fas fa-gift',[['name' => 'Add Guest Gift']]);
            $data = [
                'products'  => Product::with(['base_unit','unit'])->get(),
                'voucher_no'   => 'GGV-'.date('ymd').rand(1,999),
            ];
            return view('guestgift::create',$data);
        }else{
            return $this->access_blocked();
        }
    }

    public function store(GuestGiftFormRequest $request)
    {
        if($request->ajax()){
            if(permission('guest-gift-add')){
                // dd($request->all());
                DB::beginTransaction();
                try {
                    $gift  = $this->model->create([
                        'voucher_no' => $request->voucher_no,
                        'guest_name' => $request->guest_name,
                        'gift_from'  => $request->gift_from,
                        'item'       => $request->item,
                        'total_qty'  => $request->total_qty,
                        'date'       => $request->date,
                        'created_by' => auth()->user()->name
                    ]);

                    $giftData = $this->model->with('products')->find($gift->id);
                    $products = [];
                    if($request->has('products'))
                    {
                        foreach ($request->products as $key => $value) {
                            $products[$value['id']] = [
                                'qty'            => $value['qty']
                            ];
                            
                            $product = Product::find($value['id']);
                            if($product)
                            {
                                $product->base_unit_qty -= $value['qty'];
                                $product->update();
                            }
                            $warehosue_product = WarehouseProduct::where([
                                ['warehouse_id',1],
                                ['product_id',$value['id']]
                                ])->first();
                            if($warehosue_product)
                            {
                                $warehosue_product->qty -= $value['qty'];
                                $warehosue_product->update();
                            }
                        }
                        if(count($products) > 0)
                        {
                            $giftData->products()->sync($products);
                        }
                    }

                    if($gift)
                    {
                        $output = ['status'=>'success','message'=>'Data has been saved successfully','gift_id'=>$gift->id];
                    }else{
                        $output = ['status'=>'error','message'=>'Failed to save data!','gift_id'=>''];
                    }
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollback();
                    $output = ['status' => 'error','message' => $e->getMessage()];
                }
                return response()->json($output);
            }else{
                return response()->json($this->unauthorized());
            }
        }else{
            return response()->json($this->unauthorized());
        }
    }


    public function show(int $id)
    {
        if(permission('guest-gift-view')){
            $this->setPageData('Guest Gift Details','Guest Gift Details','fas fa-file',[['name' => 'Guest Gift Details']]);
            $gift = $this->model->with('products')->find($id);
            return view('guestgift::details',compact('gift'));
        }else{
            return $this->access_blocked();
        }
    }
    public function edit(int $id)
    {
        if(permission('guest-gift-edit')){
            $this->setPageData('Edit Guest Gift','Edit Guest Gift','fas fa-edit',[['name' => 'Edit Guest Gift']]);

            $data = [
                'products'  => Product::with(['base_unit','unit'])->get(),
                'sale'      => $this->model->with('products')->find($id),

            ];
            // dd($data['sale']);
            return view('guestgift::edit',$data);
        }else{
            return $this->access_blocked();
        }

    }

    public function update(GuestGiftFormRequest $request)
    {
        if($request->ajax()){
            if(permission('guest-gift-edit')){
                // dd($request->all());
                DB::beginTransaction();
                try {
                    $giftData = $this->model->with('products')->find($request->gift_id);
                    if(!$giftData->products->isEmpty())
                    {
                        foreach ($giftData as $key => $value) {
                            $product = Product::find($value->id);
                            if($product)
                            {
                                $product->base_unit_qty += $value->pivot->qty;
                                $product->update();
                            }
                            $warehosue_product = WarehouseProduct::where([
                                ['warehouse_id',1],
                                ['product_id',$value->id]
                                ])->first();
                            if($warehosue_product)
                            {
                                $warehosue_product->qty += $value->pivot->qty;
                                $warehosue_product->update();
                            }
                        }
                    }

                    $products = [];
                    if($request->has('products'))
                    {
                        foreach ($request->products as $key => $value) {
                            $products[$value['id']] = [
                                'qty' => $value['qty']
                            ];
                            
                            $product = Product::find($value['id']);
                            if($product)
                            {
                                $product->base_unit_qty -= $value['qty'];
                                $product->update();
                            }
                            $warehosue_product = WarehouseProduct::where([
                                ['warehouse_id',1],
                                ['product_id',$value['id']]
                                ])->first();
                            if($warehosue_product)
                            {
                                $warehosue_product->qty -= $value['qty'];
                                $warehosue_product->update();
                            }
                        }
                        if(count($products) > 0)
                        {
                            $giftData->products()->sync($products);
                        }
                    }

                    $gift  = $giftData->update([
                        'voucher_no'  => $request->voucher_no,
                        'guest_name'  => $request->guest_name,
                        'gift_from'   => $request->gift_from,
                        'item'        => $request->item,
                        'total_qty'   => $request->total_qty,
                        'date'        => $request->date,
                        'modified_by' => auth()->user()->name
                    ]);

                    $output  = $this->store_message($gift, $request->gift_id);
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollback();
                    $output = ['status' => 'error','message' => $e->getMessage()];
                }
                return response()->json($output);
            }else{
                return response()->json($this->unauthorized());
            }
        }else{
            return response()->json($this->unauthorized());
        }
    }

    public function delete(Request $request)
    {
        if($request->ajax()){
            if(permission('guest-gift-delete'))
            {
                DB::beginTransaction();
                try {
    
                    $giftData = $this->model->with('products')->find($request->id);
    
                    if(!$giftData->products->isEmpty())
                    {
                        foreach ($giftData as $key => $value) {
                            $product = Product::find($value->id);
                            if($product)
                            {
                                $product->base_unit_qty += $value->pivot->qty;
                                $product->update();
                            }
                            $warehosue_product = WarehouseProduct::where([
                                ['warehouse_id',1],
                                ['product_id',$value->id]
                                ])->first();
                            if($warehosue_product)
                            {
                                $warehosue_product->qty += $value->pivot->qty;
                                $warehosue_product->update();
                            }
                        }
                        $giftData->products->detach();
                    }
    
                    $result = $giftData->delete();
                    if($result)
                    {
                        $output = ['status' => 'success','message' => 'Data has been deleted successfully'];
                    }else{
                        $output = ['status' => 'error','message' => 'Failed to delete data'];
                    }
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollback();
                    $output = ['status' => 'error','message' => $e->getMessage()];
                }
                return response()->json($output);
            }else{
                return response()->json($this->unauthorized());
            }
        }else{
            return response()->json($this->unauthorized());
        }
    }

    public function bulk_delete(Request $request)
    {
        if($request->ajax()){
            if(permission('guest-gift-bulk-delete'))
            {
                DB::beginTransaction();
                try {
                    foreach ($request->ids as $id) {
                        $giftData = $this->model->with('products')->find($id);
        
                        if(!$giftData->products->isEMpty())
                        {
                            foreach ($giftData as $key => $value) {
                                $product = Product::find($value->id);
                                if($product)
                                {
                                    $product->base_unit_qty += $value->pivot->qty;
                                    $product->update();
                                }
                                $warehosue_product = WarehouseProduct::where([
                                    ['warehouse_id',1],
                                    ['product_id',$value->id]
                                    ])->first();
                                if($warehosue_product)
                                {
                                    $warehosue_product->qty += $value->pivot->qty;
                                    $warehosue_product->update();
                                }
                            }
                            $giftData->products->detach();
                        }
                    }
                    $result = $this->model->destroy($request->ids);
                    if($result)
                    {
                        $output = ['status' => 'success','message' => 'Data has been deleted successfully'];
                    }else{
                        $output = ['status' => 'error','message' => 'Failed to delete data'];
                    }
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollback();
                    $output = ['status' => 'error','message' => $e->getMessage()];
                }
                return response()->json($output);
            }else{
                return response()->json($this->unauthorized());
            }
        }else{
            return response()->json($this->unauthorized());
        }
    }
}
