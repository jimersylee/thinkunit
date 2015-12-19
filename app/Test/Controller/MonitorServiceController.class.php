<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Test\Controller;

use Think\Controller;

class MonitorServiceController extends BaseController {
  /**
   *@test 
   *@note 检测UUID的合法性
   **/
    public function checkUUID(){
        $flag = D("Home/Monitor", "Service")->checkUUID('135804858752');
        $this->assertFalse($flag);
        
        $flag = D("Home/Monitor", "Service")->checkUUID("5cb53d96-db87-9b05-0c71-31780825d820");
        $this->assertTrue($flag);

        $flag = D("Home/Monitor", "Service")->checkUUID("5cb53d96-db87-9b05-0c71-31780825d820~d");
        $this->assertFalse($flag);

        $flag = D("Home/Monitor", "Service")->checkUUID(D("Home/Monitor", "Service")->createUUID());
        $this->assertTrue($flag);
    }

  /**
   *@test 
   *@note 创建UUID
   **/
    public function createUUID(){
        $flag = D("Home/Monitor", "Service")->createUUID();
        $this->assert(true, !!preg_match("/^[a-zA-Z0-9]{8}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{12}$/", $flag));
    }


      
}
