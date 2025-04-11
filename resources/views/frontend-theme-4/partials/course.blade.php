<div class="course-item-one">
    <div class="img">
        <a href="{{ route('course-details', $course->slug) }}">
            <img src="{{getImageFile($course->image_path)}}" alt="course"/>
        </a>
        @if($course->status != STATUS_UPCOMING_APPROVED)
            @if (date('Y-m-d H:i:s', strtotime('-7 days')) >= $course->created_at)
                @if (in_array($course->id, $topCourse))
                    <p class="courseTag bestCourse">{{__('Best seller')}}</p>
                @endif
            @else
                <span
                    class="course-tag badge radius-3 font-12 font-medium position-absolute bg-green">{{ __('New course') }}</span>
            @endif
                <?php
                $special = @$course->specialPromotionTagCourse->specialPromotionTag->name;
                ?>
            @if($special)
                <span class="course-tag badge radius-3 font-12 font-medium position-absolute bg-orange">
                    {{ __(@$special) }}
                </span>
            @endif
        @else
            <span class="course-tag badge radius-3 font-12 font-medium position-absolute bg-warning">{{ __('Upcoming') }}</span>
        @endif
    </div>
    <div class="content">
            <a href="{{ route('course-details', $course->slug) }}" class="title">{{ Str::limit($course->title, 40)}}
            </a>
            <a href="{{ route('userProfile',$course->user->id) }}" class="author">{{ $course->$userRelation->name }}</a>
        <div class="rating-wrap">
            <p class="no">{{ $course->average_rating }}</p>
            <div class="star-ratings">
                <div class="fill-ratings" style="width: {{ $course->average_rating * 20 }}%">
                    <span>★★★★★</span>
                </div>
                <div class="empty-ratings">
                    <span>★★★★★</span>
                </div>
            </div>
            <p class="totalRating">({{ @$course->reviews->count() }})</p>
        </div>
        @if($course->learner_accessibility == 'paid')
                <?php
                $startDate = date('d-m-Y H:i:s', strtotime(@$course->promotionCourse->promotion->start_date));
                $endDate = date('d-m-Y H:i:s', strtotime(@$course->promotionCourse->promotion->end_date));
                $percentage = @$course->promotionCourse->promotion->percentage;
                $discount_price = number_format($course->price - (($course->price * $percentage) / 100), 2);
                ?>

            @if(now()->gt($startDate) && now()->lt($endDate))
                <p class="price">
                    {{ __('Price') }}:
                    <span class="discountPrice">
                                @if($currencyPlacement ?? get_currency_placement() == 'after')
                            {{ $discount_price }} {{ $currencySymbol ?? get_currency_symbol() }}
                        @else
                            {{ $currencySymbol ?? get_currency_symbol() }} {{ $discount_price }}
                        @endif
                    </span>
                    <span class="regularPrice">
                                @if($currencyPlacement ?? get_currency_placement() == 'after')
                            {{ $course->price }} {{ $currencySymbol ?? get_currency_symbol() }}
                        @else
                            {{ $currencySymbol ?? get_currency_symbol() }} {{ $course->price }}
                        @endif
                            </span>
                </p>
            @elseif ($course->price <= $course->old_price)
                <p class="price">
                    {{ __('Price') }}:
                    <span class="discountPrice">
                                @if($currencyPlacement ?? get_currency_placement() == 'after')
                            {{ $course->price }} {{ $currencySymbol ?? get_currency_symbol() }}
                        @else
                            {{ $currencySymbol ?? get_currency_symbol() }} {{ $course->price }}
                        @endif
                    </span>
                    <span class="regularPrice">
                                @if($currencyPlacement ?? get_currency_placement() == 'after')
                            {{ $course->old_price }} {{ $currencySymbol ?? get_currency_symbol() }}
                        @else
                            {{ $currencySymbol ?? get_currency_symbol() }} {{ $course->old_price }}
                        @endif
                    </span>
                </p>
            @else
                <p class="price">
                    {{ __('Price') }}:
                    <span class="discountPrice">
                                @if($currencyPlacement ?? get_currency_placement() == 'after')
                            {{ $course->price }} {{ $currencySymbol ?? get_currency_symbol() }}
                        @else
                            {{ $currencySymbol ?? get_currency_symbol() }} {{ $course->price }}
                        @endif
                    </span>
                </p>
            @endif
        @elseif($course->learner_accessibility == 'free')
            <p class="free">
                {{ __('Free') }}
            </p>
        @endif
        @if($course->learner_accessibility != 'free' && get_option('cashback_system_mode', 0))
            <div class="cashback">
                <div class="title">{{__('Cashback')}} :</div>
                <div class="amount">
                    @if($currencyPlacement ?? get_currency_placement() == 'after')
                        {{calculateCashback($course->price) }} {{ $currencySymbol ?? get_currency_symbol() }}
                    @else
                        {{ $currencySymbol ?? get_currency_symbol() }} {{calculateCashback($course->price) }}
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
