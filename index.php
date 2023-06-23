<?php
include_once __DIR__."/config/database.php";
$department_id = $_GET['department_id'];
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</head>
<body>
<?php include_once __DIR__.'/menu.php'; ?>
<div>

    <div style="width:25%; float:left; margin:0; padding:10px; border:0px solid">
        <div>
            <div class="input-group mb-3">
                <label class="input-group-text btn btn-primary" for="inputGroupSelect01">Payroll Date</label>
                <select class="form-select" id="inputGroupSelect01">
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>
        </div>
        <div>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Department</th>
                </tr>
                </thead>
                <tbody>
                <?php
                        $res = mysqli_query($conn, "SELECT * FROM DEPARTMENTS");
                        while($row = mysqli_fetch_assoc($res)):
                    ?>
                    <tr>
                        <td>
                            <a href="?department_id=<?= $row['id'] ?>"><?= $row['department'] ?></a>
                        </td>
                    </tr>
                <?php
                    endwhile;
                ?>
                </tbody>
            </table>
        </div>
        <br><br>
        <div>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Employee</th>
                </tr>
                </thead>
                <tbody>

                    <?php
                    if ($department_id != ""):
                        $res = mysqli_query($conn, "SELECT * FROM EMPLOYEES WHERE department_id = {$department_id}");
                        while($row = mysqli_fetch_assoc($res)):

                    ?>
                        <tr>
                            <td>
                                <a href="?department_id=<?= $department_id?>&employee_id=<?= $row['id'] ?>&name=<?= $row['lastname'] ?>, <?= $row['firstname'] ?> <?= $row['middlename'] ?>">
                                    <?= $row['lastname'] ?>, <?= $row['firstname'] ?> <?= $row['middlename'] ?>
                                </a>
                            </td>
                        </tr>
                    <?php
                        endwhile;
                        endif;
                    ?>

                </tbody>
            </table>
        </div>
    </div>
    <div style="width:75%; float:right; margin:0; padding:10px;">
        <h2><b>COMPANY NAME</b></h2>
        <h6><?= @$_GET['name'] ?></h6>
        <hr>
        <label>ABSENCES</label> <input type="text"> |
        <label>TARDINDESS(minutes)</label> <input type="text">
        <hr>
        <div style="width: 100%;">
            <div style="width:50%; float:left; margin:0; padding:10px; border:0px solid">
                <div style="margin:0; padding:10px; border:0px solid">
                    <b>
                        <h3 style="background-color: #1c7430;  box-sizing: border-box; padding: 5px;color: white;">EARNINGS</h3>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if(@$_GET['employee_id'] != ""):
                                $employee_id = $_GET['employee_id'];
                                $res = mysqli_query($conn, "SELECT * FROM EMPLOYEE_EDL INNER JOIN EDL ON EMPLOYEE_EDL.edl_id = EDL.id where employee_id = {$employee_id} AND type = 'EARNING'");
                                while($row = mysqli_fetch_assoc($res)):
                                    ?>
                                    <tr>
                                        <td>
                                            <button style="background-color:#5f0303; color: white;">&nbsp; x &nbsp;</button>
                                        </td>
                                        <td>
                                            <?= $row['description']?>
                                        </td>
                                        <td contenteditable="true"><?= $row['amount']?></td>
                                    </tr>
                                <?php
                                endwhile;
                            endif;
                            ?>
                            </tbody>
                        </table>
                    </b>
                </div>
                <div style="margin:0; padding:10px; border:0px solid">
                    <b>
                        <h3 style="background-color: #8c0909;  box-sizing: border-box; padding: 5px;color: white;">DEDUCTIONS</h3>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if(@$_GET['employee_id'] != ""):
                                $employee_id = $_GET['employee_id'];
                                $res = mysqli_query($conn, "SELECT * FROM EMPLOYEE_EDL INNER JOIN EDL ON EMPLOYEE_EDL.edl_id = EDL.id where employee_id = {$employee_id} AND type = 'DEDUCTION'");
                                while($row = mysqli_fetch_assoc($res)):
                                    ?>
                                    <tr>
                                        <td>
                                            <button style="background-color:#5f0303; color: white;">&nbsp; x &nbsp;</button>
                                        </td>
                                        <td>
                                            <?= $row['description']?>
                                        </td>
                                        <td contenteditable="true"><?= $row['amount']?></td>
                                    </tr>
                                <?php
                                endwhile;
                            endif;
                            ?>
                            </tbody>
                        </table>
                    </b>
                </div>
                <div style="margin:0; padding:10px; border:0px solid">
                    <b>
                        <h3  style="background-color: #06678f;  box-sizing: border-box; padding: 5px;color: white;">LOANS</h3>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if(@$_GET['employee_id'] != ""):
                                $employee_id = $_GET['employee_id'];
                                $res = mysqli_query($conn, "SELECT * FROM EMPLOYEE_EDL INNER JOIN EDL ON EMPLOYEE_EDL.edl_id = EDL.id where employee_id = {$employee_id} AND type = 'LOAN'");
                                while($row = mysqli_fetch_assoc($res)):
                                    ?>
                                    <tr>
                                        <td>
                                            <button style="background-color:#5f0303; color: white;">&nbsp; x &nbsp;</button>
                                        </td>
                                        <td>
                                            <?= $row['description']?>
                                        </td>
                                        <td contenteditable="true"><?= $row['amount']?></td>
                                    </tr>
                                <?php
                                endwhile;
                            endif;
                            ?>
                            </tbody>
                        </table>
                    </b>
                </div>
            </div>
            <div style="width:50%; float:left; margin:0; padding:10px; border:0px solid">

                <div style="margin:0; padding:10px; border:0px solid">
                    <b>
                        <h3 style="background-color: #1c7430;  box-sizing: border-box; padding: 5px;color: white;">DEBIT ADJUSMENT</h3>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if(@$_GET['employee_id'] != ""):
                                $employee_id = $_GET['employee_id'];
                                $res = mysqli_query($conn, "SELECT * FROM EMPLOYEE_EDL INNER JOIN EDL ON EMPLOYEE_EDL.edl_id = EDL.id where employee_id = {$employee_id} AND type = 'EARNING'");
                                while($row = mysqli_fetch_assoc($res)):
                                    ?>
                                    <tr>
                                        <td>
                                            <button style="background-color:#5f0303; color: white;">&nbsp; x &nbsp;</button>
                                        </td>
                                        <td>
                                            <?= $row['description']?>
                                        </td>
                                        <td contenteditable="true"><?= $row['amount']?></td>
                                    </tr>
                                <?php
                                endwhile;
                            endif;
                            ?>
                            </tbody>
                        </table>
                    </b>
                </div>
                <div style="margin:0; padding:10px; border:0px solid">
                    <b>
                        <h3  style="background-color: #8c0909;  box-sizing: border-box; padding: 5px;color: white;">CREDIT ADJUSTMENT</h3>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if(@$_GET['employee_id'] != ""):
                                $employee_id = $_GET['employee_id'];
                                $res = mysqli_query($conn, "SELECT * FROM EMPLOYEE_EDL INNER JOIN EDL ON EMPLOYEE_EDL.edl_id = EDL.id where employee_id = {$employee_id} AND type = 'LOAN'");
                                while($row = mysqli_fetch_assoc($res)):
                                    ?>
                                    <tr>
                                        <td>
                                            <button style="background-color:#5f0303; color: white;">&nbsp; x &nbsp;</button>
                                        </td>
                                        <td>
                                            <?= $row['description']?>
                                        </td>
                                        <td contenteditable="true"><?= $row['amount']?></td>
                                    </tr>
                                <?php
                                endwhile;
                            endif;
                            ?>
                            </tbody>
                        </table>
                    </b>
                </div>
            </div>
        </div>
        <div style="clear: both;">
            <hr>
            <table>
                <tr>
                    <td>WITH HOLDING TAX:</td>
                    <td> <input type="text"> <br></td>
                </tr>
                <tr>
                    <td>GROSS PAY:</td>
                    <td> <input type="text"> <br></td>
                </tr>
                <tr>
                    <td>TOTAL LOANS & DEDUCTION:</td>
                    <td> <input type="text"> <br></td>
                </tr>
                <tr>
                    <td>NET PAY:</td>
                    <td> <input type="text"> <br></td>
                </tr>
            </table>
        </div>
    </div>
</div>
</body>
</html>