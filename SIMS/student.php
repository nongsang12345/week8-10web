<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SSangStudent</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .table-luxury {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #ddd;
        }

        .table-luxury th, .table-luxury td {
            text-align: center;
            vertical-align: middle;
            padding: 8px;
            border: 1px solid #ddd;
        }

        .table-luxury th {
            background-color: #343a40;
            color: #fff;
        }

        .table-luxury tbody tr:hover {
            background-color: #f5f5f5;
        }

        .btn-success.btn-luxury {
            padding: 10px 20px;
            border: 2px solid #28a745;
        }

        .btn-warning {
            background-color: #ffc107;
        }

        .btn-danger {
            background-color: #dc3545;
        }
    </style>
</head>
<body class="bg-light">
    <?php require_once('./connection.php'); ?>
    <div class="container">
        <table class="table table-responsive table-striped table-hover mt-4 table-luxury">
            <thead class="thead-dark">
                <th>ลำดับ</th>
                <th>ID</th>
                <th>Name</th>
                <th>Surname</th>
                <th>ชื่อ</th>
                <th>นามสกุล</th>
                <th>Major</th>
                <th>Email</th>
                <th>Edit/Delete</th>
            </thead>
            <tbody>
                <?php
                 if($_SERVER["REQUEST_METHOD"] === "GET"){
                    if(isset($_GET["status"])){
                        $status = $_GET["status"];
                        if($status === '1'){
                            echo "<script> Swal.fire('Delete Success', '', 'success') </script>";
                        }else if($status === '2'){
                            echo "<script> Swal.fire('Add Success', '', 'success') </script>";
                        }else if($status === '3'){
                            echo "<script> Swal.fire('Update Success', '', 'success') </script>";
                        }
                    }
                }
                    $sql = "SELECT `id`, `en_name`, `en_surname`, `th_name`, `th_surname`, `major_code`, `email` FROM `std_info`";
                    $query = mysqli_query($connection, $sql);
                    if(!$query){
                        die('<script> Swal.fire("การแสดงข้อมูลล้มเหลว", "", "error") </script>');
                    } else {
                        $index = 1;
                        while($result = mysqli_fetch_object($query)){
                ?>
                        <tr>
                            <th><?php echo $index ?></th>
                            <td><?php echo $result->id ?></td>
                            <td><?php echo $result->en_name ?></td>
                            <td><?php echo $result->en_surname ?></td>
                            <td><?php echo $result->th_name ?></td>
                            <td><?php echo $result->th_surname ?></td>
                            <td><?php echo $result->major_code ?></td>
                            <td><?php echo $result->email ?></td>
                            <td>
                                <div class="btn-group">
                                    <a href="./update_std_form.php?id=<?php echo $result->id ?>" class="btn btn-warning">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        Edit
                                    </a>
                                    <a href="./delete_std.php?id=<?php echo $result->id ?>" class="btn btn-danger">
                                        <i class="fa-solid fa-trash"></i>
                                        Delete
                                    </a>
                                </div>
                            </td>
                        </tr>
                <?php
                            ++$index;
                        }
                    }
                ?>
            </tbody>
        </table>
        <div class="mb-2">
            <a href="insert_std_form.php" class="btn btn-success btn-luxury">Insert New Record</a>
        </div>
    </div>
    <?php mysqli_close($connection); ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>