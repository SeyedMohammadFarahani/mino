@extends('layouts.transaction')
<head>
    <title>ایجاد تراکنش جدید</title>
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
            $("#end_date").pDatepicker({
                "autoClose": true,
                format: 'YYYY/MM/DD',
                altField: '#date',
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
    <h3 class="d-flex justify-content-sm-center" style="margin: 20px">اضافه کردن تراکنش جدید</h3>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-7">

                <form id="create_user_form" method="post" action="{{route('transactions.save')}}"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="card text-right justify-content-lg-end">

                        <div class="card-header d-flex justify-content-center" style="margin-bottom: 20px">
                            <h4 class="title">{{ __('مشخصات تراکنش') }}</h4>
                        </div>


                        <div class="form-group row">
                            <label for="product_code"
                                   class="col-md-4 col-form-label text-md-right">{{ __('کد محصول') }}</label>
                            <div class="col-md-6">
                                <select id="product_code" dir="rtl"
                                        class="form-control @error('product_code') is-invalid @enderror"
                                        name="product_code"
                                        onchange="showProduct()">

                                    <option value="" selected>هیچ</option>
                                    @foreach($products as $product)
                                        <a href="{{ route('product.find', ['code' => $product->code])}}">
                                            <option value="{{$product->code}}">{{$product->code}}</option>
                                        </a>
                                    @endforeach
                                </select>
                                @error('product_code')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="product_name"
                                   class="col-md-4 col-form-label text-md-right">{{ __('نام محصول') }}</label>
                            <div class="col-md-6">
                                <input id="product_name" type="text" dir="rtl"
                                       class="form-control @error('product_name') is-invalid @enderror"
                                       name="product_name">
                                @error('product_name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="bom"
                                   class="col-md-4 col-form-label text-md-right">{{ __('BOM') }}</label>
                            <div class="col-md-6">
                                <a id="downloadBom" class="btn btn-success">دانلود</a>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="weight"
                                   class="col-md-4 col-form-label text-md-right">{{ __('وزن') }}</label>
                            <div class="col-md-6">
                                <input id="weight" type="number" dir="rtl" step=".0001"
                                       class="form-control @error('weight') is-invalid @enderror"
                                       name="weight" value="{{ old('weight')}}">
                                @error('weight')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date"
                                   class="col-md-4 col-form-label text-md-right">{{ __('تاریخ تولید') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="example1 form-control @error('date') is-invalid @enderror"
                                       id="end_date" name="end_date">
                                @error('date')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-md-6">
                                <input type="hidden" class="example1 form-control @error('date') is-invalid @enderror"
                                       id="date" name="date">
                                @error('date')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row d-flex justify-content-md-end">
                            <div class="col-md-6 ">
                                <input type="submit"
                                       name="submit"
                                       class="btn btn-primary btn-outline-white d-flex justify-content-md-end"
                                       value="ثبت تراکنش"/>
                            </div>
                        </div>

                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection

<script>
    function showProduct() {
        let code = $("#product_code").val();

        $.ajax({
            type: "GET",
            url: "/manager/transactions/find_product/" + code,

            data: {
                code: code,

            },
            success: function (response) {
                {
                    $('#product_name').val(response.product_name);
                    $('#downloadBom').attr("href", "/manager/transactions/download_bom/" + response.bom);
                }
            }
        });
        return false;
    }

</script>


