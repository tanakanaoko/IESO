
 <!DOCTYPE html>
 <html>
  <head>
   <title>ログイン</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
     </head>
      <body>
　　　　　<h1>ユーザーログイン</h1>

 
 <form action = "mission_3-7_login.php" method = "post">
  ユーザー名:
<input type = "text" name = "login_id"><br>
   パスワード:<input type = "password" name = "login_pass" ><br>
<input type="checkbox" name="keep_login"> 次回からログインを省略する<br>
<input type = "submit" name = "login" value ="ログイン">

 </form>

 </body>

</html>

<?php
// セッション開始！
session_start();
var_dump($_SESSION);
echo "<br>";

if($_POST['keep_login'] != ''){
session_set_cookie_params(365 * 24 * 3600);
}else{
session_set_cookie_params(0);
}

//DBにMysql、データベース名・testを指定。
$dsn = 'mysql:dbname=co_673_it_99sv_coco_com;host=localhost';

//DBに接続するためのユーザー名・パスワードを設定
$user = 'co-673.it.99sv-c';
$password = 'mNbi8V';
 
try{
//データーベースに接続
    $pdo = new PDO($dsn, $user, $password);
	

//MySQLがつながった時の処理

if(isset($_POST["login"])){      //loginボタンを押したら
 if (empty($_POST["login_id"])) {  // emptyは値が空のとき
       echo "<font color='red' >ログインIDがありません</font>"."<br>";
    }if (empty($_POST["login_pass"])) {
        echo "<font color='red' >パスワードがありません</font>"."<br>";
    }
}

if(isset($_POST["login"])){ 
if ( (!empty($_POST["login_id"])) && (!empty($_POST["login_pass"])) ) {
//$userid = $_POST["userid"];
$login_id = $_POST["login_id"];
$login_pass = $_POST["login_pass"];
//$_SESSION['login_id']=$login_id;
//echo $login_pass;
$sql = "SELECT * FROM userdataregister2 WHERE mail = '$login_id'";//nameが同じものを選択
// SQLステートメントを実行し、結果を変数に格納
$stmt = $pdo -> query($sql) -> fetch(PDO::FETCH_ASSOC);
var_dump($stmt);
//echo $sql;
//echo "<br>";
//var_dump($stmt);
	if($stmt['flag']=='1'){
			if ( $login_pass == $stmt['pass'] ) {
			$_SESSION['userid']=$stmt['name'];
			$_SESSION['login_id']=$login_id;
			 header("Location: mission_3-8_index.php");
			exit;
}else{
echo "<font color='red' >ログインIDまたはパスワードが違います</font>"."<br>";
$_SESSION = array();

if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-42000, '/');
}
}
}else{
echo "<font color='red' >本登録を完了してください</font>"."<br>";
}
}
}
$sql = 'SELECT * FROM userdataregister2';
$results = $pdo -> query($sql);
foreach ($results as $row){
    //$rowの中にはテーブルのカラム名が入る
	echo "<br>".$row['id'].',';
    echo $row['mail'].',';
    echo $row['name'].',';
	echo $row['urltoken'].',';
	echo $row['flag']."<hr>";
}

  //接続終了
    $pdo = null;
}

//接続に失敗した際のエラー処理
catch (PDOException $e){
    print('エラーが発生しました。:'.$e->getMessage());
    die();
}
?>
