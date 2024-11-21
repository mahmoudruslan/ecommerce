<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

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
            if (File::exists($file_path) && $file_name != 'images/users/avatar.png') {
                File::delete($file_path);
                return true;
            }
            return false;

        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function createProductMedia($images, $product)
    {
         //create media
        $i = 1;
        if(isset($images) && count($images) > 0)
        {
            foreach ($images as $image) {
                if($image){
                    // dd($image);

                    $path = 'images/products/';
                    $extension = $image->getClientOriginalExtension();
                    $image_name = time() . Str::random(6) . '.' . $extension;
                    $image->storeAs($path, $image_name, 'public');
                    $size = $image->getSize();
                    $mimetype = $image->getClientMimeType();

                    $this->resizeImage(200, null, $path, $image_name, $image);
                    $product->media()->create([
                        'file_name' => $path . $image_name,
                        'file_size' => $size,
                        'file_type' => $mimetype,
                        'file_sort' => $i,
                        'status' => true
                    ]);
                    $i++;
                }
            }
        }
    }

    public function deleteProductMedia($product)
    {
         //delete media
        $path = 'storage/';
        $images = $product->media()->pluck('file_name');
        foreach($images as $image)
        {
            if (File::exists($path . $image)) {
                File::delete($path . $image);
            }
        }
        $product->media()->delete();
    }

}

