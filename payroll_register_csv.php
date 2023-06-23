<?php

include_once __DIR__ . "/config/database.php";

// Start the output buffer.
ob_start();

// Set PHP headers for CSV output.
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=csv_export.csv');


$payroll_id = 1;

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


$earning_sorted_list = [];
$deduction_sorted_list = [];
$ot_holiday_restday_sorted_list = [];
$loan_sorted_list = [];
$debit_sorted_list = [];
$credit_sorted_list = [];


$csv_headers = ["Employees"];
$csv_content = [];

foreach ($edl_adjs as $earning):
    if ($earning[1] == "EARNING"):
        array_push($earning_sorted_list, $earning[0]);
        array_push($csv_headers, $earning[0]);
    endif;
endforeach;

foreach ($edl_adjs as $debit):
    if ($debit[1] == "DEBIT"):
        array_push($debit_sorted_list, $debit[0]);
        array_push($csv_headers, $debit[0]);
    endif;
endforeach;

foreach ($ot_hol_rest as $ot_hol_res):
    array_push($ot_holiday_restday_sorted_list, $ot_hol_res[0]);
    array_push($csv_headers, $ot_hol_res[0]);
endforeach;

array_push($csv_headers, "Gross Pay");

foreach ($edl_adjs as $deduction):
    if ($deduction[1] == "DEDUCTION"):
        array_push($deduction_sorted_list, $deduction[0]);
        array_push($csv_headers, $deduction[0]);
    endif;
endforeach;

foreach ($edl_adjs as $loan):
    if ($loan[1] == "LOAN"):
        array_push($loan_sorted_list, $loan[0]);
        array_push($csv_headers, $loan[0]);
    endif;
endforeach;

array_push($csv_headers, "TOTAL DEDUCTION & LOAN");


foreach ($edl_adjs as $credit):
    if ($credit[1] == "CREDIT"):
        array_push($credit_sorted_list, $credit[0]);
        array_push($csv_headers, $credit[0]);
    endif;
endforeach;

array_push($csv_headers, "Net Pay");


///////////////////////////////////////////////////////////
/////////////////////CSV CONTENT///////////////////////////
///////////////////////////////////////////////////////////
///
///////////////////////////////////////////////////////////


$employees_query = "SELECT lastname, firstname, middlename, payroll_transactions.*, payroll_transactions.id as payroll_transaction_id  FROM employees 
                INNER JOIN payroll_transactions ON employees.id = payroll_transactions.employee_id
                WHERE payroll_id = '{$payroll_id}' ORDER BY lastname ASC";
$employees_res = mysqli_query($conn, $employees_query);
while ($employee = mysqli_fetch_assoc($employees_res)):

    $payroll_transaction_id = $employee['payroll_transaction_id'];

    $emp = "{$employee['lastname']}, {$employee['firstname']} {$employee['middlename']}";
    $employee_payslip = [$emp];

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
                    array_push($employee_payslip, $earning[4]);
                    $is_found = true;
                    break;
                endif;
            }
        endforeach;
        //if specific type of earning not registered for current employee
        //display amount 0.00
        if (!$is_found):
            array_push($employee_payslip, 0);
        endif;
    endforeach;


    //DEBIT
    foreach ($debit_sorted_list as $debit_item):
        $is_found = false;
        foreach ($edl_adjs as $debit):
            if ($debit[2] == "DEBIT") {
                if ($debit[3] == $debit_item):
                    array_push($employee_payslip, $debit[4]);
                    $is_found = true;
                    break;
                endif;
            }
        endforeach;
        //if specific type of earning not registered for current employee
        //display amount 0.00
        if (!$is_found):
            array_push($employee_payslip, 0);
        endif;
    endforeach;


    //OT HOLIDAY REST DAY
    foreach ($ot_holiday_restday_sorted_list as $ot_hol_rest_item):
        $is_found = false;
        foreach ($ot_hol_res as $val):
            if ($val[2] == $ot_hol_rest_item):
                array_push($employee_payslip, $val[4]);
                $is_found = true;
                break;
            endif;
        endforeach;
        //if specific type of earning not registered     for current employee
        //display amount 0.00
        if (!$is_found):
            array_push($employee_payslip, 0);
        endif;
    endforeach;

    array_push($employee_payslip, $employee['gross_pay']);

    foreach ($deduction_sorted_list as $deduction_item):
        $is_found = false;
        foreach ($edl_adjs as $deduction):
            if ($deduction[2] == "DEDUCTION") {
                if ($deduction[3] == $deduction_item):
                    array_push($employee_payslip, $deduction[4]);
                    $is_found = true;
                    break;
                endif;
            }
        endforeach;
        if (!$is_found):
            array_push($employee_payslip, 0);
        endif;
    endforeach;//DEDUCTION

    //LOAN
    foreach ($loan_sorted_list as $loan_item):
        $is_found = false;
        foreach ($edl_adjs as $loan):
            if ($loan[2] == "LOAN") {
                if ($loan[3] == $loan_item):
                    array_push($employee_payslip, $loan[4]);
                    $is_found = true;
                    break;
                endif;
            }
        endforeach;
        if (!$is_found):
            array_push($employee_payslip, 0);
        endif;
    endforeach;//LOAN

    array_push($employee_payslip, $employee['total_deduction_and_loans']);

    //CREDIT
    foreach ($credit_sorted_list as $credit_item):
        $is_found = false;
        foreach ($edl_adjs as $credit):
            if ($credit[2] == "CREDIT") {
                if ($credit[3] == $credit_item):
                    array_push($employee_payslip, $credit[4]);
                    $is_found = true;
                    break;
                endif;
            }
        endforeach;
        //if specific type of earning not registered for current employee
        //display amount 0.00
        if (!$is_found):
            array_push($employee_payslip, 0);
        endif;
    endforeach;//CREDIT
    array_push($employee_payslip, $employee['net_pay']);

    array_push($csv_content, $employee_payslip);
endwhile;


ob_end_clean();
$output = fopen('php://output', 'w');
fputcsv($output, $csv_headers);

foreach ($csv_content as $payslip) {
    fputcsv($output, $payslip);
}

fclose($output);
