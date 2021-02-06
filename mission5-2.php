<!DOCTYPE HTML>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission5-1</title>
</head>
<body>
   <簡易掲示板>
    <hr>
    <?php
    $dsn = 'データベース名';//データベースへの接続
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	
	$sql = "CREATE TABLE IF NOT EXISTS tb5_1"//テーブル作成（存在しない場合）
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "name char(32),"
	. "comment TEXT,"
	. "date TEXT,"
	. "password TEXT"
	.");";
	$stmt = $pdo->query($sql);
	
	
		if(isset($_POST["name"]) &&$_POST["name"]!=""
		   &&isset($_POST["comment"])&&$_POST["comment"]!=""){
	$sql = $pdo -> prepare("INSERT INTO tb5_1 (name, comment, date, password) VALUES (:name, :comment, :date, :password)");
	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	$sql -> bindParam(':date', $date, PDO::PARAM_STR);
	$sql -> bindParam(':password', $password, PDO::PARAM_STR);
	$name = $_POST["name"];
	$comment = $_POST["comment"]; //好きな名前、好きな言葉は自分で決めること
	$password = $_POST["password1"];
	$date = date("Y年m月d日 H時i分s秒");
	$sql -> execute();}
	
	
	if(isset($_POST["commentdelete"])&&$_POST["commentdelete"]!=""
	   &&isset($_POST["password2"])&&$_POST["password2"]!=""){
	    	$id = $_POST["commentdelete"];
	    	$password = $_POST["password2"];
	$sql = 'delete from tb5_1 where id=:id and password = :password';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->bindParam(':password', $password, PDO::PARAM_STR);
	$stmt->execute();
	}
	
	if(isset($_POST["editnumber"])&&$_POST["editnumber"]!=""
	&&isset($_POST["editname"]) &&$_POST["editname"]!=""
	&&isset($_POST["editcomment"])&&$_POST["editcomment"]!=""
    &&isset($_POST["password3"])&&$_POST["password3"]!=""){
	$id =$_POST["editnumber"] ; //変更する投稿番号
	$name = $_POST["editname"];
	$comment = $_POST["editcomment"]; //変更したい名前、変更したいコメントは自分で決めること
	$password = $_POST["password3"];
	$date = date("Y年m月d日 H時i分s秒");
	$sql = 'UPDATE tb5_1 SET name=:name,comment=:comment,date=:date WHERE id=:id  and password=:password';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
	$stmt->bindParam(':date', $date, PDO::PARAM_STR);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->bindParam(':password', $password, PDO::PARAM_STR);
	$stmt->execute();
	}
	?>
	
    <form action="" method="post"  >
        新規投稿：<br>
        名前：<input  type="text" name="name" placeholder="名前を入力してください" value="<?php echo $b ; ?>"><!---->
       コメント： <input  type="text" name="comment" placeholder="コメントを入力してください" value="<?php echo $c ; ?>">
     パスワード： <input  type="text" name="password1" placeholder="パスワードを入力してください">
        <input type="submit" name="submit">
    </form>
    <form action="" method="post"  >
        削除：<br>
        コメント削除： <input  type="number" name="commentdelete" placeholder="数字を入力してください">
        パスワード：<input  type="text" name="password2" placeholder="パスワードを入力してください">
        <input type="submit" name="delete" value="削除">
    </form>
     <form action="" method="post"  >
        編集用：<br>
        番号： <input  type="number" name="editnumber" placeholder="数字を入力してください" >
        名前：<input  type="text" name="editname" placeholder="名前を入力してください" value="<?php echo $b ; ?>"><!---->
       コメント： <input  type="text" name="editcomment" placeholder="コメントを入力してください" value="<?php echo $c ; ?>">
       パスワード：<input  type="text" name="password3" placeholder="パスワードを入力してください">
        <input type="submit" name="edit" value="編集">
    </form>
   
   <hr>
   
   
	<?PHP

	
	$sql = 'SELECT * FROM tb5_1';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].',';
		echo $row['date'].'<br>';
	echo "<hr>";
	}
	
	?>
    
</body>    
</html>