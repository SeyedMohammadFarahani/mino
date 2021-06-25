@extends('layouts.manager')

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>مواد کمک فرآیند</title>
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

        <form action="{{ route('acids.destroyAll') }}" method="post">
            @csrf

            <a href="{{route('acids.create')}}" class="btn btn-success justify-content-md-end"
               style="margin-bottom: 10px">ایجاد
                ماده کمک فرآیند جدید</a>

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
                        <th scope="col">نام ماده کمک فرآیند</th>
                        <th scope="col">قیمت به ازای هر کیلوگرم (ریال)</th>
                        <th scope="col">حذف ماده کمک فرآیند</th>
                        <th scope="col">ویرایش ماده کمک فرآیند</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php $i = 1; ?>
                    @foreach($acids as $acid)

                        <tr id="tr_{{$acid->id}}">
                            <td><input type="checkbox" name="acids[]" value="{{$acid->id}}"></td>
                            <th scope="row"> <?php echo $i;?> </th>
                            <td>{{ $acid->name }}</td>
                            <td>{{ number_format($acid->price,4,'.',',') }}</td>
                            <td><i class="icon-trash"></i>
                                <a class="btn btn-danger"
                                   href="{{ route('acids.destroy', ['id' => $acid->id])}}">حذف</a>
                            </td>
                            <td><i class="icon-trash"></i>
                                <a class="btn btn-warning"
                                   href="{{ route('acids.edit', ['id' => $acid->id]) }}">ویرایش</a>
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
            {!! $acids->links() !!}
        </div>
    </div>

@endsection

