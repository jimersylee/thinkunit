<?php

/**
 * @author lizhug <lizhug.steven@gmail.com>
 * @link http://thinkunit.zunar.in
 */

namespace Test\Controller;
use Think\Controller;

class ThinkUnitController extends Controller {

    private $allTestList = array();
    private $curMethodInfo = array();
    private $curMethod = "";
    private $curAssertIndex = 1;            //当前方法断言序号
    private $curAssertFailTmp = array();            //当前断言状态缓存
    private $curTestSuccessNumber = 0;          //当前方法成功次数
    private $curTestFailNumber = 0;             //当前方法失败次数
    private $allTestSuccessNumber = 0;          //总成功次数
    private $allTestFailNumber = 0;             //总失败次数

	/**
     * @description 判断是否是注释了test，添加注释的都是需要做测试的
     * @param        模块, 方法名称
     * @return         boolean 是否添加注释test 
     */
    private function isNoteTest($module, $method){
        $func  = new \ReflectionMethod($module, $method);
        $tmp   = $func->getDocComment();
        
        $flag  = preg_match_all('/@test(.*?)\n/',$tmp, $tmp);
        $tmp   = trim($tmp[0][0]);//返回 test 
        return $tmp != '@test' ? false : true;
    }
	
    /**
     * 获取方法的功能说明
     */
    public function getMethodNote($module, $method) {
        $func  = new \ReflectionMethod($module, $method);
        $tmp   = $func->getDocComment();
        preg_match("/@note(.*?)\n/", $tmp, $note);
        return trim($note[1]);
    }

    public function index() {
        $this->run();
    }

    public function run() {
        $classMethod = get_class_methods($this);          //获取所有的函数

        foreach ($classMethod as $method) {
            
            //判断是否有注释@test
            if($this->isNoteTest($this, $method)){
                $this->curTestMethod = $method;
                $this->curAssertIndex = 1;
                $this->curTestSuccessNumber = 0;
                $this->curTestFailNumber = 0;
                $this->curAssertFailTmp = array();

                $this->$method();         //执行这个函数

                $this->curMethodInfo = array(
                    'name' => $method,          //方法名
                    "note" => $this->getMethodNote($this, $method),
                    "success" => $this->curTestSuccessNumber,
                    "fail" => $this->curTestFailNumber,
                    "total" => $this->curTestSuccessNumber + $this->curTestFailNumber,
                    "fail_list" => $this->curAssertFailTmp
                );

                array_push($this->allTestList, $this->curMethodInfo);
            }
        }

        //总测试信息
        $this->assign("test_info", array(
            "success" => $this->allTestSuccessNumber,
            "fail" => $this->allTestFailNumber,
            "total" => $this->allTestSuccessNumber + $this->allTestFailNumber
        ));

        //测试信息列表
        $this->assign('test_list', $this->allTestList);
        $this->display("ThinkUnit:run");
    }

    //断言为真
    public function assertTrue($return) {
        
        if ($return) {
            $this->curTestSuccessNumber++;
            $this->allTestSuccessNumber++;
        } else {
            $this->curTestFailNumber++;
            $this->allTestFailNumber++;
            array_push($this->curAssertFailTmp, $this->curAssertIndex);
        }

        $this->curAssertIndex++;
    }

    //断言为假
    public function assertFalse($return) {
        if (!$return) {
            $this->curTestSuccessNumber++;
            $this->allTestSuccessNumber++;
        } else {
            $this->curTestFailNumber++;
            $this->allTestFailNumber++;
            array_push($this->curAssertFailTmp, $this->curAssertIndex);
        }

        $this->curAssertIndex++;
    }

    //断言
    public function assert($assert, $return) {

        if ($assert === $return) {
            $this->curTestSuccessNumber++;
            $this->allTestSuccessNumber++;
        } else {
            $this->curTestFailNumber++;
            $this->allTestFailNumber++;
            array_push($this->curAssertFailTmp, $this->curAssertIndex);
        }

        $this->curAssertIndex++;
    }
}
