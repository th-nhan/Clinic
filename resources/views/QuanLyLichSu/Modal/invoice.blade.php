<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết hóa đơn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-4">
        <div class="text-center">
            <h4 class="fw-bold text-dark mb-1">Chi tiết hóa đơn</h4>
            <p class="text-muted small">Mã hóa đơn: <span class="fw-semibold text-dark">#{{
                    $invoice->invoice_id}}</span></p>
        </div>
        <div class="row justify-content-center g-3">
            <div class="col-lg-8 col-xl-7">
                <div class="card shadow p-3 border-0">
                    <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
                        <h6 class="mb-0 fw-bold">Thông tin chi tiết</h6>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="text-uppercase text-muted mb-0 small">Mã hóa đơn</p>
                            <p class="fw-semibold text-dark"> {{ $invoice->invoice_id ?? 'Không có
                                dữ liệu' }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-uppercase text-muted mb-0 small">Khách hàng</p>
                            <p class="fw-semibold text-dark"> {{ $invoice->history->customer->fullname ?? 'Không có
                                dữ liệu' }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-uppercase text-muted mb-0 small">Dịch vụ</p>
                            <p class="fw-semibold text-dark">
                                @foreach ($invoice->history->historyDetails as $detail)
                                {{ $detail->service->name }} <br>
                                @endforeach
                            </p>
                        </div>

                        <div class="col-md-6">
                            <p class="text-uppercase text-muted mb-0 small">Ngày khám</p>
                            <p class="fw-semibold text-dark">
                                {{ \Carbon\Carbon::parse($invoice->history->date)->format('d/m/Y') }}
                            </p>
                        </div>

                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4 p-3 rounded-3 bg-light border">
                        <div>
                            <p class="text-uppercase text-muted mb-0 small">Tổng tiền cần thanh toán</p>
                            <span class="text-danger fw-bolder" style="font-size: 2rem;"> {{
                                number_format($invoice->total_price, 0, ',', '.') }}đ
                            </span>
                        </div>
                        <div class="text-end">
                            <p class="text-uppercase text-muted mb-0 small">Trạng thái</p>
                            @if ($invoice->status === 'unpaid')
                            <span class="badge bg-warning text-dark py-1 px-2"> <i
                                    class="fas fa-exclamation-circle me-1"></i> Chưa thanh toán
                            </span>
                            @else
                            <span class="badge bg-success py-1 px-2"> <i class="fas fa-check-circle me-1"></i> Đã
                                thanh toán
                            </span>
                            @endif
                        </div>
                    </div>

                    <h6 class="fw-bold mb-3">Chọn phương thức thanh toán</h6> @if ($invoice->status === 'unpaid')

                    <div class="row g-2">
                        <div class="col-md-6">
                            <form action="{{ route('payment.momo') }}" method="POST">
                                @csrf
                                <input type="hidden" name="invoice_id" value="{{ $invoice->invoice_id }}">
                                <button type="submit" class="btn btn-danger w-100 btn-md shadow"> <i
                                        class="fas fa-mobile-alt me-2"></i> Thanh toán MoMo
                                </button>
                            </form>
                        </div>

                        <div class="col-md-6">
                            <input type="hidden" name="invoice_id" value="{{ $invoice->invoice_id }}">
                            <button type="button" class="btn btn-success w-100 btn-md shadow" data-bs-toggle="modal"
                                data-bs-target="#confirmCashModal">
                                <i class="fas fa-money-bill-wave me-2"></i> Thanh toán tiền mặt
                            </button>
                        </div>

                    </div>

                    @else
                    <button class="btn btn-success w-100 btn-md" disabled> <i class="fas fa-check me-2"></i> Đã
                        thanh toán thành công
                    </button>
                    @endif

                </div>
            </div>

            <div class="col-lg-4 col-xl-3">
                <div class="card shadow text-center p-3 h-100 border-0">
                    <div class="mb-3"> <i class="fas fa-user-tie me-1 text-primary"></i>
                        <span class="fw-bold text-dark small">Bác sĩ phụ trách</span>
                    </div>

                    <img src="{{ $invoice->user->avatar }}" alt="{{ $invoice->user->fullname ?? 'Bác sĩ' }}"
                        class="rounded-circle mx-auto mb-3 border border-4 border-light shadow-sm"
                        style="width: 100px; height: 100px; object-fit: cover;">
                    <h6 class="fw-bold text-dark mb-1">{{ $invoice->user->fullname ?? 'Bác sĩ' }}</h6>
                    <p class="text-muted small mb-3"> <span class="fw-semibold">Chuyên khoa:</span> {{
                        $invoice->user->description }}
                    </p>

                    <a href="#" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-phone-alt me-1"></i> Liên hệ
                    </a>
                </div>
            </div>

        </div>
    </div>
    <form action="{{ route('payment.cash') }}" method="POST">
        @csrf
        <input type="hidden" name="invoice_id" value="{{ $invoice->invoice_id }}">

        <div class="modal fade" id="confirmCashModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Xác nhận thanh toán</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        Bạn có chắc chắn muốn thanh toán bằng <b>tiền mặt</b> không?
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-success">Xác nhận</button>
                    </div>

                </div>
            </div>
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>