@extends('layouts.app')

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>صفحه اصلی</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

</head>

@section('content')

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-10 mt-5">

                <div class="card">

                    <div class="card-header d-flex justify-content-md-end" style="font-weight: bold">مدیریت محصولات
                    </div>

                    <div class="card-body">

                        <a href="{{ route('products.create.step.zero') }}" class="btn btn-primary pull-right mb-3">ایجاد
                            محصول
                            جدید</a>

                        @if (Session::has('message'))
                            <div class="alert alert-info">{{ Session::get('message') }}</div>
                        @endif

                        <table class="table">

                            <thead class="thead-dark">

                            <tr>
                                <th width="50px">{{--<input type="checkbox" id="master">--}}</th>
                                <th scope="col">ردیف</th>
                                <th scope="col">نام محصول</th>
                                <th scope="col">کد محصول</th>
                                <th scope="col">قیمت تمام شده</th>
                                <th scope="col">وضعیت محصول</th>
                                <th scope="col">تاریخ ثبت</th>
                                <th scope="col">دریافت گزارش</th>
                            </tr>

                            </thead>

                            <tbody>
                            <?php $i = 1; ?>
                            @foreach($products as $product)

                                <tr id="tr_{{$product->id}}">
                                    <td>{{--<input type="checkbox" name="products[]" value="{{$product->id}}">--}}</td>
                                    <th scope="row"> <?php echo $i;?> </th>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->code }}</td>
                                    <td>{{ number_format($product->price,4,'.',',') }}</td>
                                    @if($product->state == "confirmed")
                                        <td>تایید شده</td>
                                    @elseif($product->state == "nonConfirmed")
                                        <td>تایید نشده</td>
                                    @endif
                                    <td>{{ $product->date }}</td>
                                    <td><i class="icon-trash"></i>
                                        <a class="btn btn-success"
                                           href="{{ route('products.download', ['fileName' => $product->fileName]) }}">دانلود</a>
                                    </td>
                                </tr>
                                <?php $i++;?>
                            @endforeach
                            </tbody>

                        </table>

                    </div>

                </div>

                <div style="margin-top:20px" class="d-flex justify-content-center">
                    {!! $products->links() !!}
                </div>
            </div>
        </div>
    </div>

@endsection
