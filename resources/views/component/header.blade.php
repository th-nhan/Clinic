   <style>
       .navbar-brand {
           padding-left: 20px;
           display: inline-flex;
           align-items: center;
       }
   </style>
   <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm p-0 fixed-top">
       <div class="container-fluid">
           <a class="navbar-brand" href="#">
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
                   <li class="nav-item ">
                       <a class="nav-link" href="#">Dịch vụ
                           <i class="bi bi-caret-down-fill ms-1 align-middle"></i>
                       </a>
                   </li>
                   <li class="nav-item">
                       <a class="nav-link" href="#">Liên hệ</a>
                   </li>

               </ul>
               <div class="pb-2 pe-2">
                   <a href="{{ route('QuanLyLichLamViec.index') }}" class="btn btn-info">Quản lý lịch làm việc</a>
               </div>
               <div class="pb-2  pe-2">
                   <a href="{{ route('QuanLyLichLamViec.index') }}" class="btn btn-info">Quản lý lịch sử khám</a>
               </div>
               <div class="pb-2  pe-2">
                   <button class="btn btn-primary">Đăng nhập</button>
               </div>

           </div>

       </div>
   </nav>
