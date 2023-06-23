<h1>RECORD NOT FOUND!</h1>

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
            <tr>
                <td>BASIC PAY</td>
                <td contenteditable="true" id="totalBasicPay"><?= $employee['salary'] / 2 ?></td>
            </tr>
            <?php
            $res = mysqli_query($conn, "SELECT * FROM employee_edl INNER JOIN edl_adjustment ON edl_adjustment.id = employee_edl.edl_id WHERE employee_id = {$employee['id']} AND type = 'EARNING'");
            while ($row = mysqli_fetch_assoc($res)):
                ?>
                <tr>
                    <td><?= $row['description'] ?></td>
                    <td contenteditable="true"><?= $row['amount'] ?></td>
                </tr>
            <?php
            endwhile;
            ?>
            </tbody>
        </table>
        <table class="table">
            <tr class="table-success">
                <td>
                    <b>TOTAL AMOUNT <b>₱</b></b>
                </td>
                <td id="totalEarnings"></td>
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
            $res = mysqli_query($conn, "SELECT * FROM employee_edl INNER JOIN edl_adjustment ON edl_adjustment.id = employee_edl.edl_id WHERE employee_id = {$employee['id']} AND type = 'DEDUCTION'");
            while ($row = mysqli_fetch_assoc($res)):
                ?>
                <tr>
                    <td><?= $row['description'] ?></td>
                    <td contenteditable="true"><?= $row['amount'] ?></td>
                </tr>
            <?php
            endwhile;
            ?>
            </tbody>
        </table>
        <table class="table">

            <tr class="table-primary">
                <td>
                    <b>TOTAL AMOUNT ₱</b>
                </td>

                <td id="totalDeductions"></td>
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
            $res = mysqli_query($conn, "SELECT * FROM employee_edl INNER JOIN edl_adjustment ON edl_adjustment.id = employee_edl.edl_id WHERE employee_id = {$employee['id']} AND type = 'LOAN'");
            while ($row = mysqli_fetch_assoc($res)):
                ?>
                <tr>
                    <td><?= $row['description'] ?></td>
                    <td contenteditable="true"><?= $row['amount'] ?></td>
                </tr>
            <?php
            endwhile;
            ?>
            </tbody>
        </table>
        <table class="table">
            <tr class="table-danger">
                <td>
                    <b>TOTAL AMOUNT ₱</b>
                </td>
                <td id="totalLoans"></td>
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
            <tr>
                <td id="regular_ot_type">REGULAR OT (125%)</td>
                <td contenteditable="true" id="regular_ot">0</td>
                <td contenteditable="true" id="regular_ot_amount">0</td>
            </tr>
            <tr>
                <td id="rest_day_type">REST DAY PAY (130%)</td>
                <td contenteditable="true" id="rest_day">0</td>
                <td contenteditable="true" id="rest_day_amount">0</td>
            </tr>
            <tr>
                <td id="rd_ot_type">RD OT PAY (169%)</td>
                <td contenteditable="true" id="rd_ot">0</td>
                <td contenteditable="true" id="rd_ot_amount">0</td>
            </tr>
            <tr>
                <td id="snwh_type">SNWH PAY (30%)</td>
                <td contenteditable="true" id="snwh">0</td>
                <td contenteditable="true" id="snwh_amount">0</td>
            </tr>
            <tr>
                <td id="snwh_ot_type">SNWH OT PAY (69%)</td>
                <td contenteditable="true" id="snwh_ot">0</td>
                <td contenteditable="true" id="snwh_ot_amount">0</td>
            </tr>
            <tr>
                <td id="sl_with_pay_type">SL WITH PAY</td>
                <td contenteditable="true" id="sl_with_pay">0</td>
                <td contenteditable="true" id="sl_with_pay_amount">0</td>
            </tr>
            <tr>
                <td id="vl_with_pay_type">VL WITH PAY</td>
                <td contenteditable="true" id="vl_with_pay">0</td>
                <td contenteditable="true" id="vl_with_pay_amount">0</td>
            </tr>
            <tr>
                <td id="vl_conversion_type">VL CONVERSION</td>
                <td contenteditable="true" id="vl_conversion">0</td>
                <td contenteditable="true" id="vl_conversion_amount">0</td>
            </tr>
            <tr>
                <td id="regular_hp_type">REGULAR HP</td>
                <td contenteditable="true" id="regular_hp">0</td>
                <td contenteditable="true" id="regular_hp_amount">0</td>
            </tr>
            <tr>
                <td id="legal_double_type">LEGAL HP/DOUBLE PAY</td>
                <td contenteditable="true" id="legal_double">0</td>
                <td contenteditable="true" id="legal_double_amount">0</td>
            </tr>
            <tr>
                <td id="night_diff_type">NIGHT DIFF (125%)</td>
                <td contenteditable="true" id="night_diff">0</td>
                <td contenteditable="true" id="night_diff_amount">0</td>
            </tr>
            <tr>
                <td id="rh_ot_type">RH OT PAY</td>
                <td contenteditable="true" id="rh_ot">0</td>
                <td contenteditable="true" id="rh_ot_amount">0</td>
            </tr>
            </tbody>
        </table>
        <table class="table ot_holiday_rest_day">
            <thead>
            <tr class="table-success">
                <th scope="col">TOTAL AMOUNT ₱</th>
                <th></th>
                <th scope="col" id="ot_holiday_rest_day_amount">0</th>
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
            $res = mysqli_query($conn, "SELECT * FROM employee_edl INNER JOIN edl_adjustment ON edl_adjustment.id = employee_edl.edl_id WHERE employee_id = {$employee['id']} AND type = 'DEBIT'");
            while ($row = mysqli_fetch_assoc($res)):
                ?>
                <tr>
                    <td><?= $row['description'] ?></td>
                    <td contenteditable="true"><?= $row['amount'] ?></td>
                </tr>
            <?php
            endwhile;
            ?>
            </tbody>
        </table>
        <table class="table">
            <tr class="table-success">
                <td>
                    <b>TOTAL AMOUNT <b>₱</b></b>
                </td>
                <td id="totalDebit"></td>
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
            $res = mysqli_query($conn, "SELECT * FROM employee_edl INNER JOIN edl_adjustment ON edl_adjustment.id = employee_edl.edl_id WHERE employee_id = {$employee['id']} AND type = 'CREDIT'");
            while ($row = mysqli_fetch_assoc($res)):
                ?>
                <tr>
                    <td><?= $row['description'] ?></td>
                    <td contenteditable="true"><?= $row['amount'] ?></td>
                </tr>
            <?php
            endwhile;
            ?>
            </tbody>
        </table>
        <table class="table">
            <tr class="table-danger">
                <td>
                    <b>TOTAL AMOUNT <b>₱</b></b>
                </td>
                <td id="totalCredit"></td>
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
                <td id="absentDays" contenteditable="true"><?= $totalAbsent ?></td>
                <td id="absentAmount" style="font-weight: bold" contenteditable="true">0</td>
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
                <td id="tardinessMinutes" contenteditable="true"><?= $totalTardiness ?></td>
                <td id="tardinessAmount" style="font-weight: bold" contenteditable="true">0</td>
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
                <td id="grossPay"></td>
            </tr>
            <tr>
                <td>Total Deductions & Loans <b>₱</b></td>
                <td id="totalLoansAndDeductions"></td>
            </tr>
            <tr>
                <td>Net Pay <b>₱</b></td>
                <td id="netPay"></td>
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