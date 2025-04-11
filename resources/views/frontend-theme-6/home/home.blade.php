@extends('frontend.layouts.app')
@section('meta')
    @php
        $metaData = getMeta('home');
    @endphp

    <meta name="description" content="{{ __($metaData['meta_description']) }}">
    <meta name="keywords" content="{{ __($metaData['meta_keyword']) }}">

    <!-- Open Graph meta tags for social sharing -->
    <meta property="og:type" content="Learning">
    <meta property="og:title" content="{{ __($metaData['meta_title']) }}">
    <meta property="og:description" content="{{ __($metaData['meta_description']) }}">
    <meta property="og:image" content="{{ __($metaData['og_image']) }}">
    <meta property="og:url" content="{{ url()->current() }}">

    <meta property="og:site_name" content="{{ __(get_option('app_name')) }}">

    <!-- Twitter Card meta tags for Twitter sharing -->
    <meta name="twitter:card" content="Learning">
    <meta name="twitter:title" content="{{ __($metaData['meta_title']) }}">
    <meta name="twitter:description" content="{{ __($metaData['meta_description']) }}">
    <meta name="twitter:image" content="{{ __($metaData['og_image']) }}">
    @if (isAddonInstalled('LMSZAIPRODUCT'))
        <link rel="stylesheet" href="{{ asset('addon/product/css/ecommerce-product.css') }}">
    @endif
@endsection

@push('theme-style')
    <!-- page css -->
    <link rel="stylesheet" href="{{ asset('frontend-theme-4/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend-theme-4/assets/css/plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend-theme-4/assets/scss/style.css') }}">
@endpush

