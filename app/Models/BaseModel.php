<?php

namespace App\Models;

use App\Traits\Filterable;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Watson\Validating\ValidatingTrait;

class BaseModel extends Model
{
    use Cachable;
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

    /**
     * trait与class属性冲突 使用方法引入.
     *
     * 共用的trait需要包含_init方法引入变量
     */
    public function __construct()
    {
        parent::__construct();

        if (\method_exists($this, '_init')) {
            $this->_init();
        }
    }
}
