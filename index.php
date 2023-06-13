<?php
require_once('class/index.class.php');
$index = new Index();
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ทดลองจัดการข้อมูล Database</title>

    <!-- bs5 -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Font -->
    <link rel="stylesheet" href="assets/css/index.css">

</head>

<body>
    <br /><br />
    <div class="container" style="width:700px;">
        <h3 align="center">ตัวอย่างเว็บไซต์ในการจัดทำข้อมูล</h3>
        <br />
        <div>
            <div>
                <button type="button" name="add" id="add" data-bs-toggle="modal" data-bs-target="#add_data_Modal" class="btn btn-warning">+ เพิ่มสมาชิก</button>
            </div>
            <br />
            <div id="users_table">

                <?php
                $index->Call_DataList();
                ?>

            </div>
        </div>
    </div>

    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery-3.6.0.min.js"></script>

</body>

</html>


<!-- Modal -->
<div class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="DataLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="DataLabel">ข้อมูลสมาชิก</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Data Box -->
            <div class="modal-body" id="user_detail">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิดหน้าต่าง</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal confirm delete -->
<div class="modal fade" id="ConfirmDelete" tabindex="-1" aria-labelledby="ConfirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ConfirmDeleteLabel">ยืนยันการลบข้อมูล</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Data Box -->
            <div class="modal-body">
                <h4>ข้อมูลสมาชิก</h4>
                <hr>
                <div id="Deleteuser_detail"></div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger confirm_delete">ยืนยันการลบข้อมูล</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="add_data_Modal" tabindex="-1" aria-labelledby="add_data_Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- form - In Model -->
            <form id="insert_form">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_data_Label">เพิ่มข้อมูลสมาชิกใหม่</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">


                    <label>ชื่อ - นามสกุล</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="ชื่อ-นามสกุล" required>
                    <br />
                    <label>ที่อยู่ปัจจุบัน</label>
                    <textarea name="address" id="address" class="form-control" placeholder="ที่อยู่ปัจจุบัน"></textarea>
                    <br />
                    <label>เลือกเพศ</label>
                    <select name="gender" id="gender" class="form-control">
                        <option value="ชาย">ชาย</option>
                        <option value="หญิง">หญิง</option>
                    </select>
                    <br />
                    <label>อายุ</label>
                    <input type="number" name="age" id="age" min="1" max="100" class="form-control" placeholder="อายุ" required>
                    <br />
                    <input type="hidden" name="user_id" id="user_id" />


                </div>
                <div class="modal-footer">
                    <input class="btn btn-primary" type="submit" name="insert" id="insert" value="บันทึกข้อมูล">
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {

        //prepare add user
        $('#add').click(function() {
            $('#add_data_Label').text("เพิ่มข้อมูลสมาชิกใหม่");
            $('#insert').val("บันทึกข้อมูล");
            $('#insert_form')[0].reset();
        });

        //call edit data
        $(document).on('click', '.edit_data', function() {
            var user_id = $(this).attr("id");
            $.ajax({
                url: "ajax/fetch.php",
                method: "POST",
                data: {
                    user_id: user_id
                },
                dataType: "json",
                success: function(data) {
                    $('#name').val(data.name);
                    $('#address').val(data.address);
                    $('#gender').val(data.gender);
                    $('#age').val(data.age);
                    $('#user_id').val(data.id);
                    $('#insert').val("อัปเดตข้อมูล");
                    $('#add_data_Modal').modal('show');
                    $('#add_data_Label').text("แก้ไขข้อมูลสมาชิก");
                }
            });
        });

        //insert data or edit data
        $('#insert_form').on("submit", function(event) {
            event.preventDefault();
            if ($('#name').val() == "") {
                alert("กรุณากรอกชื่อ-นามสกุลด้วย");
            } else if ($('#address').val() == '') {
                alert("กรุณากรอกที่อยู่ปัจจุบันด้วย");
            } else if ($('#age').val() == '') {
                alert("กรุณากรอกอายุด้วย");
            } else {
                $.ajax({
                    url: "ajax/insert.php",
                    method: "POST",
                    data: $('#insert_form').serialize(),
                    beforeSend: function() {
                        $('#insert').val("กำลังบันทึก...");
                    },
                    success: function(data) {
                        $('#insert_form')[0].reset();
                        $('#add_data_Modal').modal('hide');
                        $('#users_table').html(data);
                        $('#user_id').val('');
                    }
                });
            }
        });

        //delete data (call data to confirm)
        $(document).on('click', '.delete_data', function() {
            var user_id = $(this).attr("id");
            if (user_id != '') {
                $.ajax({
                    url: "ajax/select.php",
                    method: "POST",
                    data: {
                        user_id: user_id
                    },
                    success: function(data) {
                        $('.confirm_delete').attr("id", user_id);
                        $('#Deleteuser_detail').html(data);
                        $('#ConfirmDelete').modal('show');
                    }
                });
            }
        });

        //truly delete data
        $(document).on('click', '.confirm_delete', function() {
            var user_id = $(this).attr("id");
            if (user_id != '') {
                $.ajax({
                    url: "ajax/delete.php",
                    method: "POST",
                    data: {
                        user_id: user_id
                    },
                    success: function(data) {
                        $('#ConfirmDelete').modal('hide');
                        $('#users_table').html(data);
                    }
                });
            }
        });

        //show data
        $(document).on('click', '.view_data', function() {
            var user_id = $(this).attr("id");
            if (user_id != '') {
                $.ajax({
                    url: "ajax/select.php",
                    method: "POST",
                    data: {
                        user_id: user_id
                    },
                    success: function(data) {
                        $('#user_detail').html(data);
                        $('#dataModal').modal('show');
                    }
                });
            }
        });


    });
</script>