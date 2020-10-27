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

  //入所者の参照処理
    $result=$user->findALL();


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
    <link rel="stylesheet" href="css/carer.css">
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
                        <li class="nav-item active "><a class="nav-link px-4" href="carer.php">入所者一覧</a></li>
                        <!--
                        <li class="nav-item"><a class="nav-link px-4" href="food.php">食事</a></li>
                        <li class="nav-item"><a class="nav-link px-4" href="vital.php">バイタル</a></li>
                        <li class="nav-item"><a class="nav-link px-4" href="excretion.php">排泄</a></li>
                        <li class="nav-item"><a class="nav-link px-4" href="bath.php">風呂</a></li>
                      -->
                    </ul>
                    <ul class="nav__sub navbar-nav navbar-right order-md-1 align-items-center d-block d-md-flex">
                    <li class="nav-item"><a class="nav-link px-4 px-md-0"><i class="fas fa-caret-right d-none d-md-inline"></i>介護職:<?php print $_SESSION['user']['name']; ?></a></li>
                        <li class="nav-item"><a class="nav-link btn btn-rounded px-5 color__btn mx-1 mx-md-0" href="?logout=1">ログアウト</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        </header>
        <table class="carer_table">
          <thead>
          <tr class="carer-list">
            <th>名前</th>
            <th>部屋</th>
            <th>性別</th>
            <th>入所者情報</th>
            <th>入所者日誌</th>
          </tr>
          </thead>
          <tbody>
          <?php foreach ($result as $value) { ?>
          <tr>
            <td class="carer-name"><?php print $value['name']; ?></td>
            <td><?php print $value['room']; ?>号室</td>
            <td>
              <?php if(($value['gender'])==="0"){?>
                男
              <?php }if(($value['gender'])==="1"){?>
                女
              <?php }?>
            </td>
              <form name="form" action="carer_inform.php" method="POST">
              <td>
                  <input type="submit" class="care-button"  value="詳細">
                  <input type="hidden" name="inform" value="<?php print $value['id']; ?>">
              </td>
            </form>
            <form name="form" action="carer_daily.php" method="POST">
            <td>
              <input type="submit" class="care-button"  value="日誌">
              <input type="hidden" name="daily"  value="<?php print $value['id']; ?>">
            </td>
            </form>
          </tr>
          </tbody>
          <?php } ?>
        </table>
        <div style="text-align: center;">

        </div>
  </body>
</html>
