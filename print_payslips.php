<?php
include_once __DIR__ . "/config/database.php";
$payroll_id = $_GET['payroll_id'];


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

    <?php

    $query = "SELECT *, payroll_transactions.id as `payroll_transaction_id` FROM payroll_transactions 
            INNER JOIN employees ON employees.id = payroll_transactions.employee_id
            INNER JOIN departments ON departments.id = employees.department_id
            INNER JOIN payrolls ON payrolls.id = payroll_transactions.payroll_id 
            WHERE payroll_id = '{$payroll_id}'";
    $payroll_transaction_res = mysqli_query($conn, $query);
    while ($payroll_transaction = mysqli_fetch_assoc($payroll_transaction_res)):

        $edl_adj_query = "SELECT * FROM payroll_transaction_edl_adj WHERE payroll_transaction_id  = '{$payroll_transaction['payroll_transaction_id']}'";
        $edl_adj_res = mysqli_query($conn, $edl_adj_query);
        $edl_adjs = mysqli_fetch_all($edl_adj_res);

        $ot_holiday_restday_query = "SELECT * FROM payroll_transaction_ot_holiday_restday  WHERE payroll_transaction_id  = '{$payroll_transaction['payroll_transaction_id']}'";
        $ot_holiday_restday_res = mysqli_query($conn, $ot_holiday_restday_query);
        $ot_holiday_restdays = mysqli_fetch_all($ot_holiday_restday_res);
        ?>

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
                    Name: <b><?= $payroll_transaction['lastname'] ?>
                        , <?= $payroll_transaction['firstname'] ?> <?= $payroll_transaction['middlename'] ?>  </b>
                    <br>
                    Department: <b><?= $payroll_transaction['department'] ?> </b>
                </div>
                <div class="col-6">
                    Payroll: <b><?= $payroll_transaction['description'] ?> </b> <br>
                    Cutoff Date: <b><?= $payroll_transaction['from_date'] ?>
                        - <?= $payroll_transaction['to_date'] ?> </b>
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
                        <?php if (count($edl_adjs) > 0): ?>
                            <table style="width: 100%;">
                                <?php
                                foreach ($edl_adjs
                                         as $edl_adj):
                                    if ($edl_adj[2] == "EARNING"):
                                        ?>
                                        <tr>
                                            <td><?= $edl_adj[3] ?></td>
                                            <td>₱<?= number_format($edl_adj[4], 2, '.', ',') ?></td>
                                        </tr>
                                    <?php
                                    endif;
                                endforeach;
                                ?>
                                <tr style="border-top:1px solid;">
                                    <td>Total</td>
                                    <td>
                                        <b>₱<?= number_format($payroll_transaction['earning_total'], 2, '.', ',') ?></b>
                                    </td>
                                </tr>
                            </table>
                        <?php
                        endif;
                        ?>
                    </div>

                    <!--- DEDUCTION --->
                    <!--- DEDUCTION --->
                    <!--- DEDUCTION --->
                    <!--- DEDUCTION --->
                    <div class="col-12">
                        <div style="background-color: #bacbe6; padding: 5px; font-weight: bold;">DEDUCTION</div>
                        <?php if (count($edl_adjs) > 0): ?>
                            <table style="width: 100%;">
                                <?php
                                foreach ($edl_adjs
                                         as $edl_adj):
                                    if ($edl_adj[2] == "DEDUCTION"):
                                        ?>
                                        <tr>
                                            <td><?= $edl_adj[3] ?></td>
                                            <td>₱<?= number_format($edl_adj[4], 2, '.', ',') ?></td>
                                        </tr>
                                    <?php
                                    endif;
                                endforeach;
                                ?>
                                <tr style="border-top:1px solid;">
                                    <td>Total</td>
                                    <td>
                                        <b>₱<?= number_format($payroll_transaction['deduction_total'], 2, '.', ',') ?></b>
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
                        <?php if (count($edl_adjs) > 0): ?>
                            <table style="width: 100%;">
                                <?php
                                foreach ($edl_adjs
                                         as $edl_adj):
                                    if ($edl_adj[2] == "LOAN"):
                                        ?>
                                        <tr>
                                            <td><?= $edl_adj[3] ?></td>
                                            <td>₱<?= number_format($edl_adj[4], 2, '.', ',') ?></td>
                                        </tr>
                                    <?php
                                    endif;
                                endforeach;
                                ?>
                                <tr style="border-top:1px solid;">
                                    <td>Total</td>
                                    <td>
                                        <b>₱<?= number_format($payroll_transaction['loan_total'], 2, '.', ',') ?></b>
                                    </td>
                                </tr>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>

                <!--- OT/HOLIDAY/RESTDAY --->
                <!--- OT/HOLIDAY/RESTDAY --->
                <!--- OT/HOLIDAY/RESTDAY --->
                <!--- OT/HOLIDAY/RESTDAY --->
                <div class="col-6">
                    <div class="col-12">
                        <div style="background-color: #bcd0c7; padding: 5px; font-weight: bold;">OT/HOLIDAY/RESTDAY
                        </div>
                        <?php if (count($ot_holiday_restdays) > 0): ?>
                            <table style="width: 100%;">
                                <?php
                                foreach ($ot_holiday_restdays as $ot_holiday_restday):
                                    if ($ot_holiday_restday[3] > 0):
                                        ?>
                                        <tr>
                                            <td><?= $ot_holiday_restday[2] ?>(<?= $edl_adj[3] ?>HR/S)</td>
                                            <td>₱<?= number_format($ot_holiday_restday[4], 2, '.', ',') ?></td>
                                        </tr>
                                    <?php
                                    endif;
                                endforeach;
                                ?>
                                <tr style="border-top:1px solid;">
                                    <td>Total</td>
                                    <td>
                                        <b>₱<?= number_format($payroll_transaction['ot_holiday_restday_total'], 2, '.', ',') ?></b>
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
                        <?php if ($payroll_transaction != NULL): ?>
                            <table style="width: 100%; border-top: 5px solid #eccccf; margin-top:3px;">
                                <tr>
                                    <td style=" border: 1px solid #eccccf;">Absent
                                        (<?= $payroll_transaction['absent'] ?>
                                        hr/s)
                                    </td>
                                    <td style=" border: 1px solid #eccccf;">
                                        ₱<?= number_format($payroll_transaction['absent_amount'], 2, '.', ',') ?></td>
                                </tr>
                                <tr>
                                    <td style=" border: 1px solid #eccccf;">Tardiness
                                        (<?= $payroll_transaction['tardiness'] ?>min/s)
                                    </td>
                                    <td style=" border: 1px solid #eccccf;">
                                        ₱<?= number_format($payroll_transaction['tardiness_amount'], 2, '.', ',') ?></td>
                                </tr>
                            </table>
                        <?php endif; ?>
                    </div>

                    <!--- COMPUTATION-->
                    <!--- COMPUTATION-->
                    <!--- COMPUTATION-->
                    <!--- COMPUTATION-->
                    <div class="col-12">
                        <?php if ($payroll_transaction != NULL): ?>
                            <table style="width: 100%; border-top: 5px solid #bcd0c7; margin-top:3px;">
                                <tr>
                                    <td style=" border: 1px solid #bcd0c7;">GROSS PAY</td>
                                    <td style=" border: 1px solid #bcd0c7; font-weight: bold;">
                                        ₱<?= number_format($payroll_transaction['gross_pay'], 2, '.', ',') ?></td>
                                </tr>
                                <tr>
                                    <td style=" border: 1px solid #bcd0c7;">TOTAL DED&LOAN</td>
                                    <td style=" border: 1px solid #bcd0c7; font-weight: bold;">
                                        ₱<?= number_format($payroll_transaction['total_deduction_and_loans'], 2, '.', ',') ?></td>
                                </tr>
                                <tr>
                                    <td style=" border: 1px solid #bcd0c7;">NET PAY</td>
                                    <td style=" border: 1px solid #bcd0c7; font-weight: bold;">
                                        ₱<?= number_format($payroll_transaction['net_pay'], 2, '.', ',') ?></td>
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
                    Name: <b><?= $payroll_transaction['lastname'] ?>
                        , <?= $payroll_transaction['firstname'] ?> <?= $payroll_transaction['middlename'] ?>  </b>
                    <br>
                    Department: <b><?= $payroll_transaction['department'] ?> </b>
                </div>
                <div class="col-6">
                    Payroll: <b><?= $payroll_transaction['description'] ?> </b> <br>
                    Cutoff Date: <b><?= $payroll_transaction['from_date'] ?>
                        - <?= $payroll_transaction['to_date'] ?> </b>
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
                        <?php if (count($edl_adjs) > 0): ?>
                            <table style="width: 100%;">
                                <?php
                                foreach ($edl_adjs
                                         as $edl_adj):
                                    if ($edl_adj[2] == "EARNING"):
                                        ?>
                                        <tr>
                                            <td><?= $edl_adj[3] ?></td>
                                            <td>₱<?= number_format($edl_adj[4], 2, '.', ',') ?></td>
                                        </tr>
                                    <?php
                                    endif;
                                endforeach;
                                ?>
                                <tr style="border-top:1px solid;">
                                    <td>Total</td>
                                    <td>
                                        <b>₱<?= number_format($payroll_transaction['earning_total'], 2, '.', ',') ?></b>
                                    </td>
                                </tr>
                            </table>
                        <?php
                        endif;
                        ?>
                    </div>

                    <!--- DEDUCTION --->
                    <!--- DEDUCTION --->
                    <!--- DEDUCTION --->
                    <!--- DEDUCTION --->
                    <div class="col-12">
                        <div style="background-color: #bacbe6; padding: 5px; font-weight: bold;">DEDUCTION</div>
                        <?php if (count($edl_adjs) > 0): ?>
                            <table style="width: 100%;">
                                <?php
                                foreach ($edl_adjs
                                         as $edl_adj):
                                    if ($edl_adj[2] == "DEDUCTION"):
                                        ?>
                                        <tr>
                                            <td><?= $edl_adj[3] ?></td>
                                            <td>₱<?= number_format($edl_adj[4], 2, '.', ',') ?></td>
                                        </tr>
                                    <?php
                                    endif;
                                endforeach;
                                ?>
                                <tr style="border-top:1px solid;">
                                    <td>Total</td>
                                    <td>
                                        <b>₱<?= number_format($payroll_transaction['deduction_total'], 2, '.', ',') ?></b>
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
                        <?php if (count($edl_adjs) > 0): ?>
                            <table style="width: 100%;">
                                <?php
                                foreach ($edl_adjs
                                         as $edl_adj):
                                    if ($edl_adj[2] == "LOAN"):
                                        ?>
                                        <tr>
                                            <td><?= $edl_adj[3] ?></td>
                                            <td>₱<?= number_format($edl_adj[4], 2, '.', ',') ?></td>
                                        </tr>
                                    <?php
                                    endif;
                                endforeach;
                                ?>
                                <tr style="border-top:1px solid;">
                                    <td>Total</td>
                                    <td>
                                        <b>₱<?= number_format($payroll_transaction['loan_total'], 2, '.', ',') ?></b>
                                    </td>
                                </tr>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>

                <!--- OT/HOLIDAY/RESTDAY --->
                <!--- OT/HOLIDAY/RESTDAY --->
                <!--- OT/HOLIDAY/RESTDAY --->
                <!--- OT/HOLIDAY/RESTDAY --->
                <div class="col-6">
                    <div class="col-12">
                        <div style="background-color: #bcd0c7; padding: 5px; font-weight: bold;">OT/HOLIDAY/RESTDAY
                        </div>
                        <?php if (count($ot_holiday_restdays) > 0): ?>
                            <table style="width: 100%;">
                                <?php
                                foreach ($ot_holiday_restdays as $ot_holiday_restday):
                                    if ($ot_holiday_restday[3] > 0):
                                        ?>
                                        <tr>
                                            <td><?= $ot_holiday_restday[2] ?>(<?= $edl_adj[3] ?>HR/S)</td>
                                            <td>₱<?= number_format($ot_holiday_restday[4], 2, '.', ',') ?></td>
                                        </tr>
                                    <?php
                                    endif;
                                endforeach;
                                ?>
                                <tr style="border-top:1px solid;">
                                    <td>Total</td>
                                    <td>
                                        <b>₱<?= number_format($payroll_transaction['ot_holiday_restday_total'], 2, '.', ',') ?></b>
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
                        <?php if ($payroll_transaction != NULL): ?>
                            <table style="width: 100%; border-top: 5px solid #eccccf; margin-top:3px;">
                                <tr>
                                    <td style=" border: 1px solid #eccccf;">Absent
                                        (<?= $payroll_transaction['absent'] ?>
                                        hr/s)
                                    </td>
                                    <td style=" border: 1px solid #eccccf;">
                                        ₱<?= number_format($payroll_transaction['absent_amount'], 2, '.', ',') ?></td>
                                </tr>
                                <tr>
                                    <td style=" border: 1px solid #eccccf;">Tardiness
                                        (<?= $payroll_transaction['tardiness'] ?>min/s)
                                    </td>
                                    <td style=" border: 1px solid #eccccf;">
                                        ₱<?= number_format($payroll_transaction['tardiness_amount'], 2, '.', ',') ?></td>
                                </tr>
                            </table>
                        <?php endif; ?>
                    </div>

                    <!--- COMPUTATION-->
                    <!--- COMPUTATION-->
                    <!--- COMPUTATION-->
                    <!--- COMPUTATION-->
                    <div class="col-12">
                        <?php if ($payroll_transaction != NULL): ?>
                            <table style="width: 100%; border-top: 5px solid #bcd0c7; margin-top:3px;">
                                <tr>
                                    <td style=" border: 1px solid #bcd0c7;">GROSS PAY</td>
                                    <td style=" border: 1px solid #bcd0c7; font-weight: bold;">
                                        ₱<?= number_format($payroll_transaction['gross_pay'], 2, '.', ',') ?></td>
                                </tr>
                                <tr>
                                    <td style=" border: 1px solid #bcd0c7;">TOTAL DED&LOAN</td>
                                    <td style=" border: 1px solid #bcd0c7; font-weight: bold;">
                                        ₱<?= number_format($payroll_transaction['total_deduction_and_loans'], 2, '.', ',') ?></td>
                                </tr>
                                <tr>
                                    <td style=" border: 1px solid #bcd0c7;">NET PAY</td>
                                    <td style=" border: 1px solid #bcd0c7; font-weight: bold;">
                                        ₱<?= number_format($payroll_transaction['net_pay'], 2, '.', ',') ?></td>
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
    <?php
    endwhile;
    ?>
</body>
</html>