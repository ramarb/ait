<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Symfony\Component\HttpKernel\Tests\Exception\AccessDeniedHttpExceptionTest;
use Session;

abstract class ParentController extends Controller
{
    //

    public $view_param = ['page_title' => 'PhotoUp Export'];
    public $controller = '';

    public function __construct(){
        $this->view_param['alert_type'] = '';
        $this->view_param['alert_message'] = '';
    }

    public function render($view){

        $this->view_param['controller'] = $this->controller;
        $this->set_ng_view();
        if(Session::has('alert_type')){
            $this->set_alert_message(Session::get('alert_type'),Session::get('alert_message'));
        }
        return view($view, $this->view_param);
    }

    public function set_alert_message($type,$message,$flash=false){
        if($flash === true){
            Session::flash('alert_type',$type);
            Session::flash('alert_message',$message);
        }else{
            $this->view_param['alert_type'] = $type;
            $this->view_param['alert_message'] = $message;
        }
    }

    public function p($mix, $exit = false){
        echo '<pre>';
        print_r($mix);
        echo '</pre>';
        if($exit)die;
    }

    public function set_ng_view(){
        $this->view_param['ng_libs'] = array(
            'js/angular/angular.min.js',
            'js/angular/angular-animate.min.js',
            'js/angular/angular-aria.min.js',
            'js/angular/angular-material.min.js',
            'js/angular/angular-messages.min.js',
            'js/angular/angular-route.min.js',
            'js/angular/svg-assets-cache.js'
        );
    }




}
