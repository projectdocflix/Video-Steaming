@extends('frontend.layouts.app')

@section('content')
@if(!empty(get_option('certificate_regular')) && get_option('certificate_regular') != '' )
@push('style')
<style>
    .certificateFont {
        @font-face {
            font-family: "certificateFont";
            url: {{ asset(get_option('certificate_font')) }},
        }
    }
</style>
@endpush
@endif
<div class="bg-page">
    <!-- Page Header Start -->
    <header class="page-banner-header blank-page-banner-header gradient-bg position-relative">
        <div class="section-overlay">
            <div class="blank-page-banner-wrap">
                <div class="container">
                    <div class="justify-content-center row">
                        <div class="col-12 col-sm-12 col-md-12">
                            <div class="page-banner-content text-center">
                                <h3 class="page-banner-heading color-heading pb-15">{{ __($course->title) }}</h3>

                                <!-- Course Watch Banner Start-->
                                <ul class="course-watch-banner-items">
                                    <li
                                        class="font-14 font-medium color-heading {{ $course->course_type == COURSE_TYPE_GENERAL ? '' : 'd-none' }}">
                                        <span class="iconify me-2" data-icon="carbon:video"></span>{{
                                        @$course->lectures->count() }}
                                        {{ __('Lectures') }}
                                    </li>
                                    <li
                                        class="font-14 font-medium color-heading {{ $course->course_type == COURSE_TYPE_GENERAL ? '' : 'd-none' }}">
                                        <span class="iconify me-2" data-icon="akar-icons:book"></span>{{
                                        @$course->lessons->count() }}
                                        {{ __('sections') }}
                                    </li>
                                    <li class="font-14 font-medium color-heading"><span class="iconify me-2"
                                            data-icon="ant-design:clock-circle-outlined"></span>
                                        @if($course->course_type == COURSE_TYPE_GENERAL)
                                        {{@$course->lectures->count() > 0 ? @$course->video_duration : '0 min'}}
                                        @else
                                        {{@$course->scorm_course->duration ? $course->scorm_course->duration : '0 min'}}
                                        @endif
                                    </li>
                                </ul>
                                <!-- Course Watch Banner End-->
                            </div>
                        </div>

                        @if($course->course_type == COURSE_TYPE_SCORM )
                        <div class="review-progress-bar-wrap w-auto">
                            <!-- Progress Bar -->
                            <div class="barras mb-4">
                                <div class="progress-bar-box">
                                    <div
                                        class="progress-hint-value font-14 color-heading d-flex justify-content-between">
                                        <p class="font-20 font-medium color-heading">{{ __('Progress') }}</p>
                                        <span class="font-15">{{number_format(studentCourseProgress(@$course->id, @$enrollment->id),
                                            2)}}% {{__('Done')}}</span>
                                    </div>
                                    <div class="barra">
                                        <div class="barra-nivel" data-nivel="{{studentCourseProgress(@$course->id, @$enrollment->id)}}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Page Header End -->

    <!-- Course Single Details Area Start -->
    <section class="course-single-details-area course-watch-page-area">
        <div class="container-fluid">
            @if($course->course_type == COURSE_TYPE_GENERAL)
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12 col-xl-7 col-xxl-8">
                    @if(@$lecture_type)
                    <!-- My Code Start -->

                    @if(@$lecture_type == 'youtube')
                    <div class="video-player-area">
                        <div class="youtube-player">
                            <div id="youtube-player-video" class="youtube-video" data-video-id="{{ @$youtube_video_src }}"></div>

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
                    @elseif(@$lecture_type == 'vimeo')
                    <div class="video-player-area">
                        <div class="plyr__video-embed" id="playerVideoVimeo">
                            <iframe
                                src="https://player.vimeo.com/video/{{ @$vimeo_video_src }}?loop=false&amp;byline=false&amp;portrait=false&amp;title=false&amp;speed=true&amp;transparent=0&amp;gesture=media"
                                allowfullscreen allowtransparency allow="autoplay"></iframe>
                        </div>
                    </div>
                    @elseif(@$lecture_type == 'video')
                    <div class="video-player-area">
                        <video id="player" class="myVideo" playsinline controls controlsList="nodownload">
                            <source src="{{ getVideoFile(@$video_src) }}" type="video/mp4" >
                        </video>
                    </div>
                    @elseif(@$lecture_type == 'text')
                    <p>{!! @$text_src !!}</p>
                    @elseif(@$lecture_type == 'image')
                    <img src="{{ getImageFile(@$image_src) }}" alt="" class="img-fluid">
                    @elseif(@$lecture_type == 'pdf')
                    <embed src=" {{ getImageFile($pdf_src) }}" class="pdf-reader-frame">
                    @elseif(@$lecture_type == 'slide_document')
                    <iframe src="{{ @$slide_document_src }}" width="100%" height="400" frameborder="0"
                        scrolling="no"></iframe>
                    @elseif(@$lecture_type == 'audio')
                    <audio id="audioplayer" class="myVideo" controls>
                        <source src="{{ getVideoFile(@$audio_src) }}" type="audio/mp3" >
                    </audio>
                    @endif

                    <!-- My Code End -->
                    @else
                    @if($course->intro_video_check == 1 && getVideoFile($course->video))
                    <div class="video-player-area">
                        <video id="player1" playsinline controls data-poster="{{ getImageFile($course->image) }}"
                            controlsList="nodownload">
                            <source src="{{ getVideoFile(@$course->video) }}" type="video/mp4" >
                        </video>
                    </div>
                    @elseif($course->intro_video_check == 2 && $course->youtube_video_id)
                    <div class="video-player-area">
                        <div class="youtube-player">
                            <div id="youtube-player-video" class="youtube-video" data-video-id="{{ @$youtube_video_src }}"></div>

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
                    @else
                    <div class="course-watch-no-video-img">
                        <img src="{{ getImageFile($course->image) }}" alt="" class="w-100 img-fluid">
                    </div>
                    @endif
                    @endif

                </div>

                <div class="col-12 col-md-12 col-lg-12 col-xl-5 col-xxl-4">
                    <div class="course-single-details-right-content course-watch-right-content mt-0">
                        <div class="curriculum-content course-watch-right-side">

                            <div class="review-progress-bar-wrap">
                                <!-- Progress Bar -->
                                <div class="barras mb-4">
                                    <div class="progress-bar-box">
                                        <div
                                            class="progress-hint-value font-14 color-heading d-flex justify-content-between">
                                            <p class="font-20 font-medium color-heading">{{ __('Course Content') }}</p>
                                            <span class="font-15">{{number_format(studentCourseProgress(@$course->id, @$enrollment->id),
                                                2)}}% Done</span>
                                        </div>
                                        <div class="barra">
                                            <div class="barra-nivel"
                                                data-nivel="{{studentCourseProgress(@$course->id, @$enrollment->id)}}%"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="course-watch-right-accordion-wrap custom-scrollbar">
                                <div class="accordion" id="accordionExample1">
                                    @php
                                    $lockCount = 0;
                                    @endphp
                                    @forelse(@$course->lessons as $key => $lesson)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading{{ $key }}">
                                            <button
                                                class="accordion-button font-medium font-18 d-flex justify-content-between {{ @$lesson_id_check == $lesson->id ?  '' : 'collapsed' }}"
                                                type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse{{ $key }}"
                                                aria-expanded="{{ @$lesson_id_check == $lesson->id ?  true : false }}"
                                                aria-controls="collapse{{ $key }}">
                                                <span class="px-2">{{ $lesson->name }}</span>

                                                <span class="watch-course-title-right-btns d-flex">
                                                    <span class="font-12 color-gray2 mx-2"><span
                                                            class="iconify font-16 color-orange me-1"
                                                            data-icon="akar-icons:clock"></span>{{
                                                        count($lesson->lectures) }} lectures</span>
                                                    <span class="font-12 color-gray2 mx-2"><span
                                                            class="iconify font-16 color-orange me-1"
                                                            data-icon="carbon:video"></span>
                                                        {{@$lesson->lectures->count() > 0 ?
                                                        lessonVideoDuration($course->id, $lesson->id) : '0 min'}}
                                                    </span>
                                                </span>
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $key }}"
                                            class="accordion-collapse collapse {{ @$lesson_id_check == $lesson->id ?  'show' : '' }}"
                                            aria-labelledby="heading{{ $key }}" data-bs-parent="#accordionExample1">
                                            <div class="accordion-body">
                                                <div class="play-list">

                                                    @forelse($lesson->lectures as $lecture)
                                                    <!-- Play List Item Start-->
                                                    @php
                                                    $lock = checkStudentCourseIsLock($course_lecture_views, $course, $lecture, $enrollment, $loop->first);
                                                    @endphp
                                                    <div
                                                        class="play-list-item @if(checkStudentCourseView($course_lecture_views, $course->id, $lecture->id)) watchFinishedCourse @elseif($lecture->id == @$lecture_id_check) watchContinuingCourse @endif d-flex align-items-center justify-content-between font-15">
                                                        <div class="play-list-left d-flex align-items-center">
                                                            <div>
                                                                @if($lecture->id == @$lecture_id_check)
                                                                <span class="iconify font-17"
                                                                    data-icon="fluent:radio-button-24-filled"></span>
                                                                @elseif(checkStudentCourseView($course_lecture_views,
                                                                $course->id,
                                                                $lecture->id))
                                                                <span class="iconify font-17"
                                                                    data-icon="ant-design:check-circle-filled"></span>
                                                                @else
                                                                <span class="iconify font-17"
                                                                    data-icon="fluent:radio-button-24-regular"></span>
                                                                @endif
                                                            </div>
                                                            @if($lock)
                                                            <span>
                                                                <p class="ps-2">{{ $lecture->title }}</p>
                                                            </span>
                                                            @else
                                                            <a
                                                                href="{{ route('student.my-course.show', [$course->slug, 'lecture_uuid' => $lecture->uuid]) }}">
                                                                <p class="ps-2">{{ $lecture->title }}</p>
                                                            </a>
                                                            @endif
                                                        </div>
                                                        <div class="play-list-right d-flex">
                                                            @if($lock)
                                                            <span class="video-time-count"><span class="iconify me-5"
                                                                    data-icon="ant-design:lock-outlined"></span>{{
                                                                $lecture->file_duration }}</span>
                                                            @else
                                                            <span class="video-time-count">{{ $lecture->file_duration
                                                                }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <!-- Play List Item End-->
                                                    @empty
                                                    <div class="row">
                                                        <p>{{ __('No Data Found') }}!</p>
                                                    </div>
                                                    @endforelse

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="row">
                                        <p>{{ __('No Data Found') }}!</p>
                                    </div>
                                    @endforelse

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            @else

            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <iframe id="scorm_player" class="scorm-content" frameBorder="0" src="{{ asset("scorm/".$course->scorm_course->uuid.'/'.$course->scorm_course->entry_url)
                        }}"
                        width="100%" title="Scorm course"></iframe>
                </div>
            </div>
            @endif
            <div class="row">
                <div
                    class="col-12 col-md-12 col-lg-12 {{ $course->course_type == COURSE_TYPE_GENERAL ? 'col-xl-7 col-xxl-8' : '' }}">
                    <div class="course-watch-inner-title-wrap d-flex justify-content-between mt-30">
                        <div class="course-watch-inner-title-left-part">
                            <h4 class="mb-3 lectureName">{{__('Introduction')}}</h4>
                            <div class="course-watch-enrolled-wrap d-flex">
                                <ul>
                                    @foreach($enrolled_students as $enrolled_student)
                                    <li><img src="{{ getImageFile(@$enrolled_student->user->image_path) }}" alt=""></li>
                                    @endforeach
                                </ul>
                                <div class="enrolled-count font-12 ms-2"><span class="color-heading font-medium">{{
                                        $total_enrolled_students }}</span> <span
                                        class="d-block text-uppercase">{{__('Enrolled')}}</span></div>
                            </div>

                        </div>
                        <div class="course-watch-inner-title-right-part">
                            <!-- Button trigger modal -->
                            <button type="button" class="bg-transparent theme-btn color-heading mb-3"
                                data-bs-toggle="modal" data-bs-target="#writeReviewModal">{{__('Write a review')}}
                            </button>
                            <div class="publish-update-time text-end">
                                <h6 class="font-14">{{__('Last update')}}</h6>
                                <p class="font-12">{{ $course->updated_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="course-single-details-left-content mt-0">

                        <!-- Tab panel nav list -->
                        <div class="course-tab-nav-wrap course-details-tab-nav-wrap d-flex justify-content-between student-courseDetails-tab">
                            <ul class="nav nav-tabs tab-nav-list border-0 student-courseDetails-tabItems" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link text-uppercase {{!$action_type ? 'active' : '' }}"
                                        id="Overview-tab" data-bs-toggle="tab" href="#Overview" role="tab"
                                        aria-controls="Overview" aria-selected="true">{{__('Overview')}}</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link text-uppercase" id="Resources-tab" data-bs-toggle="tab"
                                        href="#Resources" role="tab" aria-controls="Resources"
                                        aria-selected="true">{{__('Resources')}}</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link text-uppercase" id="Review-tab" data-bs-toggle="tab"
                                        href="#Review" role="tab" aria-controls="Review"
                                        aria-selected="false">{{__('Review')}}</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link text-uppercase {{$action_type ? 'active' : '' }}" id="Quiz-tab"
                                        data-bs-toggle="tab" href="#Quiz" role="tab" aria-controls="Quiz"
                                        aria-selected="false">{{__('Quiz')}}</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link text-uppercase" id="Assignment-tab" data-bs-toggle="tab"
                                        href="#Assignment" role="tab" aria-controls="Quiz"
                                        aria-selected="false">{{__('Assignment')}}</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link text-uppercase" id="Notice-tab" data-bs-toggle="tab"
                                        href="#Notice" role="tab" aria-controls="Notice"
                                        aria-selected="false">{{__('Notice')}}</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link text-uppercase text-nowrap" id="LiveClass-tab" data-bs-toggle="tab"
                                        href="#LiveClass" role="tab" aria-controls="LiveClass"
                                        aria-selected="false">{{__('Live Class')}}</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link text-uppercase" id="Discussion-tab" data-bs-toggle="tab"
                                        href="#Discussion" role="tab" aria-controls="Discussion"
                                        aria-selected="false">{{__('Discussion')}}</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link text-uppercase" id="Certificate-tab" data-bs-toggle="tab"
                                        href="#Certificate" role="tab" aria-controls="Certificate"
                                        aria-selected="false">{{__('Certificate')}}</a>
                                </li>
                            </ul>
                        </div>
                        <!-- Tab panel nav list -->

                        <!-- Tab Content-->
                        <div class="tab-content" id="myTabContent">
                            @include('frontend.student.course.partial.partial-overview-tab')
                            @include('frontend.student.course.partial.partial-resources-tab')
                            @include('frontend.student.course.partial.partial-review-tab')
                            @include('frontend.student.course.partial.partial-quiz-tab')
                            @include('frontend.student.course.partial.partial-assignment-tab')
                            @include('frontend.student.course.partial.partial-notice-tab')
                            @include('frontend.student.course.partial.partial-liveclass-tab')
                            @include('frontend.student.course.partial.partial-discussion-tab')
                            @include('frontend.student.course.partial.partial-certificate-tab')
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Course Single Details Area End -->

    <!--Write Review Modal Start-->
    <div class="modal fade" id="writeReviewModal" tabindex="-1" aria-labelledby="writeReviewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="writeReviewModalLabel">{{__('Write a Review')}}</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row mb-4">
                            <div class="col-md-12 text-center">
                                <div class="btn-group give-rating-group" role="group"
                                    aria-label="Basic checkbox toggle button group">
                                    <input type="checkbox" class="btn-check" id="btncheck1" name="rating">
                                    <label class="give-rating-star" for="btncheck1"><span class="iconify"
                                            data-icon="bi:star-fill"></span></label>

                                    <input type="checkbox" class="btn-check" id="btncheck2" name="rating">
                                    <label class="give-rating-star" for="btncheck2"><span class="iconify"
                                            data-icon="bi:star-fill"></span></label>

                                    <input type="checkbox" class="btn-check" id="btncheck3" name="rating">
                                    <label class="give-rating-star" for="btncheck3"><span class="iconify"
                                            data-icon="bi:star-fill"></span></label>

                                    <input type="checkbox" class="btn-check" id="btncheck4" name="rating">
                                    <label class="give-rating-star" for="btncheck4"><span class="iconify"
                                            data-icon="bi:star-fill"></span></label>

                                    <input type="checkbox" class="btn-check" id="btncheck5" name="rating">
                                    <label class="give-rating-star" for="btncheck5"><span class="iconify"
                                            data-icon="bi:star-fill"></span></label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-30">
                            <div class="col-md-12">
                                <label class="font-medium font-15 color-heading">{{__('Feedback')}}</label>
                                <textarea class="form-control feedback" id="exampleFormControlTextarea1" rows="3"
                                    placeholder="Please write your feedback here"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-between align-items-center">
                    <button type="button" class="theme-btn theme-button3" data-bs-dismiss="modal">{{__('Cancel')}}</button>
                    <button type="button" class="theme-btn theme-button1 submitReview">{{__('Submit review')}}</button>
                </div>
            </div>
        </div>
    </div>
    <!--Write Review Modal End-->
    <div class="row">
        <div class="col-12">
            <div style="overflow: hidden; height: 0;">
                <div id="certificate-preview-div-hidden" style="width:1030px; height:734px; overflow:hidden">
                    <div style="font-family: certificate_font" class="pdf-wrapper-box" id="demo-certificate">
                        @if(isset($certificateData) && isset($certificateData['html']))
                        {!! $certificateData['html'] !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" class="course_id" value="{{ @$course->id}}">
<input type="hidden" class="normalVideoSource" value="{{ @$video_src }}">
<input type="hidden" class="youTubeVideoSource" value="{{ @$youtube_video_src }}">
<input type="hidden" class="vimeoVideoSource" value="{{ @$vimeo_video_src }}">
<input type="hidden" class="lecture_id" value="{{ @$lecture_id_check }}">
<input type="hidden" class="enrollment_id" value="{{ @@$enrollment->id }}">
<input type="hidden" class="videoCompletedRoute" value="{{  route('student.video.completed') }}">
<input type="hidden" class="certificateSaveRoute" value="{{  route('student.save-certificate') }}">
@if(@$nextLectureUuid)
<input type="hidden" class="nextLectureRoute"
    value="{{  route('student.my-course.show', [$course->slug, 'lecture_uuid' => $nextLectureUuid]) }}">
@endif
<input type="hidden" class="nextLectureId" value="{{  @$nextLectureId }}">

<input type="hidden" class="studentReviewCreateRoute" value="{{ route('student.review.create') }}">
<input type="hidden" class="studentReviewPaginateRoute" value="{{ route('student.reviewPaginate', $course->id) }}">
<input type="hidden" class="studentAssignmentListRoute" value="{{ route('student.assignment-list') }}">
@endsection

@push('style')
<!-- Video Player css -->
<link rel="stylesheet" href="{{ asset('frontend/assets/vendor/video-player/plyr.css') }}">
@endpush

@push('script')
<script src="{{ asset('frontend/assets/js/tinymce.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/tinymce-script.js') }}"></script>
<script src="{{ asset('frontend/assets/js/vimeo/api/player.js') }}"></script>
<script src="{{ asset('frontend/assets/js/custom/rating.js') }}"></script>
<script src="{{ asset('frontend/assets/js/course/student-review-paginate.js') }}"></script>
<script src="{{ asset('frontend/assets/js/course/student-assignment.js') }}"></script>
<script src="{{ asset('frontend/assets/js/course/zoom-copy-url.js') }}"></script>

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
    "use strict"
        //Youtube Video duration done;
        var course_id = $('.course_id').val();
        var lecture_id = $('.lecture_id').val();
        var enrollment_id = $('.enrollment_id').val();
        var videoCompletedRoute = $('.videoCompletedRoute').val();
        var certificateSaveRoute = $('.certificateSaveRoute').val();
        var nextLectureRoute = $('.nextLectureRoute').val();
        var youTubeVideoSource = $('.youTubeVideoSource').val()

        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        // var player;
        var duration = 0;
        var interval;

    @if($course->course_type == COURSE_TYPE_SCORM)

        function timerHandler() {
            duration++;
            if(duration > 30){
                $.post("{{ route('student.my-course.completed_duration', $course->id) }}", {duration : duration, _token: $('meta[name="csrf-token"]').attr('content')}).then(resData => {
                    if(typeof resData.data.html != 'undefined' && resData.data.html != null ){
                        $('#demo-certificate').html(resData.data.html).promise().then(function(){
                            saveToServer(resData.data.certificate_number);
                        });
                    }
                });

                duration = 1;
            }
        }

        // Start timer
        function startTimer() {
            if($(document.activeElement).hasClass('scorm-content')){
                interval = window.setInterval(timerHandler, 1000);
            }
            else{
                clearInterval(interval);
                interval = false;
            }
        }

        // Stop timer
        function stopTimer() {
            clearInterval(interval);
            interval = false;
        }

        (function() {
            var hidden = "hidden";

            // Standards:
            if (hidden in document)
                document.addEventListener("visibilitychange", onchange);
            else if ((hidden = "mozHidden") in document)
                document.addEventListener("mozvisibilitychange", onchange);
            else if ((hidden = "webkitHidden") in document)
                document.addEventListener("webkitvisibilitychange", onchange);
            else if ((hidden = "msHidden") in document)
                document.addEventListener("msvisibilitychange", onchange);
            // IE 9 and lower:
            else if ("onfocusin" in document)
                document.onfocusin = document.onfocusout = onchange;
            // All others:
            else
                window.onpageshow = window.onpagehide
                = window.onfocus = window.onblur = onchange;

            function onchange (evt) {
                var v = "visible",
                    h = "hidden",
                    evtMap = {
                        focus: v,
                        focusin: v,
                        pageshow: v,
                        blur: h,
                        focusout: h,
                        pagehide: h
                    };

                evt = evt || window.event;
                if (evt.type in evtMap) {
                    if(evtMap[evt.type] == 'visible'){
                        startTimer();
                    }
                    else{
                        stopTimer();
                    }
                } else {
                    if(this[hidden]){
                        stopTimer();
                    }
                    else{
                        startTimer();
                    }
                }
            }

            // set the initial state (but only if browser supports the Page Visibility API)
            if( document[hidden] !== undefined ){
                onchange({type: document[hidden] ? "blur" : "focus"});
            }

            window.addEventListener('load', startTimer);
        })();
    @endif

</script>
<script src="{{ asset('frontend/assets/js/html2canvas.js') }}"></script>
<script src="{{ asset('frontend/assets/js/custom/course-video-ended.js') }}"></script>
<!-- Video Player js -->
<script src="{{ asset('frontend/assets/vendor/video-player/plyr.js') }}"></script>
<script>
    const zai_player = new Plyr('#player');
        const zai_player1 = new Plyr('#player1');
        const zai_player2 = new Plyr('#playerVideoYoutube');
        const zai_player3 = new Plyr('#youtubePlayer');
        const zai_player4 = new Plyr('#playerVideoVimeo');
        const zai_player5 = new Plyr('#audioplayer');
</script>
<!-- Video Player js -->

<script type="text/javascript">
    'use strict';
	//For Scorm course body
	$(document).ready(function(){
	  var width = $('#scorm_player').width();
	  $('#scorm_player').attr("height", width/2);
	  window.onresize = function(event) {
	    var width = $('#scorm_player').width();
	    $('#scorm_player').attr("height", width/2);
	  };

        @if(isset($certificateData) && isset($certificateData['html']))
            saveToServer({{ $certificateData['certificate_number'] }});
        @endif
	});
	//End for Scorm course body
</script>

<script>
    var player,
        youtube_player = document.querySelector('.youtube-player'),
        controls_bar = document.querySelector('.youtube-player-controls'),
        video_play_button = document.querySelector('.youtube-video-overBtn'),
        play_button = document.querySelector('.play-button'),
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

    function initYoutubePlayer() {
        var videoId = $('#youtube-player-video').data('video-id');
        player = new YT.Player('youtube-player-video', {
            width: 853,
            height: 480,
            videoId: videoId,
            playerVars: {
                autoplay: 1,
                controls: 0,
                // playlist: videoId,  astuce indiquer la playlist avec l'id de la video pour ne pas avoir de publicités (no ads)
                showinfo:0
            },
            events: {
                'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange
            }
        });
    }

    function onPlayerReady(e) {
        // options
        player.setVolume(70);
        sound_bar.value = 70;
        progress_text.innerHTML = "00:00:00";
        player.setPlaybackQuality('hd1080');

        // Show / Hide controls
        youtube_player.addEventListener('mouseenter', showControls);
        youtube_player.addEventListener('mouseleave', hideControls);

        // user Play / Pause
        play_button.addEventListener('click', togglePlayPause);
        video_play_button.addEventListener('click', togglePlayPause);

        // user change progress (drag, click)
        progress_bar.addEventListener('mousedown', function(e) {
            progressDrag = true;
        });
        document.addEventListener('mouseup', function(e) {
            if (progressDrag) {
                setProgress(e);
                progressDrag = false;
            }
            if (soundDrag) {
                soundDrag = false;
                setVolume(e);
            }
        });
        document.addEventListener('mousemove', function(e) {
            if (progressDrag) {
                setProgress(e);
            }
            if (soundDrag) {
                setVolume(e);
            }
        });
        progress_bar.addEventListener('click', updateProgress);

        // Mute
        sound_button.addEventListener('click', toggleMute);

        // Volume change
        sound_bar.addEventListener('mousedown', function(e) {
            soundDrag = true;
        });
        sound_bar.addEventListener('click', setVolume);

        // Fullscreen handling
        full_screen_button.addEventListener('click', function() {
            var requestFullScreen = youtube_player.requestFullscreen ||
                youtube_player.mozRequestFullScreen ||
                youtube_player.webkitRequestFullscreen ||
                youtube_player.msRequestFullscreen;
            if (requestFullScreen) {
                requestFullScreen.call(youtube_player);
                full_screen_button.style.display = 'none';
            }
        });

        // Exit Fullscreen handling (for ESC or cross icon)
        document.addEventListener('fullscreenchange', onFullScreenExit);
        document.addEventListener('webkitfullscreenchange', onFullScreenExit);
        document.addEventListener('mozfullscreenchange', onFullScreenExit);
        document.addEventListener('MSFullscreenChange', onFullScreenExit);

        launch_y_progress_timer();
    }

    // Handle Fullscreen Exit (ESC or Cross Icon)
    function onFullScreenExit() {
        if (!document.fullscreenElement && !document.mozFullScreenElement &&
            !document.webkitFullscreenElement && !document.msFullscreenElement) {
            full_screen_button.style.display = 'block';
        }
    }

    function onPlayerStateChange(e) {

        if (e.data == YT.PlayerState.PLAYING) {
            video_play_button.style.opacity=0;
            play_button.innerHTML = '<i class="fa fa-pause"></i>';
        }
        if (e.data == YT.PlayerState.PAUSED) {
            video_play_button.style.opacity=1;
            play_button.innerHTML = '<i class="fa fa-play"></i>';
        }
        if (e.data == YT.PlayerState.ENDED) {
            video_play_button.style.opacity=1;
            player.stopVideo();
            play_button.innerHTML = '<i class="fa fa-play"></i>';
            showControls();
            callCompleteCourse();
        }
    }

    function showControls() {

        if (isClicking || controls_bar.style.opacity == 1) return false;

        var opacity = 0,
            current_time = 0,
            duration = 300;

        clearInterval(show_controls_timer);
        show_controls_timer = setInterval(function() {
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

    function hideControls() {

        if (isClicking || controls_bar.style.opacity == 0 || player.getCurrentTime() == player.getDuration() || (player.getCurrentTime() == 0 && player.getPlayerState() == 2)) return false;

        var opacity = 1,
            current_time = 0,
            duration = 300;

        clearInterval(hide_controls_timer);
        hide_controls_timer = setInterval(function() {
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

    function launch_y_progress_timer() {
        clearInterval(y_progress_timer);
        y_progress_timer = setInterval(updateProgress, 500);
    }

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
        player.seekTo(newTime);
    }

    function togglePlayPause() {

        launch_click_timer();

        var play_state = player.getPlayerState();
        if (play_state == -1 || play_state == 0 || play_state == 2 || play_state == 5) {
            player.playVideo();
        }
        if (play_state == 1) {
            player.pauseVideo();
        }
    }

    function launch_click_timer() {
        isClicking = true;
        clearTimeout(click_timer);
        click_timer = setTimeout(function() {
            isClicking = false;
        }, 50);
    }

    function toggleMute(e) {
        launch_click_timer();
        if (player.isMuted()) {
            player.unMute();
            updateVolume_controls(player.getVolume());
        } else {
            player.mute();
            updateVolume_controls(0);
        }
    }

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

    function changeVideo(videoId, quality) {
        player.loadVideoById(videoId, 0, quality);
    }

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


    window.addEventListener('load', function (){
        initYoutubePlayer();
    })
</script>

@endpush
