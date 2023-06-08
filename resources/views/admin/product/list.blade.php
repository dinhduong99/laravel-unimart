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
            <h5 class="m-0 ">Danh sách sản phẩm</h5>
            <div class="form-search form-inline">
                <form action="#">
                    <input type="text" value="{{ request()->input('keyword')}}" class="form-control form-search" name="keyword" placeholder="Tìm kiếm">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary" >
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="analytic">
                <a href="{{ url('admin/product/list') }}" class="text-primary">Tất cả<span class="text-muted">({{ $count['active'] }})</span></a>
                <a href="{{ url('admin/product/list/stocking') }}" class="text-primary">Còn hàng<span class="text-muted">({{ $count['stocking'] }})</span></a>
                <a href="{{ url('admin/product/list/out-of-stock') }}" class="text-primary">Hết hàng<span class="text-muted">({{ $count['out-of-stock'] }})</span></a>
                <a href="{{ url('admin/product/list/pending') }}" class="text-primary">Riêng tư<span class="text-muted">({{ $count['pending'] }})</span></a>
                <a href="{{ url('admin/product/list/trash') }}" class="text-primary">Vô hiệu hóa<span class="text-muted">({{ $count['trash'] }})</span></a>
            </div>
            <form action="{{ url('admin/product/action') }}" method="POST">
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
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col">Giá</th>
                        <th scope="col">Danh mục</th>
                        <th scope="col">Ngày tạo</th>
                        <th scope="col">Trạng thái</th>
                        <th style="width:12%" scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                   @if ($products->count() > 0 )
                    @php
                        $t=0;
                    @endphp
                    @foreach ($products as $product)
                    @php
                        $t++;
                    @endphp
                    <tr class="">
                        <td>
                            <input type="checkbox" name="list_check[]" value="{{ $product->id }}">
                        </td>
                        <td>{{ $t }}</td>
                        <td><img style="width:100%" src="{{ url("$product->thumbnail")}}" alt=""></td>
                        <td ><a href="{{ route('edit.product',$product->id) }}">{{ $product->name }}</a></td>
                        <td>{{ number_format($product->price,0,',','.') }}đ</td>
                        <td>{{  $product->cat->name }}</td>
                        <td>{{date('d/m/Y - H:i:s', strtotime($product->created_at))  }}</td>
                        
                            @php
                               switch ($product->status){
                                case 'pending':
                                   echo '<td><span class="badge badge-warning">Chờ duyệt</span></td>';
                                   break;
                                case 'out of stock':
                                  echo '<td><span class="badge badge-danger">Hết hàng</span></td>';
                                  break;
                                case 'stocking':
                                 echo '<td><span class="badge badge-success">Còn hàng</span></td>';
                                 break;
                            }
                            @endphp
                      
                        <td>
                            @if ($url_status == "trash")
                            <a href="{{ route('delete.product',$product->id) }}" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này ra khỏi hệ thống?')"><i class="fa fa-trash"></i></a>
                            @else
                            <a href="{{ route('edit.product',$product->id) }}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                            <a href="{{ route('disable.product',$product->id) }}" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return confirm('Bạn có chắc muốn vô hiệu sản phẩm này ra khỏi hệ thống?')"><i class="fa fa-trash"></i></a>
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
            {{$products->links() }}
        </div>
    </div>
</div>
@endsection