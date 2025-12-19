<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\history;
use App\Models\HistoryDetail;
use App\Models\Invoice;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request){

        $query = History::with(relations: ['Customer', 'User', 'historyDetails.service', 'historyDetails']);

        if ($request->search_name) {
            $query->whereHas('customer', function($q) use ($request) {
                $q->where('fullname', 'LIKE', '%' . $request->search_name . '%');
            });
        }
        if($request->search_date) {
            $query->where('date', $request->search_date);
        }
        if ($request->search_service) {
            $query->whereHas('historyDetails', function($q) use ($request) {
                $q->where('service_id', $request->search_service);
            });
        }
        if ($request->search_status) {
            $query->whereHas('Invoice', function($q) use ($request) {
                $q->where('status', $request->search_status);
            });
        }
        $histories = $query->orderBy('history_id', 'ASC')->get();
        $users = User::all();
        $services = Service::all();
        $invoice = Invoice::all();
        $customers = Customer::all();
        return view('QuanLyLichSu.index', compact('histories','users','services', 'customers', 'invoice'));
    }

    public function store(Request $request) {
        $request->validate([
            'ngaykham' => 'required|date|before_or_equal:today'
        ]);
        $customer = Customer::create([
            'contact_number' => $request->sodienthoai,
            'fullname' => $request->khachhang
        ]);
        $history = History::create([
            'user_id' => $request->bacsi,
            'customer_id' => $customer->customer_id,
            'date' => $request->ngaykham,
            'time' => $request->giohen,
            'noted' => $request->ghichu
         ]);

        $services = is_array($request->dichvu) ? $request->dichvu : [$request->dichvu];

        foreach($services as $service_id) {
            $history_detail = HistoryDetail::create([
                'history_id' => $history->history_id,
                'service_id' => $service_id,
                'price' => $request->tien
            ]);
        }
        
        Invoice::create([
            'history_id' => $history->history_id,
            'user_id' => $request->bacsi,
            'total_price' => $history_detail->price ?? $request->tien,
            'method_payment' => 'momo',
            'status' => $request->radioStatus ?? 'unpaid'
        ]);

        return back()->with('success', 'Thêm thành công');

    }

    public function update(Request $request, $id)
    {
        $history = History::findOrFail($id);
        $customer = $history->customer;
        $request->validate([
        'ngaykham' => 'required|date|before_or_equal:today',
        ]);
        $customer->update([
            'fullname' => $request->khachhang,
            'contact_number' => $request->sodienthoai
        ]);

        $history->update([
            'customer_id' => $customer->customer_id,
            'user_id' => $request->bacsi,
            'date' => $request->ngaykham,
            'time' => $request->giohen,
            'noted' => $request->ghichu
        ]);

        HistoryDetail::where('history_id', $id)->delete();
        $services = $request->dichvu ?? [];
        foreach ($services as $service_id) {
            Service::find($service_id);
            HistoryDetail::create([
                'history_id' => $id,
                'service_id' => $service_id,
                'price' => $request->tien
            ]);
        }

        if ($history->invoice) {
           foreach($history->historyDetails as $hd) {
                $total = $hd->price;
                $history->invoice->update([
                    'total_price' => $total,
                    'status' => $request->radioStatus ?? 'unpaid'
                ]);
           }
        }

        return back()->with('success', 'Cập nhật thành công');
    }


    public function destroy(Request $request, $id) {
        $history = History::findOrFail($id);
        $history->historyDetails()->delete();
        $history->invoice()->delete();
        $history->delete();
        return back()->with('success', 'Xóa thành công');
    }
}