<?php
// Create_v1，預設json格式，不用post了
// {"name":"雞腿飯", "price":"100", "num":"2", "remark":"好吃"}
$data = file_get_contents("php://input", "r");
$mydata = array();
$mydata = json_decode($data, true);

if(isset($mydata["name"]) && isset($mydata["spec"]) && isset($mydata["price"]) && isset($mydata["num"]) && isset($mydata["remark"])){
    if ($mydata["name"] != "" && $mydata["spec"] != "" && $mydata["price"] != "" && $mydata["num"] != "" && $mydata["remark"] != "") {

        $p_name = $mydata["name"];
        $p_spec = $mydata["spec"];
        $p_price = $mydata["price"];
        $p_num = $mydata["num"];
        $p_remark = $mydata["remark"];
    
        $servername = "localhost";
        $username = "owner";
        $password = "123456";
        $dbname = "testdb";
    
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if (!$conn) {
            die("連線失敗" . mysqli_connect_error());
        }
    
        $sql = "INSERT INTO product(Name, Spec, Price, Num, Remark) VALUES('$p_name','$p_spec','$p_price','$p_num','$p_remark')";
        // 新增只有成功或失敗:布林值，用if else
        if (mysqli_query($conn, $sql)) {
            echo '{"state" : true , "message" : "新增成功"}';
        } else {
            echo '{"state" : false, "message" : "新增失敗' . $sql . mysqli_error($conn) . '"}';
        }
        //最後一定要記得關閉連線!
        mysqli_close($conn);
    
    } else {
        echo '{"state" : false, "message" : "欄位不得為空白"}';    
    }

}else{
    echo '{"state" : false, "message" : "欄位命名錯誤"}';
}



?>
