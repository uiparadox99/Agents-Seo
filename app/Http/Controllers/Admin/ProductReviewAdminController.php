<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ProductReview;

class ProductReviewAdminController extends Controller
{
    /**
     * Display a listing of product reviews.
     */
    public function index(Request $request)
    {
        $query = ProductReview::query()->with(['package', 'tourPackage', 'user'])->latest();

        if ($request->has('status') && $request->status !== '') {
            if ($request->status === 'pending') {
                $query->where('approved', 0);
            } elseif ($request->status === 'approved') {
                $query->where('approved', 1);
            }
        }

        if ($request->has('product_type') && !empty($request->product_type)) {
            $query->where('product_type', $request->product_type);
        }

        $data['reviews'] = $query->paginate(25);
        $data['pendingCount'] = ProductReview::where('approved', 0)->count();
        $data['approvedCount'] = ProductReview::where('approved', 1)->count();
        $data['totalCount'] = ProductReview::count();

        return view('admin.product-reviews.index', $data);
    }

    /**
     * Toggle approved status (via AJAX or form POST).
     */
    public function toggleApprove(Request $request)
    {
        $id = $request->id;
        $review = ProductReview::find($id);

        if (!$review) {
            return response()->json(['notify' => false, 'msg' => 'Review not found'], 404);
        }

        if ($request->has('is_approved')) {
            $review->approved = (bool) $request->is_approved;
        } else {
            $review->approved = !$review->approved;
        }
        $review->save();

        if ($request->ajax()) {
            return response()->json([
                'notify' => true,
                'approved' => (int) $review->approved,
                'msg' => $review->approved ? 'Review approved successfully' : 'Review unapproved'
            ]);
        }

        return redirect()->back()->with('success', 'Review status updated');
    }

    /**
     * Delete a review.
     */
    public function destroy($id)
    {
        $review = ProductReview::find($id);
        if ($review) {
            $review->delete();
            return redirect()->back()->with('success', 'Review deleted successfully');
        }
        return redirect()->back()->with('error', 'Review not found');
    }
}
