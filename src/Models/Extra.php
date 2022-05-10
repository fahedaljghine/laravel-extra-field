<?php

namespace Fahedaljghine\ExtraField;

use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{
    protected $guarded = [];

    protected $table = 'extras';

    public function extraValues()
    {
        return $this->hasMany(ExtraValue::class);
    }
}
