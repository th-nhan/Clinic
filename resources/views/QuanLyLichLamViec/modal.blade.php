{{-- Modal xem chi tiết bác sĩ --}}
@foreach ($schedule as $item)
    <div class="modal fade" id="doctorDetailModal--{{ $item->schedule_id }}" tabindex="-1"
        aria-labelledby="doctorDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="doctorDetailModalLabel">Chi Tiết Lịch Làm Việc</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="row g-4">
                        <div class="col-12 col-md-7">
                            <p><strong>ID:</strong> <span>{{ $item->schedule_id }}</span></p>
                            <p><strong>Tên bác sĩ:</strong> <span>{{ $item->user->fullname ?? 'Không có tên' }}</span>
                            </p>
                            <p><strong>Ngày làm việc:</strong> <span>{{ $item->date }}</span></p>
                            <p><strong>Ca làm việc:</strong>
                                <span>
                                    @if ($item->schedule_time_id == 1)
                                        <span class="badge bg-success">Sáng</span>
                                    @elseif ($item->schedule_time_id == 2)
                                        <span class="badge bg-warning">Chiều</span>
                                    @else
                                        <span class="badge bg-primary">Cả ngày</span>
                                    @endif
                                </span>
                            </p>
                            <p><strong>Email:</strong> <span>{{ $item->user->email ?? 'Không có email' }}</span></p>
                            <p><strong>Số điện thoại:</strong>
                                <span>{{ $item->user->contact_number ?? 'Không có số điện thoại' }}</span>
                            </p>
                            <p><strong>Tình trạng:</strong>
                                <span>
                                    @if ($item->status == 'Đã duyệt')
                                        <span class="badge bg-success">Đã duyệt</span>
                                    @elseif ($item->status == 'Chờ duyệt')
                                        <span class="badge bg-warning">Chờ duyệt</span>
                                    @else
                                        <span class="badge bg-danger">Đã hủy</span>
                                    @endif
                                </span>
                            </p>

                        </div>

                        <div class="col-12 col-md-5 d-flex flex-column align-items-center justify-content-center">
                            <img src="pic/bs1.jpg" alt="BS. Trần Minh" class="rounded-circle border-3 border-secondary"
                                width="150" height="150">
                            <p class="mb-0 fw-semibold mt-2" id="detail-ten-display"></p>
                            <p class="text-muted small mt-2">Chuyên khoa: Phục hình răng</p>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>

            </div>
        </div>
    </div>
@endforeach

