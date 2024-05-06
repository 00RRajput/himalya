<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function showUploadFile($request, $filename, $filePath)
    {
        $fileModel = ['name', 'file_path'];
        $file = $request->file($filename);

        //Display File Name
        $file->getClientOriginalName();
        $file->getClientOriginalExtension();
        $file->getRealPath();
        $file->getMimeType();

        //Move Uploaded File
        $destinationPath = $filePath;
        $fileName = date('m-Y').$file->getClientOriginalName();
        $file->move($destinationPath, $fileName);
        $fileModel['name'] = $fileName;
        $fileModel['file_path'] = $destinationPath . '/' . $fileName;
        return $fileModel;
    }

    public function fileUpload($req, $folder, $filename)
    {
        $fileModel = ['name', 'file_path'];
        if ($req->file()) {
            $fileName = time() . '_' . $req->file->getClientOriginalName();
            $filePath = $req->file($filename)->storeAs($folder, $fileName, 'public');
            $fileModel['name'] = time() . '_' . $req->file->getClientOriginalName();
            $fileModel['file_path'] = '/public/' . $filePath;
            return $fileModel;
        }
    }
}
