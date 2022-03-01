<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactUs;
use App\Http\Requests\ContactUsRequest;
use App\Models\Privacy;
use App\Models\Terms;
use Alert;
use Auth;

class ContactUsController extends Controller
{
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

    public function updateTerms(Request $request)
    {
        if(!$request->text){
            Alert::toast('Please fill the terms and conditions section', 'error');
            return back();
        }
        Terms::find(1)->update($request->all());
        activity()->log('Admin "'.Auth::user()->name.'" updated the terms and conditions');
        Alert::toast('Terms and conditions was updated', 'success');

        return back();
    }

    public function updatePrivacy(Request $request)
    {
        if(!$request->text){
            Alert::toast('Please fill the privacy section', 'error');
            return back();
        }
        Privacy::find(1)->update($request->all());
        activity()->log('Admin "'.Auth::user()->name.'" updated the privacy');
        Alert::toast('Privacy was updated', 'success');

        return back();
    }
}
