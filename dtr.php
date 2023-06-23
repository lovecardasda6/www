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
<body style="font-size: 13px;">
<?php include_once __DIR__ . '/menu.php'; ?>

<div class="container-fluid">
        <div class="row">
            <div class="col-2">
                <div style="height: 18em; overflow: scroll">
                    <table class="table">
                        <thead>
                        <tr class="table-dark">
                            <th scope="col">Department</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <a href="?department_id=all"><b>ALL EMPLOYEES</b></a>
                            </td>
                        </tr>
                        <?php
                        $res = mysqli_query($conn, "SELECT * FROM DEPARTMENTS WHERE is_active = 1");
                        while ($row = mysqli_fetch_assoc($res)):
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
                <br>
                <div>
                    <table class="table">
                        <thead>
                        <tr class="table-dark">
                            <th scope="col">Employee</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                        @$department_id = $_GET['department_id'];

                        $query = isset($_GET['department_id']) && $_GET['department_id'] != "all" ?
                            "SELECT * FROM EMPLOYEES WHERE is_active = 1 AND department_id = {$department_id} ORDER BY lastname ASC" :
                            "SELECT * FROM EMPLOYEES WHERE is_active = 1 ORDER BY lastname ASC";
                        $res = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($res)):

                            ?>
                            <tr>
                                <td>
                                    <a href="?department_id=<?= $department_id ?>&employee_id=<?= $row['id'] ?>">
                                        <?= $row['lastname'] ?>, <?= $row['firstname'] ?> <?= $row['middlename'] ?>
                                    </a>
                                </td>
                            </tr>
                        <?php
                        endwhile;
                        ?>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-10">
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                    <div class="row">
                        <div class="col-3">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">From Date</span>
                                <input type="date" class="form-control" name="from">
                            </div>

                        </div>
                        <div class="col-3">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">To Date</span>
                                <input type="date" class="form-control" name="to">
                            </div>

                        </div>
                        <div class="col">
                            <div class="input-group mb-3">
                                <button type="submit" name="search" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </div>

                </form>
                <table class="table">
                    <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Date</th>
                        <th scope="col">Timetable</th>
                        <th scope="col">OT1</th>
                        <th scope="col">OT2</th>
                        <th scope="col">OT3</th>
                        <th scope="col">Late In</th>
                        <th scope="col">Early Out</th>
                        <th scope="col">Check In</th>
                        <th scope="col">Check Out</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (isset($_GET['employee_id'])):
                        $employee_id = $_GET['employee_id'];

                        $query = "";
                        if (isset($_POST['search'])):
                            $from = $_POST['from'];
                            $to = $_POST['to'];
                            $employee_id = $_GET['employee_id'];

                            $query = "SELECT * FROM dtr WHERE employee_id ='{$employee_id}' AND date_of >= '{$from}' AND date_of <= '{$to}'";

                        else:
                            $query = "SELECT * FROM DTR WHERE employee_id = {$employee_id} ORDER BY date_of ASC";
                        endif;


                        $res = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($res)):
                            ?>
                            <tr>
                                <th scope="row">1</th>
                                <td><?= $row['date_of'] ?></td>
                                <td><?= $row['timetable'] ?></td>
                                <td><?= $row['ot1'] ?></td>
                                <td><?= $row['ot2'] ?></td>
                                <td><?= $row['ot3'] ?></td>
                                <td><?= $row['late_in'] ?></td>
                                <td><?= $row['early_out'] ?></td>
                                <td><?= $row['check_in'] ?></td>
                                <td><?= $row['check_out'] ?></td>
                            </tr>
                        <?php
                        endwhile;
                    endif;
                    ?>
                    </tbody>
                </table>
            </div>
        </div>


</div>



</body>
</html>