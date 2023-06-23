<?php
include_once __DIR__."/config/database.php";
//
//$payroll = unserialize(base64_decode($_GET['payroll']));
//$department = unserialize(base64_decode($_GET['department']));
//$employee = unserialize(base64_decode($_GET['employee']));


$payroll_id = $_GET['payroll_id'];
//$department_id = $department['id'];
$employee_id = $_GET['employee_id'];

$payroll_transaction = mysqli_query($conn,
    "SELECT * FROM payroll_transactions 
            INNER JOIN payrolls ON payrolls.id = payroll_transactions.payroll_id
            INNER JOIN employees ON employees.id = payroll_transactions.employee_id 
            INNER JOIN departments ON departments.id = employees.department_id 
            WHERE payroll_id = '{$payroll_id}' AND employee_id = '{$employee_id}'"
);
$payroll_transaction_record = mysqli_fetch_assoc($payroll_transaction);



//print_r(unserialize(base64_decode($_GET['payroll'])));
//print_r(unserialize(base64_decode($_GET['department'])));
//print_r(unserialize(base64_decode($_GET['employee'])));
//print_r($payroll_transaction_record);
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
            font-size: 8.5px !important;
        }

        .paper-size {
            width: 8.5in;
            height: 11in;
            border: 1px solid;
            box-sizing: border-box;
            margin: 0 auto;
            /*padding: 10px;*/
        }

        .payslip {
            height: 5.5in !important;
            background-color: white;
            border: 1px solid;
            box-sizing: border-box;
            padding: 10px 26px;
            /*padding: 10px;*/
        }
    </style>
</head>
<body>

