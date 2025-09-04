<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class FavoriteFilter
{
    protected $builder;
    protected $filters = ['search', 'name', 'description'];

    public function apply(Builder $builder, array $filters): Builder
    {
        $this->builder = $builder;

        foreach ($filters as $name => $value) {
            if (!method_exists($this, $name) || !$value) {
                continue;
            }
            
            $this->$name($value);
        }

        return $this->builder;
    }

    protected function search(string $search): void
    {
        $this->builder->where(function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        });
    }

    protected function name(string $name): void
    {
        $this->builder->where('name', 'like', "%{$name}%");
    }

    protected function description(string $description): void
    {
        $this->builder->where('description', 'like', "%{$description}%");
    }
}
