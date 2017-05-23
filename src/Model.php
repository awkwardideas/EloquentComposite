<?php

namespace AwkwardIdeas\EloquentComposite;

use Illuminate\Database\Eloquent\Builder;
use DB;

abstract class Model extends \Illuminate\Database\Eloquent\Model
{
    use Concerns\HasBelongsToManyOn;
    use Concerns\HasManyThroughOn;
    use Concerns\HasBelongsToManyThrough;

    protected function UpdateWithComposite($field=null){
        $query = DB::connection($this->connection)->table($this->table);

        foreach($this->compositeKey as $key){
            $query->where($key, $this[$key]);
        }
        if(!is_null($field)){
            $query->update([
                $field=>$this[$field]
            ]);
        }else{
            $updateColumns = [];
            foreach($this->fillable as $column){
                $updateColumns[$column] = $this[$column];
            }

            $query->update([
                $field=>$this[$field]
            ]);
        }
    }
}