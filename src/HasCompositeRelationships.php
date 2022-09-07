<?php

namespace AwkwardIdeas\EloquentComposite;

use AwkwardIdeas\EloquentComposite\Database\Eloquent\Concerns\HasRelationships;
use AwkwardIdeas\EloquentComposite\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Str;

//https://github.com/topclaudy/compoships

trait HasCompositeRelationships
{
    use HasRelationships;

    public function getAttribute($key)
    {
        if (is_array($key)) { //Check for multi-columns relationship
            return array_map(function ($k) {
                return parent::getAttribute($k);
            }, $key);
        }

        return parent::getAttribute($key);
    }

    public function qualifyColumn($column)
    {
        if (is_array($column)) { //Check for multi-column relationship
            return array_map(function ($c) {
                if (Str::contains($c, '.')) {
                    return $c;
                }

                return $this->getTable().'.'.$c;
            }, $column);
        }

        return parent::qualifyColumn($column);
    }

    /**
     * Configure Eloquent to use Compoships Query Builder.
     *
     * @return \AwkwardIdeas\EloquentComposite\Database\Query\Builder|static
     */
    protected function newBaseQueryBuilder()
    {
        $connection = $this->getConnection();

        return new QueryBuilder($connection, $connection->getQueryGrammar(), $connection->getPostProcessor());
    }
}
