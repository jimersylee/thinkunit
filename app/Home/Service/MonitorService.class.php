<?php
namespace Home\Service;

class MonitorService {
    //生成GUID，作为task_code主键
    public function createUUID() {
        return trim(\Org\Util\String::uuid(), "{}");
    }

    //检查uuid的合法性
    public function checkUUID($uuid) {
        return preg_match("/^[a-zA-Z0-9]{8}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{12}$/", $uuid);
    }

    //更新任务
    public function updateTask($uuid) {
        if ($this->checkUUID($uuid)) {

        } else {
            return array(
                "code" => "400",
                "message" => "uuid格式不合法"
            );
        }
    }
}