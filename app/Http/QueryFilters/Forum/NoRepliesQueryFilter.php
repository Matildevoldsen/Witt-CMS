<?php

namespace App\Http\QueryFilters\Forum;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class NoRepliesQueryFilter implements Filter
{
    /**
     * @param Builder $query
     * @param $value
     * @param string $property
     * @return void
     */
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->has('posts', '=', 1);
    }
}
