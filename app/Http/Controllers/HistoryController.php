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

        $query = History::with(relations: ['Customer', 'User', 'Invoice', 'historyDetails.service', 'historyDetails']);

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
        $histories = $query->get();
        $users = User::all();
        $services = Service::all();
        $customers = Customer::all();
        return view('QuanLyLichSu.index', compact('histories','users','services', 'customers'));
    }

    public function store(Request $request) {
        $existingCustomer = Customer::where('contact_number', $request->sodienthoai)->first();

        if ($existingCustomer) {
            return back()->with('error', 'Số điện thoại này đã tồn tại!');
        }
        $customer = Customer::create([
            'fullname' => $request->khachhang,
            'contact_number' => $request->sodienthoai
        ]);
        $history = history::create([
            'customer_id' => $customer->customer_id,
            'user_id' => $request->bacsi,
            'date' => $request->ngaykham,
            'time' => $request->giohen
        ]);
        $services = is_array($request->dichvu) ? $request->dichvu : [$request->dichvu];

        foreach ($services as $service_id) {
            $history_detail = HistoryDetail::create([
                'history_id' => $history->history_id,
                'service_id' => $service_id,
                'price' => $request->tien
            ]);
        }

        Invoice::create([
            'history_id'  => $history->history_id,
            'user_id'     => $request->bacsi,
            'total_price' => $history_detail->price ?? $request->tien,
            'method_payment' => 'momo',
            'status' => $request->radioStatus ?? 'unpaid'
        ]);

        return back()->with('success','Thêm thành công');
    }

    public function update(Request $request, $id)
    {
        $history = History::findOrFail($id);
        $customer = $history->customer;

        $customer->update([
            'fullname' => $request->khachhang,
            'contact_number' => $request->sodienthoai
        ]);

        $history->update([
            'customer_id' => $customer->customer_id,
            'user_id' => $request->bacsi,
            'date' => $request->ngaykham,
            'time' => $request->giohen
        ]);

        HistoryDetail::where('history_id', $id)->delete();
        $services = $request->dichvu ?? [];
        foreach ($services as $service_id) {
            $service = Service::find($service_id);
            HistoryDetail::create([
                'history_id' => $id,
                'service_id' => $service_id,
                'price' => $request->tien
            ]);
        }

        if ($history->invoice) {
            $total = $history->historyDetails->sum('price');
            $history->invoice->update([
                'total_price' => $total,
                'status' => $request->radioStatus ?? 'unpaid'
            ]);
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