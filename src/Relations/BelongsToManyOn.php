<?php

namespace AwkwardIdeas\EloquentComposite\Relations;

class BelongsToManyOn extends \Illuminate\Database\Eloquent\Relations\BelongsToMany
{

    /**
     * The associated key on the parent model.
     *
     * @var string
     */
    protected $localKey;

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
    public function __construct(\Illuminate\Database\Eloquent\Builder $query, \Illuminate\Database\Eloquent\Model $parent, $table, $foreignKey, $relatedKey, $localKey, $relationName = null)
    {
        $this->localKey = $localKey;

        parent::__construct($query, $parent, $table, $foreignKey, $relatedKey, $relationName);
    }

    /**
     * Set the where clause for the relation query.
     *
     * @return $this
     */
    protected function addWhereConstraints()
    {
        $this->query->where(
            $this->getQualifiedForeignKeyName(), '=', $this->parent->{$this->localKey}
        );

        return $this;
    }
}
