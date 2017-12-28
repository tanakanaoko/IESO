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
$sql= "CREATE TABLE database2"
	." ("
	. "id int not null AUTO_INCREMENT,"
	. "name char(32),"
	. "title char(32),"
	. "comment TEXT,"
	. "registry_datetime DATETIME,"
	. "pass char(8),"
	. "primary key(id)"
	.") ";
	$stmt = $pdo->query($sql);
	

//編集ボタンを押した後にテキストボックスに挿入
 $edit_num = htmlspecialchars($_POST["edit_num"]);
 $edit_pass = htmlspecialchars($_POST["edit_pass"]);

if ( (!empty($edit_num)) && (!empty($edit_pass)) ) {
$sql = "SELECT * FROM database2 WHERE id = $edit_num";
// SQLステートメントを実行し、結果を変数に格納
$stmt = $pdo -> query($sql) -> fetch(PDO::FETCH_ASSOC);
			if ( $edit_num == $stmt['id'] ) {
				if ( $edit_pass == $stmt['pass'] ) {
					$before_name = $stmt['name'];
					$before_comment = $stmt['comment'];
					$before_comment = str_replace(array("<br />"), "\n", $before_comment);
					$before_title = $stmt['title'];
					$result = $pdo->query($sql);
					//echo "<font color='blue' >再投稿ボタンを押してください</font>";
				
			}
		 }
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

 <!DOCTYPE html>
 <html>
  <head>
   <title>今はまっているアプリは？</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
     </head>
      <body>
　　　　　<h1>今はまっているアプリは？</h1>

 
投稿
 <form action = "mission_2-15.php" method = "post">
<div style="padding: 10px; margin-bottom: 10px; border: 1px dotted #333333; border-radius: 5px; background-color: #009999; color: #ffffff;">
 <p>名前:<br>
<input type = "text" name = "name" value = "<?=$before_name;?>" ><br>
アプリ名:<br>
<input type = "text" name = "title" value = "<?=$before_title;?>" ><br>
 コメント:<br>
<textarea type = "text" name = "comment" rows="5" cols="40" ><?php echo $before_comment; ?></textarea><br>
 パスワード:<br><input type = "password" name = "pass" >

<input type = "hidden" name = "edit_number" value = "<?=$edit_num;?>" >
<input type = "submit" name = "submit" value ="投稿">
<input type = "submit" name = "again_submit" value ="編集"></p>
</div>

編集・削除
<div style="padding: 10px; margin-bottom: 10px; border: 1px dotted #333333; border-radius: 5px; background-color: #4169e1; color: #ffffff;">
<p> 削除対象番号:<input type = "text" name = "delete_num" size ="5" >
 パスワード:<input type = "password" name = "delete_pass">

<input type = "submit" name = "delete" value ="削除"></p>

<p>編集対象番号:<input type = "text" name = "edit_num" size ="5" >
 パスワード:<input type = "password" name = "edit_pass">
<input type = "submit" name = "edit" value ="編集"></p>
</div>
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


//databasetxtに入力
$sql = $pdo -> prepare("INSERT INTO database2 (name, title, comment,registry_datetime, pass) VALUES (:name,:title,:comment,:registry_datetime,:pass)");

$sql -> bindParam(':name', $name, PDO::PARAM_STR);
$sql -> bindParam(':title', $title, PDO::PARAM_STR);
$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
$sql -> bindParam(':registry_datetime', $time, PDO::PARAM_STR);
$sql -> bindParam(':pass', $pass, PDO::PARAM_STR);

$name = htmlspecialchars($_POST["name"]);
 $comment =htmlspecialchars($_POST["comment"]);
  $comment = str_replace(array("\r\n","\r","\n"), "\n", $comment);
   $comment=nl2br($comment);
    $comment=trim($comment,"\n");
     $comment = str_replace("\n","",$comment);
 $title = htmlspecialchars($_POST["title"]);
 $pass = htmlspecialchars($_POST["pass"]);
 $time = date("Y/m/d H:i:s");
 if(isset($_POST["submit"])){
 if( (!empty($name)) && (!empty($title)) && (!empty($comment)) && (!empty($pass)) ){
$sql -> execute();//実行
}
}


 //コメントフォームのコメント
if(isset($_POST["submit"])){
	if(empty($name)){
	echo "<font color='red' >名前がありません</font>"."<br>";
	}
	if(empty($title)){
	echo "<font color='red' >本のタイトルがありません</font>"."<br>";
	}
	if(empty($comment)){
	echo "<font color='red' >コメントがありません</font>"."<br>";
	}
	if(empty($pass)){
	echo "<font color='red' >パスワードがありません</font>"."<br>";
	}
}

if(isset($_POST["again_submit"])){
	if(empty($name)){
	echo "<font color='red' >名前がありません</font>"."<br>";
	}
	if(empty($title)){
	echo "<font color='red' >本のタイトルがありません</font>"."<br>";
	}
	if(empty($comment)) {
		echo "<font color='red' >コメントがありません</font>"."<br>";
	}
}


 //削除フォームのコメント

 $delete_num = htmlspecialchars($_POST["delete_num"]);
 $delete_pass = htmlspecialchars($_POST["delete_pass"]);

 if(isset($_POST["delete"])){
	if (empty($delete_num)) {
	echo "<font color='red' >削除対象番号がありません</font>"."<br>";
	}
	if(empty($delete_pass)) {
	echo "<font color='red' >パスワードがありません</font>"."<br>";
	}
}

 //削除機能

if(isset($_POST["delete"])){
	if ( (!empty($delete_num)) && (!empty($delete_pass)) ) {
$sql = "SELECT * FROM database2 WHERE id = $delete_num";
// SQLステートメントを実行し、結果を変数に格納
$stmt = $pdo -> query($sql);
// foreach文で配列の中身を一行ずつ出力
foreach ($stmt as $row) {
 //passとdelete_passが等しかったら
if($row['pass'] == $delete_pass){
	$sql = "delete from database2 where id=$delete_num";  
	$result = $pdo->query($sql);
	}else{
		echo "<font color='red' >パスワードが違います</font>"."<br>";
		}
	}
}
}

 //編集フォームのコメント

if(isset($_POST["edit"])){
	if (empty($edit_num)) {
		echo "<font color='red' >編集対象番号がありません</font>"."<br>";
		}
	if(empty($edit_pass)) {
		echo "<font color='red' >パスワードがありません</font>"."<br>";
		}
	}





 //編集機能

if(isset($_POST["again_submit"])){
$edit_name = htmlspecialchars($_POST["name"]);
$edit_comment = htmlspecialchars($_POST["comment"]);
	$edit_comment = str_replace(array("\r\n","\r","\n"), "\n", $comment);
	$edit_comment=nl2br($comment);
	$edit_comment=trim($comment,"\n");
	$edit_comment = str_replace("\n","",$comment);
$edit_title = htmlspecialchars($_POST["title"]);
$edit_number = htmlspecialchars($_POST["edit_number"]);
	if ( (!empty($edit_number)) && (!empty($edit_name)) && (!empty($edit_title)) && (!empty($edit_comment)) ) {
			$sql = "SELECT * FROM database2 WHERE id = $edit_number";
// SQLステートメントを実行し、結果を変数に格納
$stmt = $pdo -> query($sql) -> fetch(PDO::FETCH_ASSOC);
//var_dump($stmt);
//var_dump($stmt['pass']);
//echo $edit_pass;
if($edit_pass = $stmt['pass']){
		$sql = "update database2 set name='$edit_name' , title = '$edit_title' , comment='$edit_comment' where id = $edit_number"; 
				$result = $pdo->query($sql);
				//var_dump($result);
							}else{
		echo "<font color='red' >パスワードが違います</font>"."<br>";
		}
						 }
						 }
						 


 //表示

$sql = 'SELECT * FROM database2';
$results = $pdo -> query($sql);
foreach ($results as $row){
    //$rowの中にはテーブルのカラム名が入る
    echo $row['id'].'  '.$row['name'].' '.$row['registry_datetime']."<br>";
	echo "<font color='blue' >アプリ名:</font>";
	echo $row['title']."<br>".$row['comment']."<hr>";
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