<div class="row paper-size" id="payrollSlip">
    <div class="payslip col-6">
        <div style="display: flex; justify-content: center;">
            <img src="./logo.png" style="width: 0.5in;">
            <div style="font-size: 10px;">
                <b>Tagbilaran Community Hospital Corporation</b>
                <br/>
                117 MIGUEL PARRAS ST. TAGBILARAN CITY BOHOL 6330
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                Name: <b><?= $payroll_transaction_record['lastname'] ?>, <?= $payroll_transaction_record['firstname'] ?> <?= $payroll_transaction_record['middlename'] ?>  </b>
                <br>
                Department: <b><?= $payroll_transaction_record['department'] ?> </b>
            </div>
            <div class="col-6">
                Payroll: <b><?= $payroll_transaction_record['description'] ?> </b> <br>
                Cutoff Date: <b><?= $payroll_transaction_record['from_date'] ?> - <?= $payroll_transaction_record['to_date'] ?> </b>
            </div>
        </div>
        <div class="row">

            <div class="col-6">
                <!--- EARNINGS --->
                <!--- EARNINGS --->
                <!--- EARNINGS --->
                <!--- EARNINGS --->
                <div class="col-12">
                    <div style="background-color: #bcd0c7; padding: 5px; font-weight: bold;">Earnings</div>
                    <?php if ($payroll_transaction_record != NULL): ?>
                        <table style="width: 100%;">
                            <?php
                            $earning_query = mysqli_query($conn, "SELECT * FROM payroll_transaction_edl_adj WHERE payroll_transaction_id  = '{$payroll_transaction_record['id']}' AND type='EARNING'");
                            while ($row = mysqli_fetch_assoc($earning_query)):
                                ?>
                                <tr>
                                    <td><?= $row['name'] ?></td>
                                    <td>₱<?= number_format($row['amount'], 2, '.', ',') ?></td>
                                </tr>
                            <?php
                            endwhile;
                            ?>
                            <tr style="border-top:1px solid;">
                                <td>Total</td>
                                <td><b>₱<?= number_format($payroll_transaction_record['earning_total'], 2, '.', ',') ?></b>
                                </td>
                            </tr>
                        </table>
                    <?php endif; ?>

                </div>

                <!--- DEDUCTION --->
                <!--- DEDUCTION --->
                <!--- DEDUCTION --->
                <!--- DEDUCTION --->
                <div class="col-12">
                    <div style="background-color: #bacbe6; padding: 5px; font-weight: bold;">DEDUCTION</div>
                    <?php if ($payroll_transaction_record != NULL): ?>
                        <table style="width: 100%;">
                            <?php
                            $earning_query = mysqli_query($conn, "SELECT * FROM payroll_transaction_edl_adj WHERE payroll_transaction_id  = '{$payroll_transaction_record['id']}' AND type='DEDUCTION'");
                            while ($row = mysqli_fetch_assoc($earning_query)):
                                ?>
                                <tr>
                                    <td><?= $row['name'] ?></td>
                                    <td>₱<?= number_format($row['amount'], 2, '.', ',') ?></td>
                                </tr>
                            <?php
                            endwhile;
                            ?>
                            <tr style="border-top:1px solid;">
                                <td>Total</td>
                                <td>
                                    <b>₱<?= number_format($payroll_transaction_record['deduction_total'], 2, '.', ',') ?></b>
                                </td>
                            </tr>
                        </table>
                    <?php endif; ?>
                </div>

                <!--- LOAN --->
                <!--- LOAN --->
                <!--- LOAN --->
                <!--- LOAN --->
                <div class="col-12">
                    <div style="background-color: #eccccf; padding: 5px; font-weight: bold;">LOAN</div>
                    <?php if ($payroll_transaction_record != NULL): ?>
                        <table style="width: 100%;">
                            <?php
                            $earning_query = mysqli_query($conn, "SELECT * FROM payroll_transaction_edl_adj WHERE payroll_transaction_id  = '{$payroll_transaction_record['id']}' AND type='LOAN'");
                            while ($row = mysqli_fetch_assoc($earning_query)):
                                ?>
                                <tr>
                                    <td><?= $row['name'] ?></td>
                                    <td>₱<?= number_format($row['amount'], 2, '.', ',') ?></td>
                                </tr>
                            <?php
                            endwhile;
                            ?>
                            <tr style="border-top:1px solid;">
                                <td>Total</td>
                                <td><b>₱<?= number_format($payroll_transaction_record['loan_total'], 2, '.', ',') ?></b>
                                </td>
                            </tr>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-6">
            <!--- OT/HOLIDAY/RESTDAY --->
            <!--- OT/HOLIDAY/RESTDAY --->
            <!--- OT/HOLIDAY/RESTDAY --->
            <!--- OT/HOLIDAY/RESTDAY --->
            <div class="col-12">
                <div style="background-color: #bcd0c7; padding: 5px; font-weight: bold;">OT/HOLIDAY/RESTDAY</div>
                <?php if ($payroll_transaction_record != NULL): ?>
                    <table style="width: 100%;">
                        <?php
                        $earning_query = mysqli_query($conn, "SELECT * FROM payroll_transaction_ot_holiday_restday WHERE payroll_transaction_id  = '{$payroll_transaction_record['id']}' AND hour > 0");
                        while ($row = mysqli_fetch_assoc($earning_query)):
                            ?>
                            <tr>
                                <td><?= $row['type'] ?>(<?= $row['hour'] ?>hr/s)</td>
                                <td>₱<?= number_format($row['amount'], 2, '.', ',') ?></td>
                            </tr>
                        <?php
                        endwhile;
                        ?>
                        <tr style="border-top:1px solid;">
                            <td>Total</td>
                            <td>
                                <b>₱<?= number_format($payroll_transaction_record['ot_holiday_restday_total'], 2, '.', ',') ?></b>
                            </td>
                        </tr>
                    </table>
                <?php endif; ?>
            </div>

            <!--- >ABSENT/TARDINESS --->
            <!--- >ABSENT/TARDINESS --->
            <!--- >ABSENT/TARDINESS --->
            <!--- >ABSENT/TARDINESS --->
            <div class="col-12">
                <?php if ($payroll_transaction_record != NULL): ?>
                    <table style="width: 100%; border-top: 5px solid #eccccf; margin-top:3px;">
                        <tr>
                            <td style=" border: 1px solid #eccccf;">Absent (<?= $payroll_transaction_record['absent'] ?>
                                hr/s)
                            </td>
                            <td style=" border: 1px solid #eccccf;">
                                ₱<?= number_format($payroll_transaction_record['absent_amount'], 2, '.', ',') ?></td>
                        </tr>
                        <tr>
                            <td style=" border: 1px solid #eccccf;">Tardiness
                                (<?= $payroll_transaction_record['tardiness'] ?>min/s)
                            </td>
                            <td style=" border: 1px solid #eccccf;">
                                ₱<?= number_format($payroll_transaction_record['tardiness_amount'], 2, '.', ',') ?></td>
                        </tr>
                    </table>
                <?php endif; ?>
            </div>

            <!--- COMPUTATION-->
            <!--- COMPUTATION-->
            <!--- COMPUTATION-->
            <!--- COMPUTATION-->
            <div class="col-12">
                <?php if ($payroll_transaction_record != NULL): ?>
                    <table style="width: 100%; border-top: 5px solid #bcd0c7; margin-top:3px;">
                        <tr>
                            <td style=" border: 1px solid #bcd0c7;">GROSS PAY</td>
                            <td style=" border: 1px solid #bcd0c7; font-weight: bold;">
                                ₱<?= number_format($payroll_transaction_record['gross_pay'], 2, '.', ',') ?></td>
                        </tr>
                        <tr>
                            <td style=" border: 1px solid #bcd0c7;">TOTAL DED&LOAN</td>
                            <td style=" border: 1px solid #bcd0c7; font-weight: bold;">
                                ₱<?= number_format($payroll_transaction_record['total_deduction_and_loans'], 2, '.', ',') ?></td>
                        </tr>
                        <tr>
                            <td style=" border: 1px solid #bcd0c7;">NET PAY</td>
                            <td style=" border: 1px solid #bcd0c7; font-weight: bold;">
                                ₱<?= number_format($payroll_transaction_record['net_pay'], 2, '.', ',') ?></td>
                        </tr>
                    </table>
                <?php endif; ?>
            </div>
            </div>
        </div>

        <br>
        <div class="row">
            <div class="col-6 justify-content-center" style="text-align: center;">
                <label style="text-decoration: underline; font-weight: bold">________________________________</label>
                <label>Signature Over Printed Name</label>

            </div>
            <div class="col-6 justify-content-center" style="text-align: center;">
                <label style="text-decoration: underline; font-weight: bold">JAN MICHEAL M. EBARA</label>
                <label>PAYROLL Incharge</label>

            </div>
        </div>
    </div>
    <div class="payslip col-6">
        <div style="display: flex; justify-content: center;">
            <img src="./logo.png" style="width: 0.5in;">
            <div style="font-size: 10px;">
                <b>Tagbilaran Community Hospital Corporation</b>
                <br/>
                117 MIGUEL PARRAS ST. TAGBILARAN CITY BOHOL 6330
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                Name: <b><?= $payroll_transaction_record['lastname'] ?>, <?= $payroll_transaction_record['firstname'] ?> <?= $payroll_transaction_record['middlename'] ?>  </b>
                <br>
                Department: <b><?= $payroll_transaction_record['department'] ?> </b>
            </div>
            <div class="col-6">
                Payroll: <b><?= $payroll_transaction_record['description'] ?> </b> <br>
                Cutoff Date: <b><?= $payroll_transaction_record['from_date'] ?> - <?= $payroll_transaction_record['to_date'] ?> </b>
            </div>
        </div>
        <div class="row">

            <div class="col-6">
                <!--- EARNINGS --->
                <!--- EARNINGS --->
                <!--- EARNINGS --->
                <!--- EARNINGS --->
                <div class="col-12">
                    <div style="background-color: #bcd0c7; padding: 5px; font-weight: bold;">Earnings</div>
                    <?php if ($payroll_transaction_record != NULL): ?>
                        <table style="width: 100%;">
                            <?php
                            $earning_query = mysqli_query($conn, "SELECT * FROM payroll_transaction_edl_adj WHERE payroll_transaction_id  = '{$payroll_transaction_record['id']}' AND type='EARNING'");
                            while ($row = mysqli_fetch_assoc($earning_query)):
                                ?>
                                <tr>
                                    <td><?= $row['name'] ?></td>
                                    <td>₱<?= number_format($row['amount'], 2, '.', ',') ?></td>
                                </tr>
                            <?php
                            endwhile;
                            ?>
                            <tr style="border-top:1px solid;">
                                <td>Total</td>
                                <td><b>₱<?= number_format($payroll_transaction_record['earning_total'], 2, '.', ',') ?></b>
                                </td>
                            </tr>
                        </table>
                    <?php endif; ?>

                </div>

                <!--- DEDUCTION --->
                <!--- DEDUCTION --->
                <!--- DEDUCTION --->
                <!--- DEDUCTION --->
                <div class="col-12">
                    <div style="background-color: #bacbe6; padding: 5px; font-weight: bold;">DEDUCTION</div>
                    <?php if ($payroll_transaction_record != NULL): ?>
                        <table style="width: 100%;">
                            <?php
                            $earning_query = mysqli_query($conn, "SELECT * FROM payroll_transaction_edl_adj WHERE payroll_transaction_id  = '{$payroll_transaction_record['id']}' AND type='DEDUCTION'");
                            while ($row = mysqli_fetch_assoc($earning_query)):
                                ?>
                                <tr>
                                    <td><?= $row['name'] ?></td>
                                    <td>₱<?= number_format($row['amount'], 2, '.', ',') ?></td>
                                </tr>
                            <?php
                            endwhile;
                            ?>
                            <tr style="border-top:1px solid;">
                                <td>Total</td>
                                <td>
                                    <b>₱<?= number_format($payroll_transaction_record['deduction_total'], 2, '.', ',') ?></b>
                                </td>
                            </tr>
                        </table>
                    <?php endif; ?>
                </div>

                <!--- LOAN --->
                <!--- LOAN --->
                <!--- LOAN --->
                <!--- LOAN --->
                <div class="col-12">
                    <div style="background-color: #eccccf; padding: 5px; font-weight: bold;">LOAN</div>
                    <?php if ($payroll_transaction_record != NULL): ?>
                        <table style="width: 100%;">
                            <?php
                            $earning_query = mysqli_query($conn, "SELECT * FROM payroll_transaction_edl_adj WHERE payroll_transaction_id  = '{$payroll_transaction_record['id']}' AND type='LOAN'");
                            while ($row = mysqli_fetch_assoc($earning_query)):
                                ?>
                                <tr>
                                    <td><?= $row['name'] ?></td>
                                    <td>₱<?= number_format($row['amount'], 2, '.', ',') ?></td>
                                </tr>
                            <?php
                            endwhile;
                            ?>
                            <tr style="border-top:1px solid;">
                                <td>Total</td>
                                <td><b>₱<?= number_format($payroll_transaction_record['loan_total'], 2, '.', ',') ?></b>
                                </td>
                            </tr>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-6">
                <!--- OT/HOLIDAY/RESTDAY --->
                <!--- OT/HOLIDAY/RESTDAY --->
                <!--- OT/HOLIDAY/RESTDAY --->
                <!--- OT/HOLIDAY/RESTDAY --->
                <div class="col-12">
                    <div style="background-color: #bcd0c7; padding: 5px; font-weight: bold;">OT/HOLIDAY/RESTDAY</div>
                    <?php if ($payroll_transaction_record != NULL): ?>
                        <table style="width: 100%;">
                            <?php
                            $earning_query = mysqli_query($conn, "SELECT * FROM payroll_transaction_ot_holiday_restday WHERE payroll_transaction_id  = '{$payroll_transaction_record['id']}' AND hour > 0");
                            while ($row = mysqli_fetch_assoc($earning_query)):
                                ?>
                                <tr>
                                    <td><?= $row['type'] ?>(<?= $row['hour'] ?>hr/s)</td>
                                    <td>₱<?= number_format($row['amount'], 2, '.', ',') ?></td>
                                </tr>
                            <?php
                            endwhile;
                            ?>
                            <tr style="border-top:1px solid;">
                                <td>Total</td>
                                <td>
                                    <b>₱<?= number_format($payroll_transaction_record['ot_holiday_restday_total'], 2, '.', ',') ?></b>
                                </td>
                            </tr>
                        </table>
                    <?php endif; ?>
                </div>

                <!--- >ABSENT/TARDINESS --->
                <!--- >ABSENT/TARDINESS --->
                <!--- >ABSENT/TARDINESS --->
                <!--- >ABSENT/TARDINESS --->
                <div class="col-12">
                    <?php if ($payroll_transaction_record != NULL): ?>
                        <table style="width: 100%; border-top: 5px solid #eccccf; margin-top:3px;">
                            <tr>
                                <td style=" border: 1px solid #eccccf;">Absent (<?= $payroll_transaction_record['absent'] ?>
                                    hr/s)
                                </td>
                                <td style=" border: 1px solid #eccccf;">
                                    ₱<?= number_format($payroll_transaction_record['absent_amount'], 2, '.', ',') ?></td>
                            </tr>
                            <tr>
                                <td style=" border: 1px solid #eccccf;">Tardiness
                                    (<?= $payroll_transaction_record['tardiness'] ?>min/s)
                                </td>
                                <td style=" border: 1px solid #eccccf;">
                                    ₱<?= number_format($payroll_transaction_record['tardiness_amount'], 2, '.', ',') ?></td>
                            </tr>
                        </table>
                    <?php endif; ?>
                </div>

                <!--- COMPUTATION-->
                <!--- COMPUTATION-->
                <!--- COMPUTATION-->
                <!--- COMPUTATION-->
                <div class="col-12">
                    <?php if ($payroll_transaction_record != NULL): ?>
                        <table style="width: 100%; border-top: 5px solid #bcd0c7; margin-top:3px;">
                            <tr>
                                <td style=" border: 1px solid #bcd0c7;">GROSS PAY</td>
                                <td style=" border: 1px solid #bcd0c7; font-weight: bold;">
                                    ₱<?= number_format($payroll_transaction_record['gross_pay'], 2, '.', ',') ?></td>
                            </tr>
                            <tr>
                                <td style=" border: 1px solid #bcd0c7;">TOTAL DED&LOAN</td>
                                <td style=" border: 1px solid #bcd0c7; font-weight: bold;">
                                    ₱<?= number_format($payroll_transaction_record['total_deduction_and_loans'], 2, '.', ',') ?></td>
                            </tr>
                            <tr>
                                <td style=" border: 1px solid #bcd0c7;">NET PAY</td>
                                <td style=" border: 1px solid #bcd0c7; font-weight: bold;">
                                    ₱<?= number_format($payroll_transaction_record['net_pay'], 2, '.', ',') ?></td>
                            </tr>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <br>
        <div class="row">
            <div class="col-6 justify-content-center" style="text-align: center;">
                <label style="text-decoration: underline; font-weight: bold">________________________________</label>
                <label>Signature Over Printed Name</label>

            </div>
            <div class="col-6 justify-content-center" style="text-align: center;">
                <label style="text-decoration: underline; font-weight: bold">JAN MICHEAL M. EBARA</label>
                <label>PAYROLL In-charge</label>

            </div>
        </div>
    </div>
</body>
</html>