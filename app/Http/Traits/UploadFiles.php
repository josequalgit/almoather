<?php 
namespace App\Http\Traits;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

trait UploadFiles {

    public function uploadFile($folderName,$file)
    {
         #CHECK IF THE GIVEN FOLDER IT DOSE EXIST IF NOT CREATE ONE.
         if(!Storage::disk('public')->exists($folderName)) Storage::disk('public')->makeDirectory($folderName);
         #CHECK IF THE FILE IS VALID.
         if(!$file->isValid()) throw new \Exception('ERROR ON UPLOAD FILES: '.$file->getErrorMessage());
         # UPLOAD THE FILE TO THE CHOSEN PATH AND DISK.
         $file_path = Storage::disk('public')->put($folderName,$file);
       
         # CREATE THE FILE URL.
         $full_url_path = URL::to('/storage/'.$file_path);
         # RETURN THE FULL USEABLE URL THE USER CAN SAVE IN THE DATABASE.
         return $full_url_path;
    }
}