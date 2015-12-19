<?php

/**
 * 订单数据模型
 */

namespace Org\Util\Pay;

class PayVo {

    protected $_orderNo;
    protected $_fee;
    protected $_title;
    protected $_body;
    protected $_callback;
    protected $_url;
    protected $_param;
    protected $_type;
    protected $_id;
    protected $_openid;

    /**
     * 设置订单号
     * @param type $order_no
     * @return \Think\Pay\PayVo
     */
    public function setOrderNo($order_no) {
        $this->_orderNo = $order_no;
        return $this;
    }

    /**
     * 设置商品价格
     * @param type $fee
     * @return \Think\Pay\PayVo
     */
    public function setFee($fee) {
        $this->_fee = $fee;
        return $this;
    }

    /**
     * 设置商品名称
     * @param type $title
     * @return \Think\Pay\PayVo
     */
    public function setTitle($title) {
        $this->_title = $title;
        return $this;
    }

    /**
     * 设置商品描述
     * @param type $body
     * @return \Think\Pay\PayVo
     */
    public function setBody($body) {
        $this->_body = $body;
        return $this;
    }

    /**
     * 设置支付完成后的后续操作接口
     * @param type $callback
     * @return \Think\Pay\PayVo
     */
    public function setCallback($callback) {
        $this->_callback = $callback;
        return $this;
    }

    /**
     * 设置支付完成后的跳转地址
     * @param type $url
     * @return \Think\Pay\PayVo
     */
    public function setUrl($url) {
        $this->_url = $url;
        return $this;
    }

    /**
     * 设置交易类型
     * @param type $type
     * @return \Think\Pay\PayVo
     */
    public function setType($type) {
        $this->_type = $type;
        return $this;
    }

    /**
     * 设置用户ID
     * @param type $openid
     * @return \Think\Pay\PayVo
     */
    public function setOpenid($openid) {
        $this->_openid = $openid;
        return $this;
    }

    /**
     * 设置商品ID
     * @param type $id
     * @return \Think\Pay\PayVo
     */
    public function setId($id) {
        $this->_id = $id;
        return $this;
    }

    /**
     * 设置订单的额外参数
     * @param type $param
     * @return \Think\Pay\PayVo
     */
    public function setParam($param) {
        $this->_param = $param;
        return $this;
    }

    /**
     * 获取订单号
     * @return type
     */
    public function getOrderNo() {
        return $this->_orderNo;
    }

    /**
     * 获取商品价格
     * @return type
     */
    public function getFee() {
        return $this->_fee;
    }

    /**
     * 获取商品名称
     * @return type
     */
    public function getTitle() {
        return $this->_title;
    }

    /**
     * 获取支付完成后的后续操作接口
     * @return type
     */
    public function getCallback() {
        return $this->_callback;
    }

    /**
     * 获取支付完成后的跳转地址
     * @return type
     */
    public function getUrl() {
        return $this->_url;
    }

    /**
     * 获取商品描述
     * @return type
     */
    public function getBody() {
        return $this->_body;
    }

    /**
     * 获取交易类型
     * @return type
     */
    public function getType() {
        return $this->_type;
    }

    /**
     * 获取商品id
     * @return type
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * 获取用户id
     * @return type
     */
    public function getOpenid() {
        return $this->_openid;
    }

    /**
     * 获取订单的额外参数
     * @return type
     */
    public function getParam() {
        return $this->_param;
    }

}
