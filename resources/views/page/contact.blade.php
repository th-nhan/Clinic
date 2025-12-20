<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên Hệ - Clinic DTN</title>
    {{-- Link Bootstrap 5 & Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* CSS Tùy chỉnh cho đẹp hơn */
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .contact-header {
            background: linear-gradient(135deg, #0dcaf0 0%, #0d6efd 100%);
            color: white;
            padding: 80px 0;
            border-radius: 0 0 50px 50px;
            margin-bottom: 50px;
        }

        .info-box {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            height: 100%;
            transition: transform 0.3s ease;
        }

        .info-box:hover {
            transform: translateY(-5px);
        }

        .info-icon {
            width: 60px;
            height: 60px;
            background: #e7f1ff;
            color: #0d6efd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .contact-form-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .form-floating > .form-control:focus ~ label {
            color: #0d6efd;
        }
        
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }

        .btn-send {
            background: linear-gradient(90deg, #0d6efd 0%, #0dcaf0 100%);
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-send:hover {
            opacity: 0.9;
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
        }

        .map-container iframe {
            width: 100%;
            height: 300px;
            border-radius: 15px;
            border: none;
        }
    </style>
</head>
<body>
    @include('component.header')

    {{-- HEADER BANNER --}}
    <div class="contact-header text-center">
        <div class="container">
            <h1 class="display-4 fw-bold">Liên Hệ Với Clinic DTN</h1>
            <p class="lead opacity-75">Chúng tôi luôn sẵn sàng lắng nghe và chăm sóc sức khỏe của bạn.</p>
        </div>
    </div>

    <div class="container mb-5">
        <div class="row g-5">
            
            {{-- CỘT TRÁI: THÔNG TIN LIÊN HỆ --}}
            <div class="col-lg-5">
                <div class="row g-4">
                    {{-- Địa chỉ --}}
                    <div class="col-12">
                        <div class="info-box d-flex align-items-start">
                            <div class="info-icon flex-shrink-0">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <div class="ms-4">
                                <h5 class="fw-bold text-primary">Địa Chỉ Phòng Khám</h5>
                                <p class="text-muted mb-0">123 Đường Nguyễn Văn Cừ, Quận 5,<br>TP. Hồ Chí Minh, Việt Nam</p>
                            </div>
                        </div>
                    </div>

                    {{-- Hotline & Email --}}
                    <div class="col-12">
                        <div class="info-box d-flex align-items-start">
                            <div class="info-icon flex-shrink-0">
                                <i class="bi bi-telephone-fill"></i>
                            </div>
                            <div class="ms-4">
                                <h5 class="fw-bold text-primary">Liên Hệ Trực Tiếp</h5>
                                <p class="mb-1"><strong class="text-dark">Hotline:</strong> 1900 123 456</p>
                                <p class="mb-0"><strong class="text-dark">Email:</strong> contact@clinicdtn.com</p>
                            </div>
                        </div>
                    </div>

                    {{-- Giờ làm việc --}}
                    <div class="col-12">
                        <div class="info-box d-flex align-items-start">
                            <div class="info-icon flex-shrink-0">
                                <i class="bi bi-clock-fill"></i>
                            </div>
                            <div class="ms-4">
                                <h5 class="fw-bold text-primary">Giờ Làm Việc</h5>
                                <ul class="list-unstyled text-muted mb-0">
                                    <li>Thứ 2 - Thứ 7: 08:00 - 17:00</li>
                                    <li>CN: Hẹn lịch riêng với bác sĩ</li>
                                    <li class="text-danger mt-1"><small>* Cấp cứu 24/7</small></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CỘT PHẢI: FORM LIÊN HỆ & BẢN ĐỒ --}}
            <div class="col-lg-7">
                <div class="card contact-form-card p-4 p-md-5 mb-4">
                    <h3 class="fw-bold mb-4 text-center text-primary">Gửi Tin Nhắn Cho Bác Sĩ</h3>
                    
                    {{-- Form Laravel --}}
                    <form action="" method="POST" id="contactForm"> 
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="name" placeholder="Họ và tên" required>
                                    <label for="name">Họ và tên</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="email" placeholder="Email" required>
                                    <label for="email">Email</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="tel" class="form-control" id="phone" placeholder="Số điện thoại" required>
                                    <label for="phone">Số điện thoại</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" id="subject">
                                        <option value="Tư vấn">Tư vấn sức khỏe</option>
                                        <option value="Đặt lịch">Hỗ trợ đặt lịch</option>
                                        <option value="Góp ý">Góp ý dịch vụ</option>
                                        <option value="Khác">Khác</option>
                                    </select>
                                    <label for="subject">Vấn đề cần hỗ trợ</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Nội dung tin nhắn" id="message" style="height: 150px" required></textarea>
                                    <label for="message">Nội dung chi tiết...</label>
                                </div>
                            </div>
                            <div class="col-12 text-center mt-4">
                                <button type="submit" class="btn btn-primary btn-send btn-lg text-white shadow">
                                    <i class="bi bi-send-fill me-2"></i> Gửi Tin Nhắn
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Bản đồ Google Maps --}}
                <div class="map-container shadow-sm">
                    {{-- Đây là iframe mẫu, bạn hãy thay src bằng link embed Google Maps địa chỉ thật của bạn --}}
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.954067902469!2d106.6756313148386!3d10.73802386283592!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f62a90e5dbd%3A0x674d5126513db291!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBDw7RuZyBuZ2jhu4cgU8OgaSBHw7Ju!5e0!3m2!1svi!2s" 
                        allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>

        </div>
    </div>

    {{-- Script Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Script xử lý form gửi thành công --}}
    <script>
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Ngăn form submit bình thường

            // Hiển thị SweetAlert2 thông báo thành công
            Swal.fire({
                title: 'Gửi thành công!',
                text: 'Cảm ơn bạn đã liên hệ. Chúng tôi sẽ phản hồi sớm nhất.',
                icon: 'success',
                confirmButtonText: 'Đóng',
                confirmButtonColor: '#0d6efd'
            }).then((result) => {
                // Sau khi đóng thông báo thì reload trang (đồng thời reset form)
                if (result.isConfirmed || result.isDismissed) {
                    window.location.reload();
                }
            });
        });
    </script>
</body>
</html>