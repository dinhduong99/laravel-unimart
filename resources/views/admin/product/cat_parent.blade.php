@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    @if(session('notification'))
    <div class="alert alert-success">
        {{ session('notification') }}
    </div>
    @endif
    @if(session('warning'))
    <div class="alert alert-danger">
    {{ session('warning') }}
    </div>
    @endif
    <div class="row">  
        <div class="col-4">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Thêm danh mục cha
                </div>
                <div class="card-body">
                    <form action="{{ url('admin/product/cat_parent/add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="form-group">
                            <label for="name">Tên danh mục cha</label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" data-url="{{ route('slug.product') }}" value="{{ old('name') }}">
                        </div>
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input class="form-control @error('slug') is-invalid @enderror" type="text" name="slug" id="slug" {{ old('slug') }}>
                        </div>
                        @error('slug')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="">Trạng thái</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status1" value="pending" checked>
                                <label class="form-check-label" for="status1">
                                    Chờ duyệt
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status2" value="public">
                                <label class="form-check-label" for="status2">
                                    Công khai
                                </label>
                            </div>
                        </div>
                        @error('status')
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
                    Danh mục cha
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên danh mục</th>
                                <th scope="col">Slug</th>
                                <th scope="col">Trạng thái</th>
                                <th style="width: 20%;" scope="col">Ngày tạo</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if ($cat_products->count() >0)
                        @php
                            $t=0;
                        @endphp
                        @foreach ($cat_products as $cat_product)
                        @php
                            $t++;
                        @endphp
                            <tr>
                                <td scope="row">{{ $t }}</td>
                                <td>{{ $cat_product->name }}</td>
                                <td>{{ $cat_product->slug }}</td>
                                <td>{{ $cat_product->status == 'public' ? 'Công khai' : 'Chưa duyệt'}}</td>
                                <td>{{ date('d/m/Y - H:i:s', strtotime($cat_product->created_at)) }}</td>
                                @if ($cat_product->has_child == 0)
                                <td>
                                    <a href="{{ route('cat_parent_delete', $cat_product->id) }}" onclick="return confirm('Bạn có chắc muốn xóa danh mục này không?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash" ></i></a>
                                </td>
                                @else
                                <td>
                                    <a href="{{ route('cat_parent_delete', $cat_product->id) }}" onclick="return confirm('Danh mục này đang chứa các danh mục con, bạn có chắc muốn xóa danh mục cha này không?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash" ></i></a>
                                </td>
                                @endif      
                            </tr>
                        @endforeach
                    @else
                    <tr>
                        <td colspan="6" class="bg-white" style="text-align:center">
                           Chưa có danh mục chưa được khởi tạo
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