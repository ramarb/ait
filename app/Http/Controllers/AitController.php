<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FlickrWrapper;

class AitController extends ParentController
{
    public function __construct(){
        parent::__construct();
        $this->controller = 'endpoint';
        $this->view_param['page_title'] = 'Endpoint';
    }

    public function index(Request $request){

        $flickr = new FlickrWrapper();
        $flickr->pushArg('per_page',20);
        //$res = $flickr->getPhotoById('32126256356');
        //$res = $flickr->getPhotosByTags('lizasoberano'); $this->p($res,1);die;



        return $this->render('ait.index');
    }

    public function getPhotos(Request $request){
        $flickr = new FlickrWrapper();
        $flickr->pushArg('per_page',20);
        $flickr->pushArg('page', $request->page_nth);
        $res = $flickr->getPhotosByTags($request->tag_name);
        //$res = $flickr->getPhotoById('32126256356');
        //$this->p($res,1);

        return json_encode($res);
    }

    public function create(){

    }

    public function store(Request $request){


    }

    public function show($id){

    }

    public function destroy(Request $request){

    }

    public function edit($id){

    }

    public function update(Request $request, $id){

    }
}
