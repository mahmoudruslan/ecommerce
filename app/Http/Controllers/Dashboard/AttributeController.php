<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\AttributeDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Attributes\StoreAttributeRequest;
use App\Http\Requests\Attributes\UpdateAttributeRequest;
use App\Models\Attribute;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AttributeDataTable $dataTable)
    {
        $permissions = userAbility(['attributes','store-attributes', 'update-attributes', 'show-attributes','delete-attributes']);
        return $dataTable->with('permissions' , $permissions)->render('dashboard.attributes.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.attributes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttributeValueRequest $request)
    {
//        dd($request);
        Attribute::create($request->validated());
        return redirect()->route('admin.attributes.index')->with([
            'message' => __('attribute Created successfully.'),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function show(Attribute $attribute)
    {
        dd($attribute);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function edit(Attribute $attribute)
    {
        return view('dashboard.attributes.edit', compact('attribute'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttributeRequest $request, Attribute $attribute)
    {
        $attribute->update($request->validated());
        return redirect()->route('admin.attributes.index')->with([
            'message' => __('attribute Updated successfully.'),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attribute $attribute)
    {
        $attribute->delete();
        return redirect()->route('admin.attributes.index')->with([
            'message' => __('attribute Deleted successfully.'),
            'alert-type' => 'success'
        ]);
    }
}
