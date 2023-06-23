<?php
include_once __DIR__ . "/config/database.php";

@$payroll_id = @$_GET['payroll_id'];

//for fetching columns only
//not for fetching employee amount payment
$edl_adj_res = mysqli_query($conn, "SELECT DISTINCT(name) as 'description', type 
                                            FROM payroll_transaction_edl_adj 
                                             INNER JOIN payroll_transactions ON payroll_transaction_edl_adj.payroll_transaction_id = payroll_transactions.id
                                             WHERE payroll_id='{$payroll_id}'");
$edl_adjs = mysqli_fetch_all($edl_adj_res);


//for fetching columns only
//not for fetching employee amount payment
$ot_holiday_restday = mysqli_query($conn, "SELECT DISTINCT(type) as `description`
                                                    FROM payroll_transaction_ot_holiday_restday
                                                    INNER JOIN payroll_transactions ON payroll_transaction_ot_holiday_restday.payroll_transaction_id = payroll_transactions.id
                                                    WHERE payroll_id='{$payroll_id}'");
$ot_hol_rest = mysqli_fetch_all($ot_holiday_restday);


$total_earnings = 1;
$total_debit = 0;
$total_ot_hol_rest = count($ot_hol_rest);
$total_deductions = 0;
$total_loans = 0;
$total_credit = 0;

foreach ($edl_adjs as $edl_adj):
    if ($edl_adj[1] == "EARNING")
        $total_earnings += 1;

    if ($edl_adj[1] == "DEBIT")
        $total_debit += 1;

    if ($edl_adj[1] == "DEDUCTION")
        $total_deductions += 1;

    if ($edl_adj[1] == "LOAN")
        $total_loans += 1;

    if ($edl_adj[1] == "CREDIT")
        $total_credit += 1;

endforeach;

$earning_sorted_list = [];
$deduction_sorted_list = [];
$ot_holiday_restday_sorted_list = [];
$loan_sorted_list = [];
$debit_sorted_list = [];
$credit_sorted_list = [];

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

        .addPayrollModule {
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
                <h4>Payroll Register</h4>
            </div>
            <div>

                <a href="payroll_register_csv.php?payroll_id=<?= $payroll_id ?>">
                    <button class="btn btn-light btn-sm">&nbsp;
                        Download CSV file
                        &nbsp;
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>
<div style="padding: 10px;">
    <table class="table" style="width: 100%;">
        <thead>
        <tr>
            <th scope="col" class="table-secondary"></th>

            <?php if ($total_earnings > 0): ?>
            <th scope="col" colspan="<?= $total_earnings ?>" class="table-success">Earning</th><?php endif; ?>

            <?php if ($total_debit > 0): ?>
            <th scope="col" colspan="<?= $total_debit ?>" class="table-success">Debit</th><?php endif; ?>

            <?php if ($total_ot_hol_rest > 0): ?>
            <th scope="col" colspan="<?= $total_ot_hol_rest ?>" class="table-success">
                    OT/HOLIDAY/RESTDAY</th><?php endif; ?>


            <?php if ($total_deductions > 0): ?>
            <th scope="col" colspan="<?= $total_deductions ?>" class="table-danger">Deduction</th><?php endif; ?>

            <?php if ($total_loans > 0): ?>
            <th scope="col" colspan="<?= $total_loans ?>" class="table-danger">Loan</th><?php endif; ?>

            <th scope="col" class="table-danger"></th>

            <?php if ($total_credit > 0): ?>
            <th scope="col" colspan="<?= $total_credit ?>" class="table-danger">Credit</th><?php endif; ?>

            <th scope="col" colspan="2" class="table-secondary">Computation</th>
        </tr>
        <tr>
            <th scope="col" class="table-secondary">Employees</th>

            <!--- FETCH COLUMNS --->
            <?php
            foreach ($edl_adjs as $earning):
                if ($earning[1] == "EARNING"):
                    array_push($earning_sorted_list, $earning[0]);
                    ?>
                    <th><?= $earning[0] ?></th>
                <?php
                endif;
            endforeach;
            ?>


            <?php
            foreach ($edl_adjs as $debit):
                if ($debit[1] == "DEBIT"):
                    array_push($debit_sorted_list, $debit[0]);
                    ?>
                    <th><?= $debit[0] ?></th>
                <?php
                endif;
            endforeach;
            ?>

            <?php
            foreach ($ot_hol_rest as $ot_hol_res):
                array_push($ot_holiday_restday_sorted_list, $ot_hol_res[0]);
                echo "<th>{$ot_hol_res[0]}</th>";
            endforeach;
            ?>


            <th class="table-success">Gross Pay</th>

            <?php
            foreach ($edl_adjs as $deduction):
                if ($deduction[1] == "DEDUCTION"):
                    array_push($deduction_sorted_list, $deduction[0]);
                    ?>
                    <th><?= $deduction[0] ?></th>
                <?php
                endif;
            endforeach;
            ?>

            <?php
            foreach ($edl_adjs as $loan):
                if ($loan[1] == "LOAN"):
                    array_push($loan_sorted_list, $loan[0]);
                    ?>
                    <th><?= $loan[0] ?></th>
                <?php
                endif;
            endforeach;
            ?>
            <th class="table-danger">TOTAL DED. & LOAN</th>

            <?php
            foreach ($edl_adjs as $credit):
                if ($credit[1] == "CREDIT"):
                    array_push($credit_sorted_list, $credit[0]);
                    ?>
                    <th><?= $credit[0] ?></th>
                <?php
                endif;
            endforeach;
            ?>
            <th>NET PAY</th>
            <!--- FETCH EDL COLUMNS --->

        </tr>
        </thead>

        <tbody>
        <?php

        $employees_query = "SELECT lastname, firstname, middlename, payroll_transactions.*, payroll_transactions.id as payroll_transaction_id  FROM employees 
                INNER JOIN payroll_transactions ON employees.id = payroll_transactions.employee_id
                WHERE payroll_id = '{$payroll_id}' ORDER BY lastname ASC";
        $employees_res = mysqli_query($conn, $employees_query);
        while ($employee = mysqli_fetch_assoc($employees_res)):
            $payroll_transaction_id = $employee['payroll_transaction_id'];
            ?>
            <tr>
                <td><?= $employee['lastname'] ?>, <?= $employee['firstname'] ?> <?= $employee['middlename'] ?></td>
                <?php
                $edl_adj_res = mysqli_query($conn, "SELECT * FROM payroll_transaction_edl_adj WHERE payroll_transaction_id  = '{$payroll_transaction_id}'");
                $edl_adjs = mysqli_fetch_all($edl_adj_res);

                $ot_holiday_restday_res = mysqli_query($conn, "SELECT * FROM payroll_transaction_ot_holiday_restday WHERE payroll_transaction_id  = '{$payroll_transaction_id}'");
                $ot_hol_res = mysqli_fetch_all($ot_holiday_restday_res);


                //EARNING
                foreach ($earning_sorted_list as $earning_item):
                    $is_found = false;
                    foreach ($edl_adjs as $earning):
                        if ($earning[2] == "EARNING") {
                            if ($earning[3] == $earning_item):
                                echo "<td>{$earning[4]}</td>";
                                $is_found = true;
                                break;
                            endif;
                        }
                    endforeach;
                    //if specific type of earning not registered for current employee
                    //display amount 0.00
                    if (!$is_found):
                        echo "<td>0</td>";
                    endif;
                endforeach;


                //DEBIT
                foreach ($debit_sorted_list as $debit_item):
                    $is_found = false;
                    foreach ($edl_adjs as $debit):
                        if ($debit[2] == "DEBIT") {
                            if ($debit[3] == $debit_item):
                                echo "<td>{$debit[4]}</td>";
                                $is_found = true;
                                break;
                            endif;
                        }
                    endforeach;
                    //if specific type of earning not registered for current employee
                    //display amount 0.00
                    if (!$is_found):
                        echo "<td>0</td>";
                    endif;
                endforeach;

                //                echo "<pre>";
                //                print_r($ot_holiday_restday_sorted_list);
                //                echo "</pre>";


                //OT HOLIDAY REST DAY
                foreach ($ot_holiday_restday_sorted_list as $ot_hol_rest_item):
                    $is_found = false;
                    foreach ($ot_hol_res as $val):
                        if ($val[2] == $ot_hol_rest_item):
                            echo "<td>{$val[4]}</td>";
                            $is_found = true;
                            break;
                        endif;
                    endforeach;
                    //if specific type of earning not registered for current employee
                    //display amount 0.00
                    if (!$is_found):
                        echo "<td>2</td>";
                    endif;
                endforeach;


                echo "<td class='table-success'>{$employee['gross_pay']}</td>";

                foreach ($deduction_sorted_list as $deduction_item):
                    $is_found = false;
                    foreach ($edl_adjs as $deduction):
                        if ($deduction[2] == "DEDUCTION") {
                            if ($deduction[3] == $deduction_item):
                                echo "<td>{$deduction[4]}</td>";
                                $is_found = true;
                                break;
                            endif;
                        }
                    endforeach;
                    if (!$is_found):
                        echo "<td>0</td>";
                    endif;
                endforeach;//DEDUCTION

                //LOAN
                foreach ($loan_sorted_list as $loan_item):
                    $is_found = false;
                    foreach ($edl_adjs as $loan):
                        if ($loan[2] == "LOAN") {
                            if ($loan[3] == $loan_item):
                                echo "<td>{$loan[4]}</td>";
                                $is_found = true;
                                break;
                            endif;
                        }
                    endforeach;
                    if (!$is_found):
                        echo "<td>0</td>";
                    endif;
                endforeach;//LOAN


                echo "<td class='table-danger'>{$employee['total_deduction_and_loans']}</td>";

                //CREDIT
                foreach ($credit_sorted_list as $credit_item):
                    $is_found = false;
                    foreach ($edl_adjs as $credit):
                        if ($credit[2] == "CREDIT") {
                            if ($credit[3] == $credit_item):
                                echo "<td>{$credit[4]}</td>";
                                $is_found = true;
                                break;
                            endif;
                        }
                    endforeach;
                    //if specific type of earning not registered for current employee
                    //display amount 0.00
                    if (!$is_found):
                        echo "<td>0</td>";
                    endif;
                endforeach;//CREDIT

                echo "<td>{$employee['net_pay']}</td>";
                ?>
            </tr>
        <?php
        endwhile;
        ?>

        </tbody>

    </table>
</div>
</body>
</html>