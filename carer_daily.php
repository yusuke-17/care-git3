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
  $care_id='';
  $daily='';
  //dailyが押された
  if(isset($_POST['daily'])){
      $daily=$_POST['daily'];
  }

  //日誌の名前を取得
  $daily_name=$user->careDailyName($daily);

  //日誌参照　条件付き
  $result=$user->careDailyId($daily);

  if (isset($daily_name['id'])===TRUE) {
      $care_id=$daily_name['id'];//care_idと入所者のidを同じにする
  }

  if (isset($daily_name['name'])===TRUE) {
      $care_name=$daily_name['name'];//入所者の名前を取得
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
    <script>
    $(function(){
      $('.care-button').on('click',function(){
        if ($('input[name="writer"]').val()==='') {
          alert('名前を記入してください');
          $('input[name="writer"]').focus();
          return false;
        }
        if ($('input[name="comment"]').val()==='') {
          alert('内容を記入してください');
          $('input[name="comment"]').focus();
          return false;
        }
    });

    $('.delete_btn').on('click',function(){
      if(!confirm('本当に削除しますか？')){
     /* キャンセルの時の処理 */
     return false;
      }else{
     /*OKの時の処理 */
      }
    });
  })
    </script>
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
    <h2 style="text-align: center; margin-top: 50px;"><?php print $care_name; ?>の日誌</h2>
    <div style="text-align:center;margin: 0 auto;margin-top: 50px;">
      <form name="form" action="care_daily_complete.php" method="POST">
       <label>
          <input type="text" size="30" name="comment" placeholder="内容">
       </label>
       <label>
          <input type="text" size="20" name="writer" value="<?php print $_SESSION['user']['name']; ?>">
       </label>
       <label>
          <input type="datetime-local" size="20" name="created_date">
       </label>
       <input type="submit" name="submit" class="care-button" value="登録">
       <input type="hidden" name="care_id" value="<?php print $care_id; ?>">
     </form>
     <form name="form" action="download.php" method="POST">
       <input type="submit" name="download" class="download-button" value="ダウンロード">
       <input type="hidden" name="care_id" value="<?php print $care_id; ?>">
       <input type="hidden" name="care_name" value="<?php print $care_name; ?>">
     </form>
    </div>
    <table class="carer_table">
      <thead>
        <tr class="carer_status">
          <th>記入者</th>
          <th>内容</th>
          <th>記入時間</th>
          <th>編集</th>
          <th>削除</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($result as $value) { ?>
        <tr>
          <td class="carer-date">
            <?php print $value['writer'];?>
          </td>
          <td>
            <?php print $value['comment']; ?>
          </td>
          <td>
            <?php print $value['created_date']; ?>
          </td>
          <form name="form" action="care_daily_edit.php" method="POST">
          <td>
            <input type="submit" name="daily_edit" class="daily_edit" value="編集">
            <input type="hidden" name="daily_edit" value="<?php print $value['id']; ?>">
          </td>
          </form>
          <form name="form" method="POST" action="care_daily_delete.php">
          <td>
            <input type="submit" class="delete_btn" value="削除">
            <input type="hidden" name="daily_delete" value="<?php print $value['id']; ?>">
          </td>
          </form>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <div style="text-align: center;">

    </div>
  </body>
</html>
