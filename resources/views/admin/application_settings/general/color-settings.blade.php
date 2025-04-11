@extends('layouts.admin')

@section('content')
    <!-- Page content area start -->
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb__content">
                        <div class="breadcrumb__content__left">
                            <div class="breadcrumb__title">
                                <h2>{{ __('Application Settings') }}</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ __(@$title) }}</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    @include('admin.application_settings.sidebar')
                </div>
                <div class="col-lg-9 col-md-8">
                    <div class="email-inbox__area bg-style">
                        <div class="item-top mb-30"><h2>{{ __(@$title) }}</h2></div>
                        <form action="{{route('settings.general_setting.cms.update')}}" method="post" class="form-horizontal">
                            @csrf

                            <div class="row">
                                <div class="col-lg-3">
                                    <label>{{ __('Design') }} <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-lg-9 mb-15">
                                    <input type="radio" id="default" name="app_color_design_type" value="1"
                                           {{ (empty(get_option('app_color_design_type')) || get_option('app_color_design_type')) ? 'checked' : '' }} required>
                                    <label for="default">{{ __('Default') }}</label><br>
                                    <input type="radio" id="custom" name="app_color_design_type" value="2" {{ get_option('app_color_design_type') == 2 ? 'checked' : '' }}>
                                    <label for="custom">{{ __('Custom') }}</label><br>
                                </div>
                            </div>
                            <div class="customDiv">
                                <div class="row">
                                    <div class="col-lg-3"><label>{{ __('Theme Color') }} <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-lg-9 mb-15">
                                         <span class="color-picker">
                                            <label for="colorPicker1" class="mb-0">
                                                <input type="color" name="app_theme_color"
                                                       value="{{ empty(get_option('app_theme_color')) ? '#5e3fd7' : get_option('app_theme_color') }}" id="colorPicker1">
                                            </label>
                                        </span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3">
                                        <label>{{ __('Navbar Background Color') }} <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-lg-9 mb-15">
                                         <span class="color-picker">
                                            <label for="colorPicker2" class="mb-0">
                                                <input type="color" name="app_navbar_background_color"
                                                       value="{{ empty(get_option('app_navbar_background_color')) ? '#030060' : get_option('app_navbar_background_color') }}"
                                                       id="colorPicker2">
                                            </label>
                                        </span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3">
                                        <label>{{ __('Body Font Color') }} <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-lg-9 mb-15">
                                         <span class="color-picker">
                                            <label for="colorPicker3" class="mb-0">
                                                <input type="color" name="app_body_font_color"
                                                       value="{{ empty(get_option('app_body_font_color')) ? '#52526C' : get_option('app_body_font_color') }}"
                                                       id="colorPicker3">
                                            </label>
                                        </span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3">
                                        <label>{{ __('Heading Color') }} <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-lg-9 mb-15">
                                         <span class="color-picker">
                                            <label for="colorPicker4" class="mb-0">
                                                <input type="color" name="app_heading_color"
                                                       value="{{ empty(get_option('app_heading_color')) ? '#040453' : get_option('app_heading_color') }}" id="colorPicker4">
                                            </label>
                                        </span>
                                    </div>
                                </div>

                                <div class="row gradient-color">
                                    <div class="col-lg-3">
                                        <label>{{ __('Gradient Banner Color') }} <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-lg-9 mb-15">
                                        <span class="color-picker d-flex flex-wrap">
                                            <label for="colorPicker8" class="mb-0 me-3">
                                                <input class="color1" type="color" name="app_gradiant_banner_color1" value="{{  get_option('app_gradiant_banner_color1') }}"
                                                       id="colorPicker8">
                                            </label>
                                            <label for="colorPicker9" class="mb-0 me-3">
                                                <input class="color2" type="color" name="app_gradiant_banner_color2" value="{{  get_option('app_gradiant_banner_color2') }}"
                                                       id="colorPicker9">
                                            </label>
                                        </span>

                                        <div class="gradient p-5" data-gradient-value="to right">
                                            <input class="app_gradiant_banner_color" type="hidden" name="app_gradiant_banner_color"
                                                   value="{{  get_option('app_gradiant_banner_color') }}">
                                            <h2 class="text-white">{{ __('Current CSS Background') }}</h2>
                                            <h3 id="textContent" class="text-white"></h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="row gradient-color">
                                    <div class="col-lg-3">
                                        @if(get_option('theme', THEME_DEFAULT) == THEME_DEFAULT)
                                        <label>{{ __('Gradiant Footer Color') }} <span class="text-danger">*</span></label>
                                        @else
                                        <label>{{ __('Gradiant section Color') }} <span class="text-danger">*</span></label>
                                        @endif
                                    </div>
                                    <div class="col-lg-9 mb-15">
                                        <span class="color-picker d-flex flex-wrap">
                                            <label for="colorPicker12" class="mb-0 me-3">
                                                <input class="color5" type="color" name="app_gradiant_footer_color1" value="{{  get_option('app_gradiant_footer_color1') }}"
                                                       id="colorPicker12">
                                            </label>
                                            <label for="colorPicker13" class="mb-0 me-3">
                                                <input class="color6" type="color" name="app_gradiant_footer_color2" value="{{  get_option('app_gradiant_footer_color2') }}"
                                                       id="colorPicker13">
                                            </label>
                                        </span>

                                        <div class="gradient p-5" data-gradient-value="180deg">
                                            <input class="app_gradiant_footer_color" type="hidden" name="app_gradiant_footer_color"
                                                   value="{{  get_option('app_gradiant_footer_color') }}">
                                            <h2 class="text-white">{{ __('Current CSS Background') }}</h2>
                                            <h3 id="textContent3" class="text-white"></h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3">
                                        @if(get_option('theme', THEME_DEFAULT) == THEME_DEFAULT)
                                        <label>{{ __('Gradiant Overlay Background Color Opacity') }} <span class="text-danger">*</span></label>
                                        @else
                                        <label>{{ __('Gradiant Section Background Color Opacity') }} <span class="text-danger">*</span></label>
                                        @endif
                                    </div>
                                    <div class="col-lg-9 mb-15">
                                        <select name="app_gradiant_overlay_background_color_opacity" class="form-control">
                                            <option value="0" {{ get_option('app_gradiant_overlay_background_color_opacity') == 0 ? 'selected' : null }}>0</option>
                                            <option value="0.1" {{ get_option('app_gradiant_overlay_background_color_opacity') == 0.1 ? 'selected' : null }}>0.1</option>
                                            <option value="0.2" {{ get_option('app_gradiant_overlay_background_color_opacity') == 0.2 ? 'selected' : null }}>0.2</option>
                                            <option value="0.3" {{ get_option('app_gradiant_overlay_background_color_opacity') == 0.3 ? 'selected' : null }}>0.3</option>
                                            <option value="0.4" {{ get_option('app_gradiant_overlay_background_color_opacity') == 0.4 ? 'selected' : null }}>0.4</option>
                                            <option value="0.5" {{ get_option('app_gradiant_overlay_background_color_opacity') == 0.5 ? 'selected' : null }}>0.5</option>
                                            <option value="0.6" {{ get_option('app_gradiant_overlay_background_color_opacity') == 0.6 ? 'selected' : null }}>0.6</option>
                                            <option value="0.7" {{ get_option('app_gradiant_overlay_background_color_opacity') == 0.7 ? 'selected' : null }}>0.7</option>
                                            <option value="0.8" {{ get_option('app_gradiant_overlay_background_color_opacity') == 0.8 ? 'selected' : null }}>0.8</option>
                                            <option value="0.9" {{ get_option('app_gradiant_overlay_background_color_opacity') == 0.9 ? 'selected' : null }}>0.9</option>
                                            <option value="1" {{ get_option('app_gradiant_overlay_background_color_opacity') == 1 ? 'selected' : null }}>1</option>
                                        </select>
                                    </div>
                                </div>

                                @if(get_option('theme', THEME_DEFAULT) == THEME_SEVEN)
                                    <div class="row">
                                        <div class="col-12">
                                            <h2 class="border-bottom mb-20">{{__('Landing Page Color')}}</h2>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <label>{{ __('Theme Color') }} <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-9 mb-15">
                                         <span class="color-picker">
                                            <label for="colorPicker21" class="mb-0">
                                                <input type="color" name="kindergarten_theme_secondary_color"
                                                       value="{{ empty(get_option('kindergarten_theme_secondary_color')) ? '#d9fbf9' : get_option('kindergarten_theme_secondary_color') }}" id="colorPicker21">
                                            </label>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <label>{{ __('Theme Secondary Color') }} <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-9 mb-15">
                                         <span class="color-picker">
                                            <label for="colorPicker20" class="mb-0">
                                                <input type="color" name="kindergarten_theme_bg_secondary_color"
                                                       value="{{ empty(get_option('kindergarten_theme_bg_secondary_color')) ? '#d9fbf9' : get_option('kindergarten_theme_bg_secondary_color') }}" id="colorPicker20">
                                            </label>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3"><label>{{ __('Button Color') }} <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-9 mb-15">
                                             <span class="color-picker">
                                                <label for="colorPicker15" class="mb-0">
                                                    <input type="color" name="kindergarten_app_theme_color"
                                                           value="{{ empty(get_option('kindergarten_app_theme_color')) ? '#5e3fd7' : get_option('kindergarten_app_theme_color') }}" id="colorPicker15">
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3"><label>{{ __('Text Header Color') }} <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-9 mb-15">
                                             <span class="color-picker">
                                                <label for="colorPicker18" class="mb-0">
                                                    <input type="color" name="kindergarten_theme_primary_color"
                                                           value="{{ empty(get_option('kindergarten_theme_primary_color')) ? '#5e3fd7' : get_option('kindergarten_theme_primary_color') }}" id="colorPicker18">
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <label>{{ __('Body Font Color') }} <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-9 mb-15">
                                             <span class="color-picker">
                                                <label for="colorPicker14" class="mb-0">
                                                    <input type="color" name="kindergarten_app_body_font_color"
                                                           value="{{ empty(get_option('kindergarten_app_body_font_color')) ? '#52526C' : get_option('kindergarten_app_body_font_color') }}"
                                                           id="colorPicker14">
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                @elseif(get_option('theme', THEME_DEFAULT) == THEME_SIX)
                                    <div class="row">
                                        <div class="col-12">
                                            <h2 class="border-bottom mb-20">{{__('Landing Page Color')}}</h2>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3"><label>{{ __('Theme Color') }} <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-9 mb-15">
                                             <span class="color-picker">
                                                <label for="colorPicker-m1" class="mb-0">
                                                    <input type="color" name="meditation_app_theme_color"
                                                           value="{{ empty(get_option('meditation_app_theme_color')) ? '#5e3fd7' : get_option('meditation_app_theme_color') }}" id="colorPicker-m1">
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3"><label>{{ __('Theme Secondary Background Color') }} <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-9 mb-15">
                                             <span class="color-picker">
                                                <label for="colorPicker-m15" class="mb-0">
                                                    <input type="color" name="meditation_app_theme_secondary_color"
                                                           value="{{ empty(get_option('meditation_app_theme_secondary_color')) ? '#ffe4db' : get_option('meditation_app_theme_secondary_color') }}" id="colorPicker-m15">
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <label>{{ __('Paragraph Color') }} <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-9 mb-15">
                                             <span class="color-picker">
                                                <label for="colorPicker-m2" class="mb-0">
                                                    <input type="color" name="meditation_app_body_font_color"
                                                           value="{{ empty(get_option('meditation_app_body_font_color')) ? '#52526C' : get_option('meditation_app_body_font_color') }}"
                                                           id="colorPicker-m2">
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <label>{{ __('Theme Red Color') }} <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-9 mb-15">
                                         <span class="color-picker">
                                            <label for="colorPicker-m3" class="mb-0">
                                                <input type="color" name="meditation_red_color"
                                                       value="{{ empty(get_option('meditation_red_color')) ? '#ee5e37' : get_option('meditation_red_color') }}" id="colorPicker-m3">
                                            </label>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <label>{{ __('Theme Blue Color') }} <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-9 mb-15">
                                         <span class="color-picker">
                                            <label for="colorPicker-m4" class="mb-0">
                                                <input type="color" name="meditation_blue_color"
                                                       value="{{ empty(get_option('meditation_blue_color')) ? '#46d3ff' : get_option('meditation_blue_color') }}" id="colorPicker-m4">
                                            </label>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <label>{{ __('Theme Yellow Color') }} <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-9 mb-15">
                                         <span class="color-picker">
                                            <label for="colorPicker-m5" class="mb-0">
                                                <input type="color" name="meditation_yellow_color"
                                                       value="{{ empty(get_option('meditation_yellow_color')) ? '#d8f87f' : get_option('meditation_yellow_color') }}" id="colorPicker-m5">
                                            </label>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="row gradient-color">
                                        <div class="col-lg-3">
                                            <label>{{ __('Gradiant Banner Color') }} <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-9 mb-15">
                                        <span class="color-picker d-flex flex-wrap">
                                            <label for="colorPicker-m6" class="mb-0 me-3">
                                                <input class="color1" type="color" name="meditation_gradiant_banner_color1" value="{{  get_option('meditation_gradiant_banner_color1') }}"
                                                       id="colorPicker-m6">
                                            </label>
                                            <label for="colorPicker-m7" class="mb-0 me-3">
                                                <input class="color2" type="color" name="meditation_gradiant_banner_color2" value="{{  get_option('meditation_gradiant_banner_color2') }}"
                                                       id="colorPicker-m7">
                                            </label>
                                        </span>

                                            <div class="gradient p-5" data-gradient-value="180deg">
                                                <input class="meditation_gradiant_banner_color" type="hidden" name="meditation_gradiant_banner_color"
                                                       value="{{  get_option('meditation_gradiant_banner_color') }}">
                                                <h2 class="text-white">{{ __('Current CSS Background') }}</h2>
                                                <h3 id="textContent" class="text-white"></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row gradient-color">
                                        <div class="col-lg-3">
                                            <label>{{ __('Gradiant Video Banner Color') }} <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-9 mb-15">
                                        <span class="color-picker d-flex flex-wrap">
                                            <label for="colorPicker-m8" class="mb-0 me-3">
                                                <input class="color1" type="color" name="meditation_gradiant_video_banner_color1" value="{{  get_option('meditation_gradiant_video_banner_color1') }}"
                                                       id="colorPicker-m8">
                                            </label>
                                            <label for="colorPicker-m9" class="mb-0 me-3">
                                                <input class="color2" type="color" name="meditation_gradiant_video_banner_color2" value="{{  get_option('meditation_gradiant_video_banner_color2') }}"
                                                       id="colorPicker-m9">
                                            </label>
                                        </span>

                                            <div class="gradient p-5" data-gradient-value="180deg">
                                                <input class="meditation_gradiant_video_banner_color" type="hidden" name="meditation_gradiant_video_banner_color"
                                                       value="{{  get_option('meditation_gradiant_video_banner_color') }}">
                                                <h2 class="text-white">{{ __('Current CSS Background') }}</h2>
                                                <h3 id="textContent" class="text-white"></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row gradient-color">
                                        <div class="col-lg-3">
                                            <label>{{ __('Gradiant Core Feature Color') }} <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-9 mb-15">
                                        <span class="color-picker d-flex flex-wrap">
                                            <label for="colorPicker-m10" class="mb-0 me-3">
                                                <input class="color1" type="color" name="meditation_gradiant_core_feature_color1" value="{{  get_option('meditation_gradiant_core_feature_color1') }}"
                                                       id="colorPicker-m10">
                                            </label>
                                            <label for="colorPicker-m11" class="mb-0 me-3">
                                                <input class="color2" type="color" name="meditation_gradiant_core_feature_color2" value="{{  get_option('meditation_gradiant_core_feature_color2') }}"
                                                       id="colorPicker-m11">
                                            </label>
                                        </span>

                                            <div class="gradient p-5" data-gradient-value="180deg">
                                                <input class="meditation_gradiant_core_feature_color" type="hidden" name="meditation_gradiant_core_feature_color"
                                                       value="{{  get_option('meditation_gradiant_core_feature_color') }}">
                                                <h2 class="text-white">{{ __('Current CSS Background') }}</h2>
                                                <h3 id="textContent" class="text-white"></h3>
                                            </div>
                                        </div>
                                    </div>
                                @elseif(get_option('theme', THEME_DEFAULT) == THEME_FIVE)
                                    <div class="row">
                                        <div class="col-12">
                                            <h2 class="border-bottom mb-20">{{__('Landing Page Color')}}</h2>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <label>{{ __('Theme Color') }} <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-9 mb-15">
                                         <span class="color-picker">
                                            <label for="colorPicker-ck21" class="mb-0">
                                                <input type="color" name="cooking_theme_color"
                                                       value="{{ empty(get_option('cooking_theme_color')) ? '#ee5e37' : get_option('cooking_theme_color') }}" id="colorPicker-ck21">
                                            </label>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <label>{{ __('Theme Secondary Color') }} <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-9 mb-15">
                                         <span class="color-picker">
                                            <label for="colorPicker-ck22" class="mb-0">
                                                <input type="color" name="cooking_theme_secondary_bg_color"
                                                       value="{{ empty(get_option('cooking_theme_secondary_bg_color')) ? '#ee5e37' : get_option('cooking_theme_secondary_bg_color') }}" id="colorPicker-ck22">
                                            </label>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <label>{{ __('Header Background Color') }} <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-9 mb-15">
                                         <span class="color-picker">
                                            <label for="colorPicker-ck24" class="mb-0">
                                                <input type="color" name="cooking_header_bg_color"
                                                       value="{{ empty(get_option('cooking_header_bg_color')) ? '#ee5e37' : get_option('cooking_header_bg_color') }}" id="colorPicker-ck24">
                                            </label>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <label>{{ __('Footer and Body Background Color') }} <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-9 mb-15">
                                         <span class="color-picker">
                                            <label for="colorPicker-ck20" class="mb-0">
                                                <input type="color" name="cooking_theme_bg_color"
                                                       value="{{ empty(get_option('cooking_theme_bg_color')) ? '#0c0c0d' : get_option('cooking_theme_bg_color') }}" id="colorPicker-ck20">
                                            </label>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3"><label>{{ __('Text Header Color') }} <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-9 mb-15">
                                             <span class="color-picker">
                                                <label for="colorPicker-ck18" class="mb-0">
                                                    <input type="color" name="cooking_theme_heading_color"
                                                           value="{{ empty(get_option('cooking_theme_heading_color')) ? '#0c0c0d' : get_option('cooking_theme_heading_color') }}" id="colorPicker-ck18">
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <label>{{ __('Body Font Color') }} <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-9 mb-15">
                                             <span class="color-picker">
                                                <label for="colorPicker-ck14" class="mb-0">
                                                    <input type="color" name="cooking_app_body_font_color"
                                                           value="{{ empty(get_option('cooking_app_body_font_color')) ? '#7c7c7' : get_option('cooking_app_body_font_color') }}"
                                                           id="colorPicker-ck14">
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                @elseif(get_option('theme', THEME_DEFAULT) == THEME_FOUR)
                                    <div class="row">
                                        <div class="col-12">
                                            <h2 class="border-bottom mb-20">{{__('Landing Page Color')}}</h2>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <label>{{ __('Theme Color') }} <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-9 mb-15">
                                         <span class="color-picker">
                                            <label for="colorPicker-ck21" class="mb-0">
                                                <input type="color" name="language_theme_color"
                                                       value="{{ empty(get_option('language_theme_color')) ? '#704fe' : get_option('language_theme_color') }}" id="colorPicker-ck21">
                                            </label>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <label>{{ __('Theme Secondary Background Color') }} <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-9 mb-15">
                                         <span class="color-picker">
                                            <label for="colorPicker-ck29" class="mb-0">
                                                <input type="color" name="language_theme_secondary_color"
                                                       value="{{ empty(get_option('language_theme_secondary_color')) ? '#7a5ede' : get_option('language_theme_secondary_color') }}" id="colorPicker-ck29">
                                            </label>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <label>{{ __('Header Background Color') }} <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-9 mb-15">
                                         <span class="color-picker">
                                            <label for="colorPicker-ck24" class="mb-0">
                                                <input type="color" name="language_header_bg_color"
                                                       value="{{ empty(get_option('language_header_bg_color')) ? '#060667' : get_option('language_header_bg_color') }}" id="colorPicker-ck24">
                                            </label>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3"><label>{{ __('Text Header Color') }} <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-9 mb-15">
                                             <span class="color-picker">
                                                <label for="colorPicker-ck18" class="mb-0">
                                                    <input type="color" name="language_theme_heading_color"
                                                           value="{{ empty(get_option('language_theme_heading_color')) ? '#0c0c0d' : get_option('language_theme_heading_color') }}" id="colorPicker-ck18">
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <label>{{ __('Body Font Color') }} <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-9 mb-15">
                                             <span class="color-picker">
                                                <label for="colorPicker-ck14" class="mb-0">
                                                    <input type="color" name="language_app_body_font_color"
                                                           value="{{ empty(get_option('language_app_body_font_color')) ? '#7c7c7' : get_option('language_app_body_font_color') }}"
                                                           id="colorPicker-ck14">
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </div>


                            <div class="row">
                                <div class="col-12">
                                    <div class="input__group general-settings-btn">
                                        <button type="submit" class="btn btn-blue float-right">{{__('Update')}}</button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content area end -->
