@extends('layouts.app')

<head>
    <title>
        ثبت نهایی
    </title>
</head>
@section('content')

    <div class="container page-body-wrapper mr-0">

        @if(session('flash_message'))
            <div class="alert alert-{{session('flash_message_level') }} alert-dismissible d-flex justify-content-center"
                 role="alert" style="font-size: medium; font-weight: bold">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('flash_message') }}
            </div>
        @endif
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
                            <input type="checkbox" checked>
                            <span class="checkbox-custom circular"></span>
                        </label>
                        <span class="menu-title">ثبت سفارش و گزارش</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="row justify-content-center main-panel">

            <h3 style="margin:20px;margin-right: 100px;text-align:right;"> ثبت نهایی سفارش و دریافت گزارش</h3>

            <div class="col-md-10">

                <form action="{{ route('products.create.step.six.post') }}" method="post">
                    @csrf

                    <div class="card card-report text-right justify-content-lg-end">
                        <table class="table mb-0" style="direction: rtl">
                            <thead>
                            <tr>
                                <th>نام محصول: {{$productName}} - {{$productCode}}</th>
                                <th>تاریخ تنظیم: {{$createDate}}</th>
                                <th></th>
                            </tr>
                            </thead>
                        </table>
                        <table class="table table-report table-bordered mb-0" border="1" width="100%" style="direction: rtl">
                            <col style="width:55%">
                            <col style="width:20%">
                            <col style="width:25%">
                            <thead class="thead-light">
                            <tr>
                                <th>شرح مواد اولیه</th>
                                <th>درصد</th>
                                <th>هزینه</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($selectedMaterials as $material)
                                <tr>
                                    <td>{{$material}}</td>
                                    <td> %{{number_format($percentPair[$material],10,'.',',')}}</td>
                                    <td> {{number_format($materialPricePair[$material],10,'.',',')}} ریال</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                            <table class="table table-report table-bordered mb-0" border="1" width="100%" style="direction: rtl">
                              <col style="width:20%">
                            <col style="width:15%">
                            <col style="width:15%">
                            <col style="width:15%">
                            <col style="width:15%">
                            <col style="width:20%">
                            <thead class="thead-light">
                                <tr>
                                    <th>فرایند های مورد نیاز بر روی مواد اولیه
                                    </th>
                                    <th>هزینه سربار
                                       <br>  (ریال)</th>
                                    <th>هزینه دستمزد
                                        <br> (ریال)</th>
                                    <th>مواد کمک فرایند  

                                    </th>
                                    <th>وزن
                                        <br> (کیلوگرم)</th>
                                    <th>هزینه
                                        <br> (ریال)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($materialProcesses as $process)
                                <tr>
                                    <td  rowspan="{{getProcessMaterialNumber($process,$materialAcidsPairKey)}}">{{$process}}</td>
                                    <td  rowspan="{{getProcessMaterialNumber($process,$materialAcidsPairKey)}}">  {{number_format($materialProcessesPricePair[$process],4,'.',',')}}</td>
                                    <td  rowspan="{{getProcessMaterialNumber($process,$materialAcidsPairKey)}}"> {{number_format($materialProcessesSalaryPair[$process],4,'.',',')}}</td>
                                </tr>
                                    @foreach($materialAcidsPairKey as $key)

                                    @if(checkString($process,$key))

                                            <tr>
                                                <td>{{getMaterial($key)}}</td>
                                                <td>  {{number_format($materialAcidsPair[$key],10,'.',',')}}</td>
                                                <td> {{number_format($acidPricePair[$key],10,'.',',')}}</td>
                                              </tr>

                                        @endif
                                    @endforeach

                                @endforeach

                              </tbody>
                            </table>
                                        <table class="table table-report table-bordered mb-0" border="1" width="100%" style="direction: rtl">

                          
                                            <thead class="thead-light">
                                            <tr>
                                                <th  style="width:200px">نام فرایند محصول نهایی</th>
                                                <th  style="width:150px"> هزینه سربار
                                                    <br> (ریال)</th>
                                                <th  style="width:150px">هزینه دستمزد
                                                    <br> (ریال)</th>
                                                <th  style="width:150px">مواد کمک فرآیند</th>
                                                <th  style="width:150px">وزن
                                                    <br> (کیلوگرم)</th>
                                                <th  style="width:200px">هزینه
                                                    <br> (ریال)</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($productProcesses as $process)
                                            <tr>

                                                <td rowspan="{{getActionMaterialNumber($process,$productAcidsPairKey)}}">{{$process}}</td>
                                                <td rowspan="{{getActionMaterialNumber($process,$productAcidsPairKey)}}">  {{number_format($productProcessesPricePair[$process],4,'.',',')}}

                                                </td>
                                                <td rowspan="{{getActionMaterialNumber($process,$productAcidsPairKey)}}"> {{number_format($productProcessesSalaryPair[$process],4,'.',',')}}

                                                </td>
                                                @foreach($productAcidsPairKey as $key)

                                                @if(checkAction($process,$key))
                                                <tr>
                                                <td  >{{getMaterial($key)}}</td>
                                                <td> {{number_format($productAcidsPair[$key],10,'.',',')}}
                                                </td>
                                                <td> {{number_format($productAcidPricePair[$key],10,'.',',')}}
                                                </td>
                                            </tr>
                                                @endif
                                                @endforeach
                                            </tr>
                                            @endforeach

                              </tbody>
                            </table>
                                                    <table class="table table-report table-bordered mb-0" border="1" width="100%" style="direction: rtl">

                                                    <thead class="thead-light">
                                                    <tr>
                                                        <th>بسته بندی</th>
                                                        <th>مقدار</th>
                                                        <th>هزینه</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($packsPairKey as $key)
                                                        <tr>
                                                            <td>{{$key}}</td>
                                                            <td> {{number_format($packsPair[$key],10,'.',',')}} {{$packUnitPair[$key]}}</td>
                                                            <td>{{number_format($packPricePair[$key],10,'.',',')}}
                                                                ریال
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                    <tbody class="thead-light">
                                                    <tr>
                                                        <th></th>
                                                        <th>جمع نهایی:</th>
                                                        <th>{{number_format($totalPrice,10,'.',',')}} ریال</th>

                                                    </tr>
                                                    </tbody>
                        </table>


                        <hr>
                        <div class="form-group row d-flex justify-content-md-end">
                            <label class="col-md-6 col-form-label text-md-right"
                                   style="font-weight: bold; font-size:x-large; margin-right: 10px">سفارش خود را نهایی
                                می کنید؟</label>
                        </div>

                        <div class="card-footer text-right" style="margin: 5px">

                            <a class="btn btn-primary  justify-content-center" dir="ltr"
                               href="{{route('products.get.report')}}">دریافت گزارش موقت</a>

                            <button type="submit" class="btn btn-primary">ثبت سفارش</button>

                            <a class="btn btn-primary  justify-content-center" dir="ltr" href="{{route('home')}}">بازگشت
                                به صفحه اصلی</a>

                        </div>


                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection
