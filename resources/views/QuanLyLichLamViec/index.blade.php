<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <title>Quản lý lịch làm việc</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

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
                <button type="button" class="btn btn-outline-primary" data-bs-target="#themLichLamViecModal"
                    data-bs-toggle="modal" aria-expanded="false" aria-controls="themLichLamViecModal">
                    <i class="bi bi-plus-circle"></i> Thêm lịch làm việc
                </button>
                <button type="button" class="btn btn-outline-secondary" data-bs-target="#timKiemLichLamViec"
                    data-bs-toggle="collapse" aria-expanded="false" aria-controls="timKiemLichLamViec">
                    Tìm kiếm</button>
                <button type="button" class="btn btn-outline-danger" data-bs-target="#xoaLichLamViec"
                    data-bs-toggle="collapse" aria-expanded="false" aria-controls="xoaLichLamViec">
                    Xóa</button>
            </div>
        </div>

        <div id="collapseContainer">

            {{-- Form Tìm kiếm lịch làm việc  --}}
            <div class="px-3 px-md-5">
                <div class="collapse show " id="timKiemLichLamViec" data-bs-parent="#collapseContainer">
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
                                            <option value="Đỗ Thành Nhân"></option>
                                            <option value="Ngô Minh Quý"></option>
                                            <option value="Nguyễn Cường Đại"></option>
                                            <option value="La Chí Thành"></option>
                                            <option value="Nguyễn Thúy Vy"></option>
                                        </datalist>
                                    </div>

                                    <div class="col-md-6 col-lg-4">
                                        <label class="form-label fw-bold">Thời gian làm việc</label>

                                       
                                        
                                        @php $type = request('filter_type', 'date'); @endphp

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

                                        
                                        <input type="hidden" name="filter_type" value="{{ $type }}">

                                       

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
                                                @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
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
                                                <input class="form-check-input" type="radio" name="caLamViec"
                                                    id="ca1" value="1"
                                                    {{ request('caLamViec') == '1' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="ca1">Sáng</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="caLamViec"
                                                    id="ca2" value="2"
                                                    {{ request('caLamViec') == '2' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="ca2">Chiều</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="caLamViec"
                                                    id="ca3" value="3"
                                                    {{ request('caLamViec') == '3' ? 'checked' : '' }}>
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

<<<<<<< HEAD
                            <div class="row mt-4">
                                <div class="col-12">
                                    <label for="floatingTextarea" class="form-label fw-bold">Ghi chú</label>
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Nhập ghi chú tại đây" id="floatingTextarea" style="height: 100px"></textarea>
                                        <label for="floatingTextarea">Nhập ghi chú tại đây</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5 d-flex justify-content-center">
                                <button type="submit" class="btn btn-success btn-lg px-5 shadow-sm"
                                data-bs-toggle="modal" data-bs-target="#addLichLamViecSuccessModal">Lưu Lịch Làm
                                    Việc</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form Xem lịch làm việc  --}}
        <div class="px-3 px-md-5">
            <div class="collapse" id="xemLichLamViec">
                <div class="card shadow-lg mb-4">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="card-title mb-4 border-bottom pb-2">
                            <i class="bi bi-eye-fill text-primary p-2"></i>
                            Xem Lịch Làm Việc
                        </h3>

                        <div class="table-responsive">
                            <table class="table table-primary table-striped text-center align-middle">
                                <tr>
                                    <th>ID</th>
                                    <th>Tên bác sĩ</th>
                                    <th>Ngày làm việc</th>
                                    <th>Ca làm việc</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Tình trạng</th>
                                    <th>Ghi chú</th>
                                    <th>Thao tác</th>


                                </tr>
                                @foreach ($schedule as $item)
                                <tr>
                                    <td>{{ $item->user_id }}</td>
                                    <td>{{ $item->user->fullname ?? 'Không có dữ liệu' }}</td>
                                </tr>
                                @endforeach


                            </table>


=======
>>>>>>> 37fc91132f684ba593d98e0b42f0706046b27867
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
                                                        value="{{ $item->schedule_id }}" onchange="updateDeleteButton()">
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
