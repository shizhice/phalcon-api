<?php
/**
 * Created by PhpStorm.
 * User: shizhice
 * Date: 2018/5/22
 * Time: 下午4:25
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractModel extends Model
{
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
}