<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('files/favicon.png') }}" type="image/x-icon">
    <title>{{readableValue('QWN0aXZlIFlvdXIgTGljZW5zZQ==')}}</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('zaifiles/assets/style.css') }}">
</head>
<body>
@yield('preloader')

<div class="overlay-wrap">
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="breadcrumb-text">
                        <a class="brand-logo" href="#"><img src="{{ getImageFile(get_option('app_logo')) }}" alt="logo"></a>
                        <h2>{{base64_decode('TE1TWkFJIC0gTGVhcm5pbmcgTWFuYWdlbWVudCBTeXN0ZW0=')}}</h2>
                        <p>{{ \Carbon\Carbon::parse(now())->format('l, j F Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pre-installation-area">
        <div class="container">
            <div class="section-wrap">
                <div class="section-wrap-header">
                    <div class="progres-stype">
                        <form action="{{ route(readableValue('bGljZW5zZS5hY3RpdmF0ZQ==')) }}" method="POST">
                            @csrf
                            <!-- Success and Error Message Display -->
                            <!-- End of Success and Error Message Display -->
                            <h1 class="fs-3">{{base64_decode('UGxlYXNlIGFjdGl2YXRlIHlvdXIgbGljZW5zZQ==')}}</h1>
                            @if(session('success'))
                                <div class="alert alert-success mt-3">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger mt-3">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <div class="mt-3">
                                <div class="single-section">
                                    <div class="gap-2 row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="domain">Domain</label>
                                                <input type="text" disabled class="form-control" id="domain" name="domain"
                                                       value="{{ get_domain_name(request()->fullUrl()) }}" readonly/>
                                            </div>
                                            @if($errors->has('domain'))
                                                <div class="error text-danger">{{ $errors->first('domain') }}</div>
                                            @endif
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="email">Customer E-mail</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                       value="{{ old('email') }}" placeholder="example@example.com"/>
                                            </div>
                                            @if($errors->has('email'))
                                                <div class="error text-danger">{{ $errors->first('email') }}</div>
                                            @endif
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="codecanyon_username">Codecanyon Username</label>
                                                <input type="text" class="form-control" id="codecanyon_username" name="codecanyon_username"
                                                       value="{{ old('codecanyon_username') }}" placeholder="User name"/>
                                            </div>
                                            @if($errors->has('codecanyon_username'))
                                                <div class="error text-danger">{{ $errors->first('codecanyon_username') }}</div>
                                            @endif
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="purchase_code">Item purchase code</label>
                                                <input type="text" class="form-control" id="purchase_code"
                                                       name="purchase_code" value="{{ old('purchase_code') }}"
                                                       placeholder=""/>
                                            </div>
                                            @if($errors->has('purchase_code'))
                                                <div class="error text-danger">{{ $errors->first('purchase_code') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <button class="primary-btn next" id="submitNext" type="submit">Enable License</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript -->
<script src="{{ asset('frontend/assets/vendor/jquery/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('frontend/assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>

@stack('script')
</body>
</html>
