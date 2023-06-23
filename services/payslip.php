<?php

require_once __DIR__ . "/../config/database.php";

$data = json_decode(file_get_contents('php://input'), true);

$payroll_id = $data['payroll_id'];
$employee_id = $data['employee_id'];
$earnings = $data['earnings'];
$deductions = $data['deductions'];
$loans = $data['loans'];
$ot_holiday_restday = $data['ot_holiday_restday'];
$debits = $data['debit'];
$credits = $data['credit'];
$transactions = $data['transactions'];

$is_posted_query = mysqli_query($conn,"SELECT is_posted FROM payrolls WHERE id = '{$payroll_id}'");
$is_posted_result = mysqli_fetch_assoc($is_posted_query);

if($is_posted_result['is_posted'] == 1){
    echo "Payroll is already posted.";
    return;
}


$transaction_record_query = mysqli_query($conn, "SELECT * FROM payroll_transactions WHERE payroll_id = '{$payroll_id}' AND employee_id = '{$employee_id}'");

$transaction_id = 0;
$is_transact = false;

//if->update else->insert
if (mysqli_num_rows($transaction_record_query) > 0):
    $transaction_record = mysqli_fetch_assoc($transaction_record_query);
    $transaction_id = $transaction_record['id'];

    $transactions_query = mysqli_query($conn, "UPDATE 
                            `payroll_transactions` 
                            SET 
                            `earning_total`='{$transactions['earning_total']}',
                            `deduction_total`='{$transactions['deduction_total']}',
                            `loan_total`='{$transactions['loan_total']}',
                            `ot_holiday_restday_total`='{$transactions['ot_holiday_restday_total']}',
                            `debit_total`='{$transactions['debit_total']}',
                            `credit_total`='{$transactions['credit_total']}',
                            `absent`='{$transactions['absent']}',
                            `absent_amount`='{$transactions['absent_amount']}',
                            `tardiness`='{$transactions['tardiness']}',
                            `tardiness_amount`='{$transactions['tardiness_amount']}',
                            `gross_pay`='{$transactions['gross_pay']}',
                            `total_deduction_and_loans`='{$transactions['total_deduction_and_loans']}',
                            `net_pay`='{$transactions['net_pay']}' 
                            WHERE id = '{$transaction_id}'");

    if ($transactions_query):
        $is_transact = true;
    endif;


else:
    ECHO "INSERT INTO `payroll_transactions` (
                            `payroll_id`, 
                            `employee_id`, 
                            `earning_total`,
                            `deduction_total`, 
                            `loan_total`, 
                            `ot_holiday_restday_total`,
                            `debit_total`, 
                            `credit_total`, 
                            `absent`, 
                            `absent_amount`, 
                            `tardiness`, 
                            `tardiness_amount`, 
                            `gross_pay`, 
                            `total_deduction_and_loans`, 
                            `net_pay`
                        ) VALUES (
                            '{$payroll_id}', 
                            '{$employee_id}', 
                            '{$transactions['earning_total']}', 
                            '{$transactions['deduction_total']}', 
                            '{$transactions['loan_total']}', 
                            '{$transactions['ot_holiday_restday_total']}', 
                            '{$transactions['debit_total']}', 
                            '{$transactions['credit_total']}', 
                            '{$transactions['absent']}', 
                            '{$transactions['absent_amount']}', 
                            '{$transactions['tardiness']}', 
                            '{$transactions['tardiness_amount']}', 
                            '{$transactions['gross_pay']}', 
                            '{$transactions['total_deduction_and_loans']}', 
                            '{$transactions['net_pay']}'
                        )";
    $transactions_query = mysqli_query($conn,"INSERT INTO `payroll_transactions` (
                            `payroll_id`, 
                            `employee_id`, 
                            `earning_total`,
                            `deduction_total`, 
                            `loan_total`, 
                            `ot_holiday_restday_total`,
                            `debit_total`, 
                            `credit_total`, 
                            `absent`, 
                            `absent_amount`, 
                            `tardiness`, 
                            `tardiness_amount`, 
                            `gross_pay`, 
                            `total_deduction_and_loans`, 
                            `net_pay`
                        ) VALUES (
                            '{$payroll_id}', 
                            '{$employee_id}', 
                            '{$transactions['earning_total']}', 
                            '{$transactions['deduction_total']}', 
                            '{$transactions['loan_total']}', 
                            '{$transactions['ot_holiday_restday_total']}', 
                            '{$transactions['debit_total']}', 
                            '{$transactions['credit_total']}', 
                            '{$transactions['absent']}', 
                            '{$transactions['absent_amount']}', 
                            '{$transactions['tardiness']}', 
                            '{$transactions['tardiness_amount']}', 
                            '{$transactions['gross_pay']}', 
                            '{$transactions['total_deduction_and_loans']}', 
                            '{$transactions['net_pay']}'
                        )");

    if ($transactions_query):
        $transaction_id = $conn->insert_id;
        $is_transact = true;
    endif;

