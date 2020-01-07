<?php
    include_once "Bacon.php";

    $conn = new Bacon();
    
    if(isset($_POST['item_list'])&&isset($_POST['finishTime'])){
        $items = $_POST['item_list'];
        $finishTime = $_POST['finishTime'];
    }
    $limitTime1 = date("Y-m-d")." "."05:00";
    $limitTime2 = date("Y-m-d")." "."13:00";
    $ordertime = date("Y-m-d")." ".$finishTime;
    //echo $items;
    //echo $finishTime;
    //print_r($items);

    if(strtotime($limitTime1)<strtotime($ordertime) && strtotime($limitTime1)<strtotime($limitTime2)){
        $jsonitems  = json_decode($items,true);
        //echo $items;
        $total_price = 0;
        foreach($jsonitems as $k=> $v){
        $temp = explode(",",$v); 
        $total_price  += $temp[1];
        }
        $getTime = (string)(date("H:i",time()+7*3600));
        session_start();
        $userID = $_SESSION['ID'];
    
        $orderID = date("Y-m-d")."-".date("H-i",time()+7*3600)."-".$userID;
    
        $conn->addOrder("未確認",$orderID,$total_price,$getTime,$finishTime,$userID,$items);
        echo ($orderID);
    }
    else{
        echo 0;
    }
    
?>