@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        @if(session('notification'))
        <div class="alert alert-success">
            {{ session('notification') }}
        </div>
        @endif
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách thành viên</h5>
            <div class="form-search form-inline">
                <form action="#">
                    <input type="text" class="form-control form-search" name="keyword" value="{{ request()->input('keyword')}}" placeholder="Tìm kiếm">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="analytic">
                <a href="{{ request()->fullurlwithquery(['status'=>'active']) }}" class="text-primary">Kích hoạt<span class="text-muted">({{ $count[0] }})</span></a>
                <a href="{{ request()->fullurlwithquery(['status'=>'trash']) }}" class="text-primary">Vô hiệu hóa<span class="text-muted">({{ $count[1] }})</span></a>
            </div>
            <form action="{{ url('admin/user/action') }}" method="POST">
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
                            <th>
                                <input type="checkbox" name="checkall">
                            </th>
                            <th scope="col">#</th>
                            <th scope="col">Họ tên</th>
                            <th scope="col">Email</th>
                            <th scope="col">Quyền</th>
                            <th style="width:13%" scope="col">Ngày tạo</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $t=0;
                        @endphp
                        @if ( $users->total() >0)
                            @foreach ($users as $user)
                            @php
                            $t++;
                            @endphp
                            <tr>
                                <td>
                                    <input type="checkbox" name="list_check[]" value="{{ $user->id }}">
                                </td>
                                <td style="font-weight: bold" scope="row">{{ $t }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                  {{ $user->role->name }}
                                </td>
                                <td>{{ date('d/m/Y - H:i:s', strtotime($user->created_at)) }}</td>
                                <td>
                                
                                    @if ($url_status=="active")
                                    @if (Auth::id()!=$user->id)
                                    <a href="{{ route('edit.user',$user->id) }}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                    <a href="{{ route('disable-user',$user->id) }}" onclick="return confirm('Bạn có chắc muốn vô hiệu thành viên này ra khỏi hệ thống?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash" ></i></a>
                                    @endif 
                                    @if (Auth::id()==$user->id)
                                    <a href="{{ route('edit.user',$user->id) }}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                    @endif 
                                    @endif
                                    @if ($url_status=="trash")
                                    @if (Auth::id()!=$user->id)
                                    <a href="{{ route('delete-user',$user->id) }}" onclick="return confirm('Bạn có chắc muốn xóa thành viên này ra khỏi hệ thống?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash" ></i></a>
                                    @endif 
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="bg-white" style="text-align:center">
                                    Không tìm thấy kết quả cần tìm
                                </td>
                            </tr>
    
                        @endif
    
                    </tbody>
                </table>
            </form>
         {{ $users->links() }}
        </div>
    </div>
</div>
@endsection