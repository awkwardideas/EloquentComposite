<?php

namespace AwkwardIdeas\EloquentComposite;

use DB;
use Illuminate\Database\Eloquent\Builder;
use AwkwardIdeas\EloquentComposite\Compoships;

abstract class Model extends \Illuminate\Database\Eloquent\Model
{
    use Compoships;
    use Database\Eloquent\Concerns\HasBelongsToManyThrough;

    protected function UpdateWithComposite($field = null)
    {
        $query = DB::connection($this->connection)->table($this->table);

        foreach ($this->compositeKey as $key) {
            $query->where($key, $this[$key]);
        }
        if (!is_null($field)) {
            $query->update([
                $field => $this[$field]
            ]);
        } else {
            $updateColumns = [];
            foreach ($this->fillable as $column) {
                $updateColumns[$column] = $this[$column];
            }

            $query->update([
                $field => $this[$field]
            ]);
        }
    }
}