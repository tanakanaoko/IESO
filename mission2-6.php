<?php

 $edit_num = htmlspecialchars($_POST["edit_num"]);
 $edit_pass = htmlspecialchars($_POST["edit_pass"]);

if ( (!empty($edit_num)) && (!empty($edit_pass)) ) {
	$filename = "comments_2-6.txt";
	$comments = file($filename);
		for ( $i=0 ; $i<count($comments) ; $i++) {
		$comment_array = explode("<>",$comments[$i]);
			if ( $edit_num == $comment_array[0] ) {
				if ( $edit_pass == $comment_array[5] ) {
					$before_name = $comment_array[1];
					$before_comment = $comment_array[3];
					$before_comment = str_replace(array("<br />"), "\n", $before_comment);
					$before_title = $comment_array[2];
				}
			}
		 }
	}

?>

 <!DOCTYPE html>
 <html>
  <head>
   <title>好きな本について語ろう！</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
     </head>
      <body>
　　　　　<h1>好きな本について語ろう！</h1>
 
 <?php 

 if ( (!empty($edit_num)) && (!empty($edit_pass)) ) {
	$backup = file("backup_2-6.txt");
	$backup_array = explode("<>",$backup[$edit_num-1]);
		if ( $edit_pass == $backup_array[4] ) {
			echo "名前やコメントを編集した後、{<font color='red' >再投稿ボタン</font>}を押してください";
		}
	}

 ?>
投稿
 <form action = "mission_2-6.php" method = "post">
<div style="padding: 10px; margin-bottom: 10px; border: 1px dotted #333333; border-radius: 5px; background-color: #009999; color: #ffffff;">
 <p>名前:<br>
<input type = "text" name = "name" value = "<?=$before_name;?>" ><br>
タイトル:<br>
<input type = "text" name = "title" value = "<?=$before_title;?>" ><br>
 コメント:<br>
<textarea type = "text" name = "comment" rows="5" cols="40" ><?php echo $before_comment; ?></textarea><br>
 パスワード:<br><input type = "password" name = "pass" >

<input type = "hidden" name = "edit_number" value = "<?=$edit_num;?>" >
<input type = "submit" name = "submit" value ="投稿">
<input type = "submit" name = "again_submit" value ="再投稿"></p>
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

 //countの設定

 if (file_exists("backup_2-6.txt")) {
	$count = count(file("backup_2-6.txt",FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES))+1;
} else {
	$count = 1;
}

 $name = htmlspecialchars($_POST["name"]);
 $comment =htmlspecialchars($_POST["comment"]);
 $comment = str_replace(array("\r\n","\r","\n"), "\n", $comment);
 $comment=nl2br($comment);
 $comment=trim($comment,"\n");
 $comment = str_replace("\n","",$comment);
  $title = htmlspecialchars($_POST["title"]);
  //$data = file("test.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)
 //$text = nl2br($text);
 $pass = htmlspecialchars($_POST["pass"]);
 $time = date("Y/m/d H:i:s");


 //コメントフォームのコメント
if(isset($_POST["submit"])){
	if(empty($name)){
	echo "<font color='red' >名前がありません</font>"."<br>";
	}
	if(empty($title)){
	echo "<font color='red' >本のタイトルがありません</font>"."<br>";
	}
	if(empty($comment)) {
	echo "<font color='red' >コメントがありません</font>"."<br>";
	}
	if(empty($pass)) {
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

//backup_2-6.txtに追記保存

if(isset($_POST["submit"])){
	$fp = fopen("backup_2-6.txt", 'a+');
	if( (!empty($name)) && (!empty($title)) && (!empty($comment)) && (!empty($pass)) ) {
	fwrite($fp,$count."<>".$name."<>".$title.'<>'.$comment."<>".$time."<>".$pass."<>"."\n");
	}
fclose($fp);
}


//comments_2-6.txtに追記保存

 if(isset($_POST["submit"])){
$commentsfp = fopen("comments_2-6.txt", 'a');
	if( (!empty($name)) && (!empty($comment)) && (!empty($pass)) ) {
	fwrite($commentsfp,$count."<>".$name."<>".$title.'<>'.$comment."<>".$time."<>".$pass."<>"."\n");
	}
fclose($commentsfp);
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
$backup = file("backup_2-6.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	if ( (!empty($delete_num)) && (!empty($delete_pass)) ) {
	$backup_array = explode("<>",$backup[$delete_num-1]);
	if ( $delete_pass == $backup_array[5] ) {
	$filename = "comments_2-6.txt";
	$comments = file($filename);
	$fp = fopen($filename, 'w');
		for ( $i=0 ; $i<count($comments) ; $i++) {
		$comment_array = explode("<>",$comments[$i]);
			if ( $delete_num != $comment_array[0] ) {
			fwrite($fp,$comments[$i]);
			}else{
			$deletefp = fopen("delete_2-6.txt", 'a+');
			fwrite($deletefp,$comments[$i]);
			fclose($deletefp);
		}	
		}
		fclose($fp);
	}else{
		echo "<font color='red' >パスワードが違います</font>"."<br>";
		}
	}
}

 //編集フォームのコメント

 $edit_num = htmlspecialchars($_POST["edit_num"]);
 $edit_pass = htmlspecialchars($_POST["edit_pass"]);

if(isset($_POST["edit"])){
	if (empty($edit_num)) {
		echo "<font color='red' >編集対象番号がありません</font>"."<br>";
		}
	if(empty($edit_pass)) {
		echo "<font color='red' >パスワードがありません</font>"."<br>";
		}
	if ( (!empty($edit_num)) && (!empty($edit_pass)) ) {
		$backup = file("backup_2-6.txt");
		$backup_array = explode("<>",$backup[$edit_num-1]);
			if ( $edit_pass != $backup_array[5] ) {
				echo "<font color='red' >パスワードが違います</font>"."<br>";
			}
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
$backup = file("backup_2-6.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	if ( (!empty($edit_number)) && (!empty($edit_name)) && (!empty($edit_title)) && (!empty($edit_comment)) ) {
		$backup_array = explode("<>",$backup[$edit_number-1]);
			if ( ($edit_name != $backup_array[1]) || ($edit_comment != $backup_array[2]) ) {
				$filename = "comments_2-6.txt";
				$comments = file($filename);
				$fp = fopen($filename, 'w+');
					for ( $i=0 ; $i<count($comments) ; $i++) {
						$comment_array = explode("<>",$comments[$i]);
							if ( $edit_number != $comment_array[0] ) {
								fwrite($fp,$comments[$i]);
							}else{
								fwrite($fp,$comment_array[0]."<>".$edit_name."<>".$edit_title."<>".$edit_comment."<>".$time."<>".$comment_array[5]."<>"."\n");
							}
						 }
					fclose($fp);
		}else{
			echo "<font color='red' >編集されていません。</font>"."<br>";
		}
	}
}

 //comments_2-6.txtの表示

$comments = file("comments_2-6.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

for ( $i=0 ; $i<count($comments) ; $i++) {
	$comment_array = explode("<>",$comments[$i]);
	echo $comment_array[0].' '.$comment_array[1]."<br>";
	echo "<font color='blue' >タイトル:</font>";
	echo $comment_array[2]."<br>";
	//echo "<font color='blue' >コメント:</font>";
	echo $comment_array[3].' '.$comment_array[4];
	echo "<hr>";
}
?>
