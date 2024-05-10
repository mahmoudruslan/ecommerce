<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\CouponDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Models\Coupon;
use Illuminate\Support\Facades\Crypt;

class CouponController extends Controller
{
    public function index(CouponDataTable $dataTable)
    {
        $permissions = userAbility(['coupons','store-coupons', 'update-coupons', 'show-coupons','delete-coupons']);
        return $dataTable->with('permissions' , $permissions)->render('dashboard.coupons.index');
    }

    public function create()
    {
        userAbility(['store-coupons']);
        return view('dashboard.coupons.create');
    }

    public function store(CouponRequest $request)
    {
        try{
                userAbility(['store-coupons']);
                Coupon::create($request->validated());

                return redirect()->route('admin.coupons.index')->with([
                        'message' => __('Item Created successfully.'),
                        'alert-type' => 'success']);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show($id)
    {
        // dd('show');
        try {
            userAbility(['show-coupons']);
            $coupon = Coupon::findOrFail(Crypt::decrypt($id));
            return view('dashboard.coupons.show', compact('coupon'));
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    public function edit($id)
    {
        try {
            userAbility(['update-coupons']);
            $coupon = Coupon::findOrFail(Crypt::decrypt($id));
            return view('dashboard.coupons.edit', compact('coupon'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(CouponRequest $request, $id)
    {
        try {
            userAbility(['update-coupons']);
            $coupon = Coupon::findOrFail(Crypt::decrypt($id));
            if(!$request->status){$coupon->status= 0;$coupon->save();}

            $coupon->update($request->validated());
            return redirect()->route('admin.coupons.index')->with([
                'message' => __('Item Updated successfully.'),
                'alert-type' => 'success']);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
}

    public function destroy( $id)
    {
        try {
            userAbility(['delete-coupons']);
            $coupon = Coupon::findOrFail(Crypt::decrypt($id));
            $coupon->delete();
            return redirect()->route('admin.coupons.index')->with([
                'message' => __('Item Deleted successfully.'),
                'alert-type' => 'success']);


        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
}
