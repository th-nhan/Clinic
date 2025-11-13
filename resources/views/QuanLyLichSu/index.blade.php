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
                <div class="fw-bold mb-2 ml-2 text-primary">Tìm kiếm</div>
                <form class="row g-2 ">
                    <div class="col-md-4">
                        <input class="form-control" type="text" placeholder="Nhập tên khách hàng..">
                    </div>
                    <div class="col-md-3">
                        <input class="form-control" type="date">
                    </div>
                    <div class="col-md-3">
                        <select name="" id="" class="form-select">
                            <option value="">Tất cả dịch vụ</option>
                                @foreach($services as $item)
                                    <option value="">
                                        {{ $item->name ?? 'Không có tên' }}
                                    </option>
                            @endforeach
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
                <h5 class="text-primary mb-0 fw-bold">Danh sách lịch sử khám</h5>
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addHistoryModal">
                    + Thêm mới
                </button>
            </div>

            <div class="table-responsive ">
                <table class="table table-striped table-hover align-middle text-center mb-0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Khách hàng</th>
                            <th>Bác sĩ</th>
                            <th>Ngày khám</th>
                            <th>Dịch vụ</th>
                            <th>Tổng tiền</th>
                            <th>Hóa đơn</th>
                            <th>Giờ hẹn</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @foreach($histories as $item)
                        <tr>
                            <td>{{ $item->history_id }}</td>
                            <td>{{ $item->customer->fullname ?? 'Không có' }}</td>
                            <td>{{ $item->user->fullname ?? 'Không có' }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}</td>

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
                                {{ $item->time ?
                                \Carbon\Carbon::parse($item->time)->format('h:s') : 'Chưa có' }}
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                                    data-bs-target="#viewHistoryModal-{{ $item->history_id }}" data-id="{{ $item->id }}">Xem</button>
                                <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal"
                                    data-bs-target="#editHistoryModal" data-id="{{ $item->id }}">Sửa</button>
                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteHistoryModal" data-id="{{ $item->id }}">Xóa</button>
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