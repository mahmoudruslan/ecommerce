<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Tag;
use App\DataTables\TagDataTable;
use App\Http\Requests\TagRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;

class TagController extends Controller
{

    public function index(TagDataTable $dataTable)
    {
        $permissions = userAbility(['tags','store-tags', 'update-tags', 'show-tags','delete-tags']);
        return $dataTable->with('permissions' , $permissions)->render('dashboard.tags.index');
    }

    public function create()
    {
        userAbility(['store-tags']);
        return view('dashboard.tags.create');
    }

    public function store(TagRequest $request)
    {
        // return $request;
        try {
            userAbility(['store-tags']);
            Tag::create([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'status' => $request->status ?? 0,
            ]);
            $this->updateCacheTags();
            return redirect()->route('admin.tags.index')->with([
                'message' => __('Item Created successfully.'),
                'alert-type' => 'success']);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show(Tag $tag)
    {
        try {
            userAbility(['show-tags']);
            return view('dashboard.tags.show', compact('tag'));
        } catch (\Exception $e) {

            return $e->getMessage();
        }

    }

    public function edit( Tag $tag)
    {
        try {
            userAbility(['update-tags']);
            return view('dashboard.tags.edit', compact('tag'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(TagRequest $request, Tag $tag)
    {
        try {
            userAbility(['update-tags']);
            $tag->update([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'status' => $request->status ?? 0,
            ]);
            $this->updateCacheTags();
            return redirect()->route('admin.tags.index')->with([
                'message' => __('Item Updated successfully.'),
                'alert-type' => 'success']);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
}

    public function destroy(Tag $tag)
    {
        try {
            userAbility(['delete-tags']);
            $tag->delete();
            $this->updateCacheTags();
            return redirect()->route('admin.tags.index')->with([
                'message' => __('Item Deleted successfully.'),
                'alert-type' => 'success']);
        } catch (\Exception $e) {

            return $e->getMessage();
        }

    }
    protected function updateCacheTags()
    {
         $tags = Tag::whereStatus(true)->get();
            Cache::forget('sopping_tags_menu');
            Cache::forever('sopping_tags_menu', $tags);
    }
}
