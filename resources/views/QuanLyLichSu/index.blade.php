<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <title>Lịch Sử</title>
</head>
@include('QuanLyLichSu.modal')

<body class="bg-light">
    @include('component.header')
    <div class="container mt-5">
        @if (session('success') || session('add_success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <strong>Thành công!</strong> {{ session('success') ?? session('add_success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Rất tiếc!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>Vui lòng kiểm tra lại dữ liệu:</strong>
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="d-flex align-items-center mb-3 justify-content-between">
            <h2 class="m-0" style="font-family:'Times New Roman', Times, serif;">
                🦷 QUẢN LÝ LỊCH SỬ KHÁM
            </h2>
            <div id="currentTime" class=" me-3 text-secondary fw-semibold" style="font-size: 16px;"></div>
        </div>
        <div class="card shadow-sm mb-4 mt-4">
            <div class="card-body">
                <div class="fw-bold mb-2 ml-2 text-primary">Tìm kiếm</div>
                <form class="row g-2" method="GET" action="{{ route('lichsu.index') }}">
                    <div class="col-md-4">
                        <div class="position-relative">
                            <input type="text" id="searchName" class="form-control" name="search_name"
                                placeholder="Tìm theo tên...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input class="form-control" type="date" name="search_date">
                    </div>
                    <div class="col-md-3">
                        <select name="search_service" class="form-select">
                            <option value="">Tất cả dịch vụ</option>
                            @foreach($services as $item)
                            <option value="{{ $item->service_id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary w-100">Tìm kiếm</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm mb-5">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="text-primary mb-0 fw-bold">Danh sách lịch sử khám</h5>
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addHistoryModal">
                    + Thêm mới
                </button>
            </div>

            <div class="table-responsive ">
                <table id="historyTable" class="table table-striped table-hover align-middle mb-0 text-center">
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
                            <td class="customer-name">{{ $item->customer->fullname }}</td>
                            <td>{{ $item->user->fullname ?? 'Không có' }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}</td>

                            <td class="text-center">
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
                                    data-bs-target="#viewHistoryModal-{{ $item->history_id }}">Xem</button>
                                <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal"
                                    data-bs-target="#editHistoryModal-{{ $item->history_id }}">Sửa</button>
                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteHistoryModal-{{ $item->history_id }}">Xóa</button>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById("searchName");
        const tableRows = document.querySelectorAll("#historyTable tbody tr");

        searchInput.addEventListener("keyup", function () {
            let keyword = this.value.toLowerCase();

            tableRows.forEach(row => {
                let name = row.querySelector(".customer-name").textContent.toLowerCase();

                if (name.includes(keyword)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });
    });
</script>