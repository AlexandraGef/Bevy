<?php

namespace Bevy\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;

class ProfileController extends Controller
{
    public function index($slug){
        return view('profile.index')->with('data',Auth::user()->profile);
    }
    public function getPic()
    {
        return view('profile.pic');
    }

    public function uploadPhoto(Request $request){

        $file = $request->file('pic');
        $filename = $file->getClientOriginalName();

        $path = 'img';

        $file->move($path, $filename);

        $user_id = Auth::user()->id;

        DB::table('users')->where('id', $user_id)->update(['pic'=>'http://localhost:8000/img/'.$filename]);

        return back();
    }

    public function editProfileForm(){
        return view('profile.editProfile')->with('data',Auth::user()->profile);
    }

    public function updateProfile(Request $request)
    {
        $user_id = Auth::user()->id;

        DB('profiles')->where('user_id',$user_id)->update($request->except('_token'));

        return back();
    }
}