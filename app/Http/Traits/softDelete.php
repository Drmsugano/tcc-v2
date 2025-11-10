<?php

namespace App\Http\Traits;

trait softDelete
{
    public static function softDelete($model, $id)
    {
        $record = $model::where('PUBLIC_ID', $id)->first();
        if ($record) {
            $record->IS_DELETED = 1;
            $record->save();
            return true;
        }
        return false;
    }
}
