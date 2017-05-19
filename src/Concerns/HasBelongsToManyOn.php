<?php

namespace AwkwardIdeas\EloquentComposite\Concerns;

use AwkwardIdeas\EloquentComposite\Relations\BelongsToManyOn;

trait HasBelongsToManyOn
{
    /**
     * Define a many-to-many on relationship.
     *
     * @param  string  $related
     * @param  string  $table
     * @param  string  $foreignKey
     * @param  string  $relatedKey
     * @param  string  $relation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToManyOn
     */
    public function belongsToManyOn($related, $table = null, $foreignKey = null, $relatedKey = null, $localKey = null, $relation = 'belongsToManyOn')
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

        $foreignKey = $foreignKey ?: $this->getForeignKey();

        $relatedKey = $relatedKey ?: $instance->getForeignKey();

        // If no table name was provided, we can guess it by concatenating the two
        // models using underscores in alphabetical order. The two model names
        // are transformed to snake case from their default CamelCase also.
        if (is_null($table)) {
            $table = $this->joiningTable($related);
        }

        return new BelongsToManyOn(
            $instance->newQuery(), $this, $table, $foreignKey, $relatedKey, $localKey, $relation
        );
    }
}
