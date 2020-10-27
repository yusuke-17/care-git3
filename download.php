<?php
date_default_timezone_set('Asia/Tokyo');

// データベースの接続情報
define( 'DB_HOST', 'localhost');
define( 'DB_USER', 'root');
define( 'DB_PASS', 'root');
define( 'DB_NAME', 'care_table');

// 変数の初期化
$care_id='';
$care_name='';
$csv_data = null;
$sql = null;
$res = null;
$message_array = array();
$name='';

session_start();

if(!empty($_SESSION['user'])) {
  if(isset($_POST['care_id'])){
      $care_id=$_POST['care_id'];
  }
  if(isset($_POST['care_name'])){
      $care_name=$_POST['care_name'];
  }


  // データベースに接続
  $mysqli = new mysqli( DB_HOST, DB_USER, DB_PASS, DB_NAME);

  // 接続エラーの確認
if(!$mysqli->connect_errno ) {
  $sql = "SELECT care_daily_table.id,care_resident_table.name,care_daily_table.writer,care_daily_table.comment,care_daily_table.created_date
          FROM care_daily_table
          INNER JOIN care_resident_table
          ON care_resident_table.id=care_daily_table.care_id
          WHERE care_resident_table.id ='".$care_id."'order by created_date desc";
  $res = $mysqli->query($sql);
  if($res) {
    $message_array = $res->fetch_all(MYSQLI_ASSOC);
  }
  $mysqli->close();
}

// CSVデータを作成
if( !empty($message_array) ){
  // 1行目のラベル作成
  //$csv_data .= '"ID","記入者","内容","投稿日時"'."\n";
  $csv_data .= '"記入者","内容","投稿日時"'."\n";
  foreach( $message_array as $value ) {
    // データを1行ずつCSVファイルに書き込む
    //$csv_data .= '"' . $value['id'] . '","' . $value['writer'] . '","' . $value['comment'] . '","' . $value['created_date'] . "\"\n";
    $csv_data .= '"' . $value['writer'] . '","' . $value['comment'] . '","' . $value['created_date'] ."\"\n";
  }
}


// 出力の設定
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment;filename=$care_name.csv");
header("Content-Transfer-Encoding: binary");


// ファイルを出力
echo $csv_data;

} else {
	// ログインページへリダイレクト
  header('Location:/Care/login.php');
  exit;
}

return;
