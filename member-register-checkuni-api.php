<?php
// {"username":"owner01"}
$data = file_get_contents("php://input", "r");
$mydata = array();
$mydata = json_decode($data, true);

if (isset($mydata["username"])) {
    if ($mydata["username"] != "") {
        $p_username = $mydata["username"];

        // 呼叫連線
        require_once("dbtools.php");
        $link = create_connection();

        // 給sql指令
        $sql = "SELECT Username FROM member WHERE Username = '$p_username'";
        $result = execute_sql($link, "if0_37421127_testdb", $sql);
            // 若資料庫搜尋結果為0，帳號不存在，可以使用
        if (mysqli_num_rows($result) == 0) {
            echo '{"state": true, "message" : "帳號不存在，可以使用"}';
        } else {
            echo '{"state": false, "message" : "帳號已存在，不可以使用"}';
        }
        // 記得關閉資料庫
        mysqli_close($link);
    }else{
        echo '{"state": false, "message" : "欄位不得為空白"}';
    }

} else {
    echo '{"state": false, "message" : "欄位命名錯誤"}';
}
