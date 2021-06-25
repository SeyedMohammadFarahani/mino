@extends('layouts.manager')
<head>
    <title>ویرایش فرآیند</title>
    <style>
        label {
            font-size: medium;
            font-weight: bold;
        }
    </style>
</head>

@section('content')
    <h3 class="d-flex justify-content-sm-center" style="margin: 20px">ویرایش فرآیند محصول</h3>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-7">

                <form id="create_user_form" method="post"
                      action="{{ route('actions.update', ['id' => $action->id])}}"
                      enctype="multipart/form-data">
                    @csrf
                    {{ method_field('patch') }}

                    <div class="card text-right justify-content-lg-end">

                        <div class="card-header d-flex justify-content-center" style="margin-bottom: 20px">
                            <h4 class="title">{{ __('مشخصات فرآیند') }}</h4>
                        </div>

                        <div class="form-group row">
                            <label for="name"
                                   class="col-md-4 col-form-label text-md-right">{{ __('نام فرآیند') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" dir="rtl" step=".0001"
                                       class="form-control @error('name') is-invalid @enderror"
                                       maxlength="50"
                                       name="name"
                                       value="{{$action->name}}" autofocus>
                                @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="price"
                                   class="col-md-4 col-form-label text-md-right">{{ __('هزینه سربار (ریال)') }}</label>
                            <div class="col-md-6">
                                <input id="price" type="number" dir="rtl"
                                       class="form-control @error('price') is-invalid @enderror"
                                       name="price"
                                       value="{{ $action->price }}">
                                @error('price')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="salary"
                                   class="col-md-4 col-form-label text-md-right">{{ __('هزینه دستمزد (ریال)') }}</label>
                            <div class="col-md-6">
                                <input id="salary" type="number" dir="rtl" step=".0001"
                                       class="form-control @error('salary') is-invalid @enderror"
                                       name="salary" value="{{ $action->salary }}">
                                @error('salary')
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

