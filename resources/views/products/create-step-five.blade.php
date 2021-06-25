@extends('layouts.app')

<head>
    <title>
        ثبت نهایی
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
                            <input type="checkbox" checked>
                            <span class="checkbox-custom circular"></span>
                        </label>
                        <span class="menu-title">فرآیند های محصول</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <label class="checkbox-label">
                            <input type="checkbox" checked>
                            <span class="checkbox-custom circular"></span>
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
        <div class="row justify-content-center main-panel">

            <h3 style="margin-right: 100px;margin-bottom:20px;text-align:right;">محصولات مورد نیاز برای بسته بندی</h3>

            <div class="col-md-10">

                <form action="{{ route('products.create.step.five.post') }}" method="post">
                    @csrf

                    <div class="card text-right justify-content-lg-end">

                        <div class="card-header d-flex justify-content-center" style="margin-bottom: 20px">
                            <h4 class="title">{{ __('لیست بسته بندی ها') }}</h4>
                        </div>
                        <div class="row" style="flex-direction:row-reverse;">
                        @foreach($packs as $pack)
                        <div class="col-6" > 
                            <div class="form-group row d-flex justify-content-md-end">
                                <label for="{{$pack->name}}"
                                       class="col-md-6 col-form-label text-md-right">{{$pack->name}}</label>
                                <div class="col-md-1 mr-4">
                                    <input id="{{$pack->id}}" type="checkbox"
                                           class="form-control"
                                           style="width:20px;"
                                           name="packs[]" value="{{$pack->name}}"
                                           onclick="disableInputPacks(this,'{{$pack->name}}','{{$pack->name}}:{{$pack->id}}',{{$packs}})">
                                </div>
                            </div>

                            <div class="form-group row d-flex justify-content-md-end" style="margin-right: 10px">
                                <label for="{{$pack->unit}}"
                                       class="col-md-5 col-form-label text-md-right">{{$pack->unit}}</label>
                                <div class="col-md-6 mr-2">
                                    <input id="{{$pack->name}}"
                                           type="number"
                                           step=".0000000001"
                                           disabled
                                           class="form-control"
                                           name="units[]">
                                    <input type="hidden"
                                           class="form-control"
                                           id="{{$pack->name}}:{{$pack->id}}"
                                           disabled
                                           name="hiddenUnits[]"
                                           value="{{$pack->name}}">
                                </div>
                            </div>
                        </div>
                        @endforeach
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">ادامه</button>
                            <a class="btn btn-primary" href="{{ route('products.create.step.four')}}" style="position:absolute;left:20px">بازگشت</a>
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
