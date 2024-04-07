<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\DataTables\TagDataTable;
use App\Http\Requests\TagRequest;
use Illuminate\Support\Facades\Crypt;
use App\Models\Tag;
use App\Traits\Helper;
use Illuminate\Http\Request;

class TagController extends Controller
{
    use Helper;

    public function index(TagDataTable $dataTable)
    {
        $this->checkAbility(['tags','store-tags', 'update-tags', 'show-tags','delete-tags']);
        return $dataTable->render('dashboard.tags.index');
    }

    public function create()
    {
        $this->checkAbility(['store-tags']);
        return view('dashboard.tags.create');
    }

    public function store(TagRequest $request)
    {
        // return $request;
        try {
            $this->checkAbility(['store-tags']);
            Tag::create([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'status' => $request->status ?? 0,
            ]);
            return redirect()->route('admin.tags.index')->with([
                'message' => __('Item Created successfully.'),
                'alert-type' => 'success']);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show($slug, $id)
    {
        try {
            $this->checkAbility(['show-tags']);
            $tag = Tag::findOrFail(Crypt::decrypt($id));
            return view('dashboard.tags.show', compact('tag'));
        } catch (\Exception $e) {

            return $e->getMessage();
        }

    }

    public function edit( $slug, $id)
    {
        try {
            $this->checkAbility(['update-tags']);
            $tag = Tag::findOrFail(Crypt::decrypt($id));
            return view('dashboard.tags.edit', compact('tag'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(TagRequest $request, $id)
    {
        try {
            $this->checkAbility(['update-tags']);
            $tag = Tag::findOrFail(Crypt::decrypt($id));
            $tag->update([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'status' => $request->status ?? 0,
            ]);
            return redirect()->route('admin.tags.index')->with([
                'message' => __('Item Updated successfully.'),
                'alert-type' => 'success']);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
}

    public function destroy( $id)
    {
        try {
            $this->checkAbility(['delete-tags']);
            $tag = Tag::findOrFail(Crypt::decrypt($id));
            $tag->delete();
            return redirect()->route('admin.tags.index')->with([
                'message' => __('Item Deleted successfully.'),
                'alert-type' => 'success']);
        } catch (\Exception $e) {

            return $e->getMessage();
        }

    }
}
