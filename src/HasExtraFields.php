<?php

namespace Fahedaljghine\ExtraField;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasExtraFields
{

    public function getExtras(): array
    {
        $extras = [];
        foreach ($this->extraValues as $extraValue) {
            $extras[$extraValue->extra->name] = $extraValue->value;
        }

        return $extras;
    }

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
        $extra_field = $this->getExtraModelClassName()::where('name', $name)
            ->where('type', $type)
            ->where('model_class', get_class($this))
            ->first();

        if ($extra_field)
            return $extra_field;

        return $this->getExtraModelClassName()::create([
            'name' => $name,
            'type' => $type,
            'model_class' => get_class($this),
        ]);
    }

    public function dropExtraFieldData(string $name): self
    {
        $extra_field = $this->getExtraModelClassName()::where('name', $name)
            ->where('model_class', get_class($this))
            ->first();

        if ($extra_field) {
            $this->getExtraValueModelClassName()
                ::where('extra_id', $extra_field->id)
                ->where('model_id', $this->id)
                ->delete();

          //  $extra_field->delete();
        }

        return $this;
    }

    public function dropExtraField(string $name): self
    {
        $extra_field = $this->getExtraModelClassName()::where('name', $name)
            ->where('model_class', get_class($this))
            ->first();

        if ($extra_field) {
            $this->getExtraValueModelClassName()
                ::where('extra_id', $extra_field->id)
                ->delete();

              $extra_field->delete();
        }

        return $this;
    }

    public function updateExtraValue(string $extra_field, string $value): self
    {
        $extra_field = $this->getExtraModelClassName()::where('name', $extra_field)
            ->where('model_class', get_class($this))
            ->first();

        if ($extra_field) {
            $extra_value = $this->getExtraValueModelClassName()::where('extra_id', $extra_field->id)
                ->first();
            if ($extra_value) {
                $extra_value->value = $value;
                $extra_value->save();
            }
        }

        return $this;
    }

    public function addStringExtraValue(string $extra_field, string $value): self
    {
        $extra_field = $this->getExtraModelClassName()::where('name', $extra_field)
            ->where('model_class', get_class($this))
            ->first();

        if (is_null($extra_field)) {
            $extra_field = $this->getExtraModelClassName()::where('name', $extra_field)
                ->where('type', "string")
                ->where('model_class', get_class($this))
                ->first();
        }

        $this->getExtraValueModelClassName()::create([
            'extra_id' => $extra_field->id,
            'model_id' => $this->id,
            'value' => $value,
        ]);

        return $this;
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
