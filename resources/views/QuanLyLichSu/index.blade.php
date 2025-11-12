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
                    <tbody>
                        @foreach($histories as $item)
                        <tr>
                            <td>{{ $item->history_id }}</td>
                            <td>{{ $item->customer->fullname ?? 'Không có' }}</td>
                            <td>{{ $item->user->fullname ?? 'Không có' }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>

                            <td class="text-start">
                                <ul class="mb-0">
                                    @foreach($item->historyDetails as $detail)
                                    <li>{{ $detail->service->name ?? 'Không có tên' }}</li>
                                    @endforeach
                                </ul>
                            </td>

                            <td>
                                {{ number_format($item->invoice->total_price ?? 0, 0, ',', '.') }} đ
                            </td>

                            <td>
                                @if(optional($item->invoice)->status == 'paid')
                                <span class="badge bg-success">Đã thanh toán</span>
                                @elseif(optional($item->invoice)->status == 'unpaid')
                                <span class="badge bg-warning text-dark">Chưa thanh toán</span>
                                @else
                                <span class="badge bg-secondary">Không rõ</span>
                                @endif
                            </td>
                            <td>
                                {{ $item->appointment_date ? \Carbon\Carbon::parse($item->appointment_date)->format('d/m/Y') : 'Chưa có' }}
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#viewHistoryModal" data-id="{{ $item->id }}">Xem</button>
                                <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editHistoryModal" data-id="{{ $item->id }}">Sửa</button> 
                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteHistoryModal" data-id="{{ $item->id }}">Xóa</button> 
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
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