@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
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
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách page</h5>
        </div>
        <div class="card-body">
            <div class="analytic">
                <a href="{{ url('admin/page/list') }}" class="text-primary">Đã duyệt<span class="text-muted">({{  $count[0] }})</span></a>
                <a href="{{ url('admin/page/list/page-pending') }}" class="text-primary">Chưa duyệt<span class="text-muted">({{  $count[1]  }})</span></a>
                <a href="{{ url('admin/page/list/page-trash') }}" class="text-primary">Vô hiệu hóa<span class="text-muted">({{  $count[2]  }})</span></a>
            </div>
            <form action="{{ url('admin/page/action') }}" method="POST">
                @csrf
                <input type="hidden" name="url_status" id="">
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
                            <th>
                                <input type="checkbox" name="checkall">
                            </th>
                            <th scope="col">#</th>
                            <th scope="col">Tên tiêu đề</th>
                            <th scope="col">Slug</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $t=0;
                        @endphp
                        @if ( $pages->total() >0)
                            @foreach ($pages as $page)
                            @php
                            $t++;
                            @endphp
                            <tr>
                                <td>
                                    <input type="checkbox" name="list_check[]" value="{{$page->id }}">
                                </td>
                                <td style="font-weight: bold" scope="row">{{ $t }}</td>
                                <td>{{ $page->name }}</td>
                                <td>{{ $page->slug }}</td>
                                    @php
                                    switch ($page->status){
                                     case 'pending':
                                        echo '<td><span class="badge badge-warning">Chờ duyệt</span></td>';
                                        break;
                                     case 'public':
                                       echo '<td><span class="badge badge-success">Công khai</span></td>';
                                       break;
                                 }
                                 @endphp
                             
                                <td>{{ date('d/m/Y - H:i:s', strtotime($page->created_at)) }}</td>
                                <td>
                                    <a href="{{ route('page.edit',$page->id) }}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                    @if ($url_status=="active" || $url_status=="pending")
                                    <a href="{{ route('page.disable',$page->id) }}" onclick="return confirm('Bạn có chắc muốn vô hiệu page này ra khỏi hệ thống?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash" ></i></a>
                                    @endif 
                                
                                    @if ($url_status=="trash")
                                    <a href="{{ route('page.delete',$page->id) }}" onclick="return confirm('Bạn có chắc muốn xóa page này ra khỏi hệ thống?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash" ></i></a>
                                    @endif 
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="bg-white" style="text-align:center">
                                    Không tìm thấy kết quả cần tìm
                                </td>
                            </tr>
    
                        @endif
    
                    </tbody>
                </table>
            </form>
         {{ $pages->links() }}
        </div>
    </div>
</div>
@endsection