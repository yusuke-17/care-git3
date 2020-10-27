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
  $care_id='';
  $writer='';
  $comment='';

  if (isset($_POST['care_id'])===TRUE) {//名前の表示
    $care_id  = htmlspecialchars($_POST['care_id'], ENT_QUOTES, 'UTF-8');
  }
  if (isset($_POST['writer'])===TRUE) {//記入者の表示
    $writer  = htmlspecialchars($_POST['writer'], ENT_QUOTES, 'UTF-8');
  }
  if (isset($_POST['comment'])===TRUE) {//コメントの表示
    $comment  = htmlspecialchars($_POST['comment'], ENT_QUOTES, 'UTF-8');
  }

  //日誌登録
  if ($_POST) {
    $user->dailyUpdate($_POST);
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
    <link rel="stylesheet" href="css/carer_status.css">
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
    <h1 style="text-align:center">更新出来ました</h1>
    <input type="hidden" name="care_id" value="<?php print $care_id; ?>">
    <input type="hidden" name="comment" value="<?php print $comment; ?>">
    <input type="hidden" name="writer" value="<?php print $writer; ?>">
    <p style="text-align:center">
    <div style="text-align: center; margin-top: 20px;">
    <a href="carer.php" class="care-button">トップページへ</a>
    </div>
    <div style="text-align: center;">

    </div>
  </body>
</html>
