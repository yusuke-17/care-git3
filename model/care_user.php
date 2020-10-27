<?php
require_once("care_db.php");
date_default_timezone_set('Asia/Tokyo');

class User extends db{
  //ログイン
  public function login($arr){
    $sql = 'SELECT * FROM care_user_table WHERE user_id=:user_id AND password=:password';
    $stmt = $this->connect->prepare($sql);
    $params = array(
       ":user_id"=>$arr['user_id'],
       ":password"=> $arr['password'],
        );
    $stmt->execute($params);
    $result =$stmt->fetch();
    //$result = $stmt->rowCount();
    return $result;
  }

  //全員の入所者参照　選択
  public function findALL(){
    $sql = 'SELECT * FROM care_resident_table';
    $stmt = $this->connect->prepare($sql);
    $stmt->execute();
    $result =$stmt->fetchAll();
    return $result;
  }

  //全員のスタッフ参照　選択
  public function staffFindALL(){
    $sql = 'SELECT * FROM care_user_table';
    $stmt = $this->connect->prepare($sql);
    $stmt->execute();
    $result =$stmt->fetchAll();
    return $result;
  }

  //スタッフの登録
  public function staffAdd($arr){
    $sql = "INSERT INTO care_user_table(name, gender, role, user_id, password,created_at,updated_at)
            VALUES (:name, :gender, :role, :user_id, :password ,:created_at,:updated_at)";
    $stmt = $this->connect->prepare($sql);
    $params = array(
       ":name"=> $arr['name'],
       ":gender" => $arr['gender'],
       ":role" =>1,
       ":user_id" =>$arr['user_id'],
       ":password"=>$arr['password'],
       ":created_at"=>date('Y-m-d H:i:s'),
       ":updated_at"=>date('Y-m-d H:i:s')
     );
    $stmt->execute($params);
  }



  //入所者の登録
  public function add($arr){
    $sql = "INSERT INTO care_resident_table(name,room,age,gender,weight,height,adress,guarantor_phone,guarantor_name,guarantor_adress,created_at,updated_at)
            VALUES (:name,:room,:age,:gender,:weight,:height,:adress,:guarantor_phone,:guarantor_name,:guarantor_adress,:created_at,:updated_at)";
    $stmt = $this->connect->prepare($sql);
    $params = array(
       //":img" => $arr['img'],
       ":name" => $arr['name'],
       ":room" =>$arr['room'],
       ":age"=>$arr['age'],
       ":gender"=> $arr['gender'],
       ":weight" => $arr['weight'],
       ":height" => $arr['height'],
       ":adress" =>$arr['adress'],
       ":guarantor_phone"=>$arr['guarantor_phone'],
       ":guarantor_name"=>$arr['guarantor_name'],
       ":guarantor_adress"=> $arr['guarantor_adress'],
       ":created_at" =>date('Y-m-d H:i:s'),
       ":updated_at" =>date('Y-m-d H:i:s')
     );
     $stmt->execute($params);
  }

  //入所者の削除
  public function careDelete($id){
    if (isset($id)) {
      $sql = "DELETE FROM care_resident_table WHERE id=:id";
      $stmt = $this->connect->prepare($sql);
      $params = array(":id"=>$id);
      $stmt->execute($params);
    }
  }


  //スタッフの参照　条件付き
  public function findId($id){
    $sql = 'SELECT * FROM care_user_table WHERE id = :id';
    $stmt = $this->connect->prepare($sql);
    $params = array(':id'=>$id);
    $stmt->execute($params);
    $result =$stmt->fetch();
    return $result;
  }
  //入所者の参照　条件付き
  public function careFindId($id){
    $sql = 'SELECT * FROM care_resident_table WHERE id = :id';
    $stmt = $this->connect->prepare($sql);
    $params = array(':id'=>$id);
    $stmt->execute($params);
    $result =$stmt->fetch();
    return $result;
  }


  //スタッフの削除
  public function delete($id){
    if (isset($id)) {
      $sql = "DELETE FROM care_user_table WHERE id=:id";
      $stmt = $this->connect->prepare($sql);
      $params = array(":id"=>$id);
      $stmt->execute($params);
    }
  }

  //スタッフ編集
  public function update($arr){
    $sql = "UPDATE care_user_table SET name=:name,gender=:gender,role=:role,user_id=:user_id,password=:password,updated_at=:updated_at WHERE id=:id";
    $stmt = $this->connect->prepare($sql);
    $params = array(
       ":id"=>$arr['id'],
       ":name"=> $arr['name'],
       ":gender"=> $arr['gender'],
       ":role" =>$arr['role'],
       ":user_id" => $arr['user_id'],
       ":password"=>$arr['password'],
       ":updated_at"=>date('Y-m-d H:i:s')
     );
     $stmt->execute($params);
  }

  //入所者の編集
  public function careUpdate($arr){
    $sql = "UPDATE care_resident_table
            SET name=:name,room=:room,age=:age,gender=:gender,weight=:weight,height=:height,adress=:adress
            ,guarantor_phone=:guarantor_phone,guarantor_name=:guarantor_name,guarantor_adress=:guarantor_adress,updated_at=:updated_at
            WHERE id=:id";
    $stmt = $this->connect->prepare($sql);
    $params = array(
       //":img" => $arr['img'],
       ":id"=>$arr['id'],
       ":name" => $arr['name'],
       ":room" =>$arr['room'],
       ":age"=>$arr['age'],
       ":gender"=> $arr['gender'],
       ":weight" => $arr['weight'],
       ":height" => $arr['height'],
       ":adress" =>$arr['adress'],
       ":guarantor_phone"=>$arr['guarantor_phone'],
       ":guarantor_name"=>$arr['guarantor_name'],
       ":guarantor_adress"=> $arr['guarantor_adress'],
       ":updated_at" =>date('Y-m-d H:i:s')
     );
     $stmt->execute($params);
  }

  //日誌名前の参照　条件付き
  public function careDailyName($id){
    $sql = 'SELECT * FROM care_resident_table WHERE id = :id';
    $stmt = $this->connect->prepare($sql);
    $params = array(':id'=>$id);
    $stmt->execute($params);
    $daily_name =$stmt->fetch();
    return $daily_name;
  }

  //日誌参照　条件付き
  public function careDailyId($id){
    $sql = 'SELECT care_daily_table.id,care_resident_table.name,care_daily_table.writer,care_daily_table.comment,care_daily_table.created_date
            FROM care_daily_table
            INNER JOIN care_resident_table
            ON care_resident_table.id=care_daily_table.care_id
            WHERE care_resident_table.id = :id order by created_date desc';
    $stmt = $this->connect->prepare($sql);
    $params = array(':id'=>$id);
    $stmt->execute($params);
    $result =$stmt->fetchAll();
    return $result;
  }

  //日誌登録
  public function dailyAdd($arr){
    $sql = "INSERT INTO care_daily_table(care_id,comment,writer,created_date,updated_date)
            VALUES (:care_id,:comment,:writer,:created_date,:updated_date)";
    $stmt = $this->connect->prepare($sql);
    $params = array(
       ":care_id"=> $arr['care_id'],
       ":comment" => $arr['comment'],
       ":writer" =>$arr['writer'],
       ":created_date"=>$arr['created_date'],
       ":updated_date"=>date('Y-m-d H:i:s')
     );
    $stmt->execute($params);
    //var_dump($params);
  }

  //日誌の削除
  public function dailyDelete($id){
    if (isset($id)) {
      $sql = "DELETE FROM care_daily_table WHERE id=:id";
      $stmt = $this->connect->prepare($sql);
      $params = array(":id"=>$id);
      $stmt->execute($params);
    }
  }

  //日誌内容の編集　条件付き
  public function dailyfindId($id){
    $sql = 'SELECT * FROM care_daily_table WHERE id = :id';
    $stmt = $this->connect->prepare($sql);
    $params = array(':id'=>$id);
    $stmt->execute($params);
    $result =$stmt->fetch();
    return $result;
  }

  //日誌編集
  public function dailyUpdate($arr){
    $sql = "UPDATE care_daily_table SET care_id=:care_id,comment=:comment,writer=:writer,created_date=:created_date,updated_date=:updated_date WHERE id=:id";
    $stmt = $this->connect->prepare($sql);
    $params = array(
       ":id"=>$arr['id'],
       ":care_id"=> $arr['care_id'],
       ":comment"=> $arr['comment'],
       ":writer" => $arr['writer'],
       ":created_date"=>$arr['created_date'],
       ":updated_date"=>date('Y-m-d H:i:s')
     );
     $stmt->execute($params);
  }

}
?>
