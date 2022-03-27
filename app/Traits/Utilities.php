<?php

namespace App\Traits;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

trait Utilities
{
    public function ifNotExistsInDB($tableName, $idColumnName, $id)
    {
        $find = "where".ucfirst($idColumnName);
        $hay = DB::table($tableName)->$find($id)->get();
        if(count($hay) == 0){
            return true;
        }
    }


    public function uploadImageBase64($image, $folder)
    {

        $folderPath = $folder;
        $image_parts =  explode(";base64,", $image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type_new = explode(";base64,", $image_type_aux[1]);
        $image_type = $image_type_new[0];
        //specify the extensions allowed
        $extensions = array('png', 'gif', 'jpg', 'jpeg');

        if (in_array($image_type, $extensions) === false) {
            // $error = $this->failedResponse($message, $status);
            return ["status" => false];
        }
        $image_base64 = base64_decode($image_parts[1]);
        $imagename = md5(uniqid(). time()) . '.'.$image_type;
        $destinationpath = $folderPath . $imagename;
        Storage::put($destinationpath, $image_base64);
        return ["status" => true, "data" => $imagename];
    }

    public function deleteImage($deleteImage, $folder)
    {
        $destinationPath = public_path('/'.$folder);
        $oldImage = $destinationPath."/".$deleteImage;
        if (file_exists($oldImage)) {
            unlink($oldImage);
        }
    }


    //generate the coupon code
    public function generateCode($length_of_string)
    {
        return substr(sha1(time()), 0, $length_of_string);
    }

}