endif;

if ($is_transact):

    $empty_edl_adj = mysqli_query($conn, "DELETE FROM payroll_transaction_edl_adj WHERE payroll_transaction_id = '{$transaction_id}'");
    $empty_payroll_transaction_ot_holiday_restday = mysqli_query($conn, "DELETE FROM payroll_transaction_ot_holiday_restday WHERE payroll_transaction_id = '{$transaction_id}'");

    foreach ($earnings as $earning) {
        $q = "INSERT INTO `payroll_transaction_edl_adj`(
        `payroll_transaction_id`, 
        `type`,
        `name`, 
        `amount`
    ) VALUES (
        '{$transaction_id}',
        '{$earning['type']}',
        '{$earning['name']}',
        '{$earning['amount']}'
    )";
        $query = mysqli_query($conn, $q);
    }

    foreach ($deductions as $deduction) {
        $q = "INSERT INTO `payroll_transaction_edl_adj`(
        `payroll_transaction_id`, 
        `type`,
        `name`, 
        `amount`
    ) VALUES (
        '{$transaction_id}',
        '{$deduction['type']}',
        '{$deduction['name']}',
        '{$deduction['amount']}'
    )";
        $query = mysqli_query($conn, $q);
    }

    foreach ($loans as $loan) {
        $q = "INSERT INTO `payroll_transaction_edl_adj`(
        `payroll_transaction_id`, 
        `type`,
        `name`, 
        `amount`
    ) VALUES (
        '{$transaction_id}',
        '{$loan['type']}',
        '{$loan['name']}',
        '{$loan['amount']}'
    )";
        $query = mysqli_query($conn, $q);
    }

    foreach ($debits as $debit) {
        $q = "INSERT INTO `payroll_transaction_edl_adj`(
        `payroll_transaction_id`, 
        `type`,
        `name`, 
        `amount`
    ) VALUES (
        '{$transaction_id}',
        '{$debit['type']}',
        '{$debit['name']}',
        '{$debit['amount']}'
    )";
        $query = mysqli_query($conn, $q);
    }

    foreach ($credits as $credit) {
        $q = "INSERT INTO `payroll_transaction_edl_adj`(
        `payroll_transaction_id`, 
        `type`,
        `name`, 
        `amount`
    ) VALUES (
        '{$transaction_id}',
        '{$credit['type']}',
        '{$credit['name']}',
        '{$credit['amount']}'
    )";
        $query = mysqli_query($conn, $q);
    }

    foreach ($ot_holiday_restday as $value) {
        $q = "INSERT INTO `payroll_transaction_ot_holiday_restday`(
        `payroll_transaction_id`, 
        `type`, 
        `hour`, 
        `amount`
    ) VALUES (
        '{$transaction_id}',
        '{$value['type']}',
        '{$value['hour']}',
        '{$value['amount']}'
    )";
        $query = mysqli_query($conn, $q);
    }

    echo "Payroll transaction successfully save!";

endif;