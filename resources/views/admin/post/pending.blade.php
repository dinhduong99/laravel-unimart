@extends('layouts.admin')
@section('content')
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
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách bài viết</h5>
            <div class="form-search form-inline">
                <form action="#">
                    <input type="text" value="{{ request()->input('keyword')}}" class="form-control form-search" name="keyword" placeholder="Tìm kiếm">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary" >
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="analytic">
                <a href="{{ url('admin/post/list') }}" class="text-primary">Tất cả<span class="text-muted">({{ $count['all'] }})</span></a>
                <a href="{{ url('admin/post/list/post-approved') }}" class="text-primary">Đã duyệt<span class="text-muted">({{ $count['active'] }})</span></a>
                <a href="{{ url('admin/post/list/post-pending') }}" class="text-primary">Chưa duyệt<span class="text-muted">({{ $count['pending'] }})</span></a>
                <a href="{{ url('admin/post/list/post-trash') }}" class="text-primary">Vô hiệu hóa<span class="text-muted">({{ $count['trash'] }})</span></a>
            </div>
            <form action="{{ url('admin/post/action') }}" method="POST">
            @csrf
            <input type="hidden" name="url_status" id="" value="{{$url_status}}">
            <div class="form-action form-inline py-3">
                <select class="form-control mr-1" id="" name="action">
                    <option value="">Chọn</option>
                    @foreach ($list_action as $k=>$value)
                    <option value="{{ $k }}">{{ $value }}</option>
                    @endforeach
                </select>
                <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
            </div>
            <table class="table table-striped table-checkall">
                <thead>
                    <tr>
                        <th scope="col">
                            <input name="checkall" type="checkbox">
                        </th>
                        <th scope="col">#</th>
                        <th style="width:7%"  scope="col">Ảnh</th>
                        <th scope="col">Tên tiêu đề</th>
                        <th style="width:12%" scope="col">Danh mục</th>
                        <th style="width:10%" scope="col">Ngày tạo</th>
                        <th scope="col">Trạng thái</th>
                        <th style="width:12%" scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                   @if ($posts->count() > 0 )
                    @php
                        $t=0;
                    @endphp
                    @foreach ($posts as $post)
                    @php
                        $t++;
                    @endphp
                    <tr class="">
                        <td>
                            <input type="checkbox" name="list_check[]" value="{{ $post->id }}">
                        </td>
                        <td>{{ $t }}</td>
                        <td><a href="{{ route('post.edit',$post->id) }}"><img style="width:100%" src="{{ url("$post->thumbnail")}}" alt=""></a></td>
                        <td><a style="overflow: hidden;display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 2;" href="{{ route('post.edit',$post->id) }}">{{ $post->name }}</a></td>
                        <td>{{$post->cat->name }}</td>
                        <td>{{date('d/m/Y - H:i:s', strtotime($post->created_at))  }}</td>
                     
                            @php
                               switch ($post->status){
                                case 'pending':
                                   echo '<td><span class="badge badge-warning">Chờ duyệt</span></td>';
                                   break;
                                case 'public':
                                  echo '<td><span class="badge badge-success">Công khai</span></td>';
                                  break;
                            }
                            @endphp
                        <td>
                            @if ($url_status == "trash")
                            <a href="{{ route('post.delete',$post->id) }}" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này ra khỏi hệ thống?')"><i class="fa fa-trash"></i></a>
                            @else
                            <a href="{{ route('post.edit',$post->id) }}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                            <a href="{{ route('post.disable',$post->id) }}" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return confirm('Bạn có chắc muốn vô hiệu sản phẩm này ra khỏi hệ thống?')"><i class="fa fa-trash"></i></a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="8" class="bg-white" style="text-align:center">
                            Không tìm thấy kết quả cần tìm
                        </td>
                    </tr>

                @endif
                </tbody>
            </table>
        </form>
            {{$posts->links() }}
        </div>
    </div>
</div>
@endsection