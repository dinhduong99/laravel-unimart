@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Chỉnh sửa trang
            </div>
            <div class="card-body">
                <form action="{{ route('page.update',$page->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Tiêu đề trang</label>
                        <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name"  value="{{ $page->name }}">
                    </div>
                    @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <input class="form-control @error('slug') is-invalid @enderror" type="text" name="slug" id="slug" value="{{ $page->slug  }}">
                    </div>
                    @error('slug')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="form-group ">
                        <label for="description">Nội dung</label>
                        <textarea name="description" class="form-control  @error('description') is-invalid @enderror" id="description" cols="30" rows="10">{{ $page->description != null ? $page->description : "" }}</textarea>
                    </div>
                    @error('description')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="form-group">
                        <label for="">Trạng thái</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="pending" value="pending" {{ $page->status == 'pending' ? 'checked':"" }}>
                            <label class="form-check-label" for="pending">
                                Chờ duyệt
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="public" value="public" {{ $page->status == 'public' ? 'checked':"" }}>
                            <label class="form-check-label" for="public">
                                Công khai 
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection