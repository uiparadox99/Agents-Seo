@php
    $productType = $type ?? 'package';
    $approvedReviews = (method_exists($product, 'approvedProductReviews') && \Illuminate\Support\Facades\Schema::hasTable('product_reviews'))
        ? $product->approvedProductReviews()->latest()->get()
        : collect();
    $totalApproved = $approvedReviews->count();
    $avgRating = $totalApproved > 0 ? round($approvedReviews->avg('rating'), 1) : 0;
@endphp

<div class="product-reviews-section mt-5 mb-4" id="package-reviews">
    <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1 font-weight-bold" style="color: #090d3a;">Customer Reviews</h4>
                <div class="d-flex align-items-center">
                    @if($totalApproved > 0)
                        <span class="text-warning mr-2" style="font-size: 1.1rem;">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa fa-star{{ $i <= round($avgRating) ? '' : '-o' }}"></i>
                            @endfor
                        </span>
                        <span class="font-weight-bold mr-1">{{ $avgRating }}</span>
                        <span class="text-muted">({{ $totalApproved }} {{ $totalApproved == 1 ? 'review' : 'reviews' }})</span>
                    @else
                        <span class="text-muted">No reviews yet</span>
                    @endif
                </div>
            </div>
            <a href="#write-review-card" class="btn btn-sm btn-outline-primary" style="border-radius: 20px;">
                <i class="fa fa-pencil mr-1"></i> Write a Review
            </a>
        </div>

        <div class="card-body">
            @if(session('review_success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa fa-check-circle mr-2"></i> {{ session('review_success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(isset($errors) && $errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0 pl-3">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- List of approved reviews -->
            @if($totalApproved > 0)
                <div class="reviews-list mb-4">
                    @foreach($approvedReviews as $review)
                        <div class="review-item border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div>
                                    <strong class="text-dark">{{ $review->name }}</strong>
                                    <span class="badge badge-light border ml-2 text-success">
                                        <i class="fa fa-check-circle text-success"></i> Verified
                                    </span>
                                </div>
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($review->created_at)->setTimezone('Asia/Karachi')->format('d M, Y') }}
                                </small>
                            </div>
                            <div class="text-warning mb-2" style="font-size: 0.9rem;">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa fa-star{{ $i <= (int)$review->rating ? '' : '-o' }}"></i>
                                @endfor
                            </div>
                            <p class="mb-0 text-secondary" style="line-height: 1.6;">
                                {{ $review->comment }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-4 text-muted">
                    <p class="mb-1"><i class="fa fa-commenting-o fa-2x"></i></p>
                    <p class="mb-0">There are no reviews yet for this package. Have you booked or traveled with this package? Share your experience!</p>
                </div>
            @endif

            <!-- Write a Review Form -->
            <div class="card bg-light border-0 mt-3" id="write-review-card" style="border-radius: 10px;">
                <div class="card-body p-4">
                    <h5 class="card-title font-weight-bold mb-3" style="color: #090d3a;">Leave Your Review</h5>
                    <form action="{{ route('product.reviews.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_type" value="{{ $productType }}">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <!-- Honeypot anti-spam field -->
                        <div style="display:none;" aria-hidden="true">
                            <input type="text" name="website_hp" tabindex="-1" autocomplete="off">
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="reviewer_name" class="font-weight-semibold">Your Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="reviewer_name" name="name" 
                                    value="{{ old('name', auth()->check() ? auth()->user()->name : '') }}" 
                                    maxlength="100" required placeholder="e.g. Muhammad Ali">
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="rating_val" class="font-weight-semibold">Rating <span class="text-danger">*</span></label>
                                <select class="form-control" id="rating_val" name="rating" required>
                                    <option value="5" {{ old('rating', '5') == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ 5 - Excellent</option>
                                    <option value="4" {{ old('rating') == '4' ? 'selected' : '' }}>⭐⭐⭐⭐ 4 - Very Good</option>
                                    <option value="3" {{ old('rating') == '3' ? 'selected' : '' }}>⭐⭐⭐ 3 - Good</option>
                                    <option value="2" {{ old('rating') == '2' ? 'selected' : '' }}>⭐⭐ 2 - Fair</option>
                                    <option value="1" {{ old('rating') == '1' ? 'selected' : '' }}>⭐ 1 - Poor</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="review_comment" class="font-weight-semibold">Your Review / Experience <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="review_comment" name="comment" rows="4" 
                                minlength="10" maxlength="1000" required 
                                placeholder="Describe your experience with hotel accommodations, transport, ticketing, and agent service (min 10 characters)...">{{ old('comment') }}</textarea>
                            <small class="form-text text-muted">Minimum 10 characters, maximum 1000 characters.</small>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted"><i class="fa fa-info-circle mr-1"></i> Reviews are verified by moderators before being published.</small>
                            <button type="submit" class="btn btn-primary px-4 font-weight-bold" style="background-color: #090d3a; border-color: #090d3a;">
                                Submit Review
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
