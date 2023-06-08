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
        <h5 class="m-0 ">Chi tiết liên hệ </h5>
    </div>
        <div class="card-body" style="border-bottom:2px solid #dee2e6">
          <div class="font-weight-bold px-2 py-3">
            Thông tin liên hệ
          </div>
            <table class="table table-striped">
                <tbody>
                  <tr>
                    <td>Tên khách hàng liên hệ:</td>
                    <td>{{ $contact->fullname }}</td>
                  </tr>
                  <tr>
                    <td>Địa chỉ email:</td>
                    <td>{{ $contact->email }}</td>
                  </tr>  
                  <tr>
                    <td>Số điện thoại:</td>
                    <td>{{ $contact->phone }}</td>
                  </tr>  
                  <tr>
                    <td>Thời gian liên hệ:</td>
                    <td>{{date('d/m/Y - H:i:s', strtotime($contact->created_at))  }}</td>
                  </tr>
                  <tr>
                    <td>Ghi chú:</td>
                    <td>
                    @if ($contact->note =="")
                      Không có
                    @else
                      {{ $contact->note }}
                    @endif
                    </td>
                  </tr>
                </tbody>
            </table>
              <form action=" {{ route('contact.update',$contact->id) }}" method="POST">
                @csrf 
                <div class="form-action form-inline pb-3">
                  <label class="pl-2" for="">Tình trạng liên hệ:</label>
                  <div class="form-action px-3">
                  <select name="select-status" class="form-control" id="" name="action">
                  <option {{ $contact->status == "pending"?"selected":"" }} value="pending">Đang chờ duyệt</option>
                  <option {{ $contact->status == "approved"?"selected":"" }} value="approved">Đã duyệt</option>
                </select>
                <input type="submit" name="btn-status" value="Cập nhật" class="btn btn-primary">
              </form>
        </div>
    </div>
</div>
@endsection