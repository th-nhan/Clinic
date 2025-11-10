<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đăng Nhập</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>

<body>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow" style="width: 400px;">
            <h3 class="card-title text-center mb-4">Đăng Nhập</h3>
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
</body>

</html>
