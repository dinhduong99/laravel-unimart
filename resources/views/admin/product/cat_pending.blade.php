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
    <div class="row">  
        <div class="col-12">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Danh mục chưa duyệt
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
                        @if ($cat_pending->count() >0)
                        @php
                            $t=0;
                        @endphp
                        @foreach ($cat_pending as $cat)
                        @php
                            $t++;
                        @endphp
                            <tr>
                                <td scope="row">{{ $t }}</td>
                                <td>{{ $cat->name }}</td>
                                <td>{{ $cat->slug }}</td>
                                <td>{{ $cat->status == 'public' ? 'Công khai' : 'Chưa duyệt'}}</td>
                                <td>{{ date('d/m/Y - H:i:s', strtotime($cat->created_at)) }}</td>
                                @if ($cat->has_child == 0)
                                <td>
                                    <a href="{{ route('cat_pending_edit',$cat->id) }}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                    <a href="{{ route('cat_pending_delete',$cat->id) }}" onclick="return confirm('Bạn có chắc muốn xóa danh mục này không?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash" ></i></a>
                                </td>
                                @else
                                <td>
                                    <a href="{{ route('cat_pending_edit',$cat->id) }}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                    <a href="{{ route('cat_pending_delete',$cat->id) }}" onclick="return confirm('Danh mục này đang chứa các danh mục con, bạn có chắc muốn xóa danh mục cha này không?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash" ></i></a>
                                </td>
                                @endif      
                            </tr>
                        @endforeach
                    @else
                    <tr>
                        <td colspan="6" class="bg-white" style="text-align:center">
                           Không có danh mục nào chưa được duyệt
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