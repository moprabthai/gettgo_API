<?php

namespace App\Http\Controllers;

use App\Models\Profile_picture;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Profile_pictureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        switch ($request->module) {
            case 'uploadProfile':
                $imageType = $request->image->getClientOriginalExtension();
                $imageName = Str::random(64).".".$imageType;

                // if ($imageType == 'jpg'||$imageType=='png'||$imageType=='jfif') {
                    $emp = Profile_picture::where('emp_id', $request->emp_id)->get();

                    if (count($emp) != 0) {
                        //update
                        Storage::disk('public_uploads')->delete($emp[0]->image);
                        Profile_picture::where('emp_id', $request->emp_id)->update(array(
                            'image' => $imageName
                        ));
                        Storage::disk('public_uploads')->put($imageName, file_get_contents($request->image));
                        return 'Update';
                    } else {
                        //create
                        Profile_picture::create([
                            'emp_id' => $request->emp_id,
                            'image' => $imageName
                        ]);
                        Storage::disk('public_uploads')->put($imageName, file_get_contents($request->image));
                        return 'Create';
                    }
                // }
                break;
            case 'deleteProfile':
                try {
                    $imageName =  Profile_picture::where('emp_id', $request->emp_id)->get()[0]->image;
                    Storage::disk('public_uploads')->delete($imageName);
                    Profile_picture::where('emp_id', $request->emp_id)->delete();
                    return 'Sucess';
                } catch (\Exception) {
                    return 'False';
                }
                break;
            case 'getImage':
                try{
                    $imageName =  Profile_picture::where('emp_id', $request->emp_id)->get()[0]->image;
                    $url = 'http://moprabthai.thddns.net:9090/api/public/storage/profile_image/' . $imageName;
                    return response()->json([
                        "status" => true,
                        "url" => $url
                    ]);
                }
                catch (\Exception) {
                    return response()->json([
                        "status" => false
                    ]);
                }
                break;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile_picture  $profile_picture
     * @return \Illuminate\Http\Response
     */
    public function show(Profile_picture $profile_picture)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile_picture  $profile_picture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile_picture $profile_picture)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile_picture  $profile_picture
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile_picture $profile_picture)
    {
        //
    }
}
