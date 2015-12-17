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
use Illuminate\Support\Collection;

abstract class Relatable extends Model
{

    protected $referenceClass = 'App\Relatable';

    public function fillRelations(){

        $relations = array();

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
        ->orderBy('source_type','sibling_type')
        ->get();

        foreach($Results as $Result){
            //If this class is source
            if($Result->source_type == $this->referenceClass){
                $sibling = $Result->sibling_type;
                $relations[$Result->sibling_type][] = $sibling::find($Result->sibling_id);

            } else {
            //If this class is sibling
                $source = $Result->source_type;
                $relations[$Result->source_type][] = $source::find($Result->source_id);
            }
        }

        //Now set the relations
        if(count($relations) > 0){
            $this->setRelations([
                'relationships'=> collect($relations),
            ]);
        }
    }
}