<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student System</title>
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

        .card {
            border: none;
        }

        .form-label {
            font-weight: bold;
        }

        .btn-outline-success {
            border-color: #28a745;
            color: #28a745;
        }

        .btn-outline-success:hover {
            background-color: #28a745;
            color: #fff;
        }

        .btn-outline-danger {
            border-color: #dc3545;
            color: #dc3545;
        }

        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: #fff;
        }
    </style>
</head>

<body class="bg-light">
    
</body>

</html>

<body class="bg-light">
<?php
require_once('./connection.php');
$error = [
    "id" => "",
    "email" => "",
    "en_name" => "",
    "en_surname" => "",
    "th_name" => "",
    "th_surname" => "",
    "major_code" => "",
];
$id = $email = $en_name = $en_surname = $th_name = $th_surname = $major_code = "";

function protectInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    empty($_POST["id"]) ? $error["id"] = "*กรุณากรอกรหัสนักศึกษา" : $id = protectInput($_POST["id"]);
    if (!empty($_POST["email"])) {
        !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) ? $error["email"] = "*ระบุรูปแบบอีเมลให้ถูกต้อง" : $email = protectInput($_POST["email"]);
    }
    empty($_POST["en_name"]) ? $error["en_name"] = "*กรุณากรอกชื่อ" : $en_name = protectInput($_POST["en_name"]);
    empty($_POST["en_surname"]) ? $error["en_surname"] = "*กรุณากรอกนามสกุล" : $en_surname = protectInput($_POST["en_surname"]);
    empty($_POST["th_name"]) ? $error["th_name"] = "*กรุณากรอกชื่อ" : $th_name = protectInput($_POST["th_name"]);
    empty($_POST["th_surname"]) ? $error["th_surname"] = "*กรุณากรอกนามสกุล" : $th_surname = protectInput($_POST["th_surname"]);
    if (!empty($_POST["email"])) {
        $major_code = protectInput($_POST["major_code"]);
    }

    
    $checkDuplicateSQL = "SELECT COUNT(*) AS count FROM `std_info` WHERE `id`='$id'";
    $checkDuplicateQuery = mysqli_query($connection, $checkDuplicateSQL);
    if ($checkDuplicateQuery) {
        $result = mysqli_fetch_assoc($checkDuplicateQuery);
        if ($result['count'] > 0) {
            $error["id"] = "รหัสนักศึกษาซ้ำกัน";
        }
    } else {
        die('<script> Swal.fire("เกิดข้อผิดพลาดในการตรวจสอบรหัสนักศึกษา", "", "error") </script>');
    }

    if (empty($error["email"]) && empty($error["major_code"]) && !empty($_POST["id"]) && !empty($_POST["en_name"]) && !empty($_POST["en_surname"]) && !empty($_POST["th_name"]) && !empty($_POST["th_surname"]) && empty($error["id"])) {
        $sql = "INSERT INTO `std_info`(`id`, `en_name`, `en_surname`, `th_name`, `th_surname`, `major_code`, `email`) VALUES 
        ('$id','$en_name','$en_surname','$th_name','$th_surname','$major_code','$email')";
        $query = mysqli_query($connection, $sql);
        if (!$query) {
            echo '<script> Swal.fire("การเพิ่มข้อมูลล้มเหลว", "", "error") </script>';
        } else {
            header("Location: ./student.php?status=2");
            exit();
        }
    } else {
        echo '<script> Swal.fire("กรุณากรอกข้อมูลให้ถูกต้อง", "", "warning") </script>';
    }
}
?>

    <div class="container d-flex flex-column justify-content-center align-items-center">
        <div class="card mb-3">
            <div class="card-header text-bg-primary h3">Add Member</div>
            <div class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="row">
                    <div class="col-12 mb-3">
                        <label for="studentID" class="form-label">ID</label>
                        <?php if ($error["id"]) { ?>
                            <input name="id" type="text" class="form-control is-invalid" id="studentID">
                            <div class="invalid-feedback"><?php echo $error["id"]; ?></div>
                        <?php } else if (!empty($id)) { ?>
                            <input name="id" type="text" class="form-control is-valid" id="studentID" value="<?php echo $id; ?>">
                        <?php } else { ?>
                            <input name="id" type="text" class="form-control" id="studentID">
                        <?php } ?>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="studentEmail" class="form-label">Email</label>
                        <?php if ($error["email"]) { ?>
                            <input name="email" type="text" class="form-control is-invalid" id="studentEmail">
                            <div class="invalid-feedback"><?php echo $error["email"]; ?></div>
                        <?php } else if (!empty($email)) { ?>
                            <input name="email" type="text" class="form-control is-valid" id="studentEmail" value="<?php echo $email; ?>">
                        <?php } else { ?>
                            <input name="email" type="text" class="form-control" id="studentEmail">
                        <?php } ?>
                    </div>
                    <div class="col-6 mb-3">
                        <label for="studentNameEng" class="form-label">name</label>
                        <?php if ($error["en_name"]) { ?>
                            <input name="en_name" type="text" class="form-control is-invalid" id="studentNameEng">
                            <div class="invalid-feedback"><?php echo $error["en_name"]; ?></div>
                        <?php } else if (!empty($en_name)) { ?>
                            <input name="en_name" type="text" class="form-control is-valid" id="studentNameEng" value="<?php echo $en_name; ?>">
                        <?php } else { ?>
                            <input name="en_name" type="text" class="form-control" id="studentNameEng">
                        <?php } ?>
                    </div>
                    <div class="col-6 mb-3">
                        <label for="studentSurnameEng" class="form-label">Surname</label>
                        <?php if ($error["en_surname"]) { ?>
                            <input name="en_surname" type="text" class="form-control is-invalid" id="studentSurnameEng">
                            <div class="invalid-feedback"><?php echo $error["en_surname"]; ?></div>
                        <?php } else if (!empty($en_surname)) { ?>
                            <input name="en_surname" type="text" class="form-control is-valid" id="studentSurnameEng" value="<?php echo $en_surname; ?>">
                        <?php } else { ?>
                            <input name="en_surname" type="text" class="form-control" id="studentSurnameEng">
                        <?php } ?>
                    </div>
                    <div class="col-6 mb-3">
                        <label for="studentNameTh" class="form-label">ชื่อ</label>
                        <?php if ($error["th_name"]) { ?>
                            <input name="th_name" type="text" class="form-control is-invalid" id="studentNameTh">
                            <div class="invalid-feedback"><?php echo $error["th_name"]; ?></div>
                        <?php } else if (!empty($th_name)) { ?>
                            <input name="th_name" type="text" class="form-control is-valid" id="studentNameTh" value="<?php echo $th_name; ?>">
                        <?php } else { ?>
                            <input name="th_name" type="text" class="form-control" id="studentNameTh">
                        <?php } ?>
                    </div>
                    <div class="col-6 mb-3">
                        <label for="studentSurnameTh" class="form-label">นามสกุล</label>
                        <?php if ($error["th_surname"]) { ?>
                            <input name="th_surname" type="text" class="form-control is-invalid" id="studentSurnameTh">
                            <div class="invalid-feedback"><?php echo $error["th_surname"]; ?></div>
                        <?php } else if (!empty($th_surname)) { ?>
                            <input name="th_surname" type="text" class="form-control is-valid" id="studentSurnameTh" value="<?php echo $th_surname; ?>">
                        <?php } else { ?>
                            <input name="th_surname" type="text" class="form-control" id="studentSurnameTh">
                        <?php } ?>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="studentMajor" class="form-label">Major</label>
                        <?php if ($error["major_code"]) { ?>
                            <input name="major_code" type="text" class="form-control is-invalid" id="studentMajor">
                            <div class="invalid-feedback"><?php echo $error["major_code"]; ?></div>
                        <?php } else if (!empty($major_code)) { ?>
                            <input name="major_code" type="text" class="form-control is-valid" id="studentMajor" value="<?php echo $major_code; ?>">
                        <?php } else { ?>
                            <input name="major_code" type="text" class="form-control" id="studentMajor">
                        <?php } ?>
                    </div>
                    <button type="submit" class="col-1 btn btn-outline-success ms-3">Save</button>
                    <a href="./student.php" class="col-1 btn btn-outline-danger ms-3">Back</a>
                </form>
            </div>
        </div>
    </div>
    <?php mysqli_close($connection); ?>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>