@extends('layouts.app')

<head>
    <title>
        انتخاب فرآیند روغن خام
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


            <h3 style="margin-right: 100px;margin-bottom:20px;margin-top:30px ;text-align:right;">فرآیندهای مورد نظر خود
                را انتخاب
                کنید</h3>
            <div class="col-md-10">

                <form action="{{ route('products.create.step.two.post') }}" method="post">
                    @csrf

                    @foreach($selectedMaterials as $material)
                        <div class="card text-right justify-content-lg-end">

                            <div class="card-header " style="margin-bottom: 20px">
                                <h4 class="title">{{$material}}</h4>
                            </div>
                            <div class="row">
                            @foreach($processes as $process)
                            <div class="col-6">                                @if($process->material==$material)
                                    <div class="form-group row d-flex justify-content-md-end">
                                        <label for="{{$process->name}}"
                                               class="col-md-4 col-form-label text-md-right">{{$process->name}}</label>
                                        <div class="col-md-1 mr-4">
                                            <input id="{{$process->id}}" type="checkbox"
                                            style="width:20px;"
                                                   class="form-control"
                                                   name="processes[]" value="{{$process->name}}:{{$material}}"
                                                   onclick="disableInputAcid(this,'{{$material}}','{{$process->name}}',{{$acids}})">
                                        </div>
                                    </div>
                                    @foreach($acids as $acid)
                                        <div  id="label:{{$material}}:{{$process->name}}:{{$acid->id}}" class="form-group row process">
                                            <label
                                                class="col-md-5 col-form-label text-md-right">{{$acid->name}}</label>
                                            <div class="col-md-6 mr-2">
                                                <input id="{{$material}}:{{$process->name}}:{{$acid->id}}"
                                                       type="number"
                                                       step=".0000000001"
                                                       class="form-control process"
                                                       name="acids[]"
                                                       style="margin-bottom: 10px">

                                                <input type="hidden"
                                                       class="form-control"
                                                       name="hiddenAcids[]"
                                                       value="{{$acid->name}}:{{$process->name}}:{{$material}}">
                                            </div>
                                        </div>
                                    @endforeach

                                @endif
                                </div>
                            @endforeach
</div>
                            @endforeach


                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary">ادامه</button>
                                <a class="btn btn-primary" href="{{ url()->previous()}}" style="position:absolute;left:20px">بازگشت</a>
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
