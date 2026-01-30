<?php

use Illuminate\Database\Eloquent\Model;
use App\Models\AdminActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

if (!function_exists('admin_log')) {
    function admin_log(
        string $aksi,
        string $keterangan,
        ?Model $model = null
    ) {
        if (!Auth::check()) {
            return;
        }

        AdminActivityLog::create([
            'admin_id' => Auth::id(),
            'aksi' => $aksi,
            'model' => $model ? get_class($model) : null,
            'model_id' => $model?->id,
            'keterangan' => $keterangan,
            'ip' => Request::ip(),
        ]);
    }
}
