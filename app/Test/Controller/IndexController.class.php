<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Test\Controller;

use Think\Controller;

class IndexController extends BaseController {
  
  /**
   *
   *@test 
   *
   **/
    public function Test_index(){

        $dd = $this->http_get(C("DOMAIN") . "index/index", "", "ZUNAR=ct104hpvufhaomcmm6l15q5085; city=020; lang=zh-CN; is_mobile=1");
        var_dump($dd);
        return true;
    }
   /**
   *
   *@test 
   *
   **/
    public function Test_2(){
		$array = array();
        $assert = $array;
       // echo __FILE__ ;
        echo APP_PATH;

        $this->assert($assert, $array);
    }
  /**
   *
   *@test 
   *
   **/
	public function Test_3(){
		$array = array();
        $assert = 0; 
        $this->assert($assert,count($array));
    }
   /**
   *
   *@test 
   *
   **/
    public function Test_4(){
		$array = array();
        $assert = $array; 
        $this->assert_is_array($array);
        return json_decode($assert, true);
    }	  
}
