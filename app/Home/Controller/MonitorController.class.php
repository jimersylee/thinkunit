<?php
namespace Home\Controller;
use Think\Controller;
class MonitorController extends BaseController {
    public function index(){
        $this->display("Home:index");
    }
}