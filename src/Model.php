<?php

namespace AwkwardIdeas\EloquentComposite;

use Illuminate\Database\Eloquent\Builder;
use DB;

class Model extends \Illuminate\Database\Eloquent\Model
{

    protected function UpdateWithComposite($field){
        $query = DB::connection($this->connection)->table($this->table);

        foreach($this->compositeKey as $key){
            $query->where($key, $this[$key]);
        }
        $query->update([
            $field=>$this[$field]
        ]);
    }
}