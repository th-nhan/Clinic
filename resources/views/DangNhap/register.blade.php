<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đăng Ký</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        .card {
            background: #fdfdfd;
        }
        .logo-container {
            display: flex;
            justify-content: center;
            margin-bottom: 15px;
        }

        .logo-img {
            width: 100px;
            height: auto;
            border-radius: 50px;
            object-fit: contain;
            background: white;
            padding: 5px;
            transition: transform 0.3s ease;
        }


        .logo-img:hover {
            transform: scale(1.05) rotate(-2deg);
        }
    </style>

</head>

<body>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow" style="width: 400px;">
            <div class="card-header-custom">
                <div class="logo-container">
                    <img src="pic/logo1.jpg" alt="logo" class="logo-img">
                </div>

                <h2 class="card-title text-center">Đăng ký</h2>
            </div>
            @if(session('error'))
                <div class="alert alert-danger text-center" role="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('register') }}" method="POST">
                @csrf
                 <div class="mb-3">
                    <label for="fullname" class="form-label">Họ và tên</label>
                    <input type="text" class="form-control" id="fullname" value="{{ old('fullname') }}"
                    name="fullname" placeholder="Nhập họ và tên của bạn" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                     id="email" placeholder="Nhập email của bạn" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mật Khẩu</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Nhập mật khẩu của bạn"
                        required>
                </div>
               <div class="mb-3">
                    <label for="confirm-password" class="form-label">Nhập lại mật khẩu</label>
                    <input type="password" class="form-control" name="confirm-password" id="confirm-password" placeholder="Nhập mật khẩu của bạn"
                        required>
                </div>
                <div class="mb-3">
                    <a href="{{ route('login') }}">Đã có tài khoản</a>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Đăng Ký</button>
                </div>
            </form>

        </div>
    </div>
</body>

</html>
