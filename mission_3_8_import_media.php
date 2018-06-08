<?php
    if(isset($_GET["target"]) && $_GET["target"] !== ""){
        $target = $_GET["target"];
    }
    else{
        header("Location: mission_3-8_index.php");
    }
    $MIMETypes = array(
        'png' => 'image/png',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'mp4' => 'video/mp4'
    );
    $dsn = 'mysql:dbname=co_673_it_99sv_coco_com;host=localhost';

	//DBに接続するためのユーザー名・パスワードを設定
	$user = 'co-673.it.99sv-c';
	$password = 'mNbi8V';
 
	try{
	//データーベースに接続
    $pdo = new PDO($dsn, $user, $password);
        $sql = "SELECT * FROM database3 WHERE fname = :target;";
        $stmt = $pdo->prepare($sql);
        $stmt -> bindValue(":target", $target, PDO::PARAM_STR);
        $stmt -> execute();
        $row = $stmt -> fetch(PDO::FETCH_ASSOC);
        header("Content-Type: ".$MIMETypes[$row["extension"]]);
        echo ($row["raw_data"]);
    }
    catch (PDOException $e) {
        echo("<p>500 Inertnal Server Error</p>");
        exit($e->getMessage());
    }
?>
