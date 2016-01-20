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
            if($Result->source_type == $this->referenceClass && $Result->source_id == $this->id){
                $sibling = $Result->sibling_type;
                $so = $sibling::find($Result->sibling_id);

                if( ($so->restricted == 1 && \Session::get('dm') == 1 ) || $so->restricted == 0    )

                $relations[$Result->sibling_type][] = $sibling::find($Result->sibling_id);

            } else {
            //If this class is sibling
                $source = $Result->source_type;
                $so = $source::find($Result->source_id);

                if( ( $so->restricted == 1 && \Session::get('dm') == 1 ) || $so->restricted == 0  )
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


    static function listAllCampaignObjectsOfType($object){
        //$object is any relatable object

        $source_collection = \DB::table('relationships')
            ->select('source_id')
            ->where('source_type',get_class($object))
            ->where('campaign_id',\Session::get('campaign')->id)
            ->get();

        if(count($source_collection) > 0){
            foreach ($source_collection as $s) {
                $ids[] = $s->source_id;
            }
        }

        $sibling_collection = \DB::table('relationships')
            ->select('sibling_id')
            ->where('sibling_type',get_class($object))
            ->where('campaign_id',\Session::get('campaign')->id)
            ->get();


        if(count($sibling_collection) > 0){
            foreach($sibling_collection as $s){
                $ids[] = $s->sibling_id;
            }
        }

        //Unique array values only
        $ids = array_unique($ids);

        $return_value = \DB::table($object->getTable())
            ->whereIn('id',$ids);

        return $return_value;
    }

    public function removeCampaignMembership(){

        $relationship = Relationship::where(function($query){
            $query->where('source_type',$this->referenceClass);
            $query->where('source_id', $this->id);
            $query->where('sibling_type','App\\Campaign');
            $query->where('sibling_id',\Session::get('campaign')->id);
        })
        ->orWhere(function($query){
            $query->where('sibling_type',$this->referenceClass);
            $query->where('sibling_id', $this->id);
            $query->where('source_type','App\\Campaign');
            $query->where('source_id',\Session::get('campaign')->id);
        })
        ->first();

        $relationship->delete();
    }

}