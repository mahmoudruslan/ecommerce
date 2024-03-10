<?php

namespace App\Traits;

use App\Models\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use function PHPUnit\Framework\directoryExists;

trait Files
{
    function saveImag($name_folder,   $images)
    {
        try{

            foreach ($images as $image) {
                $photo = $image->getClientOriginalExtension();
                $name = time() . Str::random(6) . '.' . $photo;
                $image->storeAs($name_folder, $name, 'public');
                return $name_folder . '/' . $name;
            }
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }


    function deleteFiles($file_name)
    {
        try{
            File::delete($file_name);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

}



// <?php

// namespace App\Traits;

// use App\Models\Image;
// use Illuminate\Support\Facades\File;
// use Illuminate\Support\Str;
// use function PHPUnit\Framework\directoryExists;

// trait SaveImgTrait
// {
//     function saveimg($name_folder, $photo_owner_id, $model_path, $images)
//     {

//         foreach ($images as $image) {

//             $photo = $image->getClientOriginalExtension();
//             $name = time() . Str::random(6) . '.' . $photo;
//             Image::create([
//                 'filename' => $name,
//                 'imageable_id' => $photo_owner_id,
//                 'imageable_type' => $model_path,
//             ]);
//             $image->storeAs($name_folder, $name, 'attachments');
//         }
//     }



//     function deleteDirectory($directory_path, $id)
//     {
//         $image_ids = Image::where('imageable_id', $id)->select('id')->get();
//         foreach ($image_ids as $image_id) {
//             $image = Image::find($image_id->id);
//             $image->delete();
//         }
//         if (directoryExists($directory_path)) {
//             File::deleteDirectory(public_path($directory_path));
//         }
//     }

//     function deleteFiles($directory_path, $file_name, $id)
//     {
//         try {
//             File::delete('attachments/' . $directory_path . '/' . $file_name);
//             $image = Image::find($id);
//             if($image)
//             {
//                 $image->delete();
//             }

//             $files = File::allFiles('attachments/' . $directory_path);
//             if (empty($files)) {
//                 File::deleteDirectory(public_path('attachments/' . $directory_path));
//             }
//         } catch (\Exception $e) {
//             return redirect()->back()->with(['error' => $e->getMessage()]);
//         }
//     }
// }