@section('content')

    @php
        $bannerImage = @$home->banner_image;
        if(env('IS_LOCAL', 0)){
            $bannerImage = get_option('banner_image_'.get_option('theme', THEME_DEFAULT));
        }
    @endphp
        <!-- Hero Banner -->
    <section class="hero-banner hero-banner-meditation bg-lan-bg">
        <div class="container">
            <div class="hero-banner-content">
                <div class="text-content">
                    <div class="sub-title-wrap">
                        @foreach(@$home->banner_mini_words_title ?? [] as $banner_mini_word)
                            <p>{{ __($banner_mini_word) }}</p>
                        @endforeach
                    </div>
                    <div class="titleText-wrap">
                        <h4 class="title">
                            {{ __(@$home->banner_first_line_title) }}
                            <span>{{ __(@$home->banner_second_line_title) }}</span>
                            {{ __(@$home->banner_third_line_title) }}
                            <span>{{ __(@$home->banner_fourth_line_title) }}</span>
                        </h4>
                        <p class="text">{{ __(@$home->banner_subtitle) }}</p>
                    </div>
                    <div class="d-flex justify-content-center align-items-center g-12 pt-7">
                        <a href="{{ $home->banner_first_button_link }}"
                           class="hero-btn-1">{{ __($home->banner_first_button_name) }} <i
                                class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="video-content">
                    <img src="{{ getImageFile($bannerImage) }}" alt="">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#newVideoPlayerModal"
                            class="videoPlay-btn">
                        <img src="{{asset('frontend-theme-4/assets/images/meditation-video-btn.svg')}}" alt="">
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Features -->
    <section class="core-features core-features-meditation {{ @$home->special_feature_area == 1 ? '' : 'd-none' }}">
        <div class="container">
            <div class="core-features-content">
                <!--  -->
                <div class="title-wrap">
                    <div class="row rg-20 justify-content-lg-between justify-content-center">
                        <div class="col-lg-5">
                            <h4 class="title">{{ __(get_option('home_special_feature_title')) }}</h4>
                        </div>
                        <div class="col-lg-4">
                            <div class="d-flex flex-column justify-content-end h-100">
                                <p class="text">{{ __(get_option('home_special_feature_area_subtitle')) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  -->
                <div class="row rg-20">
                    <div class="col-lg-4 col-sm-6">
                        <div class="core-features-item core-features-item-meditation">
                            <div class="icon">
                                <img src="{{ getImageFile(get_option('home_special_feature_first_logo')) }}" alt=""/>
                            </div>
                            <div class="content">
                                <h4 class="title">{{ __(get_option('home_special_feature_first_title')) }}</h4>
                                <p class="text">{{ __(get_option('home_special_feature_first_subtitle')) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="core-features-item core-features-item-meditation">
                            <div class="icon">
                                <img src="{{ getImageFile(get_option('home_special_feature_second_logo')) }}" alt=""/>
                            </div>
                            <div class="content">
                                <h4 class="title">{{ __(get_option('home_special_feature_second_title')) }}</h4>
                                <p class="text">{{ __(get_option('home_special_feature_second_subtitle')) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="core-features-item core-features-item-meditation">
                            <div class="icon">
                                <img src="{{ getImageFile(get_option('home_special_feature_third_logo')) }}" alt=""/>
                            </div>
                            <div class="content">
                                <h4 class="title">{{ __(get_option('home_special_feature_third_title')) }}</h4>
                                <p class="text">{{ __(get_option('home_special_feature_third_subtitle')) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if(!get_option('private_mode') || !auth()->guest())
        @if($home->courses_area == 1)
            <!-- Board Section -->
            <section class="board-section board-section-meditation bg-meditation-primary">
                <div class="container">
                    <div class="board-section-content">
                        <!--  -->
                        <div class="title-wrap">
                            <div class="row justify-content-between align-items-center rg-20">
                                <div class="col-lg-8">
                                    <div class="d-flex flex-column flex-sm-row align-items-lg-center align-items-sm-start align-items-center g-26">
                                        <div class="icon d-flex max-w-60 flex-shrink-0">
                                            <img src="{{ getImageFile(get_option('course_logo')) }}" alt="Course"/>
                                        </div>
                                        <div class="content">
                                            <h4 class="title text-center text-sm-start">{{ __(get_option('course_title')) }}</h4>
                                            <p class="text text-center text-sm-start">{{ __(get_option('course_subtitle')) }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="d-flex justify-content-lg-end justify-content-sm-start justify-content-center">
                                        <a href="{{ route('courses') }}"
                                           class="btn-outline-meditation-white">{{__('View All')}} <i
                                                class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  -->
                        <div class="row rg-20">
                            @if(count($featuredCourses))
                                @foreach ($featuredCourses->take(6) as $key =>$course)
                                    @php
                                        $userRelation = getUserRoleRelation($course->user);
                                         // Calculate class dynamically based on index
                                        $position = $key + 1; // Convert 0-based index to 1-based
                                        if ($position % 9 == 2 || $position % 9 == 5 || $position % 9 == 7) {
                                            $courseClass = 'course-item-five-blue';
                                        } elseif ($position % 9 == 3 || $position % 9 == 6 || $position % 9 == 9) {
                                            $courseClass = 'course-item-five-yellow';
                                        } else {
                                            $courseClass = ''; // Default class for other positions
                                        }
                                    @endphp
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="course-item-five {{ $courseClass }}"
                                             data-background="{{getImageFile($course->image_path)}}">
                                            <div class="priceWrap">
                                        <span class="priceContent">
                                            {{__('PRICE')}}:
                                        @if($course->learner_accessibility == 'paid')
                                                    <?php
                                                    $startDate = date('d-m-Y H:i:s', strtotime(@$course->promotionCourse->promotion->start_date));
                                                    $endDate = date('d-m-Y H:i:s', strtotime(@$course->promotionCourse->promotion->end_date));
                                                    $percentage = @$course->promotionCourse->promotion->percentage;
                                                    $discount_price = number_format($course->price - (($course->price * $percentage) / 100), 2);
                                                    ?>

                                                @if(now()->gt($startDate) && now()->lt($endDate))
                                                    <span class="regularPrice">
                                                    @if($currencyPlacement ?? get_currency_placement() == 'after')
                                                            {{ $discount_price }} {{ $currencySymbol ?? get_currency_symbol() }}
                                                        @else
                                                            {{ $currencySymbol ?? get_currency_symbol() }} {{ $discount_price }}
                                                        @endif
                                                </span>
                                                    <span class="discountPrice">
                                                @if($currencyPlacement ?? get_currency_placement() == 'after')
                                                            {{ $course->price }} {{ $currencySymbol ?? get_currency_symbol() }}
                                                        @else
                                                            {{ $currencySymbol ?? get_currency_symbol() }} {{ $course->price }}
                                                        @endif
                                                </span>
                                                @elseif ($course->price <= $course->old_price)
                                                    <span class="regularPrice">
                                                @if($currencyPlacement ?? get_currency_placement() == 'after')
                                                            {{ $course->old_price }} {{ $currencySymbol ?? get_currency_symbol() }}
                                                        @else
                                                            {{ $currencySymbol ?? get_currency_symbol() }} {{ $course->old_price }}
                                                        @endif
                                                </span>
                                                    <span class="discountPrice">
                                                @if($currencyPlacement ?? get_currency_placement() == 'after')
                                                            {{ $course->price }} {{ $currencySymbol ?? get_currency_symbol() }}
                                                        @else
                                                            {{ $currencySymbol ?? get_currency_symbol() }} {{ $course->price }}
                                                        @endif
                                                </span>
                                                @else
                                                    <span class="discountPrice">
                                                    @if($currencyPlacement ?? get_currency_placement() == 'after')
                                                            {{ $course->price }} {{ $currencySymbol ?? get_currency_symbol() }}
                                                        @else
                                                            {{ $currencySymbol ?? get_currency_symbol() }} {{ $course->price }}
                                                        @endif
                                                </span>
                                                @endif
                                            @elseif($course->learner_accessibility == 'free')
                                                <span class="discountPrice">
                                                {{ __('Free') }}
                                            </span>
                                                @endif
                                            </div>
                                            <div class="content">
                                                <p class="degi">
                                                    {{__('BY')}} :

                                                    <a href="{{ route('userProfile',$course->user->id) }}">{{ $course->$userRelation->name }}</a>
                                                </p>
                                                <a href="{{ route('course-details', $course->slug) }}"
                                                   class="titleLink">
                                                    <h4 class="title">{{ Str::limit($course->title, 40)}}</h4>
                                                    <div class="link">
                                                        <i class="fa fa-arrow-right"></i>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                {{ __("No Course Found") }}
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif

    @if($home->bundle_area == 1)
        @if(count($bundles) > 0)
            <!-- Latest Bundle Section -->
            <section class="latest-bundle latest-bundle-meditation bg-lan-bg">
                <div class="container">
                    <div class="latest-bundle-content">
                        <!--  -->
                        <div class="title-wrap">
                            <div class="row justify-content-between align-items-center rg-20">
                                <div class="col-lg-8">
                                    <div class="d-flex flex-column flex-sm-row align-items-lg-center align-items-sm-start align-items-center g-26">
                                        <div class="icon d-flex max-w-60 flex-shrink-0">
                                            <img src="{{ getImageFile(get_option('bundle_course_logo')) }}" alt=""/>
                                        </div>
                                        <div class="content">
                                            <h4 class="title text-center text-sm-start">{{ __(get_option('bundle_course_title')) }}</h4>
                                            <p class="text text-center text-sm-start">{{ __(get_option('bundle_course_subtitle')) }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="d-flex justify-content-lg-end justify-content-sm-start justify-content-center">
                                        <a href="{{ route('bundles') }}"
                                           class="btn-outline-meditation">{{ __('View All') }} <i
                                                class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  -->
                        <div class="row rg-20">
                            @foreach($bundles->take(4) as $key => $bundle)
                                @php
                                    $relation = getUserRoleRelation($bundle->user);
                                     // Calculate class dynamically based on index
                                    $position = $key + 1; // Convert 0-based index to 1-based
                                    if ($position % 9 == 2 || $position % 9 == 5 || $position % 9 == 7) {
                                        $courseClass = 'course-item-five-blue';
                                    } elseif ($position % 9 == 3 || $position % 9 == 6 || $position % 9 == 9) {
                                        $courseClass = 'course-item-five-yellow';
                                    } else {
                                        $courseClass = ''; // Default class for other positions
                                    }
                                @endphp
                                <div class="col-xl-3 col-lg-4 col-sm-6">
                                    <div class="course-item-five {{$courseClass}}"
                                         data-background="{{ getImageFile($bundle->image) }}">
                                        <div class="priceWrap">
                                            <p class="priceContent">
                                                {{__('PRICE')}}:
                                                <span class="discountPrice">
                                         @if($currencyPlacement == 'after')
                                                        {{$bundle->price}} {{ $currencySymbol }}
                                                    @else
                                                        {{ $currencySymbol }} {{$bundle->price}}
                                                    @endif
                                    </span>
                                            </p>
                                        </div>
                                        <div class="content">
                                            <a href="{{ route('bundle-details', [$bundle->slug]) }}" class="link"><i
                                                    class="fa fa-arrow-right"></i></a>
                                            <p class="degi">
                                                {{__('BY')}} :
                                                <span>
                                        <a href="{{ route('userProfile',$bundle->user->id) }}">{{ @$bundle->user->$relation->name }}</a>
                                    </span>
                                            </p>
                                            <a href="{{ route('bundle-details', [$bundle->slug]) }}" class="titleLink">
                                                <h4 class="title">{{ Str::limit($bundle->name, 40) }}</h4>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif

    @if($home->category_courses_area == 1)
        <!-- Top categories -->
        <section class="top-categories top-categories-meditation bg-lan-bg p-0">
            <div class="container">
                <div class="top-categories-content">
                    <!--  -->
                    <div class="title-wrap">
                        <h4 class="title">{{ __(get_option('category_course_title')) }}</h4>
                        <p class="text">{{ __(get_option('category_course_subtitle')) }}</p>
                    </div>
                    <!--  -->
                    <div class="row rg-24">
                        @foreach($featureCategories->take(8) as $key => $category)
                            <div class="col-xl-3 col-lg-4 col-sm-6">
                                <a href="{{ route('category-courses', $category->slug) }}">
                                    <div class="top-categories-item top-categories-item-lan">
                                        <div class="icon">
                                            <img src="{{getImageFile($category->image)}}" alt=""/>
                                        </div>
                                        <div class="content">
                                            <h4 class="title">{{ __($category->name) }}</h4>
                                            <p class="text">{{__('OVER')}} {{$category->courses->count()}}
                                                + {{__('COURSE')}}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="pt-sm-41 pt-20 d-flex justify-content-center">
                        <a href="#" class="btn-fill-meditation">{{__('All Categories')}}<i
                                class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if($home->upcoming_courses_area == 1)
        <!-- Upcoming course Section -->
        <section class="upcoming-course upcoming-course-meditation bg-lan-bg">
            <div class="container">
                <div class="upcoming-course-content">
                    <!--  -->
                    <div class="title-wrap">
                        <div class="row justify-content-between align-items-center rg-20">
                            <div class="col-lg-8">
                                <div class="d-flex flex-column flex-sm-row align-items-lg-center align-items-sm-start align-items-center g-26">
                                    <div class="icon d-flex max-w-60 flex-shrink-0"><img
                                            src="{{ getImageFile(get_option('upcoming_course_logo')) }}" alt=""/>
                                    </div>
                                    <div class="content">
                                        <h4 class="title text-center text-sm-start">{{ __(get_option('upcoming_course_title')) }}</h4>
                                        <p class="text text-center text-sm-start">{{ __(get_option('upcoming_course_title')) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="d-flex justify-content-lg-end justify-content-sm-start justify-content-center">
                                    <a href="{{ route('courses') }}" class="btn-outline-meditation">{{__('View All')}}
                                        <i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row rg-20">
                        @if(count($upcomingCourses))
                            @foreach ($upcomingCourses->take(3) as $key => $course)
                                @php
                                    $userRelation = getUserRoleRelation($course->user);
                                    // Calculate class dynamically based on index
                                   $position = $key + 1; // Convert 0-based index to 1-based
                                   if ($position % 9 == 2 || $position % 9 == 5 || $position % 9 == 7) {
                                       $courseClass = 'course-item-five-blue';
                                   } elseif ($position % 9 == 3 || $position % 9 == 6 || $position % 9 == 9) {
                                       $courseClass = 'course-item-five-yellow';
                                   } else {
                                       $courseClass = ''; // Default class for other positions
                                   }
                                @endphp
                                <div class="col-lg-4 col-sm-6">
                                    <div class="course-item-five {{$courseClass}}"
                                         data-background="{{getImageFile($course->image_path)}}">
                                        <div class="priceWrap">
                                            <span class="upcoming">{{__('Upcoming')}}</span>
                                            <span class="priceContent">
                                    {{__('PRICE')}}:
                                @if($course->learner_accessibility == 'paid')
                                                        <?php
                                                        $startDate = date('d-m-Y H:i:s', strtotime(@$course->promotionCourse->promotion->start_date));
                                                        $endDate = date('d-m-Y H:i:s', strtotime(@$course->promotionCourse->promotion->end_date));
                                                        $percentage = @$course->promotionCourse->promotion->percentage;
                                                        $discount_price = number_format($course->price - (($course->price * $percentage) / 100), 2);
                                                        ?>

                                                    @if(now()->gt($startDate) && now()->lt($endDate))
                                                        <span class="regularPrice">
                                            @if($currencyPlacement ?? get_currency_placement() == 'after')
                                                                {{ $discount_price }} {{ $currencySymbol ?? get_currency_symbol() }}
                                                            @else
                                                                {{ $currencySymbol ?? get_currency_symbol() }} {{ $discount_price }}
                                                            @endif
                                        </span>
                                                        <span class="discountPrice">
                                        @if($currencyPlacement ?? get_currency_placement() == 'after')
                                                                {{ $course->price }} {{ $currencySymbol ?? get_currency_symbol() }}
                                                            @else
                                                                {{ $currencySymbol ?? get_currency_symbol() }} {{ $course->price }}
                                                            @endif
                                        </span>
                                                    @elseif ($course->price <= $course->old_price)
                                                        <span class="regularPrice">
                                        @if($currencyPlacement ?? get_currency_placement() == 'after')
                                                                {{ $course->old_price }} {{ $currencySymbol ?? get_currency_symbol() }}
                                                            @else
                                                                {{ $currencySymbol ?? get_currency_symbol() }} {{ $course->old_price }}
                                                            @endif
                                        </span>
                                                        <span class="discountPrice">
                                        @if($currencyPlacement ?? get_currency_placement() == 'after')
                                                                {{ $course->price }} {{ $currencySymbol ?? get_currency_symbol() }}
                                                            @else
                                                                {{ $currencySymbol ?? get_currency_symbol() }} {{ $course->price }}
                                                            @endif
                                        </span>
                                                    @else
                                                        <span class="discountPrice">
                                            @if($currencyPlacement ?? get_currency_placement() == 'after')
                                                                {{ $course->price }} {{ $currencySymbol ?? get_currency_symbol() }}
                                                            @else
                                                                {{ $currencySymbol ?? get_currency_symbol() }} {{ $course->price }}
                                                            @endif
                                        </span>
                                                    @endif
                                                @elseif($course->learner_accessibility == 'free')
                                                    <span class="discountPrice">
                                        {{ __('Free') }}
                                    </span>
                                            @endif
                                        </div>
                                        <div class="content">
                                            <p class="degi">
                                                {{__('BY')}} :
                                                <span>
                                        <a href="{{ route('userProfile',$course->user->id) }}">{{ $course->$userRelation->name }}</a>
                                    </span>
                                            </p>
                                            <a href="{{ route('course-details', $course->slug) }}"
                                               class="titleLink">
                                                <h4 class="title">{{ Str::limit($course->title, 40)}}</h4>
                                                <div class="link">
                                                    <i class="fa fa-arrow-right"></i>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            {{ __("No Course Found") }}
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if(isAddonInstalled('LMSZAIPRODUCT'))
        @if($home->product_area == 1)
            <!-- Product Varity -->
            <section class="product-varity product-varity-meditation">
                <div class="container">
                    <div class="product-varity-content">
                        <!--  -->
                        <div class="title-wrap">
                            <h4 class="title">{{ __(get_option('product_section_title')) }}
                                @if(env('LOGIN_HELP') == 'active')
                                    <span class="color-deep-orange font-18">(Addon)</span>
                                @endif
                            </h4>
                            <p class="text">{{ __(get_option('product_section_subtitle')) }}</p>
                        </div>
                        <!--  -->
                        <div class="row rg-24 pb-27">
                            @foreach($products->take(6) as $product)
                                @php
                                    $relation = getUserRoleRelation($product->user)
                                @endphp
                                <div class="col-lg-4 col-md-6">
                                    <div class="course-item-meditation">
                                        <div class="course-item-two">
                                            <div class="img">
                                                <img src="{{getImageFile($product->thumbnail_path)}}"
                                                     alt="{{$product->title}}"/>
                                            </div>
                                            <div class="content">
                                                <a class="title"
                                                   href="{{ route('lms_product.frontend.view', $product->slug) }}">{{$product->title}}</a>
                                                @php
                                                    $reviewCount = $product->reviews()->count();
                                                    $averate_percent = $product->average_review * 20;
                                                @endphp
                                                <div class="rating-wrap">
                                                    <span>{{ number_format(@$product->average_review, 1) }}</span>
                                                    <div class="rating-part-star">
                                                        <div
                                                            class="course-rating search-instructor-rating w-100 mb-0 d-inline-flex align-items-center justify-content-center">
                                                            <div class="star-ratings">
                                                                <div class="fill-ratings"
                                                                     style="width: {{ $averate_percent }}%">
                                                                    <span>★★★★★</span>
                                                                </div>
                                                                <div class="empty-ratings">
                                                                    <span>★★★★★</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <span class="num-total">({{ $reviewCount }})</span>
                                                </div>
                                                <p class="price">{{__('Price')}}:
                                                    @if($product->old_price > $product->current_price)
                                                        <span class="regularPrice">
                                                            @if($currencyPlacement ?? get_currency_placement() == 'after')
                                                                {{ $product->old_price }} {{ $currencySymbol ?? get_currency_symbol() }}
                                                            @else
                                                                {{ $currencySymbol ?? get_currency_symbol() }} {{ $product->old_price }}
                                                            @endif
                                                        </span>
                                                        <span class="discountPrice">
                                                            @if($currencyPlacement ?? get_currency_placement() == 'after')
                                                                {{ $product->current_price }} {{ $currencySymbol ?? get_currency_symbol() }}
                                                            @else
                                                                {{ $currencySymbol ?? get_currency_symbol() }} {{ $product->current_price }}
                                                            @endif
                                                        </span>
                                                    @else
                                                        <span class="regularPrice">
                                                            @if($currencyPlacement ?? get_currency_placement() == 'after')
                                                                {{ $product->current_price }} {{ $currencySymbol ?? get_currency_symbol() }}
                                                            @else
                                                                {{ $currencySymbol ?? get_currency_symbol() }} {{ $product->current_price }}
                                                            @endif
                                                        </span>
                                                    @endif
                                                </p>
                                                @if($product->quantity > 0)
                                                    <button class="btn-fill-meditation addToCart"
                                                            data-product_id="{{ $product->id }}" data-quantity=1
                                                            data-route="{{ route('student.addToCart') }}">{{ __('Add To Cart') }}
                                                        <i class="fa fa-arrow-right"></i></button>
                                                @else
                                                    <button class="btn-fill-meditation">{{ __('Out of stock') }} <i
                                                            class="fa fa-arrow-right"></i></button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!--  -->
                        <div class="d-flex justify-content-center pt-27">
                            <button class="btn-outline-meditation-white">View All Product <i
                                    class="fa fa-arrow-right"></i></button>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif

    @if($home->instructor_area == 1)
        <!-- instructor Section -->
        <section class="top-rated-course top-rated-course-meditation bg-white">
            <div class="container">
                <div class="top-rated-course-content">
                    <!--  -->
                    <div class="title-wrap">
                        <div class="row justify-content-between align-items-end rg-20">
                            <div class="col-lg-8">
                                <div class="d-flex flex-column flex-sm-row align-items-lg-center align-items-sm-start align-items-center g-26">
                                    <div class="content">
                                        <h4 class="title text-center text-sm-start">{{ __(get_option('top_instructor_title')) }}</h4>
                                        <p class="text text-center text-sm-start">{{ __(get_option('top_instructor_subtitle')) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-4">
                                <div class="d-flex justify-content-lg-end justify-content-sm-start justify-content-center">
                                    <a href="{{ route('instructor') }}"
                                       class="btn-outline-meditation">{{__('View All Instructor')}} <i
                                            class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--  -->
                    <div class="row rg-20">
                        @foreach ($instructors->take(4) as $user)
                            <div class="col-xl-3 col-lg-4 col-sm-6">
                                <div class="instructor-item-two">
                                    <a href="{{ route('userProfile', $user->id) }}" class="img">
                                        @php
                                            $percent = $user->hourly_rate && $user->hourly_old_rate ? (($user->hourly_old_rate -
                                            $user->hourly_rate) * 100) / $user->hourly_old_rate : 0;
                                        @endphp
                                        @if ($percent && $user->consultation_available == 1)
                                            <span
                                                class="instructor-price-cutoff badge radius-3 font-12 font-medium position-absolute bg-orange">{{round(@$percent) }} {{ __('off') }}</span>
                                        @endif
                                        <img src="{{getImageFile(@$user->image_path)}}" alt=""/>
                                    </a>
                                    <div class="content">

                                        <a class="name" href="{{ route('userProfile', $user->id) }}"
                                           class="title">{{$user->name }}</a>

                                        <p class="degi">{{ @$user->professional_title }}</p>
                                        <div class="d-flex align-items-center cg-23 rg-10 flex-wrap rating">
                                            <!-- Rating -->
                                            <div class="d-flex align-items-center g-5">
                                                <div class="icon d-flex">
                                                    <img src="{{asset('frontend-theme-4/assets/images/star-full.svg')}}"
                                                         alt=""/>
                                                </div>
                                                <p class="fs-14 fw-500 lh-15">{{ number_format(@$average_rating, 1) }}</p>
                                            </div>
                                            <!--  -->
                                            <p class="fs-14 fw-500 lh-15">{{@$user->enrollment_students_count}} {{__('students')}}</p>
                                            <!--  -->
                                            <p class="fs-14 fw-500 lh-15">{{@$user->courses->count()}} {{__('courses')}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Subscription Start -->
    @if (@$home->subscription_show == 1 && get_option('subscription_mode'))
        <div class="price-area price-plan-meditation bg-lan-bg overflow-hidden">
            <div class="container">
                <div class="price-plan-content">
                    <!--  -->
                    <div class="title-wrap">
                        <h4 class="title">Saas Plan</h4>
                        <p class="text">#CHOOSE A SAAS PLAN AND SAVE MONEY!</p>
                    </div>
                </div>

                <div class="row">
                    <div class="nav nav-pills justify-content-center align-items-center price-plan-meditation-nav"
                         id="pills-tab" role="tablist">
                        <span class="plan-switch-month-year-text mx-3">{{ __('Monthly') }}</span>
                        <div class="price-tab-lang">
                            <span class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-monthly-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-monthly" type="button" role="tab"
                                        aria-controls="pills-monthly" aria-selected="true"></button>
                            </span>
                            <span class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-yearly-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-yearly" type="button" role="tab"
                                        aria-controls="pills-yearly" aria-selected="false"></button>
                            </span>
                        </div>
                        <span class="plan-switch-month-year-text mx-3">
                            {{ __('Yearly') }}
                        </span>
                    </div>
                    <div class="tab-content price-plan-meditation-nav-content" id="">
                        @include('frontend-theme-2.home.partial.subscription-home-list')
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- Subscription End -->

    @if($home->customer_says_area == 1)
        <!-- Testimonials Section -->
        <section class="testimonial-section testimonial-section-meditation bg-lan-bg">
            <div class="container">
                <div class="testimonial-section-content">
                    <!--  -->
                    <div class="title-wrap">
                        <h4 class="title">{{ __(get_option('customer_say_title')) }}</h4>
                        <p class="text">{{ __(get_option('customer_say_sub_title')) }}</p>
                    </div>
                    <!--  -->
                    <div class="testimonial-grid-items">
                        <div class="item">
                            <div class="testimonial-item-three">
                                <div class="author">
                                    <div class="info">
                                        <p class="degi">{{ __(get_option('customer_say_first_position')) }}</p>
                                        <h4 class="name">{{ __(get_option('customer_say_first_name')) }}</h4>
                                    </div>
                                    <div class="img">
                                        <img src="{{ getImageFile(get_option('customer_say_first_image')) }}" alt=""/>
                                    </div>
                                </div>
                                <p class="text">{{ __(get_option('customer_say_first_comment_description')) }}</p>
                                <div class="rating-wrap">
                                    <div class="star-ratings">
                                        <div class="fill-ratings"
                                             style="width: {{ (float) get_option('customer_say_first_comment_rating_star') * 20 }}%">
                                            <span>★★★★★</span>
                                        </div>
                                        <div class="empty-ratings">
                                            <span>★★★★★</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item item-big">
                            <div class="d-flex flex-column g-24">
                                <div class="testimonial-item-three">
                                    <div class="author">
                                        <div class="info">
                                            <p class="degi">{{ __(get_option('customer_say_second_position')) }}</p>
                                            <h4 class="name">{{ __(get_option('customer_say_second_name')) }}</h4>
                                        </div>
                                        <div class="img">
                                            <img src="{{ getImageFile(get_option('customer_say_second_image')) }}"
                                                 alt=""/>
                                        </div>
                                    </div>
                                    <p class="text">{{ __(get_option('customer_say_second_comment_description')) }}</p>
                                    <div class="rating-wrap">
                                        <div class="star-ratings">
                                            <div class="fill-ratings"
                                                 style="width: {{ (float) get_option('customer_say_second_comment_rating_star') * 20 }}%">
                                                <span>★★★★★</span>
                                            </div>
                                            <div class="empty-ratings">
                                                <span>★★★★★</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="testimonial-item-three">
                                    <div class="author">
                                        <div class="info">
                                            <p class="degi">{{ __(get_option('customer_say_third_position')) }}</p>
                                            <h4 class="name">{{ __(get_option('customer_say_third_name')) }}</h4>
                                        </div>
                                        <div class="img">
                                            <img src="{{ getImageFile(get_option('customer_say_third_image')) }}"
                                                 alt=""/>
                                        </div>
                                    </div>
                                    <p class="text">{{ __(get_option('customer_say_third_comment_description')) }}</p>
                                    <div class="rating-wrap">
                                        <div class="star-ratings">
                                            <div class="fill-ratings"
                                                 style="width: {{ (float) get_option('customer_say_third_comment_rating_star') * 20 }}%">
                                                <span>★★★★★</span>
                                            </div>
                                            <div class="empty-ratings">
                                                <span>★★★★★</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="testimonial-item-three">
                                <div class="author">
                                    <div class="info">
                                        <p class="degi">{{ __(get_option('customer_say_fourth_position')) }}</p>
                                        <h4 class="name">{{ __(get_option('customer_say_fourth_name')) }}</h4>
                                    </div>
                                    <div class="img">
                                        <img src="{{ getImageFile(get_option('customer_say_fourth_image')) }}" alt=""/>
                                    </div>
                                </div>
                                <p class="text">{{ __(get_option('customer_say_fourth_comment_description')) }}</p>
                                <div class="rating-wrap">
                                    <div class="star-ratings">
                                        <div class="fill-ratings"
                                             style="width: {{ (float) get_option('customer_say_first_comment_rating_star') * 20 }}%">
                                            <span>★★★★★</span>
                                        </div>
                                        <div class="empty-ratings">
                                            <span>★★★★★</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Saas Plan Start -->
    @if (@$home->saas_show == 1 && get_option('saas_mode'))
        <div class="price-area price-plan-meditation bg-lan-bg overflow-hidden">
            <div class="container">
                <div class="price-plan-content">
                    <!--  -->
                    <div class="title-wrap">
                        <h4 class="title">Saas Plan</h4>
                        <p class="text">#CHOOSE A SAAS PLAN AND SAVE MONEY!</p>
                    </div>
                </div>

                <div class="row">
                    <ul class="nav nav-pills saas-plan-instructor-organization-nav radius-8 mb-4 price-plan-meditation-nav"
                        id="home2SassTab"
                        role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="instructor-tab" data-bs-toggle="tab"
                                    data-bs-target="#instructor-tab-pane" type="button" role="tab"
                                    aria-controls="instructor-tab-pane"
                                    aria-selected="true">{{ __('Instructor') }}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="organization-tab" data-bs-toggle="tab"
                                    data-bs-target="#organization-tab-pane" type="button" role="tab"
                                    aria-controls="organization-tab-pane"
                                    aria-selected="false">{{ __('Organization') }}</button>
                        </li>
                    </ul>
                    <div class="tab-content price-plan-meditation-nav-content" id="home2SassTabContent">
                        <!-- Instructor -->
                        @include('frontend-theme-2.home.partial.instructor-saas-home-list')

                        <!-- Organization -->
                        @include('frontend-theme-2.home.partial.organization-saas-home-list')
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- Saas Plan End -->

    @if($home->instructor_support_area == 1)
        <!-- Support -->
        <section class="support-section support-section-meditation">
            <div class="container">
                <div class="support-section-content">
                    <!--  -->
                    <div class="title-wrap">
                        <h4 class="title">{{ __(@$aboutUsGeneral->instructor_support_title) }}</h4>
                        <p class="text">{{ __(@$aboutUsGeneral->instructor_support_subtitle) }}</p>
                    </div>
                    <!--  -->
                    <div class="row rg-20">
                        @foreach($instructorSupports as $index => $instructorSupport)
                            <div class="col-md-4 col-sm-6">
                                <div class="support-item-one">
                                    <div class="icon">
                                        <img src="{{ getImageFile($instructorSupport->image_path) }}" alt=""/>
                                    </div>
                                    <div class="text-content">
                                        <h4 class="title">{{ __($instructorSupport->title) }}</h4>
                                        <p class="text">{{ __($instructorSupport->subtitle) }}</p>
                                    </div>
                                    <a href="{{ $instructorSupport->button_link ?? '#' }}"
                                       class="btn-outline-meditation">{{ __($instructorSupport->button_name) }}
                                        <i
                                            class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if($home->faq_area == 1)
        <!-- FAQ -->
        <section class="bg-lan-bg faq-section faq-section-meditation">
            <div class="container">
                <div class="faq-section-content">
                    <!--  -->
                    <div class="title-wrap">
                        <h4 class="title">{{ __(get_option('faq_title')) }}</h4>
                        <p class="text">{{ __(get_option('faq_subtitle')) }}</p>
                    </div>
                    <!--  -->
                    <div class="accordion zAccordion-reset zAccordion-one zAccordion-meditation" id="accordionExample">
                        <div class="row rg-20 justify-content-center">
                            @php
                                $splitFaqs = $faqQuestions->split(2);
                            @endphp
                            <div class="col-xl-5 col-lg-6">
                                @foreach($splitFaqs->get(0) ?? [] as $key => $faqQuestion)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button {{ $key == 0 ? '' : 'collapsed' }}"
                                                    type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapse_{{ $key }}"
                                                    aria-expanded="{{ $key == 0 ? 'true' : 'false' }}"
                                                    aria-controls="collapse_{{ $key }}">{{($key+1)}}
                                                . {{ __($faqQuestion->question) }}
                                            </button>
                                        </h2>
                                        <div id="collapse_{{ $key }}"
                                             class="accordion-collapse collapse {{ $key == 0 ? 'show' : '' }}"
                                             data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <p> {{ __($faqQuestion->answer) }} </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-xl-5 col-lg-6">
                                @php
                                    $labelIndex = count($splitFaqs->get(0) ?? []);
                                @endphp
                                @foreach($splitFaqs->get(1) ?? [] as $key => $faqQuestion)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#collapse_right_{{$key}}" aria-expanded="false"
                                                    aria-controls="collapse_right_{{$key}}">{{++$labelIndex}}
                                                . {{ __($faqQuestion->question) }}
                                            </button>
                                        </h2>
                                        <div id="collapse_right_{{$key}}" class="accordion-collapse collapse"
                                             data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <p> {{ __($faqQuestion->answer) }} </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!--  -->
                    <div class="client-logo-wrap">
                        <ul class="client-logo">
                            @foreach($clients as $client)
                                <li><img src="{{ getImageFile($client->image_path) }}" alt="{{ $client->name }}"/></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @include('frontend.home.partial.consultation-booking-schedule-modal')

    <!-- New Video Player Modal Start-->
    <div class="modal fade VideoTypeModal" id="newVideoPlayerModal" tabindex="-1" aria-labelledby="newVideoPlayerModal"
         aria-hidden="true">

        <div class="modal-header border-bottom-0">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span class="iconify"
                                                                                                     data-icon="akar-icons:cross"></span>
            </button>
        </div>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="video-player-area">
                        <!-- HTML 5 Video -->
                        <video id="player" playsinline controls data-poster="{{ getImageFile($bannerImage) }}"
                               controlsList="nodownload">
                            <source src="{{ getVideoFile(@$home->banner_video) }}" type="video/mp4">
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <!-- Video Player css -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendor/video-player/plyr.css') }}">
@endpush

@push('script')
    <!--Hero text effect-->
    <script src="{{ asset('frontend/assets/js/course/addToCart.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/course/addToWishlist.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/custom/booking.js') }}"></script>

    <!-- Video Player js -->
    <script src="{{ asset('frontend/assets/vendor/video-player/plyr.js') }}"></script>

    <!--  -->
    <script src="{{ asset('frontend-theme-4/assets/js/jquery-3.7.0.min.js') }}"></script>
{{--    <script src="{{ asset('frontend-theme-4/assets/js/bootstrap.min.js') }}"></script>--}}
    <script src="{{ asset('frontend-theme-4/assets/js/plugins.js') }}"></script>
    <script src="{{ asset('frontend-theme-4/assets/js/main.js') }}"></script>

    <script>
        const zai_player = new Plyr('#player');
    </script>
    <!-- Video Player js -->
@endpush
