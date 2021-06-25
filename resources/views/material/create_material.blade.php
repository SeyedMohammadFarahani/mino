@extends('layouts.manager')
<head>
    <title>ایجاد ماده خام جدید</title>
    <style>
        label {
            font-size: medium;
            font-weight: bold;
        }
    </style>
</head>

@section('content')
    <h3 class="d-flex justify-content-sm-center" style="margin: 20px">اضافه کردن ماده خام جدید</h3>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-7">

                <form id="create_user_form" method="post" action="{{route('materials.save')}}"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="card text-right justify-content-lg-end">

                        <div class="card-header d-flex justify-content-center" style="margin-bottom: 20px">
                            <h4 class="title">{{ __('مشخصات ماده خام') }}</h4>
                        </div>

                        <div class="form-group row">
                            <label for="name"
                                   class="col-md-4 col-form-label text-md-right">{{ __('نام ماده خام') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" dir="rtl"
                                       class="form-control @error('name') is-invalid @enderror"
                                       maxlength="50"
                                       name="name"
                                       value="{{ old('name')}}" autofocus>
                                @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="price"
                                   class="col-md-4 col-form-label text-md-right">{{ __('قیمت به ازای هر کیلوگرم (ریال)') }}</label>
                            <div class="col-md-6">
                                <input id="price" type="number" dir="rtl" step=".0001"
                                       class="form-control @error('price') is-invalid @enderror"
                                       name="price" autofocus>
                                @error('price')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row d-flex justify-content-md-end">
                            <div class="col-md-6 ">
                                <input type="submit"
                                       name="submit"
                                       class="btn btn-primary btn-outline-white d-flex justify-content-md-end"
                                       value="ایجاد"/>
                            </div>
                        </div>

                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection

