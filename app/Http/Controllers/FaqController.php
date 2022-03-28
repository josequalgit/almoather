<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FAQ;
use App\Http\Requests\FaqRequest;
use Alert,Auth;

class FaqController extends Controller
{
    public function index()
    {
        $data = FAQ::paginate(10);
        //return $data;
        return view('dashboard.faqs.index',compact('data'));
    }

    public function create()
    {
        return view('dashboard.faqs.create');
    }

    public function edit($id)
    {
        $data = FAQ::findOrFail($id);

        return view('dashboard.faqs.edit',compact('data'));
    }

    public function store(FaqRequest $request)
    {
        $allFelids = $request->all();
        $addTranslate = [
            'question'=>[
                'ar'=>$request->answer_ar,
                'en'=>$request->answer_en,
            ],
            'answer'=>[
                'ar'=>$request->question_ar,
                'en'=>$request->question_en,
            ]
        ];
        $data = FAQ::create($addTranslate);
        activity()->log('Admin "'.Auth::user()->name.'" added new question"'. $data->question .'".');
        Alert::toast('Faq was added', 'success');
        return redirect()->route('dashboard.faqs.index');
    }
    public function update(FaqRequest $request,$id)
    {
        $data = FAQ::find($id);
        $allFelids = $request->all();
        $addTranslate = [
            'question'=>[
                'ar'=>$request->question_ar,
                'en'=>$request->question_en,
            ],
            'answer'=>[
                'ar'=>$request->answer_ar,
                'en'=>$request->answer_en,
            ]
        ];
        $data->update($addTranslate);
        activity()->log('Admin "'.Auth::user()->name.'" updated question"'. $data->question .'".');
        Alert::toast('Faq was updated', 'success');
        return redirect()->route('dashboard.faqs.index');
    }

    public function delete($id)
    {
        $data = FAQ::find($id);
        activity()->log('Admin "'.Auth::user()->name.'" deleted question"'. $data->question .'".');

        $data->delete();
        Alert::toast('Faq was deleted', 'success');

        return response()->json([
            'status'=>200,
            'msg'=>'faq was deleted'
        ],200);

    }
}
