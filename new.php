<?php 
  // DB接続
  $dsn = 'mysql:dbname=myfriends;host=localhost';
  $user = 'root';
  $password = '';
  $dbh = new PDO($dsn,$user,$password);
  $dbh->query('SET NAMES utf8');

  // areasテーブルのデータ全件取得
   $sql = 'SELECT * FROM `areas` WHERE 1';

   $stmt = $dbh->prepare($sql);
   $stmt->execute();

   $areas = array();

   while(true){
      $record = $stmt->fetch(PDO::FETCH_ASSOC);

      if($record == false){
        break;
      }

      $areas[] = $record;

    }


    // 10/24追加
    // friendsテーブルからデータを取得する
   $sql = 'SELECT * FROM `friends` WHERE 1';

   $stmt = $dbh->prepare($sql);
   $stmt->execute();


   // 男女カウント用の変数を用意(while文の外に書く)
   // while内に入れてしまうとカウントを0に戻してしまう
    $male = 0;
    $female =0;

    while(true){
      $record = $stmt->fetch(PDO::FETCH_ASSOC);

      if($record == false){
        break;
      }

      // // 男女のカウントプログラム
      if($record['gender'] == 0){
          $male++;
          // $male = $male + 1;
      }elseif($record['gender'] == 1){
          $female++;
        }

    }


    // 登録ボタンが押されたら(もし$_POSTが空でなければ)処理を実行
    if(!empty($_POST)){
    // ①$_POSTに格納された送信データをechoを使って出力

      // $_POSTとはPHPにあらかじめ用意されたスーパーグローバル変数
      // formからmethod="post"でデータが送信された際、内部で $_POSTが生成される
      // $_POSTはformの要素に指定されたキー(name)と実際に入力された値(value)で構成された連想配列
      // $_POST = array("name"=>"友達11","area_id"=>10,"gender"=>1,"age"=>27)

      // echo '<br>';
      // echo '<br>';
      // echo $_POST;
      echo '<pre>';
      var_dump($_POST);
      echo '</pre>';

      // echo $_POST['friend_name'];
      // echo '<br>';
      // echo $_POST['area_id'];
      // echo '<br>';
      // echo $_POST['gender'];
      // echo '<br>';
      // echo $_POST['age'];
      // echo '<br>';


        // 前日に自力で作った文
      // $friend_name = $_POST['friend_name'];
      // $area_id = $_POST['area_id'];
      // $gender = $_POST['gender'];
      // $age = $_POST['age'];

      // $sql = 'INSERT INTO `friends`(`friend_name`,`area_id`,`gender`,`age`) VALUES(”'.$friend_name.'","'.$area_id.'","'.$gender.'","'.$age.'")';
      // $stmt = $dbh->prepare($sql);
      // $stmt->execute();

      // $edit_data = $stmt->fetch(PDO::FETCH_ASSOC);

      // echo $friend_name;
      // echo $area_id;
      // echo $gender;
      // echo $age;




      // ②登録処理実装
      // INSERT INTO `テーブル名` SET 'カラム名1' = 値1,`カラム名2` =値2
      $sql = 'INSERT INTO `friends` SET `friend_name`=?, `area_id`=?,`gender`=?,`age`=?,`created`=now()';


      // 代入したいデータを定義する
      $data[] = $_POST["friend_name"];
      $data[] = $_POST["area_id"];
      $data[] = $_POST["gender"];
      $data[] = $_POST["age"];

      // データをセットして実行
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);


      // another way
      // $friend_name = $_POST['friend_name'];
      // $area_id = $_POST['area_id'];
      // $gender = $_POST['gender'];
      // $age = $_POST['age'];

      // $sql = 'INSERT INTO `friends`(`friend_name`,`area_id`,`gender`,`age`) VALUES("'.$friend_name.'","'.$area_id.'","'.$gender.'","'.$age.'"")';

      // $stmt = $dbh->prepare($sql);
      // $stmt->execute();

      // echo $friend_name;
      // echo $area_id;
      // echo $gender;
      // echo $age;



      // index.phpに戻りたい
      // header('Location: index.php');
      // 登録された都道府県のshow.phpに遷移してほしい



      // exit();
      // 赤く表示されるのはPHPの言語基盤
      // exit...処理停止

    }


      $dbh = null;

    

 ?>


<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>myFriends</title>

    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="assets/css/form.css" rel="stylesheet">
    <link href="assets/css/timeline.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header page-scroll">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="index.php"><span class="strong-title"><i class="fa fa-facebook-square"></i> My friends</span></a>
          </div>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
              </ul>
          </div>
          <!-- /.navbar-collapse -->
      </div>
      <!-- /.container-fluid -->
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-md-4 content-margin-top">
        <legend>友達の登録</legend>


       
        <form method="post" action="" class="form-horizontal" role="form">
           


            <!-- 名前 -->

            
            <div class="form-group">
              <label class="col-sm-2 control-label">名前</label>
              <div class="col-sm-10">
                <input type="text" name="friend_name" class="form-control" placeholder="例：山田　太郎">
              </div>
            </div>
          

            <!-- 出身 -->


            <div class="form-group">
              <label class="col-sm-2 control-label">出身</label>
              <div class="col-sm-10">
                <select class="form-control" name="area_id">
                  <option value="0">出身地を選択</option>

                  <!-- foreach文で繰り返し -->
                  <?php foreach($areas as $area) : ?>
                  <option value="<?php echo $area['area_id']; ?>"><?php echo $area['area_name']; ?></option>
                  <?php endforeach ; ?>

                </select>
              </div>
            </div>


            <!-- 性別 -->
            <!-- 10/24 ここで登録した性別をshow.phpに反映させないといけない -->

            <div class="form-group">
              <label class="col-sm-2 control-label">性別</label>
              <div class="col-sm-10">
                <select class="form-control" name="gender">
                  <option value="0">性別を選択</option>
                  <option value="0">男性</option>
                  <option value="1">女性</option>
                </select>
              </div>
            </div>


            <!-- 年齢 -->
            

            <div class="form-group">
              <label class="col-sm-2 control-label">年齢</label>
              <div class="col-sm-10">
                <input type="text" name="age" class="form-control" placeholder="例：27">
              </div>
            </div>


           <input type="submit" class="btn btn-default" value="登録">
        </form>
      </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>