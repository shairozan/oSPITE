<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/5/15
 * Time: 11:49 AM
 */

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model as Model;
use App\Relationship;

abstract class Relatable extends Model
{

    protected $referenceClass = 'App\Relatable';

    public function fillRelations(){
        //First we will locate all references in relationships
        //Both source and destination for this class

        $Results = Relationship::where(function($query)  {
            $query->where('source_type',$this->referenceClass);
            $query->where('source_id', $this->id);
        })
        ->orWhere(function($query) {
            $query->where('sibling_type',$this->referenceClass);
            $query->where('sibling_id',$this->id);
        })
        ->get();

        dd($Results);
    }
}