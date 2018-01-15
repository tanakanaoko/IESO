<?php
// セッション開始！
session_start();
?>


 <!DOCTYPE html>
 <html>
  <head>
   <title>ユーザー登録</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
     </head>
      <body>
　　　　　<h1>ユーザー登録フォーム</h1>

 
投稿
 <form action = "mission_3-7_register1.php" method = "post">
 <p>mailadress:
<input type = "text" name = "mail"><br>
  ユーザー名:
<input type = "text" name = "name"><br>
   パスワード:<input type = "password" name = "pass" ><br>
 パスワード再入力:<input type = "password" name = "repass" >
<input type = "submit" name = "submit" value ="登録"><br><br>
<a href="http://co-673.it.99sv-coco.com/mission_3-7_login.php">ログイン画面はこちら</a>

 </form>

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


//databaseの作成
$sql= "CREATE TABLE userdataregister2"
	." ("
	. "id int not null AUTO_INCREMENT,"
	. "mail char(32),"
	. "name char(32),"
	. "pass char(8),"
	. "urltoken char(255),"
	. "flag char(1),"
	. "unique key(mail),"
	. "primary key(id)"
	.") ";
	$stmt = $pdo->query($sql);


//userregisterに入力
$mail = $_POST["mail"];
 $name = $_POST["name"];
 $pass = $_POST["pass"];
 $repass = $_POST["repass"];

if(isset($_POST["submit"])){
 if( (!empty($mail)) && (!empty($name)) && (!empty($pass)) && (!empty($repass)) ){
  if($pass == $repass){
$sql = $pdo -> prepare("INSERT INTO userdataregister2 (mail, name, pass,urltoken,flag) VALUES (:mail,:name,:pass,:urltoken,:flag)");
$sql -> bindParam(':mail', $mail, PDO::PARAM_STR);
$sql -> bindParam(':name', $name, PDO::PARAM_STR);
$sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
$urltoken = hash('sha256',uniqid(rand(),1));
$sql -> bindParam(':urltoken', $urltoken, PDO::PARAM_STR);
$flag=0;
$sql -> bindParam(':flag', $flag, PDO::PARAM_STR);
//データベースに書き込む
$sql -> execute();//実行

	//メールの宛先
	$mailTo = $mail;
 
	//Return-Pathに指定するメールアドレス
	$returnMail = '////////////////////////';
 
	$name = "掲示板";
	$keijiban_mail = 'web@sample.com';
	$subject = "会員登録用URLのお知らせ";
		
	$url = "http://co-673.it.99sv-coco.com//mission_3-7_register2.php"."?urltoken=".$urltoken;
 
$body = <<< EOM
24時間以内に下記のURLからご登録下さい。
{$url}
EOM;
 
	mb_language('ja');
	mb_internal_encoding('UTF-8');
 
	//Fromヘッダーを作成
	$header = 'From: ' . mb_encode_mimeheader($name). ' <' . $keijiban_mail. '>';
 mail($mailTo, $subject, $body, $header, '-f'. $returnMail);



/*
}else{
echo "<font color='red' >すでに登録されたメールアドレスです</font>";
}*/
echo "<br>"."<br>"."登録内容の確認をします。"."<br>"."ユーザーID:".$mail."<br>";
echo "パスワード:"."****";
}else{
echo "<font color='red' >パスワードが正しく入力されていません</font>"."<br>";
}
}else{
echo "<font color='red' >入力されていない箇所があります</font>"."<br>";
}
}
//テーブルの中身を表示
/*$sql = 'SELECT * FROM userdataregister2';
$results = $pdo -> query($sql);
foreach ($results as $row){
    //$rowの中にはテーブルのカラム名が入る
	echo "<br>".$row['id'].',';
    echo $row['mail'].',';
    echo $row['name'].',';
	echo $row['urltoken'].',';
	echo $row['flag']."<hr>";
}
*/
  //接続終了
    $pdo = null;
}

//接続に失敗した際のエラー処理
catch (PDOException $e){
    print('エラーが発生しました。:'.$e->getMessage());
    die();
}
?>