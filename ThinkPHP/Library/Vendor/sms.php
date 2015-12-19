<?php
class sms {
	public $comid = "1832";
	public $username = "diancanba";
	public $userpwd = "od2014";
	public $smsnumber = "10690";

	public function sendnote($mobtel, $msg) {
		$username = $this->username;
		$userpwd = $this->userpwd;
		$smsnumber = $this->smsnumber;
		$comid = $this->comid;
		$msg = urlencode ( mb_convert_encoding ( $msg, 'gbk', 'utf-8' ) );
		$url = "http://jiekou.56dxw.com/sms/HttpInterface.aspx?comid=$comid&username=$username&userpwd=$userpwd&handtel=$mobtel&sendcontent=$msg&sendtime=&smsnumber=$smsnumber";
		$flag = file_get_contents ( $url );
		if ($flag == 1) {
            return array(
                "code" => "200",
                "message" => "发送成功"
            );
        } else {
            return array(
                "code" => "400",
                "message" => $flag
            );
        }
        
	}


	public function yunpian($mobile, $text) {
		$apikey = "9968d89e2c365c0dcdfb649c5c5ac43a";
		$url = "http://yunpian.com/v1/sms/send.json";
		$encode_text = urlencode ($text);

	    $data = "apikey=$apikey&text=$encode_text&mobile=$mobile";

	    $result = $this->sock_post($url, $data);
        $resultArr = json_decode($result, true);
        
        if ($resultArr['code'] == 0) {
            return array(
                "code" => "200",
                "message" => "发送成功"
            );
        } else {
            return array(
                "code" => "400",
                "message" => $resultArr['detail']
            );
        }
	}

	/**
    * url 为服务的url地址
    * query 为请求串
    */
    public function sock_post($url,$query){
        $data = "";
        $info=parse_url($url);
        $fp=fsockopen($info["host"],80,$errno,$errstr,30);
        if(!$fp){
            return $data;
        }
        $head="POST ".$info['path']." HTTP/1.0\r\n";
        $head.="Host: ".$info['host']."\r\n";
        $head.="Referer: http://".$info['host'].$info['path']."\r\n";
        $head.="Content-type: application/x-www-form-urlencoded\r\n";
        $head.="Content-Length: ".strlen(trim($query))."\r\n";
        $head.="\r\n";
        $head.=trim($query);
        $write=fputs($fp,$head);
        $header = "";
        while ($str = trim(fgets($fp,4096))) {
            $header.=$str;
        }
        while (!feof($fp)) {
            $data .= fgets($fp,4096);
        }
        return $data;
    }


		
}
?>