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
                                <h2>{{ __('Version Update') }}</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                                    <li class="breadcrumb-item active"
                                        aria-current="page">{{ __('Version Update') }}</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="customers__area bg-style mb-30">
                        <div class="item-title d-flex justify-content-between">
                            <h2>{{ __('Version Update') }}</h2>
                        </div>
                        <!-- Upload Script File Form -->
                        <form action="{{ route('admin.store-script-file') }}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="custom-form-group mb-3 row">
                                <label for="file" class="col-lg-3 text-lg-right text-black"> {{ __('File') }} </label>
                                <div class="col-lg-9">
                                    <input type="file" name="file" id="file" class="form-control flat-input"
                                           placeholder="{{ __('File') }}">
                                    @if ($errors->has('file'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('file') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="custom-form-group mb-3 row">
                                <label for="path" class="col-lg-3 text-lg-right text-black"> {{ __('Path') }} </label>
                                <div class="col-lg-9">
                                    <input type="text" name="path" id="path" class="form-control flat-input"
                                           placeholder="{{ __('Path') }}">
                                    @if ($errors->has('path'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('path') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="customers__area bg-style mb-30">
                        <!-- Load Script File Form -->
                        <form action="{{ route('admin.load-script-file') }}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="custom-form-group mb-3 row">
                                <label for="loadPath"
                                       class="col-lg-3 text-lg-right text-black"> {{ __('Path') }} </label>
                                <div class="col-lg-9">
                                    <input type="text" name="path" id="loadPath" class="form-control flat-input"
                                           placeholder="{{ __('Path') }}">
                                    @if ($errors->has('path'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('path') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary" type="submit">{{ __('Download') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content area end -->
@endsection
