<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Http\Requests\TeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use Alert;
class TeamController extends Controller
{
    public function index()
    {
        $data = Team::paginate(10);
        return view('dashboard.teams.index',compact('data'));
    }

    public function create()
    {
        return view('dashboard.teams.create');
    }
    public function edit($id)
    {
        $data = Team::findOrFail($id);

       return view('dashboard.teams.edit',compact('data'));
    }
    public function update(UpdateTeamRequest $request,$id)
    {
        $data  = [
            'social_media'=>json_encode(
                [
                    'twitter'=>$request->twitter,
                    'facebook'=>$request->facebook,
                ]),
                'name'=>[
                    'ar'=>$request->name_ar,
                    'en'=>$request->name_en,
                ],
                'description'=>[
                    'ar'=>$request->description_ar,
                    'en'=>$request->description_en,
                ]
        ];

        $merge = array_merge($request->all(),$data);
        $data = Team::find($id);

        if($request->hasFile('image'))
        {
            $data->ClearMediaCollection('image')
            ->addMedia($request->file('image'))
            ->toMediaCollection('image');
        }
        $data->update($merge);
        Alert::toast('Team member was updated', 'success');
        return redirect()->route('dashboard.teams.index');
    }
    public function store(TeamRequest $request)
    {
        $data  = [
            'social_media'=>json_encode(
                [
                    'twitter'=>$request->twitter,
                    'facebook'=>$request->facebook,
                ]),
                'name'=>[
                    'ar'=>$request->name_ar,
                    'en'=>$request->name_en,
                ],
                'description'=>[
                    'ar'=>$request->description_ar,
                    'en'=>$request->description_en,
                ]
        ];

        $merge = array_merge($request->all(),$data);
        $data = Team::create($merge);
        $data->addMedia($request->file('image'))
        ->toMediaCollection('image');
        Alert::toast('Team member was created', 'success');
        return redirect()->route('dashboard.teams.index');
    }

    public function delete($id)
    {
        $team = Team::find($id);
        $team->ClearMediaCollection('image');
        $team->delete();

        Alert::toast('Team member was deleted', 'success');
        return response()->json([
            'msg'=>'Team member was deleted',
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));

    }


}
