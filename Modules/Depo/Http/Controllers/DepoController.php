<?php

namespace Modules\Depo\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Depo\Entities\Depo;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use Modules\Account\Entities\ChartOfAccount;
use Modules\Account\Entities\Transaction;
use Modules\Depo\Http\Requests\DepoFormRequest;

class DepoController extends BaseController
{
    public function __construct(Depo $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if(permission('depo-access')){
            $this->setPageData('Depo','Depo','fas fa-store',[['name' => 'Depo']]);
            $districts = DB::table('locations')->where([['type',1],['status',1]])->orderBy('id','asc')->pluck('name','id');
            return view('depo::index',compact('districts'));
        }else{
            return $this->access_blocked();
        }
    }

    public function get_datatable_data(Request $request)
    {
        if($request->ajax()){
            if(permission('depo-access')){

                if (!empty($request->name)) {
                    $this->model->setName($request->name);
                }

                if (!empty($request->mobile_no)) {
                    $this->model->setMobileNo($request->mobile_no);
                }
                if (!empty($request->email)) {
                    $this->model->setEmail($request->email);
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
                    if(permission('depo-edit')){
                        $action .= ' <a class="dropdown-item edit_data" data-id="' . $value->id . '">'.self::ACTION_BUTTON['Edit'].'</a>';
                    }
                    if(permission('depo-view')){
                        $action .= ' <a class="dropdown-item view_data" data-id="' . $value->id . '"  data-name="' . $value->name . '">'.self::ACTION_BUTTON['View'].'</a>';
                    }
                    if(permission('depo-delete')){
                        $action .= ' <a class="dropdown-item delete_data"  data-id="' . $value->id . '" data-name="' . $value->name . '">'.self::ACTION_BUTTON['Delete'].'</a>';
                    }

                    $row = [];
                    if(permission('depo-bulk-delete')){
                        $row[] = row_checkbox($value->id);//custom helper function to show the table each row checkbox
                    }
                    $row[] = $no;
                    $row[] = $value->name;
                    $row[] = $value->mobile_no;
                    $row[] = $value->email;
                    $row[] = $value->district_name;
                    $row[] = $value->upazila_name;
                    $row[] = $value->area_name;
                    $row[] = $value->commission_rate;
                    $row[] = number_format($value->balance,2,'.','').' Tk';
                    $row[] = permission('depo-edit') ? change_status($value->id,$value->status, $value->name) : STATUS_LABEL[$value->status];
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

    public function store_or_update_data(DepoFormRequest $request)
    {
        if($request->ajax()){
            if(permission('depo-add')){
                DB::beginTransaction();
                try {
                    $collection   = collect($request->validated());
                    $collection   = $this->track_data($collection,$request->update_id);
                    $depo         = $this->model->updateOrCreate(['id'=>$request->update_id],$collection->all());
                    
                    if(empty($request->update_id))
                    {
                        $coa_max_code  = ChartOfAccount::where('level',4)->where('code','like','1020203%')->max('code');
                        $code          = $coa_max_code ? ($coa_max_code + 1) : '102020300001';
                        $head_name     = $depo->id.'-'.$depo->name;
                        $depo_coa      = ChartOfAccount::create($this->model->coa_data($code,$head_name,$depo->id));
                        if(!empty($request->previous_balance))
                        {
                            if($depo_coa){
                                Transaction::insert($this->model->previous_balance_data($request->previous_balance,$depo_coa->id,$depo->name));
                            }
                        }
                    }else{
                        $new_head_name = $request->update_id.'-'.$request->name;
                        $depo_coa = ChartOfAccount::where('depo_id',$request->update_id)->first();
                        if($depo_coa)
                        {
                            $depo_coa->update(['name'=>$new_head_name]);
                        }
                    }
                    $output = $this->store_message($depo, $request->update_id);

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
            if(permission('depo-view')){
                $depo   = $this->model->with('district','upazila','area')->findOrFail($request->id);
                return view('depo::view-data',compact('depo'))->render();
            }
        }
    }

    public function edit(Request $request)
    {
        if($request->ajax()){
            if(permission('depo-edit')){
                $data   = $this->model->findOrFail($request->id);
                $output = $this->data_message($data); //if data found then it will return data otherwise return error message
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
            if(permission('depo-delete')){
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
            if(permission('depo-bulk-delete')){
                $result   = $this->model->destroy($request->ids);
                $output   = $this->bulk_delete_message($result);
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
            if(permission('depo-edit')){
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

    public function area_wise_depo_list(int $area_id)
    {
        $depos = DB::table('depos')
        ->where('area_id',$area_id)
        ->pluck('name','id');
        return response()->json($depos);
    }

    public function previous_balance(int $id)
    {
        $balance = $this->model->previous_balance($id);
        return  response()->json($balance);
    }
}
