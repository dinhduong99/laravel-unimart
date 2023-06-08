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
    <div class="card">
        <div class="card-header font-weight-bold">
           Cập nhật danh mục chưa duyệt
        </div>
        <div class="card-body">
            <form action="{{ route('cat_pending_update',$cat_edit->id) }}" method="POST">
                @csrf
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="form-group">
                    <label for="name">Tên danh mục</label>
                    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" data-url="{{ route('slug.product') }}" value="{{ $cat_edit->name }}" disabled>
                </div>
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input class="form-control @error('slug') is-invalid @enderror" type="text" name="slug" id="slug"  value="{{ $cat_edit->slug  }}" disabled>
                </div>
                @error('slug')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                @if ($cat_edit->parent_id != 0)
                <div class="form-group">
                    <label for="">Danh mục cha</label>
                    <select class="form-control @error('parent_id') is-invalid @enderror" id="" name="parent_id">
                        <option>Chọn danh mục</option>
                    @foreach ($cat_parent as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach   
                    </select>
                </div>
                @endif
                @error('parent_id')
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
@endsection