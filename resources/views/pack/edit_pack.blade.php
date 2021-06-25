@extends('layouts.manager')
<head>
    <title>ویرایش بسته بندی</title>
    <style>
        label {
            font-size: medium;
            font-weight: bold;
        }
    </style>
</head>

@section('content')
    <h3 class="d-flex justify-content-sm-center" style="margin: 20px">ویرایش اطلاعات بسته بندی</h3>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-7">

                <form id="create_user_form" method="post"
                      action="{{ route('packs.update', ['id' => $pack->id])}}"
                      enctype="multipart/form-data">
                    @csrf
                    {{ method_field('patch') }}

                    <div class="card text-right justify-content-lg-end">

                        <div class="card-header d-flex justify-content-center" style="margin-bottom: 20px">
                            <h4 class="title">{{ __('مشخصات بسته بندی') }}</h4>
                        </div>

                        <div class="form-group row">
                            <label for="name"
                                   class="col-md-4 col-form-label text-md-right">{{ __('نام بسته بندی') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" dir="rtl"
                                       class="form-control @error('name') is-invalid @enderror"
                                       maxlength="50"
                                       name="name"
                                       value="{{$pack->name}}" autofocus>
                                @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="unit"
                                   class="col-md-4 col-form-label text-md-right">{{ __('واحد') }}</label>
                            <div class="col-md-6">
                                <input id="unit" type="text" dir="rtl"
                                       class="form-control @error('unit') is-invalid @enderror"
                                       maxlength="50"
                                       name="unit"
                                       value="{{ $pack->unit}}" >
                                @error('unit')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="price"
                                   class="col-md-4 col-form-label text-md-right">{{ __('قیمت به ازای هر واحد (ریال)') }}</label>
                            <div class="col-md-6">
                                <input id="price" type="number" dir="rtl" step=".0001"
                                       class="form-control @error('price') is-invalid @enderror"
                                       name="price"
                                       value="{{ $pack->price }}">
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
                                       value="ثبت تغییرات"/>
                            </div>
                        </div>

                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection

