$(document).ready(function () {

    calculateEarnings();
    calculateDeductions();
    calculateLoans();

    let ratePerDay = (monthly_salary * 12 / 313);
    let ratePerHour = ((monthly_salary * 12 / 313) / 8) / 60;


    let absentDays = Number($("#absentDays").text());
    let absentAmount = Number(absentDays * ratePerDay).toFixed(2);
    $("#absentAmount").text(absentAmount);

    let tardinessMinute = $("#tardinessMinutes").text();
    let tardinessAmount = Number(tardinessMinute * ratePerHour).toFixed(2);
    $("#tardinessAmount").text(tardinessAmount);


});

function calculateEarnings() {

    let ratePerHour = (monthly_salary * 12 / 313) / 8;
    let totalEarnings = 0;


    let absent = Number($("#absentDays").text());
    let tardiness = Number($("#tardinessMinutes").text());

    let totalBasicPay = monthly_salary / 2;

    // if (absent == 0 || tardiness == 0) {
    //     totalBasicPay = monthly_salary / 2;
    // } else {
    //     totalBasicPay = $("#totalBasicPay").text();
    // };

    let absentAmount = (ratePerHour * 8) * absent;
    let tardinessAmount = (ratePerHour / 60) * tardiness;

    $("#absentAmount").text(absentAmount.toFixed(2));
    $("#tardinessAmount").text(tardinessAmount.toFixed(2));

    let totalAbsentWithTardinessAmount = absentAmount + tardinessAmount;

    let basicPay = Number(totalBasicPay) - Number(totalAbsentWithTardinessAmount);
    $("#totalBasicPay").text(basicPay.toFixed(2));

    $(".earnings > tbody > tr").each(function () {
        totalEarnings += Number($(this).find('td').eq(1).text());
    });

    $("#totalEarnings").html((totalEarnings).toFixed(2));


}

function calculateDeductions() {
    let totalDeductions = 0;
    $(".deductions > tbody > tr").each(function () {
        totalDeductions += Number($(this).find('td').eq(1).text());
    });
    $("#totalDeductions").html((totalDeductions).toFixed(2));
}

function calculateLoans() {
    let totalLoans = 0;
    $(".loans > tbody > tr").each(function () {
        totalLoans += Number($(this).find('td').eq(1).text());
    });
    $("#totalLoans").html((totalLoans).toFixed(2));

}

function calculateGrossPay() {
    let totalEarnings = Number($("#totalEarnings").text());
    let totalDebit = Number($("#totalDebit").text());
    let ot_holiday_rest_day_amount = Number($("#ot_holiday_rest_day_amount").text());

    let grossPay = totalEarnings + totalDebit + ot_holiday_rest_day_amount;

    $("#grossPay").text((grossPay).toFixed(2));
    //
    // console.log("totalDebit: " + totalDebit);
    // console.log("totalGross: " + grossPay);
}

function calculateTotalDeductionsAndLoans() {
    let totalDeductions = Number($("#totalDeductions").text());
    let totalLoans = Number($("#totalLoans").html());

    $("#totalLoansAndDeductions").text((totalDeductions + totalLoans).toFixed(2));
}

function calculateNetPay(totalDebit, totalCredit) {

    let totalEarnings = Number($("#totalEarnings").text());
    let totalDeductions = Number($("#totalDeductions").text());
    let totalLoans = Number($("#totalLoans").text());
    let ot_holiday_rest_day_amount = Number($("#ot_holiday_rest_day_amount").text())

    let netPay = (totalEarnings + ot_holiday_rest_day_amount + totalDebit) - (totalDeductions + totalLoans + totalCredit);

    $("#netPay").text((netPay).toFixed(2));

}

