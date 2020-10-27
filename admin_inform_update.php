<?php
session_start();//セッションスタート
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
  $name='';
  $room='';
  $age='';
  $gender='';
  $weight='';
  $height='';
  $adress='';
  $guarantor_phone='';
  $guarantor_name='';
  $guarantor_adress='';

  //確認ボタンが押されたら、内容を表示

  if (isset($_POST['id'])===TRUE) {
    $id  = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
  }

  if (isset($_POST['name'])===TRUE) {
    $name  = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
  }

  if (isset($_POST['room'])===TRUE) {
    $room  = htmlspecialchars($_POST['room'], ENT_QUOTES, 'UTF-8');
  }

  if (isset($_POST['age'])===TRUE) {
    $age  = htmlspecialchars($_POST['age'], ENT_QUOTES, 'UTF-8');
  }

  if (isset($_POST['gender'])===TRUE) {
    $gender  = htmlspecialchars($_POST['gender'], ENT_QUOTES, 'UTF-8');
  }

  if (isset($_POST['weight'])===TRUE) {
    $weight  = htmlspecialchars($_POST['weight'], ENT_QUOTES, 'UTF-8');
  }

  if (isset($_POST['height'])===TRUE) {
    $height  = htmlspecialchars($_POST['height'], ENT_QUOTES, 'UTF-8');
  }

  if (isset($_POST['adress'])===TRUE) {
    $adress  = htmlspecialchars($_POST['adress'], ENT_QUOTES, 'UTF-8');
  }

  if (isset($_POST['guarantor_phone'])===TRUE) {
    $guarantor_phone  = htmlspecialchars($_POST['guarantor_phone'], ENT_QUOTES, 'UTF-8');
  }

  if (isset($_POST['guarantor_name'])===TRUE) {
    $guarantor_name  = htmlspecialchars($_POST['guarantor_name'], ENT_QUOTES, 'UTF-8');
  }

  if (isset($_POST['guarantor_adress'])===TRUE) {
    $guarantor_adress  = htmlspecialchars($_POST['guarantor_adress'], ENT_QUOTES, 'UTF-8');
  }

  //入所者の更新処理
  if (isset($_POST['update'])) {
    $user->careUpdate($_POST);
  }


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
    <link rel="stylesheet" href="css/admin_informedit.css">
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
                <a class="navbar-brand" href="admin.php">
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
                    <li class="nav-item active "><a class="nav-link px-4" href="admin.php">入所者</a></li>
                    <li class="nav-item"><a class="nav-link px-4" href="admin_user.php">スタッフ</a></li>
                </ul>
                <ul class="nav__sub navbar-nav navbar-right order-md-1 align-items-center d-block d-md-flex">
                    <li class="nav-item"><a class="nav-link px-4 px-md-0"><i class="fas fa-caret-right d-none d-md-inline"></i>管理者：<?php print $_SESSION['user']['name']; ?></a></li>
                    <li class="nav-item"><a class="nav-link btn btn-rounded px-5 color__btn mx-1 mx-md-0" href="?logout=1">ログアウト</a></li>
                </ul>
            </div>
        </div>
        </nav>
    </header>
    <h1 style="text-align:center">更新出来ました</h1>
    <input type="hidden" name="name" value="<?php print $name; ?>">
    <input type="hidden" name="room" value="<?php print $room; ?>">
    <input type="hidden" name="age" value="<?php print $age; ?>">
    <input type="hidden" name="gender" value="<?php print $gender; ?>">
    <input type="hidden" name="weight" value="<?php print $weight; ?>">
    <input type="hidden" name="height" value="<?php print $height; ?>">
    <input type="hidden" name="adress" value="<?php print $adress; ?>">
    <input type="hidden" name="guarantor_phone" value="<?php print $guarantor_phone; ?>">
    <input type="hidden" name="guarantor_name" value="<?php print $guarantor_name; ?>">
    <input type="hidden" name="guarantor_adress" value="<?php print $guarantor_adress; ?>">
    <p style="text-align:center">
    <div style="text-align: center; margin-top: 20px;">
    <a href="admin.php" class="care-button" style="">トップページに戻る</a>
    </div>
  </body>
  <div style="text-align: center;">

  </div>
</html>
