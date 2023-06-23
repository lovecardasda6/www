<?php
include_once __DIR__ . "/config/database.php";

if (isset($_POST['save'])):
    $is_active = isset($_POST['is_active']) ? $_POST['is_active'] : 0;
    $emp_id = $_POST['employee_id'];
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $department = $_POST['department'];
    $salary = $_POST['salary'];
    $pay_mode = $_POST['pay_mode'];


    $tin = $_POST['tin'];

    $has_sss = isset($_POST['has_sss']) ? $_POST['has_sss'] : 0;
    $sss = $_POST['sss'];

    $has_philhealth = isset($_POST['has_philhealth']) ? $_POST['has_philhealth'] : 0;
    $philhealth = $_POST['philhealth'];

    $has_pagibig = isset($_POST['has_pagibig']) ? $_POST['has_pagibig'] : 0;
    $pagibig = $_POST['pagibig'];

    echo $query = "INSERT INTO `employees`(
                                    `emp_id`, 
                                    `firstname`, 
                                    `lastname`, 
                                    `middlename`, 
                                    `department_id`, 
                                    `sss`, 
                                    `pagibig`, 
                                    `philhealth`, 
                                    `tin`, 
                                    `salary`, 
                                    `pay_mode`,
                                    `is_active`, 
                                    `has_sss`, 
                                    `has_pagibig`, 
                                    `has_philheath`
                                ) VALUES (
                                    '{$emp_id}', '{$firstname}', '{$lastname}','{$middlename}',
                                    '{$department}', '{$sss}', '{$pagibig}','{$philhealth}',
                                    '{$tin}', '{$salary}', '{$pay_mode}','{$is_active}',
                                    '{$has_sss}', '{$has_pagibig}', '{$has_philhealth}'
                                )";
    $res = mysqli_query($conn, $query);
    if($res){
        header("Location: add_employee.php?success=1");
    }else{

        header("Location: add_employee.php?success=0");
    }
endif;
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
            crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <style>
        body {
            box-sizing: border-box;
        }

        .container {
            margin: 0 auto;
            width: 75%;
        }

        .content {
            padding: 1em;
            clear: both;
        }

        .control {
            padding: 1em 0px;
            float: right;
        }

        .control > button {
            background-color: #0066ff;
            padding: 1em;
            color: white;
        }
    </style>
</head>
<body style="background-color: whitesmoke">

<?php include_once __DIR__ . '/menu.php'; ?>


<div class="container">
    <div class="content">
        <div class="bg-secondary" style="padding: 10px; color: white;">
            New Employee
        </div>
        <br>
        <?php if(isset($_GET['success']) AND $_GET['success'] == 1): ?>
        <div class="bg-success" style="padding: 10px; color: white;">
            Employee successfully added!
        </div>
        <br>
        <?php endif; ?>
        <?php if(isset($_GET['success']) AND $_GET['success'] == 0): ?>
        <div class="bg-danger" style="padding: 10px; color: white;">
            An error occurred while adding new employee!
        </div>
        <br>
        <?php endif; ?>

        <form action="" method="post">

            <div class="row">
                <div class="col-6">
                    <div class="form-check">
                        <input class="form-check-input" name="is_active" checked type="checkbox" value="1"
                               id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            Is Active
                        </label>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Employee ID</label>
                        <input type="text" class="form-control" name="employee_id" id="exampleFormControlInput1"
                               required>
                    </div>


                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Lastname</label>
                        <input type="text" class="form-control" name="lastname" id="exampleFormControlInput1" required>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Firstname</label>
                        <input type="text" class="form-control" name="firstname" id="exampleFormControlInput1" required>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Middlename</label>
                        <input type="text" class="form-control" name="middlename" id="exampleFormControlInput1"
                               >
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Department</label>
                        <select class="form-select  mb-3" name="department" aria-label=".form-select-lg example"
                                name="department">
                            <?php
                            $department_res = mysqli_query($conn, "SELECT * FROM departments WHERE is_active = 1 ORDER BY department ASC");
                            while ($row = mysqli_fetch_assoc($department_res)):
                                ?>
                                <option value="<?= $row['id'] ?>"><?= $row['department'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Salary</label>
                        <input type="number" step="0.01" min="0" name="salary" class="form-control"
                               id="exampleFormControlInput1">
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Pay Mode</label>
                        <select class="form-select" name="pay_mode" mb-3" aria-label=".form-select-lg example"
                        name="department">
                        <option value="SALARY">Salary Mode</option>
                        <option value="WAGE">Wage Mode</option>
                        </select>
                    </div>
                </div>

                <div class="col-6">
                    <div class="bg-success" style="padding: 10px; color: white;">
                        TIN
                    </div>
                    <br>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">TIN</label>
                        <input type="text" name="tin" class="form-control" id="exampleFormControlInput1">
                    </div>
                    <br>
                    <div class="bg-success" style="padding: 10px; color: white;">
                        SSS
                    </div>
                    <br>

                    <div class="form-check">
                        <input class="form-check-input" name="has_sss" type="checkbox" value="1" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            has SSS
                        </label>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">SSS No.</label>
                        <input type="text" name="sss" class="form-control" id="exampleFormControlInput1">
                    </div>
                    <br>

                    <div class="bg-success" style="padding: 10px; color: white;">
                        PHIL-HEALTH
                    </div>
                    <br>
                    <div class="form-check">
                        <input class="form-check-input" name="has_philhealth" type="checkbox" value="1"
                               id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            has PHIL-HEALTH
                        </label>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">PHIL-HEALTH No.</label>
                        <input type="text" name="philhealth" class="form-control" id="exampleFormControlInput1">
                    </div>
                    <br>

                    <div class="bg-success" style="padding: 10px; color: white;">
                        PAG-IBIG
                    </div>
                    <br>
                    <div class="form-check">
                        <input class="form-check-input" name="has_pagibig" type="checkbox" value="1"
                               id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            has PAG-IBIG
                        </label>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">PAG-IBIG No.</label>
                        <input type="text" name="pagibig" class="form-control" id="exampleFormControlInput1">
                    </div>
                </div>
            </div>
            <hr>
            <div style="display: flex; justify-content: end">
                <button class="btn btn-success" type="submit" name="save">Save Employee</button>&nbsp;
<!--                <button class="btn btn-primary" type="submit" name="saveAndNew">Save & View</button>-->
            </div>
        </form>
    </div>
</div>
</body>
</html>