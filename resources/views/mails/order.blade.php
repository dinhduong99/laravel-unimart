<div style="background-color:#ffffff;margin:0;padding:0">
	
	<div style="background-color:#ffffff">
		<table style="border-collapse:collapse;table-layout:fixed;color:#999;font-family:Georgia,serif;margin-bottom:1px;border-bottom:2px solid #f83649" align="center">
			<tbody>
				<tr>
					<td style="padding:10px 0 6px 0;vertical-align:top;width:450px">
						<div align="left" id="m_-8577439486122036794emb-email-header">
							<img style="height: 40px;border: 1px white solid;border-radius: 6px;" 
							src="{{ $message->embed('public/uploads/logo-dd.PNG') }}" alt="Logo DD STORE" class="CToWUd" data-bit="iit">
							<p style="margin:0;font-size:12px;color:#444444;font-weight:bold;font-family:open sans,sans-serif">Trang bán hàng trực tuyến của <span ><a style="color:#f83649;" href="{{ url("") }}" target="_blank" >ddstore.com.vn</a></span></p>
						</div>
					</td>
					<td style="text-align:right;padding:10px 0 0 0;vertical-align:bottom;width:150px">
						<p style="font-size:14px;color:#f83649;font-weight:bold;font-family:open sans,sans-serif;margin-bottom:6px"><a style="color:#f83649;text-decoration:none;font-weight:bold;font-size:14px" href="tel:0966158666" target="_blank"><span style="color:#f83649;font-weight:bold;font-size:14px">Hotline: 0909 090 909</span> </a></p>
					</td>
				</tr>

			</tbody>
		</table>
		<table style="border-collapse:collapse;table-layout:fixed;Margin-left:auto;Margin-right:auto" align="center" id="m_-8577439486122036794emb-email-header-container">
			<tbody>
				<tr>
					<td style="padding:0;width:600px">
						<div style="color:#41637e;font-family:Avenir,sans-serif;font-size:26px;line-height:32px;Margin-bottom:0px">
							<div style="background-color:#f83649;height:120px;display:flex" align="center" id="m_-8681123714821486489emb-email-header">
								<p style="float:left;width:430px;margin-left:20px;text-align:left;text-transform:uppercase;color:#fff;font-size:24px;line-height:70px">Xác nhận đơn hàng
								</p>
								<p style="margin-top:32px;width:150px;display:inline-block;color:#272727;font-size:15px;font-weight:600">Mã đơn hàng <br> <span style="color:#272727">#{{ $code }}</span></p>
							</div>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		<table style="border-collapse:collapse;table-layout:fixed;Margin-left:auto;Margin-right:auto;word-wrap:break-word;word-break:break-word;background-color:#f4f8fa;border:1px solid #f6f6f6" align="center">
			<tbody>
				<tr>
					<td style="padding:0;text-align:left;vertical-align:top;color:#555657;font-size:13px;line-height:21px;font-family:Georgia,serif;width:600px">
						<div style="Margin-left:25px;Margin-right:25px;Margin-top:24px">
							<p style="Margin-top:0;Margin-bottom:0;font-family:open sans,sans-serif">
								<span>Kính chào quý khách <strong>{{ $fullname }}</strong></span>
							</p>
							<p style="Margin-top:20px;Margin-bottom:0;font-family:open sans,sans-serif">
								<span>Chân thành cảm ơn quý khách đã mua sắm tại <strong style="color:#f83649">ddstore.com.vn</strong></span>
							</p>
							<p style="Margin-top:20px;Margin-bottom:20px;font-family:open sans,sans-serif">
								<span>Chúng tôi hy vọng quý khách hài lòng với trải nghiệm mua sắm và các sản phẩm đã chọn.</span>
							</p>
							<p style="Margin-top:20px;Margin-bottom:20px;font-family:open sans,sans-serif">
								<span>Đơn hàng của quý khách hiện đã được tiếp nhận.</span>
							</p>
						</div>
						<div style="Margin-left:15px;Margin-right:15px;margin-top:20px;background:#fff;padding:20px 15px">
							<p style="color:#024fa0;font-family:open sans,sans-serif;font-size:15px;margin-top:0"><strong>Chi tiết đơn hàng  </strong>
							</p>
							<table style="width:100%;border-collapse:collapse">
								<tbody style="font-family:open sans,sans-serif">
									<tr>
										<th>
											Hình ảnh
										</th>
										<th align="left">
											Tên
										</th>
										<th align="left">
											Đơn giá
										</th>
										<th align="left">
											Số lượng
										</th>
										<th align="left">
											Thành tiền
										</th>
									</tr>
									@foreach ($product_order as $product)
									<tr style="border-bottom:1px dotted #f0f0f0">
										<td style="width:15%;padding:10px 0">
											<span style="float:left;border:1px solid #e1e1e1"><img src="{{ $message->embed($product->options->thumbnail) }}" width="100%" class="CToWUd" data-bit="iit" jslog="138226; u014N:xr6bB; 53:W2ZhbHNlLDJd">
											</span>
										</td>
										<td align="left" style="width:35%;font-family:open sans,sans-serif;vertical-align:top;padding:10px 0">
											<span style="display:inherit;padding-left:5px;font-family:open sans,sans-serif;color:#024fa0;font-weight:300">{{ $product->name }}</span>
										</td>
										<td align="left" style="font-family:open sans,sans-serif;vertical-align:top;padding:10px 0">
											{{ number_format($product->price,0,',','.') }}đ
										</td>
										<td align="left" style="font-family:open sans,sans-serif;vertical-align:top;padding:10px 0;text-align:center">
											{{ $product->qty }}
										</td>
										<td align="left" style="font-family:open sans,sans-serif;vertical-align:top;padding:10px 0">
											{{ number_format($product->subtotal,0,',','.') }}đ
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
							<table style="border-collapse:collapse;table-layout:fixed;Margin-left:auto;Margin-right:auto;word-wrap:break-word;word-break:break-word;background-color:#ffffff;margin-top:10px" align="center">
								<tbody>
									<tr>
										<td style="padding:0;text-align:left;vertical-align:top;color:#565656;font-size:14px;line-height:21px;font-family:Georgia,serif;width:600px">
											<div style="background:#f3d9ee;padding:0 10px">

												
												<table align="center" style="width:100%;border-collapse:collapse">
													<tbody>
														<tr style="border-bottom:1px dotted #fff">
															<td colspan="2" style="font-family:open sans,sans-serif;font-weight:bold;padding:10px 0">
																Tổng giá trị sản phẩm:
															</td>
															<td align="right" style="font-family:open sans,sans-serif">
																{{ number_format($card_total ,0,',','.') }}đ
															</td>
														</tr>
														<tr>
															<td colspan="2" style="font-family:open sans,sans-serif;font-weight:bold;padding:10px 0">
																Phí vận chuyển:
															</td>
															<td align="right" style="font-family:open sans,sans-serif">
																0 ₫
															</td>
														</tr>
													</tbody>
												</table>
											</div>
											<div style="padding:10px 10px 0 10px">
												<table align="center" style="width:100%">
													<tbody>
														<tr>
															<td colspan="2" style="font-family:open sans,sans-serif;font-size:16px;">
																<strong style="Margin-top:0;Margin-bottom:0;font-size:16px;line-height:24px">Thành tiền</strong>
																<br>
																(Đã bao gồm VAT)
															</td>
															<td align="right" style="font-family:open sans,sans-serif;color:#f83649;font-weight:bold">
																{{ number_format($card_total ,0,',','.') }}đ
															</td>
														</tr>
													</tbody>
												</table>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div style="Margin-left:15px;Margin-right:15px;margin-top:20px;background:#fff;padding:20px 15px">
							<p style="color:#024fa0;font-family:open sans,sans-serif;font-size:15px;margin-top:0"><strong>Thông tin đơn hàng</strong>
							</p>
							<table style="border-collapse:collapse;table-layout:fixed;Margin-left:auto;Margin-right:auto;word-wrap:break-word;word-break:break-word;background-color:#ffffff;border-bottom:1px dotted #b7b6a8;padding-bottom:15px;width:100%" align="center">
								<tbody>
									<tr>
										<td style="font-family:open sans,sans-serif;font-weight:bold">
											Mã đơn hàng của quý khách:
										</td>
										<td style="font-family:open sans,sans-serif">
											#{{ $code }}
										</td>
									</tr>
									<tr>
										<td style="font-family:open sans,sans-serif;font-weight:bold">
											Thời gian đặt hàng:
										</td>
										<td style="font-family:open sans,sans-serif">
											<p>	{{ $time_order}}</p>
										</td>
									</tr>
									<tr>
										<td width="45%" style="font-family:open sans,sans-serif;font-weight:bold">
											Phương thức thanh toán:
										</td>
										<td style="font-family:open sans,sans-serif">
											@if ($payment_method == 'payment-home')
												Thanh toán tại nhà
												@endif
										</td>
									</tr>
									<tr>
										<td width="45%" style="font-family:open sans,sans-serif;font-weight:bold">
											Tình trạng thanh toán:
										</td>
										<td style="font-family:open sans,sans-serif">
											Đang chờ xác nhận
										</td>
									</tr>
									<tr>
										<td style="font-family:open sans,sans-serif;font-weight:bold">
											Phương thức giao hàng:
										</td>
										<td>
											<p>
																					
												Giao hàng tận nơi
											</p>
										</td>
									</tr>
									<tr>
										<td style="font-family:open sans,sans-serif;font-weight:bold">
											Ghi chú:
										</td>
										<td>
											<p>								
												{{ $note }}
											</p>
										</td>
									</tr>
								</tbody>
							</table>
							<p style="color:#024fa0;font-family:open sans,sans-serif;font-size:15px;margin-top:15px"><strong>Địa chỉ giao hàng</strong>
							</p>
							<table style="border-collapse:collapse;table-layout:fixed;Margin-left:auto;Margin-right:auto;word-wrap:break-word;word-break:break-word;background-color:#ffffff;width:100%" align="center">
								<tbody>
									
									<tr>
										<td style="font-family:open sans,sans-serif;font-weight:bold">
											Tên người nhận:
										</td>
										<td style="font-family:open sans,sans-serif">
											<strong>{{ $fullname}}</strong>
										</td>
									</tr>
									
									
									<tr>
										<td style="font-family:open sans,sans-serif;font-weight:bold">
											Địa chỉ người nhận:
										</td>
										<td style="font-family:open sans,sans-serif">
											<p>
												{{ $address }}
											</p>
										</td>
									</tr>
									<tr>
										<td width="45%" style="font-family:open sans,sans-serif;font-weight:bold">
											Số điện thoại liên hệ:
										</td>
										<td style="font-family:open sans,sans-serif">
											{{ $phone }}
										</td>
									</tr>
									
								</tbody>
							</table>
						</div>
						<div style="Margin-left:15px;Margin-right:15px;margin-top:20px;background:#fff;padding:20px 15px">
							<p style="color:#024fa0;font-family:open sans,sans-serif;font-size:15px;margin-top:0"><strong>Thời gian giao hàng dự kiến</strong>
							</p>
							<table style="border-collapse:collapse;table-layout:fixed;Margin-left:auto;Margin-right:auto;word-wrap:break-word;word-break:break-word;background-color:#ffffff;padding-bottom:15px;width:100%" align="center">
								<tbody>
									<tr>
										<td colspan="2" style="font-family:open sans,sans-serif">
										- Khu vực Hồ Chí Minh: 1-2 ngày (nội thành) và 2-3 (ngoại thành) <br>
										- Khu vực miền Tây: 4-5 ngày <br>
										- Khu vực Đà Nẵng và miền Trung: 4-6 ngày <br>
										- Khu vực Hà Nội: 5 ngày (nội thành) và 7-8 ngày (ngoại thành) <br>
										- Các tỉnh phía Bắc khác: 6-8 ngày <br>
										Thời gian trên được tính kể từ ngày bưu điện bắt đầu phát hàng đi, chưa bao gồm thời gian xác nhận đơn hàng và không giao vào ngày Chủ nhật và ngày lễ.	
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div style="Margin-left:20px;Margin-right:20px;Margin-bottom:20px">
							<div style="background-color:#edeee7;display:block;font-size:2px;line-height:1px;width:100%;Margin-bottom:20px">
								&nbsp;
							</div>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		<table style="border-collapse:collapse;table-layout:fixed;Margin-left:auto;Margin-right:auto;word-wrap:break-word;word-break:break-word;background-color:#ffffff;margin-top:15px" align="center">
			<tbody>
				<tr>
					<td style="padding:0;text-align:left;vertical-align:top;color:#565656;font-size:14px;line-height:21px;font-family:Georgia,serif;width:600px">
						<div style="Margin-left:15px;Margin-right:15px;Margin-bottom:30px">
							<p style="Margin-top:0;Margin-bottom:0;font-family:open sans,sans-serif">
								<span>Mọi thắc mắc và góp ý, xin Quý khách vui lòng liên hệ với chúng tôi qua:
								</span>
							</p>
							<p style="Margin-top:0;Margin-bottom:0;font-family:open sans,sans-serif">
								<span>Email hỗ trợ: <span style="color:#007ec6"><a href="mailto:tuvan_online@bitis.com.vn" target="_blank">tuvanonline@ddstore.com.vn</a></span></span>
							</p>
							<p style="Margin-top:0;Margin-bottom:0;font-family:open sans,sans-serif">
								Số hotline: <a style="color:#f83649;text-decoration:none;font-weight:bold;font-size:14px" href="tel:0966158666" target="_blank"><span style="color:#f83649;font-weight:700"> 0909 090 909</span></a>
							</p>
							<p style="Margin-top:0;Margin-bottom:0;font-family:open sans,sans-serif">
								<strong style="color:#f83649">DD STORE</strong> Trân trọng cảm ơn và rất hân hạnh được phục vụ Quý khách.
							</p>
						</div>
					</td>
				</tr>
			</tbody>
		</table><div class="yj6qo"></div><div class="adL">
	</div></div><div class="adL">
</div></div>
