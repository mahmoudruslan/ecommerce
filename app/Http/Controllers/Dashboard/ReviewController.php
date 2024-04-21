<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\ReviewDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use App\Traits\Helper;
use Illuminate\Support\Facades\Crypt;

class ReviewController extends Controller
{
    use Helper;
    public function index(ReviewDataTable $dataTable)
    {
        $this->checkAbility(['reviews','store-reviews', 'update-reviews', 'show-reviews','delete-reviews']);
        return $dataTable->render('dashboard.reviews.index');
    }

    public function show($id)
    {
        try {
            $this->checkAbility(['show-reviews']);
            $review = Review::findOrFail(Crypt::decrypt($id));
            return view('dashboard.reviews.show', compact('review'));
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }


    public function destroy( $id)
    {
        try {
            $this->checkAbility(['delete-reviews']);
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
