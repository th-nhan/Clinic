<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        // 1. XỬ LÝ THỜI GIAN (TUẦN)
        $weekOffset = (int) $request->get('week', 0);
        
        // Nếu người dùng đang tìm kiếm theo 'search_date', hãy tự động nhảy tới tuần của ngày đó
        if ($request->filled('search_date') && !$request->has('week')) {
            $searchDate = Carbon::parse($request->search_date);
            $startOfWeek = $searchDate->startOfWeek();
            $endOfWeek   = $searchDate->copy()->endOfWeek();
            // (Tùy chọn: tính lại weekOffset nếu cần, nhưng để hiển thị thì start/end là đủ)
        } else {
            // Mặc định lấy theo tuần hiện tại + offset
            $startOfWeek = Carbon::now()->startOfWeek()->addWeeks($weekOffset);
            $endOfWeek   = $startOfWeek->copy()->endOfWeek();
        }

        $weekDates = [];
        $currentDate = $startOfWeek->copy();
        while ($currentDate <= $endOfWeek) {
            $weekDates[] = $currentDate->copy();
            $currentDate->addDay();
        }

        // 2. KHỞI TẠO QUERY CƠ BẢN (Dùng chung cho cả 2 bảng)
        $baseQuery = Schedule::with(['user', 'scheduletime']);

        // --- ÁP DỤNG BỘ LỌC CHUNG (Cho cả Tuần và Danh sách) ---
        
        // Lọc Bác sĩ
        if ($request->filled('ten_bac_si')) {
            $baseQuery->whereHas('user', function ($q) use ($request) {
                $q->where('fullname', 'like', '%' . $request->ten_bac_si . '%');
            });
        }

        // Lọc Ca làm việc
        if ($request->filled('caLamViec')) {
            $baseQuery->where('schedule_time_id', $request->caLamViec);
        }

        // Lọc Trạng thái
        if ($request->filled('status')) {
            $baseQuery->where('status', $request->status);
        }

        // 3. LẤY DỮ LIỆU CHO LỊCH TUẦN (GRID VIEW)
        // Clone baseQuery để không ảnh hưởng query dưới
        // Lịch tuần thì PHẢI giới hạn trong tuần đó (whereBetween)
        $weekSchedules = $baseQuery->clone()
            ->whereBetween('date', [$startOfWeek->format('Y-m-d'), $endOfWeek->format('Y-m-d')])
            ->where('status', '!=', 'Đã hủy') // Lịch tuần thường không hiện cái đã hủy cho đỡ rối
            ->get();

        // Gom nhóm dữ liệu tuần
        $calendarData = [];
        foreach ($weekSchedules as $sche) {
            $calendarData[$sche->date][$sche->schedule_time_id][] = $sche;
        }

        // 4. LẤY DỮ LIỆU CHO DANH SÁCH (LIST VIEW BÊN DƯỚI)
        // Clone baseQuery tiếp
        $listQuery = $baseQuery->clone()->orderBy('schedule_id', 'desc');

        // Riêng danh sách thì lọc thêm chính xác Ngày (nếu có)
        if ($request->filled('search_date')) {
            $listQuery->where('date', $request->search_date);
        }
        // Nếu có lọc tháng/năm thì thêm vào đây...

        $schedule = $listQuery->get();

        // 5. TRẢ VỀ VIEW
        return view('QuanLyLichLamViec.index', compact(
            'schedule',      // Dữ liệu danh sách
            'calendarData',  // Dữ liệu lịch tuần (Đã được lọc)
            'weekDates',
            'startOfWeek',
            'endOfWeek',
            'weekOffset'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ten_bac_si' => 'required|string',
            'date'       => 'required|date',
            'caLamViec'  => 'required',
            'status'     => 'required',
        ], [
            'ten_bac_si.required' => 'Vui lòng chọn bác sĩ.',
            'date.required'       => 'Vui lòng chọn ngày.',
        ]);


        try {
            // 2. Tìm User ID từ tên Bác sĩ
            $doctor = User::where('fullname', $request->ten_bac_si)->first();
            if (!$doctor) {
                return redirect()->back()->with('error', 'Không tìm thấy bác sĩ có tên: ' . $request->ten_bac_si);
            }

            // 3. Chuyển đổi 'ca1' -> 1
            $timeId = null;
            switch ($request->caLamViec) {
                case 'ca1':
                    $timeId = 1;
                    break;
                case 'ca2':
                    $timeId = 2;
                    break;
                case 'ca3':
                    $timeId = 3;
                    break;
                default:
                    $timeId = null;
            }
            if (!$timeId) {
                return redirect()->back()->with('error', 'Ca làm việc không hợp lệ.');
            }
            // 4. Kiểm tra trùng lịch (Bác sĩ + Ngày + Ca)
            $exists = Schedule::where('user_id', $doctor->user_id)
                ->where('date', $request->date)
                ->where('schedule_time_id', $timeId)
                ->exists();

            if ($exists) {
                return redirect()->back()->with('error', 'Lịch làm việc này đã tồn tại.');
            }

            $statusText = 'Chờ duyệt';
            if ($request->status == '1') $statusText = 'Đã duyệt';
            if ($request->status == '2') $statusText = 'Chờ duyệt';
            if ($request->status == '3') $statusText = 'Đã hủy';

            // 5. Lưu vào CSDL
            // Sử dụng new Schedule() để kiểm soát từng cột
            $schedule = new Schedule();
            $schedule->user_id          = $doctor->user_id;
            $schedule->schedule_time_id = $timeId;
            $schedule->date             = $request->date;
            $schedule->status           = $statusText;
            $schedule->createdBy        = Auth::id() ?? 1;
            $schedule->createdAt        = now();

            $schedule->save();

            return redirect()->back()->with('success', 'Thêm lịch thành công!');
        } catch (\Exception $e) {
            Log::error("Lỗi thêm lịch: " . $e->getMessage());
            // return response()->json(['success' => false, 'message' => 'Lỗi Server: ' . $e->getMessage()], 500);
            return redirect()->back()->with('error', 'Lỗi hệ thống: ' . $e->getMessage());
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'ten_bac_si' => 'required|string',
            'date'       => 'required|date',
            'caLamViec'  => 'required',
            'status'     => 'required',
        ]);

        try {


            $schedule = Schedule::where('schedule_id', $id)->first();

            if (!$schedule) {
                return back()->with('error', 'Không tìm thấy lịch làm việc này.');
            }

            // 2. Tìm User ID 
            $doctor = User::where('fullname', $request->ten_bac_si)->first();
            if (!$doctor) {
                return back()->with('error', 'Không tìm thấy bác sĩ có tên: ' . $request->ten_bac_si);
            }

            //Đổi ca
            $timeId = null;
            switch ($request->caLamViec) {
                case 'ca1':
                    $timeId = 1;
                    break;
                case 'ca2':
                    $timeId = 2;
                    break;
                case 'ca3':
                    $timeId = 3;
                    break;
                default:
                    $timeId = null;
            }
            if (!$timeId) {
                return back()->with('error', 'Ca làm việc không hợp lệ.');
            }
            // 4. Kiểm tra trùng lịch (Bác sĩ + Ngày + Ca)
            $exists = Schedule::where('user_id', $doctor->user_id)
                ->where('date', $request->date)
                ->where('schedule_time_id', $timeId)
                ->where('schedule_id', '!=', $id)
                ->where('status', '!=', 'Đã hủy')
                ->exists();

            if ($exists) {
                return back()->with('error', 'Lịch làm việc này đã tồn tại.');
            }

            // 5. Lưu vào CSDL


            $schedule->user_id          = $doctor->user_id;
            $schedule->schedule_time_id = $timeId;
            $schedule->date             = $request->date;
            $schedule->status           = $request->status;
            // $schedule->createdBy        = Auth::id() ?? 1;
            $schedule->createdAt        = now();

            $schedule->save();

            return back()->with('success', 'Cập nhật thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi cập nhật: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {

            $schedule = Schedule::where('schedule_id', $id)->first();

            if ($schedule) {
                $schedule->delete();
                return back()->with('success', 'Đã xóa thành công!');
            } else {
                return back()->with('error', 'Lỗi: Không tìm thấy lịch làm việc này.');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi hệ thống: ' . $e->getMessage());
        }
    }

    public function deleteMany(Request $request)
    {
        try {

            $idsString = $request->input('ids');

            if (empty($idsString)) {
                return back()->with('error', 'Chưa chọn lịch nào để xóa.');
            }


            $idsArray = explode(',', $idsString);


            Schedule::whereIn('schedule_id', $idsArray)->delete();

            return back()->with('success', 'Đã xóa ' . count($idsArray) . ' lịch thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi xóa nhiều: ' . $e->getMessage());
        }
    }
}
