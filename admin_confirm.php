<?php
session_start();//セッションスタート
date_default_timezone_set('Asia/Tokyo');
//ログアウト処理
if (isset($_GET['logout'])) {
  $_SESSION = array();
}

//ログインを経由しているか確認
if (!isset($_SESSION['user'])) {
  header('Location:/Care/login.php');
  exit;
}

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

//送信された内容を表示する

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


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>介護日誌「Care」</title>
    <link rel="stylesheet" href="css/admin_inform.css">
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
                    <li class="nav-item"><a class="nav-link px-4 px-md-0"><i class="fas fa-caret-right d-none d-md-inline"></i>管理者 <?php print $_SESSION['user']['name']; ?></a></li>
                    <li class="nav-item"><a class="nav-link btn btn-rounded px-5 color__btn mx-1 mx-md-0" href="?logout=1">ログアウト</a></li>
                </ul>
            </div>
        </div>
        </nav>
    </header>
    <table>
      <form name="form" action="admin_complete.php" enctype="multipart/form-data" method="POST">
      <tr class="carer-list">
        <th>名前</th>
        <td><?php print $name; ?>
          <input type="hidden" name="name" value="<?php print $name; ?>">
        </td>
      </tr>
      <tr class="carer-list">
        <th>部屋</th>
        <td><?php print $room; ?>室
          <input type="hidden" name="room" value="<?php print $room; ?>">
        </td>
      </tr>
      <tr class="carer-list">
        <th>年齢</th>
        <td><?php print $age; ?>才
          <input type="hidden" name="age" value="<?php print $age; ?>">
        </td>
      </tr>
      <tr class="carer-list">
        <th>性別</th>
        <td>
          <?php if($gender==="0"){?>
            男
          <?php }if($gender==="1"){?>
            女
          <?php }?>
          <input type="hidden" name="gender" value="<?php print $gender; ?>">
        </td>
      </tr>
      <tr class="carer-list">
        <th>体重</th>
        <td><?php print $weight; ?>kg
          <input type="hidden" name="weight" value="<?php print $weight; ?>">
        </td>
      </tr>
      <tr class="carer-list">
        <th>身長</th>
        <td><?php print $height; ?>cm
          <input type="hidden" name="height" value="<?php print $height; ?>">
        </td>
      </tr>
      <tr class="carer-list">
        <th>住所</th>
        <td><?php print $adress; ?>
          <input type="hidden" name="adress" value="<?php print $adress; ?>">
        </td>
      </tr>
      <tr class="carer-list">
        <th>保証人</th>
        <td><?php print $guarantor_name; ?>
          <input type="hidden" name="guarantor_name" value="<?php print $guarantor_name; ?>">
        </td>
      </tr>
      <tr class="carer-list">
        <th>電話番号(保証人）</th>
        <td><?php print $guarantor_phone; ?>
          <input type="hidden" name="guarantor_phone" value="<?php print $guarantor_phone; ?>">
        </td>
      </tr>
      <tr class="carer-list">
        <th>住所(保証人)</th>
        <td><?php print $guarantor_adress; ?>
          <input type="hidden" name="guarantor_adress" value="<?php print $guarantor_adress; ?>">
        </td>
      </tr>
    </table>
    <div style="text-align:center">
    <input type="submit" name="submit" class="care-button"  value="登録">
    <input type="button" class="care-button" onclick="location.href='http://localhost/Care/admin_new.php'"  value="戻る">
    </div>
    </form>
    <div style="text-align: center;">

    </div>
  </body>
</html>
