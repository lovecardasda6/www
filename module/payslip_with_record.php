<h1>RECORD FOUND!</h1>

<?php
$dtr = "SELECT * FROM DTR WHERE employee_id = '{$employee['id']}' AND date_of >= '{$payroll['from']}' AND date_of <= '{$payroll['to']}'";
$query = mysqli_query($conn, $dtr);
$totalPresent = 0;
$totalAbsent = 0;
$totalTardiness = 0;
while ($row = mysqli_fetch_assoc($query)):
    if ($row['check_in'] != "" and $row['check_out'] != "") {
        $totalPresent += 1;
        $totalTardiness += ($row['late_in'] + $row['early_out']);
    } else
        $totalAbsent += 1;
endwhile;
?>


<hr>

<div class="row">


    <?php
    $payroll_transaction_edl_adj_query = mysqli_query($conn, "SELECT * FROM payroll_transaction_edl_adj WHERE payroll_transaction_id  = '{$payroll_record['id']}'");
    $payroll_transaction_edl_adj_arr = mysqli_fetch_all($payroll_transaction_edl_adj_query);
    //    echo "<pre>";
    //    print_r($payroll_transaction_edl_adj_arr);
    //    echo "</pre>";
    //    print_r($payroll_transaction_edl_adj_arr);
    ?>


    <!-- Earnings -->
    <!-- Earnings -->
    <!-- Earnings -->
    <div class="col-lg-4 col-md-4 col-sm-12">
        <table class="table earnings">
            <thead>
            <tr class="table-success">
                <th scope="col">Earnings</th>
                <th scope="col">Amount</th>
            </tr>
            </thead>
            <tbody style="border-top: 3px solid #198754;">
            <?php
            foreach ($payroll_transaction_edl_adj_arr as $earning):
                if ($earning[2] == "EARNING"):
                    ?>
                    <tr>
                        <td><?= $earning[3] ?></td>
                        <td contenteditable="true" <?= $earning[3] == "BASIC PAY" ? "id='totalBasicPay'" : "" ?>><?= $earning[4] ?></td>
                    </tr>
                <?php
                endif;
            endforeach;
            ?>
            </tbody>
        </table>
        <table class="table">
            <tr class="table-success">
                <td>
                    <b>TOTAL AMOUNT <b>₱</b></b>
                </td>
                <td id="totalEarnings"><?= $payroll_record['earning_total'] ?></td>
            </tr>
        </table>
    </div>


    <!-- Deduction -->
    <!-- Deduction -->
    <!-- Deduction -->
    <div class="col-lg-4 col-md-4 col-sm-12">
        <table class="table deductions">
            <thead>
            <tr class="table-primary">
                <th scope="col">Deduction</th>
                <th scope="col">Amount</th>
            </tr>
            </thead>
            <tbody style="border-top: 3px solid #0d6efd;">
            <?php
            foreach ($payroll_transaction_edl_adj_arr as $earning):
                if ($earning[2] == "DEDUCTION"):
                    ?>
                    <tr>
                        <td><?= $earning[3] ?></td>
                        <td contenteditable="true"><?= $earning[4] ?></td>
                    </tr>
                <?php
                endif;
            endforeach;
            ?>
            </tbody>
        </table>
        <table class="table">

            <tr class="table-primary">
                <td>
                    <b>TOTAL AMOUNT ₱</b>
                </td>

                <td id="totalDeductions"><?= $payroll_record['deduction_total'] ?></td>
            </tr>
        </table>
    </div>


    <!-- Loan -->
    <!-- Loan -->
    <!-- Loan -->
    <div class="col-lg-4 col-md-4 col-sm-12">
        <table class="table loans">
            <thead>
            <tr class="table-danger">
                <th scope="col">Loan</th>
                <th scope="col">Amount</th>
            </tr>
            </thead>
            <tbody style="border-top: 3px solid #dc3545;">
            <?php
            foreach ($payroll_transaction_edl_adj_arr as $earning):
                if ($earning[2] == "LOAN"):
                    ?>
                    <tr>
                        <td><?= $earning[3] ?></td>
                        <td contenteditable="true"><?= $earning[4] ?></td>
                    </tr>
                <?php
                endif;
            endforeach;
            ?>
            </tbody>
        </table>
        <table class="table">
            <tr class="table-danger">
                <td>
                    <b>TOTAL AMOUNT ₱</b>
                </td>
                <td id="totalLoans"><?= $payroll_record['loan_total'] ?></td>
            </tr>
        </table>
    </div>
