<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image as Image;

class Gallery extends Controller
{
    /**
    *@samip shrestha*
    **/
    

    public function saveImage($image,$path ,$width="0",$height="0")
    {
       /* $path = 'assets/uploads/magazine/image/'*/
       if($image != "")
       {
            $imageNewName = rand(11111,99999).'_' . time().rand().'.'. 'jpg';
            $image->move( base_path() . '/public/'.$path, $imageNewName);
            /*$img = Image::make($path.$imageNewName);
            if($width > 0 &&  $height > 0)
            {
                $img->resize($width, $height);
            }
            $img->save($path.$imageNewName, 30);*/
            return $imageNewName;
       }
       return '';
        
    }

    public function checkImageForUpdate( $oldFile , $newFile , $path,$width=0,$height=0 )
    {
        if( $newFile == "" )
        {
            /*no new file*/
            return $oldFile;
        }
        else
        {
            /*new file exits*/
            \File::delete( $path.$oldFile );
            $fileName = $this->saveImage( $newFile,$path,$width,$height );
            return $fileName;
        }
    }

}
