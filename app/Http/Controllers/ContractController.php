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
}