</div>

<br/>

<div class="row">
    <!-- OT / Holidays / Rest Day -->
    <!-- OT / Holidays / Rest Day -->
    <!-- OT / Holidays / Rest Day -->


    <div class="col-lg-6  col-md-6  col-sm-12">
        <table class="table ot_holiday_rest_day">
            <thead>
            <tr class="table-success">
                <th scope="col">OT / Holidays / Rest Day</th>
                <th scope="col">Hours</th>
                <th scope="col">Amount</th>
            </tr>
            </thead>
            <tbody style="border-top: 3px solid #198754;">
            <?php
            $payroll_transaction_ot_holiday_restday_query = mysqli_query($conn, "SELECT * FROM payroll_transaction_ot_holiday_restday WHERE  payroll_transaction_id  = '{$payroll_record['id']}' ");
            $payroll_transaction_ot_holiday_restday_query_array = mysqli_fetch_all($payroll_transaction_ot_holiday_restday_query);


            foreach ($payroll_transaction_ot_holiday_restday_query_array as $ot_holiday_restday):
                ?>
                <?php if ($ot_holiday_restday[2] == "REGULAR OT (125%)"): ?>
                <tr>
                    <td id="regular_ot_type">REGULAR OT (125%)</td>
                    <td contenteditable="true" id="regular_ot"><?= $ot_holiday_restday[3] ?></td>
                    <td contenteditable="true" id="regular_ot_amount"><?= $ot_holiday_restday[4] ?></td>
                </tr>
            <?php endif; ?>
                <?php if ($ot_holiday_restday[2] == "REST DAY PAY (130%)"): ?>
                <tr>
                    <td id="rest_day_type">REST DAY PAY (130%)</td>
                    <td contenteditable="true" id="rest_day"><?= $ot_holiday_restday[3] ?></td>
                    <td contenteditable="true" id="rest_day_amount"><?= $ot_holiday_restday[4] ?></td>
                </tr>
            <?php endif; ?>
                <?php if ($ot_holiday_restday[2] == "RD OT PAY (169%)"): ?>
                <tr>
                    <td id="rd_ot_type">RD OT PAY (169%)</td>
                    <td contenteditable="true" id="rd_ot"><?= $ot_holiday_restday[3] ?></td>
                    <td contenteditable="true" id="rd_ot_amount"><?= $ot_holiday_restday[4] ?></td>
                </tr>
            <?php endif; ?>
                <?php if ($ot_holiday_restday[2] == "SNWH PAY (30%)"): ?>
                <tr>
                    <td id="snwh_type">SNWH PAY (30%)</td>
                    <td contenteditable="true" id="snwh"><?= $ot_holiday_restday[3] ?></td>
                    <td contenteditable="true" id="snwh_amount"><?= $ot_holiday_restday[4] ?></td>
                </tr>
            <?php endif; ?>
                <?php if ($ot_holiday_restday[2] == "SNWH OT PAY (69%)"): ?>
                <tr>
                    <td id="snwh_ot_type">SNWH OT PAY (69%)</td>
                    <td contenteditable="true" id="snwh_ot"><?= $ot_holiday_restday[3] ?></td>
                    <td contenteditable="true" id="snwh_ot_amount"><?= $ot_holiday_restday[4] ?></td>
                </tr>
            <?php endif; ?>
                <?php if ($ot_holiday_restday[2] == "SL WITH PAY"): ?>
                <tr>
                    <td id="sl_with_pay_type">SL WITH PAY</td>
                    <td contenteditable="true" id="sl_with_pay"><?= $ot_holiday_restday[3] ?></td>
                    <td contenteditable="true" id="sl_with_pay_amount"><?= $ot_holiday_restday[4] ?></td>
                </tr>
            <?php endif; ?>
                <?php if ($ot_holiday_restday[2] == "VL WITH PAY"): ?>
                <tr>
                    <td id="vl_with_pay_type">VL WITH PAY</td>
                    <td contenteditable="true" id="vl_with_pay"><?= $ot_holiday_restday[3] ?></td>
                    <td contenteditable="true" id="vl_with_pay_amount"><?= $ot_holiday_restday[4] ?></td>
                </tr>
            <?php endif; ?>
                <?php if ($ot_holiday_restday[2] == "VL CONVERSION"): ?>
                <tr>
                    <td id="vl_conversion_type">VL CONVERSION</td>
                    <td contenteditable="true" id="vl_conversion"><?= $ot_holiday_restday[3] ?></td>
                    <td contenteditable="true" id="vl_conversion_amount"><?= $ot_holiday_restday[4] ?></td>
                </tr>
            <?php endif; ?>
                <?php if ($ot_holiday_restday[2] == "REGULAR HP"): ?>
                <tr>
                    <td id="regular_hp_type">REGULAR HP</td>
                    <td contenteditable="true" id="regular_hp"><?= $ot_holiday_restday[3] ?></td>
                    <td contenteditable="true" id="regular_hp_amount"><?= $ot_holiday_restday[4] ?></td>
                </tr>
            <?php endif; ?>
                <?php if ($ot_holiday_restday[2] == "LEGAL HP/DOUBLE PAY"): ?>
                <tr>
                    <td id="legal_double_type">LEGAL HP/DOUBLE PAY</td>
                    <td contenteditable="true" id="legal_double"><?= $ot_holiday_restday[3] ?></td>
                    <td contenteditable="true" id="legal_double_amount"><?= $ot_holiday_restday[4] ?></td>
                </tr>
            <?php endif; ?>
                <?php if ($ot_holiday_restday[2] == "NIGHT DIFF (125%)"): ?>
                <tr>
                    <td id="night_diff_type">NIGHT DIFF (125%)</td>
                    <td contenteditable="true" id="night_diff"><?= $ot_holiday_restday[3] ?></td>
                    <td contenteditable="true" id="night_diff_amount"><?= $ot_holiday_restday[4] ?></td>
                </tr>
            <?php endif; ?>
                <?php if ($ot_holiday_restday[2] == "RH OT PAY"): ?>
                <tr>
                    <td id="rh_ot_type">RH OT PAY</td>
                    <td contenteditable="true" id="rh_ot"><?= $ot_holiday_restday[3] ?></td>
                    <td contenteditable="true" id="rh_ot_amount"><?= $ot_holiday_restday[4] ?></td>
                </tr>
            <?php
            endif;
            endforeach;
            ?>
            </tbody>
        </table>
        <table class="table ot_holiday_rest_day">
            <thead>
            <tr class="table-success">
                <th scope="col">TOTAL AMOUNT ₱</th>
                <th></th>
                <th scope="col" id="ot_holiday_rest_day_amount"><?= $payroll_record['ot_holiday_restday_total'] ?></th>
            </tr>
            </thead>
        </table>
    </div>

    <!-- DEBIT ADJUSTMENT -->
    <!-- DEBIT ADJUSTMENT -->
    <!-- DEBIT ADJUSTMENT -->
    <div class="col-lg-3  col-md-3  col-sm-12">
        <table class="table debit">
            <thead>
            <tr class="table-success">
                <th scope="col">Debit Adjustment</th>
                <th scope="col">Amount</th>
            </tr>
            </thead>
            <tbody style="border-top: 3px solid #0d6efd;">
            <?php
            foreach ($payroll_transaction_edl_adj_arr as $earning):
                if ($earning[2] == "DEBIT"):
                    ?>
                    <tr>
                        <td><?= $earning[3] ?></td>
                        <td contenteditable="true"><?= $earning[4] ?></td>
                    </tr>
                <?php
                endif;
            endforeach;
            ?>
            </tbody>
        </table>
        <table class="table">
            <tr class="table-success">
                <td>
                    <b>TOTAL AMOUNT <b>₱</b></b>
                </td>
                <td id="totalDebit"><?= $payroll_record['debit_total'] ?></td>
            </tr>
        </table>
    </div>

    <!-- CREDIT ADJUSTMENT -->
    <!-- CREDIT ADJUSTMENT -->
    <!-- CREDIT ADJUSTMENT -->
    <div class="col-lg-3  col-md-3 col-sm-12">
        <table class="table credit">
            <thead>
            <tr class="table-danger">
                <th scope="col">Credit Adjustment</th>
                <th scope="col">Amount</th>
            </tr>
            </thead>
            <tbody style="border-top: 3px solid #dc3545;">
            <tbody style="border-top: 3px solid #dc3545;">
            <?php
            foreach ($payroll_transaction_edl_adj_arr as $earning):
                if ($earning[2] == "CREDIT"):
                    ?>
                    <tr>
                        <td><?= $earning[3] ?></td>
                        <td contenteditable="true"><?= $earning[4] ?></td>
                    </tr>
                <?php
                endif;
            endforeach;
            ?>
            </tbody>
        </table>
        <table class="table">
            <tr class="table-danger">
                <td>
                    <b>TOTAL AMOUNT <b>₱</b></b>
                </td>
                <td id="totalCredit"><?= $payroll_record['credit_total'] ?></td>
            </tr>
        </table>
    </div>
