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
    <section class="hero-banner hero-banner-kindergarten"
             data-background="{{ getImageFile($bannerImage) }}">
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
                        <a href="{{ $home->banner_second_button_link }}"
                           class="hero-btn-2">{{ __($home->banner_second_button_name) }} <i
                                class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Features -->
    <section class="core-features core-features-kindergarten {{ @$home->special_feature_area == 1 ? '' : 'd-none' }}">
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
                        <div class="core-features-item core-features-item-kindergarten">
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
                        <div class="core-features-item core-features-item-kindergarten">
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
                        <div class="core-features-item core-features-item-kindergarten">
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
            <section class="board-section board-section-kindergarten">
                <div class="container">
                    <div class="board-section-content">
                        <!--  -->
                        <div class="title-wrap">
                            <div class="row justify-content-between align-items-center rg-20">
                                <div class="col-lg-7">
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
                                           class="btn-fill-kindergarten">{{__('View All')}} <i
                                                class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  -->
                        <div class="row rg-40">
                            @if(count($featuredCourses))
                                <div class="latest-courses-slider owl-carousel">
                                    @foreach ($featuredCourses as $course)
                                        @php
                                            $userRelation = getUserRoleRelation($course->user);
                                        @endphp
                                        <div class="col-12 col-sm-4 col-lg-3 w-100">
                                            <div class="course-item-kindergarten">
                                                @include('frontend-theme-4.partials.course')
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                {{ __("No Course Found") }}
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif

    @if($home->category_courses_area == 1)
        <!-- Top categories -->
        <section class="top-categories top-categories-kindergarten">
            <img src="{{asset('frontend-theme-4/assets/images/kindergarten-top-category-wave.svg')}}" alt=""
                 class="wave-img"/>
            <div class="container">
                <div class="top-categories-content">
                    <!--  -->
                    <div class="title-wrap">
                        <div class="icon d-flex">
                            <img src="{{ getImageFile(get_option('category_course_logo')) }}" alt=""/>
                        </div>
                        <h4 class="title">{{ __(get_option('category_course_title')) }}</h4>
                        <p class="text">{{ __(get_option('category_course_subtitle')) }}</p>
                    </div>
                    <!--  -->
                    <div class="row rg-24">
                        @foreach($featureCategories->take(8) as $key => $category)
                            <div class="col-xl-3 col-lg-4 col-sm-6">
                                <a href="{{ route('category-courses', $category->slug) }}">
                                    <div class="top-categories-item">
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
                </div>
            </div>
        </section>
    @endif

    @if($home->upcoming_courses_area == 1)
        <!-- Upcoming course Section -->
        <section class="upcoming-course upcoming-course-kindergarten">
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
                                    <a href="{{ route('courses') }}" class="btn-fill-kindergarten">{{__('View All')}}
                                        <i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row rg-20">
                        @if(count($upcomingCourses))
                            @foreach ($upcomingCourses as $course)
                                @php
                                    $userRelation = getUserRoleRelation($course->user);
                                @endphp
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <div class="course-item-kindergarten">
                                        @include('frontend-theme-4.partials.course')
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

    @if($home->bundle_area == 1)
        @if(count($bundles) > 0)
            <!-- Latest Bundle Section -->
            <section class="latest-bundle latest-bundle-kindergarten">
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
                                           class="btn-fill-kindergarten">{{ __('View All') }} <i
                                                class="fa fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  -->
                        <div class="row rg-30">
                            @foreach($bundles->take(4) as $bundle)
                                @php
                                    $relation = getUserRoleRelation($bundle->user)
                                @endphp
                                <div class="col-md-6">
                                    <div class="course-item-three">
                                        <div class="img">
                                            <img src="{{ getImageFile($bundle->image) }}" alt=""/>
                                        </div>
                                        <div class="content">
                                            <a href="{{ route('bundle-details', [$bundle->slug]) }}"
                                               class="title">{{ Str::limit($bundle->name, 40) }}</a>
                                            <a href="{{ route('userProfile',$bundle->user->id) }}"
                                               class="author">{{ @$bundle->user->$relation->name }}</a>
                                            <p>
                                                {{__('Courses')}}:
                                                <span class="color-hover">{{ @$bundle->bundleCourses->count() }}</span>
                                            </p>
                                            <p class="price">{{ __('Price') }}:
                                                <span class="discountPrice">
                                                  @if($currencyPlacement == 'after')
                                                        {{$bundle->price}} {{ $currencySymbol }}
                                                    @else
                                                        {{ $currencySymbol }} {{$bundle->price}}
                                                    @endif
                                            </span>
                                            </p>
                                            @if(get_option('cashback_system_mode', 0))
                                                <div class="cashback">
                                                    <div class="title">{{__('Cashback')}} :</div>
                                                    <div class="amount">
                                                        @if($currencyPlacement ?? get_currency_placement() == 'after')
                                                            {{calculateCashback($bundle->price) }} {{ $currencySymbol ?? get_currency_symbol() }}
                                                        @else
                                                            {{ $currencySymbol ?? get_currency_symbol() }} {{calculateCashback($bundle->price) }}
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
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

    @if(isAddonInstalled('LMSZAIPRODUCT'))
        @if($home->product_area == 1)
            <!-- Product Varity -->
            <section class="product-varity product-varity-kindergarten">
                <img src="{{asset('frontend-theme-4/assets/images/kindergarten-top-category-wave.svg')}}" alt="" class="wave-img"/>
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
                        <div class="row rg-24">
                            @foreach($products->take(6) as $product)
                                @php
                                    $relation = getUserRoleRelation($product->user)
                                @endphp
                                <div class="col-lg-4 col-md-6">
                                    <div class="course-item-two course-item-two-kindergarten">
                                        <div class="img">
                                            <img src="{{getImageFile($product->thumbnail_path)}}"
                                                 alt="{{$product->title}}"/>
                                        </div>
                                        <div class="content">
                                            <a class="title" href="{{ route('lms_product.frontend.view', $product->slug) }}">{{$product->title}}</a>
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
                                                <button class="btn-fill-kindergarten addToCart"
                                                        data-product_id="{{ $product->id }}" data-quantity=1
                                                        data-route="{{ route('student.addToCart') }}">{{ __('Add To Cart') }}
                                                    <i class="fa fa-arrow-right"></i></button>
                                            @else
                                                <button class="btn-fill-kindergarten">{{ __('Out of stock') }} <i
                                                        class="fa fa-arrow-right"></i></button>
                                            @endif
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


    @if($home->instructor_area == 1)
        <!-- Top Instructor -->
        <section class="top-instructor top-instructor-kindergarten">
            <img src="{{asset('frontend-theme-4/assets/images/top-instructor-bg.png')}}" alt="" class="bg-img"/>
            <div class="container">
                <div class="top-instructor-content">
                    <!--  -->
                    <div class="title-wrap">
                        <h4 class="title text-center text-sm-start">{{ __(get_option('top_instructor_title')) }}</h4>
                        <p class="text text-center text-sm-start">{{ __(get_option('top_instructor_subtitle')) }}</p>
                    </div>
                    <!--  -->
                    <div class="row rg-20">
                        @foreach($consultationInstructors->take(4) as $user)
                            <div class="col-xl-3 col-lg-4 col-sm-6">
                                <div class="top-instructor-item-one position-relative">
                                    @php
                                        $percent = $user->hourly_rate && $user->hourly_old_rate ? (($user->hourly_old_rate -
                                        $user->hourly_rate) * 100) / $user->hourly_old_rate : 0;
                                    @endphp
                                    @if ($percent && $user->consultation_available == 1)
                                        <span
                                            class="instructor-price-cutoff badge radius-3 font-12 font-medium position-absolute bg-orange">{{round(@$percent) }} {{ __('off') }}</span>
                                    @endif
                                    <a href="{{ route('userProfile', $user->id) }}" class="img">
                                        <img src="{{getImageFile(@$user->image_path)}}"
                                             alt=""/>
                                    </a>
                                    <div class="content">
                                        <a href="{{ route('userProfile', $user->id) }}"
                                           class="title">{{$user->name }}</a>
                                        <p class="ins-authLevel"> {{ @$user->professional_title }} ||
                                            @if(get_instructor_ranking_level($user->badges))
                                                || {{ get_instructor_ranking_level($user->badges) }}
                                            @endif
                                        </p>
                                            <?php
                                            $average_rating = $user->courses->where('average_rating', '>', 0)->avg('average_rating');
                                            ?>
                                        <div class="ratingWrap">
                                            <p class="no">{{ number_format(@$average_rating, 1) }}</p>
                                            <div class="star-ratings">
                                                <div class="fill-ratings"
                                                     style="width: {{ $average_rating * 20 }}%">
                                                    <span>★★★★★</span>
                                                </div>
                                                <div class="empty-ratings">
                                                    <span>★★★★★</span>
                                                </div>
                                            </div>
                                            <div class="totalRating">
                                                ({{ count(@$user->courses->where('average_rating', '>', 0))}})
                                            </div>
                                        </div>
                                        <div class="search-instructor-bottom-item font-14 font-medium">
                                            <div
                                                class="search-instructor-award-img d-inline-flex flex-wrap justify-content-center">
                                                @foreach ($user->badges as $badge)
                                                    <img src="{{ asset($badge->badge_image) }}"
                                                         title="{{ $badge->name }}" alt="{{ $badge->name }}"
                                                         class="fit-image rounded-circle">
                                                @endforeach
                                            </div>
                                        </div>
                                        @if ($user->consultation_available == 1)
                                            @if ($user->hourly_rate < $user->hourly_old_rate)
                                                <p class="fs-12 fw-500 lh-12 text-kindergarten-para-text pb-26">{{ $user->hourly_rate }}
                                                    /{{ __('Hour') }}</p>
                                                <p class="fs-12 fw-500 lh-12 text-kindergarten-para-text pb-26 text-decoration-line-through">{{ $user->hourly_old_rate }}</p>
                                            @else
                                                <p class="fs-12 fw-500 lh-12 text-kindergarten-para-text pb-26">{{ $user->hourly_rate }}
                                                    /{{ __('Hour') }}</p>
                                            @endif
                                        @else
                                            <p class="fs-12 fw-500 lh-12 text-kindergarten-para-text pb-26"></p>
                                        @endif
                                        @php $hourly_fee = 0; @endphp
                                        @if($currencyPlacement ?? get_currency_placement() == 'after')
                                            @php $hourly_fee = $user->hourly_rate . ' ' . $currencySymbol ?? get_currency_symbol() . '/h'; @endphp
                                        @else
                                            @php $hourly_fee = $currencySymbol ?? get_currency_symbol() . ' ' . $user->hourly_rate . '/h'; @endphp
                                        @endif
                                        <button type="button"
                                                data-type="{{ $user->available_type }}"
                                                data-booking_instructor_user_id="{{ $user->id }}"
                                                data-hourly_fee="{{ $hourly_fee }}"
                                                data-hourly_rate="{{ $user->hourly_rate }}"
                                                data-get_off_days_route="{{ route('getOffDays', $user->id) }}"
                                                class="btn-fill-kindergarten linkBtn"
                                                data-bs-toggle="modal"
                                                data-bs-target="#consultationBookingModal">{{ __('Book Schedule') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if (@$home->subscription_show == 1 && get_option('subscription_mode'))
        <!-- Price Plan Section -->
        <section class="price-plan price-plan-kindergarten">
            <div class="container">
                <div class="price-plan-content">
                    <!--  -->
                    <div class="title-wrap">
                        <h4 class="title">{{ __('Subscribe Now!') }}</h4>
                        <p class="text">{{ __('#Choose a subscription plan and save money!') }}</p>
                    </div>
                    <!--  -->
                    <div class="price-plan-tab-wrap d-flex justify-content-center align-items-center g-20 pb-50">
                        <h4 class="fs-18 fw-400 lh-27 text-main-color">{{ __('Monthly') }}</h4>
                        <div class="price-toggle-wrap price-toggle-kindergarten">
                            <input id="priceToggle-checkbox-kindergarten" type="checkbox" class="zPrice-plan-switch priceToggle-checkbox" />
                            <label for="priceToggle-checkbox-kindergarten" class="priceToggle-switch">
                                      <span class="switch__circle">
                                        <span class="switch__circle-inner"></span>
                                      </span>
                            </label>
                        </div>
                        <h4 class="fs-18 fw-400 lh-27 text-main-color">{{__('Yearly')}}</h4>
                    </div>
                    <!--  -->
                    <div class="row rg-20">
                        @php
                            $matched = $subscriptions->where('id', @$mySubscriptionPackage->package_id)->first();
                            $disabledYearly = (!is_null($matched) && $mySubscriptionPackage->subscription_type == SUBSCRIPTION_TYPE_YEARLY ? true : false);
                            $disabledMonthly = ($disabledYearly) ? true : (!is_null($matched) && $mySubscriptionPackage->subscription_type == SUBSCRIPTION_TYPE_MONTHLY ? true : false);
                        @endphp
                        @foreach ($subscriptions as $index => $subscription)
                            @php
                                $isCurrentMonthly = (($subscription->id == @$mySubscriptionPackage->package_id && @$mySubscriptionPackage->subscription_type) == SUBSCRIPTION_TYPE_MONTHLY);
                                $isCurrentYearly = (($subscription->id == @$mySubscriptionPackage->package_id && @$mySubscriptionPackage->subscription_type) == SUBSCRIPTION_TYPE_YEARLY);
                                $priceMonthly = $subscription->discounted_monthly_price;
                                $oldPriceMonthly = $subscription->monthly_price;
                                $priceYearly = $subscription->discounted_yearly_price;
                                $oldPriceYearly = $subscription->yearly_price;
                            @endphp
                            <div class="col-lg-4 col-md-6">
                                <div class="price-plan-item-two">
                                    <div class="price-head">
                                        <p class="sub-title">{{ $subscription->title }}</p>
                                        <div class="d-flex align-items-center g-10">
                                            @if($priceMonthly < 1)
                                                <h4 class="planPrice planPrice-monthly-amount">{{__('Full Free')}}</h4>
                                            @else
                                                <h4 class="planPrice planPrice-monthly-amount">{{ $priceMonthly.($currencySymbol ?? get_currency_symbol()) }}</h4>
                                                @if($priceMonthly != $oldPriceMonthly)
                                                    <h4 class="planPrice planPrice-monthly-amount text-decoration-line-through fs-14 lh-14 text-kindergarten-para-text">{{ $oldPriceMonthly.($currencySymbol ?? get_currency_symbol()) }}</h4>
                                                @endif
                                            @endif
                                            @if($priceYearly < 1)
                                                <h4 class="planPrice planPrice-yearly-amount">{{__('Full Free')}}</h4>
                                            @else
                                                <h4 class="planPrice planPrice-yearly-amount">{{ $priceYearly.($currencySymbol ?? get_currency_symbol()) }}</h4>
                                                @if($priceYearly != $oldPriceYearly)
                                                    <h4 class="planPrice planPrice-yearly-amount text-decoration-line-through fs-14 lh-14 text-kindergarten-para-text">{{ $oldPriceYearly.($currencySymbol ?? get_currency_symbol()) }}</h4>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    <div class="price-body">
                                        <ul class="list">
                                            <li class="d-flex align-items-center g-10">
                                                <div class="icon flex-shrink-0"><i class="fa fa-check"></i></div>
                                                <p class="text">{{ __('Unlimited access to').' '. $subscription->course. __(' course') }}</p>
                                            </li>
                                            <li class="d-flex align-items-center g-10">
                                                <div class="icon flex-shrink-0"><i class="fa fa-check"></i></div>
                                                <p class="text">{{ __('Access to').' '. $subscription->bundle_course.' '.__('bundle course') }}</p>
                                            </li>
                                            <li class="d-flex align-items-center g-10">
                                                <div class="icon flex-shrink-0"><i class="fa fa-check"></i></div>
                                                <p class="text">{{ __("Buy") .' '. $subscription->consultancy.' '.__('Consultancy Hour') }}</p>
                                            </li>
                                            <li class="d-flex align-items-center g-10">
                                                <div class="icon flex-shrink-0"><i class="fa fa-check"></i></div>
                                                <p class="text">{{ $subscription->device .' '. __("Devices Access") }}</p>
                                            </li>
                                        </ul>
                                        <form method="post"
                                              action="{{ route('student.subscription.checkout', $subscription->uuid) }}">
                                            @csrf
                                            <input type="hidden" name="monthly" class="monthly-type" value=1>
                                            <button type="submit"
                                                    {{ ($disabledMonthly) ? 'disabled' : '' }} class="{{ ($disabledMonthly) ? 'disabled-btn' : '' }} priceBtn btn-fill-kindergarten monthly-btn">{{ ($disabledMonthly && $isCurrentMonthly) ? __("Current Plan") : __("Get Started") }}</button>
                                            <button type="submit"
                                                    {{ ($disabledYearly) ? 'disabled' : '' }} class="{{ ($disabledYearly) ? 'disabled-btn' : '' }} priceBtn btn-fill-kindergarten yearly-btn d-none">{{ ($disabledYearly && $isCurrentYearly) ? __("Current Plan") : __("Get Started") }}</button>
                                        </form>
                                        @php
                                            if($disabledMonthly && $subscription->id == $matched->id){
                                                $disabledMonthly = false;
                                            }
                                            if($disabledYearly && $subscription->id == $matched->id){
                                                $disabledYearly = false;
                                            }
                                        @endphp
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if($home->customer_says_area == 1)
        <!-- Testimonial -->
        <section class="testimonial-section testimonial-section-kindergarten">
            <img src="{{asset('frontend-theme-4/assets/images/kindergarten-top-category-wave.svg')}}" alt=""
                 class="wave-img"/>
            <div class="container">
                <div class="testimonial-section-content">
                    <!--  -->
                    <div class="title-wrap">
                        <h4 class="title">{{ __(get_option('customer_say_title')) }}</h4>
                        <p class="text">{{ __(get_option('customer_say_sub_title')) }}</p>
                    </div>
                    @php
                        // Define the array of items (first, second, third, fourth)
                        $customerSayItems = ['first', 'second', 'third'];
                    @endphp
                        <!--  -->
                    <div class="row rg-24">
                        @foreach($customerSayItems as $customerSayItem)
                            <div class="col-lg-4 col-sm-6">
                                <div class="testimonial-item-two">
                                    <div class="author">
                                        <div class="img">
                                            <img
                                                src="{{ getImageFile(get_option('customer_say_'.$customerSayItem.'_image')) }}"
                                                alt="quote"/>
                                        </div>
                                        <div class="content">
                                            <h4 class="name">{{ __(get_option('customer_say_'.$customerSayItem.'_name')) }}</h4>
                                            <p class="degi">{{ __(get_option('customer_say_'.$customerSayItem.'_position')) }}</p>
                                        </div>
                                    </div>

                                    <p class="text">{{ __(get_option('customer_say_'.$customerSayItem.'_comment_description')) }}</p>
                                    <div class="rating-wrap">
                                        <p class="no">{{ (float) get_option('customer_say_'.$customerSayItem.'_comment_rating_star')}}</p>
                                        <div class="star-ratings">
                                            <div class="fill-ratings"
                                                 style="width: {{ (float) get_option('customer_say_'.$customerSayItem.'_comment_rating_star') * 20 }}%">
                                                <span>★★★★★</span>
                                            </div>
                                            <div class="empty-ratings">
                                                <span>★★★★★</span>
                                            </div>
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

    @if (@$home->saas_show == 1 && get_option('saas_mode'))
        <!-- Price Plan Section -->
        <section class="price-plan price-plan-kindergarten">
            <div class="container">
                <div class="price-plan-content">
                    <!--  -->
                    <div class="title-wrap">
                        <h4 class="title">{{ __('Saas Plan') }}</h4>
                        <p class="text">{{ __('#Choose a saas plan and save money!') }}</p>
                    </div>
                    <!--  -->
                    <div class="d-flex justify-content-center">
                        <ul class="nav nav-pills  zTab-reset zTab-instructorOrganization zTab-instructorOrganization-kindergarten"
                            id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-instructor1-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-instructor1" type="button" role="tab"
                                        aria-controls="pills-instructor1" aria-selected="true">
                                    {{__('Instructor')}}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-organization1-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-organization1" type="button" role="tab"
                                        aria-controls="pills-organization1" aria-selected="false">
                                    {{__('Organization')}}</button>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-instructor1" role="tabpanel"
                             aria-labelledby="pills-instructor1-tab" tabindex="0">
                            <div
                                class="price-plan-tab-wrap d-flex justify-content-center align-items-center g-20 pb-50">
                                <h4 class="fs-18 fw-400 lh-27 text-main-color">{{__('Monthly')}}</h4>

                                <div class="price-toggle-wrap price-toggle-kindergarten">
                                    <input id="priceToggle-checkbox-kindergarten-2" type="checkbox" class="zPrice-plan-switch-tab priceToggle-checkbox" />
                                    <label for="priceToggle-checkbox-kindergarten-2" class="priceToggle-switch">
                                      <span class="switch__circle">
                                        <span class="switch__circle-inner"></span>
                                      </span>
                                    </label>
                                </div>
                                <h4 class="fs-18 fw-400 lh-27 text-main-color">{{__('Yearly')}}</h4>
                            </div>
                            <!--  -->
                            <div class="row rg-20">
                                @php
                                    $matched = $instructorSaas->where('id', @$mySaasPackage->package_id)->first();
                                    $disabledYearly = (!is_null($matched) && $mySaasPackage->subscription_type == SUBSCRIPTION_TYPE_YEARLY ? true : false);
                                    $disabledMonthly = ($disabledYearly) ? true : (!is_null($matched) && $mySaasPackage->subscription_type == SUBSCRIPTION_TYPE_MONTHLY ? true : false);
                                @endphp
                                @foreach($instructorSaas as $index => $saas)
                                    @php
                                        $isCurrentMonthly = (($saas->id == @$mySaasPackage->package_id && @$mySaasPackage->subscription_type) == SUBSCRIPTION_TYPE_MONTHLY);
                                        $isCurrentYearly = (($saas->id == @$mySaasPackage->package_id && @$mySaasPackage->subscription_type) == SUBSCRIPTION_TYPE_YEARLY);
                                        $priceMonthly = $saas->discounted_monthly_price;
                                        $oldPriceMonthly = $saas->monthly_price;
                                        $priceYearly = $saas->discounted_yearly_price;
                                        $oldPriceYearly = $saas->yearly_price;
                                    @endphp
                                    <div class="col-lg-4 col-md-6">
                                        <div class="price-plan-item-two">
                                            <div class="price-head">
                                                <p class="sub-title">{{ $saas->title }}</p>
                                                <div class="d-flex align-items-center g-10">
                                                    @if($priceMonthly < 1)
                                                        <h4 class="planPrice planPrice-monthly-amount">{{__('Full Free')}}</h4>
                                                    @else
                                                        <h4 class="planPrice planPrice-monthly-amount">{{ $priceMonthly.($currencySymbol ?? get_currency_symbol()) }}</h4>
                                                        @if($priceMonthly != $oldPriceMonthly)
                                                            <h4 class="planPrice planPrice-monthly-amount text-decoration-line-through fs-14 lh-14 text-kindergarten-para-text">{{ $oldPriceMonthly.($currencySymbol ?? get_currency_symbol()) }}</h4>
                                                        @endif
                                                    @endif
                                                    @if($priceYearly < 1)
                                                        <h4 class="planPrice planPrice-yearly-amount">{{__('Full Free')}}</h4>
                                                    @else
                                                        <h4 class="planPrice planPrice-yearly-amount">{{ $priceYearly.($currencySymbol ?? get_currency_symbol()) }}</h4>
                                                        @if($priceYearly != $oldPriceYearly)
                                                            <h4 class="planPrice planPrice-yearly-amount text-decoration-line-through fs-14 lh-14 text-kindergarten-para-text">{{ $oldPriceYearly.($currencySymbol ?? get_currency_symbol()) }}</h4>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="price-body">
                                                <ul class="list">
                                                    <li class="d-flex align-items-center g-10">
                                                        <div class="icon flex-shrink-0"><i class="fa fa-check"></i></div>
                                                        <p class="text">{{ __('Unlimited Create ').' '. $saas->course. ' '.__('Course') }}</p>
                                                    </li>
                                                    <li class="d-flex align-items-center g-10">
                                                        <div class="icon flex-shrink-0"><i class="fa fa-check"></i></div>
                                                        <p class="text">{{ __("Create") .' '. $saas->bundle_course.' '.__('Bundle Course') }}</p>
                                                    </li>
                                                    <li class="d-flex align-items-center g-10">
                                                        <div class="icon flex-shrink-0"><i class="fa fa-check"></i></div>
                                                        <p class="text">{{ __("Enable") .' '. $saas->subscription_course.' '.__('Subscription Course') }}</p>
                                                    </li>
                                                    <li class="d-flex align-items-center g-10">
                                                        <div class="icon flex-shrink-0"><i class="fa fa-check"></i></div>
                                                        <p class="text">{{ __("Give") .' '. $saas->consultancy.' '.__('hour consultancy') }}</p>
                                                    </li>
                                                    <li class="d-flex align-items-center g-10">
                                                        <div class="icon flex-shrink-0"><i class="fa fa-check"></i></div>
                                                        <p class="text">{{ __("Minimum of") .' '. $saas->admin_commission .'% '.__('sale commission')}}</p>
                                                    </li>
                                                </ul>
                                                <form method="post"
                                                      action="{{ route('student.subscription.checkout', $saas->uuid) }}">
                                                    @csrf
                                                    <input type="hidden" name="monthly" class="monthly-type" value=1>
                                                    <button type="submit"
                                                            {{ ($disabledMonthly) ? 'disabled' : '' }} class="{{ ($disabledMonthly) ? 'disabled-btn' : '' }} priceBtn btn-fill-kindergarten monthly-btn">{{ ($disabledMonthly && $isCurrentMonthly) ? __("Current Plan") : __("Get Started") }}</button>
                                                    <button type="submit"
                                                            {{ ($disabledYearly) ? 'disabled' : '' }} class="{{ ($disabledYearly) ? 'disabled-btn' : '' }} priceBtn btn-fill-kindergarten yearly-btn d-none">{{ ($disabledYearly && $isCurrentYearly) ? __("Current Plan") : __("Get Started") }}</button>
                                                </form>
                                                @php
                                                    if($disabledMonthly && $saas->id == $matched->id){
                                                        $disabledMonthly = false;
                                                    }
                                                    if($disabledYearly && $saas->id == $matched->id){
                                                        $disabledYearly = false;
                                                    }
                                                @endphp
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-organization1" role="tabpanel"
                             aria-labelledby="pills-organization1-tab" tabindex="0">
                            <div
                                class="price-plan-tab-wrap d-flex justify-content-center align-items-center g-20 pb-50">
                                <h4 class="fs-18 fw-400 lh-27 text-main-color">{{__('Monthly')}}</h4>

                                <div class="price-toggle-wrap price-toggle-kindergarten">
                                    <input id="priceToggle-checkbox-kindergarten-4" type="checkbox" class="zPrice-plan-switch-tab priceToggle-checkbox" />
                                    <label for="priceToggle-checkbox-kindergarten-4" class="priceToggle-switch">
                                      <span class="switch__circle">
                                        <span class="switch__circle-inner"></span>
                                      </span>
                                    </label>
                                </div>
                                <h4 class="fs-18 fw-400 lh-27 text-main-color">{{__('Yearly')}}</h4>
                            </div>
                            <!--  -->
                            <div class="row rg-20">
                                @php
                                    $matched = $organizationSaas->where('id', @$mySaasPackage->package_id)->first();
                                    $disabledYearly = (!is_null($matched) && $mySaasPackage->subscription_type == SUBSCRIPTION_TYPE_YEARLY ? true : false);
                                    $disabledMonthly = ($disabledYearly) ? true : (!is_null($matched) && $mySaasPackage->subscription_type == SUBSCRIPTION_TYPE_MONTHLY ? true : false);
                                @endphp
                                @foreach($organizationSaas as $index => $saas)
                                    @php
                                        $isCurrentMonthly = (($saas->id == @$mySaasPackage->package_id && @$mySaasPackage->subscription_type) == SUBSCRIPTION_TYPE_MONTHLY);
                                        $isCurrentYearly = (($saas->id == @$mySaasPackage->package_id && @$mySaasPackage->subscription_type) == SUBSCRIPTION_TYPE_YEARLY);
                                        $priceMonthly = $saas->discounted_monthly_price;
                                        $oldPriceMonthly = $saas->monthly_price;
                                        $priceYearly = $saas->discounted_yearly_price;
                                        $oldPriceYearly = $saas->yearly_price;
                                    @endphp
                                    <div class="col-lg-4 col-md-6">
                                        <div class="price-plan-item-two">
                                            <div class="price-head">
                                                <p class="sub-title">{{ $saas->title }}</p>
                                                <div class="d-flex align-items-center g-10">
                                                    @if($priceMonthly < 1)
                                                        <h4 class="planPrice planPrice-monthly-amount">{{__('Full Free')}}</h4>
                                                    @else
                                                        <h4 class="planPrice planPrice-monthly-amount">{{ $priceMonthly.($currencySymbol ?? get_currency_symbol()) }}</h4>
                                                        @if($priceMonthly != $oldPriceMonthly)
                                                            <h4 class="planPrice planPrice-monthly-amount text-decoration-line-through fs-14 lh-14 text-kindergarten-para-text">{{ $oldPriceMonthly.($currencySymbol ?? get_currency_symbol()) }}</h4>
                                                        @endif
                                                    @endif
                                                    @if($priceYearly < 1)
                                                        <h4 class="planPrice planPrice-yearly-amount">{{__('Full Free')}}</h4>
                                                    @else
                                                        <h4 class="planPrice planPrice-yearly-amount">{{ $priceYearly.($currencySymbol ?? get_currency_symbol()) }}</h4>
                                                        @if($priceYearly != $oldPriceYearly)
                                                            <h4 class="planPrice planPrice-yearly-amount text-decoration-line-through fs-14 lh-14 text-kindergarten-para-text">{{ $oldPriceYearly.($currencySymbol ?? get_currency_symbol()) }}</h4>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="price-body">
                                                <ul class="list">
                                                    <li class="d-flex align-items-center g-10">
                                                        <div class="icon flex-shrink-0"><i class="fa fa-check"></i></div>
                                                        <p class="text">{{ __("Unlimited create of").' '. $saas->instructor.' '.__('instructor') }}</p>
                                                    </li>
                                                    <li class="d-flex align-items-center g-10">
                                                        <div class="icon flex-shrink-0"><i class="fa fa-check"></i></div>
                                                        <p class="text">{{ __("Create ").' '. $saas->student.' '.__('student') }}</p>
                                                    </li>
                                                    <li class="d-flex align-items-center g-10">
                                                        <div class="icon flex-shrink-0"><i class="fa fa-check"></i></div>
                                                        <p class="text">{{ __('Unlimited Create ').' '. $saas->course. ' '.__('Course') }}</p>
                                                    </li>
                                                    <li class="d-flex align-items-center g-10">
                                                        <div class="icon flex-shrink-0"><i class="fa fa-check"></i></div>
                                                        <p class="text">{{ __("Create") .' '. $saas->bundle_course.' '.__('Bundle Course') }}</p>
                                                    </li>
                                                    <li class="d-flex align-items-center g-10">
                                                        <div class="icon flex-shrink-0"><i class="fa fa-check"></i></div>
                                                        <p class="text">{{ __("Enable") .' '. $saas->subscription_course.' '.__('Subscription Course') }}</p>
                                                    </li>
                                                    <li class="d-flex align-items-center g-10">
                                                        <div class="icon flex-shrink-0"><i class="fa fa-check"></i></div>
                                                        <p class="text">{{ __("Give") .' '. $saas->consultancy.' '.__('hour consultancy') }}</p>
                                                    </li>
                                                    <li class="d-flex align-items-center g-10">
                                                        <div class="icon flex-shrink-0"><i class="fa fa-check"></i></div>
                                                        <p class="text">{{ __("Minimum of") .' '. $saas->admin_commission .'% '.__('sale commission')}}</p>
                                                    </li>
                                                </ul>
                                                <form method="post"
                                                      action="{{ route('student.subscription.checkout', $saas->uuid) }}">
                                                    @csrf
                                                    <input type="hidden" name="monthly" class="monthly-type" value=1>
                                                    <button type="submit"
                                                            {{ ($disabledMonthly) ? 'disabled' : '' }} class="{{ ($disabledMonthly) ? 'disabled-btn' : '' }} priceBtn btn-fill-kindergarten monthly-btn">{{ ($disabledMonthly && $isCurrentMonthly) ? __("Current Plan") : __("Get Started") }}</button>
                                                    <button type="submit"
                                                            {{ ($disabledYearly) ? 'disabled' : '' }} class="{{ ($disabledYearly) ? 'disabled-btn' : '' }} priceBtn btn-fill-kindergarten yearly-btn d-none">{{ ($disabledYearly && $isCurrentYearly) ? __("Current Plan") : __("Get Started") }}</button>
                                                </form>
                                                @php
                                                    if($disabledMonthly && $saas->id == $matched->id){
                                                        $disabledMonthly = false;
                                                    }
                                                    if($disabledYearly && $saas->id == $matched->id){
                                                        $disabledYearly = false;
                                                    }
                                                @endphp
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if($home->instructor_support_area == 1)
        <!-- Support -->
        <section class="support-section support-section-kindergarten">
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
                                       class="btn-fill-kindergarten">{{ __($instructorSupport->button_name) }}
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
        <section class="faq-section faq-section-kindergarten">
            <div class="container">
                <div class="faq-section-content">
                    <!--  -->
                    <div class="title-wrap">
                        <h4 class="title">{{ __(get_option('faq_title')) }}</h4>
                        <p class="text">{{ __(get_option('faq_subtitle')) }}</p>
                    </div>
                    <!--  -->
                    <div class="accordion zAccordion-reset zAccordion-one zAccordion-kindergarten"
                         id="accordionExample">
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
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
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
                        <video id="player" playsinline controls
                               data-poster="{{ getImageFile(get_option('become_instructor_video_preview_image')) }}"
                               controlsList="nodownload">
                            <source src="{{ getVideoFile(get_option('become_instructor_video')) }}" type="video/mp4">
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
