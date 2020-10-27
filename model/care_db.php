<?php
require_once("config/care_config.php");
date_default_timezone_set('Asia/Tokyo');
class db{
  //プロパティ
  private $host;
  private $dbname;
  private $user;
  private $pass;
  protected $connent;
  //コンストラクト
  function __construct($host,$dbname,$user,$pass){
    $this->host=$host;
    $this->dbname=$dbname;
    $this->user=$user;
    $this->pass=$pass;
  }
  //メソッド
  public function connectDB(){
    $this->connect = new PDO('mysql:host='.$this->host.';dbname='.$this->dbname, $this->user, $this->pass);
    if (!$this->connect) {
      echo "DB不可";
      die();
    }
  }
}
