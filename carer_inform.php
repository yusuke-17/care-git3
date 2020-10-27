<?php
session_start();
date_default_timezone_set('Asia/Tokyo');
require_once("./config/care_config.php");
require_once("./model/care_user.php");

//ログアウト処理
if (isset($_GET['logout'])) {
  $_SESSION = array();
}

//ログインを経由しているか確認
if (!isset($_SESSION['user'])) {
  header('Location:/Care/login.php');
  exit;
}


try {
  $user = new User($host,$dbname,$user,$pass);
  $user->connectDB();
  $id='';
  $inform='';
  if(isset($_POST['inform'])){
      $inform=$_POST['inform'];
  }

  //参照　条件付き
  $result=$user->careFindId($inform);

} catch (PDOException $e) {
  // PDOExceptionをキャッチする
    print "エラー!: " . $e->getMessage() . "<br/gt;";
    die();
}


 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>介護日誌「Care」</title>
    <link rel="stylesheet" href="css/carer_inform.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
  </head>
  <body>
    <header>
      <nav class="navbar navbar-default navbar-expand-md navbar-light py-0 color__navi">
            <div class="container">
                    <a class="navbar-brand" href="carer.php">
                        <h1 class="font-weight-bold color__logo">
                        介護日誌「Care」
                        </h1>
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent"
                            aria-controls="navbarContent" aria-expanded="false" aria-label="スマートフォン用ナビゲーション">
                            <span class="navbar-toggler-icon"></span>
                            <span class="toggler__txt">メニュー</span>
                        </button>
                <div class="navbar-collapse collapse flex-column align-items-end pb-3 pb-md-0" id="navbarContent">
                    <ul class="nav__main navbar-nav order-md-2 mt-3">
                        <li class="nav-item"><a class="nav-link px-4" href="carer.php">入所者一覧</a></li>
                        <!--
                        <li class="nav-item"><a class="nav-link px-4" href="food.php">食事</a></li>
                        <li class="nav-item"><a class="nav-link px-4" href="vital.php">バイタル</a></li>
                        <li class="nav-item"><a class="nav-link px-4" href="excretion.php">排泄</a></li>
                        <li class="nav-item"><a class="nav-link px-4" href="bath.php">風呂</a></li>
                      -->
                    </ul>
                    <ul class="nav__sub navbar-nav navbar-right order-md-1 align-items-center d-block d-md-flex">
                        <li class="nav-item"><a class="nav-link px-4 px-md-0"><i class="fas fa-caret-right d-none d-md-inline"></i>介護職：<?php print $_SESSION['user']['name']; ?></a></li>
                        <li class="nav-item"><a class="nav-link btn btn-rounded px-5 color__btn mx-1 mx-md-0" href="?logout=1">ログアウト</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <table>
      <!--
      <tr class="carer-list">
        <th>写真</th>
        <td><img src="img/face_ojiisan.jpg" alt="老人写真"></td>
      </tr>
    -->
      <tr class="carer-list">
        <th>名前</th>
        <td><?php print $result['name']; ?></td>
      </tr>
      <tr class="carer-list">
        <th>部屋</th>
        <td><?php print $result['room']; ?></td>
      </tr>
      <tr class="carer-list">
        <th>年齢</th>
        <td><?php print $result['age']; ?></td>
      </tr>
      <tr class="carer-list">
        <th>性別</th>
        <td>
          <?php if($result['gender']==="0"){?>
            男
          <?php }if($result['gender']==="1"){?>
            女
          <?php }?>
        </td>
      </tr>
      <tr class="carer-list">
        <th>体重</th>
        <td><?php print $result['weight']; ?></td>
      </tr>
      <tr class="carer-list">
        <th>身長</th>
        <td><?php print $result['height']; ?></td>
      </tr>
      <tr class="carer-list">
        <th>住所</th>
        <td><?php print $result['adress']; ?></td>
      </tr>
      <tr class="carer-list">
        <th>電話番号(保証人）</th>
        <td><?php print $result['guarantor_phone']; ?></td>
      </tr>
      <tr class="carer-list">
        <th>保証人</th>
        <td><?php print $result['guarantor_name']; ?></td>
      </tr>
      <tr class="carer-list">
        <th>住所(保証人)</th>
        <td><?php print $result['guarantor_adress']; ?></td>
      </tr>
    </table>
    <div style="text-align: center;">
    
    </div>
  </body>
</html>
