<?php

trait ConnecntDatabase {

    protected $connect;

    protected function connect() {

    
        try {

            $database = [
                'host' => 'localhost',
                'dbname' => 'test',
                'username' => 'root',
                'password' => ''
            ];
            
            //connect to database
            $this->connect = new PDO('mysql:host='.$database['host'].';dbname='.$database['dbname'].';charset=utf8', $database['username'], $database['password']);
            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        } catch(PDOException $ex){

            //alert -> Can't connect to database
            echo '<script>alert("Can\'t connect to database")</script>';

        }
    }

}


trait FetchData {

    use ConnecntDatabase;

    public function Call_DataList(string $errors = null ,string $alert = null) {

        try {

            //export new data list with message
            if(empty($this->connect)) {
                $this->connect();
            }

            //message
            if (empty($errors)) {
                if($alert !== null) {
                    echo '<div class="alert alert-success">'.$alert.'</div>';
                }
            } else {
                echo '<div class="alert alert-danger">' . $errors . '</div>';
            }


            //data list

            $datalist = $this->connect->prepare('SELECT * FROM users ORDER BY id DESC');
            $datalist->execute();

            if ($datalist->rowCount() > 0) {

                //header
                echo '
                <table class="table table-bordered">  
                <tr>  
                 <th width="55%">ชื่อ - สกุล</th>  
                 <th width="15%">แก้ไข</th>  
                 <th width="15%">ดูรายละเอียด</th>
                 <th width="15%">ลบ</th>  
                </tr>
                ';

                while ($row = $datalist->fetch(PDO::FETCH_ASSOC)) {
                    echo '
                <tr>  
                <td>' . $row["name"] . '</td>  
                <td><input type="button" name="edit" value="แก้ไข" id="' . $row["id"] . '" class="btn btn-primary edit_data"></td>  
                <td><input type="button" name="view" value="ดูรายละเอียด" id="' . $row["id"] . '" class="btn btn-info view_data"></td>
                <td><input type="button" name="view" value="ลบ" id="' . $row["id"] . '" class="btn btn-danger delete_data"></td>  
                </tr>';
                }

                echo '</table>';
            } else {

                //no data found
                echo '<div class="alert alert-danger">ไม่พบข้อมูลผู้ใช้ใดๆเลย</div>';
            }
        } catch (PDOException $ex) {

            //database errors
            echo '<div class="alert alert-danger">มีปัญหาในการติดต่อกับฐานข้อมูล</div>';
            
        }

    }


}

?>