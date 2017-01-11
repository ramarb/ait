<?php

namespace App\Models;

/**
 * Class FlickrWrapper
 * @package App\Models
 */
class FlickrWrapper
{
    private $api_key = "db9284ff4a8d8e229a14db4a81a4edbd";
    private $api_url = "https://api.flickr.com/services/rest/";
    private $extras = "date_upload, date_taken, owner_name, icon_server, original_format, last_update, geo, tags, machine_tags, o_dims, views, media, path_alias, url_sq, url_t, url_s, url_q, url_m, url_n, url_z, url_c, url_l, url_o";
    private $method = '';
    private $response = '';
    private $tags = '';
    private $args = array();
    private $per_page = 100;


    public function __construct(){
        $this->args = array(
            'api_key'	=> $this->api_key,
            'format'	=> 'php_serial',
            'per_page' => $this->per_page
        );
    }

    /**
     * @param $method
     */
    public function setMethod($method){
        $this->method = $method;
    }

    /**
     * @param $tags
     */
    public function setTags($tags){
        $this->tags = $tags;
    }

    public function setResponse($data){
        $this->response = $data;
    }

    public function pushArg($index, $arg){
        $this->args[$index] = $arg;
    }

    public function getResponse(){
        return $this->response;
    }

    public function getPhotosByTags($tags){

        $this->setMethod('flickr.photos.search');
        $this->setTags($tags);

        $this->pushArg('method',$this->method);
        $this->pushArg('tags',$this->tags);
        $this->pushArg('extras',$this->extras);
        $this->submitRequest();

        return $this->response;
    }

    public function getPhotoById($photoId){
        $this->setMethod('flickr.photos.getInfo');

        $this->pushArg('method',$this->method);
        $this->pushArg('photo_id',$photoId);

        $this->submitRequest();
        return $this->response;
    }

    public function submitRequest(){
        $encoded_params = array();

        foreach ($this->args as $k => $v){
            $encoded_params[] = urlencode($k).'='.urlencode($v);
        }

        $url = $this->api_url."?".implode('&', $encoded_params);

        $rsp = file_get_contents($url);

        $this->setResponse(unserialize($rsp));
    }
}
