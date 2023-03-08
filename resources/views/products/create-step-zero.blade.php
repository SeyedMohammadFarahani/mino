@extends('layouts.app')

<head>
    <title>
        انتخاب مواد خام
    </title>
</head>

@section('content')

    <div class="container page-body-wrapper mr-0">

        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                <li class="nav-item" style="padding-top:20vh;">
                    <a class="nav-link" href="#">
                        <label class="checkbox-label">
                            <input type="checkbox" checked>
                            <span class="checkbox-custom circular"></span>
                        </label>
                        <span class="menu-title">نام محصول</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <label class="checkbox-label">
                            <input type="checkbox" disabled>
                            <span class="checkbox-custom circular" style="opacity:.4;"></span>
                        </label>
                        <span class="menu-title">مواد خام</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <label class="checkbox-label">
                            <input type="checkbox" disabled>
                            <span class="checkbox-custom circular" style="opacity:.4;"></span>
                        </label>
                        <span class="menu-title">فرایندهای روغن خام</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <label class="checkbox-label">
                            <input type="checkbox" disabled>
                            <span class="checkbox-custom circular" style="opacity:.4;"></span>
                        </label>
                        <span class="menu-title">درصد ترکیب مواد</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <label class="checkbox-label">
                            <input type="checkbox" disabled>
                            <span class="checkbox-custom circular" style="opacity:.4;"></span>
                        </label>
                        <span class="menu-title">فرآیند های محصول</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <label class="checkbox-label">
                            <input type="checkbox" disabled>
                            <span class="checkbox-custom circular" style="opacity:.4;"></span>
                        </label>
                        <span class="menu-title">بسته بندی</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <label class="checkbox-label">
                            <input type="checkbox" disabled>
                            <span class="checkbox-custom circular" style="opacity:.4;"></span>
                        </label>
                        <span class="menu-title">ثبت سفارش و گزارش</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="row justify-content-center  main-panel">

            <h3 style="margin-right: 100px;margin-bottom:20px;text-align:right;">نام محصول خود را انتخاب کنید</h3>

            <div class="col-md-10">
                @if(session('flash_message'))
                    <div
                        class="alert alert-{{session('flash_message_level') }} alert-dismissible d-flex justify-content-center"
                        role="alert" style="font-size: medium; font-weight: bold">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{ session('flash_message') }}
                    </div>
                @endif

                <form action="{{ route('products.create.step.zero.post') }}" method="post">
                    @csrf

                    <div class="card text-right justify-content-lg-end">

                        <div class="card-header d-flex justify-content-center" style="margin-bottom: 20px">
                            <h4 class="title">{{ __('نام محصول') }}</h4>
                        </div>

                        <div class="form-group row">
                            <label for="productName"
                                   class="col-md-4 col-form-label text-md-right">{{ __('نام محصول') }}</label>
                            <div class="col-md-6">
                                <input id="productName" type="text" dir="rtl"
                                       class="form-control @error('productName') is-invalid @enderror"
                                       maxlength="50"
                                       name="productName"
                                       value="{{ old('productName')}}">
                                @error('productName')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="productCode"
                                   class="col-md-4 col-form-label text-md-right">{{ __('کد محصول') }}</label>
                            <div class="col-md-6">
                                <input id="productCode" type="text" dir="rtl"
                                       class="form-control @error('productCode') is-invalid @enderror"
                                       maxlength="50"
                                       name="productCode"
                                       value="{{ old('productCode')}}">
                                @error('productCode')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">ادامه</button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection

