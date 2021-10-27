<?php

namespace Modules\Customer\Http\Controllers;

use Exception;
use App\Traits\UploadAble;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Customer\Entities\Customer;
use Modules\Setting\Entities\Warehouse;
use App\Http\Controllers\BaseController;
use Modules\Account\Entities\Transaction;
use Modules\Setting\Entities\CustomerGroup;
use Modules\Account\Entities\ChartOfAccount;
use Modules\Customer\Http\Requests\CustomerFormRequest;

class CustomerController extends BaseController
{
    use UploadAble;
    public function __construct(Customer $model)
    {
        $this->model = $model;
    }


    public function index()
    {
        if(permission('customer-access')){
            $this->setPageData('Customer','Customer','far fa-handshake',[['name'=>'Customer']]);
            $data = [
                'warehouses'      => Warehouse::where('status',1)->get(),
                'customer_groups' => CustomerGroup::where('status',1)->get(),
                'locations'       => DB::table('locations')->where('status', 1)->get(),
            ];
            return view('customer::index',$data);
        }else{
            return $this->access_blocked();
        }
    }

    public function get_datatable_data(Request $request)
    {
        if($request->ajax()){
            if(permission('customer-access')){

                if (!empty($request->name)) {
                    $this->model->setName($request->name);
                }
                if (!empty($request->shop_name)) {
                    $this->model->setShopName($request->shop_name);
                }
                if (!empty($request->mobile)) {
                    $this->model->setMobile($request->mobile);
                }
                if (!empty($request->email)) {
                    $this->model->setEmail($request->email);
                }
                if (!empty($request->customer_group_id)) {
                    $this->model->setCustomerGroupID($request->customer_group_id);
                }
                if (!empty($request->district_id)) {
                    $this->model->setDistrictID($request->district_id);
                }
                if (!empty($request->area_id)) {
                    $this->model->setAreaID($request->area_id);
                }
                if (!empty($request->upazila_id)) {
                    $this->model->setUpazilaID($request->upazila_id);
                }
                if (!empty($request->route_id)) {
                    $this->model->setRouteID($request->route_id);
                }
                if (!empty($request->status)) {
                    $this->model->setStatus($request->status);
                }

                $this->set_datatable_default_properties($request);//set datatable default properties
                $list = $this->model->getDatatableList();//get table data
                $data = [];
                $no = $request->input('start');
                foreach ($list as $value) {
                    $no++;
                    $action = '';
                    if(permission('customer-edit')){
                    $action .= ' <a class="dropdown-item edit_data" data-id="' . $value->id . '">'.self::ACTION_BUTTON['Edit'].'</a>';
                    }
                    if(permission('customer-view')){
                    $action .= ' <a class="dropdown-item view_data" data-id="' . $value->id . '" data-name="' . $value->name . '">'.self::ACTION_BUTTON['View'].'</a>';
                    }
                    if(permission('customer-delete')){
                        $action .= ' <a class="dropdown-item delete_data"  data-id="' . $value->id . '" data-name="' . $value->name . '">'.self::ACTION_BUTTON['Delete'].'</a>';
                    }
                    if(!empty($value->avatar))
                    {
                        $avatar =  "<img src='".asset("storage/".CUSTOMER_AVATAR_PATH.$value->avatar)."' alt='".$value->name."' style='width:50px;'/>";
                    }else{
                        $avatar =  "<img src='".asset("images/male.svg")."' alt='Default Image' style='width:50px;'/>";
                    }
                    $row = [];
                    if(permission('customer-bulk-delete')){
                        $row[] = row_checkbox($value->id);//custom helper function to show the table each row checkbox
                    }
                    $row[] = $no;
                    $row[] = $avatar;
                    $row[] = $value->name;
                    $row[] = $value->shop_name;
                    $row[] = $value->mobile;
                    $row[] = $value->customer_group->group_name;
                    $row[] = $value->district->name;
                    $row[] = $value->upazila->name;
                    // $row[] = $value->route->name;
                    $row[] = $value->area->name;
                    $row[] = permission('customer-edit') ? change_status($value->id,$value->status, $value->name) : STATUS_LABEL[$value->status];
                    $row[] = $this->model->customer_balance($value->id);
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

    public function store_or_update_data(CustomerFormRequest $request)
    {
        if($request->ajax()){
            if(permission('customer-add') || permission('customer-edit')){
                DB::beginTransaction();
                try {
                    $collection   = collect($request->validated());
                    $collection   = $this->track_data($collection,$request->update_id);
                    $avatar = !empty($request->old_avatar) ? $request->old_avatar : null;
                    if($request->hasFile('avatar')){
                        $avatar  = $this->upload_file($request->file('avatar'),CUSTOMER_AVATAR_PATH);
                        if(!empty($request->old_avatar)){
                            $this->delete_file($request->old_avatar, CUSTOMER_AVATAR_PATH);
                        }  
                    }
                    $collection   = $collection->merge(compact('avatar'));
                    $customer     = $this->model->updateOrCreate(['id'=>$request->update_id],$collection->all());
                    $output       = $this->store_message($customer, $request->update_id);
                    if(empty($request->update_id))
                    {
                        $coa_max_code      = ChartOfAccount::where('level',4)->where('code','like','1020201%')->max('code');
                        $code              = $coa_max_code ? ($coa_max_code + 1) : $this->coa_head_code('customer_receivable');
                        $head_name         = $customer->id.'-'.$customer->name;
                        $customer_coa      = ChartOfAccount::create($this->model->coa_data($code,$head_name,$customer->id));
                        if(!empty($request->previous_balance))
                        {
                            if($customer_coa){
                                Transaction::insert($this->model->previous_balance_data($request->previous_balance,$customer_coa->id,$customer->name));
                            }
                        }
                    }else{
                        $old_head_name = $request->update_id.'-'.$request->old_name;
                        $new_head_name = $request->update_id.'-'.$request->name;
                        $customer_coa  = ChartOfAccount::where(['name'=>$old_head_name,'customer_id'=>$request->update_id])->first();
                        if($customer_coa)
                        {
                            $customer_coa->update(['name'=>$new_head_name]);
                        }
                    }
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollBack();
                    $output = ['status' => 'error','message' => $e->getMessage()];
                }
            }else{
                $output = $this->unauthorized();
            }
            return response()->json($output);
        }else{
            return response()->json($this->unauthorized());
        }
    }

    public function edit(Request $request)
    {
        if($request->ajax()){
            if(permission('customer-edit')){
                $data   = $this->model->findOrFail($request->id);
                $output = $this->data_message($data);
                return response()->json($output);
            }else{
                $output = $this->unauthorized();
            }
            return response()->json($output);
        }else{
            return response()->json($this->unauthorized());
        }
    }

    public function show(Request $request)
    {
        if($request->ajax()){
            if(permission('customer-view')){
                $customer   = $this->model->with(['customer_group','district','upazila','area'])->findOrFail($request->id);
                return view('customer::view-data',compact('customer'))->render();
            }
        }
    }

    public function delete(Request $request)
    {
        if($request->ajax()){
            if(permission('customer-delete')){
                DB::beginTransaction();
                try {
                    $total_sale_data = DB::table('sales')->where('customer_id',$request->id)->get()->count();
                    if ($total_sale_data > 0) {
                        $output = ['status'=>'error','message'=>'This data cannot delete because it is related with others data.'];
                    } else {
                        $customer_coa_id = ChartOfAccount::where('customer_id',$request->id)->first();
                        Transaction::where('chart_of_account_id',$customer_coa_id->id)->delete();
                        $customer_coa_id->delete();
                        $result   = $this->model->find($request->id)->delete();
                        $output   = $this->delete_message($result);
                    }
                    DB::commit();
                } catch (Exception $e) {
                   DB::rollBack();
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

    public function change_status(Request $request)
    {
        if($request->ajax()){
            if(permission('customer-edit')){
                $result   = $this->model->find($request->id)->update(['status' => $request->status]);
                $output   = $result ? ['status' => 'success','message' => 'Status Has Been Changed Successfully']
                : ['status' => 'error','message' => 'Failed To Change Status'];
            }else{
                $output   = $this->unauthorized();
            }
            return response()->json($output);
        }else{
            return response()->json($this->unauthorized());
        }
    }


    public function customer_list(Request $request)
    {
        if($request->ajax()){
            $district_id = $request->district_id;
            $upazila_id  = $request->upazila_id;
            $route_id    = $request->route_id;
            $area_id     = $request->area_id;
            $data = DB::table('customers')
                    ->select('id','name','shop_name','mobile')
                    ->when($district_id, function($q) use ($district_id){
                        $q->where('district_id',$district_id);
                    })
                    ->when($upazila_id, function($q) use ($upazila_id){
                        $q->where('upazila_id',$upazila_id);
                    })
                    ->when($route_id, function($q) use ($route_id){
                        $q->where('route_id',$route_id);
                    })
                    ->when($area_id, function($q) use ($area_id){
                        $q->where('area_id',$area_id);
                    })
                    ->get();
            return response()->json($data);
        }
    }

    public function groupData(int $id)
    {
        $data = $this->model->with('customer_group')->find($id);
        return $data ? $data->customer_group->percentage : 0;
    }

    public function previous_balance(int $id)
    {
        $data = DB::table('transactions as t')
                ->leftjoin('chart_of_accounts as coa','t.chart_of_account_id','=','coa.id')
                ->select(DB::raw("SUM(t.debit) - SUM(t.credit) as balance"),'coa.id','coa.code')
                ->groupBy('t.chart_of_account_id')
                ->where('coa.customer_id',$id)
                ->where('t.approve',1)
                ->first();
        $balance = $data ? $data->balance : 0;
        return  response()->json($balance);
    }
}
