<?php
// {"id":"xxx", "state": "0"}

// {"state" : true,"message" : "更新成功"}
// {"state" : false, "message" : "會員更新失敗和錯誤代碼等'"}
// {"state" : false, "message" : "欄位不得為空白"}
// {"state" : false, "message" : "欄位命名錯誤"}
$data = file_get_contents("php://input", "r");
$mydata = array();
$mydata = json_decode($data, true);

if (isset($mydata["id"]) && isset($mydata["state"])) {
    if ($mydata["id"] != "" && $mydata["state"] != "") {
        $p_id = $mydata["id"];
        $p_state = $mydata["state"];

        // 呼叫連線
        require_once("dbtools.php");
        $link = create_connection();

        // 給sql指令: 將網頁switch開關按鈕的狀態$p_state傳送給後端(透過此api傳遞給資料庫->從網頁switch的$p_state可直接變更資料庫的State欄位)
        $sql = "UPDATE member SET State = '$p_state' WHERE ID = '$p_id'";
        
        // 執行上方sql指令
        if(execute_sql($link, "testdb", $sql)){
            echo '{"state": true, "message" : "會員狀態更新成功"}';
        }else{
            echo '{"state": true, "message" : "會員更新失敗和錯誤代碼等"}';
        }
        // 記得關閉資料庫
        mysqli_close($link);
    }else{
        echo '{"state": false, "message" : "欄位不得為空白"}';
    }

} else {
    echo '{"state": false, "message" : "欄位命名錯誤"}';
}
