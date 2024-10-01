<?php
// {"state" : true, "data": [{"level": "900", "level_num"; "50"}, {"level": "100", "level_num"; "50"}, {"level": "200", "level_num"; "50"}, {"level": "300", "level_num"; "50"}, {"level": "400", "level_num"; "50"}], "message" : ""取得資料成功"}
// {"state" : false, "message" : "取得資料失敗'"}

// 呼叫連線
require_once("dbtools.php");
$link = create_connection();

// 給sql指令:
$sql = "SELECT COUNT(State) as state_num, State FROM member GROUP BY State";
// 執行上方sql指令，並將結果設給$result
$result = execute_sql($link, "testdb", $sql);

// 將result，一筆一筆列出來，直到沒有資料可撈。因為很多筆，所以要用陣列array()呈現
$mydata = array();
while($row = mysqli_fetch_assoc($result)){
    $mydata[] = $row;
}

echo '{"state" : true, "data" : ' .json_encode($mydata) . ', "message" : "取得資料成功!"}';

// 記得關閉資料庫
mysqli_close($link);
?>