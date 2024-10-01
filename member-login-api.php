<?php
// {"username":"owner01"}

// {"state" : true, "message" : "登入成功"}
// {"state" : false, "message" : "登入失敗和錯誤代碼等"}
// {"state" : false, "message" : "欄位不得為空白"}
// {"state" : false, "message" : "欄位命名錯誤"}

$data = file_get_contents("php://input", "r");
$mydata = array();
$mydata = json_decode($data, true);

if (isset($mydata["username"]) && isset($mydata["password"])) {
    if ($mydata["username"] != "" && $mydata["password"] != "" ) {
        $p_username = $mydata["username"];
        $p_password = $mydata["password"];

        // 呼叫連線
        require_once("dbtools.php");
        $link = create_connection();

        // 給sql指令
        // 1.確認帳號是否存在(當資料庫中的帳號(橘色Username) = 使用者輸入的帳號($p_username)時-->則撈出(select)資料庫中的帳號及密碼)
        $sql = "SELECT Username, Password FROM member WHERE Username = '$p_username'";
        // 執行上方sql指令，並將結果設給$result。
        $result = execute_sql($link, "testdb", $sql);
            // 若資料庫搜尋結果筆數為1，代表帳號存在，可繼續比對密碼
        if (mysqli_num_rows($result) == 1) {
            // 比對密碼
            $row = mysqli_fetch_assoc($result);  //將json格式排成陣列?我們比較好看懂
            // echo $row["Password"];  (測試，印出資料庫中的密碼亂碼)
            // 比對亂數密碼(20240808-password.php 練習過)。$p_password為使用者輸入的，$row["Password"]為資料庫中的亂數
            if(password_verify($p_password, $row["Password"])){
                // 密碼比對正確，產生Uid01並更新至資料庫 
                $uid01 = substr(hash('sha256', uniqid(time())), 0, 8);
                $sql = "UPDATE member SET Uid01 = '$uid01' WHERE Username = '$p_username'";
                if (execute_sql($link, "testdb", $sql)){
                    // uid01更新成功
                     $sql = "SELECT Username, Email, Uid01, State,Created_at FROM member WHERE Username = '$p_username'";
                    $result = execute_sql($link, "testdb", $sql);
                    $row = mysqli_fetch_assoc($result);

                    echo'{"state" : true, "data": '. json_encode($row) .', "message" : "登入成功"}';
                }else{
                    // uid01更新失敗
                    echo '{"state" : false, "message" : "uid01更新失敗"}';
                }
               
            }else{
                echo'{"state" : false, "message" : "登入失敗"}';
            }
        } else {
            // 帳號不存在，登入失敗
            echo '{"state": false, "message" : "登入失敗"}';
        }
        // 記得關閉資料庫
        mysqli_close($link);
    }else{
        // 欄位不得為空白
        echo '{"state": false, "message" : "登入失敗"}';
    }

} else {
    // 欄位命名錯誤
    echo '{"state": false, "message" : "登入失敗"}';
}
?>