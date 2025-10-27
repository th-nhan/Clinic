<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <title>Quản lý lịch làm việc</title>
    <style>
        .px-10 {
            padding-left: 40px;
            padding-right: 40px;
        }

        .responsive-btn-group-wrapper {
            gap: 0;
        }

        .responsive-btn {

            border-radius: 0 !important;
        }

        .responsive-btn-group-wrapper .responsive-btn:first-child {
            border-top-left-radius: 0.375rem !important;
            border-bottom-left-radius: 0.375rem !important;
        }

        .responsive-btn-group-wrapper .responsive-btn:last-child {
            border-top-right-radius: 0.375rem !important;
            border-bottom-right-radius: 0.375rem !important;
        }

        .form-label {
            margin-right: 10px;
            width: 150px;
        }

        @media (max-width: 767.98px) {
            .responsive-btn-group-wrapper {
                flex-direction: column;
                gap: 8px;
            }

            .responsive-btn {

                margin-bottom:
                    border-radius: 0.375rem !important;
            }
        }
    </style>
</head>
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> --}}

<body>
    @include('component.header')
    <div class="container-fluid">
        <div class="mx-5">
            <h2>Quản lý lịch làm việc</h2>
        </div>
        <div class="mx-5  my-4  d-flex flex-wrap justify-content-center responsive-btn-group-wrapper">
            <button type="button" class="btn btn-outline-primary py-2 px-10 responsive-btn"
                data-bs-target="#themLichLamViec" data-bs-toggle="collapse">

                Thêm lịch làm việc
            </button>
            <button type="button" class="btn btn-outline-primary py-2 px-10 responsive-btn">Xem thông tin lịch làm
                việc</button>
            <button type="button" class="btn btn-outline-primary py-2 px-10 responsive-btn">Tìm kiếm lịch làm
                việc</button>
            <button type="button" class="btn btn-outline-primary py-2 px-10 responsive-btn">Cập nhật lịch làm
                việc</button>
            <button type="button" class="btn btn-outline-primary py-2 px-10 responsive-btn">Xóa lịch làm việc</button>
        </div>

    </div>
    @include('component.footer')
</body>
<script>
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('dateTimePicker').setAttribute('min', today);
</script>

</html>
