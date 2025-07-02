<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $profile = Profile::where('user_id',$id)->first();
        return view('editProfile',compact('profile'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'profile_image' => 'mimes:png,jpg,jpeg,gif',
            'name' => 'min:3',
            'phone' => 'integer|digits:10',
            'gender' => '',
            'date_of_birth' => 'date',
            'address' => 'max:255'
        ]);

        
        $user = $request->user();
        $user->name = $request->name;
        $user->save();
        $profile = Profile::where('user_id',$id)->first();
        $profile->phone = $request->phone;
        $profile->gender = $request->gender;
        $profile->date_of_birth = $request->date_of_birth;
        $profile->address = $request->address;
        if($request->profile_image != ''){
            $path = public_path() . '/uploads/';
            if($profile->profile_image != ''  && $profile->profile_image != null){
                $old_file = $path . $profile->profile_image;
                if (file_exists($old_file)) {
                    unlink($old_file);
                }
            }
            $img = $request->profile_image;
            $ext = $img->getClientOriginalExtension();
            $imageName = time() . "." . $ext;
            $img->move(public_path() . "/uploads", $imageName);
            $profile->profile_image = $imageName;
        } else {
                $imageName = $profile->profile_image;
            }
        
        $profile->save();
        return redirect()->back()->with('success','Profile Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,string $id)
    {
        $request->validate([
            'password' => 'required|min:4'
        ]);

        $user = User::find($id);
        if(Hash::check($request->password,$user->password)){
            Auth::logout();
            $user->delete();
            return redirect(route('home'))->with('success',"Account Deleted Successfully");
        }
        return redirect()->back()->with('error',"Incorrect Password");


    }
}
