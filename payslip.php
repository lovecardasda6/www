<?php
include_once __DIR__."/config/database.php";
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


</head>
<body style="box-sizing: border-box;">
<?php include_once __DIR__ . '/menu.php'; ?>
<div style="font-size: 13px;">
    <div class="row" style="padding: 0.5em;">
        <div class="col-2 col-md-2 col-sm-12">
            <!-- PAYROLL -->
            <!-- PAYROLL -->
            <!-- PAYROLL -->
            <div style="height: 13em; overflow: scroll;">
                <table class="table">
                    <thead>
                    <tr class="table-dark">
                        <th scope="col">PAYROLL</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $res = mysqli_query($conn, "SELECT * FROM PAYROLLS ORDER BY id DESC");
                    while ($row = mysqli_fetch_assoc($res)):
                        $encrypt = serialize([
                            "id" => $row['id'],
                            "description" => $row['description'],
                            "from" => $row['from_date'],
                            "to" => $row['to_date']
                        ]);

                        ?>
                        <tr>
                            <td>
                                <a href="?payroll=<?= base64_encode($encrypt) ?>">
                                    <?= $row['code'] ?> - <?= $row['description'] ?>
                                </a>
                            </td>
                        </tr>
                    <?php
                    endwhile;
                    ?>
                    </tbody>
                </table>
            </div>
            <br>
            <hr>

            <!-- DEPARTMENT -->
            <!-- DEPARTMENT -->
            <!-- DEPARTMENT -->
            <div style="height: 16em; overflow: scroll">
                <table class="table">
                    <thead>
                    <tr class="table-dark">
                        <th scope="col">DEPARTMENT</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (isset($_GET['payroll'])):
                        $res = mysqli_query($conn, "SELECT * FROM DEPARTMENTS WHERE is_active = 1");
                        while ($row = mysqli_fetch_assoc($res)):
                            $encrypt = serialize([
                                "id" => $row['id'],
                                "department" => $row['department'],

                            ]);
                            ?>
                            <tr>
                                <td>
                                    <a href="?payroll=<?= $_GET['payroll'] ?>&department=<?= base64_encode($encrypt) ?>">
                                        <?= $row['department'] ?>
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
            <br>
            <hr>

            <!-- EMPLOYEES -->
            <!-- EMPLOYEES -->
            <!-- EMPLOYEES -->
            <div>
                <table class="table">
                    <thead>
                    <tr class="table-dark">
                        <th scope="col">EMPLOYEE</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    if (isset($_GET['department'])):
                        $department = unserialize(base64_decode($_GET['department']));
                        $res = mysqli_query($conn, "SELECT * FROM EMPLOYEES WHERE is_active = 1 AND department_id = {$department['id']}");
                        while ($row = mysqli_fetch_assoc($res)):
                            $encrypt = serialize([
                                "id" => $row['id'],
                                "salary" => $row['salary'],
                                "name" => "{$row['lastname']}, {$row['firstname']} {$row['middlename']}"
                            ]);
                            ?>
                            <tr>
                                <td>
                                    <a href="?payroll=<?= $_GET['payroll'] ?>&department=<?= $_GET['department'] ?>&employee=<?= base64_encode($encrypt) ?>">
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

        <!--###################################################################################################################-->
        <!--########################################################-->
        <!-- PAYSLIP -->
        <!--########################################################-->
        <!--###################################################################################################################-->
        <div class="col-10  col-md-10 col-sm-12">
            <?php
            if (isset($_GET['employee']) && isset($_GET['department'])):
                $payroll = unserialize(base64_decode($_GET['payroll']));
                $department = unserialize(base64_decode($_GET['department']));
                $employee = unserialize(base64_decode($_GET['employee']));
                ?>
                <div style="display: flex; justify-content: space-between">
                    <div>
                        <h2><b>COMPANY NAME</b></h2>
                        <h6><?= $employee['name'] ?></h6>
                        <h6><?= $employee['id'] ?></h6>
                    </div>
                    <div>
                        <h7>
                            Description: <b><?= $payroll['description'] ?></b>
                            <br>
                            Cutoff Date: <b><?= $payroll['from'] ?> - <?= $payroll['to'] ?></b>
                            <br>
                            Department: <b><?= $department['department'] ?></b>
                        </h7>
                    </div>
                </div>
                <?php
                $payroll_transaction_exist = mysqli_query($conn, "SELECT * FROM payroll_transactions WHERE payroll_id = '{$payroll['id']}' AND employee_id = '{$employee['id']}'");
                $payroll_record = mysqli_fetch_assoc($payroll_transaction_exist);


                if (mysqli_num_rows($payroll_transaction_exist)):
                    include __DIR__."/module/payslip_with_record.php";
                else:
                    include __DIR__."/module/payslip.php";
                endif;
            endif;
            ?>

        </div>
    </div>
</div>
<br><br><br><br><br><br><br><br><br><br>
<script src="app.js"></script>
</body>
</html>