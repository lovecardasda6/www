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
                <h4>Social Security System (SSS)</h4>
            </div>
            <div style="color: white;">
                <a href="payslip.php">
                    <button class="btn btn-light btn-sm">New Payslip</button>
                </a>
            </div>
        </div>
        <hr/>


        <!-- EMPLOYEES -->
        <!-- EMPLOYEES -->
        <!-- EMPLOYEES -->
        <table class="table">
            <thead>
            <tr class=" table-success">
                <th scope="col">From</th>
                <th scope="col">To</th>
                <th scope="col">EE</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>