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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
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
            <div class="d-flex align-items-center gap-3">
                
                <a href="{{ route('lichlamviec') }}" class="btn btn-info px-4">Quản lý lịch làm việc</a>
                <a href="{{ route('lichsu.index') }}" class="btn btn-info px-4">Quản lý lịch sử khám</a>
                @auth
                    <div class="dropdown">
                        <a href="#"
                            class="d-flex align-items-center text-decoration-none dropdown-toggle text-dark p-2 rounded hover-bg-light"
                            id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">


                            <img src="{{ Auth::user()->avatar ?? asset('pic/bs1.jpg') }}" alt="Avatar"
                                class="rounded-circle border-2 border-white shadow-sm" width="40" height="40"
                                style="object-fit: cover;">

                            <div class="d-none d-md-block ms-2 text-start">

                                <span class="d-block fw-bold small">{{ Auth::user()->fullname }}</span>


                                <span class="d-block text-muted" style="font-size: 11px;">
                                    {{ Auth::user()->description ?? 'Thành viên' }}
                                </span>
                            </div>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2 rounded-3"
                            aria-labelledby="userDropdown">
                            <li>
                                <h6 class="dropdown-header text-uppercase small text-muted">Tài khoản</h6>
                            </li>

                            <li>
                                <a class="dropdown-item py-2 d-flex align-items-center" href="{{ route('lichlamviec') }}">
                                    <i class="bi bi-calendar-week me-2 text-primary"></i> Quản lý lịch làm việc
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 d-flex align-items-center" href="{{ route('lichsu.index') }}">
                                    <i class="bi bi-clock-history me-2 text-info"></i> Quản lý lịch sử khám
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 d-flex align-items-center text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endauth
                @guest
                    <a href="{{ route('login') }}" class="btn btn-outline-primary px-4">
                        Đăng nhập
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-primary  px-4">
                        Đăng ký
                    </a>
                @endguest
            </div>
        </div>

    </div>
</nav>
<div class="mt-25"></div>
