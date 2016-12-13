<?php
//ここにDBからデータを取得する処理を記述する
//１DBへ接続
$dsn = 'mysql:dbname=myfriends;host=localhost';
$user = 'root';
$password = 'mysql';
  
$dbh = new PDO($dsn, $user, $password);
$dbh->query('SET NAMES utf8');


//都道府県ID取得
$data[] = $_GET['area_id'];

//2　SQL作成
//都道府県名取得
 
$sql = 'SELECT * FROM`areas`WHERE `area_id` = ?';


//３　SQL実行

$stmt = $dbh->prepare($sql);
$stmt->execute($data);



//４　データ取得
$rec = $stmt->fetch(PDO::FETCH_ASSOC);

//データ格納用変す

$name = $rec['area_name'];








//2　SQL作成
$sql = 'SELECT * FROM`friends`WHERE `area_id` = ?';

//３　SQL実行
$stmt = $dbh->prepare($sql);
$stmt->execute($data);


////４　データ取得

$friends = array();

//男女カウント用の変数
$male = 0 ;
$female = 0;


while(1){
  //データ取得
  $rec = $stmt->fetch(PDO::FETCH_ASSOC);

  //取得できるデータがなかったらループ終了
  if($rec == false){
    break;
  }
  $friends[] = $rec;

  //男女カウント 0(男)ならOK　ダメたら１（女）などそれ以上の数字をカウント
if($rec['gender'] == 0){
  //男性
  $male++;
}else{
  //女性
  $female++;
}

      // $stmt = $dbh->prepare($sql);
      // $stmt->execute($data);


      //  header('Location: index.php'); // 指定したURLに遷移
      // exit(); // これ以下の処理を停


}



//$_GET['action']が存在する　かつ空でない時、deleteが指定されたいたら削除処理を行う
//削除処理を行ったら、index.phpに画面を遷移する



//issetないと存在しないことになる　箱を想像するissetは箱がある !emptyは箱の中身がある。
   
// データの削除処理
  if (isset($_GET['action']) && !empty($_GET['action']) == 'delete') {

    // if (isset($_GET['action']) && !empty($_GET['action'])){
    //   if(GET['action'] == 'delete'){


    
      // 物理削除
      // $sql = 'DELETE FROM `posts` WHERE `id` = ?';
    $sql = 'DELETE FROM `friends` WHERE `friend_id` = '.$_GET['friend_id'];
    
    // $data[] = $_POST['friend_id'];
    // $data[] = $friend_id;
     

      $stmt = $dbh->prepare($sql);
      $stmt->execute();

      // $friends = $stmt->fetch(PDO::FETCH_ASSOC);

       
       header('Location: index.php'); // 指定したURLに遷移
      exit(); // これ以下の処理を停止
  }
// }




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
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../assets/css/form.css" rel="stylesheet">
    <link href="../assets/css/timeline.css" rel="stylesheet">
    <link href="../assets/css/main.css" rel="stylesheet">

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
       
      <legend><?php echo $name; ?>の友達</legend>
      

      <div class="well">男性：<?php echo $male; ?>名　女性：<?php echo $female; ?>名</div>
        <table class="table table-striped table-hover table-condensed">
          <thead>
            <tr>
              <th><div class="text-center">名前</div></th>
              <th><div class="text-center"></div></th>
            </tr>
          </thead>
          <tbody>
            <!-- 友達の名前を表示 -->
             <?php foreach ($friends as $friend) :?>
            <tr>
              <td><div class="text-center"><?php echo $friend['friend_name']; ?></div></td>
              <td>
                <div class="text-center">
                  <a href="edit.php?friend_id=<?php echo $friend['friend_id'];?>"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
<!--                   

 -->                    

                  <a href="javascript:void(0);" onclick="destroy(<?php echo $friend['friend_id']; ?>);"><i class="fa fa-trash"></i></a>

                </div>
              </td>
            </tr>
             <?php endforeach; ?>
           <!--  <tr>
              <td><div class="text-center">小林　花子</div></td>
              <td>
                <div class="text-center">
                  <a href="edit.php"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                  <a href="javascript:void(0);" onclick="destroy();"><i class="fa fa-trash"></i></a>
                </div>
              </td>
            </tr>
            <tr>
              <td><div class="text-center">佐藤　健</div></td>
              <td>
                <div class="text-center">
                  <a href="edit.php"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                  <a href="javascript:void(0);" onclick="destroy();"><i class="fa fa-trash"></i></a>
                </div>
              </td>
            </tr>
             </div>-->
          </tbody>
        </table>

        <input type="button" class="btn btn-default" value="新規作成" onClick="location.href='new.php'">
        

      </div>
    </div>
  </div>



    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
    function destroy(friend_id) {
    　// ポップアップを表示
    　if(confirm('削除しますか？よろしいでしょうか？')==true){
      //OK押した時 show.php に遷移　リフレッシュする actionでdelete処理を行う Javasquriptは＄が入らない。


      location.href = 'show.php?action=delete&friend_id=' + friend_id;
      return true
    }else{
      //キャンセル押した時
      return false;
    }
  }

</script>
  </body>
</html>
