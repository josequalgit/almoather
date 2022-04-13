<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contract;
use App\Http\Requests\UpdateContractRequest;

class ContractController extends Controller
{
    public function edit()
    {
        $data = Contract::find(1);

        return view('dashboard.contract.edit',compact('data'));
    }

    public function update(UpdateContractRequest $request)
    {
        $data = Contract::find(1)->update($request->all());
        return back();
    }

    public function get_active_contracts()
    {
        $data = Contract::where([['is_accepted',1],['is_completed',0]])->paginate(10);
        
        return view('dashboard.contract.activeContract',compact('data'));
    }

    public function change_status_contracts(Request $request,$id,$status)
    {
        $data = Contract::find($id);
        if(!$data) return response()->json([
            'msg'=>'contract not found',
            'status'=>config('global.UNAUTHORIZED_VALIDATION_STATUS')
        ],config('global.UNAUTHORIZED_VALIDATION_STATUS'));
        
        $data->is_completed = $status == 1?1:0;
        $data->rejectNote = $request->note;
        $data->admin_status = $status?1:0;
        $data->save();

        return response()->json([
            'msg'=>'contract was updated',
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }
}
