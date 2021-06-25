@extends('layouts.manager')
<head>
    <title>ویرایش تراکنش</title>
    <style>
        label {
            font-size: medium;
            font-weight: bold;
        }
    </style>
</head>

@section('content')
    <h3 class="d-flex justify-content-sm-center" style="margin: 20px">ویرایش اطلاعات تراکنش</h3>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-7">

                <form id="create_user_form" method="post"
                      action="{{ route('transactions.update', ['id' => $transaction->id])}}"
                      enctype="multipart/form-data">
                    @csrf
                    {{ method_field('patch') }}

                    <div class="card text-right justify-content-lg-end">

                        <div class="card-header d-flex justify-content-center" style="margin-bottom: 20px">
                            <h4 class="title">{{ __('مشخصات تراکنش') }}</h4>
                        </div>


                        <div class="form-group row">
                            <label for="product_code"
                                   class="col-md-4 col-form-label text-md-right">{{ __('کد محصول') }}</label>
                            <div class="col-md-6">
                                <input id="product_code" type="text" dir="rtl"
                                       class="form-control @error('product_code') is-invalid @enderror"
                                       name="product_code" value="{{$transaction->product_code}}">
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
                                       name="product_name" value="{{$transaction->product_name}}">
                                @error('product_name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="weight"
                                   class="col-md-4 col-form-label text-md-right">{{ __('وزن') }}</label>
                            <div class="col-md-6">
                                <input id="weight" type="number" dir="rtl" step=".0001"
                                       class="form-control @error('weight') is-invalid @enderror"
                                       name="weight" value="{{ $transaction->weight}}">
                                @error('weight')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="finalPrice"
                                   class="col-md-4 col-form-label text-md-right">{{ __('قیمت نهایی') }}</label>
                            <div class="col-md-6">
                                <div id="finalPrice" type="number" dir="rtl" step=".0001"
                                       class="form-control @error('finalPrice') is-invalid @enderror">{{ number_format($transaction->finalPrice,4,'.',',')}}
                                </div>
                                @error('finalPrice')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="soldPrice"
                                   class="col-md-4 col-form-label text-md-right">{{ __('قیمت فروش') }}</label>
                            <div class="col-md-6">
                                <input id="soldPrice" type="number" dir="rtl" step=".0001"
                                       class="form-control @error('soldPrice') is-invalid @enderror"
                                       name="soldPrice" >
                                @error('soldPrice')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row d-flex justify-content-md-end">
                            <div class="col-md-6 ">
                                <input type="submit"
                                       name="submit"
                                       class="btn btn-primary btn-outline-white d-flex justify-content-md-end"
                                       value="ثبت تغیرات"/>
                            </div>
                        </div>

                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection

{{--<script>
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
                    /*$('#finalPrice').html(response.finalPrice);*/
                }
            }
        });

        return false;
    }

</script>--}}
