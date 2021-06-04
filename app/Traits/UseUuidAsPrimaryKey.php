<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait UseUuidAsPrimaryKey
{
    public static function bootUseUuidAsPrimaryKey() //: void
    {
        static::creating(function (self $model): void {
            /* @var \Illuminate\Database\Eloquent\Model|\App\Traits\UseUuidAsPrimaryKey $model */
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::orderedUuid()->toString();
            }
        });
    }

    /**
     * @return bool
     */
    public function getIncrementing(): bool
    {
        return false;
    }

    /**
     * @return string
     */
    public function getKeyType(): string
    {
        return 'string';
    }
}
