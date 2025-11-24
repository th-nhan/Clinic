<style>
    .navbar-brand {
        padding-left: 20px;
        display: inline-flex;
        align-items: center;
    }

    .mt-25 {
        margin-top: 100px;
    }

    @media (min-width: 992px) {
        .dropdown:hover .dropdown-menu {
            display: block;
            margin-top: 0;
            /* Chỉnh lại khoảng cách nếu cần */
        }
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm p-0 fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="pic/logo1.jpg" alt="logo" width="65px" height="100%">
            DTN DENTAL CLINIC
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse  navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Trang chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Giới thiệu</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Dịch vụ
                    </a>

                    <ul class="dropdown-menu shadow border-0">
                        <li><a class="dropdown-item" href="#">Trám răng</a></li>
                        <li><a class="dropdown-item" href="#">Trồng răng sứ</a></li>
                        <li><a class="dropdown-item" href="#">Niềng răng</a></li>
                        <li><a class="dropdown-item" href="#">Bọc sứ</a></li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li><a class="dropdown-item" href="#">Xem tất cả dịch vụ</a></li>
                    </ul>
                </li>
                <li class="nav-item me-2">
                    <a class="nav-link" href="#">Liên hệ</a>
                </li>

            </ul>
            <div class="pb-2 pe-2">
                <a href="{{ route('lichlamviec') }}" class="btn btn-info">Quản lý lịch làm việc</a>
            </div>
            <div class="pb-2  pe-2">
                <a href="{{ route('lichsu.index') }}" class="btn btn-info">Quản lý lịch sử khám</a>
            </div>
            <div class="d-flex align-items-center gap-3">

                <div class="dropdown">
                    <a href="#"
                        class="d-flex align-items-center text-decoration-none dropdown-toggle text-dark p-2 rounded hover-bg-light"
                        id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">

                        <img src="pic/bs1.jpg" alt="Avatar" class="rounded-circle  border-2 border-white shadow-sm"
                            width="40" height="40" style="object-fit: cover;">

                        <div class="d-none d-md-block ms-2 text-start">
                            <span class="d-block fw-bold small">Đỗ Thành Nhân</span>
                            <span class="d-block text-muted" style="font-size: 11px;">Bác sĩ Chuyên khoa</span>
                        </div>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2 rounded-3"
                        aria-labelledby="userDropdown">
                        <li>
                            <h6 class="dropdown-header text-uppercase small text-muted">Tài khoản</h6>
                        </li>

                        <li>
                            <a class="dropdown-item py-2 d-flex align-items-center" href="{{ route('lichlamviec') }}">
                                <i class="bi bi-calendar-week me-2 text-primary"></i>
                                Quản lý lịch làm việc
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2 d-flex align-items-center" href="{{ route('lichsu.index') }}">
                                <i class="bi bi-clock-history me-2 text-info"></i>
                                Quản lý lịch sử khám
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2 d-flex align-items-center" href="#">
                                <i class="bi bi-person-gear me-2 text-warning"></i>
                                Cài đặt hồ sơ
                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item py-2 d-flex align-items-center text-danger"
                                href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-right me-2"></i>
                                Đăng xuất
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>

    </div>
</nav>
<div class="mt-25"></div>