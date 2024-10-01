<?php
// {"id":"xxx"}

// {"state" : true,"message" : "刪除成功"}
// {"state" : false, "message" : "刪除失敗和錯誤代碼等'"}
// {"state" : false, "message" : "欄位不得為空白"}
// {"state" : false, "message" : "欄位命名錯誤"}
$data = file_get_contents("php://input", "r");
$mydata = array();
$mydata = json_decode($data, true);

if (isset($mydata["id"])) {
    if ($mydata["id"] != "") {
        $p_id = $mydata["id"];

        // 呼叫連線
        require_once("dbtools.php");
        $link = create_connection();

        // 給sql指令: 
        $sql = "DELETE FROM member WHERE ID = '$p_id'";
        // 執行上方sql指令
        if(execute_sql($link, "if0_37421127_testdb", $sql)){
            echo '{"state": true, "message" : "刪除成功"}';
        }else{
            echo '{"state": true, "message" : "刪除失敗和錯誤代碼等"}';
        }
        // 記得關閉資料庫
        mysqli_close($link);
    }else{
        echo '{"state": false, "message" : "欄位不得為空白"}';
    }

} else {
    echo '{"state": false, "message" : "欄位命名錯誤"}';
}
