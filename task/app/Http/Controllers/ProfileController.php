<?php

namespace App\Http\Controllers;

use App\Http\Requests\profileStoreRequest;
use App\Http\Requests\profileUpdateRequest;
use App\Models\Profile;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profiles=Profile::all();
        return response()->json($profiles,200);
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(profileStoreRequest $request)
{

    $user_id= Auth::id();
    $validated= $request->Validated();
    $validated['user_id']=$user_id;

    //image upload
    if($request->hasFile('img_profile')){
        $path = $request->file('img_profile')->store('images_profiles','public');
        $validated['img_profile']=$path;
        
    }
    $profile=Profile::create($validated);




    return response()->json($profile, 201);
}

    /**
     * Display the specified resource.
     */

    public function show(Profile $profile)
    {
            if(Auth::id() != $profile->user_id){
            return response()->json("Undefined",403);

    }

        $profile->load('user.tasks');
        return response()->json($profile,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(profileUpdateRequest $request,  $id)
    {
        $profile= Profile::findOrFail($id);
        $user_id= Auth::id();
        if($profile->user_id != $user_id){
            return response()->json("لا لا لا ",403);
        }
        $data =$request->validated();
        $profile->update($data);
        return response()->json($profile,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $profile= Profile::findOrFail($id);
               $user_id= Auth::id();
        if($profile->user_id != $user_id){
            return response()->json("لا لا لا ",403);
        }

        $profile->delete( );
        return response()->json("Profile deleted successfully",200);
    }
}
