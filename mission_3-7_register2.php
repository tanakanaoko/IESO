<?php
// セッション開始！
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>会員登録画面</title>
<meta charset="utf-8">
</head>
<body>
<h1>会員登録画面</h1>
</body>
</html>

<?php

//DBにMysql、データベース名・testを指定。
$dsn = 'mysql:dbname=co_673_it_99sv_coco_com;host=localhost';

//DBに接続するためのユーザー名・パスワードを設定
$user = 'co-673.it.99sv-c';
$password = 'mNbi8V';
 
try{
//データーベースに接続
    $pdo = new PDO($dsn, $user, $password);
	

//MySQLがつながった時の処理

if(empty($_GET)) {
	header("Location: mission_3-7_register1.php");
	exit();
}else{
	//GETデータを変数に入れる
	$urltoken = isset($_GET[urltoken]);
			$sql = 'SELECT * FROM userdataregister2';
			$results = $pdo -> query($sql);
	//メール入力判定
	if (empty($urltoken)){
		 echo "もう一度登録をやりなおして下さい。";
	}else{
			//flagが0の未登録者・仮登録日から24時間以内
			/*
			$sql = "SELECT * FROM userdataregister2 WHERE urltoken='$urltoken'";
			$results = $pdo -> query($sql);
			*/
			$sql = $pdo -> prepare("update userdataregister2 set flag=:flag where urltoken=:urltoken");
			$sql -> bindValue(':flag', '1', PDO::PARAM_STR);
			$sql -> bindParam(':urltoken', $_GET['urltoken'], PDO::PARAM_STR);
			$sql -> execute();//実行
			echo "会員登録が完了しました。";
			 
			}
}
/*$sql = 'SELECT * FROM userdataregister2';
$results = $pdo -> query($sql);
foreach ($results as $row){
    //$rowの中にはテーブルのカラム名が入る
    echo $row['id'].',';
    echo $row['mail'].',';
    echo $row['name'].',';
	echo $row['urltoken'].',';
	echo $row['flag']."<hr>";
}*/
			 //接続終了
    $pdo = null;
}

//接続に失敗した際のエラー処理
catch (PDOException $e){
    print('エラーが発生しました。:'.$e->getMessage());
    die();
}

 
?>
<!DOCTYPE html>
<html>
<head>
 <meta charset="utf-8">
</head>
<body>
 <li><a href="http://co-673.it.99sv-coco.com/mission_3-7_login.php">ログイン画面</a></li>
</body>
</html>

