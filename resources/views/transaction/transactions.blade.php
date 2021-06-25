@extends('layouts.manager')

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>فروش</title>
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

        <form action="{{ route('transactions.destroyAll') }}" method="post">
            @csrf

            <a href="{{route('transactions.create')}}" class="btn btn-success justify-content-md-end"
               style="margin-bottom: 10px">ایجاد تراکنش جدید</a>

            <a href="{{route('transactions.search')}}" class="btn btn-warning justify-content-md-end"
               style="margin-bottom: 10px">مشاهده بر اساس تاریخ</a>

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
                                <td><input type="checkbox" name="transactions[]" value="{{$transaction->id}}"></td>
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


        </form>

        {{-- Pagination --}}
        <div style="margin-top:20px" class="d-flex justify-content-center">
            {!! $transactions->links() !!}
        </div>
    </div>

@endsection