</div>

<hr/>

<div class="row">
    <!-- ABSENT -->
    <!-- ABSENT -->
    <!-- ABSENT -->
    <div class="col-4">
        <table class="table">
            <tbody style="border: 3px solid #a52834;">
            <tr class="table-danger">
                <td></td>
                <td id="">Day(s)</td>
                <td id="">Amount</td>
            </tr>
            <tr>
                <td>Absent (Days)</td>
                <td id="absentDays" contenteditable="true"><?= $payroll_record['absent'] ?></td>
                <td id="absentAmount" style="font-weight: bold"
                    contenteditable="true"><?= $payroll_record['absent_amount'] ?></td>
            </tr>
            </tbody>
        </table>
    </div>

    <!-- TARDINESS -->
    <!-- TARDINESS -->
    <!-- TARDINESS -->
    <div class="col-4">
        <table class="table">
            <tbody style="border: 3px solid #a52834;">
            <tr class="table-danger">
                <td></td>
                <td>Minutes(s)</td>
                <td>Amount</td>
            </tr>
            <tr>
                <td>Tardiness</td>
                <td id="tardinessMinutes" contenteditable="true"><?= $payroll_record['tardiness'] ?></td>
                <td id="tardinessAmount" style="font-weight: bold"
                    contenteditable="true"><?= $payroll_record['tardiness_amount'] ?></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <!-- FINAL CALCULATION -->
    <!-- FINAL CALCULATION -->
    <!-- FINAL CALCULATION -->
    <div class="col-4">
        <table class="table">
            <tbody style="border: 3px solid #198754;">
            <tr>
                <td>Gross Pay <b>₱</b></td>
                <td id="grossPay"><?= $payroll_record['gross_pay'] ?></td>
            </tr>
            <tr>
                <td>Total Deductions & Loans <b>₱</b></td>
                <td id="totalLoansAndDeductions"><?= $payroll_record['total_deduction_and_loans'] ?></td>
            </tr>
            <tr>
                <td>Net Pay <b>₱</b></td>
                <td id="netPay"><?= $payroll_record['net_pay'] ?></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<hr>

<!--- BUTTONS --->
<!--- BUTTONS --->
<!--- BUTTONS --->
<div class="row">
    <div class="col">
        <!--        <button class="btn btn-primary" onclick="computePayroll()">Compute Payroll</button>-->
        <button class="btn btn-success" id="savePayroll" onclick="savePaySlip()">Save Payroll</button>
    </div>
</div>

<script>
    const monthly_salary = <?= $employee['salary'] ?>;
    const employee_id = <?= $employee['id'] ?>;
    const payroll_id = <?= $payroll['id'] ?>;

</script>