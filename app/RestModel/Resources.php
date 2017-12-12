<?php

namespace App\RestModel;

use Illuminate\Database\Eloquent\Model;

class Resources extends Model
{
    protected $table = 'resources';

    public function scopeCollection($query, $type, $mode, $set)
    {

    	$query = $query->selectRaw('id, type, set_name, CONCAT(type,"/",set_name,"/",filename) as filepath');

    	if(!$type && !$mode && !$set) return $query->get();

    	if($mode && ( $mode == 'emoji' || $mode == 'sticker' )){

    		$query = $query->where('type', $mode);

    	}else if($mode && ( $mode == 'pancake' || $mode == 'gummybear' || $mode == 'hotdog' || $mode == 'pancake' || $mode == 'regular')){

    		$query = $query->where('set_name', $mode);

    	}else if($mode && ( $mode == 'paid' || $mode == 'free')){

    		$query = $query->where('paid', $mode == 'paid' ? 1 : 0);

    	}

    	if($set){

    		$query = $query->where('set_name', $set);

    	}

    	if($type == 'owned'){

    		if(request()->user()->paid_emoji_set){

    			$query = $query->orwhereraw('paid = 0 and FIND_IN_SET(set_name, "'.request()->user()->paid_emoji_set.'")');

    		}else{

    			$query = $query->where('paid', 0);

    		}

    	}

    	return $query->get();

    }

}
