<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactUs;
use App\Http\Requests\ContactUsRequest;
use App\Http\Requests\UpdateTermsRequest;
use App\Models\Privacy;
use App\Models\Terms;
use Alert;
use Auth;

class ContactUsController extends Controller
{

    public function index()
    {
        $data = Privacy::find(1);
        return view('dashboard.privacy.index',compact('data'));
    }
    public function indexTerms()
    {
        $data = Terms::find(1);
        return view('dashboard.terms.index',compact('data'));
    }
    public function indexPolicy()
    {
        $data = Privacy::find(2);
        return view('dashboard.privacy.return-policy',compact('data'));
    }
    public function updatePrivacy(Request $request)
    {
        $data = Privacy::updateOrCreate(['id' => 2],[
            'text'=>[
                'ar'=>$request->text_ar,
                'en'=>$request->text_en,
            ]
        ]);
        Alert::toast('Page was updated', 'success');

       return back();
    }
    public function updatePolicy(Request $request)
    {
        $data = Privacy::updateOrCreate(['id' => 2],[
            'text'=>[
                'ar'=>$request->text_ar,
                'en'=>$request->text_en,
            ]
        ]);
       
        Alert::toast('Page was updated', 'success');
        
       return back();
    }

    public function edit()
    {
        $data = ContactUs::find(1);
        $privacy = Privacy::find(1);
        $terms = Terms::find(1);
        return view('dashboard.contactUs.edit',compact('data','privacy','terms'));
    }

    public function update(ContactUsRequest $request)
    {
        ContactUs::find(1)->update($request->all());
        activity()->log('Admin "'.Auth::user()->name.'" updated the contact us page');
        Alert::toast('Page was updated', 'success');
        return back();
    }

    public function updateTerms(UpdateTermsRequest $request)
    {
        if(!$request->text_ar||!$request->text_en){
            Alert::toast('Please fill the terms and conditions section', 'error');
            return back();
        }
        $allFelids = $request->all();
        $addTranslate = [
            'text'=>[
                'ar'=>$request->text_ar,
                'en'=>$request->text_en,
            ],
        ];
        Terms::find(1)->update($addTranslate);
        activity()->log('Admin "'.Auth::user()->name.'" updated the terms and conditions');
        Alert::toast('Terms and conditions was updated', 'success');

        return back();
    }

    public function updatePrivacys(UpdateTermsRequest $request)
    {
        if(!$request->text_ar||!$request->text_en){
            Alert::toast('Please fill the privacy section', 'error');
            return back();
        }
        $allFelids = $request->all();
        $addTranslate = [
            'text'=>[
                'ar'=>$request->text_ar,
                'en'=>$request->text_en,
            ],
        ];
        Privacy::find(1)->update($addTranslate);
        activity()->log('Admin "'.Auth::user()->name.'" updated the privacy');
        Alert::toast('Privacy was updated', 'success');

        return back();
    }
}
