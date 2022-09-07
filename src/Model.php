<?php

namespace AwkwardIdeas\EloquentComposite;

use Illuminate\Support\Facades\DB;
use AwkwardIdeas\EloquentComposite\Compoships;

abstract class Model extends \Illuminate\Database\Eloquent\Model
{
    use Compoships;
    use Database\Eloquent\Concerns\HasBelongsToManyThrough;

    /**
     * @var array $compositeKey Columns that make up the composite key
     */
    protected $compositeKey = [];

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