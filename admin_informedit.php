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

//ログインを経由しているか確認
if (!isset($_SESSION['user'])) {
  header('Location:/Care/login.php');
  exit;
}

try {
  $user = new User($host,$dbname,$user,$pass);
  $user->connectDB();
  $id='';
  $care_edit='';

  if(isset($_POST['care_edit'])){
      $care_edit=$_POST['care_edit'];
  }

  //参照　条件付き
  $result=$user->careFindId($care_edit);


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
    <script>
    $(function(){
      $('.care-button').on('click',function(){
        if ($('input[name="name"]').val()==='') {
          alert('必須項目を記入してください');
          $('input[name="name"]').focus();
          return false;
        }else if ($('input[name="name"]').val().match(/^\d+$/)) {
          alert('数字を入れないでください');
          $('input[name="name"]').focus();
          return false;
        }
        if ($('input[name="room"]').val()==='') {
          alert('必須項目を記入してください');
          $('input[name="room"]').focus();
          return false;
        }else if (!$('input[name="room"]').val().match(/^\d+$/)) {
          alert('数字を入れてください');
          $('input[name="room"]').focus();
          return false;
        }
        if ($('input[name="age"]').val()==='') {
          alert('必須項目を記入してください');
          $('input[name="age"]').focus();
          return false;
        }else if (!$('input[name="age"]').val().match(/^\d+$/)) {
          alert('数字を入れてください');
          $('input[name="age"]').focus();
          return false;
        }else if (!$('input[name="age"]').val().match(/^[0-9a-zA-Z]*$/)) {
          alert('半角英数字を入れてください');
          $('input[name="age"]').focus();
          return false;
        }
        if ($('input[name="weight"]').val()==='') {
          alert('必須項目を記入してください');
          $('input[name="weight"]').focus();
          return false;
        }else if (!$('input[name="weight"]').val().match(/^\d+$/)) {
          alert('数字を入れてください');
          $('input[name="weight"]').focus();
          return false;
        }else if (!$('input[name="weight"]').val().match(/^[0-9a-zA-Z]*$/)) {
          alert('半角英数字を入れてください');
          $('input[name="weight"]').focus();
          return false;
        }
        if ($('input[name="height"]').val()==='') {
          alert('必須項目を記入してください');
          $('input[name="height"]').focus();
          return false;
        }else if (!$('input[name="height"]').val().match(/^\d+$/)) {
          alert('数字を入れてください');
          $('input[name="height"]').focus();
          return false;
        }else if (!$('input[name="height"]').val().match(/^[0-9a-zA-Z]*$/)) {
          alert('半角英数字を入れてください');
          $('input[name="height"]').focus();
          return false;
        }
        if ($('input[name="adress"]').val()==='') {
          alert('必須項目を記入してください');
          $('input[name="adress"]').focus();
          return false;
        }
    });
  })
    </script>
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
    <form name="form" action="admin_inform_update.php" method="POST">
    <table>
      <tr>
        <th>名前</th>
        <td><input type="text" name="name" value="<?php print $result['name']; ?>"></td>
      </tr>
      <tr>
        <th>部屋</th>
        <td><input type="text" name="room" value="<?php print $result['room']; ?>"></td>
      </tr>
      <tr>
        <th>年齢</th>
        <td><input type="text" name="age" value="<?php print $result['age']; ?>"></td>
      </tr>
      <tr>
        <th>性別</th>
        <td>
          <select name="gender">
            <option value="0">男</option>
            <option value="1">女</option>
          </select>
        </td>
      </tr>
      <tr>
        <th>体重</th>
        <td><input type="text" name="weight" value="<?php print $result['weight']; ?>"></td>
      </tr>
      <tr>
        <th>身長</th>
        <td><input type="text" name="height" value="<?php print $result['height']; ?>"></td>
      </tr>
      <tr>
        <th>住所</th>
        <td><input type="text" name="adress" value="<?php print $result['adress']; ?>"></td>
      </tr>
      <tr>
        <th>電話番号(保証人)</th>
        <td><input type="text" name="guarantor_phone" value="<?php print $result['guarantor_phone']; ?>"></td>
      </tr>
      <tr>
        <th>保証人</th>
        <td><input type="text" name="guarantor_name" value="<?php print $result['guarantor_name']; ?>"></td>
      </tr>
      <tr>
        <th>住所(保証人)</th>
        <td><input type="text" name="guarantor_adress" value="<?php print $result['guarantor_adress']; ?>"></td>
      </tr>
    </table>
    <div style="text-align: center; margin-top: 20px;">
    <input type="submit" name="update" class="care-button" value="更新">
    <input type="hidden" name="id" value="<?php print $result['id']; ?>">
    </div>
    </form>
    <div style="text-align: center;">

    </div>
  </body>
</html>
