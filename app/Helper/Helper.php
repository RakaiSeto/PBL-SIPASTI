<?php

namespace App\Helper;

use App\Models\t_activity_log;
use Illuminate\Support\Facades\Log;

class Helper
{
    public static function logging($username, $module, $action, $description)
    {
        $log = new t_activity_log();
        $log->username = $username;
        $log->module = $module;
        $log->action = $action;
        $log->description = $description;
        $log->save();

        Log::info(json_encode($log));
    }

    public static function getUsername($request)
    {
        if ($request->user()) {
            return $request->user()->username;
        }
        return 'Anon';
    }
}