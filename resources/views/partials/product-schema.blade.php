@php
    $productType = $type ?? 'package';
    $productName = $productType === 'package' ? ($product->name ?? '') : ($product->title ?? '');
    
    // Description builder (clean and without duplicate words)
    if ($productType === 'package') {
        $rawDesc = $product->content1 ?? $product->content2 ?? $product->name ?? '';
    } else {
        if (!empty($product->requirement)) {
            $rawDesc = $product->requirement;
        } else {
            $title = trim($product->title ?? '');
            $country = trim($product->country ?? 'Pakistan');
            if (stripos($title, 'tour') !== false || stripos($title, 'package') !== false) {
                $rawDesc = $title . ' to ' . $country;
            } else {
                $rawDesc = $title . ' Tour Package to ' . $country;
            }
        }
    }
    $description = str_limit(trim(preg_replace('/\s+/', ' ', strip_tags($rawDesc))), 160);

    // Image (Always a valid absolute URL, never empty)
    if (!empty($product->image)) {
        $imageUrl = url('storage/uploads/packages/' . $product->image);
    } elseif (!empty($product->agent->logo)) {
        $imageUrl = url('storage/uploads/agents/' . $product->agent->logo);
    } else {
        $imageUrl = asset('images/placeholder.jpg');
    }

    // SKU
    $skuPrefix = $productType === 'package' ? 'UMRAH-PKG-' : 'TOUR-PKG-';
    $sku = $skuPrefix . $product->id;

    // Brand / Agent
    $brandName = !empty($product->agent->business_name) ? trim($product->agent->business_name) : 'Agents.com.pk';

    // Build Product schema array
    $productData = [
        '@type' => 'Product',
        '@id' => request()->url() . ($productType === 'package' ? '#package' : '#tour-package'),
        'name' => $productName,
        'description' => $description,
        'image' => $imageUrl,
        'url' => request()->url(),
        'sku' => $sku,
        'brand' => [
            '@type' => 'Brand',
            'name' => $brandName,
        ],
    ];

    // Reviews & Aggregate Rating (ONLY approved reviews)
    $approvedReviews = (method_exists($product, 'approvedProductReviews') && \Illuminate\Support\Facades\Schema::hasTable('product_reviews'))
        ? $product->approvedProductReviews()->latest()->take(5)->get()
        : collect();
    $reviewCount = $approvedReviews->count();

    if ($reviewCount > 0) {
        $avgRating = round($product->approvedProductReviews()->avg('rating'), 1);
        $productData['aggregateRating'] = [
            '@type' => 'AggregateRating',
            'ratingValue' => number_format($avgRating > 0 ? $avgRating : 5.0, 1, '.', ''),
            'reviewCount' => (string) $reviewCount,
            'bestRating' => '5',
            'worstRating' => '1',
        ];

        $reviewItems = [];
        foreach ($approvedReviews as $rev) {
            $reviewItems[] = [
                '@type' => 'Review',
                'author' => [
                    '@type' => 'Person',
                    'name' => !empty($rev->name) ? trim($rev->name) : 'Customer',
                ],
                'datePublished' => \Carbon\Carbon::parse($rev->created_at)->setTimezone('Asia/Karachi')->toDateString(),
                'reviewRating' => [
                    '@type' => 'Rating',
                    'ratingValue' => (string) ($rev->rating ?? 5),
                    'bestRating' => '5',
                    'worstRating' => '1',
                ],
                'reviewBody' => str_limit(trim(preg_replace('/\s+/', ' ', strip_tags($rev->comment ?? ''))), 300),
            ];
        }
        $productData['review'] = $reviewItems;
    }

    // Pricing & Offers
    $startingPrice = $product->starting_price ?? null;
    if (!empty($startingPrice) && is_numeric($startingPrice) && (float) $startingPrice > 0) {
        $priceFloat = (float) $startingPrice;
        $validFromDate = $product->updated_at ?? $product->created_at ?? now();
        $validFromIso = \Carbon\Carbon::parse($validFromDate)->setTimezone('Asia/Karachi')->toIso8601String();
        $isAvailable = (!isset($product->active) || (int) $product->active === 1);

        $productData['offers'] = [
            '@type' => 'Offer',
            'url' => request()->url(),
            'priceCurrency' => 'PKR',
            'price' => number_format($priceFloat, 2, '.', ''),
            'priceValidUntil' => \Carbon\Carbon::now()->addYear()->format('Y-m-d'),
            'validFrom' => $validFromIso,
            'availability' => $isAvailable ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
            'itemCondition' => 'https://schema.org/NewCondition',
            'seller' => [
                '@type' => 'Organization',
                'name' => $brandName,
            ],
        ];
    }

    // BreadcrumbList
    $breadcrumbList = [
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'Home',
                'item' => url('/'),
            ],
            [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => ($productType === 'package' ? 'Umrah Packages' : 'Tour Packages'),
                'item' => ($productType === 'package' ? url('/cheap-umrah-packages') : url('/tour-packages')),
            ],
            [
                '@type' => 'ListItem',
                'position' => 3,
                'name' => $productName,
                'item' => request()->url(),
            ],
        ],
    ];

    $schemaGraph = [
        '@context' => 'https://schema.org',
        '@graph' => [
            $productData,
            $breadcrumbList,
        ],
    ];
@endphp
<script type="application/ld+json">
{!! json_encode($schemaGraph, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}
</script>
