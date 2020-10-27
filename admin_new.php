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
    <link rel="stylesheet" href="css/admin_new.css">
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
                    <li class="nav-item"><a class="nav-link px-4 px-md-0"><i class="fas fa-caret-right d-none d-md-inline"></i>管理者：<?php print $_SESSION['user']['name']; ?></a></li>
                    <li class="nav-item"><a class="nav-link btn btn-rounded px-5 color__btn mx-1 mx-md-0" href="?logout=1">ログアウト</a></li>
                </ul>
            </div>
        </div>
        </nav>
    </header>
    <p style="text-align:center; margin-top: 50px;"><span class="red">*</span>は必須項目</p>
    <table>
      <form name="form" action="admin_confirm.php" enctype="multipart/form-data" method="POST">
      <tr class="carer-list">
        <th>名前<span class="red">*</span></th>
        <td><input type="text" name="name" size="30"></td>
      </tr>
      <tr class="carer-list">
        <th>部屋<span class="red">*</span></th>
        <td><input type="text" name="room" size="10">室</td>
      </tr>
      <tr class="carer-list">
        <th>年齢<span class="red">*</span></th>
        <td><input type="text" name="age" size="10">才</td>
      </tr>
      <tr class="carer-list">
        <th>性別<span class="red">*</span></th>
        <td>
          <select name="gender">
            <option value="0">男</option>
            <option value="1">女</option>
          </select>
        </td>
      </tr>
      <tr class="carer-list">
        <th>体重<span class="red">*</span></th>
        <td><input type="text" name="weight" size="10">kg</td>
      </tr>
      <tr class="carer-list">
        <th>身長<span class="red">*</span></th>
        <td><input type="text" name="height" size="10">cm</td>
      </tr>
      <tr class="carer-list">
        <th>住所<span class="red">*</span></th>
        <td><input type="text" name="adress" size="30"></td>
      </tr>
      <tr class="carer-list">
        <th>保証人</th>
        <td><input type="text" name="guarantor_name" size="30"></td>
      </tr>
      <tr class="carer-list">
        <th>電話番号(保証人）</th>
        <td><input type="text" name="guarantor_phone" size="30"></td>
      </tr>
      <tr class="carer-list">
        <th>住所(保証人)</th>
        <td><input type="text" name="guarantor_adress" size="30"></td>
      </tr>
    </table>
    <div style="text-align: center; margin-top: 20px;">
    <input type="submit" name="submit" class="care-button"  value="確認">
    </div>
    </form>
  </body>
</html>
