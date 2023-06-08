@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Chỉnh sửa sản phẩm
            </div>
            <div class="card-body">
                <form action="{{ route('update.product',$product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Tên sản phẩm</label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name"  value="{{ $product->name }}" data-url="{{ route('slug.product') }}">
                            </div>
                            @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input class="form-control @error('slug') is-invalid @enderror" type="text" name="slug" id="slug" value=" {{ $product->slug}}">
                            </div>
                            @error('slug')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <label for="price">Giá sản phẩm</label>
                                <input class="form-control @error('price') is-invalid @enderror" type="text" name="price" id="price" value=" {{ $product->price }}">
                            </div>
                            @error('price')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <label for="percent_price">Phần trăm khuyến mãi</label>
                                <input class="form-control @error('percent_price') is-invalid @enderror" type="text" name="percent_price" id="percent_price" value="{{ $product->percent_price }}">
                            </div>
                            @error('percent_price')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <label for="sale_price">Giá khuyến mãi</label>
                                <input class="form-control @error('sale_price') is-invalid @enderror" type="text" name="sale_price" id="sale_price" value="{{ $product->sale_price}}">
                            </div>
                            @error('sale_price')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <label for="">Danh mục</label>
                                <select name="product_cat_id" class="form-control @error('cat') is-invalid @enderror">
                                    <option>Chọn danh mục</option>
                                    @foreach ($list_cat as $cat)
                                    <option {{ $product->product_cat_id == $cat->id?'selected':''}} value="{{ $cat->id }}">{{ str_repeat('----- ',$cat->level) . $cat->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('cat')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label  for="">Màu sắc sản phẩm</label>
                                <div style="border: 1px solid #ced4da;border-radius: 0.25rem;padding: 0.375rem 0.75rem;display:flex;flex-wrap:wrap;align-items: baseline;" class="color @error('color_id') is-invalid @enderror">
                                    @php
                                         $color_id=json_decode($product->color_id);
                                    @endphp
                                    @foreach ($colors as $color)
                                    <div>
                                        <input type="checkbox" name="color_id[]" value="{{ $color->id }}" id="color_{{ $color->id }}"{{ in_array($color->id,$color_id)?"checked":"" }}>
                                        <label style="background-color:{{ $color->color_code }};{{ $color->color_code == '#000000' ? 'color: white;': 'color:#000000'}};border: 2px solid #ced4da;border-radius: 20px;padding: 0px 10px;margin: 0px 8px 10px 8px" for="color_{{ $color->id }}">{{ $color->name }}</label>
                                    </div>
                                    @endforeach
                                </div>    
                            </div>
                            @error('color_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        @php
                        $image_list=json_decode($product->image_list); 
                        $color_image=json_decode($product->color_image);
                        $t=0;
                        @endphp
                        <label for="">Hình ảnh sản phẩm</label>
                        <input type="file" name="thumbnail" id="thumbnail" accept="image/png, image/jpg, image/jpeg" hidden>
                        <div class="thumbnail">
                            <span class="add-file @error('thumbnail') is-invalid @enderror"><i class="btn-plus" >+</i></span>
                            <div class="preview" id="preview">
                                <span class="btn-close" onclick="delete_img()">x</span>
                                <div class="image-upload"><img src="{{url($product->thumbnail)}}" alt=""> </div>
                                <div>
                                    <select name="color_image[]" class="form-control color_img">
                                      <option value="0">Chọn màu</option>
                                        @foreach ($colors_img as $color)
                                      <option {{$color->id  == $color_image[$t]?'selected':''}} value="{{ $color->id }}">{{ $color->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    @error('thumbnail')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div  class="form-group ">
                        <label for="">Hình ảnh chi tiết sản phẩm</label>
                        <div style="height: 300px;overflow-y:auto" class="form-group border px-2 py-3 rounded ">
                            <input type="file" name="image_list[]" id="image_list" accept="image/png, image/jpg, image/jpeg" multiple hidden>
                            <ul class="image_list">
                                <li><span class="add-file @error('image_list') is-invalid @enderror"><i class="btn-plus">+</i></span></li>
                                @foreach ($image_list as $key => $image)
                                @php
                                    $t++;
                                @endphp
                                <li>
                                    <span class="btn-close" data-name="{{ substr($image,15) }}">x</span>
                                    <div class="image-upload">
                                        <img src="{{ url($image) }}" alt="">
                                        <input type="hidden" name="key[]" value="{{ $image }}">    
                                    </div>
                                    <div>
                                        <select name="color_image[]" class="form-control color_img">
                                            <option   value="0">Chọn màu</option>                    
                                            @foreach ($colors_img as $color)
                                            <option  {{$color->id  == $color_image[$t]?'selected':''}} value="{{ $color->id }}">{{ $color->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @error('image_list')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="form-group">
                        <label for="detail">Chi tiết sản phẩm</label>
                        <textarea name="detail" class="form-control  @error('detail') is-invalid @enderror" id="detail" cols="30" rows="15">{{ $product->detail}}</textarea>
                    </div>
                    @error('detail')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="form-group ">
                        <label for="description">Mô tả sản phẩm</label>
                        <textarea name="description" class="form-control  @error('description') is-invalid @enderror" id="description" cols="30" rows="15">{{ $product->description}}</textarea>
                    </div>
                    @error('description')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="form-group">
                        <label for="">Trạng thái</label>
                        <div class="form-check">
                            <input {{ $product->status == 'pending' ? "checked" :" " }} class="form-check-input" type="radio" name="status" id="pending" value="pending" checked>
                            <label class="form-check-label" for="pending">
                                Chờ duyệt
                            </label>
                        </div>
                        <div class="form-check">
                            <input {{ $product->status == 'out of stock' ? "checked" :" " }} class="form-check-input" type="radio" name="status" id="out of stock" value="out of stock">
                            <label class="form-check-label" for="out of stock">
                                Hết hàng
                            </label>
                        </div>
                        <div class="form-check">
                            <input {{ $product->status == 'stocking' ? "checked" :" " }} class="form-check-input" type="radio" name="status" id="stocking" value="stocking">
                            <label class="form-check-label" for="stocking">
                                Còn hàng
                            </label>
                        </div>
                    </div>
                    <button type="submit" name="btn-update" value="Thêm mới" class="btn btn-primary">Cập nhật</button>
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
                    str +='<select name="color_image[]" class="form-control color_img">';
                    str +='<option value="0">Chọn màu</option>';
                    str +=' @foreach ($colors as $color)';
                    str +='<option value="{{ $color->id }}">{{ $color->name }}</option>';
                    str +='@endforeach';
                    str +='</select>';
                    str +='</div>';
                    str += '</div>';     
            }
            $('.thumbnail').append(str);
        });
        $(document).on('click', '.thumbnail span.btn-close', function () {
            $(".preview").remove();
            $("input[type='file']#thumbnail").val("");
        });

        $("ul.image_list .add-file").click(function () {
            if($('span').hasClass('is-invalid')){
                $('span').removeClass('is-invalid')
            }
            $("input[type='file']#image_list").click();
        });
        const datatransfer = new DataTransfer();
        $("input[type='file']#image_list").on('change',function(event){
            var str= "";
            let file= $(this).get(0).files;
            // alert(file.length);
            for(let i = 0; i < file.length ; i++){
                var src_img = URL.createObjectURL(event.target.files[i]);
                str += '<li>';
                    str +='<span class="btn-close" data-name="'+this.files.item(i).name+'">x</span>';
                    str +='<div class="image-upload">';
                    str +='<img src="'+src_img+'" alt="">';
                    str +='</div>';
                    str +='<div>';
                    str +='<select name="color_image[]" class="form-control color_img">';
                    str +='<option value="0">Chọn màu</option>';
                    str +=' @foreach ($colors as $color)';
                    str +='<option value="{{ $color->id }}">{{ $color->name }}</option>';
                    str +='@endforeach';
                    str +='</select>';
                    str +='</div>';
                    str +='</li>';
                }
            $('ul.image_list').append(str);
            for (let file of this.files) {
                datatransfer.items.add(file);
            }
            this.files = datatransfer.files;
        });

        $(document).on('click', 'ul.image_list li span.btn-close', function () {
            let file_name =$(this).attr('data-name');
            for(let i =0 ; i <  datatransfer.items.length; i++){
                if (file_name === datatransfer.items[i].getAsFile().name) {
                    datatransfer.items.remove(i);
                }
            }
            $("input[type='file']#image_list").get(0).files =  datatransfer.files;
            $(this).closest('li').remove();
        });
    });

</script>
@endsection
