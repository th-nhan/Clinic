<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <title>DTN Clinic</title>
    <style>
        .navbar-brand {
            padding-left: 20px;
            display: inline-flex;
            align-items: center;
        }

        .bi-facebook,
        .bi-youtube,
        .bi-instagram {
            color: white;
        }

        .bi-facebook:hover,
        .bi-youtube:hover,
        .bi-instagram:hover {
            color: #4f5257;
        }

        .hv-txt-blue {
            color: white;
            text-decoration: none;
            margin: 5px 0;
        }

        .hv-txt-blue:hover {
            color: #4f5257;

        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</head>

<body>
    @include('component.header')
    <div class="container-fluid p-0">
        <img src="https://nhakhoasaigon.vn/wp-content/uploads/2019/05/banner-treo-WEB-02.jpg" alt=""
            class="img-fluid w-100">
    </div>

    <section class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2 class="fw-bold mb-4 display-7 text-start">
                        Về Nha Khoa DTN
                    </h2>
                    <p>
                        Là chuỗi phòng khám Nha khoa uy tín hàng đầu Việt Nam với đội ngũ bác sĩ giỏi,
                        chăm sóc khách hàng tận tâm và kết quả nụ cười đẹp.
                        Nha Khoa DTN hiện có mặt tại hơn 30 phòng khám trên toàn quốc.
                    </p>
                    <p>
                        Với cơ sở vật chất hiện đại, quy trình chuẩn quốc tế,
                        chúng tôi mang đến trải nghiệm thoải mái và dịch vụ nha khoa toàn diện.
                    </p>
                    <a href="#" class="btn btn-outline-primary">Tìm hiểu thêm</a>
                </div>
                <div class="col-md-6 text-center">
                    <iframe width="100%" height="315"
                        src="https://www.youtube.com/embed/GUb8uUZUh5A?si=IoJKFvArXlfiOkb5" title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center fw-bold text-uppercase mb-4 text-primary">
                Sự Khác Biệt Ở Nha Khoa DTN
            </h2>
            <div class="d-flex justify-content-center mb-5">
                <div class="bg-primary rounded" style="width: 80px; height: 4px;"></div>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="https://jetdentist.vn/upload/news/b%C3%ACa_(1)4.jpg_1684914954.webp"
                            class="card-img-top" alt="Vệ sinh vô khuẩn">
                        <div class="card-body">
                            <h5 class="card-title fw-bold text-primary">Đừng để bị lây nhiễm bệnh</h5>
                            <p class="card-text">
                                Nha Khoa DTN đảm bảo quy trình vô trùng nghiêm ngặt, dụng cụ luôn được tiệt khuẩn đúng
                                cách.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="https://media.tapchigiaoduc.edu.vn/uploads/2021/10/12/scientist-in-lab-p96atwk-1634001229.jpeg"
                            class="card-img-top" alt="Đối tác Harvard">
                        <div class="card-body">
                            <h5 class="card-title fw-bold text-primary">Đối tác Đại học Harvard</h5>
                            <p class="card-text">
                                Nha Khoa DTN là đối tác toàn cầu của Đại học Harvard, mang đến tiêu chuẩn điều trị quốc
                                tế.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="https://nhakhoadomin.vn/wp-content/uploads/2025/05/mobile.jpg" class="card-img-top"
                            alt="Đội ngũ bác sĩ">
                        <div class="card-body">
                            <h5 class="card-title fw-bold text-primary">Đội ngũ bác sĩ chuyên nghiệp</h5>
                            <p class="card-text">
                                100% bác sĩ tại Nha Khoa DTN đều có chứng chỉ hành nghề và nhiều năm kinh nghiệm thực
                                tế.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="container-fluid mt-5 p-0">
        <div class="text-center p-4 bg-dark text-white">
            Nha Khoa DTN - Địa chỉ: Số 123, Đường Cao Lỗ, Phường Chấn Hưng, TP.HCM - Điện thoại: 0123 456 789
        </div>

        <div class="flex bg-secondary text-white justify-content-around d-flex flex-wrap p-4">
            <div class="space-y-2 p-4 d-flex flex-column">
                <a class="hv-txt-blue">Trả góp 0% - Thanh toán linh hoạt</a>
                <a class="hv-txt-blue">Hợp tác chiến lược</a>
                <a class="hv-txt-blue">Bảo hiểm liên kết</a>
                <a class="hv-txt-blue">Tuyển dụng</a>
            </div>
            <div class="space-y-2 p-4 d-flex flex-column">
                <a class="hv-txt-blue">Răng sứ thẩm mỹ</a>
                <a class="hv-txt-blue">Niềng răng</a>
                <a class="hv-txt-blue">Trồng răng Implant</a>
                <a class="hv-txt-blue">Trám răng</a>
                <a class="hv-txt-blue">Bọc răng sứ</a>
            </div>
            <div class="space-y-2 p-4 d-flex flex-column">
                <p>Kết nối chúng tôi</p>
                <div class="">
                    <a href="#"><i class="bi bi-facebook fs-3 me-3"></i></a>
                    <a href="#"><i class="bi bi-youtube fs-3 me-3"></i></a>
                    <a href="#"><i class="bi bi-instagram fs-3 me-3"></i></a>
                </div>
            </div>
            <div class="space-y-2 p-4">
                <p>Hotline: 1900 1900</p>
                <p>Email: cskh@dtn.clinic.com </p>
                <img src="/pic/logo-da-thong-bao-bo-cong-thuong-mau-xanh.png" alt="bo cong thuong" width="150px"
                    height="100px">
                <img src="/pic/tinhnhiemmang.png" alt="tinh nhiem mang" width="150px" height="100px"
                    class="mt-2">
            </div>


        </div>
        <div class="text-center px-3 bg-light">
            © 2024 Copyright: Nha Khoa DTN
        </div>
    </footer>
</body>

</html>
