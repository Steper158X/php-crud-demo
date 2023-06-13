<?php
require_once('../class/main.class.php');

class Insert_Data
{

    use ConnecntDatabase;
    use FetchData;

    public function __construct()
    {

        //connect to database
        $this->connect();

        //null alert message
        $errors = null;

        try {

            //check id
            if ($_POST['user_id'] != '') {

                //update data
                $query = $this->connect->prepare('UPDATE users SET name = :name, address = :address, gender = :gender , age = :age WHERE id= :id');
                $query->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
                $query->bindValue(':address', $_POST['address'], PDO::PARAM_STR);
                $query->bindValue(':gender', $_POST['gender'], PDO::PARAM_STR);
                $query->bindValue(':age', $_POST['age'], PDO::PARAM_INT);
                $query->bindValue(':id' , $_POST['user_id'] , PDO::PARAM_INT);
                $query->execute();
            } else {

                //insert data
                $insert = $this->connect->prepare('INSERT INTO users (name, address , gender , age) VALUE (:name , :address , :gender , :age)');
                $insert->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
                $insert->bindValue(':address', $_POST['address'], PDO::PARAM_STR);
                $insert->bindValue(':gender', $_POST['gender'], PDO::PARAM_STR);
                $insert->bindValue(':age', $_POST['age'], PDO::PARAM_INT);
                $insert->execute();
            }
        } catch (PDOException $ex) {
            $errors = 'มีปัญหาในการเชื่อมต่อกับฐานข้อมูล โปรดติดต่อผู้ดูแลระบบ';
        }

        $this->Call_DataList($errors , 'บันทึกข้อมูลเรียบร้อยแล้ว');

    }
}
