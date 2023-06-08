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
                    Danh mục
                </div>
                <div class="card-body">
                    <form action="{{ url('admin/post/cat/add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="form-group">
                            <label for="name">Tên danh mục</label>
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
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Danh mục
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
                        @if (!empty($list_cat))
                        @php
                            $t=0;
                        @endphp
                        @foreach ($list_cat as $cat)
                        @php
                            $t++;
                        @endphp
                         
                            <tr>
                                <td scope="row">{{ $t }}</td>
                                <td>{{ str_repeat('----- ',$cat->level) . $cat->name}}</td>
                                <td>{{ $cat->slug }}</td>
                                <td>{{  $cat->status == 'public' ? 'Công khai' : 'Chưa duyệt'}}</td>
                                <td>{{date('d/m/Y - H:i:s', strtotime($cat->created_at))  }}</td>
                                <td>
                                    <a href="" onclick="return confirm('Bạn có chắc muốn xóa danh mục này không?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash" ></i></a>
                                </td>
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