<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\CouponDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Models\Coupon;
use App\Traits\Helper;
use Illuminate\Support\Facades\Crypt;

class CouponController extends Controller
{
    use Helper;
    public function index(CouponDataTable $dataTable)
    {
        // dd('index');
        $this->checkAbility(['coupons','store-coupons', 'update-coupons', 'show-coupons','delete-coupons']);
        return $dataTable->render('dashboard.coupons.index');
    }

    public function create()
    {
        // dd('create');
        $this->checkAbility(['store-coupons']);
        return view('dashboard.coupons.create');
    }

    public function store(CouponRequest $request)
    {
        try{
                $this->checkAbility(['store-coupons']);
              
                $coupon = Coupon::create([
                    'name_ar' => $request->name_ar,
                    'name_en' => $request->name_en,
                    'parent_id' => $request->parent_id ?? null,
                ]);
                return redirect()->route('admin.coupons.index')->with([
                        'message' => __('Item Created successfully.'),
                        'alert-type' => 'success']);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show($slug, $id)
    {
        // dd('show');
        try {
            $this->checkAbility(['show-coupons']);
            $coupon = Coupon::findOrFail(Crypt::decrypt($id));
            return view('dashboard.coupons.show', compact('coupon'));
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    public function edit( $slug, $id)
    {
        // dd('index');
        try {
            $this->checkAbility(['update-coupons']);
            $coupons = Coupon::where('parent_id', null)->get(['id', 'name_ar', 'name_en', 'image']);
            $coupon = Coupon::findOrFail(Crypt::decrypt($id));
            return view('dashboard.coupons.edit', compact('coupon', 'coupons'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(CouponRequest $request, $id)
    {
        // dd('update');
        try {
            $this->checkAbility(['update-coupons']);
            $coupon = Coupon::findOrFail(Crypt::decrypt($id));
            $file_name = $coupon->image;
            $path = '';
            if ($image = $request->file('image')) {
                $this->deleteFiles($file_name);
                $path = 'images/coupons/';
                $file_name = $this->saveImag($path, [$request->image]);
                $this->resizeImage(300, null, $path, $file_name, $image);
            }
            $coupon->update([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'image' =>  $path . $file_name,
                'parent_id' => $request->parent_id ?? null,
            ]);
            return redirect()->route('admin.coupons.index')->with([
                'message' => __('Item Updated successfully.'),
                'alert-type' => 'success']);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
}

    public function destroy( $id)
    {
        // dd('destroy');
        try {
            $this->checkAbility(['delete-coupons']);
            $coupon = Coupon::findOrFail(Crypt::decrypt($id));
            if(count($coupon->children) > 0){
                return redirect()->route('admin.coupons.index')->with([
                    'message' => __('This is coupon has subcoupons'),
                    'alert-type' => 'danger']);
            } else if(count($coupon->products) > 0){
                return redirect()->route('admin.coupons.index')->with([
                    'message' => __('This is coupon has products'),
                    'alert-type' => 'danger']);
            }

            $this->deleteFiles($coupon->image);
            $coupon->delete();
            return redirect()->route('admin.coupons.index')->with([
                'message' => __('Item Deleted successfully.'),
                'alert-type' => 'success']);


        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
}
