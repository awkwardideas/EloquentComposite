<?php

namespace AwkwardIdeas\EloquentComposite\Concerns;

trait HasManyThroughOn
{

    /**
     * Define a has-many-through relationship.
     *
     * @param  string  $related
     * @param  string  $through
     * @param  string|null  $firstKey
     * @param  string|null  $secondKey
     * @param  string|null  $localKey
     * @return \AwkwardIdeas\EloquentComposite\Relations\HasManyThroughOn
     */
    public function hasManyThroughOn($related, $through, $firstKey = null, $secondKey = null, $localKey = null, $throughKey = null)
    {
        $through = new $through;

        $firstKey = $firstKey ?: $this->getForeignKey();

        $secondKey = $secondKey ?: $through->getForeignKey();

        $localKey = $localKey ?: $this->getKeyName();

        $throughKey = $throughKey ?: $this->getKeyName();

        $instance = $this->newRelatedInstance($related);

        return new \AwkwardIdeas\EloquentComposite\Relations\HasManyThroughOn($instance->newQuery(), $this, $through, $firstKey, $secondKey, $localKey, $throughKey);
    }
}
