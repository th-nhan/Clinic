<!-- modal add -->

<div class="modal fade" id="addHistoryModal" tabindex="-1" aria-labelledby="addHistoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow-lg border-0">
            <div class=" modal-header bg-primary text-white">
                <h5 class="modal-title" id="addHistoryLabel">Thêm lịch sử khám </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="#" method="post">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Khách hàng</label>
                            <input type="text" name="khachhang" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Bác sĩ</label>
                            <select name="bacsi" id="" class="form-select">
                                <option value="">Tất cả bác sĩ</option>
                                @foreach ($users as $item )  
                                <option value="">
                                    {{ $item->fullname ?? 'Không có tên' }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Ngày khám</label>
                            <input type="date" name="ngaykham" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Dịch vụ</label>
                            <select name="dichvu" class="form-select">
                                <option value="">Tất cả dịch vụ</option>
                                @foreach ($services as $item )
                                <option value="">
                                    {{ $item->name ?? 'Không có tên' }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tổng tiền</label>
                            <input type="number" name="tongtien" class="form-control" placeholder="VD: 650000" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Giờ hẹn</label>
                            <input type="date" name="lichhen" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>

        </div>
    </div>
</div>



<!-- modal update -->

<div class="modal fade" id="editHistoryModal" tabindex="-1" aria-labelledby="editHistoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="editHistoryLabel">Sửa lịch sử khám</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Khách hàng</label>
                            <input type="text" name="khachhang" id="edit-khachhang" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Bác sĩ</label>
                            <input type="text" name="bacsi" id="edit-bacsi" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Ngày khám</label>
                            <input type="date" name="ngaykham" id="edit-ngaykham" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Dịch vụ</label>
                            <input type="text" name="dichvu" id="edit-dichvu" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tổng tiền</label>
                            <input type="number" name="tongtien" id="edit-tongtien" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Ngày hẹn</label>
                            <input type="date" name="lichhen" id="edit-lichhen" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-warning text-white">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- modal delete -->

<div class="modal fade" id="deleteHistoryModal">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-sm">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteHistoryLabel"> Xác nhận xóa</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="deleteForm" method="POST">
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa <strong class="text-danger" id="delete-name">lịch sử</strong>
                        này không?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger">Xóa</button>
                </div>
            </form>
        </div>
    </div>
</div>




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
                <div class="row g-4 g-4 align-items-center">
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
                    </div>
                    <div class="col-md-4 text-center">
                        <h6 class="fw-bold ">Bác sĩ phụ trách</h6>
                        <div class=" d-flex flex-column align-items-center justify-content-center">
                            <img src="{{ $item->user->avatar }}" alt="{{ $item->user->fullname ?? 'Bác sĩ' }}"
                                class="rounded-circle border-3 border-secondary" style="max-width: 170px; max-height: 170px; object-fit: cover;" width="150" height="150">
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
                    <span class="btn btn-success">Cần thanh toán</span>
                    @endif
                </button>
            </div>
        </div>
    </div>
</div>
@endforeach