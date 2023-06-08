@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    @if(session('notification'))
    <div class="alert alert-success">
        {{ session('notification') }}
    </div>
    @endif
    <div class="row">  
        <div class="col-4">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Thêm màu sắc sản phẩm
                </div>
                <div class="card-body">
                    <form action="{{ url('admin/product/color_add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="form-group">
                            <label for="name">Tên màu</label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name"  value="{{ old('name') }}">
                        </div>
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="color_code">Mã màu</label>
                            <input class="form-control @error('color_code') is-invalid @enderror" type="color" name="color_code" id="color_code"  value="{{ old('color_code') }}">
                        </div>
                        @error('color_code')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <button type="submit" name="btn-add" value="Thêm mới" class="btn btn-primary">Thêm mới</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Màu sắc sản phẩm
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên màu sắc</th>
                                <th scope="col">Mã màu</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if ($colors->count() >0)
                        @php
                            $t=0;
                        @endphp
                        @foreach ($colors  as $color)
                        @php
                            $t++;
                        @endphp
                            <tr>
                                <td scope="row">{{ $t }}</td>
                                <td>{{ $color->name }}</td>
                                <td>{{ $color->color_code }}</td>
                                <td>{{ date('d/m/Y - H:i:s', strtotime($color->created_at)) }}</td>
                                <td>
                                    <a href="{{ route('color_delete', $color->id) }}" onclick="return confirm('Bạn có chắc muốn xóa màu này?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash" ></i></a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                    <tr>
                        <td colspan="5" class="bg-white" style="text-align:center">
                           Chưa có màu sắc nào được khởi tạo
                        </td>
                    </tr>
                    @endif   
                    </tbody>    
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection