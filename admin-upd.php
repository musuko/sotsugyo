<?php session_start(); ?>
<?php require 'header.php'; ?>
<!-- <?php require 'menu2.php'; ?> -->
<?php require 'common.php'; ?>
<?php require 'dbconnect.php'; ?>

<?php

try {

    //登録情報を変数に代入する
    $name1 = h($_SESSION['form']['name1']);
    $name2 = h($_SESSION['form']['name2']);

    $furigana1 = h($_SESSION['form']['furigana1']);
    $furigana2 = h($_SESSION['form']['furigana2']);

    $office_id = h($_SESSION['form']['office_id']);
    $office_name = h($_SESSION['form']['office_name']);

    $department_id = h($_SESSION['form']['department_id']);
    $department_name = h($_SESSION['form']['department_name']);

    $telno = h($_SESSION['form']['telno']);
    $email = h($_SESSION['form']['email']);

    $birthdate = h($_SESSION['form']['birth_year'] . 
    sprintf('%02d', $_SESSION['form']['birth_month']) . 
    sprintf('%02d', $_SESSION['form']['birth_day']));

    $hiredate = h($_SESSION['form']['hire_year'] . 
    sprintf('%02d', $_SESSION['form']['hire_month']) . 
    sprintf('%02d', $_SESSION['form']['hire_day']));

    if ($_SESSION['form']['retire_year'] =='' || 
        $_SESSION['form']['retire_month'] =='' || 
        $_SESSION['form']['retire_day'] =='') {

    $retiredate = 0;

    } else {

    $retiredate = h($_SESSION['form']['retire_year'] . 
    sprintf('%02d', $_SESSION['form']['retire_month']) . 
    sprintf('%02d', $_SESSION['form']['retire_day']));
    }

    $authority = h($_SESSION['form']['authority']);
    $login = h($_SESSION['form']['login']);
    $password = h($_SESSION['form']['password']);

    $picture = h($_SESSION['form']['picture']);

    $updated_at = date('Ymd');
    $updated_by = $_SESSION['admin']['id'];


    if (isset($_SESSION['admin'])){

    //ボタン情報を変数に代入する
    $button = ($_SESSION['form']['action']);
    //'admin_id'を変数に代入する
    $admin_id = ($_SESSION['form']['admin_id']);

      //登録処理
      if ($button == 'insert') {

        $sql = $pdo->prepare 
        ('INSERT INTO admin SET admin_login=?, admin_password=?, admin_name1=?, 
        admin_name2=?, admin_furigana1=?, admin_furigana2=?, hire_date=?, authority=?, 
        picture=?, office_id=?, office_name=?, department_id=?, department_name=?, 
        telno=?, email=?, birthdate=?, updated_at=?, updated_by_id=?');

        $sql->bindParam (1, $login, PDO::PARAM_STR);
        $sql->bindParam (2, $password, PDO::PARAM_STR);
        $sql->bindParam (3, $name1, PDO::PARAM_STR);
        $sql->bindParam (4, $name2, PDO::PARAM_STR);
        $sql->bindParam (5, $furigana1, PDO::PARAM_STR);
        $sql->bindParam (6, $furigana2, PDO::PARAM_STR);
        $sql->bindParam (7, $hiredate, PDO::PARAM_INT);
        $sql->bindParam (8, $authority, PDO::PARAM_STR);
        $sql->bindParam (9, $picture, PDO::PARAM_STR);
        $sql->bindParam (10, $office_id, PDO::PARAM_INT);
        $sql->bindParam (11, $office_name, PDO::PARAM_STR);
        $sql->bindParam (12, $department_id, PDO::PARAM_INT);
        $sql->bindParam (13, $department_name, PDO::PARAM_STR);
        $sql->bindParam (14, $telno, PDO::PARAM_INT);
        $sql->bindParam (15, $email, PDO::PARAM_STR);
        $sql->bindParam (16, $birthdate, PDO::PARAM_INT);
        $sql->bindParam (17, $updated_at, PDO::PARAM_INT);
        $sql->bindParam (18, $updated_by, PDO::PARAM_INT);

        $sql->execute();

        echo '社員情報を登録しました。';
        require 'admin-show.php';

      //更新処理
      } elseif ($button == 'update') {

        if (isset($admin_id) && is_numeric($admin_id)) {

        $sql = $pdo->prepare 
        ('UPDATE admin SET admin_login=?, admin_password=?, admin_name1=?, 
        admin_name2=?, admin_furigana1=?, admin_furigana2=?, hire_date=?, 
        retire_date=?, authority=?, picture=?, office_id=?, office_name=?, 
        department_id=?, department_name=?, telno=?, email=?, birthdate=?, 
        updated_at=?, updated_by_id=? WHERE admin_id=?');

          $sql->bindParam (1, $login, PDO::PARAM_STR);
          $sql->bindParam (2, $password, PDO::PARAM_STR);
          $sql->bindParam (3, $name1, PDO::PARAM_STR);
          $sql->bindParam (4, $name2, PDO::PARAM_STR);
          $sql->bindParam (5, $furigana1, PDO::PARAM_STR);
          $sql->bindParam (6, $furigana2, PDO::PARAM_STR);
          $sql->bindParam (7, $hiredate, PDO::PARAM_INT);
          $sql->bindParam (8, $retiredate, PDO::PARAM_INT);
          $sql->bindParam (9, $authority, PDO::PARAM_STR);
          $sql->bindParam (10, $picture, PDO::PARAM_STR);
          $sql->bindParam (11, $office_id, PDO::PARAM_INT);
          $sql->bindParam (12, $office_name, PDO::PARAM_STR);
          $sql->bindParam (13, $department_id, PDO::PARAM_INT);
          $sql->bindParam (14, $department_name, PDO::PARAM_STR);
          $sql->bindParam (15, $telno, PDO::PARAM_INT);
          $sql->bindParam (16, $email, PDO::PARAM_STR);
          $sql->bindParam (17, $birthdate, PDO::PARAM_INT);
          $sql->bindParam (18, $updated_at, PDO::PARAM_INT);
          $sql->bindParam (19, $updated_by, PDO::PARAM_INT);
          $sql->bindParam (20, $admin_id, PDO::PARAM_INT);

          $sql->execute();

          echo '社員情報を更新しました。';
          require 'admin-show.php';

        }
      }
    }

//入力情報のセッションを初期化する
unset($_SESSION['form']);

} catch (PDOException $e) {

  echo ('エラーメッセージ：'.$e->getMessage());

}

?>