function computePayroll() {


    let totalDebit = 0;
    $(".debit > tbody > tr").each(function () {
        totalDebit += Number($(this).find('td').eq(1).text());
    });
    $("#totalDebit").html((totalDebit).toFixed(2));

    let totalCredit = 0;
    $(".credit > tbody > tr").each(function () {
        totalCredit += Number($(this).find('td').eq(1).text());
    });
    $("#totalCredit").html((totalCredit).toFixed(2));

    calculateEarnings();
    calculateDeductions();
    calculateLoans();
    calculateOT();

    calculateGrossPay();
    calculateTotalDeductionsAndLoans();


    // let ratePerHour = (monthly_salary * 12 / 313) / 8;
    //
    // let absent = (ratePerHour * 8) * Number($("#absentDays").text());
    // let tardiness = (ratePerHour / 60) * Number($("#tardinessMinutes").text());
    //
    // $("#absentAmount").text(absent.toFixed(2));
    // $("#tardinessAmount").text(tardiness.toFixed(2));
    //
    // let totalAbsentWithTardinessAmount = absent + tardiness;
    calculateNetPay(totalDebit, totalCredit);


}

function calculateOT() {

    let ratePerHour = (monthly_salary * 12 / 313) / 8;


    let regular_ot_amount = 0;
    let rest_day_amount = 0;
    let rd_ot_amount = 0;
    let snwh_amount = 0;
    let snwh_ot_amount = 0;
    let sl_with_amount = 0;
    let vl_with_pay_amount = 0;
    let vl_conversion_amount = 0;
    let regular_hp_amount = 0;
    let legal_double_amount = 0;
    let rh_ot_amount = 0;
    let night_diff_amount = 0;

    let regular_ot = Number($("#regular_ot").text());
    if (regular_ot > 0) {
        regular_ot_amount = (ratePerHour * regular_ot) * 1.25;
    }

    let rest_day = $("#rest_day").text();
    if (rest_day > 0) {
        rest_day_amount = (ratePerHour * rest_day) * 1.30;
    }

    let rd_ot = $("#rd_ot").text();
    if (rd_ot > 0) {
        rd_ot_amount = (ratePerHour * rd_ot) * 1.69;
    }

    let snwh = $("#snwh").text();
    if (snwh > 0) {
        snwh_amount = (ratePerHour * snwh) * 0.30;
    }

    let snwh_ot = $("#snwh_ot").text();
    if (snwh_ot > 0) {
        snwh_ot_amount = (ratePerHour * snwh_ot) * 0.69;
    }

    let sl_with_pay = $("#sl_with_pay").text();
    if (sl_with_pay > 0) {
        sl_with_amount = ratePerHour * sl_with_pay;
    }

    let vl_with_pay = $("#vl_with_pay").text();

    if (vl_with_pay > 0) {
        vl_with_pay_amount = ratePerHour * vl_with_pay;
    }

    let vl_conversion = $("#vl_conversion").text();
    if (vl_conversion > 0) {
        vl_conversion_amount = ratePerHour * vl_conversion;
    }

    let regular_hp = $("#regular_hp").text();
    if (regular_hp > 0) {
        regular_hp_amount = ratePerHour * regular_hp;
    }

    let legal_double = $("#legal_double").text();
    if (legal_double > 0) {
        legal_double_amount = (ratePerHour * legal_double) * 2;
    }

    let night_diff = $("#night_diff").text();
    if (night_diff > 0) {
        night_diff_amount = (ratePerHour * 1.35) * night_diff;
    }


    let rh_ot = $("#rh_ot").text();
    if (rh_ot > 0) {
        rh_ot_amount = (ratePerHour * rh_ot) * 1.30;
    }


    let ot_holiday_rest_day_amount = Number(regular_ot_amount) +
        Number(rest_day_amount) +
        Number(rd_ot_amount) +
        Number(snwh_amount) +
        Number(snwh_ot_amount) +
        Number(sl_with_amount) +
        Number(vl_with_pay_amount) +
        Number(vl_conversion_amount) + Number(regular_hp_amount) +
        Number(legal_double_amount) +
        Number(night_diff_amount) + Number(rh_ot_amount);


    $("#regular_ot_amount").text(regular_ot_amount.toFixed(2));
    $("#rest_day_amount").text(rest_day_amount.toFixed(2));
    $("#rd_ot_amount").text(rd_ot_amount.toFixed(2));
    $("#snwh_amount").text(snwh_amount.toFixed(2));
    $("#snwh_ot_amount").text(snwh_ot_amount.toFixed(2));
    $("#sl_with_amount").text(sl_with_amount.toFixed(2));
    $("#vl_with_pay_amount").text(vl_with_pay_amount.toFixed(2));
    $("#vl_conversion_amount").text(vl_conversion_amount.toFixed(2));
    $("#regular_hp_amount").text(regular_hp_amount.toFixed(2));
    $("#legal_double_amount").text(legal_double_amount.toFixed(2));
    $("#night_diff_amount").text(night_diff_amount.toFixed(2));
    $("#rh_ot_amount").text(rh_ot_amount.toFixed(2));

    $("#ot_holiday_rest_day_amount").text(ot_holiday_rest_day_amount.toFixed(2));
}

