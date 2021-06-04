<?php

namespace App\Models;

class Demo extends BaseModel
{
    protected $table = 'demo';

    protected $primaryKey = 'id';

    protected $dateFormat = 'U';

    protected $fillable = ['int', 'char'];
}
