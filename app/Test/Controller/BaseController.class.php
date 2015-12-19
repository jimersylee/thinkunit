<?php

namespace Test\Controller;
use Think\Controller;

define(CONFIG_PATH, APP_PATH . "Home/Conf/config.php");
define(TAGS_PATH, APP_PATH . "Home/Conf/tags.php");
define(FUNCTION_PATH, APP_PATH . "Home/Common/function.php");

//测试基类，配置网站文件路径
class BaseController extends \Test\Controller\ThinkUnitController{

    public function __construct() {
        parent::__construct();
        C(include CONFIG_PATH);
        C(include TAGS_PATH);
        C(include FUNCTION_PATH);
    }
}