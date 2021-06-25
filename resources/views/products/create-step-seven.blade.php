@extends('layouts.app')

<head>
    <title>
        دریافت گزارش
    </title>
</head>
@section('content')

    <div class="container">



        <div class="row justify-content-center mt-5">

            <div class="col-md-10">

                <div class="card text-right d-flex justify-content-sm-center">

                    <div class="card-header d-flex justify-content-center" style="margin-bottom: 20px">
                        <h4 class="title">{{ __('دریافت گزارش') }}</h4>
                    </div>

                    <div class="card-body justify-content-lg-end" style="margin-bottom: 20px">

                        <div class="form-group row">
                            <label
                                class="col-md-4 col-form-label text-md-right"
                                style="font-weight: bold">{{ __('قیمت نهایی (ریال)') }}</label>
                            <div class="col-md-2">
                                <input type="text" dir="ltr" disabled
                                       class="form-control"
                                       maxlength="50"
                                       value="{{number_format($totalPrice)}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label
                                class="col-md-4 col-form-label text-md-right"
                                style="font-weight: bold">{{ __('دریافت گزارش BOM') }}</label>
                            <div class="col-md-2">
                                <a class="btn btn-primary" dir="ltr" href="{{route('products.get.bom')}}">دریافت
                                    فایل</a>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label
                                class="col-md-4 col-form-label text-md-right"
                                style="font-weight: bold">{{ __('دریافت گزارش مدیریتی') }}</label>
                            <div class="col-md-2">
                                <a class="btn btn-primary " dir="ltr" href="{{route('products.get.report')}}">دریافت
                                    فایل</a>
                            </div>
                        </div>

                    </div>

                    <div class="card-footer text-right">
                        <a class="btn btn-primary" href="{{route('home')}}"> بازگشت به صفحه اصلی</a>
                    </div>

                </div>
                @if(session('flash_message'))
            <div class="alert alert-{{session('flash_message_level') }} alert-dismissible d-flex justify-content-center"
                 role="alert" style="font-size: medium; font-weight: bold">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('flash_message') }}
            </div>
        @endif
            </div>
        </div>
    </div>
@endsection
