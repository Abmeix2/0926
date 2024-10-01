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

        
        $sql = "SELECT Username, Password FROM member WHERE Username = '$p_username'";
       
        $result = execute_sql($link, "if0_37421127_testdb", $sql);
            
        if (mysqli_num_rows($result) == 1) {
           
            $row = mysqli_fetch_assoc($result);  
            
            if(password_verify($p_password, $row["Password"])){
               
                $uid01 = substr(hash('sha256', uniqid(time())), 0, 8);
                $sql = "UPDATE member SET Uid01 = '$uid01' WHERE Username = '$p_username'";
                if (execute_sql($link, "if0_37421127_testdb", $sql)){
                    // uid01更新成功
                     $sql = "SELECT Username, Email, Uid01, State,Created_at FROM member WHERE Username = '$p_username'";
                    $result = execute_sql($link, "if0_37421127_testdb", $sql);
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