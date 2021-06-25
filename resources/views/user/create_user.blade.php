@extends('layouts.manager')
<head>
    <title>ایجاد کاربر جدید</title>
    <style>
        label {
            font-size: medium;
            font-weight: bold;
        }
    </style>
</head>

@section('content')
    <h3 class="d-flex justify-content-sm-center" style="margin: 20px">اضافه کردن کاربر جدید</h3>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-7">

                <form id="create_user_form" method="post" action="{{route('users.save')}}"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="card text-right justify-content-lg-end">

                        <div class="card-header d-flex justify-content-center" style="margin-bottom: 20px">
                            <h4 class="title">{{ __('مشخصات کاربر') }}</h4>
                        </div>

                        <div class="form-group row">
                            <label for="name"
                                   class="col-md-4 col-form-label text-md-right">{{ __('نام') }}</label>
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
                            <label for="lastName"
                                   class="col-md-4 col-form-label text-md-right">{{ __('نام خانوادگی') }}</label>
                            <div class="col-md-6">
                                <input id="lastName" type="text" dir="rtl"
                                       class="form-control @error('lastName') is-invalid @enderror"
                                       maxlength="50"
                                       name="lastName"
                                       value="{{ old('lastName')}}">
                                @error('lastName')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username"
                                   class="col-md-4 col-form-label text-md-right">{{ __('نام کاربری') }}</label>
                            <div class="col-md-6">
                                <input id="username" type="text" dir="ltr"
                                       class="form-control @error('username') is-invalid @enderror"
                                       maxlength="50"
                                       name="username"
                                       value="{{ old('username')}}">
                                @error('username')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password"
                                   class="col-md-4 col-form-label text-md-right">{{ __('رمز عبور') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" dir="ltr"
                                       class="form-control @error('password') is-invalid @enderror"
                                       name="password">
                                @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="role"
                                   class="col-md-4 col-form-label text-md-right">{{ __('نقش') }}</label>
                            <div class="col-md-6">
                                <select id="role" dir="rtl"
                                        class="form-control @error('role') is-invalid @enderror"
                                        name="role">
                                    <option value="" selected>هیچ</option>
                                    <option value="manager">مدیر</option>
                                    <option value="seller">مدیر تولید</option>
                                    <option value="user">کاربر</option>
                                </select>
                                @error('role')
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

