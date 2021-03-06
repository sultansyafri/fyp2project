<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

//use File;

class UserController extends Controller
{
    public function myprofile()
    {
        return view('profile');
    }

    public function profileupdate(Request $request)
    {
        $user_id = Auth::user()->id;
        $user = User::findOrFail($user_id);
        $user->fname = $request->input('fname');
        $user->lname = $request->input('lname');
        $user->address1 = $request->input('address1');
        $user->address2 = $request->input('address2');
        $user->city = $request->input('city');
        $user->state = $request->input('state');
        $user->postcode = $request->input('postcode');
        $user->phone = $request->input('phone');
        $user->alternatephone = $request->input('alernatephone');

        if($request->hasfile('image'))
        {
            $destination = 'uploads/profile/'.$user->image;
            if(File::exists($destination)){
                File::delete($destination);

            }
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/profile/', $filename);
            $user->image = $filename;
        }

        $user->update();
        return redirect()->back()->with('status','Profile Updated');

    }
}