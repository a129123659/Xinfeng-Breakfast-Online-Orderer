<?php

include_once "php/Bacon.php";

$conn; //PDO connection class

$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "XBS";

try {
    $conn = new PDO('mysql:dbname=' . $dbName . ';host=' . $dbServername, $dbUsername, $dbPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Error Handling
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    echo  $e->getMessage();
}



$sqlInsertData = "INSERT INTO status (data,isNew)
                    VALUES (1,false);";
$sqlOrders = 'create table Orders(

    status      varchar(128)    not NULL,
    ID          varchar(128)    not NULL,
    price       integer(4)      not NULL,
    GetTime     time NULL,
    FnsTime     time NULL,
    user_ID     varchar(128)    not NULL,    
    items       nvarchar(4000)  not NULL,
    isRead      boolean         not NULL,
    Primary key(ID)
);
ALTER TABLE Orders
    DEFAULT false for isRead;';

$sqlStatus = 'create table status(
            data   int(1)   not NULL,
            isNew  boolean  not NULL,
            Primary key(data)
        );';

$sqlAccount = "create table Account(
            user_ID     nvarchar(128)     PRIMARY	KEY not null,  	
            password 	nvarchar(128) 	not null	,
            salt       nvarchar(128)   not null    ,  	
            name		nvarchar(128) 	not null	,   
            age			integer(4) 	 	not null	,	
            gender		nvarchar(10) 	not null	,	
            email		nvarchar(40) 	not null	,	
            total		integer(8)		default 0
);";

$sqlItem = "create table Item(
    ID          varchar(128)    not NULL,
    type        varchar(15)     not NULL,
    price       integer(4)      not NULL,
    picture     varchar(200),
    info        nvarchar(4000)   not NULL,
    Primary key(ID)
);";

$sqlCombo = "create table Combo(
    ID          nvarchar(128)   not NULL,
    price       integer(4)      not NULL,
    picture     varchar(200),
    items       nvarchar(4000)  not NULL,
    info        nvarchar(4000),
    Primary key(ID)
);";

$sqlOpen = "create table OrderTime(
        timeKey   nvarchar(20)  not NULL,
        times  time NULL,
        Primary key(timeKey)
);";

try {
    $conn->exec($sqlOrders);
    echo "Orders table success";
} catch (PDOException $e) {
    if ($e->getMessage() == "SQLSTATE[42S01]: Base table or view already exists: 1050 Table 'orders' already exists") {
        echo "Table 'orders' already exists<br>";
    } else echo $e->getMessage() . "<br>";
}
try {
    $conn->exec($sqlStatus);
    echo "status table success";
} catch (PDOException $e) {
    if ($e->getMessage() == "SQLSTATE[42S01]: Base table or view already exists: 1050 Table 'status' already exists") {
        echo "Table 'status' already exists<br>";
    } else echo $e->getMessage() . "<br>";
}
try {
    $conn->exec($sqlAccount);
    echo "Account table success";
} catch (PDOException $e) {
    if ($e->getMessage() == "SQLSTATE[42S01]: Base table or view already exists: 1050 Table 'account' already exists") {
        echo "Table 'account' already exists<br>";
    } else echo $e->getMessage() . "<br>";
}

try {
    $conn->exec($sqlItem);
    echo "Item table success";
} catch (PDOException $e) {
    if ($e->getMessage() == "SQLSTATE[42S01]: Base table or view already exists: 1050 Table 'item' already exists") {
        echo "Table 'item' already exists<br>";
    } else echo $e->getMessage() . "<br>";
}

try {
    $conn->exec($sqlCombo);
    echo "Combo table success";
} catch (PDOException $e) {
    if ($e->getMessage() == "SQLSTATE[42S01]: Base table or view already exists: 1050 Table 'combo' already exists") {
        echo "Table 'combo' already exists<br>";
    } else echo $e->getMessage() . "<br>";
}
try {
    $conn->exec($sqlOpen);
    echo "Open table success";
} catch (PDOException $e) {
    if ($e->getMessage() == "SQLSTATE[42S01]: Base table or view already exists: 1050 Table 'ordertime' already exists") {
        echo "Table 'ordertime' already exists<br>";
    } else echo $e->getMessage() . "<br>";
}

try {
    $conn->exec($sqlInsertData);
    echo "initialize success";
} catch (PDOException $e) {

    if ($e->getMessage() == "SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry '1' for key 'PRIMARY'") {
        echo "data already insert<br>";
    } else {
        echo $e->getMessage();
    }
}

$conn = new Bacon();

$conn->initOpenTime();

$conn->addOrder(
    "未確認",
    "19-10-05-029",
    "30",
    "11:40",
    "12:50",
    "0975975176",
    "培根蛋餅 x1 (30)"
);
$conn->addOrder(
    "準備中",
    "19-10-05-028",
    "175",
    "11:38",
    "12:40",
    "0975975176",
    "起司蛋餅 x5 (175)"
);
$conn->addOrder(
    "已完成",
    "19-10-05-027",
    "60",
    "11:34",
    "12:30",
    "0975975176",
    "卡拉雞腿堡 x1 (60)"
);
$conn->addOrder(
    "已結帳",
    "19-10-05-026",
    "40",
    "11:32",
    "12:30",
    "0975975176",
    "鮮奶茶 x1 (40)"
);
$conn->addOrder(
    "已結帳",
    "19-10-05-025",
    "130",
    "11:30",
    "12:25",
    "0975975176",
    "鮪魚三明治 x3 (90)、鮮奶茶 x1 (40)"
);
$conn->addOrder(
    "婉拒",
    "19-10-05-024",
    "30",
    "11:20",
    "12:20",
    "0975975176",
    "培根蛋餅 x1 (30)"
);
$conn->addOrder(
    "婉拒",
    "19-10-05-023",
    "60000",
    "11:10",
    "12:10",
    "0975975176",
    "鮮奶茶 x1500 (60000)"
);

