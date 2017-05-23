<?php

namespace AwkwardIdeas\EloquentComposite\Relations;

class HasManyThroughOn extends \Illuminate\Database\Eloquent\Relations\HasManyThrough
{
    /**
     * The local key on the relationship.
     *
     * @var string
     */
    protected $throughKey;

    /**
     * Create a new has many through relationship instance.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Illuminate\Database\Eloquent\Model  $farParent
     * @param  \Illuminate\Database\Eloquent\Model  $throughParent
     * @param  string  $firstKey
     * @param  string  $secondKey
     * @param  string  $localKey
     * @return void
     */

    public function __construct(\Illuminate\Database\Eloquent\Builder $query, \Illuminate\Database\Eloquent\Model $farParent, \Illuminate\Database\Eloquent\Model $throughParent, $firstKey, $secondKey, $localKey, $throughKey)
    {
        $this->localKey = $localKey;
        $this->firstKey = $firstKey;
        $this->secondKey = $secondKey;
        $this->throughKey = $throughKey;
        $this->farParent = $farParent;
        $this->throughParent = $throughParent;

        parent::__construct($query, $farParent, $throughParent, $firstKey, $secondKey, $localKey);
    }

    /**
     * Set the join clause on the query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|null  $query
     * @return void
     */
    protected function performJoin(\Illuminate\Database\Eloquent\Builder $query = null)
    {
        $query = $query ?: $this->query;

        $farKey = $this->getQualifiedFarKeyName();

        $query->join($this->throughParent->getTable(), $this->throughParent->getTable() . '.' . $this->throughKey, '=', $farKey);

        if ($this->throughParentSoftDeletes()) {
            $query->whereNull($this->throughParent->getQualifiedDeletedAtColumn());
        }
    }
}
