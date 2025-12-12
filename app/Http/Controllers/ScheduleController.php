<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
        $weekOffset = (int) $request->get('week', 0);

        if ($request->filled('search_date') && !$request->has('week')) {
            $searchDate = Carbon::parse($request->search_date);
            $startOfWeek = $searchDate->startOfWeek();
            $endOfWeek   = $searchDate->copy()->endOfWeek();
        } else {
            $startOfWeek = Carbon::now()->startOfWeek()->addWeeks($weekOffset);
            $endOfWeek   = $startOfWeek->copy()->endOfWeek();
        }


        $weekDates = [];
        $currentDate = $startOfWeek->copy();
        while ($currentDate <= $endOfWeek) {
            $weekDates[] = $currentDate->copy();
            $currentDate->addDay();
        }

       
        $baseQuery = Schedule::with(['user', 'scheduletime']);

        

        // Lọc Bác sĩ
        if ($request->filled('ten_bac_si')) {
            $baseQuery->whereHas('user', function ($q) use ($request) {
                $q->where('fullname', 'like', '%' . $request->ten_bac_si . '%');
            });
        }

        // Lọc Ca làm việc
        if ($request->filled('caLamViec')) {
            $baseQuery->whereIn('schedule_time_id', $request->caLamViec);
        }

        // Lọc Trạng thái
        if ($request->filled('status')) {
            $baseQuery->where('status', $request->status);
        }

        
        $weekSchedules = $baseQuery->clone()
            ->whereBetween('date', [$startOfWeek->format('Y-m-d'), $endOfWeek->format('Y-m-d')])
            ->where('status', '!=', 'Đã hủy') 
            ->get();

        // Gom nhóm dữ liệu tuần
        $calendarData = [];
        foreach ($weekSchedules as $sche) {
            $calendarData[$sche->date][$sche->schedule_time_id][] = $sche;
        }

        //Gom dữ liệu theo ngày cụ thể
        $listQuery = $baseQuery->clone()->orderBy('schedule_id', 'desc');

        if ($request->filled('search_date')) {
            $listQuery->where('date', $request->search_date);
        }


        $schedule = $listQuery->get();

        $doctorList = User::select('fullname')->distinct()->get();

        // 5. TRẢ VỀ VIEW
        return view('QuanLyLichLamViec.index', compact(
            'schedule',      
            'calendarData',  
            'weekDates',
            'startOfWeek',
            'endOfWeek',
            'weekOffset',
            'doctorList'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            
            $doctor = User::where('fullname', $request->ten_bac_si)->first();
            if (!$doctor) {
                return redirect()->back()->with('error', 'Không tìm thấy bác sĩ có tên: ' . $request->ten_bac_si);
            }

            
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
            
            $conflictIds = [];

            if ($timeId == 3) {
                $conflictIds = [1, 2, 3]; 
            } elseif ($timeId == 1) {
                $conflictIds = [1, 3];
            } elseif ($timeId == 2) {
                $conflictIds = [2, 3];
            }
            $exists = Schedule::where('user_id', $doctor->user_id)
                ->where('date', $request->date)
                ->whereIn('schedule_time_id', $conflictIds)
                ->exists();

            if ($exists) {
                return redirect()->back()->with('error', 'Lịch làm việc này đã tồn tại.');
            }

            $statusText = 'Chờ duyệt';
            if ($request->status == '1') $statusText = 'Đã duyệt';
            if ($request->status == '2') $statusText = 'Chờ duyệt';
            if ($request->status == '3') $statusText = 'Đã hủy';

            // Lưu vào CSDL
            
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
       

        try {


            $schedule = Schedule::where('schedule_id', $id)->first();

            if (!$schedule) {
                return back()->with('error', 'Không tìm thấy lịch làm việc này.');
            }

            
            $doctor = User::where('fullname', $request->ten_bac_si)->first();
            if (!$doctor) {
                return back()->with('error', 'Không tìm thấy bác sĩ có tên: ' . $request->ten_bac_si);
            }

            
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
