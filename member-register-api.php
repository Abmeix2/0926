<?php
$data = file_get_contents("php://input", "r");
$mydata = array();
$mydata = json_decode($data, true);

if (isset($mydata["username"]) && isset($mydata["password"]) && isset($mydata["email"])) {
    if ($mydata["username"] != "" && $mydata["password"] != "" && $mydata["email"] != "") {
        $p_username = $mydata["username"];

        //password_hash("123456", PASSWORD_DEFAULT)
        // $p_password = $mydata["password"];
        $p_password = password_hash($mydata["password"], PASSWORD_DEFAULT);
        $p_email    = $mydata["email"];

        // 呼叫連線
        require_once("dbtools.php");
        $link = create_connection();

        // 給sql指令
        $sql = "INSERT INTO member(Username, Password, Email) VALUES('$p_username', '$p_password', '$p_email')";
        // 布林值 (只有失敗或成功)，用if else
        if (execute_sql($link, "if0_37421127_testdb", $sql)) {
            echo '{"state": true, "message" : "註冊成功"}';
        } else {
            echo '{"state": false, "message" : "註冊失敗"}';
        }
        // 記得關閉資料庫
        mysqli_close($link);
    }else{
        echo '{"state": false, "message" : "欄位不得為空白"}';
    }

} else {
    echo '{"state": false, "message" : "欄位命名錯誤"}';
}
?>
