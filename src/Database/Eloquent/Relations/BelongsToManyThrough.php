<?php

namespace AwkwardIdeas\EloquentComposite\Database\Eloquent\Relations;

class BelongsToManyThrough extends \Illuminate\Database\Eloquent\Relations\BelongsToMany
{

    /**
     * The associated key on the parent model.
     *
     * @var string
     */
    protected $farKey;

    /**
     * The first intermediate table for the relation.
     *
     * @var string
     */
    protected $through;



    /**
     * Create a new belongs to many relationship instance.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Illuminate\Database\Eloquent\Model  $parent
     * @param  string  $table
     * @param  string  $foreignKey
     * @param  string  $relatedKey
     * @param  string  $relationName
     * @return void
     */
    public function __construct(\Illuminate\Database\Eloquent\Builder $query, \Illuminate\Database\Eloquent\Model $parent, \Illuminate\Database\Eloquent\Model $through, $table, $foreignPivotKey, $relatedPivotKey, $farKey, $parentKey, $relationName = null)
    {
        $this->farKey = $farKey;
        $this->through = $through;

        parent::__construct($query, $parent, $table, $foreignPivotKey, $relatedPivotKey, $parentKey, $relationName);
    }

    /**
     * Set the join clause for the relation query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|null  $query
     * @return $this
     */
    protected function performJoin($query = null)
    {
        $query = $query ?: $this->query;

        $baseTable = $this->related->getTable();

        $throughTable = $this->through->getTable();

        $throughKey = $throughTable . '.' . $this->farKey;

        $key = $baseTable.'.'.$this->farKey;

        $query->join($throughTable, $throughKey, '=', $key);

        // We need to join to the intermediate table on the related model's primary
        // key column with the intermediate table's foreign key for the related
        // model instance. Then we can set the "where" for the parent models.


        $key = $throughTable.'.'.$this->relatedPivotKey;
        $relatedKey = $this->table . '.' . $this->relatedPivotKey;

        $query->join($this->table, $key, '=', $relatedKey);

        return $this;
    }
}
