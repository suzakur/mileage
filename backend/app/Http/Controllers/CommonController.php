<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function getLabel($input) {
        if($input == 'fund') {
            return '<span class="m-badge m-badge--success">Dana</span>';
        }
        else if($input == 'charge') {
            return '<span class="m-badge m-badge--warning">Pembebanan</span>';
        }
        return '';
    }

    public function getStatus($stat) {
    	if($stat == 'draft'|| $stat == 'inactive') {
    		return '<span class="m-badge m-badge--info">'.$stat.'</span>';
    	}
    	elseif($stat == 'published' || $stat == 'active') {
    		return '<span class="m-badge m-badge--success">'.$stat.'</span>';
    	}
    	elseif($stat == 'archived') {
    		return '<span class="m-badge m-badge--danger">'.$stat.'</span>';
    	}
    }
}
