@extends('layouts.app')

<head>
    <title>
        BOM گزارش
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
                            <h4 class="title">{{ __('BOM') }}</h4>
                        </div>

                         <table class="table table-bordered mb-0" border="1" width="100%" style="direction: rtl">
                            <col style="width:55%">
	                          <col style="width:20%">
	                          <col style="width:25%">
                              <thead class="thead-light" >
                                <tr>
                                  <th>شرح مواد اولیه</th>
                                  <th>درصد</th>
                                </tr>
                              </thead>
                              <tbody>
                              @foreach($selectedMaterials as $material)
                                <tr>
                                  <td>{{$material}}</td>
                                  <td>   %{{number_format($percentPair[$material],10,'.',',')}}</td>
                                </tr>
                              @endforeach
                              </tbody>
                         </table>
                         <table class="table table-report table-bordered mb-0" border="1" width="100%" style="direction: rtl">
                              <col style="width:55%">
                            <col style="width:20%">
                            <col style="width:25%">
                              <thead class="thead-light" >
                                  <tr>
                                    <th>فرایند های مورد نیاز بر روی مواد اولیه</th>
                                    <th>مواد کمک فرایند </th>
                                    <th>وزن
                                      <br> (کیلوگرم)</th>
                                  </tr>
                                </thead>
                                <tbody>
                              @foreach($materialProcesses as $process)
                                  <tr>
                                    <td  rowspan="{{getProcessMaterialNumber($process,$materialAcidsPairKey)}}">{{$process}}</td>
                                  </tr>
                                  @foreach($materialAcidsPairKey as $key)
                                
                                  @if(checkString($process,$key))
              
                                          <tr>
                                              <td>{{getMaterial($key)}}</td>
                                              <td>  {{number_format($materialAcidsPair[$key],10,'.',',')}}</td>
                                            </tr>
          
                                      @endif
                                  @endforeach
                          
                                @endforeach
                                </tbody>
                         </table>
                                <table class="table table-report table-bordered mb-0" border="1" width="100%" style="direction: rtl">
                                <col style="width:55%">
                            <col style="width:20%">
                            <col style="width:25%">
                                <thead class="thead-light" >
                                  <tr>
                                    <th>فرایند های مورد نیاز بر روی محصول نهایی</th>
                                    <th>مواد کمک فرآیند </th>
                                    <th>وزن
                                      <br> (کیلوگرم)</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @foreach($productProcesses as $process)
                                  <tr>
                                    <td rowspan="{{getActionMaterialNumber($process,$productAcidsPairKey)}}">{{$process}}</td>
                                  </tr>
                                  @foreach($productAcidsPairKey as $key)
                                  @if(checkAction($process,$key))
                                  <tr>
                                    <td  >{{getMaterial($key)}}</td>
                                    <td> {{number_format($productAcidsPair[$key],10,'.',',')}} 
                                    </td>
                                  </tr>
                                  @endif
                                  @endforeach
                                @endforeach
                                </tbody>
                              
                            </table>
                     


                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection
