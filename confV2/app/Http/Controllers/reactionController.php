<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\likes;
use App\comments;

class reactionController extends Controller
{
    //action can be a like or dislike
    public function like($id, $action){
        if (Session()->has('userConfV2')) {

        	if ($action == 'like') {
        		likes::create(['idPost' => $id, 'idUser' => Session()->get('userConfV2')]);
        	} else {
        		likes::where('idPost', '=', $id)->where('idUser', '=', Session()->get('userConfV2'))->delete();
        	}

        }
    }

    //Add Like
    public function addComment($idPost, Request $req){
        if (Session()->has('userConfV2') && $req->input('comment') != '') {

            comments::create(['idPost' => $idPost, 'idUser' => Session()->get('userConfV2'), 'comment' => $req->input('comment')]);
        
        }
    }
}
