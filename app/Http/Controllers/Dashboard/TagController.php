<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\TagDataTable;
use Yajra\DataTables\Html\Builder;
use App\Http\Requests\TagRequest;
use Illuminate\Support\Facades\Crypt;
use App\Models\Tag;
use DataTables;
use Hash;

class TagController extends Controller
{
    public function index(TagDataTable $dataTable)
    {
        return $dataTable->render('dashboard.tags.index');
    }

    public function create()
    {
        // $permissions = Permission::get();
        return view('dashboard.tags.create');
    }

    public function store(TagRequest $request)
    {
        try {
            $tag = Tag::create([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'image' => 'avatar.png',
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
            dd('tags show');
            $tag = Tag::findOrFail(Crypt::decrypt($id));
            return view('dashboard.tags.show', compact('tag'));
        } catch (\Exception $e) {

            return $e->getMessage();
        }

    }

    public function edit( $slug, $id)
    {
        try {
            $tag = Tag::findOrFail(Crypt::decrypt($id));
            return view('dashboard.tags.edit', compact('tag'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(TagRequest $request, $id)
    {
        try {
            $tag = Tag::findOrFail(Crypt::decrypt($id));
            $tag->update([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'image' => 'avatar.png',
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
            $tag = Tag::findOrFail(Crypt::decrypt($id));
            $tag->delete();
            return redirect()->route('admin.tags.index')->with('success', __('Item Deleted successfully.'));
        } catch (\Exception $e) {

            return $e->getMessage();
        }

    }
}
