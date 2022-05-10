<?php

namespace Fahedaljghine\ExtraField;

use Illuminate\Database\Eloquent\Model;

class ExtraValue extends Model
{
    protected $guarded = [];

    protected $table = 'extra_values';

    public function extra()
    {
        return $this->belongsTo(Extra::class);
    }

    public function model()
    {
        return $this->belongsTo($this->extra->model);
    }
}
