@extends('layouts.app')

<head>
    <title>
        درصد ترکیب مواد
    </title>
</head>
@section('content')

    <div class="container  page-body-wrapper mr-0">
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
                <li class="nav-item" >
                    <a class="nav-link" href="#">
                        <label class="checkbox-label">
                            <input type="checkbox" checked>
                            <span class="checkbox-custom circular"></span>
                        </label>
                        <span class="menu-title">مواد خام</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <label class="checkbox-label">
                            <input type="checkbox" checked>
                            <span class="checkbox-custom circular"></span>
                        </label>
                        <span class="menu-title">فرایندهای روغن خام</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <label class="checkbox-label">
                            <input type="checkbox" checked>
                            <span class="checkbox-custom circular"></span>
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
        <div class="row justify-content-center   main-panel">

            <h3 style="margin-right: 100px;margin-bottom:20px;text-align:right;">درصد ترکیب مواد مورد نظر خود را انتخاب
                کنید</h3>

            <div class="col-md-10">

                <form action="{{ route('products.create.step.three.post') }}" method="post">
                    @csrf

                    <div class="card text-right justify-content-lg-end">

                        <div class="card-header d-flex justify-content-center" style="margin-bottom: 20px">
                            <h4 class="title">{{ __('درصد ترکیب مواد') }}</h4>
                        </div>
                        <div class="row" style="flex-direction:row-reverse;">
                        @foreach($selectedMaterials as $material)
                            <div class="col-6" >  
                            <div class="form-group row d-flex justify-content-md-end" style="margin-right: 10px">
                                <label
                                    class="col-md-6 col-form-label text-md-right">{{$material}}</label>
                            </div>

                            <div class="form-group row d-flex justify-content-md-end" style="margin-right: 10px">
                                <label
                                    class="col-md-3 col-form-label text-md-right">درصد</label>
                                <div class="col-md-8 mr-2">
                                    <input type="number"
                                           step=".0000000001"
                                           class="form-control"
                                           name="percents[]"
                                           style="margin-bottom: 10px">
                                    <input type="hidden"
                                           class="form-control"
                                           name="hiddenPercents[]"
                                           value="{{$material}}">

                                </div>
                            </div>
                            </div>
                        @endforeach
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">ادامه</button>
                            <a class="btn btn-primary" href="{{ route('products.create.step.two')}}" style="position:absolute;left:20px">بازگشت</a>
                        </div>

                    </div>

                </form>
                @if(session('flash_message'))
                    <div
                        class="alert alert-{{session('flash_message_level') }} alert-dismissible d-flex justify-content-center"
                        role="alert" style="font-size: medium; font-weight: bold">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{ session('flash_message') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
