<?php
require_once('main.class.php');

class Fetch_data {

    use ConnecntDatabase;

    public function __construct()
    {
        //connect to database
        $this->connect();

        //start Fetch
        $data = $this->connect->prepare('SELECT * FROM users WHERE id = :id');
        $data->bindValue(':id', $_POST['user_id'], PDO::PARAM_INT);
        $data->execute();

        exit(json_encode($data->fetch(PDO::FETCH_ASSOC)));

    }
}