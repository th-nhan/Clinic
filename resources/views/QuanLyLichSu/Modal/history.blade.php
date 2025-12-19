<title>History</title>
<!-- modal add history -->
<form action="{{ route('lichsu.store') }}" method="POST">
    @csrf
    <div class="modal fade" id="addHistoryModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header bg-primary text-white">
                    <h5 class="fw-bold">Thêm lịch sử khám</h5>
                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body px-4">

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="fw-bold">Khách hàng: </label>
                            <input type="text" name="khachhang" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold">Số điện thoại khách hàng:</label>
                            <input type="text" name="sodienthoai" class="form-control" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="fw-bold">Bác sĩ: </label>
                            <select name="bacsi" class="form-select" required>
                                <option value="">Tất cả bác sĩ</option>
                                @foreach($users as $u)
                                @if ($u->description == 'Nha sĩ')
                                  <option value="{{ $u->user_id }}">{{ $u->fullname }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="fw-bold">Ngày khám: </label>
                            <input type="date" name="ngaykham" class="form-control" max="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="col-md-3">
                            <label class="fw-bold">Giờ hẹn: </label>
                            <input type="time" name="giohen" class="form-control" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3 align-items-center">

                        <div class="col-md-6">
                            <label class="fw-bold">Trạng thái: </label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="radioStatus" value="unpaid" required>
                                <label class="form-check-label">Chưa thanh toán</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="radioStatus" value="paid" required>
                                <label class="form-check-label">Đã thanh toán</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold">Tổng tiền: </label>
                            <input type="number" name="tien" class="form-control" required>
                        </div>

                        <div class="row g-1">
                            <label class="fw-bold">Dịch vụ (chọn ít nhất 1): </label>

                            @foreach($services as $s)
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="dichvu[]"
                                        value="{{ $s->service_id }}">
                                    <label class="form-check-label">{{ $s->name }}</label>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="row g-1">
                            <label class="fw-bold">Ghi chú: </label>
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea"
                                    name="ghichu"></textarea>
                                <label for="floatingTextarea">Ghi chú</label>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button class="btn btn-primary" type="submit">Lưu</button>
                </div>

            </div>
        </div>
    </div>
</form>



<!-- modal update history  -->
@foreach($histories as $item)
<form action="{{ route('lichsu.update', $item->history_id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="modal fade" id="editHistoryModal-{{ $item->history_id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5>Sửa lịch sử khám</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body px-4">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label>Khách hàng</label>
                            <input type="text" name="khachhang" class="form-control"
                                value="{{ $item->customer->fullname}}" required>
                        </div>
                        <div class="col-md-6">
                            <label>Số điện thoại khách hàng</label>
                            <input type="text" name="sodienthoai" class="form-control" required
                                value="{{ $item->customer->contact_number }}">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label>Bác sĩ</label>
                            <select name="bacsi" class="form-select" required>
                                <option value="">Tất cả bác sĩ</option>
                                @foreach($users as $u)
                                <option value="{{ $u->user_id }}" {{ $item->user_id == $u->user_id ? 'selected' : '' }}>
                                    {{ $u->fullname }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Ngày khám</label>
                            <input type="date" name="ngaykham" class="form-control" value="{{ $item->date }}" required>
                        </div>
                        <div class="col-md-3">
                            <label>Giờ hẹn</label>
                            <input type="time" name="giohen" class="form-control" value="{{ $item->time ?? '' }}">
                        </div>
                    </div>

                    <div class="row g-3 mb-3 align-items-center">
                        <div class="col-md-6">
                            <label>Trạng thái</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="radioStatus"
                                    id="radioUnpaid-{{ $item->history_id }}" value="unpaid" {{
                                    optional($item->invoice)->status == 'unpaid' ? 'checked' : '' }}>
                                <label class="form-check-label" for="radioUnpaid-{{ $item->history_id }}">Chưa thanh
                                    toán</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="radioStatus"
                                    id="radioPaid-{{ $item->history_id }}" value="paid" {{
                                    optional($item->invoice)->status == 'paid' ? 'checked' : '' }}>
                                <label class="form-check-label" for="radioPaid-{{ $item->history_id }}">Đã thanh
                                    toán</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Tổng tiền</label>
                            <input type="number" name="tien" class="form-control"
                                value="{{$item->invoice->total_price}}">
                        </div>
                        <div class="row g-1">
                            <label>Dịch vụ</label>
                            @foreach($services as $s)
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input service-checkbox" type="checkbox" name="dichvu[]"
                                        value="{{ $s->service_id }}" data-min="{{ $s->min_price }}"
                                        data-max="{{ $s->max_price }}" {{ $item->historyDetails->contains('service_id',
                                    $s->service_id) ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $s->name }}</label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="row g-1">
                            <label class="fw-bold">Ghi chú: </label>
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea"
                                    name="ghichu"></textarea>
                                <label for="floatingTextarea">Ghi chú</label>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-warning">Lưu</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endforeach




<!-- modal delete -->

@foreach ($histories as $item)
<form id="deleteForm" method="POST" action="{{ route('lichsu.destroy', $item->history_id) }}">
    @csrf
    @method('DELETE')

    <div class="modal fade" id="deleteHistoryModal-{{ $item->history_id }}">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header bg-danger text-white">
                    <h5>Xóa lịch sử khám</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    Bạn có chắc muốn xóa lịch sử này không?
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger">Xóa</button>
                </div>

            </div>
        </div>
    </div>

</form>
@endforeach


<!-- modal details  -->>

@foreach ($histories as $item )
<div class="modal fade" id="viewHistoryModal-{{ $item->history_id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-dark">
                <h5 class="modal-title fw-bold">Chi tiết lịch sử khám</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4 align-items-center">
                    <div class="col-md-8">
                        <div class="mb-2"><span class="fw-bold">Mã khách hàng: </span>{{ $item->customer_id }}</div>
                        <div class="mb-2"><span class="fw-bold">Tên khách hàng: </span>{{ $item->customer->fullname }}
                        </div>
                        <div class="mb-2"><span class="fw-bold">Bác sĩ phụ trách: </span>{{ $item->user->fullname }}
                        </div>
                        <div class="mb-2"><span class="fw-bold">Ngày khám:</span> {{
                            \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}</div>
                        <div class="mb-2">
                            <span class="fw-bold">Dịch vụ thực hiện:</span>
                            <ul class="mb-0 ps-3">
                                @foreach($item->historyDetails as $detail)
                                <li>{{ $detail->service->name ?? 'Không có tên' }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="mb-2">
                            <span class="fw-bold">Tổng tiền:</span>
                            <span class="text-success fw-semibold">{{ number_format($item->invoice->total_price ??
                                0,0,',','.') }}đ</span>
                        </div>
                        <div class="mb-2">
                            <span class="fw-bold">Trạng thái hóa đơn: </span>
                            @if(optional($item->invoice)->status == 'paid')
                            <span class="badge bg-success">Đã thanh toán</span>
                            @elseif(optional($item->invoice)->status == 'unpaid')
                            <span class="badge bg-warning text-dark">Chưa thanh toán</span>
                            @else
                            <span class="badge bg-secondary">Không rõ</span>
                            @endif
                        </div>
                        <div class="mb-2">
                            <span class="fw-bold">Số điện thoại khách hàng: </span>
                            <span> {{ $item->customer->contact_number }}</span>
                        </div>
                        <div class="mb-2">
                            <span class="fw-bold">Ghi chú: </span>
                            <span> {{ $item->noted }}</span>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <h6 class="fw-bold ">Bác sĩ phụ trách</h6>
                        <div class=" d-flex flex-column align-items-center justify-content-center">
                            <img src="{{ $item->user->avatar }}" alt="{{ $item->user->fullname ?? 'Bác sĩ' }}"
                                class="rounded-circle border-3 border-secondary"
                                style="max-width: 160px; max-height: 160px; object-fit: cover;" width="150"
                                height="150">
                            <p class="mb-0 fw-semibold mt-2">{{ $item->user->fullname ?? 'Bác sĩ' }}</p>
                            <p class="text-muted small mt-2">Chuyên khoa: {{ $item->user->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button class="w-" data-bs-dismiss="#">
                    @if(optional($item->invoice)->status == 'paid')
                    <button class="btn btn-success" disabled> Thanh toán rồi</button>
                    @elseif(optional($item->invoice)->status == 'unpaid')
                    <form action="{{ route('hoadon.show', $item->invoice->invoice_id) }}" method="GET">
                        <button class="btn btn-success">Cần thanh toán</button>
                    </form>
                    @endif
                </button>
            </div>
        </div>
    </div>
</div>
@endforeach