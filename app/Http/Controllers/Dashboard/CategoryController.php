<?php

namespace App\Http\Controllers\Dashboard;

use App\Traits\Files;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\CategoryDataTable;
use App\Models\Category;
use App\Models\Product;
use DataTables;
use Yajra\DataTables\Html\Builder;
use App\Http\Requests\CategoryRequest;
use Intervention\Image\Facades\Image;
use Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class CategoryController extends Controller
{
    use Files;
    public function index(CategoryDataTable $dataTable)
    {
        return $dataTable->render('dashboard.categories.index');
    }

    public function create()
    {
        return view('dashboard.categories.create');
    }

    public function store(CategoryRequest $request)
    {
        try {
            if ($image = $request->file('image')) {
                $path = 'images/categories';
                $fileName = $this->saveImag($path, [$request->image]);
                // Image::make($image->getReelPath())->resize(500, null, function($constraint){
                //     $constraint->aspectRatio();
                // })->save($path, 100);
                // dd(true);
                $category = Category::create([
                    'name_ar' => $request->name_ar,
                    'name_en' => $request->name_en,
                    'image' => 'storage/' . $fileName
                ]);
                return redirect()->route('admin.categories.index')->with([
                        'message' => __('Item Created successfully.'),
                        'alert-type' => 'success']);
                }

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show($slug, $id)
    {
        dd('categories show');
        try {
            $category = Category::findOrFail(Crypt::decrypt($id));
            return view('dashboard.categories.show', compact('category'));
        } catch (\Exception $e) {

            return $e->getMessage();
        }

    }

    public function edit( $slug, $id)
    {
        try {
            $category = Category::findOrFail(Crypt::decrypt($id));
            return view('dashboard.categories.edit', compact('category'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(CategoryRequest $request, $id)
    {
        try {
            $category = Category::findOrFail(Crypt::decrypt($id));
            if (isset($request->image)) {
                $this->deleteFiles($category->image);
                $category->image = $this->saveImag('images/categories', [$request->image]);
            }
            $category->update([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'image' => 'storage/' . $category->image,
            ]);
            return redirect()->route('admin.categories.index')->with([
                'message' => __('Item Updated successfully.'),
                'alert-type' => 'success']);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
}

    public function destroy( $id)
    {
        try {
            $category = Category::findOrFail(Crypt::decrypt($id));
            $this->deleteFiles($category->image);
            $category->delete();
            return redirect()->route('admin.categories.index')->with([
                'message' => __('Item Deleted successfully.'),
                'alert-type' => 'success']);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

}
