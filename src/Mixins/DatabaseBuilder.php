<?php

namespace FaithGen\SDK\Mixins;

use Illuminate\Support\Str;

class DatabaseBuilder
{
    /**
     * Searches the database in an eloquent query for the given attributes.
     *
     * @return \Closure
     */
    public function search()
    {
        return function ($attributes, ?string $filter_text) {
            if ($filter_text) {
                $filter_text = '%'.$filter_text.'%';
            }

            if (is_string($attributes)) {
                return $this->where($attributes, 'LIKE', $filter_text);
            }

            if (is_array($attributes)) {
                $attributes = collect($attributes);

                $attribute = $attributes->first();

                $remainderKeys = $attributes->filter(fn ($field) => $field !== $attribute)->toArray();

                $query = $this->where($attribute, 'LIKE', $filter_text);

                if (count($remainderKeys)) {
                    foreach ($remainderKeys as $key) {
                        if (! Str::of($key)->contains('.')) {
                            $query->orWhere($key, 'LIKE', $filter_text);
                        } else {
                            [$relationship, $column] = explode('.', $key);

                            // $eloquentBuilder->orWhereHas($relationship, fn($model) => $model->where($column, 'LIKE', $filter_text));
                        }
                    }
                }

                return $query;
            } else {
                abort(402, 'Invalid search fields');
            }
        };
    }
}
