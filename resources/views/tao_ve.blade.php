<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mặt Vé</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center" >
                        QUẢN LÝ THÔNG TIN VÉ MÁY BAY
                    </div>
                    <div class="text-center" style="padding: 10px 0px 0px 0px">
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('form-logout').submit();" class="btn btn-success" style="align:center">Logout</a>
                        <form id="form-logout" action="{{ route('logout') }}" method="POST">
                            @csrf
                        </form>
                    </div>
                    {{-- <a href="{{ route('logout') }}">Logout</a> --}}
                    <div class="card-body">
                        @if(Session::has('khong-co-code'))
                            <div class="alert alert-danger" role="alert">
                                {{Session::get('khong-co-code')}}
                            </div>
                        @endif
                            <form action="{{ route('xulyve') }}" method="POST" style="margin: 10px 0px 20px 0px">
                            @csrf
                                <label for="hang_bay">Chọn Hãng Hàng Không</label>
                                <select name="hang_bay">
                                    <option value="0">VNA</option>
                                    <option value="1">VJ</option>
                                    <option value="2">BL</option>
                                    <option value="3">QH</option>
                                    <option value="4">VU</option>
                                </select>
                                <label for="ma_code">Mã Code</label>
                                <input type="text" name="ma_code" placeholder="Vui lòng nhập mã code!">
                                <button type="submit" class="btn btn-primary">Lưu</button>
                            </form>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th style="width:100px">Mã Code</th>
                                    <th>Tên</th>
                                    <th style="width:100px">Số Hiệu</th>
                                    <th>Ngày Bay</th>
                                    <th>Nơi Đi</th>
                                    <th>Nơi Đến</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($ma_codes as $ma_code)
                                <tr>
                                    <td>{{$ma_code->id}}</td>
                                    <td>{{$ma_code->code}}</td>
                                    <td>{{$ma_code->ten}}</td>
                                    <td>{{$ma_code->chuyenbay}}</td>
                                    <td>{{$ma_code->ngaybay}}</td>
                                    <td>{{$ma_code->noidi}}</td>
                                    <td>{{$ma_code->noiden}}</td>
                                    <td>
                                        <a href="/matve/{{ $ma_code->id }}" class="btn btn-info">Mặt Vé</a>
                                    </td>
                                </tr>
                            @endforeach    
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>