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
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
        $oc = get_class($object);
        //Are we DM or not


            $source_collection = \DB::table('relationships')
                ->select('source_id')
                ->where('source_type', get_class($object))
                ->where('campaign_id', \Session::get('campaign')->id)
                ->get();


        if(count($source_collection) > 0){
            foreach ($source_collection as $s) {
                //Only allow permitted objects

                $so = $oc::find($s->source_id);
                if( ($so->restricted == 1 && \Session::get('dm') == 1 ) || $so->restricted == 0   ) {
                    $ids[] = $s->source_id;
                }
            }
        }

        $sibling_collection = \DB::table('relationships')
            ->select('sibling_id')
            ->where('sibling_type',get_class($object))
            ->where('campaign_id',\Session::get('campaign')->id)
            ->get();


        if(count($sibling_collection) > 0){
            foreach($sibling_collection as $s){
                $so = $oc::find($s->sibling_id);

                if( ( $so->restricted == 1 && \Session::get('dm') == 1 ) || $so->restricted == 0   ) {
                    $ids[] = $s->sibling_id;
                }
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

        try {
            $relationship->delete();
        } catch (Exception $e){
            \Log::error('Could not remove reference for ' . $this->referenceClass . ':' . $this->id . ' from campaign ' . \Session::get('campaign')->id);
        }
    }

    public function addCampaignMembership(){
        $relationship = new Relationship();
        $relationship->campaign_id = \Session::get('campaign')->id;
        $relationship->source_type = 'App\\Campaign';
        $relationship->source_id = \Session::get('campaign')->id;
        $relationship->sibling_type = $this->referenceClass;
        $relationship->sibling_id = $this->id;

        try{
            $relationship->save();
        } catch(Exception $e){
            \Log::error('Could not register ' . $this->referenceClass . ': ' . $this->id . ' with campaign ' . \Session::get('campaign')->id . ': Error message is ' . $e->getMessage());
        }
    }

    public function addFiles(UploadedFile $file){
        $ext = $file->getClientOriginalExtension();
        $name = sha1($file->getClientOriginalName());
        $file->move(storage_path() . '/app/uploads/campaign_' . \Session::get('campaign')->id, $name . '.' . $ext);
        $this->image = \URL::to('/images/' . \Session::get('campaign')->id . '/' . $name . '.' . $ext);
    }

    public function removeFiles(){
        if(strlen($this->image) > 0 ){
            //todo: Let's look at a way to configure storage to globally be local / cloud etc

            //Let's break out the image name
            $components = explode("/",$this->image);
            $filename = $components[count($components) -1];

            if(\File::exists(storage_path() . '/app/uploads/campaign_' .
                \Session::get('campaign')->id . '/' . $filename) ){

                //Delete that file yo!
                \File::delete( storage_path() . '/app/uploads/campaign_' .
                    \Session::get('campaign')->id . '/' . $filename);
            }
        }
    }

}