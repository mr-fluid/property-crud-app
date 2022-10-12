<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TrialApi;
use App\Models\Property;
use App\Models\PropertyType;


class ApiController extends Controller
{

    public function fetchFromApi(TrialApi $trialApi){
        
       $properties =  json_decode($trialApi->getResponse());
       foreach($properties->data as $key=>$value){
        if(!Property::where('uuid',$value->uuid)->exists()){
         Property::Create([
            "uuid" =>  $value->uuid,
            "county" =>  $value->county,
            "country" =>  $value->country,
            "town" =>  $value->town,
            "description" =>  $value->description,
            "address" =>  $value->address,
            "image_full" =>  $value->image_full,
            "image_thumbnail" =>  $value->image_thumbnail,
            "latitude" =>  $value->latitude,
            "longitude" =>  $value->longitude,
            "num_bedrooms" =>  $value->num_bedrooms,
            "num_bathrooms" =>  $value->num_bathrooms,
            "price" =>  $value->price,
            "type" =>  $value->type,
            "property_type" =>  $value->property_type_id,
            "created_at" =>  $value->created_at,
            "updated_at" =>  $value->updated_at,
            "data_source" => "api"
         ]);
        }
        else{
         Property::where('uuid', $value->uuid)->update([
            "uuid" =>  $value->uuid,
            "county" =>  $value->county,
            "country" =>  $value->country,
            "town" =>  $value->town,
            "description" =>  $value->description,
            "address" =>  $value->address,
            "image_full" =>  $value->image_full,
            "image_thumbnail" =>  $value->image_thumbnail,
            "latitude" =>  $value->latitude,
            "longitude" =>  $value->longitude,
            "num_bedrooms" =>  $value->num_bedrooms,
            "num_bathrooms" =>  $value->num_bathrooms,
            "price" =>  $value->price,
            "type" =>  $value->type,
            "property_type" =>  $value->property_type_id,
            "created_at" =>  $value->created_at,
            "updated_at" =>  $value->updated_at,
            "data_source" => "api"
         ]);
        }
      
        if(!PropertyType::where('id',$value->property_type->id)->exists()){
         PropertyType::Create([
            "id" =>  $value->property_type->id,
            "title" =>  $value->property_type->title,
            "description" =>  $value->property_type->description,
            "created_at" =>  $value->property_type->created_at,
            "updated_at" =>  $value->property_type->updated_at,
         ]);
        }
        else{
         PropertyType::where('id', $value->property_type->id)->update([
            "id" =>  $value->property_type->id,
            "title" =>  $value->property_type->title,
            "description" =>  $value->property_type->description,
            "created_at" =>  $value->property_type->created_at,
            "updated_at" =>  $value->property_type->updated_at,
         ]);
        }
        
       }
    }
}
