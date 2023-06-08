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
            <h5 class="m-0 ">Danh sách liên hệ</h5>
            <div class="form-search form-inline">
                <form action="#">
                    <input type="text" value="{{ request()->input('keyword')}}" class="form-control form-search" name="keyword" placeholder="Tìm kiếm">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary" >
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="analytic">
                <a href="{{ url('admin/contact/list') }}" class="text-primary">Tất cả<span class="text-muted">({{ $count['active'] }})</span></a>
                <a href="{{ url('admin/contact/list/contact-pending') }}" class="text-primary">Chờ Duyệt<span class="text-muted">({{ $count['pending'] }})</span></a>
                <a href="{{  url('admin/contact/list/contact-approved')  }}" class="text-primary">Đã Duyệt<span class="text-muted">({{ $count['approved'] }})</span></a>
                <a href="{{  url('admin/contact/list/contact-trash')  }}" class="text-primary">Vô hiệu hóa<span class="text-muted">({{ $count['trash'] }})</span></a>
            </div>
            <form action="{{ url('admin/contact/action') }}" method="POST">
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
                        <th style="width: 12%" scope="col">Họ Tên</th>
                        <th style="width: 25%"  scope="col">Email</th>
                        <th scope="col">Số điện thoại</th>
                        <th style="width: 10%"  scope="col">Thời gian liên hệ</th>
                        <th style="width: 10%"  scope="col">Thời gian duyệt</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                   @if ($contacts->count() > 0 )
                    @php
                        $t=0;
                    @endphp
                    @foreach ($contacts as $contact)
                    @php
                        $t++;
                    @endphp
                    <tr class="">
                        <td>
                            <input type="checkbox" name="list_check[]" value="{{ $contact->id }}">
                        </td>
                        <td>{{ $t }}</td>
                        <td>{{$contact->fullname}}</td>
                        <td>{{$contact->email}}</td>
                        <td>{{$contact->phone}}</td>
                        <td>{{date('d/m/Y - H:i:s', strtotime($contact->created_at))  }}</td>
                        <td>{{date('d/m/Y - H:i:s', strtotime($contact->updated_at))  }}</td>
                        <td>
                            @php
                               switch ($contact->status){
                                case 'pending':
                               echo '<span class="badge badge-danger">
                                  Đang chờ duyệt
                                </span>';
                                   break;
                                case 'approved':
                                echo '<span class="badge badge-success">
                                  Đã duyệt
                                </span>';
                                    break;
                            }
                            @endphp
                        </td>
                        <td>
                            @if ($url_status == "trash")
                            <a href="{{ route('contact.delete',$contact->id) }}" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này ra khỏi hệ thống?')"><i class="fa fa-trash"></i></a>
                            @else
                            <a href="{{ route('contact.edit',$contact->id) }}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Detail"><i class="fa fa-edit"></i></a>
                            <a href="{{ route('contact.disable',$contact->id) }}" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return confirm('Bạn có chắc muốn vô hiệu sản phẩm này ra khỏi hệ thống?')"><i class="fa fa-trash"></i></a>
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
        {{ $contacts->appends(request()->query())->links()  }}
        </div>
    </div>
</div>
@endsection
