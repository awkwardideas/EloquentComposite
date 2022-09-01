<?php

namespace AwkwardIdeas\EloquentComposite\Database\Eloquent\Concerns;

use AwkwardIdeas\EloquentComposite\Database\Eloquent\Relations\BelongsToManyThrough;

trait HasBelongsToManyThrough
{
    /**
     * Define a many-to-many on relationship.
     *
     * @param  string  $related
     * @param  string  $through
     * @param  string  $table
     * @param  string  $foreignKey
     * @param  string  $relatedKey
     * @param  string  $relation
     * @return \AwkwardIdeas\EloquentComposite\Database\Eloquent\Relations\BelongsToManyThrough
     */
    public function belongsToManyThrough($related, $through, $table = null, $foreignKey = null, $relatedKey = null, $farKey=null, $parentKey = null, $relation = 'belongsToManyThrough')
    {
        // If no relationship name was passed, we will pull backtraces to get the
        // name of the calling function. We will use that function name as the
        // title of this relation since that is a great convention to apply.
        if (is_null($relation)) {
            $relation = $this->guessBelongsToManyRelation();
        }

        // First, we'll need to determine the foreign key and "other key" for the
        // relationship. Once we have determined the keys we'll make the query
        // instances as well as the relationship instances we need for this.
        $instance = $this->newRelatedInstance($related);

        $instanceFar = $this->newRelatedInstance($through);

        $foreignKey = $foreignKey ?: $this->getForeignKey();

        $relatedKey = $relatedKey ?: $instance->getForeignKey();

        $farKey = $farKey ?: $instance->getKeyName();

        $parentKey = $parentKey ?: $this->getKeyName();

        // If no table name was provided, we can guess it by concatenating the two
        // models using underscores in alphabetical order. The two model names
        // are transformed to snake case from their default CamelCase also.
        if (is_null($table)) {
            $table = $this->joiningTable($related);
        }

        return new BelongsToManyThrough(
            $instance->newQuery(), $this, $instanceFar, $table, $foreignKey, $relatedKey, $farKey, $parentKey, $relation
        );
    }
}
