@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm bài viết
            </div>
            <div class="card-body">
                <form action="{{ url('admin/post/store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                            <div class="form-group">
                                <label for="name">Tên tiêu đề bài viết</label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name"  value="{{ old('name') }}" data-url="{{ route('slug.product') }}">
                            </div>
                            @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input class="form-control @error('slug') is-invalid @enderror" type="text" name="slug" id="slug" value="{{ old('slug') }}">
                            </div>
                            @error('slug')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <label for="">Danh mục</label>
                                <select name="post_cat_id" class="form-control @error('post_cat_id') is-invalid @enderror">
                                    <option>Chọn danh mục</option>
                                    @foreach ($list_cat as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('post_cat_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                    <div class="form-group">
                        <label for="">Ảnh bìa bài viết</label>
                        <input type="file" name="thumbnail" id="thumbnail" accept="image/png, image/jpg, image/jpeg" hidden>
                        <div class="thumbnail">
                            <span class="add-file @error('thumbnail') is-invalid @enderror"><i class="btn-plus" >+</i></span>
                            {{-- <div class="preview" id="preview"><span class="btn-close" onclick="delete_img()">x</span><div class="image-upload"><img src="{{ asset('BGmixigaming.jpg') }}" alt=""> </div>
                            <div>
                             <select name="color_image[]" class="form-control color_img">
                               <option value="0">Chọn màu</option>
                                 @foreach ($colors as $color)
                               <option value="{{ $color->id }}">{{ $color->name }}</option>
                            @endforeach
                               </select>
                                </div></div> --}}
                        </div>
                    </div>
                    @error('thumbnail')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="form-group ">
                        <label for="description">Chi tiết bài viết</label>
                        <textarea name="description" class="form-control  @error('description') is-invalid @enderror" id="description" cols="30" rows="15"></textarea>
                    </div>
                    @error('description')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="form-group">
                        <label for="">Trạng thái</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status1" value="pending" checked>
                            <label class="form-check-label" for="pending">
                                Chờ duyệt
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="public" value="public">
                            <label class="form-check-label" for="public">
                                Công khai
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        $(".thumbnail .add-file").click(function () {
            if($('span').hasClass('is-invalid')){
                $('span').removeClass('is-invalid')
            }
            $("input[type='file']#thumbnail").click();
        });
        $("input[type='file']#thumbnail").on('change',function(event){
            let file= $(this).get(0).files;
            if(file.length>0){
                var src_img = URL.createObjectURL(event.target.files[0]);
                var str = '<div class="preview" id="preview">';
                    str += '<span class="btn-close">x</span>';
                    str += '<div class="image-upload" >';
                    str += '<img  src="'+ src_img +'" alt=""> ';
                    str += '</div>';
                    str += '</div>';    
            }
            $('.thumbnail').append(str);
        });
        $(document).on('click', 'span.btn-close', function () {
            $(".preview").remove();
            $("input[type='file']#thumbnail").val("");
        });

    });
</script>
@endsection