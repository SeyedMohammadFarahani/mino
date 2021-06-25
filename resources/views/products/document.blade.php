@extends('layouts.app')

<head>
    <title>
        گزارش مدیریتی
    </title>
</head>
@section('content')

    <div class="container">

        @if(session('flash_message'))
            <div class="alert alert-{{session('flash_message_level') }} alert-dismissible d-flex justify-content-center"
                 role="alert" style="font-size: medium; font-weight: bold">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('flash_message') }}
            </div>
        @endif

        <div class="row justify-content-center">


            <div class="col-md-10">

                <form action="{{ route('products.create.step.six.post') }}" method="post">
                    @csrf

                    <div class="card card-report text-right justify-content-lg-end">

                        <div class="card-header d-flex justify-content-center">
                            <h4 class="title">{{ __('گزارش مدیریتی') }}</h4>
                        </div>
                        <table class="table mb-0" style="direction: rtl">
                            <thead>
                            <tr>
                              <th >نام محصول: {{$productName}} - {{$productCode}}</th>
                              <th>تاریخ تنظیم: {{$createDate}}</th>
                              <th></th>
                            </tr>
                          </thead>
                          </table>
                  <table class="table table-report table-bordered mb-0" border="1" width="100%" style="direction: rtl">
                            <col style="width:55%">
	<col style="width:20%">
	<col style="width:25%">
                              <thead class="thead-light" >
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
                                  <td>   %{{number_format($percentPair[$material],10,'.',',')}}</td>
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
                              <thead class="thead-light" >
                                  <tr>
                                    <th>فرایند های مورد نیاز بر روی مواد اولیه</th>
                                    <th>هزینه سربار (ریال)</th>
                                    <th>هزینه دستمزد (ریال)</th>
                                    <th>مواد کمک فرایند </th>
                                    <th>وزن (کیلوگرم)</th>
                                    <th>هزینه (ریال)</th>
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
                                {{-- <thead class="thead-light" >
                                  <tr>
                                    <th>مواد کمک فرایند مورد نیاز برای فرآیند های مواد اولیه</th>
                                    <th>وزن</th>
                                    <th>هزینه</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @foreach($materialAcidsPairKey as $key)
                                  <tr>
                                    <td>{{$key}}</td>
                                    <td>  {{number_format($materialAcidsPair[$key],10,'.',',')}} کیلوگرم</td>
                                    <td> {{number_format($acidPricePair[$key],10,'.',',')}} ریال</td>
                                  </tr>
                                @endforeach
                                </tbody> --}}
                                <table class="table table-report table-bordered mb-0" border="1" width="100%" style="direction: rtl">
                                <thead class="thead-light" >
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
                                  </tr>
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
                                @endforeach
                                </tbody>
                                </table>
                                {{-- <thead class="thead-light" >
                                  <tr>
                                    <th>مواد کمک فرآیند مورد نیاز برای فرآیند های محصول نهایی</th>
                                    <th>وزن</th>
                                    <th>هزینه</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @foreach($productAcidsPairKey as $key)
                                  <tr>
                                    <td>{{$key}}</td>
                                    <td> {{number_format($productAcidsPair[$key],10,'.',',')}} کیلوگرم</td>
                                    <td> {{number_format($productAcidPricePair[$key],10,'.',',')}} ریال</td>
                                  </tr>
                                @endforeach
                                </tbody> --}}
                              <table class="table table-report table-bordered mb-0" border="1" width="100%" style="direction: rtl">
                                <thead class="thead-light" >
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
                                    <td>{{number_format($packPricePair[$key],10,'.',',')}} ریال</td>
                                  </tr>
                                @endforeach
                                </tbody>
                                <tbody class="thead-light">
                                  <tr>
                                      <th></th>
                                      <th>جمع نهایی:</th>
                                      <th>{{number_format($totalPrice,10,'.',',')}} ریال </th>

                                    </tr>
                                  </tbody>
                            </table>


                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection
