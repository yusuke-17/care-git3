<?php
session_start();

require_once("./config/care_config.php");
require_once("./model/care_user.php");

try {
  $user = new User($host,$dbname,$user,$pass);
  $user->connectDB();

//ログイン機能
  if ($_POST) {
    $result = $user->login($_POST);
    if (!empty($result)) {
      $_SESSION['user'] = $result;
      if ($_SESSION['user']['role']==1) {//スタッフがログインする
        header('Location:/Care/carer.php');
        exit;
      }elseif ($_SESSION['user']['role']==0) {//管理者がログインする
        header('Location:/Care/admin.php');
        exit;
      }
    }else {
        $error = "ログインが出来ませんんでした。";
    }
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
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="Care_JS/jquery.js" type="text/jscript"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
    <script>
    </script>
  </head>
<body class="text-center" style="background-image:url('img/bluesky.jpg'); background-size: cover;">
  <form class="form-signin" action="" method="post">
  <h4 h3 mb-3 font-weight-normal class="text-white">介護日誌「Care」</h4>
  <div class="form-group">
    <label for="inputUserId" class="sr-only">ユーザーIDを入力してください</label>
    <?php if (isset($error)) echo "<p class='text-danger'>".$error."</p>" ?>
    <input type="userID" class="form-control" id="inputUserId" placeholder="ユーザーID" name="user_id">
  </div>
  <div class="form-group">
    <label for="inputUserName" class="sr-only">パスワードを入力してください</label>
    <input type="password" class="form-control" id="password" placeholder="パスワード" name="password">
  </div>
  <input type="submit" class="btn btn-primary btn-block btn-lg"  id="enterRoom" value="ログイン">
</form>
</body>
</html>