@endsection

@push('style')
    <link rel="stylesheet" href="{{asset('frontend/assets/css/for-certificate.css')}}">
@endpush

@push('script')

    <script src="{{asset('frontend/assets/js/color.js')}}"></script>

    <script>
        "use strict"
        $(function () {
            // Function to set gradient color dynamically for each gradient-color section
            function setGradient(container) {
                // Select the two color input fields within this gradient-color container
                const colorInputs = container.find('input[type="color"]');
                const color1 = colorInputs.eq(0).val(); // First color input
                const color2 = colorInputs.eq(1).val(); // Second color input

                // Get the .gradient div and the direction within this container
                const gradientDiv = container.find('.gradient');
                const direction = gradientDiv.data("gradient-value"); // Retrieve direction from data attribute

                // Generate the CSS gradient
                const gradient = `linear-gradient(${direction}, ${color1}, ${color2})`;

                // Apply the gradient to the .gradient div background and update the hidden input
                gradientDiv.css('background', gradient);
                gradientDiv.find('input[type="hidden"]').val(gradient); // Update hidden input
                gradientDiv.find('h3').text(gradient); // Display the gradient CSS as text in the h3
            }

            // Set initial gradients on page load for each .gradient-color container
            $('.gradient-color').each(function () {
                setGradient($(this));
            });

            // Update the gradient dynamically when any color input changes within its container
            $('.gradient-color input[type="color"]').on("input", function () {
                const container = $(this).closest('.gradient-color');
                setGradient(container);
            });
        });

        $(function () {
            var app_color_design_type = "{{ empty(get_option('app_color_design_type')) ? 1 : get_option('app_color_design_type') }}";
            appDesignType(app_color_design_type);
        });

        $("input[name='app_color_design_type']").click(function () {
            var app_design_type = $("input[name='app_color_design_type']:checked").val();
            appDesignType(app_design_type);
        });

        function appDesignType(app_color_design_type) {
            if (app_color_design_type == 1) {
                $('.customDiv').addClass('d-none');
            } else {
                $('.customDiv').removeClass('d-none');
            }
        }
    </script>

@endpush
