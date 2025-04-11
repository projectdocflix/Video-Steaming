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
                                <h2>{{__('Email Notification Template')}}</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a
                                            href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                    <li class="breadcrumb-item active"
                                        aria-current="page">{{__('Email Notification Template')}}</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="customers__area bg-style mb-30">
                        <form action="{{route('email-notification.update', [$template->slug])}}" method="post" data-handler="commonResponseWithPageLoad" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-2">
                                <div class="col-md-12">
                                    <div class="custom-form-group">
                                        <label for="name" class="form-label"> {{__('Name')}} </label>
                                        <input type="text" name="name" id="name" readonly
                                               value="{{$template->category}}"
                                               class="form-control flat-input">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="custom-form-group">
                                        <label for="subject" class="form-label"> {{__('Subject')}} </label>
                                        <input type="text" name="subject" id="subject" value="{{$template->subject}}"
                                               class="form-control flat-input" placeholder=" {{__('Subject')}} ">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div>
                                        <label for="body" class="form-label"> {{__('Variables')}} </label>
                                        {!! $template->variables !!}
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="custom-form-group">
                                        <label for="body" class="form-label"> {{__('Body')}} </label>
                                        <textarea name="body" id="summernote" class="form-control"
                                                  placeholder="{{__('Body')}}"
                                                  rows="10">{{$template->body}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="custom-form-group">
                                        <label for="body" class="form-label"> {{__('Status')}} </label>
                                        <select name="status" id="status" class="form-control">
                                            <option
                                                value="1" {{ $template->status == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
                                            <option
                                                value="0" {{ $template->status == 0 ? 'selected' : '' }}>{{ __('Deactivated') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-blue mr-30">{{__('Save')}}</button>
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
    <link href="{{ asset('common/css/summernote/summernote.min.css') }}" rel="stylesheet">
    <link href="{{ asset('common/css/summernote/summernote-lite.min.css') }}" rel="stylesheet">
@endpush
@push('script')
    <script src="{{ asset('common/js/summernote/summernote-lite.min.js') }}"></script>
    <script>
        $("#summernote").summernote({dialogsInBody: true});
    </script>
@endpush

