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

                        <div class="col-md-5 d-flex flex-column align-items-center justify-content-start text-center">

                            <div class="rounded-circle border border-3 border-secondary overflow-hidden mb-3"
                                style="width: 150px; height: 150px;">
                                <img id="detail-avatar" src="{{ $item->user->avatar ?? asset('pic/bs1.jpg') }}"
                                    alt="{{ $item->user->fullname }}" class="w-100 h-100" style="object-fit: cover;">
                            </div>
                            <p class="text-muted small">Bác sĩ: {{ $item->user->fullname ?? 'Không có tên' }}</p>
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
                <form method="POST" action="{{ route('lich.update',$item->schedule_id) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-info text-white">

                        <h5 class="modal-title" id="capNhatLichLamViecLabel-{{ $item->schedule_id }}">
                            <i class="bi bi-floppy2-fill text-white p-2"></i>
                            Cập Nhật Lịch Làm Việc
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-4">
                            <div class="col-12">
                                <label for="doctorDataList-{{ $item->schedule_id }}" class="form-label fw-bold">Chọn
                                    bác sĩ</label>
                                <input class="form-control" list="datalistOptions"
                                    id="doctorDataList-{{ $item->schedule_id }}" placeholder="Gõ để tìm kiếm..." name="ten_bac_si"
                                    value="{{ $item->user->fullname ?? 'Không có tên' }}" readonly>
                            </div>

                            <div class="col-12">
                                <label for="dateTimePicker-{{ $item->schedule_id }}" class="form-label fw-bold">Chọn
                                    ngày</label>
                                <input type="date" class="form-control" id="dateTimePicker-{{ $item->schedule_id }}" name="date"
                                    value="{{ $item->date }}" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold d-block mb-2">Chọn ca làm việc</label>
                                <div class="d-flex flex-wrap gap-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="caLamViec"
                                            id="ca1-{{ $item->schedule_id }}" value="ca1"
                                            {{ $item->schedule_time_id == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ca1-{{ $item->schedule_id }}">Sáng</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="caLamViec"
                                            id="ca2-{{ $item->schedule_id }}" value="ca2"
                                            {{ $item->schedule_time_id == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="ca2-{{ $item->schedule_id }}">Chiều</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="caLamViec"
                                            id="ca3-{{ $item->schedule_id }}" value="ca3"
                                            {{ $item->schedule_time_id == 3 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ca3-{{ $item->schedule_id }}">Cả
                                            ngày</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="status-{{ $item->schedule_id }}" class="form-label fw-bold">Tình
                                    trạng</label>

                                <select class="form-select" aria-label="Tình trạng"
                                    id="status-{{ $item->schedule_id }}" name="status">

                                    <option value="Đã duyệt" {{ $item->status == 'Đã duyệt' ? 'selected' : '' }}>
                                        Đã duyệt
                                    </option>

                                    <option value="Chờ duyệt" {{ $item->status == 'Chờ duyệt' ? 'selected' : '' }}>
                                        Chờ duyệt
                                    </option>

                                    <option value="Đã hủy" {{ $item->status == 'Đã hủy' ? 'selected' : '' }}>
                                        Đã hủy
                                    </option>

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

@foreach ($schedule as $item)
    <div class="modal fade" id="deleteLichLamViecModal-{{ $item->schedule_id }}" tabindex="-1"
        aria-labelledby="deleteLichLamViecModalLabel" aria-hidden="true">
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
                    <form method="POST" action="{{ route('lich.destroy', $item->schedule_id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Xóa</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

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
                <form action="{{ route('lich.store') }}" method="POST" id="formThemLich">
                    @csrf
                    <div class="row g-4">
                        <div class="col-12">
                            <label for="doctorDataList" class="form-label fw-bold">Chọn bác sĩ</label>
                            <input class="form-control" list="datalistOptions" id="doctorDataList"
                                placeholder="Gõ để tìm kiếm..." name="ten_bac_si" required>
                            <datalist id="datalistOptions">
                                <option value="Nguyễn Thúy Vy"></option>
                                <option value="Đỗ Thành Nhân"></option>
                                <option value="Ngô Minh Quý"></option>
                                <option value="Nguyễn Cường Đại"></option>
                                <option value="La Chí Thành"></option>
                            </datalist>
                        </div>

                        <div class="col-12">
                            <label for="dateTimePicker" class="form-label fw-bold">Chọn ngày</label>
                            <input type="date" class="form-control" id="dateTimePicker" name="date">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold d-block mb-2">Chọn ca làm việc</label>
                            <div class="d-block">
                                <div class="form-check d-block  pb-2">
                                    <input class="form-check-input" type="radio" name="caLamViec" id="ca1"
                                        value="ca1" checked>
                                    <label class="form-check-label" for="ca1">Sáng(8:00 - 11:00)</label>
                                </div>
                                <div class="form-check d-block  pb-2">
                                    <input class="form-check-input" type="radio" name="caLamViec" id="ca2"
                                        value="ca2">
                                    <label class="form-check-label" for="ca2">Chiều(13:00 - 17:00)</label>
                                </div>
                                <div class="form-check d-block  pb-2">
                                    <input class="form-check-input" type="radio" name="caLamViec" id="ca3"
                                        value="ca3">
                                    <label class="form-check-label" for="ca3">Cả ngày(8:00 - 17:00)</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="status" class="form-label fw-bold">Tình trạng</label>
                            <select class="form-select" aria-label="Tình trạng" id="status" name="status">
                                <option value="Đã duyệt">Đã duyệt</option>
                                <option value="Chờ duyệt" selected>Chờ duyệt</option>
                                <option value="Đã hủy">Đã hủy</option>
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

{{-- Modal Xóa Nhiều --}}
<div class="modal fade" id="modalXoaNhieu" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Xác nhận xóa</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa <b id="countDisplay">0</b> lịch làm việc đã chọn không?</p>
                <p class="text-danger small">Hành động này không thể hoàn tác!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                
                
                <form id="formXoaNhieu" action="{{ route('lich.deleteMany') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    
                    <input type="hidden" name="ids" id="idsToDelete">
                    <button type="submit" class="btn btn-danger">Đồng ý Xóa</button>
                </form>
            </div>
        </div>
    </div>
</div>