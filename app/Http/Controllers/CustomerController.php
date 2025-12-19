<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\History;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

public function show($id)
{
    $customer = Customer::with([
        'histories.user',
        'histories.invoice',
        'histories.historyDetails.service'
    ])->findOrFail($id);

    return view('QuanLyLichSu.customer.show', compact('customer'));
}

public function overview(Request $request)
{
    $name = $request->input('name');
    $phone = $request->input('phone'); 

    // **Bước 1: Tìm kiếm Khách hàng theo Tên và SĐT**
    // (Giữ nguyên logic của bạn)
    $customerIds = Customer::where('fullname', $name)
        ->where('contact_number', $phone)
        ->pluck('customer_id');

    // **Bước 2: Tải TẤT CẢ Lịch sử khám**
    // (Giữ nguyên logic của bạn)
    $histories = History::with([
        'user',
        'historyDetails.service',
        'invoice'
    ])
    ->whereIn('customer_id', $customerIds)
    ->orderByDesc('date') // Quan trọng: Đảm bảo bản ghi mới nhất nằm ở đầu để lấy chẩn đoán
    ->get();

    $customer = Customer::where('fullname', $name)
                    ->where('contact_number', $phone)
                    ->first(); 
    
    // Xử lý trường hợp không tìm thấy khách hàng
    if (!$customer) {
        return response()->json([
            'name' => $name,
            'phone' => $phone,
            'histories' => [],
            
            // Trả về mặc định cho các trường mở rộng
            'last_diagnosis' => 'Chưa có thông tin',
            'medical_notes' => 'Chưa có thông tin',
            'total_paid' => 0,
            'total_debt' => 0,
        ]);
    }

    // ==========================================================
    // 🔥 PHẦN BỔ SUNG LOGIC TÍNH TOÁN DỮ LIỆU TỔNG QUAN
    // ==========================================================
    
    // 1. Chẩn đoán gần nhất: Lấy trường 'noted' từ bản ghi lịch sử khám gần nhất (đã sort)
    $lastHistory = $histories->first(); 
    $lastDiagnosis = $lastHistory ? $lastHistory->noted : 'Chưa có chẩn đoán từ lần khám gần nhất.';
    
    // 2. Tổng quan Tài chính: Lấy tất cả hóa đơn và tính tổng
    $allInvoices = $histories->pluck('invoice')->filter(); // Lấy tất cả hóa đơn không null
    
    $totalPaid = $allInvoices->where('status', 'paid')->sum('total_price');
    $totalDebt = $allInvoices->where('status', 'unpaid')->sum('total_price');

    // 3. Các trường không có sẵn (Giả định không mở rộng DB)
    $medicalNotes = 'Không thể xác định thông tin y tế cố định (Do DB chưa có trường riêng).';
    
    // ==========================================================
    
    return response()->json([
        'name' => $customer->fullname,
        'phone' => $customer->contact_number,
        
        // 🔥 THÊM CÁC TRƯỜNG DỮ LIỆU MỞ RỘNG
        'last_diagnosis' => $lastDiagnosis,
        'medical_notes' => $medicalNotes,
        'total_paid' => $totalPaid,
        'total_debt' => $totalDebt,
        
        // Lịch sử khám (Giữ nguyên logic map của bạn)
        'histories' => $histories
            ->map(function ($h) {
                return [
                    'date' => \Carbon\Carbon::parse($h->date)->format('d/m/Y'),
                    'time' => $h->time,
                    'doctor' => $h->user->fullname ?? 'Không rõ',
                    'services' => $h->historyDetails->map(
                        fn ($d) => $d->service->name
                    ),
                    'total' => number_format($h->invoice->total_price ?? 0),
                    'status' => $h->invoice->status ?? 'unpaid',
                    'noted' => $h->noted
                ];
            })
            ->values()
    ]);
}

public function search(Request $request)
{
    return Customer::where('fullname', 'like', "%{$request->q}%")
        ->orWhere('contact_number', 'like', "%{$request->q}%")
        ->select('customer_id', 'fullname', 'contact_number')
        ->get();
}

} 