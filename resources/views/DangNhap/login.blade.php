<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đăng Nhập</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        .card {
            background: #fdfdfd;
        }
        .logo-container {
            display: flex;
            justify-content: center;
            margin-bottom: 15px;
        }

        /* CSS chỉnh ảnh logo đẹp hơn */
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

                <h2 class="card-title text-center">Đăng Nhập</h2>
                <p class="text-muted small text-center">Vui lòng đăng nhập để tiếp tục</p>
            </div>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Nhập email của bạn" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mật Khẩu</label>
                    <input type="password" class="form-control" id="password" placeholder="Nhập mật khẩu của bạn"
                        required>
                </div>
                <div class="mb-3 text-end">
                    <a href="#" class="text-decoration-none">Quên mật khẩu?</a>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Đăng Nhập</button>
                </div>
            </form>

        </div>
    </div>
</body>

</html>
