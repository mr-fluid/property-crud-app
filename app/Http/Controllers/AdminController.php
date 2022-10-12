<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Support\Str;
use App\Http\Requests\PropertyPostRequest;
use App\Http\Requests\PropertyEditRequest;
use Image;
use File;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $properties = Property::with('property')->get();
        return response()->json($properties);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PropertyPostRequest $request)
    {
        
        $image = $request->file('image');
        $imagename = 'image'.time().'.'.$image->getClientOriginalExtension();
        $thumbnailname = 'thumbnail'.time().'.'.$image->getClientOriginalExtension();

        $destinationPath = public_path('/thumbnail');
        $thumbnail = Image::make($image->getRealPath());
        $thumbnail->resize(150, 150, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$thumbnailname);
   
        $destinationPath = public_path('/image');
        $img = Image::make($image->getRealPath());
        $img->resize( 1000,400, function ($constraint) {
            
        })->save($destinationPath.'/'.$imagename);

        $uuid = Str::uuid()->toString();
        $validated = $request->safe()->except(['image']);
        $property = Property::create(array_merge($validated, ['uuid' => $uuid],['image_full' => $imagename],['image_thumbnail' => $thumbnailname],['data_source' => 'local']));
        return response()->json([
            'message'=>'Property Created Successfully!!',
            'property'=>$property
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $property = Property::find($id);
        return response()->json($property);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $property = Property::find($id);
        return response()->json($property);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PropertyEditRequest $request, $id)
    {
        
        $validated = $request->safe()->except(['image']);
        $property = Property::find($id);
        if($request->file('image')){
            if (File::exists(public_path("image/".$property->image_full))) {
            File::delete(public_path("image/".$property->image_full));
            }
            if (File::exists(public_path("thumbnail/".$property->image_thumbnail))) {
            File::delete(public_path("thumbnail/".$property->image_thumbnail));
            }

            $image = $request->file('image');
            $imagename = 'image'.time().'.'.$image->getClientOriginalExtension();
            $thumbnailname = 'thumbnail'.time().'.'.$image->getClientOriginalExtension();
    
            $destinationPath = public_path('/thumbnail');
            $thumbnail = Image::make($image->getRealPath());
            $thumbnail->resize(150, 150, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$thumbnailname);
       
            $destinationPath = public_path('/image');
            $img = Image::make($image->getRealPath());
            $img->resize( 1000,400, function ($constraint) {
                
            })->save($destinationPath.'/'.$imagename);
            $merged_data = array_merge($validated,['image_full' => $imagename],['image_thumbnail' => $thumbnailname]);
        }
      
        else{
            $merged_data = $validated;
        }
        
        
        $property->fill($merged_data)->save();
        return response()->json([
            'message'=>'Property Updated Successfully!!',
            'property'=>$property
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $property = Property::find($id);
        if (File::exists(public_path("image/".$property->image_full))) {
            File::delete(public_path("image/".$property->image_full));
            }
            if (File::exists(public_path("thumbnail/".$property->image_thumbnail))) {
            File::delete(public_path("thumbnail/".$property->image_thumbnail));
            }
        $property->delete();
        return response()->json([
            'message'=>'Property Deleted Successfully!!'
        ]);
    }
}
