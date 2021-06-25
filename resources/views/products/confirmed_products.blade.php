@extends('layouts.manager')

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>محصولات (تایید شده)</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        td {
            font-weight: bold;
            font-size: medium;
        }

        thead th {
            font-weight: bold;
            font-size: medium;
        }

        .table thead th {
            font-weight: bold;
            font-size: medium;
        }
    </style>

</head>

@section('content')

    <div class="container mt-5" style="width: 80%">

        @if(session('flash_message'))
            <div class="alert alert-{{session('flash_message_level') }} alert-dismissible d-flex justify-content-center"
                 role="alert" style="font-size: medium; font-weight: bold">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('flash_message') }}
            </div>
        @endif

        <form action="{{ route('confirmed.products.destroyAll') }}" method="post">
            @csrf

            {{-- <a href="{{route('products.create.step.one')}}" class="btn btn-success justify-content-md-end"
                style="margin-bottom: 10px">ایجاد محصول جدید</a>--}}

            <input type="submit"
                   name="submit"
                   class="btn btn-danger justify-content-md-end" style="margin-bottom: 10px"
                   value="حذف دسته جمعی"/>


            <div class="row" style="overflow: scroll">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr style="background: #4aa0e6">
                        <th width="50px">{{--<input type="checkbox" id="master">--}}</th>
                        <th scope="col">ردیف</th>
                        <th scope="col">نام محصول</th>
                        <th scope="col">کد محصول</th>
                        <th scope="col">ایجاد کننده</th>
                        <th scope="col">تاریخ ثبت</th>
                        <th scope="col">وضعیت محصول</th>
                        <th scope="col">گزارش مدیریتی</th>
                        <th scope="col">گزارش BOM</th>
                        <th scope="col">حذف محصول</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php $i = 1; ?>
                    @foreach($products as $product)

                        <tr id="tr_{{$product->id}}">
                            <td><input type="checkbox" name="products[]" value="{{$product->id}}"></td>
                            <th scope="row"> <?php echo $i;?> </th>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->code }}</td>
                            <td>{{ $product->creator }}</td>
                            <td>{{ $product->date }}</td>
                            <td>تایید شده</td>
                            <td><i class="icon-trash"></i>
                                <a class="btn btn-success"
                                   href="{{ route('products.download.report', ['fileName' => $product->fileName]) }}">دانلود</a>
                            </td>
                            <td><i class="icon-trash"></i>
                                <a class="btn btn-success"
                                   href="{{ route('products.download.bom', ['bom' => $product->bom]) }}">دانلود</a>
                            </td>
                            <td><i class="icon-trash"></i>
                                <a class="btn btn-danger"
                                   href="{{ route('confirmed.products.destroy', ['id' => $product->id])}}">حذف</a>
                            </td>
                        </tr>
                        <?php $i++;?>
                    @endforeach
                    </tbody>
                </table>

            </div>

        </form>

        {{-- Pagination --}}
        <div style="margin-top:20px" class="d-flex justify-content-center">
            {!! $products->links() !!}
        </div>
    </div>

@endsection

