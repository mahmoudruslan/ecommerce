<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\ReviewDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use Illuminate\Support\Facades\Crypt;

class ReviewController extends Controller
{
    public function index(ReviewDataTable $dataTable)
    {
        $permissions = userAbility(['reviews','store-reviews', 'update-reviews', 'show-reviews','delete-reviews']);
        return $dataTable->with('permissions' , $permissions)->render('dashboard.reviews.index');
    }

    public function show($id)
    {
        try {
            userAbility(['show-reviews']);
            $review = Review::findOrFail(Crypt::decrypt($id));
            return view('dashboard.reviews.show', compact('review'));
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }


    public function destroy( $id)
    {
        try {
            userAbility(['delete-reviews']);
            $review = Review::findOrFail(Crypt::decrypt($id));
            $review->delete();
            return redirect()->route('admin.reviews.index')->with([
                'message' => __('Item Deleted successfully.'),
                'alert-type' => 'success']);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}
