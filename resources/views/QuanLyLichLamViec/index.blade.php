<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <title>Quản lý lịch làm việc</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

</head>
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> --}}
@include('QuanLyLichLamViec.modal')
<script src="{{ asset('js/app.js') }}"></script>

<body>
    @include('component.header')

    <div class="mt-3 mb-3 px-3 px-md-5">

        {{-- Bắt lỗi thêm, xóa --}}
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

    </div>

    <div class="container-fluid py-4">
        <div
            class="d-flex flex-column flex-md-row align-items-md-center 
            justify-content-md-between mb-4 px-3 px-md-5">

            <div>
                <h2 class="mb-2 mb-md-0">📅 Quản lý Lịch làm việc</h2>
            </div>

            <div id="currentTime" class="text-secondary fw-semibold text-md-end" style="font-size: 16px;"></div>

        </div>
        <div class="px-3 px-md-5 mb-5">
            <div class="d-flex flex-wrap gap-2 responsive-btn-group-wrapper" id="controlButtons">

                <button type="button" class="btn btn-outline-warning" data-bs-target="#xemLichLamViec"
                    data-bs-toggle="collapse" aria-expanded="false" aria-controls="xemLichLamViec">
                    Xem lịch làm việc</button>
                <button type="button" class="btn btn-outline-secondary" data-bs-target="#timKiemLichLamViec"
                    data-bs-toggle="collapse" aria-expanded="false" aria-controls="timKiemLichLamViec">
                    Tìm kiếm</button>
                @if (auth()->check() && auth()->user()->description === 'Quản trị viên')
                    <button type="button" class="btn btn-outline-primary" data-bs-target="#themLichLamViecModal"
                        data-bs-toggle="modal" aria-expanded="false" aria-controls="themLichLamViecModal">
                        <i class="bi bi-plus-circle"></i> Thêm lịch làm việc
                    </button>

                    <button type="button" class="btn btn-outline-danger" data-bs-target="#xoaLichLamViec"
                        data-bs-toggle="collapse" aria-expanded="false" aria-controls="xoaLichLamViec">
                        Xóa</button>
                @endif
            </div>
        </div>

        <div id="collapseContainer">

            {{-- Form Xem lịch làm việc theo tuần --}}
            <div class="px-3 px-md-5">
                <div class="collapse {{ request()->has('week') || !request()->hasAny(['ten_bac_si', 'filter_type', 'search_date', 'status']) ? 'show' : '' }}"
                    id="xemLichLamViec" data-bs-parent="#collapseContainer">
                    <div class="card shadow-lg mb-4">
                        <div class="card-body p-4">

                            {{-- 1. HEADER & ĐIỀU HƯỚNG --}}
                            <div
                                class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 border-bottom pb-3">
                                <h3 class="card-title m-0 text-primary">
                                    <i class="bi bi-calendar-week me-2"></i> Lịch Theo Tuần
                                </h3>

                                <div class="d-flex align-items-center gap-2 mt-3 mt-md-0 bg-light p-2 rounded">
                                    {{-- Nút Lùi --}}
                                    <a href="{{ route('lich.index', array_merge(request()->all(), ['week' => $weekOffset - 1])) }}"
                                        class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-chevron-left"></i>
                                    </a>

                                    {{-- Hiển thị ngày --}}

                                    <form id="formChonTuan" action="{{ route('lich.index') }}" method="GET"
                                        class="d-inline-block">
                                        <select name="week"
                                            class="form-select form-select-sm fw-bold border-primary text-primary"
                                            style="min-width: 280px; cursor: pointer;"
                                            onchange="document.getElementById('formChonTuan').submit()">

                                            @php
                                                $yearfilled = \Carbon\Carbon::now();
                                                $todayReal = $yearfilled->copy()->startOfWeek();
                                                $startOfYear = $yearfilled->copy()->startOfYear()->startOfWeek();
                                                if ($startOfYear->year < $yearfilled->year) {
                                                    $startOfYear = $startOfYear->addWeek();
                                                }
                                            @endphp

                                            @for ($i = 0; $i < 53; $i++)
                                                @php
                                                    $wStart = $startOfYear->copy()->addWeeks($i);
                                                    $wEnd = $wStart->copy()->endOfWeek();
                                                    $offset = $todayReal->diffInWeeks($wStart, false);
                                                    $label =
                                                        'Tuần ' .
                                                        str_pad($i + 1, 2, '0', STR_PAD_LEFT) .
                                                        ' [Từ ' .
                                                        $wStart->format('d/m/Y') .
                                                        ' -- Đến ' .
                                                        $wEnd->format('d/m/Y') .
                                                        ']';
                                                @endphp

                                                <option value="{{ $offset }}"
                                                    {{ (int) $weekOffset == (int) $offset ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endfor
                                        </select>
                                    </form>
                                    {{-- Nút Tiến --}}
                                    <a href="{{ route('lich.index', array_merge(request()->all(), ['week' => $weekOffset + 1])) }}"
                                        class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-chevron-right"></i>
                                    </a>

                                    {{-- Nút Hôm nay --}}
                                    @if ($weekOffset != 0)
                                        <a href="{{ route('lich.index', request()->except('week')) }}"
                                            class="btn btn-sm btn-secondary ms-2">
                                            Về hôm nay
                                        </a>
                                    @endif
                                </div>
                            </div>


                            <div class="table-responsive">
                                <table class="table table-bordered text-center m-0 align-middle"
                                    style="min-width: 800px;">

                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th class="py-3" style="width: 100px; background-color: #0d6efd;">CA
                                            </th>
                                            @foreach ($weekDates as $date)
                                                <th class="{{ $date->isToday() ? 'bg-warning text-dark' : '' }}">
                                                    <div class="text-uppercase small fw-bold">
                                                        {{ $date->locale('vi')->dayName }}</div>
                                                    <div class="fs-5 fw-bold">{{ $date->format('d/m') }}</div>
                                                </th>
                                            @endforeach
                                        </tr>
                                    </thead>


                                    <tbody>
                                        @php
                                            $shifts = [
                                                1 => ['name' => 'SÁNG', 'time' => '08:00 - 11:00', 'bg' => 'success'],
                                                2 => ['name' => 'CHIỀU', 'time' => '13:00 - 17:00', 'bg' => 'warning'],
                                                3 => [
                                                    'name' => 'CẢ NGÀY',
                                                    'time' => '08:00 - 17:00',
                                                    'bg' => 'primary',
                                                ],
                                            ];
                                        @endphp

                                        @foreach ($shifts as $shiftId => $info)
                                            <tr>

                                                <td class="fw-bold bg-light">
                                                    <div class="text-{{ $info['bg'] }}">{{ $info['name'] }}</div>
                                                    <small class="text-muted"
                                                        style="font-size: 11px">{{ $info['time'] }}</small>
                                                </td>

                                                {{-- Cột Dữ Liệu Các Ngày --}}
                                                @foreach ($weekDates as $dateObj)
                                                    @php
                                                        $dateKey = $dateObj->format('Y-m-d');
                                                        $cellData = $calendarData[$dateKey][$shiftId] ?? [];
                                                    @endphp

                                                    <td class="p-1 align-top"
                                                        style="height: 100px; background-color: #fff;">
                                                        @if (count($cellData) > 0)
                                                            <div class="d-flex flex-column gap-1">
                                                                @foreach ($cellData as $item)
                                                                    {{-- Thẻ Bác sĩ --}}
                                                                    <div class="badge bg-{{ $info['bg'] }} bg-opacity-10 text-dark border border-{{ $info['bg'] }} w-100 text-start p-2 shadow-sm"
                                                                        style="cursor: pointer;"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#chiTietLichLamViec--{{ $item->schedule_id }}">

                                                                        <div class="d-flex align-items-center">

                                                                            <div class="rounded-circle bg-secondary text-white d-flex justify-content-center align-items-center me-2"
                                                                                style="width: 20px; height: 20px; font-size: 10px;">
                                                                                @if (!empty($item->user->avatar))
                                                                                    <img src="{{ $item->user->avatar }}"
                                                                                        alt="avatar"
                                                                                        class="rounded-circle"
                                                                                        style="width: 100%; height: 100%; rounded-circle">
                                                                                @else
                                                                                    <i class="bi bi-person-fill"></i>
                                                                                @endif
                                                                            </div>
                                                                            <div class="text-truncate"
                                                                                style="max-width: 80px;">
                                                                                {{ $item->user->fullname ?? '...' }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>



                        </div>
                    </div>
                </div>
            </div>


            {{-- Form Tìm kiếm lịch làm việc  --}}
            <div class="px-3 px-md-5">
                <div class="collapse {{ request()->hasAny(['ten_bac_si', 'filter_type', 'search_date', 'caLamViec', 'status']) ? 'show' : '' }}"
                    id="timKiemLichLamViec" data-bs-parent="#collapseContainer">
                    <div class="card shadow-lg mb-4">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="card-title mb-4 border-bottom pb-2">
                                <i class="bi bi-search text-primary p-2"></i>
                                Tìm kiếm lịch làm việc
                            </h3>

                            <form action="{{ route('lich.index') }}" method="GET">
                                <div class="row g-4">


                                    <div class="col-md-6 col-lg-4">
                                        <label for="doctorDataList" class="form-label fw-bold">Chọn bác sĩ</label>
                                        <input class="form-control" list="datalistOptions" id="doctorDataList"
                                            placeholder="Gõ để tìm kiếm..." value="{{ request('ten_bac_si') }}"
                                            name="ten_bac_si">
                                        <datalist id="datalistOptions">
                                            @foreach ($doctorList as $doc)
                                                <option value="{{ $doc->fullname }}"></option>
                                            @endforeach
                                        </datalist>
                                    </div>

                                    <div class="col-md-6 col-lg-4">
                                        <label class="form-label fw-bold">Thời gian làm việc</label>

                                        @php $type = request('filter_type', 'date'); @endphp
                                        <input type="hidden" name="filter_type" value="{{ $type }}">
                                        <div class="btn-group w-100 mb-2" role="group">
                                            {{-- Nút Ngày --}}
                                            <a href="{{ route('lich.index', ['filter_type' => 'date']) }}"
                                                class="btn btn-sm {{ $type == 'date' ? 'btn-primary' : 'btn-outline-primary' }}">
                                                Theo Ngày
                                            </a>

                                            {{-- Nút Tháng --}}
                                            <a href="{{ route('lich.index', ['filter_type' => 'month']) }}"
                                                class="btn btn-sm {{ $type == 'month' ? 'btn-primary' : 'btn-outline-primary' }}">
                                                Theo Tháng
                                            </a>

                                            {{-- Nút Năm --}}
                                            <a href="{{ route('lich.index', ['filter_type' => 'year']) }}"
                                                class="btn btn-sm {{ $type == 'year' ? 'btn-primary' : 'btn-outline-primary' }}">
                                                Theo Năm
                                            </a>
                                        </div>


                                        {{-- Trường hợp 1: Ngày --}}
                                        @if ($type == 'date')
                                            <input type="date" class="form-control" name="search_date"
                                                value="{{ request('search_date') }}">
                                        @endif

                                        {{-- Trường hợp 2: Tháng --}}
                                        @if ($type == 'month')
                                            <input type="month" class="form-control" name="search_month"
                                                value="{{ request('search_month') }}">
                                        @endif

                                        {{-- Trường hợp 3: Năm --}}
                                        @if ($type == 'year')
                                            <select class="form-select" name="search_year">
                                                <option value="">Chọn năm</option>
                                                @for ($i = date('Y') + 1; $i >= date('Y') - 6; $i--)
                                                    <option value="{{ $i }}"
                                                        {{ request('search_year') == $i ? 'selected' : '' }}>
                                                        Năm {{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        @endif
                                    </div>
                                    <div class="col-md-12 col-lg-4">
                                        <label class="form-label fw-bold d-block mb-2">Chọn ca làm việc</label>
                                        <div class="d-flex flex-wrap gap-3">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="caLamViec[]"
                                                    id="ca1" value="1"
                                                    {{ in_array('1', request('caLamViec', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="ca1">Sáng</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="caLamViec[]"
                                                    id="ca2" value="2"
                                                    {{ in_array('2', request('caLamViec', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="ca2">Chiều</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="caLamViec[]"
                                                    id="ca3" value="3"
                                                    {{ in_array('3', request('caLamViec', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="ca3">Cả ngày</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-lg-4">
                                        <label for="status" class="form-label fw-bold">Tình trạng</label>
                                        <select class="form-select" aria-label="Tình trạng" id="status"
                                            name="status">
                                            <option value="">-- Tất cả --</option>
                                            <option value="Đã duyệt"
                                                {{ request('status') == 'Đã duyệt' ? 'selected' : '' }}>Đã duyệt
                                            </option>
                                            <option value="Chờ duyệt"
                                                {{ request('status') == 'Chờ duyệt' ? 'selected' : '' }}>Chờ duyệt
                                            </option>
                                            <option value="Đã hủy"
                                                {{ request('status') == 'Đã hủy' ? 'selected' : '' }}>Đã hủy</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mt-5 d-flex justify-content-center gap-4">
                                    <button type="submit" class="btn btn-success btn-lg px-5 shadow-sm">
                                        Tìm kiếm
                                    </button>

                                    <a href="{{ route('lich.index') }}"
                                        class="btn btn-secondary btn-lg px-4 shadow-sm">
                                        <i class="bi bi-arrow-counterclockwise"></i> Xóa lọc
                                    </a>
                                </div>
                            </form>

                            <h3 class="card-title mt-5 border-bottom pb-2">

                                <i class="bi bi-list-columns-reverse text-primary p-2"></i>
                                Danh sách lịch làm việc
                            </h3>


                            <div class="d-flex align-items-center mb-3">
                                <span class="fs-5 fw-bold text-secondary me-2">Kết quả tìm kiếm:</span>
                                <span class="badge rounded-pill bg-danger fs-6 shadow-sm">
                                    {{ $schedule->count() }} trùng khớp
                                </span>
                            </div>

                            <div class="table-responsive mt-5">
                                <table class="table table-striped table-hover text-center align-middle">
                                    <tr class="table-header-colored">
                                        <th>ID</th>
                                        <th>Tên bác sĩ</th>
                                        <th>Ngày làm việc</th>
                                        <th>Ca làm việc</th>
                                        <th>Email</th>
                                        <th>Số điện thoại</th>
                                        <th>Tình trạng</th>
                                        <th>Thao tác</th>


                                    </tr>
                                    @foreach ($schedule as $item)
                                        <tr>
                                            <td>{{ $item->schedule_id }}</td>
                                            <td>{{ $item->user->fullname ?? 'Không có tên' }}</td>
                                            <td>{{ $item->date }}</td>
                                            <td>
                                                @if ($item->schedule_time_id == 1)
                                                    <span class="badge bg-success">Sáng</span>
                                                @elseif ($item->schedule_time_id == 2)
                                                    <span class="badge bg-warning">Chiều</span>
                                                @else
                                                    <span class="badge bg-primary">Cả ngày</span>
                                                @endif
                                            </td>
                                            <td>{{ $item->user->email ?? 'Không có email' }}</td>
                                            <td>{{ $item->user->contact_number ?? 'Không có số điện thoại' }}</td>
                                            <td>
                                                @if ($item->status == 'Đã duyệt')
                                                    <span class="badge bg-success">Đã duyệt</span>
                                                @elseif ($item->status == 'Chờ duyệt')
                                                    <span class="badge bg-warning">Chờ duyệt</span>
                                                @else
                                                    <span class="badge bg-danger">Đã hủy</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#doctorDetailModal--{{ $item->schedule_id }}"
                                                    data-id="{{ $item->schedule_id }}">
                                                    Xem
                                                </button>
                                                <button class="btn btn-info" data-bs-toggle="modal"
                                                    data-bs-target="#capNhatLichLamViec--{{ $item->schedule_id }}"
                                                    data-id="{{ $item->schedule_id }}">Sửa</button>
                                                <button class="btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#deleteLichLamViecModal-{{ $item->schedule_id }}">Xóa</button>
                                            </td>

                                        </tr>
                                    @endforeach

                                </table>


                            </div>


                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form Xoa lịch làm việc  --}}
            <div class="px-3 px-md-5">
                <div class="collapse" id="xoaLichLamViec" data-bs-parent="#collapseContainer">
                    <div class="card shadow-lg mb-4">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="card-title mb-4 border-bottom pb-2">
                                <i class="bi bi-trash3-fill text-primary p-2"></i>
                                Xóa lịch làm việc
                            </h3>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover text-center align-middle">
                                    <tr class="table-header-colored">
                                        <th>
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input" type="checkbox" id="checkAll"
                                                    onchange="toggleAllCheckboxes(this)">
                                            </div>
                                        </th>
                                        <th>ID</th>
                                        <th>Tên bác sĩ</th>
                                        <th>Ngày làm việc</th>
                                        <th>Ca làm việc</th>
                                        <th>Email</th>
                                        <th>Số điện thoại</th>
                                        <th>Tình trạng</th>
                                        <th>Thao tác</th>


                                    </tr>
                                    @foreach ($schedule as $item)
                                        <tr>
                                            <td>
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input row-checkbox" type="checkbox"
                                                        value="{{ $item->schedule_id }}"
                                                        onchange="updateDeleteButton()">
                                                </div>
                                            </td>
                                            <td>{{ $item->schedule_id }}</td>
                                            <td>{{ $item->user->fullname ?? 'Không có tên' }}</td>
                                            <td>{{ $item->date }}</td>
                                            <td>
                                                @if ($item->schedule_time_id == 1)
                                                    <span class="badge bg-success">Sáng</span>
                                                @elseif ($item->schedule_time_id == 2)
                                                    <span class="badge bg-warning">Chiều</span>
                                                @else
                                                    <span class="badge bg-primary">Cả ngày</span>
                                                @endif
                                            </td>
                                            <td>{{ $item->user->email ?? 'Không có email' }}</td>
                                            <td>{{ $item->user->contact_number ?? 'Không có số điện thoại' }}</td>
                                            <td>
                                                @if ($item->status == 'Đã duyệt')
                                                    <span class="badge bg-success">Đã duyệt</span>
                                                @elseif ($item->status == 'Chờ duyệt')
                                                    <span class="badge bg-warning">Chờ duyệt</span>
                                                @else
                                                    <span class="badge bg-danger">Đã hủy</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#deleteLichLamViecModal-{{ $item->schedule_id }}">Xóa</button>
                                            </td>

                                        </tr>
                                    @endforeach

                                </table>


                            </div>

                            <div class="batch-delete-area d-flex justify-content-end mt-3" id="batchDeleteArea">
                                <button type="button" class="btn btn-danger btn-lg shadow-sm" data-bs-toggle="modal"
                                    data-bs-target="#modalXoaNhieu">
                                    <i class="bi bi-trash-fill"></i> Xóa tất cả đã chọn (<span
                                        id="selectedCount">0</span>)
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('component.footer')
</body>

</html>
