<?php
include_once __DIR__."/config/database.php";

if (isset($_POST['save'])):
    $employee = unserialize(base64_decode($_GET['employee']));
    $amount = $_POST['amount'];
    $edl_id = $_POST['edl_id'];
    $employee_id = $employee['id'];

    echo $query = "INSERT INTO employee_edl (`amount`, `edl_id`, `employee_id`) VALUES ('{$amount}', '{$edl_id}', '{$employee_id}')";
    $res = mysqli_query($conn, $query);
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
        body{
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

        .module {
            display: none;
        }
    </style>
</head>
<body>

<?php include_once __DIR__ . '/menu.php'; ?>


<div class="container">
    <div class="content">
        <div style="display: flex; justify-content: space-between;background-color: #373b3e; padding: .7em;">
            <div style="color: white;">
                <h4>Payslips</h4>
            </div>
            <div style="color: white;">
                <a href="payslip.php">
                    <button class="btn btn-light btn-sm">New Payslip</button>
                </a>
            </div>
        </div>
        <br/>
        <form action="">
            <div class="row">
                <div class="col-3">
                    <select name="" id="" class="form-control">
                        <option value="#">Select payroll</option>
                    </select>
                </div>
                <div class="col-3">
                    <select name="" id="" class="form-control">
                        <option value="#">Select department</option>
                    </select>
                </div>
                <div class="col-3">
                    <button class="btn btn-primary">Search</button>
                </div>
            </div>
        </form>
        <hr/>


        <!-- EMPLOYEES -->
        <!-- EMPLOYEES -->
        <!-- EMPLOYEES -->
        <div style="background-color: #1a8656; padding: 1em; color: white;">
            <b>Employees</b>
        </div>
        <table class="table">
            <thead>
            <tr class=" table-success">
            <th scope="col">Lastname</th>
            <th scope="col">Firstname</th>
            <th scope="col">Middlename</th>
            <th scope="col">Department</th>
            <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $page = 0;
            $records_per_page = 3;
            if (isset($_GET['page']) && $_GET['page'] >= 2):
                $page = $_GET['page'] * 3 - 1;
            else:
                $page = 0;
            endif;

            $transactions_query = mysqli_query($conn, "SELECT count(*) as `transactions` FROM payroll_transactions");
            $total_records = mysqli_fetch_array($transactions_query);

            echo $total_records['transactions'];

            if (isset($_GET['payroll']) and isset($_GET['department'])):
            else:
                $employee = mysqli_query($conn, "SELECT * FROM payroll_transactions INNER JOIN employees ON employees.id = payroll_transactions.employee_id INNER JOIN departments ON departments.id = employees.department_id WHERE employees.is_active = 1 ORDER BY lastname ASC, payroll_transactions.id DESC LIMIT {$page}, {$records_per_page}");
                while ($row = mysqli_fetch_assoc($employee)):?>

                    <tr>
                        <th><?= $row['lastname'] ?></th>
                        <th><?= $row['firstname'] ?></th>
                        <th><?= $row['middlename'] ?></th>
                        <th><?= $row['lastname'] ?></th>
                        <th>
                            <button class="btn btn-primary btn-sm">View</button>
                            <a href="print_payslip.php?payroll_id=<?= $row['payroll_id'] ?>&employee_id=<?= $row['employee_id'] ?>" target="_blank" style="text-decoration: none;">
                                <button class="btn btn-success btn-sm">Print</button>
                            </a>
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </th>
                    </tr>
                <?php
                endwhile;
            endif;
            ?>
            </tbody>
        </table>

        <?php
        for ($i = 1; $i <= $total_records['transactions'] / 3; $i++):
            ?>
            <a href="?page=<?= $i ?>"><?= $i ?></a>
        <?php
        endfor;
        ?>
    </div>
</div>
</body>
</html>