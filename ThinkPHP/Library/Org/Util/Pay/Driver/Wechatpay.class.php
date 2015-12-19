<?php
namespace Org\Util\Pay\Driver;

class Wechatpay extends \Org\Util\Pay\Pay {

    protected $gateway = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
    protected $verify_url = 'https://api.mch.weixin.qq.com/pay/orderquery';
    protected $config = array(
        'appid' => '',
        'mch_id' => '',
        'key' => '',
        'notify_url' =>  ''
    );

    public function check() {
        if (!$this->config['appid'] || !$this->config['mch_id'] || !$this->config['key']|| !$this->config['notify_url']) {
            E("微信支付设置有误！");
        }
        return true;
    }



    public function buildRequestForm(\Org\Util\Pay\PayVo $vo) {
        $param = array(
            'nonce_str' =>(string)mt_rand(),
            'spbill_create_ip' => get_client_ip(),
            'device_info' => 'WEB',
            'appid' => $this->config['appid'],
            'mch_id' => $this->config['mch_id'],
            'notify_url' => $this->config['notify_url'],
            'out_trade_no' => $vo->getOrderNo(),
            'body' => $vo->getTitle(),
            'detail' => $vo->getBody(),
            'total_fee' => $vo->getFee(),//-----------------
            'trade_type' => $vo->getType(),
            'product_id' => $vo->getId(),
            'openid' => $vo->getOpenid()
        );

        \Think\Log::write("11111" . $this->config['notify_url']);
        $param['sign'] = $this->signatureArithmetic($param);

        $param = $this->xml_encode($param);
        $order = $this->fsockOpen($this->gateway, 0, $param);



        return  (array)simplexml_load_string($order, 'SimpleXMLElement', LIBXML_NOCDATA);
    }



    /**
     * 签名算法
     * @param $data
     * @return bool|string
     */
    public function signatureArithmetic($data) {
        if (is_array($data)) {
            $keyArray = array_keys($data);
            natsort($keyArray);
            $string = '';

            foreach ($keyArray as $vo) {

                if (null != $data[$vo]) {
                    $string .= $vo . "=" . $data[$vo] . "&";
                }
            }
            $string = md5($string . "key=" . $this->config["key"]);
            return strtoupper($string);
        } else {
            return false;
        }
    }

    /**
     * XML编码
     * @param mixed $data 数据
     * @param string $root 根节点名
     * @param string $item 数字索引的子节点名
     * @param string $attr 根节点属性
     * @param string $id   数字索引子节点key转换的属性名
     * @param string $encoding 数据编码
     * @return string
     */
    public function xml_encode($data, $root='xml', $item='item', $attr='', $id='id', $encoding='utf-8') {
        if(is_array($attr)){
            $_attr = array();
            foreach ($attr as $key => $value) {
                $_attr[] = "{$key}=\"{$value}\"";
            }
            $attr = implode(' ', $_attr);
        }
        $attr   = trim($attr);
        $attr   = empty($attr) ? '' : " {$attr}";
        $xml   = "<{$root}{$attr}>";
        $xml   .= self::data_to_xml($data, $item, $id);
        $xml   .= "</{$root}>";
        return $xml;
    }

    /**
     * 数据XML编码
     * @param mixed $data 数据
     * @return string
     */
    public static function data_to_xml($data) {
        $xml = '';
        foreach ($data as $key => $val) {
            is_numeric($key) && $key = "item id=\"$key\"";
            $xml    .=  "<$key>";
            $xml    .=  ( is_array($val) || is_object($val)) ? self::data_to_xml($val)  : self::xmlSafeStr($val);
            list($key, ) = explode(' ', $key);
            $xml    .=  "</$key>";
        }
        return $xml;
    }

    public static function xmlSafeStr($str)
    {
        return '<![CDATA['.preg_replace("/[\\x00-\\x08\\x0b-\\x0c\\x0e-\\x1f]/",'',$str).']]>';
    }


    /**
     * 针对notify_url验证消息是否是微信发出的合法消息
     * @return 验证结果
     */
    public function verifyNotify($notify) {

        $sign = $notify['sign'];
        unset($notify['sign']);
        $this->setInfo($notify);
        //生成签名结果
        return $sign == $this->signatureArithmetic($notify);

    }

    protected function setInfo($notify) {
        $info = array();
        //支付状态
        $info['status'] = $notify['result_code'] == 'SUCCESS' ? true : false;
        $info['money'] = $notify['total_fee'] / 100;
        $info['out_trade_no'] = $notify['out_trade_no'];
        $this->info = $info;
    }

    /**
     * 商户处理后同步返回给微信参数
     */
    public function notifySuccess() {

        echo '<xml>
  <return_code><![CDATA[SUCCESS]]></return_code>
  <return_msg><![CDATA[OK]]></return_msg>
</xml>';
    }

}