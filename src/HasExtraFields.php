<?php

namespace Fahedaljghine\ExtraField;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasExtraFields
{
    public function extras(): Collection
    {
        return $this->getExtraModelClassName()::where($this->getModelClassColumnName(), get_class($this))
            ->get();
    }

    public function extraValues(): HasMany
    {
        return $this->hasMany($this->getExtraValueModelClassName(), $this->getModelIdColumnName())
            ->latest('id');
    }

    public function addExtraField(string $name, string $type)
    {
        $exist = $this->getExtraModelClassName()::where('name', $name)
            ->where('type', $type)
            ->where('model_class', get_class($this))
            ->first();

        if ($exist)
            return $exist;

        return $this->getExtraModelClassName()::create([
            'name' => $name,
            'type' => $type,
            'model_class' => get_class($this),
        ]);
    }

    public function addExtraValue(int $extra_id, string $value): self
    {
        $this->getExtraValueModelClassName()::create([
            'extra_id' => $extra_id,
            'model_id' => $this->id,
            'value' => $value,
        ]);

        return $this;
    }

    protected function getExtraValueTableName(): string
    {
        $modelClass = $this->getExtraValueModelClassName();

        return (new $modelClass)->getTable();
    }

    protected function getExtraTableName(): string
    {
        $modelClass = $this->getExtraModelClassName();

        return (new $modelClass)->getTable();
    }

    protected function getModelIdColumnName(): string
    {
        return config('extra-field.model_primary_key_attribute') ?? 'model_id';
    }

    protected function getModelClassColumnName(): string
    {
        return config('extra-field.model_name_attribute') ?? 'model_class';
    }

    protected function getExtraModelClassName(): string
    {
        return config('extra-field.extra_model');
    }

    protected function getExtraValueModelClassName(): string
    {
        return config('extra-field.extra_value_model');
    }
}
