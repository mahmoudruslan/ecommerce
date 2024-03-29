<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use function PHPUnit\Framework\directoryExists;

trait Files
{
    function saveImag($path, $images)
    {
        try{

            foreach ($images as $image) {
                $extension = $image->getClientOriginalExtension();
                $image_name = time() . Str::random(6) . '.' . $extension;
                $image->storeAs($path, $image_name, 'public');
                return $image_name;
            }
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }


    function resizeImage($width, $hight, $path, $file_name, $image)
    {
        try{
            // dd($path . $file_name);
            Image::make($image->getRealPath())->resize($width, $hight, function($constraint){
                $constraint->aspectRatio();
            })->save('storage/' . $path . $file_name, 100);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    function deleteFiles($file_name)
    {
        try{
            $file_path = 'storage/'. $file_name;
            if (File::exists($file_path)) {
                File::delete($file_path);
                return true;
            }
            return false;

        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

}

