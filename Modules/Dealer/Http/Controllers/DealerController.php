<?php

namespace Modules\Dealer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Dealer\Entities\Dealer;
use Modules\Dealer\Entities\DealerArea;
use App\Http\Controllers\BaseController;
use Modules\Account\Entities\Transaction;
use Modules\Account\Entities\ChartOfAccount;
use Modules\Dealer\Http\Requests\DealerFormRequest;

class DealerController extends BaseController
{
    public function __construct(Dealer $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if(permission('dealer-access')){
            $this->setPageData('Dealer','Dealer','fas fa-store',[['name' => 'Dealer']]);
            $depos     = DB::table('depos')->where('status',1)->get();
            $dealer_groups     = DB::table('dealer_groups')->where('status',1)->pluck('group_name','id');
            $districts = DB::table('locations')->where([['type',1],['status',1]])->orderBy('id','asc')->pluck('name','id');
            return view('dealer::index',compact('depos','districts','dealer_groups'));
        }else{
            return $this->access_blocked();
        }
    }

    public function get_datatable_data(Request $request)
    {
        if($request->ajax()){
            if(permission('dealer-access')){

                if (!empty($request->name)) {
                    $this->model->setName($request->name);
                }

                if (!empty($request->mobile_no)) {
                    $this->model->setMobileNo($request->mobile_no);
                }
                if (!empty($request->email)) {
                    $this->model->setEmail($request->email);
                }
                
                if (!empty($request->depo_id)) {
                    $this->model->setDepoID($request->depo_id);
                }
                
                if (!empty($request->district_id)) {
                    $this->model->setDistrictID($request->district_id);
                }
                if (!empty($request->upazila_id)) {
                    $this->model->setUpazilaID($request->upazila_id);
                }
                if (!empty($request->area_id)) {
                    $this->model->setAreaID($request->area_id);
                }
                if (!empty($request->dealer_group_id)) {
                    $this->model->setDealerGroupID($request->dealer_group_id);
                }
                if (!empty($request->type)) {
                    $this->model->setType($request->type);
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
                    if(permission('dealer-edit')){
                        $action .= ' <a class="dropdown-item edit_data" data-id="' . $value->id . '">'.self::ACTION_BUTTON['Edit'].'</a>';
                    }
                    if(permission('dealer-view')){
                        $action .= ' <a class="dropdown-item view_data" data-id="' . $value->id . '"  data-name="' . $value->name . '">'.self::ACTION_BUTTON['View'].'</a>';
                    }
                    if(permission('dealer-delete')){
                        $action .= ' <a class="dropdown-item delete_data"  data-id="' . $value->id . '" data-name="' . $value->name . '">'.self::ACTION_BUTTON['Delete'].'</a>';
                    }

                    $row = [];
                    if(permission('dealer-bulk-delete')){
                        $row[] = row_checkbox($value->id);//custom helper function to show the table each row checkbox
                    }
                    $row[] = $no;
                    $row[] = $value->name;
                    $row[] = $value->type == 1 ? '<span class="badge badge-success">Depo Dealer</span>' : '<span class="badge badge-primary">Direct Dealer</span>';
                    $row[] = $value->mobile_no;
                    $row[] = $value->email;
                    $row[] = $value->depo_name ?? 'N/A';
                    $row[] = $value->district_name;
                    $row[] = $value->upazila_name;
                    $row[] = $value->area_name;
                    $row[] = $value->group_name;
                    $row[] = $value->commission_rate ?? '0';
                    $row[] = number_format($value->balance,2,'.','').' Tk';
                    $row[] = permission('dealer-edit') ? change_status($value->id,$value->status, $value->name) : STATUS_LABEL[$value->status];
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

    public function store_or_update_data(DealerFormRequest $request)
    {
        if($request->ajax()){
            if(permission('dealer-add')){
                // dd($request->all());
                DB::beginTransaction();
                try {
                    if(!empty($request->update_id))
                    {
                        $old_data = $this->model->find($request->update_id);
                        if($old_data->type == 2)
                        {
                            if($old_data->type != $request->type)
                            {
                                $dealer_coa = ChartOfAccount::where('dealer_id',$request->update_id)->first();
                                if($dealer_coa)
                                {
                                    Transaction::where('chart_of_account_id',$dealer_coa->id)->delete();
                                }
                                $dealer_coa->delete();
                            }
                        }
                    }
                    $collection   = collect($request->validated());
                    $collection   = $this->track_data($collection,$request->update_id);
                    $dealer       = $this->model->updateOrCreate(['id'=>$request->update_id],$collection->all());
                    if($request->type == 2){
                        if(empty($request->update_id))
                        {
                            $coa_max_code  = ChartOfAccount::where('level',4)->where('code','like','1020204%')->max('code');
                            $code          = $coa_max_code ? ($coa_max_code + 1) : '1020204000001';
                            $head_name     = $dealer->id.'-'.$dealer->name;
                            $dealer_coa    = ChartOfAccount::create($this->model->coa_data($code,$head_name,$dealer->id));
                            if(!empty($request->previous_balance))
                            {
                                if($dealer_coa){
                                    Transaction::insert($this->model->previous_balance_data($request->previous_balance,$dealer_coa->id,$dealer->name));
                                }
                            }
                        }else{
                            $new_head_name = $request->update_id.'-'.$request->name;
                            $dealer_coa = ChartOfAccount::where('dealer_id',$request->update_id)->first();
                            if($dealer_coa)
                            {
                                $dealer_coa->update(['name'=>$new_head_name]);
                            }
                        }
                    }
                    
                    $output = $this->store_message($dealer, $request->update_id);
                    DB::commit();
                } catch (\Throwable $th) {
                    DB::rollback();
                    $output = ['status'=>'error','message'=>$th->getMessage()];
                }
            }else{
                $output = $this->unauthorized();
            }
            return response()->json($output);
        }else{
            return response()->json($this->unauthorized());
        }
    }

    public function view(Request $request)
    {
        if($request->ajax()){
            if(permission('dealer-view')){
                $dealer   = $this->model->with('district','upazila','areas')->findOrFail($request->id);
                return view('dealer::view-data',compact('dealer'))->render();
            }
        }
    }

    public function edit(Request $request)
    {
        if($request->ajax()){
            if(permission('dealer-edit')){
                $data   = $this->model->findOrFail($request->id);
                $output = $this->data_message($data); 
            }else{
                $output = $this->unauthorized();
            }
            return response()->json($output);
        }else{
            return response()->json($this->unauthorized());
        }
    }

    public function delete(Request $request)
    {
        if($request->ajax()){
            if(permission('dealer-delete')){
                $result   = $this->model->find($request->id)->delete();
                $output   = $this->delete_message($result);
            }else{
                $output   = $this->unauthorized();

            }
            return response()->json($output);
        }else{
            return response()->json($this->unauthorized());
        }
    }

    public function bulk_delete(Request $request)
    {
        if($request->ajax()){
            if(permission('dealer-bulk-delete')){
                DB::beginTransaction();
                try {
                    $result   = $this->model->destroy($request->ids);
                    $output   = $this->bulk_delete_message($result);
                    DB::commit();
                } catch (\Throwable $th) {
                    DB::rollback();
                    $output = ['status'=>'error','message'=>$th->getMessage()];
                }
            }else{
                $output   = $this->unauthorized();
            }
            return response()->json($output);
        }else{
            return response()->json($this->unauthorized());
        }
    }

    public function change_status(Request $request)
    {
        if($request->ajax()){
            if(permission('dealer-edit')){
                $result   = $this->model->find($request->id)->update(['status' => $request->status]);
                $output   = $result ? ['status' => 'success','message' => 'Status Has Been Changed Successfully']
                : ['status' => 'error','message' => 'Failed To Change Status'];
            }else{
                $output       = $this->unauthorized();
            }
            return response()->json($output);
        }else{
            return response()->json($this->unauthorized());
        }
    }

    public function depo_wise_dealer_list(int $depo_id)
    {
        $dealers = DB::table('dealers')
        ->where('depo_id',$depo_id)
        ->pluck('name','id');
        return response()->json($dealers);
    }

    public function area_wise_dealer_list(int $area_id)
    {
        $dealers = DB::table('dealers')
        ->where('area_id',$area_id)
        ->pluck('name','id');
        return response()->json($dealers);
    }

    public function previous_balance(int $id)
    {
        $balance = $this->model->previous_balance($id);
        return  response()->json($balance);
    }
}
