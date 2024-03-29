<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServerRoomLog;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use stdClass;

class ServerLogController extends Controller
{
    const LOG_STATUS_SHOW = 1;
    const LOG_STATUS_HIDE = 0;
    const DATA_PER_PAGE = 5;

    // 新增機房日誌
    public function createLog(Request $request)
    {
        $request->dd();
        try
        {
            $validated = $request->validate([
                'maintain_type' => 'required|integer',
                'maintain_man' => 'required|string',
                'maintain_date' => 'required|string',
                'entrance_time' => 'required|string',
                'exit_time' => 'required|string',
                'work_desc' => 'required|string',
            ]);

            if(!preg_match('/\d{2}\:\d{2}/', $validated['entrance_time'])) {
                // throw new Exception('error', 400);
            }

            if(!preg_match('\d{2}\:\d{2}', $validated['exit_time'])) {
                // throw new Exception('error', 400);
            }

            $seq_number = $this->getSequenceNo();

            $server_log = new ServerRoomLog();

            $server_log->login_user_id = 5;
            $server_log->server_log_id = $seq_number;
            $server_log->maintain_man = $validated['maintain_man'];
            $server_log->log_status = 1;
            $server_log->types = $validated['maintain_type'];
            $server_log->maintain_description = $validated['work_desc'];
            $server_log->remark = '';
            $server_log->maintain_date = $validated['maintain_date'];
            $server_log->enter_time = $validated['entrance_time'];
            $server_log->exit_time = $validated['exit_time'];

            $server_log->save();

            return redirect()->route('log_list', ['create_success' => '新增成功']);
        }
        catch (Exception $e)
        {
            abort($e->getCode(), $e->getMessage());
        }
    }

    // 顯示機房日誌列表
    public function showLogList(Request $request)
    {
        $count = self::DATA_PER_PAGE;
        if(isset($_GET['count'])) {
            $count = $request['count'];
        }

        $server_log = ServerRoomLog::where('log_status', self::LOG_STATUS_SHOW)
                    ->orderByDesc('created_at')
                    ->paginate($count);
                    // ->get();
                    
        $server_log = $server_log->toArray();

        $response = [];
        $response['lists'] = $server_log['data'];
        $response['from'] = $server_log['from'];
        $response['total'] = $server_log['total'];
        $response['count'] = $count; // 每頁顯示幾筆
        $response['current_page'] = $server_log['current_page'];
        $response['last_page'] = $server_log['last_page'];

        if (isset($request['create_success'])) {
            $response['create_success'] = $request['create_success'];
        }

        return view('log.list', $response);
    }

    public function showSingleLog($log_id)
    {
        $log = ServerRoomLog::where('server_log_id', $log_id)->get();

        $log = $log->toArray()[0];

        $response = [];
        $response['type'] = 'single';
        $response['title'] = $log_id;
        $response['data'] = $log;

        return view('log.form', $response);
    }

    public function searchLogList(Request $request)
    {
        $validated = $request->validate([
            'keyword' => 'string',
            'maintain_date' => 'string',
        ]);

        $logs = DB::table('server_room_log');

        if(isset($validated['keyword'])) {
            $logs->where('server_log_id', $validated['keyword'])
                    ->orWhere('maintain_man', 'like', $validated['keyword']);
        }

        if(isset($validated['maintain_date'])) {
            $logs->where('maintain_date', $validated['maintain_date']);
        }

        $logs = $logs->get();

        $logs->dd();


    }

    public function editSingleLog($log_id)
    {
        $log = ServerRoomLog::where('server_log_id', $log_id)->get();

        $log = $log->toArray()[0];

        $response = [];
        $response['type'] = 'edit';
        $response['id'] = $log_id;
        $response['title'] = '編輯' . $log_id;
        $response['data'] = $log;

        return view('log_form', $response);
    }

    public function saveSingleLog($log_id, Request $request)
    {
        $validated = $request->validate([
            'maintain_type' => 'required|integer',
            'maintain_man' => 'required|string',
            'maintain_date' => 'required|string',
            'entrance_time' => 'required|string',
            'exit_time' => 'required|string',
            'work_desc' => 'required|string',
        ]);

        $data = [];
        $data['maintain_man'] = $validated['maintain_man'];
        $data['types'] = $validated['maintain_type'];
        $data['maintain_date'] = $validated['maintain_date'];
        $data['enter_time'] = $validated['entrance_time'];
        $data['exit_time'] = $validated['exit_time'];
        $data['maintain_description'] = $validated['work_desc'];

        ServerRoomLog::where('server_log_id', $log_id)
                        ->update($data);

        return redirect()->route('log_list', ['create_success' => '修改成功']);
    }

    public function deleteSingleLog($log_id)
    {
        // dd($log_id);
        ServerRoomLog::where('server_log_id', $log_id)
                        ->update(['log_status' => 0]);
        // return redirect()->route('log_list', ['create_success' => '刪除成功']);

    }

    protected function getSequenceNo()
    {

        $today = date('Ymd');
        $latestLog = ServerRoomLog::orderBy('created_at', 'DESC')->first();

        if (!$latestLog) {
            $latestLog = new stdClass();
            $latestLog->id = 0;
        }

        return $today . str_pad($latestLog->id + 1, 4, "0", STR_PAD_LEFT);
    }

}
