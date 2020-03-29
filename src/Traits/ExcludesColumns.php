<?php

namespace FaithGen\SDK\Traits;

trait ExcludesColumns
{
    /**
     * Excludes some columns from a query.
     *
     * @param $query
     * @param array $columns
     * @return mixed
     */
    public function scopeExclude($query, array $columns = [])
    {
        $tableColumns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());

        $requiredColumns = collect($tableColumns)->filter(fn($column) => !in_array($column, $columns))->toArray();

        return $query->select($requiredColumns);
    }
}
