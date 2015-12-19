<?php
namespace Think\Upload\Driver;
/**
 * @name 又拍云上传驱动
 * @author 娃娃脾气
 * 
 *
 */
class Upyun{
    /**
     * 上传文件根目录
     * @var string
     */
    private $rootPath;
    
    private $config;

    /**
     * 本地上传错误信息
     * @var string
     */
    private $error = ''; //上传错误信息

    private $upyun;
    
    /**
     * 构造函数，用于设置上传根路径
     */
    public function __construct($config = array()){
    	$this->config = C('FILE_UPLOAD_CONFIG.' . Upyun);
    	
    	
		// 擦，数组怎么合并不来啊。。我不玩了
    	// $this->config = array_merge($this->config, $config);
    	

    	$this -> upyun = new lib\UpYun($this->config['bucketname'], $this->config['username'], $this->config['password']);
    }

    /**
     * 检测上传根目录
     * @param string $rootpath   根目录
     * @return boolean true-检测通过，false-检测失败
     */
    public function checkRootPath($rootpath){
    	$pathInfo = $this -> upyun -> getFileInfo($rootpath);
        $this->rootPath = $rootpath;
        return $pathInfo;
    }

    /**
     * 检测上传目录
     * @param  string $savepath 上传目录
     * @return boolean          检测结果，true-通过，false-失败
     */
    public function checkSavePath($savepath){
    	if($this -> upyun -> getFileInfo($savepath)){
    		return true;
    	}else{
    		return $this -> mkdir($savepath);
    	}
    }

    /**
    * 设置图片密码
    */
    public function setFileSecret($secret) {
        $this-> upyun -> setFileSecret($secret);
    }

    /**
    * 删除文件
    */
    public function deleteFile($path) {
        return $this-> upyun -> deleteFile($path);
    }

    /**
     * 转移文件
     */
    public function shiftFile($pathArray) {
        return $this-> upyun -> shiftFile($pathArray);
    }

    /**
     * 保存指定文件
     * @param  array   $file    保存的文件信息
     * @param  boolean $replace 同名文件是否覆盖
     * @return boolean          保存状态，true-成功，false-失败
     */
    public function save($file, $replace=true) {
    	
        $filename = $this->rootPath . $file['savepath'] . $file['savename'];
        $fh = fopen($file['tmp_name'], 'rb');
        $rsp = $this -> upyun -> writeFile($filename, $fh, True);
        fclose($fh);
        return (bool)$rsp;
    }
    /**
     * 创建目录
     * @param  string $savepath 要创建的穆里
     * @return boolean          创建状态，true-成功，false-失败
     */
    public function mkdir($savepath){
    	
    	return $this -> upyun -> makeDir($this->rootPath . $savepath, true);
    }
    /**
     * 获取最后一次上传错误信息
     * @return string 错误信息
     */
    public function getError(){
        return $this->error;
    }



}
