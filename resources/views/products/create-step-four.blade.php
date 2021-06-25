@extends('layouts.app')

<head>
    <title>
        فرآیندهای محصول
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

            <h3 style="margin-right: 100px;margin-bottom:20px;text-align:right;">فرآیندهای مورد نظر را برای محصول نهایی
                انتخاب کنید</h3>

            <div class="col-md-10">

                <form action="{{ route('products.create.step.four.post') }}" method="post">
                    @csrf

                    <div class="card text-right justify-content-lg-end">
                        <div class="row" style="flex-direction:row-reverse;">
                        @foreach($processes as $process)
                          <div class="col-6" > 
                            <div class="form-group row d-flex justify-content-md-end mt-3">
                                <label for="{{$process->name}}"
                                       class="col-md-4 col-form-label text-md-right">{{$process->name}}</label>
                                <div class="col-md-1 mr-4">
                                    <input id="{{$process->id}}" type="checkbox"
                                           class="form-control"
                                           style="width:20px;"
                                           name="productProcesses[]" value="{{$process->name}}"
                                           onclick="disableInputprocess(this,'{{$process->name}}',{{$acids}})">
                                </div>
                            </div>
                            @foreach($acids as $acid)
                                <div id="label:{{$process->name}}:{{$acid->id}}" for="{{$acid->name}}" class="form-group row  process">
                                    <label 
                                           class="col-md-5 col-form-label text-md-right">{{$acid->name}}</label>
                                    <div class="col-md-6 mr-2">
                                        <input id="{{$process->name}}:{{$acid->id}}"
                                               type="number"
                                               step=".0000000001"
                                               class="form-control process"
                                               name="productAcids[]"
                                               style="margin-bottom: 10px">
                                        <input type="hidden"
                                               class="form-control"
                                               name="hiddenProductAcids[]"
                                               value="{{$acid->name}}:{{$process->name}}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @endforeach
</div>

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
