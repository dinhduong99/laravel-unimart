@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm Ads
            </div>
            <div class="card-body">
                <form action="{{ url('admin/ads/store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Tên ads</label>
                        <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name"  value="{{ old('name') }}">
                    </div>
                    @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="form-group ">
                        <label for="description">Mô tả ads</label>
                        <textarea name="description" class="form-control  @error('description') is-invalid @enderror" id="description" cols="30" rows="10"></textarea>
                    </div>
                    @error('description')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="form-group">
                        <label for="">Hình ảnh ads</label>
                        <input type="file" name="thumbnail" id="thumbnail" accept="image/png, image/jpg, image/jpeg" hidden>
                        <div class="thumbnail">
                            <span class="add-file @error('thumbnail') is-invalid @enderror"><i class="btn-plus" >+</i></span>
                        </div>
                    </div>
                    @error('thumbnail')
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
                    str +='<div>';
                    str +='</div>';
                    str += '</div>';    
            }
            $('.thumbnail').append(str);
        });
        $(document).on('click', 'span.btn-close', function () {
            $(".preview").remove();
            $("input[type='file']#thumbnail").val("");
        });
        $("ul.image_list .add-file").click(function () {
            if($('span').hasClass('is-invalid')){
                $('span').removeClass('is-invalid')
            }
            $("input[type='file']#image_list").click();
        });
    });
</script>
@endsection