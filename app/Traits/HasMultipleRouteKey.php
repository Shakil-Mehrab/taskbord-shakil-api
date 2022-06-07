<?php

namespace App\Traits;

use Illuminate\Support\Facades\Schema;

trait HasMultipleRouteKey
{
    /**
     * Map the extra route bindings key if define in model class
     *
     * @return array
     */
    protected function getBindingKeys()
    {
        return property_exists($this, 'routeBindingKeys') && is_array($this->routeBindingKeys)
            ? $this->routeBindingKeys
            : [];
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'id';
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed        $value
     * @param  string|null  $field
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {

        if ($field && !is_null($field)) {
            return $this->newQuery()->where($field, $value)->first();
        }

        $bindingKeys = $this->getBindingKeys();

        $query = $this->newQuery()->where($this->getRouteKeyName(), $value);

        $modelTableName = $this->getTable();

        foreach ($bindingKeys as $bindingKey) {
            if (Schema::hasColumn($modelTableName, $bindingKey)) {
                $query = $query->orWhere($bindingKey, $value);
            }
        }

        return $query->first();
    }
}