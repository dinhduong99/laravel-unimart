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
        <h5 class="m-0 ">Chi tiết đơn hàng</h5>
    </div>
        <div class="card-body" style="border-bottom:2px solid #dee2e6">
          <div class="font-weight-bold px-2 py-3">
            Thông tin khách hàng
          </div>
            <table class="table table-striped">
                <tbody>
                  <tr>
                    <td>Mã đơn hàng:</td>
                    <td>#{{ $order->code }}</td>
                  </tr>
                  <tr>
                    <td>Tên khách hàng:</td>
                    <td>{{ $order->fullname }}</td>
                  </tr>
                  <tr>
                    <td>Địa chỉ email:</td>
                    <td>{{ $order->email }}</td>
                  </tr>  
                  <tr>
                    <td>Số điện thoại:</td>
                    <td>{{ $order->phone }}</td>
                  </tr>  
                  <tr>
                    <td>Địa chỉ:</td>
                    <td>{{ $order->address }}, {{ $order->wards}}, {{ $order->province}}, {{ $order->city}}</td>
                  </tr> 
                  <tr>
                    <td>Thời gian đặt hàng:</td>
                    <td>{{date('d/m/Y - H:i:s', strtotime($order->created_at))  }}</td>
                  </tr>
                  <tr>
                    <td>Phương thức thanh toán:</td>
                    <td>
                    @if ($order->payment_method=='payment-home')
                      Thanh toán tại nhà
                    @endif
                    </td>
                  </tr>
                  <tr>
                    <td>Ghi chú:</td>
                    <td>
                    @if ($order->note =="")
                      Không có
                    @else
                      {{ $order->note }}
                    @endif
                    </td>
                  </tr>
                </tbody>
            </table>
              <form action=" {{ route('detail.order_status',$order->id) }}" method="POST">
                @csrf 
                <div class="form-action form-inline pb-3">
                  <label class="pl-2" for="">Tình trạng đơn hàng:</label>
                  <div class="form-action px-3">
                  <select name="select-status" class="form-control" id="" name="action">
                  <option {{ $order->status == "complete"?"selected":"" }} value="complete">Đã hoàn thành</option>
                  <option {{ $order->status == "processing"?"selected":"" }} value="processing">Đang xử lý</option>
                  <option {{ $order->status == "delivering"?"selected":"" }} value="delivering">Đang giao hàng</option>
                  <option {{ $order->status == "cancel"?"selected":"" }} value="cancel">Đã hủy</option>
                </select>
              </div>
                <input type="hidden" name="fullname" value="{{ $order->fullname }}" />
                <input type="hidden" name="phone" value="{{ $order->phone }}" />
                <input type="hidden" name="email" value="{{ $order->email }}" />
                <input type="hidden" name="create_at" value="{{$order->created_at}}" />
                <input type="hidden" name="address" value="{{ $order->address }}" />
                <input type="hidden" name="wards" value="{{ $order->wards}}" />
                <input type="hidden" name="province" value="{{ $order->province}}" />
                <input type="hidden" name="city" value="{{ $order->city}}" />
                <input type="hidden" name="card_total" value="{{$order->card_total}}" />
                <input type="hidden" name="order_status" value="{{$order->status}}" />
                <input type="submit" name="btn-status" value="Cập nhật" class="btn btn-primary">
              </div>
              </form>
        </div>
        <div class="card-body">
          <div class="font-weight-bold px-2 py-3">
            Thông tin đơn hàng
          </div>
          <table class="table table-striped">
              <thead>
                  <tr>
                      <th scope="col">#</th>
                      <th style="width:10%" scope="col">Ảnh</th>
                      <th scope="col">Tên sản phẩm</th>
                      <th scope="col">Giá</th>
                      <th scope="col">Số Lượng</th>
                      <th scope="col">Thành tiền</th>
                  </tr>
              </thead>
              <tbody>
                @php
                  $t=0;
                  $product_order= json_decode($order->product_order);
                @endphp
                @foreach ($product_order as $product)
                @php
                  $t++;
                @endphp
                <tr class="">
                  <td>{{ $t }}</td>
                  <td><a href=""><img style="width:100%" src="{{ url($product->options->thumbnail) }}" alt=""></a></td>
                  <td>{{ $product->name }}</td>
                  <td>{{ number_format($product->price,0,',','.') }}đ</td>
                  <td>{{ $product->qty }}</td>
                  <td>{{ number_format($product->subtotal,0,',','.') }}đ</td>
                </tr>
                @endforeach
              </tbody>
              <tfoot>
                  <tr class="">
                    <td colspan="6" style="font-weight: bold">Tổng giá trị đơn hàng: <span style="color: red;padding-left:10px">{{ number_format($order->card_total,0,',','.') }}đ</span></td>
                  </tr>
              </tfoot>
          </table>
      </div>
    </div>
</div>
@endsection