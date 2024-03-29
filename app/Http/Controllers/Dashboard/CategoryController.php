<?php

namespace App\Http\Controllers\Dashboard;

use App\Traits\Files;
use App\Http\Controllers\Controller;
use App\DataTables\CategoryDataTable;
use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class CategoryController extends Controller
{
    use Files;
    public function index(CategoryDataTable $dataTable)
    {
        $user = auth()->user();
        if(!$user->hasAnyDirectPermission(['update-category', 'show-category','delete-category'])
        ||
        !$user->hasRole(['categories'])
        ){
            dd('403 forbidden');
        }
        return $dataTable->render('dashboard.categories.index');
    }

    public function create()
    {
        $categories = Category::where('parent_id', null)->get(['id', 'name_ar', 'name_en']);
        return view('dashboard.categories.create', compact('categories'));
    }

    public function store(CategoryRequest $request)
    {
        try{
                $image = $request->file('image');
                $path = 'images/categories/';
                $file_name = $this->saveImag($path, [$request->image]);
                $this->resizeImage(300, null, $path, $file_name, $image);
                $category = Category::create([
                    'name_ar' => $request->name_ar,
                    'name_en' => $request->name_en,
                    'image' => $path . $file_name,
                    'parent_id' => $request->parent_id ?? null,
                ]);
                return redirect()->route('admin.categories.index')->with([
                        'message' => __('Item Created successfully.'),
                        'alert-type' => 'success']);

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
            $categories = Category::where('parent_id', null)->get(['id', 'name_ar', 'name_en', 'image']);
            $category = Category::findOrFail(Crypt::decrypt($id));
            return view('dashboard.categories.edit', compact('category', 'categories'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(CategoryRequest $request, $id)
    {

        try {
            $category = Category::findOrFail(Crypt::decrypt($id));
            $file_name = $category->image;
            $path = '';
            if ($image = $request->file('image')) {
                $this->deleteFiles($file_name);
                $path = 'images/categories/';
                $file_name = $this->saveImag($path, [$request->image]);
                $this->resizeImage(300, null, $path, $file_name, $image);
            }
            $category->update([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'image' =>  $path . $file_name,
                'parent_id' => $request->parent_id ?? null,
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
            if(count($category->children) > 0){
                return redirect()->route('admin.categories.index')->with([
                    'message' => __('This is category has subcategories'),
                    'alert-type' => 'danger']);
            } else if(count($category->products) > 0){
                return redirect()->route('admin.categories.index')->with([
                    'message' => __('This is category has products'),
                    'alert-type' => 'danger']);
            }

            $this->deleteFiles($category->image);
            $category->delete();
            return redirect()->route('admin.categories.index')->with([
                'message' => __('Item Deleted successfully.'),
                'alert-type' => 'success']);


        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
    public function removeImage($category_id)
    {
        $category = Category::findOrFail($category_id);

        $this->deleteFiles($category->image);
        $category->image = null;
        $category->save();
        return response()->json([]);
    }

}
