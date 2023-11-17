<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServerRoomLog;
use stdClass;

class ServerLogController extends Controller
{
    //
    public function createLog (Request $request)
    {
        // $request->dd();
        
        $validated = $request->validate([
            'maintain_type' => 'required|integer',
            'maintain_man' => 'required|string',
            'maintain_date' => 'required|string',
            'entrance_time' => 'required|string',
            'exit_time' => 'required|string',
            'work_desc' => 'required|string',
        ]);

        $server_log = new ServerRoomLog();

        $server_log->login_user_id = 5;
        $server_log->maintain_number = 123;
        $server_log->maintain_man = $validated['maintain_man'];
        $server_log->status = 1;
        $server_log->types = $validated['maintain_type'];
        $server_log->maintain_description = $validated['work_desc'];
        $server_log->remark = '';
        $server_log->enter_time = $validated['maintain_date'] . ' ' .$validated['entrance_time'];
        $server_log->exit_time = $validated['maintain_date'] . ' ' .$validated['exit_time'];

        $server_log->save();

        return url('greet');
    }

    public function showLogList () {
        $server_log = ServerRoomLog::orderByDesc('created_at')
                                    ->get();

        return view('log_list', ['lists' => $server_log]);
    }

    public function showSingleLog () {
        
    }
}
