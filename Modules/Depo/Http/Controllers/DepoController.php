<?php

namespace Modules\Depo\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Depo\Entities\Depo;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use Modules\Account\Entities\ChartOfAccount;
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
                    if(permission('depo-delete')){
                        if($value->deletable == 2){
                        $action .= ' <a class="dropdown-item delete_data"  data-id="' . $value->id . '" data-name="' . $value->name . '">'.self::ACTION_BUTTON['Delete'].'</a>';
                        }
                    }

                    $row = [];
                    if(permission('depo-bulk-delete')){
                        $row[] = ($value->deletable == 2) ? row_checkbox($value->id) : '';//custom helper function to show the table each row checkbox
                    }
                    $row[] = $no;
                    $row[] = $value->name;
                    $row[] = $value->district_name;
                    $row[] = $value->mobile_no;
                    $row[] = $value->email;
                    $row[] = $value->address;
                    $row[] = $value->commission_rate;
                    $row[] = $this->model->balance($value->id).' Tk';
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
                $collection   = collect($request->validated());
                $collection   = $this->track_data($collection,$request->update_id);
                $depo       = $this->model->updateOrCreate(['id'=>$request->update_id],$collection->all());
                
                if(empty($request->update_id))
                {
                    $coa_max_code  = ChartOfAccount::where('level',3)->where('code','like','50201%')->max('code');
                    $code          = $coa_max_code ? ($coa_max_code + 1) : '5020101';
                    $head_name     = $depo->id.'-'.$depo->name;
                    $depo_coa_data = $this->model->coa($code,$head_name,$depo->id);
                    $depo_coa      = ChartOfAccount::create($depo_coa_data);
                    if(!empty($request->previous_balance))
                    {
                        if($depo_coa){
                            $this->previous_balance_add($request->previous_balance,$depo_coa->id,$depo->name);
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
                $this->model->flushCache();
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
            if(permission('depo-edit')){
                $data   = $this->model->findOrFail($request->id);
                $output = $this->data_message($data); //if data found then it will return data otherwise return error message
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
            if(permission('depo-delete')){
                $result   = $this->model->find($request->id)->delete();
                $output   = $this->delete_message($result);
                $this->model->flushCache();
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
                $this->model->flushCache();
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
                $this->model->flushCache();
            }else{
                $output       = $this->unauthorized();
            }
            return response()->json($output);
        }else{
            return response()->json($this->unauthorized());
        }
    }
}
