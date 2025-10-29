<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <title>Document</title>
</head>
@include('QuanLyLichSu.modal')

<body class="bg-light">
    @include('component.header')
    <div class="container mt-5">
        <div class="d-flex align-items-center mb-3 justify-content-between">
            <h2 class="m-0" style="font-family:'Times New Roman', Times, serif;">
                🦷 QUẢN LÝ LỊCH SỬ KHÁM
            </h2>
            <div id="currentTime" class=" me-3 text-secondary fw-semibold" style="font-size: 16px;"></div>
        </div>
        <div class="card shadow-sm mb-4 mt-4">
            <div class="card-body">
                <form class="row g-2 ">
                    <div class="col-md-4">
                        <input class="form-control" type="text" placeholder="Tìm kiếm lịch sử..">
                    </div>
                    <div class="col-md-3">
                        <input class="form-control" type="date">
                    </div>
                    <div class="col-md-3">
                        <select name="" id="" class="form-select">
                            <option>Tất cả dịch vụ</option>
                            <option>Trám răng</option>
                            <option>Tẩy trắng</option>
                            <option>Nhổ răng</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary w-100">Tìm kiếm</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="text-primary mb-0">Danh sách lịch sử khám</h5>
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addHistoryModal">
                    + Thêm mới
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle text-center mb-0">
                    <tr>
                        <th>#</th>
                        <th>Khách hàng</th>
                        <th>Bác sĩ</th>
                        <th>Ngày khám</th>
                        <th>Dịch vụ</th>
                        <th>Tổng tiền</th>
                        <th>Hóa đơn</th>
                        <th>Lịch hẹn</th>
                        <th>Thao tác</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Nguyễn Văn A</td>
                        <td>BS. Trần Minh</td>
                        <td>2025-10-25</td>
                        <td>
                            <ul class="text-start mb-0">
                                <li>Trám răng sâu</li>
                                <li>Tẩy trắng răng</li>
                            </ul>
                        </td>
                        <td class="text-success fw-bold">650,000đ</td>
                        <td><span class="bg-success badge">Đã thanh toán</span></td>
                        <td><span class="badge bg-info">📅 2025-11-05</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                                data-bs-target="#viewHistoryModal">Xem</button>
                            <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal"
                                data-bs-target="#editHistoryModal">
                                Sửa
                            </button>
                            <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#deleteHistoryModal">
                                Xóa
                            </button>
                        </td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>Nguyễn Văn A</td>
                        <td>BS. Trần Minh</td>
                        <td>2025-10-25</td>
                        <td>
                            <ul class="text-start mb-0">
                                <li>Trám răng sâu</li>
                                <li>Tẩy trắng răng</li>
                            </ul>
                        </td>
                        <td class="text-success fw-bold">650,000đ</td>
                        <td><span class="bg-success badge">Đã thanh toán</span></td>
                        <td><span class="badge bg-info">📅 2025-11-05</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-info">Xem</button>
                            <button class="btn btn-sm btn-outline-warning">Sửa</button>
                            <button class="btn btn-outline-danger btn-sm">Xóa</button>
                        </td>
                    </tr>

                    <tr>
                        <td>3</td>
                        <td>Nguyễn Văn A</td>
                        <td>BS. Trần Minh</td>
                        <td>2025-10-25</td>
                        <td>
                            <ul class="text-start mb-0">
                                <li>Trám răng sâu</li>
                                <li>Tẩy trắng răng</li>
                            </ul>
                        </td>
                        <td class="text-success fw-bold">650,000đ</td>
                        <td><span class="bg-success badge">Đã thanh toán</span></td>
                        <td><span class="badge bg-info">📅 2025-11-05</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-info">Xem</button>
                            <button class="btn btn-sm btn-outline-warning">Sửa</button>
                            <button class="btn btn-outline-danger btn-sm">Xóa</button>
                        </td>
                    </tr>

                    <tr>
                        <td>4</td>
                        <td>Nguyễn Văn A</td>
                        <td>BS. Trần Minh</td>
                        <td>2025-10-25</td>
                        <td>
                            <ul class="text-start mb-0">
                                <li>Trám răng sâu</li>
                                <li>Tẩy trắng răng</li>
                            </ul>
                        </td>
                        <td class="text-success fw-bold">650,000đ</td>
                        <td><span class="bg-light text-muted badge">Chưa thanh toán</span></td>
                        <td><span class="badge bg-light text-muted">Chưa gặp</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-info">Xem</button>
                            <button class="btn btn-sm btn-outline-warning">Sửa</button>
                            <button class="btn btn-outline-danger btn-sm">Xóa</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>

</html>

<!-- Time  -->
<script>
    function updateTime() {
        const timenow = new Date();
        const options = {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        }
        document.getElementById('currentTime').innerHTML = timenow.toLocaleDateString('vi-VN', options);
    }
    updateTime();
    setInterval(updateTime, 1000);
</script>