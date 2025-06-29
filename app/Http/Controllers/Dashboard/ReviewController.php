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

    public function show(Review $review)
    {
        try {
            userAbility(['show-reviews']);
            return view('dashboard.reviews.show', compact('review'));
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
    public function destroy(Review $review)
    {
        try {
            userAbility(['delete-reviews']);
            $review->delete();
            return redirect()->route('admin.reviews.index')->with([
                'message' => __('Item Deleted successfully.'),
                'alert-type' => 'success']);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}