{{-- Form Cập nhật lịch làm việc  --}}
@foreach ($schedule as $item)
    <div class="modal fade" id="capNhatLichLamViec--{{ $item->schedule_id }}" tabindex="-1"
        aria-labelledby="capNhatLichLamViecLabel-{{ $item->schedule_id }}" aria-hidden="true">
        
        <div class="modal-dialog modal-l">
            <div class="modal-content">
                <form>
                    <div class="modal-header bg-info text-white">
                        
                        <h5 class="modal-title" id="capNhatLichLamViecLabel-{{ $item->schedule_id }}">
                            <i class="bi bi-floppy2-fill text-white p-2"></i>
                            Cập Nhật Lịch Làm Việc
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-4"> <div class="col-12">
                                <label for="doctorDataList-{{ $item->schedule_id }}" class="form-label fw-bold">Chọn bác sĩ</label>
                                <input class="form-control" list="datalistOptions"
                                    id="doctorDataList-{{ $item->schedule_id }}" placeholder="Gõ để tìm kiếm..."
                                    value="{{ $item->user->fullname ?? 'Không có tên' }}" disabled>
                            </div>

                            <div class="col-12">
                                <label for="dateTimePicker-{{ $item->schedule_id }}" class="form-label fw-bold">Chọn ngày</label>
                                <input type="date" class="form-control" id="dateTimePicker-{{ $item->schedule_id }}"
                                    value="{{ $item->date }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold d-block mb-2">Chọn ca làm việc</label>
                                <div class="d-flex flex-wrap gap-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio"
                                            name="caLamViec-{{ $item->schedule_id }}"
                                            id="ca1-{{ $item->schedule_id }}" value="ca1"
                                            {{ old('caLamViec-' . $item->schedule_id, $item->schedule_time_id) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ca1-{{ $item->schedule_id }}">Sáng</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio"
                                            name="caLamViec-{{ $item->schedule_id }}"
                                            id="ca2-{{ $item->schedule_id }}" value="ca2"
                                            {{ old('caLamViec-' . $item->schedule_id, $item->schedule_time_id) == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="ca2-{{ $item->schedule_id }}">Chiều</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio"
                                            name="caLamViec-{{ $item->schedule_id }}"
                                            id="ca3-{{ $item->schedule_id }}" value="ca3"
                                            {{ old('caLamViec-' . $item->schedule_id, $item->schedule_time_id) == 3 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ca3-{{ $item->schedule_id }}">Cả
                                            ngày</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="status-{{ $item->schedule_id }}" class="form-label fw-bold">Tình trạng</label>
                                @php $statusName = 'status-' . $item->schedule_id; @endphp
                                <select class="form-select" aria-label="Tình trạng"
                                    id="status-{{ $item->schedule_id }}" name="status-{{ $item->schedule_id }}">
                                    <option value="1"
                                        {{ old($statusName, $item->status) == 'Đã duyệt' ? 'selected' : '' }}>Đã duyệt
                                    </option>
                                    <option value="2"
                                        {{ old($statusName, $item->status) == 'Chờ duyệt' ? 'selected' : '' }}>Chờ
                                        duyệt
                                    </option>
                                    <option value="3"
                                        {{ old($statusName, $item->status) == 'Đã hủy' ? 'selected' : '' }}>
                                        Đã hủy</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-info">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

{{-- Modal xóa lịch làm việc --}}

<div class="modal fade" id="deleteLichLamViecModal" tabindex="-1" aria-labelledby="deleteLichLamViecModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteLichLamViecModalLabel">Xóa Lịch Làm Việc</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa lịch làm việc này không?</p>
                <p class="text-danger"><small>Hành động này không thể hoàn tác!</small></p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Xóa</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal thêm lịch làm việc mới thành công --}}
<div class="modal fade" id="addLichLamViecSuccessModal" tabindex="-1"
    aria-labelledby="addLichLamViecSuccessModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="addLichLamViecSuccessModalLabel">Thêm Lịch Làm Việc Thành Công</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <p>Lịch làm việc mới đã được thêm thành công!</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

{{-- Them lich --}}

<div class="modal fade" id="themLichLamViecModal" tabindex="-1" aria-labelledby="themLichLamViecModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-l">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="themLichLamViecModalLabel">Thêm Lịch Làm Việc</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="formThemLich" action="#">
                    <div class="row g-4">
                        <div class="col-12">
                            <label for="doctorDataList" class="form-label fw-bold">Chọn bác sĩ</label>
                            <input class="form-control" list="datalistOptions" id="doctorDataList"
                                placeholder="Gõ để tìm kiếm...">
                            <datalist id="datalistOptions">
                                <option value="Dr. Đỗ Thành Nhân"></option>
                                <option value="Dr. Ngô Minh Quý"></option>
                                <option value="Dr. Nguyễn Cường Đại"></option>
                                <option value="Dr. La Chí Thành"></option>
                            </datalist>
                        </div>

                        <div class="col-12">
                            <label for="dateTimePicker" class="form-label fw-bold">Chọn ngày</label>
                            <input type="date" class="form-control" id="dateTimePicker">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold d-block mb-2">Chọn ca làm việc</label>
                            <div class="d-flex flex-wrap gap-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="caLamViec" id="ca1"
                                        value="ca1" checked>
                                    <label class="form-check-label" for="ca1">Sáng</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="caLamViec" id="ca2"
                                        value="ca2">
                                    <label class="form-check-label" for="ca2">Chiều</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="caLamViec" id="ca3"
                                        value="ca3">
                                    <label class="form-check-label" for="ca3">Cả ngày</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="status" class="form-label fw-bold">Tình trạng</label>
                            <select class="form-select" aria-label="Tình trạng" id="status">
                                <option value="1">Đã duyệt</option>
                                <option value="2" selected>Chờ duyệt</option>
                                <option value="3">Đã hủy</option>
                            </select>
                        </div>
                    </div>
                </form>

            </div>

            <div class="modal-footer">
                <div class="mt-5 d-flex justify-content-center">
                    <button type="submit" class="btn btn-success btn-lg px-5 shadow-sm" form="formThemLich">
                        Lưu Lịch Làm Việc
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
