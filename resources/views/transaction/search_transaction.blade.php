@extends('layouts.transaction')
<head>
    <title>جست و جوی تراکنش ها</title>
    <style>
        label {
            font-size: medium;
            font-weight: bold;
        }
    </style>

    <link rel="stylesheet" href="{{asset('css/persian-datepicker.css')}}"/>

    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{asset('js/persian-date.js')}}"></script>
    <script src="{{asset('js/persian-datepicker.js')}}"></script>

    <script>

        $(document).ready(function () {
            $("#startDate").pDatepicker({
                "autoClose": true,
                format: 'YYYY/MM/DD',
                altField: '#startDateAlt',
                altFieldFormatter: function (d) {
                    const ye = new Intl.DateTimeFormat('en', {year: 'numeric'}).format(d);
                    const mo = new Intl.DateTimeFormat('en', {month: '2-digit'}).format(d);
                    const da = new Intl.DateTimeFormat('en', {day: '2-digit'}).format(d);
                    return `${ye}-${mo}-${da}`;
                }
            });

            $("#lastDate").pDatepicker({
                "autoClose": true,
                format: 'YYYY/MM/DD',
                altField: '#lastDateAlt',
                altFieldFormatter: function (d) {
                    const ye = new Intl.DateTimeFormat('en', {year: 'numeric'}).format(d);
                    const mo = new Intl.DateTimeFormat('en', {month: '2-digit'}).format(d);
                    const da = new Intl.DateTimeFormat('en', {day: '2-digit'}).format(d);
                    return `${ye}-${mo}-${da}`;
                }
            });

        })
    </script>

</head>

@section('content')
    <h3 class="d-flex justify-content-sm-center" style="margin: 20px">جست و جوی تراکنش ها</h3>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-7">

                <form id="create_user_form" method="get" action="{{route('transactions.search.result')}}"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="card text-right justify-content-lg-end">

                        <div class="card-header d-flex justify-content-center" style="margin-bottom: 20px">
                            <h4 class="title">{{ __('جست و جو بر اساس تاریخ') }}</h4>
                        </div>


                        <div class="form-group row">
                            <label for="firstDate"
                                   class="col-md-4 col-form-label text-md-right">{{ __('تاریخ شروع') }}</label>
                            <div class="col-md-6">
                                <input type="text"
                                       class="example1 form-control @error('firstDate') is-invalid @enderror"
                                       id="startDate" name="firstDate">
                                @error('firstDate')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-md-6">
                                <input type="hidden"
                                       class="example1 form-control @error('firstDate') is-invalid @enderror"
                                       id="startDateAlt" name="firstDateHidden">
                                @error('firstDate')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lastDate"
                                   class="col-md-4 col-form-label text-md-right">{{ __('تاریخ پایان') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="example1 form-control @error('lastDate') is-invalid @enderror"
                                       id="lastDate" name="lastDate">
                                @error('firstDate')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">

                            <div class="col-md-6">
                                <input type="hidden"
                                       class="example1 form-control @error('lastDate') is-invalid @enderror"
                                       id="lastDateAlt" name="lastDateHidden">
                                @error('firstDate')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row d-flex justify-content-md-end">
                            <div class="col-md-6 ">
                                <input type="submit"
                                       name="submit"
                                       class="btn btn-primary btn-outline-white d-flex justify-content-md-end"
                                       value="جست و جو"/>
                            </div>
                        </div>

                    </div>

                </form>
            </div>

            @if($transactions!= null)
                <div class="row" style="overflow: scroll">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr style="background: #4aa0e6">

                            <th scope="col">ردیف</th>
                            <th scope="col">نام محصول</th>
                            <th scope="col">کد محصول</th>
                            <th scope="col">وزن</th>
                            <th scope="col">تاریخ ثبت</th>
                            @if(auth()->user()->role == "manager")
                                <th scope="col">قیمت نهایی</th>
                                <th scope="col">قیمت فروش</th>
                                <th scope="col">میزان سود</th>
                                <th scope="col">ویرایش تراکنش</th>
                            @endif
                            <th scope="col">حذف تراکنش</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php $i = 1; ?>
                        @foreach($transactions as $transaction)

                            <tr id="tr_{{$transaction->id}}">

                                <th scope="row"> <?php echo $i;?> </th>
                                <td>{{ $transaction->product_name }}</td>
                                <td>{{ $transaction->product_code }}</td>
                                <td>{{ number_format($transaction->weight,4,'.',',') }}</td>
                                <td>{{ Morilog\Jalali\CalendarUtils::strftime('Y-m-d', $transaction->date) }}</td>
                                @if(auth()->user()->role == "manager")
                                    <td>{{ number_format($transaction->finalPrice,4,'.',',') }}</td>
                                    <td>{{ number_format($transaction->soldPrice,4,'.',',') }}</td>
                                    <td>{{ number_format($transaction->profit,4,'.',',') }}</td>
                                    <td><i class="icon-trash"></i>
                                        <a class="btn btn-warning"
                                           href="{{ route('transactions.edit', ['id' => $transaction->id]) }}">ویرایش</a>
                                    </td>
                                @endif
                                <td><i class="icon-trash"></i>
                                    <a class="btn btn-danger"
                                       href="{{ route('transactions.destroy', ['id' => $transaction->id])}}">حذف</a>
                                </td>

                            </tr>
                            <?php $i++;?>
                        @endforeach
                        </tbody>
                    </table>

                </div>

            @endif


        </div>
    </div>

@endsection

