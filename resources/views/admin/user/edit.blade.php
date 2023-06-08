@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Cập nhật thông tin
        </div>
        <div class="card-body">
            <form action="{{ route('update.user',$user->id) }}" method='POST'> 
                @csrf
                <div class="form-group">
                    <label for="name">Họ và tên</label>
                    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ $user->name }}">
                </div>
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" id="email" value="{{ $user->email }}" disabled>
                </div>
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" id="password">
                </div>
                @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label for="password_confirmation">Xác Nhận Mật khẩu</label>
                    <input class="form-control @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation" id="password_confirmation">
                </div>
                @error('password_confirmation')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              
                <div class="form-group">
                    <label for="role">Nhóm quyền</label>
                  
                    <select class="form-control @error('role') is-invalid @enderror" name="role_id" id="">
                        <option>Chọn quyền</option>
                        @foreach ($roles as $role)
                        <option {{ $user->role_id == $role->id ?'selected':''}} value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                
                </div>
                @error('role')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
                <button type="submit" name="btn-update" value="Thêm mới" class="btn btn-primary">Cập nhật</button>
            </form>
        </div>
    </div>
</div>
@endsection