<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Watson\Validating\ValidatingTrait;

class BaseModel extends Model
{
    use Filterable;
    use HasFactory;
    use ValidatingTrait;

    public const CREATED_AT = 'create_time';
    public const UPDATED_AT = 'update_time';
    public const DELETED_AT = 'delete_time';

    /**
     * The default rules that the model will validate against.
     *
     * @var array
     */
    protected $rules = [];
}
