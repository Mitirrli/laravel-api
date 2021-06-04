<?php

namespace App\Models;

use App\Traits\UseUuidAsPrimaryKey;

class Demo extends BaseModel
{
    use UseUuidAsPrimaryKey;

    protected $table = 'demo';

    protected $primaryKey = 'id';

    protected $dateFormat = 'U';

    protected $fillable = ['int', 'char'];
}
