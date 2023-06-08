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
            <h5 class="m-0 ">Danh sách slider</h5>
        </div>
        <div class="card-body">
            <div class="analytic">
                <a href="{{ url('admin/slider/list') }}" class="text-primary">Đã duyệt<span class="text-muted">({{  $count[0] }})</span></a>
                <a href="{{ url('admin/slider/list/slider-pending') }}" class="text-primary">Chưa duyệt<span class="text-muted">({{  $count[1] }})</span></a>
                <a href="{{ url('admin/slider/list/slider-trash') }}" class="text-primary">Vô hiệu hóa<span class="text-muted">({{  $count[2]  }})</span></a>
            </div>
            <form action="{{ url('admin/slider/action') }}" method="POST">
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
                            <th scope="col">Tên slider</th>
                            <th scope="col">Hình ảnh</th>
                            <th scope="col">Trạng thái</th>
                            <th style="width:13%" scope="col">Ngày tạo</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $t=0;
                        @endphp
                        @if ( $sliders->total() >0)
                            @foreach ($sliders as $slider)
                            @php
                            $t++;
                            @endphp
                            <tr>
                                <td>
                                    <input type="checkbox" name="list_check[]" value="{{$slider->id }}">
                                </td>
                                <td style="font-weight: bold" scope="row">{{ $t }}</td>
                                <td>{{ $slider->name }}</td>
                                <td style="width: 20%" ><img style="width:100%" src="{{ url($slider->thumbnail) }}" alt=""></td>
                                @php
                                switch ($slider->status){
                                 case 'pending':
                                    echo '<td><span class="badge badge-warning">Chờ duyệt</span></td>';
                                    break;
                                 case 'public':
                                   echo '<td><span class="badge badge-success">Công khai</span></td>';
                                   break;
                             }
                             @endphp
                                <td>{{ date('d/m/Y - H:i:s', strtotime($slider->created_at)) }}</td>
                                <td>
                                    <a href="{{ route('edit_slider',$slider->id) }}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                    @if ($url_status=="active")
                                    <a href="{{ route('disable_slider',$slider->id) }}" onclick="return confirm('Bạn có chắc muốn vô hiệu slider này ra khỏi hệ thống?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash" ></i></a>
                                    @endif 
                                
                                    @if ($url_status=="trash")
                                    <a href="{{ route('delete_slider',$slider->id) }}" onclick="return confirm('Bạn có chắc muốn xóa slider này ra khỏi hệ thống?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash" ></i></a>
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
         {{ $sliders->links() }}
        </div>
    </div>
</div>
@endsection