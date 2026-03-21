<?php

namespace App\Services;

use App\Models\Log;
use Illuminate\Database\Eloquent\Model;

class LogService
{
    public static function log(string $action, Model $model, ?array $data = null, ?int $userId = null, ?string $detail = null): Log
    {
        $userId = $userId ?? auth()->id();

        return Log::create([
            'user_id' => $userId,
            'action' => $action,
            'model' => get_class($model),
            'model_id' => $model->id,
            'data' => $data,
            'detail' => $detail,
        ]);
    }

    public static function logCreate(Model $model, ?int $userId = null, ?string $detail = null): Log
    {
        return self::log(
            'create_' . strtolower(class_basename($model)),
            $model,
            $model->toArray(),
            $userId,
            $detail
        );
    }

    public static function logUpdate(Model $model, array $changes, ?int $userId = null, ?string $detail = null): Log
    {
        // Log only the attributes that have actually changed.
        return self::log(
            'update_' . strtolower(class_basename($model)),
            $model,
            [
                'before' => collect($model->getOriginal())->only(array_keys($changes))->all(),
                'after' => $changes,
            ],
            $userId,
            $detail
        );
    }

    public static function logDelete(Model $model, ?int $userId = null, ?string $detail = null): Log
    {
        return self::log(
            'delete_' . strtolower(class_basename($model)),
            $model,
            $model->toArray(),
            $userId,
            $detail
        );
    }
}
