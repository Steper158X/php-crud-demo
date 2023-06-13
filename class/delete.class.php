<?php

require_once('../class/main.class.php');

class Delete_Data
{

    use ConnecntDatabase;
    use FetchData;

    public function __construct()
    {

        //connect to database
        $this->connect();

        $error = null;

        try {

            if (empty($_POST['user_id'])) {
                $error = 'มีปัญหาในการลบข้อมูล';
            } else {

                //no errors -> delete data
                $query = $this->connect->prepare('DELETE FROM users WHERE id = :id');
                $query->bindValue(':id', $_POST['user_id'], PDO::PARAM_INT);
                $query->execute();

                if ($query->rowCount() == 0) {
                    $error = 'ไม่สามารถลบข้อมูลได้';
                }
            }
        } catch (PDOException $ex) {

            //errors
            $error = 'มีปัญหาในการเชื่อมต่อกับฐานข้อมูล โปรดติดต่อผู้ดูแลระบบ';
        }


        //return data list
        $this->Call_DataList($error, 'ลบข้อมูลเรียบร้อยแล้ว');
    }
}
