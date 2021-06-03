<?php

namespace App\Models;

use App\Traits\Filterable;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use Cachable;
    use Filterable;
    use HasFactory;
}
