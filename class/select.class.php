<?php

require_once('main.class.php');

class Select
{

    use ConnecntDatabase;

    public function __construct()

    {

        //connect to database
        $this->connect();

        $data = $this->connect->prepare('SELECT * FROM users WHERE id = :id');
        $data->bindValue(':id', $_POST['user_id'], PDO::PARAM_INT);
        $data->execute();

        if ($data->rowCount() == 1) {

            echo '<div class="table-responsive"><table class="table table-bordered">';
            while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
                echo '  
                      <tr>  
                           <td width="30%"><label>ชื่อ - นามสกุล</label></td>  
                           <td width="70%">' . $row["name"] . '</td>  
                      </tr>  
                      <tr>  
                           <td width="30%"><label>ที่อยู่</label></td>  
                           <td width="70%">' . $row["address"] . '</td>  
                      </tr>  
                      <tr>  
                           <td width="30%"><label>เพศ</label></td>  
                           <td width="70%">' . $row["gender"] . '</td>  
                      </tr>
                      <tr>  
                           <td width="30%"><label>อายุ</label></td>  
                           <td width="70%">' . $row["age"] . ' ปี</td>  
                      </tr>  
                 ';
            }

            echo '</table></div>';
        } else {

            //show errors
            echo '<div class="alert alert-danger">ไม่พบข้อมูล</div>';
        }
    }
}
