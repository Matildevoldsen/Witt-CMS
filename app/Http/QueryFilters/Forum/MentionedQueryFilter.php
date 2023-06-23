<?php

namespace App\Http\QueryFilters\Forum;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class MentionedQueryFilter implements Filter
{
    /**
     * @param Builder $query
     * @param $value
     * @param string $property
     * @return void
     */
    public function __invoke(Builder $query, $value, string $property)
    {
        if (!auth()->user()) {
            return;
        }

        $query->whereHas('posts', function (Builder $query) {
            $query->whereHas('mentions', function (Builder $query) {
                $query->where('user_id', auth()->user()->id);
            });
        });
    }
}
