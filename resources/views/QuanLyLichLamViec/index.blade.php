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
                </button> <button type="button" class="btn btn-outline-secondary" data-bs-target="#xemLichLamViec"
                    data-bs-toggle="collapse" aria-expanded="false" aria-controls="xemLichLamViec">
                    Xem thông tin</button>
                <button type="button" class="btn btn-outline-secondary" data-bs-target="#timKiemLichLamViec"
                    data-bs-toggle="collapse" aria-expanded="false" aria-controls="timKiemLichLamViec">
                    Tìm kiếm</button>
                <button type="button" class="btn btn-outline-danger" data-bs-target="#xoaLichLamViec"
                    data-bs-toggle="collapse" aria-expanded="false" aria-controls="xoaLichLamViec">
                    Xóa</button>
            </div>
        </div>

        <div id="collapseContainer">
            {{-- Form Xem lịch làm việc  --}}
            <div class="px-3 px-md-5">
                <div class="collapse show" id="xemLichLamViec" data-bs-parent="#collapseContainer">
                    <div class="card shadow-lg mb-4">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="card-title mb-4 border-bottom pb-2">
                                <i class="bi bi-eye-fill text-primary p-2"></i>
                                Xem Lịch Làm Việc
                            </h3>
    
                            <div class="table-responsive">
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
                                                    data-bs-target="#deleteLichLamViecModal">Xóa</button>
                                            </td>
    
                                        </tr>
                                    @endforeach
    
                                </table>
    
    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            {{-- Form Tìm kiếm lịch làm việc  --}}
            <div class="px-3 px-md-5">
                <div class="collapse" id="timKiemLichLamViec" data-bs-parent="#collapseContainer">
                    <div class="card shadow-lg mb-4">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="card-title mb-4 border-bottom pb-2">
                                <i class="bi bi-search text-primary p-2"></i>
                                Tìm Kiếm Lịch Làm Việc
                            </h3>
    
                            <form>
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
                                                <input class="form-check-input" type="radio" name="caLamViec"
                                                    id="ca1" value="ca1" checked>
                                                <label class="form-check-label" for="ca1">Sáng</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="caLamViec"
                                                    id="ca2" value="ca2">
                                                <label class="form-check-label" for="ca2">Chiều</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="caLamViec"
                                                    id="ca3" value="ca3">
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
    
                                <div class="mt-5 d-flex justify-content-center">
                                    <button type="submit" class="btn btn-success btn-lg px-5 shadow-sm">
                                        Tìm kiếm
                                    </button>
                                </div>
                            </form>
    
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
                                                    data-bs-target="#deleteLichLamViecModal">Xóa</button>
                                            </td>
    
                                        </tr>
                                    @endforeach
    
                                </table>
    
    
                            </div>
    
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
                                Xóa Lịch Làm Việc
                            </h3>
    
                            <div class="table-responsive">
                                <table class="table table-primary table-striped text-center align-middle">
                                    <thead>
                                        <tr>
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
                                            <th>Tình trạng</th>
                                            <th>Ghi chú</th>
                                            <th>Xóa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input row-checkbox" type="checkbox"
                                                        value="1" onchange="updateDeleteButton()">
                                                </div>
                                            </td>
                                            <td>1</td>
                                            <td>Đỗ Thành Nhân</td>
                                            <td>31/10/2025</td>
                                            <td>Sáng</td>
                                            <td><span class="badge bg-danger">Đã hủy</span></td>
                                            <td></td>
                                            <td><button class="btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#deleteLichLamViecModal">Xóa</button></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input row-checkbox" type="checkbox"
                                                        value="1" onchange="updateDeleteButton()">
                                                </div>
                                            </td>
                                            <td>2</td>
                                            <td>La Chí Thành</td>
                                            <td>31/10/2025</td>
                                            <td>Sáng</td>
                                            <td><span class="badge bg-success">Đã duyệt</span></td>
                                            <td></td>
                                            <td><button class="btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#deleteLichLamViecModal">Xóa</button></td>
    
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input row-checkbox" type="checkbox"
                                                        value="1" onchange="updateDeleteButton()">
                                                </div>
                                            </td>
                                            <td>3</td>
                                            <td>Nguyễn Cường Đại</td>
                                            <td>31/10/2025</td>
                                            <td>Chiều</td>
                                            <td><span class="badge bg-success">Đã duyệt</span></td>
                                            <td></td>
                                            <td><button class="btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#deleteLichLamViecModal">Xóa</button></td>
                                        </tr>
                                    </tbody>
    
                                </table>
    
    
                            </div>
                            <div class="batch-delete-area d-flex justify-content-end mt-3" id="batchDeleteArea">
                                <button type="button" class="btn btn-danger btn-lg shadow-sm" data-bs-toggle="modal"
                                    data-bs-target="#deleteLichLamViecModal">
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
