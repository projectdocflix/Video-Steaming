@extends('frontend.layouts.app')
@php
    $relation = getUserRoleRelation($course->user);
@endphp
@section('meta')
    <meta name="description" content="{{ __($course->meta_description) }}">
    <meta name="keywords" content="{{ __($course->meta_keywords) }}">

    <!-- Open Graph meta tags for social sharing -->
    <meta property="og:type" content="Learning">
    <meta property="og:title" content="{{ __($course->meta_title) }}">
    <meta property="og:description" content="{{ __($course->meta_description) }}">
    <meta property="og:image" content="{{ getImageFile($course->og_image) }}">
    <meta property="og:url" content="{{ url()->current() }}">

    <meta property="og:site_name" content="{{ __(get_option('app_name')) }}">

    <!-- Twitter Card meta tags for Twitter sharing -->
    <meta name="twitter:card" content="Learning">
    <meta name="twitter:title" content="{{ __($course->meta_title) }}">
    <meta name="twitter:description" content="{{ __($course->meta_description) }}">
    <meta name="twitter:image" content="{{ getImageFile($course->og_image) }}">
@endsection
@section('content')
    <div class="bg-page">
        <!-- Course Single Page Header Start -->
        <header class="course-single-page-header gradient-bg position-relative">
            <div class="section-overlay">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                            <div class="course-single-banner-content">
                                <h3 class="page-banner-heading text-white pb-30">{{ __($course->title) }}</h3>
                                <p class="page-banner-sub-heading pb-30">{{ __($course->subtitle) }}</p>
                                <p class="instructor-name-certificate font-medium font-12 text-white">
                                    <span class="text-decoration-underline">{{ @$course->user->$relation->name }}</span>
                                    @if(get_instructor_ranking_level(@$course->user->badges))
                                        | {{ get_instructor_ranking_level(@$course->user->badges) }}
                                    @endif
                                </p>

                                <div class="course-rating d-flex align-items-center text-white">
                                    <span
                                        class="font-medium font-14 me-2">{{ number_format($course->average_rating, 1) }}</span>
                                    <ul class="rating-list d-flex align-items-center me-2">
                                        @include('frontend.course.render-course-rating')
                                    </ul>
                                    <span class="rating-count font-14 me-3">({{ $total_user_review }})</span>
                                    <span
                                        class="rating-count font-14">{{ @$course->orderItems->count() }} {{ __('Students') }}</span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Course Single Page Header End -->

        <!-- Course Single Details Area Start -->
        <section class="course-single-details-area before-login-purchase-course-details">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-8">

                        <div class="course-single-details-left-content bg-white">

                            <!-- Tab panel nav list -->
                            <div class="course-tab-nav-wrap course-details-tab-nav-wrap d-flex justify-content-between">
                                <ul class="nav nav-tabs tab-nav-list border-0" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="Overview-tab" data-bs-toggle="tab"
                                           href="#Overview" role="tab" aria-controls="Overview"
                                           aria-selected="true">{{ __('Overview') }}</a>
                                    </li>
                                    @if($course->course_type == COURSE_TYPE_GENERAL)
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="Curriculum-tab" data-bs-toggle="tab"
                                               href="#Curriculum" role="tab" aria-controls="Curriculum"
                                               aria-selected="false">{{ __('Curriculum') }}</a>
                                        </li>
                                    @endif
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="Discussion-tab" data-bs-toggle="tab" href="#Discussion"
                                           role="tab" aria-controls="Discussion"
                                           aria-selected="false">{{ __('Discussion') }}</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="Review-tab" data-bs-toggle="tab" href="#Review"
                                           role="tab" aria-controls="Review"
                                           aria-selected="false">{{ __('Review') }}</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="Instructor-tab" data-bs-toggle="tab" href="#Instructor"
                                           role="tab" aria-controls="Review"
                                           aria-selected="false">{{ (count($course->course_instructors->where('status', STATUS_APPROVED)) > 1) ? __('Instructors') : __('Instructor') }}</a>
                                    </li>
                                </ul>
                            </div>
                            <!-- Tab panel nav list -->

                            <!-- Tab Content-->
                            <div class="tab-content" id="myTabContent">
                                @include('frontend.course.partial.partial-overview-tab')
                                @include('frontend.course.partial.partial-curriculum-tab')
                                @include('frontend.course.partial.partial-discussion-tab')
                                @include('frontend.course.partial.partial-review-tab')
                                @include('frontend.course.partial.partial-instructor-tab')
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-4">
                        <div class="course-single-details-right-content">
                            <div class="course-info-box bg-white">

                                <div
                                    class="video-area-left position-relative d-flex align-items-center justify-content-center">
                                    <div class="course-info-video-img"><img src="{{ getImageFile($course->image) }}"
                                                                            alt="video" class="img-fluid"></div>
                                    @if($course->intro_video_check == 1 && getVideoFile($course->video))
                                        <button type="button" class="play-btn position-absolute" data-bs-toggle="modal"
                                                data-bs-target="#newVideoPlayerModal">
                                            <img src="{{ asset('frontend/assets/img/icons-svg/play.svg') }}" alt="play">
                                        </button>

                                    @endif
                                    @if($course->intro_video_check == 2 && $course->youtube_video_id)
                                        <button type="button" class="play-btn position-absolute" id="intro-video-btn"
                                                data-video-id="{{$course->youtube_video_id}}">
                                            <img src="{{ asset('frontend/assets/img/icons-svg/play.svg') }}" alt="play">
                                        </button>
                                    @endif
                                </div>
                                @if($course->learner_accessibility == 'paid')
                                    <div class="course-price-box d-flex justify-content-between align-items-center mt-30 mb-30">
                                            <?php
                                            $startDate = date('d-m-Y H:i:s', strtotime(@$course->promotionCourse->promotion->start_date));
                                            $endDate = date('d-m-Y H:i:s', strtotime(@$course->promotionCourse->promotion->end_date));
                                            $percentage = @$course->promotionCourse->promotion->percentage;
                                            $discount_price = number_format($course->price - (($course->price * $percentage) / 100), 2);
                                            ?>

                                        @if(now()->gt($startDate) && now()->lt($endDate))
                                            <div>
                                                <h4 class="d-flex align-items-center mb-1">
                                                    @if(get_currency_placement() == 'after')
                                                        {{ $discount_price }} {{ get_currency_symbol() }}
                                                    @else
                                                        {{ get_currency_symbol() }} {{ $discount_price }}
                                                    @endif

                                                    <span class="text-decoration-line-through fw-normal font-16 color-gray ps-3">
                                                        @if(get_currency_placement() == 'after')
                                                            {{ $course->price }} {{ get_currency_symbol() }}
                                                        @else
                                                            {{ get_currency_symbol() }} {{ $course->price }}
                                                        @endif
                                                    </span>
                                                </h4>
                                                <span class="course-left-duration color-deep-orange font-14">
                                                    <span class="iconify me-2 font-18" data-icon="clarity:alarm-clock-line"></span>
                                                    {{ getLeftDuration($startDate, $endDate) }} {{ __('Left at this Price') }}!
                                                </span>
                                            </div>
                                            <div class="price-off font-12 font-medium color-hover px-3 d-flex align-items-center justify-content-center">{{ @$percentage }} % {{ __("off") }}</div>
                                        @elseif($course->price <= $course->old_price)
                                            <div>
                                                <h4 class="d-flex align-items-center mb-1">
                                                    @if(get_currency_placement() == 'after')
                                                        {{ $course->price }} {{ get_currency_symbol() }}
                                                    @else
                                                        {{ get_currency_symbol() }} {{ $course->price }}
                                                    @endif

                                                    <span class="text-decoration-line-through fw-normal font-16 color-gray ps-3">
                                                        @if(get_currency_placement() == 'after')
                                                            {{ $course->old_price }} {{ get_currency_symbol() }}
                                                        @else
                                                            {{ get_currency_symbol() }} {{ $course->old_price }}
                                                        @endif
                                                    </span>
                                                </h4>
                                            </div>
                                            @php
                                                $percentage = number_format(((($course->old_price - $course->price) / $course->old_price) * 100), 2);
                                            @endphp
                                            <div class="price-off font-12 font-medium color-hover px-3 d-flex align-items-center justify-content-center">{{ $percentage }} % {{ __("off") }}</div>
                                        @else
                                            <div>
                                                <h4 class="d-flex align-items-center mb-1">
                                                    @if(get_currency_placement() == 'after')
                                                        {{ $course->price }} {{ get_currency_symbol() }}
                                                    @else
                                                        {{ get_currency_symbol() }} {{ $course->price }}
                                                    @endif
                                                </h4>
                                            </div>
                                        @endif
                                    </div>
                                @elseif($course->learner_accessibility == 'free')
                                    <div
                                        class="course-price-box d-flex justify-content-between align-items-center mt-30 mb-30">
                                        <div>
                                            <h4 class="d-flex align-items-center mb-1">  {{ __('Free') }} </h4>
                                        </div>
                                    </div>
                                @endif

                                <div class="course-includes-box course-includes-box-top">
                                    <ul class="pb-30">
                                        <li class="d-flex justify-content-between">
                                            <div>
                                                <span class="iconify" data-icon="bytesize:clock"></span>
                                                <span>{{ __('Course Duration') }}</span>
                                            </div>
                                            @if($course->course_type == COURSE_TYPE_GENERAL)
                                                <div>{{ @$course->VideoDuration }}</div>
                                            @else
                                                <div>{{ @$course->scorm_course->duration }}</div>
                                            @endif
                                        </li>
                                        <li class="d-flex justify-content-between">
                                            <div>
                                                <span class="iconify" data-icon="carbon:increase-level"></span>
                                                <span>{{ __('Course Level') }}</span>
                                            </div>
                                            <div>{{ @$course->difficultyLevel->name }}</div>
                                        </li>
                                        <li class="d-flex justify-content-between">
                                            <div>
                                                <span class="iconify" data-icon="heroicons-outline:users"></span>
                                                <span>{{ __('Student Enrolled') }}</span>
                                            </div>
                                            <div>{{ @$total_course_students }}</div>
                                        </li>
                                        <li class="d-flex justify-content-between">
                                            <div>
                                                <span class="iconify" data-icon="cil:language"></span>
                                                <span>{{ __('Language') }}</span>
                                            </div>
                                            <div>{{ @$course->language->name }}</div>
                                        </li>
                                    </ul>
                                </div>

                                @if($course_exits == 'enrolled')
                                    <a href="{{ route('student.my-course.show', $course->slug) }}"
                                       class="theme-btn theme-button1 theme-button3 w-100 mb-30 ">
                                        {{ __('Go to Course') }}
                                        <i data-feather="arrow-right"></i>
                                    </a>
                                @elseif($course_exits == 'cartList')
                                    <button class="theme-btn theme-button1 theme-button3 w-100 mb-30">
                                        {{ __('Added to Cart') }}
                                    </button>
                                @else
                                    @if($course->status == STATUS_APPROVED)
                                        <button class="theme-btn theme-button1 theme-button3 w-100 mb-30 addToCart "
                                                data-course_id="{{ $course->id }}"
                                                data-route="{{ route('student.addToCart') }}">
                                            <span class="msgInfoChange">{{ __('Enroll the Course') }} <i
                                                    data-feather="arrow-right"></i></span>
                                        </button>

                                        @if($course->learner_accessibility != 'free' && get_option('cashback_system_mode', 0))
                                            <div class="alert alert-success d-flex mb-15">
                                                <div class="align-items-center d-flex mr-15">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                         class="feather feather-credit-card">
                                                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                                        <line x1="1" y1="10" x2="23" y2="10"></line>
                                                    </svg>
                                                </div>

                                                <div class="ml-10">
                                                    <div
                                                        class="font-14 font-weight-bold ">{{ __("Get Cashback") }}</div>
                                                    <div
                                                        class="font-12 ">{{ __("By purchasing this product, you will get")}}
                                                        @if($currencyPlacement ?? get_currency_placement() == 'after')
                                                            {{calculateCashback($course->price) }} {{ $currencySymbol ?? get_currency_symbol() }}
                                                        @else
                                                            {{ $currencySymbol ?? get_currency_symbol() }} {{calculateCashback($course->price) }}
                                                        @endif
                                                        {{ __("cashback") }}.
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                    @else
                                        <button class="bg-warning mb-30 theme-btn w-100">
                                            <span class="msgInfoChange">{{ __('Upcoming') }}</span>
                                        </button>
                                    @endif
                                @endif

                                @if(get_option('course_gift_mode', 0))
                                    <a href="{{ route('student.course-gift', $course->uuid) }}"
                                       class="alert alert-warning align-items-center border border-dark d-flex mb-30 p-2">
                                        <div class="mr-15">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-gift text-gray">
                                                <polyline points="20 12 20 22 4 22 4 12"></polyline>
                                                <rect x="2" y="7" width="20" height="5"></rect>
                                                <line x1="12" y1="22" x2="12" y2="7"></line>
                                                <path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path>
                                                <path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-5">
                                            <h4 class="font-14 font-weight-bold text-gray">{{ __("Gift this course") }}</h4>
                                            <p class="font-12 text-gray">{{ __("Send this course as a gift to your friends") }}</p>
                                        </div>
                                    </a>
                                @endif


                                <div class="course-info-box-wishlist-btns d-flex justify-content-between gap-2 mb-30">
                                    <button class="theme-btn para-color font-medium addToWishlist"
                                            title="Add to wishlist" data-course_id="{{ $course->id }}"
                                            data-route="{{ route('student.addToWishlist') }}"><span class="iconify me-2"
                                                                                                    data-icon="bytesize:heart"></span>{{ __('Add to Wishlist') }}
                                    </button>
                                    <button class="theme-btn para-color font-medium" title="Share this course"
                                            data-bs-toggle="modal" data-bs-target="#shareThisCourseModal"><span
                                            class="iconify me-2"
                                            data-icon="ci:share-outline"></span>{{ __('Share Course') }}</button>
                                </div>

                                <div class="course-includes-box mb-30">
                                    <h6 class="pb-30">{{ __('This Course Includes') }}</h6>
                                    <ul>
                                        @if($course->course_type == COURSE_TYPE_GENERAL)
                                            <li>
                                                <span class="iconify" data-icon="bi:camera-video"></span>
                                                <span>{{@$course->lectures->count() > 0 ? @$course->video_duration : '0'}} {{ __('Video Lectures') }}</span>
                                            </li>
                                        @endif
                                        <li>
                                            <span class="iconify"
                                                  data-icon="healthicons:i-exam-multiple-choice-outline"></span>
                                            <span>{{ @$course->quizzes->count() }} {{ __('Quizzes') }}</span>
                                        </li>
                                        <li>
                                            <span class="iconify" data-icon="bi:book"></span>
                                            <span>{{ @$course->assignments->count() }} {{ __('Assignments') }}</span>
                                        </li>
                                        <li>
                                            <span class="iconify" data-icon="akar-icons:download"></span>
                                            <span>{{ @$course->resources->count() }} {{ __('Downloadable Resources') }}</span>
                                        </li>
                                        <li>
                                            <span class="iconify" data-icon="bytesize:clock"></span>
                                            <span>{{ (!$course->access_period) ? __('Full Lifetime Access') : $course->access_period.' '.__('days after the enrollment') }}</span>
                                        </li>
                                        <li>
                                            <span class="iconify" data-icon="lucide:award"></span>
                                            <span>{{ __('Certificate of Completion') }}</span>
                                        </li>
                                    </ul>
                                </div>

                                @if(@Auth::user() && Auth::user()->is_affiliator == AFFILIATOR && get_option('referral_status'))
                                    <div class="course-info-box-affiliate-link-copy position-relative">
                                        <h6 class="pb-20">Affiliate Link:</h6>
                                        <div class="input-group">
                                            <input id="ref_link" class="form-control w-100" value="{{ $ref_link }}"/>
                                            <button type="button"
                                                    class="btn affiliate-copy-btn border-0 position-absolute"
                                                    onclick="copyToClipboard('ref_link')"
                                                    title="{{ __('Copy to Clipboard') }}">
                                                <i class="fa fa-copy"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Course Single Details Area End -->
    </div>

    <!--Share This Course Modal Start-->
    <div class="modal fade" id="shareThisCourseModal" tabindex="-1" aria-labelledby="shareThisCourseModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="shareThisCourseModalLabel">{{ __('Share This Course') }}</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="share-course-list">
                        <li><a href="http://www.facebook.com/sharer.php?u={{ route('course-details', $course->slug) }}"><span
                                    class="iconify" data-icon="cib:facebook-f"></span></a></li>
                        <li><a href="https://twitter.com/share?url={{ route('course-details', $course->slug) }}"><span
                                    class="iconify" data-icon="el:twitter"></span></a></li>
                        <li>
                            <a href="https://www.linkedin.com/shareArticle?url={{ route('course-details', $course->slug) }}"><span
                                    class="iconify" data-icon="cib:linkedin-in"></span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--Share This Course Modal End-->

    <input type="hidden" class="courseReviewPaginateRoute" value="{{ route('frontend.reviewPaginate', $course->id) }}">

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
                        @if($course->intro_video_check == 1 && getVideoFile($course->video))
                            <!-- HTML 5 Video -->
                            <video id="player2" playsinline controls data-poster="{{ getImageFile($course->image) }}"
                                   controlsList="nodownload">
                                <source src="{{ getVideoFile($course->video) }}" type="video/mp4">
                            </video>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- New Video Player Modal End-->

    <!-- New Video Player Modal Start-->
    <div class="modal fade VideoTypeModal" id="youtubeVideoPlayerModal" tabindex="-1"
         aria-labelledby="youtubeVideoPlayerModal" aria-hidden="true">

        <div class="modal-header border-bottom-0">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span class="iconify"
                                                                                                     data-icon="akar-icons:cross"></span>
            </button>
        </div>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="video-player-area">
                        <div class="youtube-player">
                            <div id="youtube-player-video" class="youtube-video"></div>
                            <button class="youtube-video-overBtn"><i class="fa fa-play"></i></button>
                            <div class="youtube-player-controls">
                                <button class="play-button">
                                    <i class="fa fa-play"></i>
                                </button>
                                <progress class="progress-bar" min="0" max="100" value="0"></progress>
                                <span class="progress-text"></span>

                                <button class="sound-button">
                                    <i class="fa fa-volume-up"></i>
                                </button>
                                <progress class="sound-bar" min="0" max="100" value="0"></progress>
                                <button class="fullscreen-button">
                                    <i class="fa fa-expand"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- New Video Player Modal End-->

    <!--  Text Upload Modal Start -->
    <div class="modal fade textUploadModal venoBoxTypeModal" id="textUploadModal" tabindex="-1" aria-hidden="true">
        <div class="modal-header border-bottom-0">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span class="iconify"
                                                                                                     data-icon="akar-icons:cross"></span>
            </button>
        </div>
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="getLectureText"></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Text Upload Modal End -->

    <!-- Image Upload Modal Start -->
    <div class="modal fade textUploadModal venoBoxTypeModal" id="imageUploadModal" tabindex="-1" aria-hidden="true">
        <div class="modal-header border-bottom-0">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span class="iconify"
                                                                                                     data-icon="akar-icons:cross"></span>
            </button>
        </div>
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="" alt="" class="img-fluid getLectureImage">
                </div>
            </div>
        </div>
    </div>
    <!-- Image Upload Modal End -->

    <!-- Slide Show Upload Modal Start-->
    <div class="modal fade venoBoxTypeModal" id="slideModal" tabindex="-1" aria-hidden="true">
        <div class="modal-header border-bottom-0">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span class="iconify"
                                                                                                     data-icon="akar-icons:cross"></span>
            </button>
        </div>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <iframe class="getLectureSlide" src="" width="100%" height="400" frameborder="0"
                            scrolling="no"></iframe>
                </div>
            </div>
        </div>
    </div>
    <!-- Slide Show Upload Modal End-->

    <!-- Audio Player Modal Start-->
    <div class="modal fade venoBoxTypeModal" id="audioPlayerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-header border-bottom-0">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span class="iconify"
                                                                                                     data-icon="akar-icons:cross"></span>
            </button>
        </div>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <!--Audio -->
                    <audio class="getLectureAudio" src="" type="audio/mp3" style="width: 550px" controls
                           controlsList="nodownload">
                    </audio>
                </div>
            </div>
        </div>
    </div>
    <!-- Audio Player Modal End-->
