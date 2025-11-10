{{-- Modal xem chi tiết bác sĩ --}}
<div class="modal fade" id="doctorDetailModal" tabindex="-1" aria-labelledby="doctorDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="doctorDetailModalLabel">Chi Tiết Lịch Làm Việc</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div class="row g-4">
                    <div class="col-12 col-md-7">
                        <p><strong>ID:</strong> <span id="detail-id"></span></p>
                        <p><strong>Tên bác sĩ:</strong> <span id="detail-ten"></span></p>
                        <p><strong>Ngày làm việc:</strong> <span id="detail-ngay"></span></p>
                        <p><strong>Ca làm việc:</strong> <span id="detail-ca"></span></p>
                        <p><strong>Email:</strong> <span id="detailemail"></span></p>
                        <p><strong>Số điện thoại:</strong> <span id="detailsdt"></span></p>
                        <p><strong>Tình trạng:</strong> <span id="detail-trangthai"></span></p>
                        <p><strong>Ghi chú:</strong> <span id="detail-ghichu"></span></p>
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

{{-- Form Cập nhật lịch làm việc  --}}
<div class="modal fade" id="capNhatLichLamViec" tabindex="-1" aria-labelledby="capNhatLichLamViecLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h5 class="modal-title" id="capNhatLichLamViecLabel">
                        <i class="bi bi-floppy2-fill text-primary p-2"></i>
                        Cập Nhật Lịch Làm Việc
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-md-6 col-lg-3">
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

                        <div class="col-md-6 col-lg-3">
                            <label for="dateTimePicker" class="form-label fw-bold">Chọn ngày</label>
                            <input type="date" class="form-control" id="dateTimePicker">
                        </div>

                        <div class="col-md-12 col-lg-3">
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

                        <div class="col-md-12 col-lg-3">
                            <label for="status" class="form-label fw-bold">Tình trạng</label>
                            <select class="form-select" aria-label="Tình trạng" id="status">
                                <option value="1">Đã duyệt</option>
                                <option value="2" selected>Chờ duyệt</option>
                                <option value="3">Đã hủy</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <label for="floatingTextarea" class="form-label fw-bold">Ghi chú</label>
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Nhập ghi chú tại đây" id="floatingTextarea" style="height: 100px"></textarea>
                                <label for="floatingTextarea">Nhập ghi chú tại đây</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-success">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>

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