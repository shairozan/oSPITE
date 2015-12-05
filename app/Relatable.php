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

abstract class Relatable extends Model
{

    public static function getRelated($Model,$id){
        $Related = DB::table('relationships')
            ->where(function($query) use ($Model,$id){
                $query->where('source_type',$Model)
                    ->where('source_id',$id);

            })
            ->orWhere(function($query) use ($Model, $id) {
                $query->where('sibling_type',$Model)
                    ->where('sibling_id',$id);
            })
            ->get();

        dd($Related);
    }
}