@if(count($enrollments) > 0)
    <div class="table-responsive">
        <table class="table bg-white my-courses-page-table">
            <thead>
            <tr>
                <th scope="col" class="color-gray font-15 font-medium">{{__('Course')}}</th>
                <th scope="col" class="color-gray font-15 font-medium">{{__('Author')}}</th>
                <th scope="col" class="color-gray font-15 font-medium">{{__('Price')}}</th>
                <th scope="col" class="color-gray font-15 font-medium">{{__('Order ID')}}</th>
                <th scope="col" class="color-gray font-15 font-medium">{{__('Validity')}}</th>
                <th scope="col" class="color-gray font-15 font-medium">{{__('Progress')}}</th>
                <th scope="col" class="color-gray font-15 font-medium">{{__('Action')}}</th>
            </tr>
            </thead>
            <tbody>

            @foreach($enrollments as $enrollment)
                @if($enrollment->course_id)
                <tr>
                    <td class="wishlist-course-item">
                        <div class="card course-item wishlist-item border-0 d-flex align-items-center">
                            <div class="course-img-wrap flex-shrink-0 overflow-hidden">
                                <?php
                                $special = @$course->specialPromotionTagCourse->specialPromotionTag->name;
                                ?>
                                @if($special)
                                    <span class="course-tag badge radius-3 font-12 font-medium position-absolute bg-orange">
                                        {{ @$special }}
                                    </span>
                                @endif
                                <a href="{{ route('student.my-course.show', @$enrollment->course->slug) }}"><img src="{{ getImageFile(@$enrollment->course->image_path) }}" alt="course" class="img-fluid"></a>
                            </div>
                            <div class="card-body flex-grow-1">
                                <h5 class="card-title course-title"><a href="{{ route('student.my-course.show', @$enrollment->course->slug) }}">{{ @$enrollment->course->title }}</a></h5>
                                @if(get_option('refund_system_mode', false))
                                    <div class="card-text font-medium font-11 mb-1">
                                        @if($enrollment->unit_price > 0 && $enrollment->user_id == $enrollment->order->user_id)
                                        <button class="color-gray2 me-2 font-medium bg-transparent border-0 my-course-give-a-review-btn my-learning-refund courseRefund" data-amount="{{ $enrollment->unit_price }}" data-id="{{ @$enrollment->id }}"><span><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 11 11" fill="none">
                                                    <path d="M0.6875 4.70593V6.5285C0.6875 7.14553 1.18766 7.64534 1.80434 7.64534H5.82725C6.44428 7.64534 6.94409 7.14518 6.94409 6.5285V4.70593H0.6875ZM5.58697 6.5615H4.24256C4.05281 6.5615 3.89881 6.4075 3.89881 6.21775C3.89881 6.028 4.05281 5.874 4.24256 5.874H5.58697C5.77672 5.874 5.93072 6.028 5.93072 6.21775C5.93072 6.4075 5.77672 6.5615 5.58697 6.5615Z" fill="#929292"/>
                                                    <path d="M5.15811 0.657231C5.32827 0.74145 5.39771 0.9477 5.31314 1.11786L5.11274 1.52211L5.51699 1.72286C5.68714 1.80742 5.75658 2.01332 5.67202 2.18348C5.5878 2.35364 5.38121 2.42307 5.21139 2.33851L4.42111 1.94629C4.29427 1.88339 4.24271 1.72973 4.30561 1.60289L4.69783 0.812262C4.78205 0.642106 4.9883 0.572668 5.15846 0.657231H5.15811Z" fill="#929292"/>
                                                    <path d="M6.05103 7.98911H1.58159C0.89925 7.98911 0.34375 7.43395 0.34375 6.75126V4.06933C0.34375 3.38698 0.898906 2.83148 1.58159 2.83148H6.05103C6.73338 2.83148 7.28888 3.38664 7.28888 4.06933V6.75126C7.28888 7.43361 6.73372 7.98911 6.05103 7.98911ZM1.58159 3.51933C1.27806 3.51933 1.03125 3.76614 1.03125 4.06967V6.75161C1.03125 7.05479 1.27806 7.30195 1.58159 7.30195H6.05103C6.35456 7.30195 6.60138 7.05514 6.60138 6.75161V4.06967C6.60138 3.76648 6.35456 3.51933 6.05103 3.51933H1.58159Z" fill="#929292"/>
                                                    <path d="M0.687012 4.36218H6.94464V5.04968H0.687012V4.36218Z" fill="#929292"/>
                                                    <path d="M6.18774 9.96873C5.0073 9.96873 3.89424 9.51258 3.05274 8.68483C2.74268 8.37923 2.47902 8.0317 2.27002 7.65117L2.87227 7.3198C3.04964 7.64189 3.27239 7.93614 3.53502 8.19498C4.24693 8.89555 5.18914 9.28158 6.18808 9.28158C8.27293 9.28158 9.96933 7.58517 9.96933 5.50033C9.96933 3.41548 8.27293 1.71908 6.18808 1.71908C5.78899 1.71908 5.39608 1.78095 5.02105 1.90264L4.80896 1.24883C5.25274 1.1048 5.7168 1.03192 6.18808 1.03192C8.65208 1.03192 10.6568 3.03667 10.6568 5.50067C10.6568 7.96467 8.65208 9.96942 6.18808 9.96942L6.18774 9.96873Z" fill="#929292"/>
                                                </svg></span> {{ __('Refund') }}</button>
                                        @endif
                                        <button class="color-gray2 me-2 font-medium bg-transparent border-0 my-course-give-a-review-btn star-full my-learning-give-review courseReview" data-course_id="{{ @$enrollment->course->id }}" data-bs-toggle="modal" data-bs-target="#writeReviewModal"><span class="iconify me-1" data-icon="bi:star-fill"></span>{{ __('Give') }}</button>
                                        <a target="_blank" href="{{route('student.download-invoice-by-enroll', [@$enrollment->id])}}" class="color-gray2 me-2 my-learning-invoice"><img src="{{ asset('frontend/assets/img/courses-img/invoice-icon.png') }}" alt="report" class="me-1">{{__('Invoice')}}</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="wishlist-price font-15 color-heading">{{ @$enrollment->course->instructor->name }}</td>
                    <td class="wishlist-price font-15 color-heading">
                        @if($enrollment->unit_price > 0)
                            @if(get_currency_placement() == 'after')
                                {{ $enrollment->unit_price }} {{ get_currency_symbol() }}
                            @else
                                {{ get_currency_symbol() }} {{ $enrollment->unit_price }}
                            @endif

                        @else
                            {{ __('Free') }}
                        @endif
                    </td>
                    <td class="wishlist-price font-15 color-heading">{{@$enrollment->order->order_number}}</td>
                    <td class="font-15 color-heading">{{ (checkIfExpired($enrollment)) ? (checkIfLifetime($enrollment->end_date) ? __('Lifetime') : \Carbon\Carbon::now()->diffInDays($enrollment->end_date, false).' '.__('days left') ) : __('Expired') }}</td>

                    <td class="wishlist-price font-15 color-heading">
                        <div class="review-progress-bar-wrap">
                            <!-- Progress Bar -->
                            <div class="barras">
                                <div class="progress-bar-box">
                                    <div class="progress-hint-value font-14 color-heading">{{number_format(studentCourseProgress(@$enrollment->course->id, @$enrollment->id), 2)}}%</div>
                                    <div class="barra">
                                        <div class="barra-nivel" data-nivel="{{number_format(studentCourseProgress(@$enrollment->course->id, @$enrollment->id), 2)}}%" style="width: {{number_format(studentCourseProgress(@$enrollment->course->id, @$enrollment->id), 2)}}%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="wishlist-add-to-cart-btn">
                        @if(checkIfExpired($enrollment))
                        <a href="{{ route('student.my-course.show', @$enrollment->course->slug) }}" class="theme-button theme-button1 theme-button3 font-13">{{ __('View') }}</a>
                        @else
                        <a href="{{ route('course-details', @$enrollment->course->slug) }}" class="theme-button theme-button1 theme-button3 font-13">{{ __('Renew') }}</a>
                        @endif
                    </td>
                </tr>
                @endif
            @endforeach

            </tbody>
        </table>
    </div>
@else
    <!-- If there is no data Show Empty Design Start -->
    <div class="empty-data">
        <img src="{{ asset('frontend/assets/img/empty-data-img.png') }}" alt="img" class="img-fluid">
        <h4 class="my-3">{{ __('Empty Course') }}</h4>
    </div>
    <!-- If there is no data Show Empty Design End -->
@endif
<!-- Pagination Start -->
@if(@$enrollments->hasPages())
    {{ @$enrollments->links('frontend.paginate.paginate') }}
@endif
<!-- Pagination End -->