//$conn->register("admin", "0000", "管理員", "0", "0", "0");
//$conn->register("0975975176", "123", "傑森史塔森", 20, "男", "sss@gmail.com");
//$conn->register("0987987987", "456", "小瑞", 25, "女", "156785978@gmail.com");


$conn->addCombo("美式套餐",70,"./images/combo/美式套餐.jpg","漢堡,薯條","好吃");
$conn->addCombo("內湖熱狗堡",90,"./images/combo/內湖熱狗堡.jpg","熱狗,熱狗,熱狗","金寶逼你食");
$conn->addCombo("晨博套餐",69,"./images/combo/晨博套餐.jpg","熱狗,荷包蛋","陳柏霖大力推荐");
$conn->addCombo("薯條套餐", 45, "./images/combo/薯條套餐.jpg", "薯條,紅茶", "好ㄘ");
$conn->addCombo("好多飲料套餐", 30, "./images/combo/好多飲料套餐.jpg", "奶茶,紅茶", "豪好喝");
$conn->addCombo("沒有比較便宜套餐", 60, "./images/combo/沒有比較便宜套餐.jpg", "牛肉三明治,紅茶", "好貴");
$conn->addCombo("寫程式好累套餐", 45, "./images/combo/寫程式好累套餐.jpg", "薯條,奶茶", "好累喔");
$conn->addCombo("都是點心套餐", 60, "./images/combo/都是點心套餐.jpg", "薯條,抓餅", "會胖");

$conn->addItem("蘿蔔糕","點心",70,"./images/item/蘿蔔糕.jpg","好吃");
$conn->addItem("炸雞塊","點心",70,"./images/item/炸雞塊.jpg","好吃");
$conn->addItem("熱狗","點心",70,"./images/item/熱狗.jpg","好吃");
$conn->addItem("蛋餅","點心",70,"./images/item/蛋餅.jpg","好吃");
$conn->addItem("包子","點心",70,"./images/item/包子.jpg","好吃");
$conn->addItem("抓餅","點心", 35, "./images/item/抓餅.jpg", "這是點心嗎0.0");

$conn->addItem("鮪魚三明治","三明治",70,"./images/item/鮪魚三明治.jpg","好吃");
$conn->addItem("肌肉三明治","三明治",70,"./images/item/肌肉三明治.jpg","好吃");
$conn->addItem("牛肉三明治","三明治",70,"./images/item/牛肉三明治.jpg","好吃");
$conn->addItem("總匯三明治","三明治",70,"./images/item/總匯三明治.jpg","好吃");
$conn->addItem("里肌三明治","三明治",70,"./images/item/里肌三明治.jpg","好吃");

$conn->addItem("奶茶","飲料",20,"./images/item/奶茶.jpg","保證拉肚子");
$conn->addItem("苦瓜汁","飲料",25,"./images/item/苦瓜汁.jpg","苦");

echo "********************************";
echo "<br>Order 格式<br>";
$test = $conn->getUnFinishOrder();
$test = json_decode($test, true);

foreach ($test as $row) {
    echo "<br>";
    foreach ($row as $key => $value) {
        echo $key . " : " . $value . "<br />";
    }
    break;
}
echo "********************************";
echo "<br>Account 格式<br>";
$test = $conn->getCustomer("user_ID","ASC");
$test = json_decode($test, true);

foreach ($test as $row) {
    echo "<br>";
    foreach ($row as $key => $value) {
        echo $key . " : " . $value . "<br />";
    }
    break;
}
echo "********************************";
echo "<br>Item 格式<br>";
$test = $conn->getItem();
$test = json_decode($test, true);

foreach ($test as $row) {
    echo "<br>";
    foreach ($row as $key => $value) {
        echo $key . " : " . $value . "<br />";
    }
    break;
}
echo "********************************";
echo "<br>Combo 格式<br>";
$test = $conn->getCombo();
$test = json_decode($test, true);

foreach ($test as $row) {
    echo "<br>";
    foreach ($row as $key => $value) {
        echo $key . " : " . $value . "<br />";
    }
    break;
}
echo "********************************";
echo "<br>Combo 格式<br>";
$test = $conn->getCombo();
$test = json_decode($test, true);

foreach ($test as $row) {
    echo "<br>";
    foreach ($row as $key => $value) {
        echo $key . " : " . $value . "<br />";
    }
    break;
}
echo "********************************";
echo "<br>接受訂單時間 格式<br>";
$test = $conn->getOpeningTime();
$test = json_decode($test, true);

foreach ($test as $key=>$value) {
    echo $key . " : " . $value . "<br />";
}
