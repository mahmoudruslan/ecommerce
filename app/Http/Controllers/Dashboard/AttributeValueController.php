<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\AttributeValueDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\AttributeValues\StoreAttributeValueRequest;
use App\Http\Requests\AttributeValues\UpdateAttributeValueRequest;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Support\Facades\DB;

class AttributeValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AttributeValueDataTable $dataTable)
    {
        $permissions = userAbility(['attribute-values','store-attribute-values', 'update-attribute-values', 'show-attribute-values','delete-attribute-values']);
        return $dataTable->with('permissions' , $permissions)->render('dashboard.attribute_values.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $attributes = Attribute::all();
        return view('dashboard.attribute_values.create',compact('attributes'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AttributeValues\StoreAttributeValueRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttributeValueRequest $request)
    {
        AttributeValue::create($request->validated());
        return redirect()->route('admin.attribute-values.index')->with([
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
    public function show(AttributeValue $attribute)
    {
        dd($attribute);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AttributeValue  $attributeValue
     * @return \Illuminate\Http\Response
     */
    public function edit(AttributeValue $attributeValue)
    {
        $attributes = Attribute::all();
        return view('dashboard.attribute_values.edit', compact('attributes','attributeValue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\AttributeValues\UpdateAttributeValueRequest  $request
     * @param  \App\Models\AttributeValue  $attributeValue
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttributeValueRequest $request, AttributeValue $attributeValue)
    {
        $attributeValue->update($request->validated());
        return redirect()->route('admin.attribute-values.index')->with([
            'message' => __('attribute Updated successfully.'),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AttributeValue  $attributeValue
     * @return \Illuminate\Http\Response
     */
    public function destroy(AttributeValue $attributeValue)
    {
        $attributeValue->delete();
        return redirect()->route('admin.attribute-values.index')->with([
            'message' => __('attribute Deleted successfully.'),
            'alert-type' => 'success'
        ]);
    }
    /**
     * Get attribute values by attribute id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getAttributeValues($id)
    {
        $attributeValues = AttributeValue::select(['id', DB::raw("value_" . app()->getLocale() . " as value")])
            ->where('attribute_id', $id)
            ->get();
        return response()->json([
            'attribute-values' => $attributeValues,
        ]);
    }
}
