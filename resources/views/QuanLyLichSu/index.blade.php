<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Quản Lý Lịch Sử Khám</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            /* Sử dụng font hiện đại hơn Times New Roman */
        }

        .header-title {
            font-family: 'Times New Roman', Times, serif;
            font-weight: 700;
        }

        .card-header-custom {
            background-color: #f8f9fa;
            /* Màu nền nhẹ cho header của card */
            border-bottom: 1px solid #e9ecef;
        }

        .btn-action {
            margin: 0 2px;
            font-size: 0.8rem;
        }

        #customerSuggest {
            max-height: 300px;
            overflow-y: auto;
            border-radius: 0 0 0.5rem 0.5rem;
            border-top: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        #customerSuggest .list-group-item:hover {
            background-color: #e9ecef;
            cursor: pointer;
        }
    </style>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
@include('QuanLyLichSu.modal.history')

<body class="bg-light">
    @include('component.header')
    <div class="container mt-4">
        @if (session('success') || session('add_success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <strong>Thành công!</strong> {{ session('success') ?? session('add_success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Rất tiếc!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-warning alert-dismissible fade show shadow-sm border-0" role="alert">
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
        <div class="d-flex align-items-center mb-4 justify-content-between border-bottom pb-2">
            <h1 class=" header-title">
                QUẢN LÝ LỊCH SỬ KHÁM
            </h1>
            <div id="currentTime" class="text-secondary fw-semibold" style="font-size: 1rem;"></div>
        </div>
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body position-relative p-4">
                <h5 class="text-primary fw-bold mb-3 d-flex align-items-center">
                    <i class="bi bi-search me-2"></i> Tìm kiếm Khách hàng
                </h5>

                <div class="input-group input-group-lg border rounded-3 overflow-hidden">
                    <span class="input-group-text bg-primary text-white border-0">
                        <i class="bi bi-person-lines-fill"></i>
                    </span>
                    <input type="text" id="searchName" class="form-control border-0 ps-3"
                        placeholder="Nhập tên khách hàng hoặc số điện thoại..." aria-label="Tìm kiếm khách hàng">
                </div>

                <ul id="customerSuggest" class="" style="z-index:1000; display:none; top: calc(3rem + 50px);"> </ul>
            </div>
        </div>
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <h5 class="text-primary fw-bold mb-3 d-flex align-items-center">
                    <i class="bi bi-funnel-fill me-2"></i> Bộ lọc Lịch sử
                </h5>
                <form class="row gy-3 gx-4" method="GET" action="{{ route('lichsu.index') }}">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Ngày khám</label>
                        <input class=" form-control form-control" type="date" name="search_date"
                            value="{{ request('search_date') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold ">Dịch vụ</label>
                        <select name="search_service" class="form-select form-select">
                            <option value="">Tất cả dịch vụ</option>
                            @foreach($services as $item)
                            <option value="{{ $item->service_id }}" {{ request('search_service')==$item->service_id ?
                                'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-muted">Trạng thái hóa đơn</label>
                        <select name="search_status" class="form-select form-select">
                            <option value="">Tất cả trạng thái</option>
                            <option value="paid" {{ request('search_status')=='paid' ? 'selected' : '' }}>Đã thanh toán
                            </option>
                            <option value="unpaid" {{ request('search_status')=='unpaid' ? 'selected' : '' }}>Chưa thanh
                                toán</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <div class="w-100 d-flex gap-2">
                            <button class="btn btn-primary btn w-50 d-flex align-items-center justify-content-center">
                                <i class="bi bi-funnel me-1"></i> Lọc
                            </button>
                            <a href="{{ route('lichsu.index') }}"
                                class="btn btn-secondary btn w-50 d-flex align-items-center justify-content-center">
                                <i class="bi bi-arrow-repeat me-1"></i> Reset
                            </a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <div class="card shadow-lg mb-5 border-0">
            <div class="card-header card-header-custom d-flex justify-content-between align-items-center p-3">
                <h5 class="text-dark fw-bold m-0 d-flex align-items-center">
                    <i class="fas fa-list-alt me-2 text-primary"></i> Danh sách lịch sử khám
                </h5>
                <button class="btn btn-success btn-sm fw-bold d-flex align-items-center" data-bs-toggle="modal"
                    data-bs-target="#addHistoryModal">
                    <i class="fas fa-plus-circle me-1"></i> Thêm mới
                </button>
            </div>

            <div class="table-responsive">
                <table id="historyTable" class="table table-striped table-hover align-middle mb-0 text-center">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Khách hàng</th>
                            <th scope="col">Bác sĩ</th>
                            <th scope="col">Ngày khám</th>
                            <th scope="col">Dịch vụ</th>
                            <th scope="col">Tổng tiền</th>
                            <th scope="col">Hóa đơn</th>
                            <th scope="col">Giờ hẹn</th>
                            <th scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @foreach($histories as $item)
                        <tr data-customer-id="{{ $item->customer->customer_id }}"
                            data-customer-name="{{ $item->customer->fullname }}"
                            data-customer-phone="{{ $item->customer->contact_number }}">
                            <td>{{ $item->history_id }}</td>
                            <td class="customer-name">{{ $item->customer->fullname }}</td>
                            <td>{{ $item->user->fullname ?? 'Không có' }}</td>
                            <td class="customer-phone" style="display:none;">
                                {{ $item->customer->contact_number }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}</td>
                            <td>
                                <ul class="mb-0">
                                    @foreach($item->historyDetails as $d)
                                    <li>{{ $d->service->name }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="fw-bold text-danger">{{ number_format($item->invoice->total_price ?? 0) }} đ</td>
                            <td>
                                @if(optional($item->invoice)->status == 'paid')
                                <span class="badge bg-success">Đã thanh toán</span>
                                @else
                                <span class="badge bg-warning text-dark">Chưa thanh toán</span>
                                @endif
                            </td>
                            <td>{{ $item->time }}</td>

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
            {{-- <div class="card-footer bg-white border-top">
                {{ $histories->links() }}
            </div> --}}
        </div>
    </div>
</body>

</html>

<script>
    // Hàm cập nhật thời gian
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
        document.getElementById('currentTime').innerHTML = '<i class="far fa-calendar-alt me-1"></i> ' + timenow.toLocaleDateString('vi-VN', options);
    }
    updateTime();
    setInterval(updateTime, 1000);

    // Lọc dữ liệu trong bảng theo tên/sđt khi gõ vào ô searchName
    document.addEventListener("DOMContentLoaded", function () {
        const tableSearchInput = document.getElementById("searchName");
        const tableRows = document.querySelectorAll("#historyTable tbody tr");

        tableSearchInput.addEventListener("input", function () {
            const keyword = this.value.toLowerCase().trim();
            if (keyword === "") {
                tableRows.forEach(row => {
                    row.style.display = "";
                });
                return;
            }
            tableRows.forEach(row => {
                const name = row.dataset.customerName.toLowerCase();
                const phone = row.dataset.customerPhone;

                if (!keyword || name.includes(keyword) || phone.includes(keyword)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });
    });

    // Hàm Suggestion Box và Mở Modal Tổng quan
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById("searchName");
        const suggestBox = document.getElementById("customerSuggest");

        let debounceTimer = null;

        searchInput.addEventListener("input", function () {
            const keyword = this.value.trim();

            clearTimeout(debounceTimer);

            if (!keyword || keyword.length < 2) { // Tối ưu: chỉ tìm kiếm khi có ít nhất 2 ký tự
                suggestBox.style.display = "none";
                suggestBox.innerHTML = "";
                return;
            }

            debounceTimer = setTimeout(async () => {
                try {
                    // Cải tiến: Thêm loading state
                    suggestBox.innerHTML = '<li class="list-group-item text-center text-info"><i class="fas fa-spinner fa-spin me-2"></i> Đang tìm kiếm...</li>';
                    suggestBox.style.display = "block";

                    const res = await fetch(`/customers/search?q=${keyword}`);
                    if (!res.ok) throw new Error('Network response was not ok');
                    const customers = await res.json();

                    suggestBox.innerHTML = "";

                    if (customers.length === 0) {
                        suggestBox.innerHTML = '<li class="list-group-item text-muted text-center">Không tìm thấy khách hàng nào.</li>';
                        return;
                    }

                    // Lọc các khách hàng duy nhất dựa trên Tên và SĐT
                    const uniqueCustomers = [];
                    const seen = new Set();

                    customers.forEach(c => {
                        const key = c.fullname + '|' + c.contact_number;
                        if (!seen.has(key)) {
                            seen.add(key);
                            uniqueCustomers.push(c);
                        }
                    });

                    if (uniqueCustomers.length === 0) {
                        suggestBox.innerHTML = '<li class="list-group-item text-muted text-center">Không tìm thấy khách hàng nào.</li>';
                        return;
                    }

                    // Duyệt qua các khách hàng đã lọc duy nhất
                    uniqueCustomers.forEach(c => {
                        const li = document.createElement("li");
                        li.className = "list-group-item list-group-item-action py-2";

                        // Highlight từ khóa tìm kiếm
                        const highlightedName = c.fullname.replace(new RegExp(keyword, 'gi'), match => `<b>${match}</b>`);
                        const highlightedPhone = c.contact_number.replace(new RegExp(keyword, 'gi'), match => `<b>${match}</b>`);

                        li.innerHTML = `
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong class="text-primary">${highlightedName}</strong><br>
                                    <small class="text-muted">${highlightedPhone}</small>
                                </div>
                            </div>
                        `;

                        li.onclick = () => {
                            searchInput.value = c.fullname; // Giữ lại tên khách hàng đã chọn trên ô input
                            suggestBox.style.display = "none";
                            // TRUYỀN TÊN VÀ SỐ ĐIỆN THOẠI
                            openCustomerModal(c.fullname, c.contact_number);
                        };

                        suggestBox.appendChild(li);
                    });

                } catch (error) {
                    console.error("Lỗi khi tìm kiếm khách hàng:", error);
                    suggestBox.innerHTML = '<li class="list-group-item text-danger text-center">Lỗi tải dữ liệu.</li>';
                }
            }, 300); // debounce time
        });

        // Ẩn suggest box khi click ra ngoài
        document.addEventListener('click', function (e) {
            if (!searchInput.contains(e.target) && !suggestBox.contains(e.target)) {
                suggestBox.style.display = 'none';
            }
        });
    });

    // ==========================================================
    // 1. HÀM TEMPLATE HTML (Tách biệt logic hiển thị)
    // ==========================================================
    function createCustomerOverviewHtml(data, historiesHtml) {
        // Tách phần Biểu đồ ra một div riêng biệt
        const financialChartHtml = `
        <div id="financialChartContainer" style="height: 200px;">
            <canvas id="debtPaidChart"></canvas>
        </div>
    `;

        return `
        <div class="mb-4 p-3 border rounded shadow-sm bg-light">
            <div class="row">
                <div class="col-md-3">
                    <p class="mb-1 fw-bold text-dark"><i class="fas fa-user me-2 text-primary"></i>Tên khách hàng:</p>
                    <p class="fs-5 text-primary ms-4">${data.name}</p>
                </div>
                <div class="col-md-3">
                    <p class="mb-1 fw-bold text-dark"><i class="fas fa-phone me-2 text-primary"></i>Số điện thoại:</p>
                    <p class="fs-5 text-primary ms-4">${data.phone}</p>
                </div>
                </div>
        </div>

        <h5 class="fw-bold text-danger mb-3"><i class="fas fa-exclamation-triangle me-2"></i>Thông Tin Y Tế Quan Trọng</h5>
        <div class="alert alert-warning border-0 shadow-sm p-3">
            <p class="mb-1 text-dark fw-semibold">Chẩn đoán gần nhất:</p>
            <p class="ms-3 text-danger">${data.last_diagnosis || 'Chưa có thông tin'}</p>
        </div>

        <h5 class="fw-bold text-primary mt-4 mb-3"><i class="fas fa-money-check-alt me-2"></i>Tổng Quan Tài Chính</h5>
        <div class="row p-3 border rounded mb-4 align-items-center">
            <div class="col-md-4 border-end">
                <p class="mb-1 text-muted">Tổng tiền đã chi:</p>
                <p class="fs-5 fw-bold text-success">${(data.total_paid || 0).toLocaleString('vi-VN')} đ</p>
                <p class="mb-1 text-muted">Công nợ/Chưa thanh toán:</p>
                <p class="fs-5 fw-bold text-danger">${(data.total_debt || 0).toLocaleString('vi-VN')} đ</p>
            </div>
            <div class="col-md-8">
                ${financialChartHtml}
            </div>
        </div>

        <h5 class="fw-bold text-primary mb-3"><i class="bi bi-calendar-check me-2"></i>Chi tiết Lịch sử khám (${data.histories.length} lần)</h5>
        ${historiesHtml}
    `;
    }

    // ==========================================================
    // 2. HÀM VẼ BIỂU ĐỒ (Sử dụng Chart.js)
    // ==========================================================
    function drawFinancialChart(paid, debt) {
        const ctx = document.getElementById('debtPaidChart');

        if (!ctx) return;

        // Nếu cả hai đều bằng 0, không vẽ biểu đồ
        if (paid === 0 && debt === 0) {
            // Tùy chọn: Thay thế canvas bằng thông báo
            document.getElementById('financialChartContainer').innerHTML = '<div class="alert alert-light text-center m-0">Không có dữ liệu giao dịch để lập biểu đồ.</div>';
            return;
        }

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Đã Thanh toán', 'Công nợ'],
                datasets: [{
                    label: 'Tổng tiền',
                    data: [paid, debt],
                    backgroundColor: [
                        'rgba(40, 167, 69, 0.8)', // Xanh lá (Success)
                        'rgba(220, 53, 69, 0.8)'   // Đỏ (Danger)
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: {
                                size: 14
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: 'Tỷ lệ Thanh toán và Công nợ',
                        font: {
                            size: 16
                        }
                    }
                }
            }
        });
    }

    // ==========================================================
    // 3. HÀM MỞ MODAL CHÍNH (Kết hợp API và Rendering)
    // ==========================================================
    function openCustomerModal(customerName, customerPhone) {
        const modalElement = document.getElementById('customerOverviewModal');
        const modal = new bootstrap.Modal(modalElement);
        const content = document.getElementById('customerOverviewContent');

        content.innerHTML = `
        <div class="text-center py-5 text-muted">
            <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
            <p class="mt-2 text-primary">Đang tải dữ liệu tổng quan cho ${customerName}...</p>
        </div>
    `;
        modal.show();

        const url = `/customers/overview?name=${encodeURIComponent(customerName)}&phone=${encodeURIComponent(customerPhone)}`;

        fetch(url)
            .then(res => {
                if (!res.ok) {
                    throw new Error('Lỗi khi tải dữ liệu tổng quan khách hàng');
                }
                return res.json();
            })
            .then(data => {
                // 1. Tạo HTML cho lịch sử khám (giữ nguyên logic bảng)
                let historiesHtml = '';
                if (data.histories.length > 0) {
                    historiesHtml = `
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm table-hover align-middle mb-0 text-center">
                            <thead class="bg-light">
                                <tr>
                                    <th>Ngày khám</th>
                                    <th>Giờ hẹn</th>
                                    <th>Bác sĩ</th>
                                    <th>Dịch vụ</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Ghi chú</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${data.histories.map(h => `
                                    <tr>
                                        <td>${h.date}</td>
                                        <td>${h.time}</td>
                                        <td>${h.doctor}</td>
                                        <td class="text-start">
                                            <ul class="mb-0 ps-3 list-unstyled">
                                                ${h.services.map(s => `<li class="d-flex align-items-center">${s}</li>`).join('')}
                                            </ul>
                                        </td>
                                        <td class="fw-bold text-danger">${h.total} đ</td>
                                        <td>
                                            <span class="badge ${h.status === 'paid' ? 'bg-success' : 'bg-warning text-dark'} py-2">
                                                ${h.status === 'paid' ? '<i class="fas fa-check"></i> Đã thanh toán' : '<i class="fas fa-clock"></i> Chưa thanh toán'}
                                            </span>
                                        </td>
                                        <td class="text-start text-muted">${h.noted || 'Không có ghi chú'}</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    </div>
                `;
                } else {
                    historiesHtml = '<div class="alert alert-info text-center"><i class="fas fa-smile-beam me-2"></i>Khách hàng chưa có lịch sử khám nào.</div>';
                }

                // 2. Sử dụng hàm template để render toàn bộ nội dung
                const html = createCustomerOverviewHtml(data, historiesHtml);

                content.innerHTML = html;

                // 3. Vẽ biểu đồ sau khi HTML đã được render vào DOM
                drawFinancialChart(data.total_paid || 0, data.total_debt || 0);

            })
            .catch(error => {
                console.error(error);
                content.innerHTML = '<div class="alert alert-danger text-center"><i class="fas fa-exclamation-triangle me-2"></i>Không thể tải dữ liệu. Vui lòng thử lại.</div>';
            });
    }

</script>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>🦷 Quản Lý Lịch Sử Khám Nha Khoa</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
</head>

<body>
    <div class="modal fade" id="customerOverviewModal" tabindex="-1" aria-labelledby="customerOverviewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="customerOverviewModalLabel"><i class="fas fa-user-circle me-2"></i> Tổng
                        quan khách hàng</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body" id="customerOverviewContent">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>