<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductReview;
use App\Packages;
use App\TourPackages;

class ProductReviewController extends Controller
{
    /**
     * Store a newly created product review.
     */
    public function store(Request $request)
    {
        // 1. Anti-spam honeypot check
        if (!empty($request->input('website_hp'))) {
            // Silently pretend success to fool bots
            return redirect()->back()->with('review_success', 'Thank you! Your review has been submitted and will appear after approval.');
        }

        // 2. Validate input
        $validated = $request->validate([
            'product_type' => 'required|in:package,tour',
            'product_id'   => 'required|integer',
            'name'         => 'required|string|max:100',
            'rating'       => 'required|integer|between:1,5',
            'comment'      => 'required|string|min:10|max:1000',
        ]);

        // 3. Verify product exists
        if ($validated['product_type'] === 'package') {
            $exists = Packages::where('id', $validated['product_id'])->exists();
        } else {
            $exists = TourPackages::where('id', $validated['product_id'])->exists();
        }

        if (!$exists) {
            return redirect()->back()->withErrors(['product_id' => 'The selected package was not found.']);
        }

        // 4. Sanitize strings (strip tags)
        $cleanName = trim(strip_tags($validated['name']));
        $cleanComment = trim(strip_tags($validated['comment']));

        // 5. Create review with approved = 0
        ProductReview::create([
            'product_type' => $validated['product_type'],
            'product_id'   => $validated['product_id'],
            'user_id'      => auth()->check() ? auth()->id() : null,
            'name'         => $cleanName,
            'rating'       => (int) $validated['rating'],
            'comment'      => $cleanComment,
            'approved'     => 0,
        ]);

        return redirect()->to(url()->previous() . '#package-reviews')
            ->with('review_success', 'Thank you! Your review has been submitted and will appear once approved by our moderation team.');
    }
}
