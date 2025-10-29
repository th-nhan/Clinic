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
                            <input type="text" name="bacsi" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Ngày khám</label>
                            <input type="date" name="ngaykham" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Dịch vụ</label>
                            <select name="dichvu" class="form-select">
                                <option>Trám răng</option>
                                <option>Tẩy trắng</option>
                                <option>Nhổ răng</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tổng tiền</label>
                            <input type="number" name="tongtien" class="form-control" placeholder="VD: 650000" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Ngày hẹn</label>
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




<!-- modal details  -->
<div class="modal fade" id="viewHistoryModal" tabindex="-1" aria-labelledby="viewHistoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-dark">
                <h5 class="modal-title fw-bold">Chi tiết lịch sử khám</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4 align-items-center mb-3">
                    <div class="col-md-8">
                        <div class="mb-2"><span class="fw-bold">Tên khách hàng:</span> Nguyễn Văn A</div>
                        <div class="mb-2"><span class="fw-bold">Bác sĩ phụ trách:</span> BS. Trần Minh</div>
                        <div class="mb-2"><span class="fw-bold">Ngày khám:</span> 2025-10-25</div>
                        <div class="mb-2">
                            <span class="fw-bold">Dịch vụ thực hiện:</span>
                            <ul class="mb-0 ps-3">
                                <li>Trám răng sâu</li>
                                <li>Tẩy trắng răng</li>
                            </ul>
                        </div>
                        <div class="mb-2"><span class="fw-bold">Tổng tiền:</span>
                            <span class="text-success fw-semibold">650,000đ</span>
                        </div>
                        <div class="mb-2"><span class="fw-bold">Trạng thái hóa đơn:</span>
                            <span class="badge bg-success">Đã thanh toán</span>
                        </div>
                        <div><span class="fw-bold">Lịch hẹn tiếp theo:</span>
                            <span class="badge bg-info text-dark">2025-11-05</span>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <h6 class="fw-bold">Bác sĩ phụ trách</h6>
                        <div class="d-flex flex-column align-items-center justify-content-center">
                            <img src="https://monozy.net/wp-content/uploads/2023/12/chup-anh-profile-bac-si-phong-kham-657d4478271fd.jpg"
                                alt="BS. Trần Minh" class="rounded-circle border-3 border-secondary" width="150"
                                height="150">
                            <p class="mb-0 fw-semibold mt-2">BS. Trần Minh</p>
                            <p class="text-muted small mt-2">Chuyên khoa: Phục hình răng</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</div>