@endsection

@push('style')
    <!-- Video Player css -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendor/video-player/plyr.css') }}">
@endpush

@push('script')
    <script src="{{ asset('frontend/assets/js/course/addToCart.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/course/addToWishlist.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/course/course-review-paginate.js') }}"></script>

    <!--Tinymce js-->
    <script src="{{ asset('frontend/assets/js/tinymce.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/tinymce-script.js') }}"></script>

    <!-- Video Player js -->
    <script src="{{ asset('frontend/assets/vendor/video-player/plyr.js') }}"></script>
    <script>
        // const zai_player = new Plyr('#player');
        // const zai_player2 = new Plyr('#youtubePlayer');
        const zai_player1 = new Plyr('#player2');
        // const zai_player3 = new Plyr('#youtubePlayer2');
        // const zai_player4 = new Plyr('#vimeoPlayer');
    </script>

    <script>
        (function() {
            const devtools = {
                isOpen: false,
                orientation: undefined,
            };
            const threshold = 160;
            const emitEvent = (isOpen, orientation) => {
                window.dispatchEvent(new CustomEvent('devtoolschange', {
                    detail: {
                        isOpen,
                        orientation
                    }
                }));
            };
            setInterval(() => {
                const widthThreshold = window.outerWidth - window.innerWidth > threshold;
                const heightThreshold = window.outerHeight - window.innerHeight > threshold;
                const orientation = widthThreshold ? 'vertical' : 'horizontal';
                if (!(heightThreshold && widthThreshold) && ((window.Firebug && window.Firebug.chrome && window.Firebug.chrome.isInitialized) || widthThreshold || heightThreshold)) {
                    if (!devtools.isOpen || devtools.orientation !== orientation) {
                        emitEvent(true, orientation);
                    }
                    devtools.isOpen = true;
                    devtools.orientation = orientation;
                } else {
                    if (devtools.isOpen) {
                        emitEvent(false, undefined);
                    }
                    devtools.isOpen = false;
                    devtools.orientation = undefined;
                }
            }, 500);

            function isDesktopDevice() {
                return !/Mobi|Android|iPhone|iPad|iPod/i.test(navigator.userAgent);
            }

            if (isDesktopDevice()) {
                window.addEventListener('devtoolschange', function (e) {
                    if (e.detail.isOpen) {
                        location.replace('/'); // Redirect the user
                    }
                });
            }


            // Disable copying URL from iframe by adding sandbox restrictions
            document.querySelectorAll('iframe').forEach(function(iframe) {
                iframe.setAttribute('sandbox', 'allow-scripts allow-same-origin allow-presentation');
            });
        })();
    </script>

    <script>
        const players = Array.from(document.querySelectorAll('.js-player')).map((p) => new Plyr(p));
    </script>
    <!-- Video Player js -->

    <script>
        "use strict"
        $('.lectureText').on('click', function () {
            var text = $(this).data("lecture_text")
            $('.getLectureText').html(text)
        })

        $('.lectureImage').on('click', function () {
            var image = $(this).data("lecture_image")
            $('.getLectureImage').attr('src', image)
        })

        $('.lectureSlide').on('click', function () {
            var slide = $(this).data("lecture_slide")
            $('.getLectureSlide').attr('src', slide)
        })

        $('.normalVideo').on('click', function () {
            var video = $(this).data("normal_video")
            console.log(video)
            $('.getNormalVideo').attr('src', video)
        })

        $('.lectureAudio').on('click', function () {
            var audio = $(this).data("lecture_audio")
            console.log(audio)
            $('.getLectureAudio').attr('src', audio)
        })

        function copyToClipboard(elem) {
            // Get the text field
            var copyText = document.getElementById(elem);

            // Select the text field
            copyText.select();
            copyText.setSelectionRange(0, 99999); // For mobile devices

            // Copy the text inside the text field
            navigator.clipboard.writeText(copyText.value);

        }

        var url = new URL(window.location.href);
        var code = url.searchParams.get("code");
        if (code && code.length > 0) {
            saveItem(code);
        }

        function saveItem(val) {
            if (val === null) {
                return;
            }
            var all_ref = localStorage.getItem('ref')

            if (all_ref === '' || all_ref == null) {
                localStorage.setItem('ref', JSON.stringify([code]));
                return;
            }
            all_ref = JSON.parse(all_ref);
            if (!all_ref.includes(val)) {
                all_ref.push(val)
                localStorage.setItem('ref', JSON.stringify(all_ref));
            }
        }

    </script>

    <script>

        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        var player,
            youtube_player = document.querySelector('.youtube-player'),
            controls_bar = document.querySelector('.youtube-player-controls'),
            play_button = document.querySelector('.play-button'),
            video_play_button = document.querySelector('.youtube-video-overBtn'),
            progress_bar = document.querySelector('.progress-bar'),
            progress_text = document.querySelector('.progress-text'),
            sound_button = document.querySelector('.sound-button'),
            sound_bar = document.querySelector('.sound-bar'),
            full_screen_button = document.querySelector('.fullscreen-button'),
            y_progress_timer,
            progressDrag = false,
            soundDrag = false,
            isClicking = false,
            isInFullscreen = false,
            click_timer,
            show_controls_timer,
            hide_controls_timer;

        // Initialize the YouTube Player with a given video ID
        function initYoutubePlayer(videoId) {
            // If a player already exists, destroy it before creating a new one
            if (player && player.destroy) {
                clearInterval(y_progress_timer); // Stop any existing timers
                player.destroy(); // Destroy the current player instance
            }

            // Create a new player instance with the provided video ID
            player = new YT.Player('youtube-player-video', {
                width: 853,
                height: 480,
                videoId: videoId,
                playerVars: {
                    autoplay: 1,
                    controls: 0,
                    showinfo: 0
                },
                events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange
                }
            });
        }

        function onPlayerReady(e) {
            // Initialize controls and player settings
            player.setVolume(70);
            sound_bar.value = 70;
            progress_text.innerHTML = "00:00:00";
            player.setPlaybackQuality('hd1080');

            // Show / Hide controls
            youtube_player.addEventListener('mouseenter', showControls);
            youtube_player.addEventListener('mouseleave', hideControls);

            // Play / Pause functionality
            play_button.addEventListener('click', togglePlayPause);
            video_play_button.addEventListener('click', togglePlayPause);

            // Drag and drop functionality for the progress bar
            progress_bar.addEventListener('mousedown', function (e) {
                progressDrag = true;
            });
            document.addEventListener('mouseup', function (e) {
                if (progressDrag) {
                    setProgress(e);
                    progressDrag = false;
                }
                if (soundDrag) {
                    soundDrag = false;
                    setVolume(e);
                }
            });
            document.addEventListener('mousemove', function (e) {
                if (progressDrag) {
                    setProgress(e);
                }
                if (soundDrag) {
                    setVolume(e);
                }
            });

            // Click on progress bar to change progress
            progress_bar.addEventListener('click', updateProgress);

            // Mute/unmute functionality
            sound_button.addEventListener('click', toggleMute);

            // Volume change functionality
            sound_bar.addEventListener('mousedown', function (e) {
                soundDrag = true;
            });
            sound_bar.addEventListener('click', setVolume);

            // Fullscreen functionality
            full_screen_button.addEventListener('click', function () {
                var requestFullScreen = youtube_player.requestFullscreen ||
                    youtube_player.mozRequestFullScreen ||
                    youtube_player.webkitRequestFullscreen ||
                    youtube_player.msRequestFullscreen;
                if (requestFullScreen) {
                    requestFullScreen.call(youtube_player);
                    full_screen_button.style.display = 'none'; // Hide the fullscreen button while in fullscreen mode
                }
            });

            // Listen for fullscreen exit events
            document.addEventListener('fullscreenchange', onFullScreenExit);
            document.addEventListener('webkitfullscreenchange', onFullScreenExit);
            document.addEventListener('mozfullscreenchange', onFullScreenExit);
            document.addEventListener('MSFullscreenChange', onFullScreenExit);

            launch_y_progress_timer(); // Start the progress timer
        }

        // Handle exiting fullscreen mode
        function onFullScreenExit() {
            if (!document.fullscreenElement && !document.mozFullScreenElement &&
                !document.webkitFullscreenElement && !document.msFullscreenElement) {
                full_screen_button.style.display = 'block'; // Show fullscreen button after exit
            }
        }

        // Update player state when play/pause/ended occurs
        function onPlayerStateChange(e) {
            if (e.data == YT.PlayerState.PLAYING) {
                play_button.innerHTML = '<i class="fa fa-pause"></i>';
                video_play_button.style.opacity = 0;
            } else if (e.data == YT.PlayerState.PAUSED) {
                play_button.innerHTML = '<i class="fa fa-play"></i>';
                video_play_button.style.opacity = 1;
            } else if (e.data == YT.PlayerState.ENDED) {
                player.stopVideo(); // Stop video at the end
                play_button.innerHTML = '<i class="fa fa-play"></i>';
                video_play_button.style.opacity = 1;
                showControls(); // Show controls when the video ends
            }
        }

        // Event handler for play/pause button
        function togglePlayPause() {
            var play_state = player.getPlayerState();
            if (play_state == -1 || play_state == 0 || play_state == 2 || play_state == 5) {
                player.playVideo();
            } else if (play_state == 1) {
                player.pauseVideo();
            }
        }

        // Show the controls bar
        function showControls() {
            if (isClicking || controls_bar.style.opacity == 1) return false;

            var opacity = 0,
                current_time = 0,
                duration = 300;

            clearInterval(show_controls_timer);
            show_controls_timer = setInterval(function () {
                controls_bar.style.opacity = opacity;

                opacity += .05;
                current_time += 16;
                if (opacity >= 1 && current_time >= duration) {
                    controls_bar.style.opacity = 1;
                    clearInterval(show_controls_timer);
                    return false;
                }
            }, 16);
        }

        // Hide the controls bar
        function hideControls() {
            if (isClicking || controls_bar.style.opacity == 0 || player.getCurrentTime() == player.getDuration() || (player.getCurrentTime() == 0 && player.getPlayerState() == 2)) return false;

            var opacity = 1,
                current_time = 0,
                duration = 300;

            clearInterval(hide_controls_timer);
            hide_controls_timer = setInterval(function () {
                controls_bar.style.opacity = opacity;

                opacity -= .05;
                current_time += 16;
                if (opacity <= 0 && current_time >= duration) {
                    controls_bar.style.opacity = 0;
                    clearInterval(hide_controls_timer);
                    return false;
                }
            }, 16);
        }

        // Progress timer function to keep the progress bar in sync with the video
        function launch_y_progress_timer() {
            clearInterval(y_progress_timer);
            y_progress_timer = setInterval(updateProgress, 500);
        }

        // Function to update the progress bar and time display
        function updateProgress() {
            if (player && player.getDuration()) {
                var percentage = Math.floor((100 / player.getDuration()) * player.getCurrentTime());
                if (typeof percentage != 'undefined') {
                    progress_bar.value = percentage;

                    // Get current time and total duration
                    var currentTime = player.getCurrentTime();
                    var totalTime = player.getDuration();

                    // Format both times
                    var currentTimeFormatted = formatTime(currentTime);
                    var totalTimeFormatted = formatTime(totalTime);

                    // Update progress text to show current time / total time
                    progress_text.innerHTML = currentTimeFormatted + ' / ' + totalTimeFormatted;
                }
            }
        }

        // Function to format time for the progress display
        function formatTime(time) {
            var hours = Math.floor(time / 3600);
            var minutes = Math.floor((time - (hours * 3600)) / 60);
            var seconds = Math.floor(time - (hours * 3600) - (minutes * 60));

            var result = hours < 10 ? '0' + hours : hours;
            result += ':';
            result += minutes < 10 ? '0' + minutes : minutes;
            result += ':';
            result += seconds < 10 ? '0' + seconds : seconds;

            return result;
        }

        // Toggle mute and unmute
        function toggleMute() {
            launch_click_timer();
            if (player.isMuted()) {
                player.unMute(); // Unmute the player
                updateVolume_controls(player.getVolume()); // Update volume bar to the current volume
            } else {
                player.mute(); // Mute the player
                updateVolume_controls(0); // Set volume bar to 0 when muted
            }
        }

        // Function to set the volume based on the user's interaction with the volume bar
        function setVolume(e) {
            var offsetLeft = sound_bar.getBoundingClientRect().left;
            var position = e.pageX - offsetLeft;
            var volume = position / sound_bar.clientWidth * 100;

            if (volume < 10) {
                volume = 0;
            }
            if (player.isMuted()) {
                player.unMute();
            }

            player.setVolume(volume);
            updateVolume_controls(volume);
        }

        // Function to update the volume button and sound bar UI
        function updateVolume_controls(volume) {
            if (volume == 0) {
                sound_button.innerHTML = '<i class="fa fa-volume-mute"></i>';
            } else if (volume < 50) {
                sound_button.innerHTML = '<i class="fa fa-volume-down"></i>';
            } else {
                sound_button.innerHTML = '<i class="fa fa-volume-up"></i>';
            }

            sound_bar.value = volume;
        }

        function setProgress(e) {
            var offsetLeft = progress_bar.getBoundingClientRect().left;
            var position = e.pageX - offsetLeft;
            var percentage = 100 * position / progress_bar.clientWidth;

            if (percentage > 100) {
                percentage = 100;
            }
            if (percentage < 0) {
                percentage = 0;
            }

            var newTime = player.getDuration() * percentage / 100;
            player.seekTo(newTime); // Seek to the new time based on the percentage
        }


        // Set up event listeners to initialize a video on click
        $(document).on('click', '.youtube-player-btn', function () {
            $('#youtubeVideoPlayerModal').modal('toggle');
            var videoId = $(this).data('video-id');
            initYoutubePlayer(videoId);
        });

        $(document).on('click', '#intro-video-btn', function () {
            $('#youtubeVideoPlayerModal').modal('toggle');
            var videoId = $(this).data('video-id');
            initYoutubePlayer(videoId);
        });

    </script>

@endpush