function savePaySlip() {

    computePayroll();

    let earnings = [];
    let totalEarnings = 0;

    let deductions = [];
    let totalDeductions = 0;

    let loans = [];
    let totalLoans = 0;

    let ot_holiday_restday = [];
    let total_ot_holiday_restday = 0

    let debit = [];
    let totalDebit = 0;

    let credit = [];
    let totalCredit = 0;

    $(".earnings > tbody > tr").each(function () {
        earnings.push({
            "type": "EARNING",
            "name": $(this).find('td').eq(0).text(),
            "amount": $(this).find('td').eq(1).text()
        });
        totalEarnings += Number($(this).find('td').eq(1).text());
    });

    $(".deductions > tbody > tr").each(function () {
        deductions.push({
            "type": "DEDUCTION",
            "name": $(this).find('td').eq(0).text(),
            "amount": $(this).find('td').eq(1).text()
        });
        totalDeductions += Number($(this).find('td').eq(1).text());
    });

    $(".loans > tbody > tr").each(function () {
        loans.push({
            "type": "LOAN",
            "name": $(this).find('td').eq(0).text(),
            "amount": $(this).find('td').eq(1).text()
        });
        totalLoans += Number($(this).find('td').eq(1).text());
    });

    $(".ot_holiday_rest_day > tbody > tr").each(function () {
        ot_holiday_restday.push({
            "type": $(this).find('td').eq(0).text(),
            "hour": $(this).find('td').eq(1).text(),
            "amount": $(this).find('td').eq(2).text()
        });
        total_ot_holiday_restday += Number($(this).find('td').eq(2).text());
    });

    $(".debit > tbody > tr").each(function () {
        debit.push({
            "type": "DEBIT",
            "name": $(this).find('td').eq(0).text(),
            "amount": $(this).find('td').eq(1).text()
        });
        totalDebit += Number($(this).find('td').eq(1).text());
    });

    $(".credit > tbody > tr").each(function () {
        credit.push({
            "type": "CREDIT",
            "name": $(this).find('td').eq(0).text(),
            "amount": $(this).find('td').eq(1).text()
        });
        totalCredit += Number($(this).find('td').eq(1).text());
    });

    totalEarnings = totalEarnings.toFixed(2);
    totalDeductions = totalDeductions.toFixed(2);
    totalLoans = totalLoans.toFixed(2);
    total_ot_holiday_restday = total_ot_holiday_restday.toFixed(2);
    totalDebit = totalDebit.toFixed(2);
    totalCredit = totalCredit.toFixed(2);


    let transactions = {
        "earning_total": totalEarnings,
        "deduction_total": totalDeductions,
        "loan_total": totalLoans,
        "ot_holiday_restday_total": total_ot_holiday_restday,
        "debit_total": totalDebit,
        "credit_total": totalCredit,
        "absent": $("#absentDays").text(),
        "absent_amount": $("#absentAmount").text(),
        "tardiness": $("#tardinessMinutes").text(),
        "tardiness_amount": $("#tardinessAmount").text(),
        "gross_pay": $("#grossPay").text(),
        "total_deduction_and_loans": $("#totalLoansAndDeductions").text(),
        "net_pay": $("#netPay").text()
    };


    let content = {
        "payroll_id": payroll_id,
        "employee_id": employee_id,
        "earnings": earnings,
        "deductions": deductions,
        "loans": loans,
        "ot_holiday_restday": ot_holiday_restday,
        "debit": debit,
        "credit": credit,
        "transactions": transactions
    };

    $.ajax({
        type: "POST",
        url: "/services/payslip.php",
        data: JSON.stringify(content),
        success: function (response) {
            console.log(response)
        },
        error: function (response) {
            alert("Please click compute first before saving.");
        }

    });
}
