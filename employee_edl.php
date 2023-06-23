<?php
include_once __DIR__."/config/database.php";

if (isset($_POST['save'])):
    $employee = unserialize(base64_decode($_GET['employee']));
    $amount = $_POST['amount'];
    $edl_id = $_POST['edl_id'];
    $employee_id = $employee['id'];

    ECHO $query = "INSERT INTO employee_edl (`amount`, `edl_id`, `employee_id`) VALUES ('{$amount}', '{$edl_id}', '{$employee_id}')";
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
                <h4>Employee EDL</h4>
            </div>
        </div>

        <br>
        <?php if (isset($_GET['edl']) && isset($_GET['employee']) && $_GET['edl'] == true && $_GET['employee'] != ""): ?>
            <?php
            $employee = unserialize(base64_decode($_GET['employee']));
            $query = "SELECT * FROM employee_edl INNER JOIN edl_adjustment ON edl_adjustment.id =employee_edl.edl_id WHERE employee_id = '{$employee['id']}'";
            $res = mysqli_query($conn, $query);
            $row = mysqli_fetch_all($res);
            $records = $row;
//                print_r($records);
            ?>
            <!-- Earnings -->
            <!-- Earnings -->
            <!-- Earnings -->
            <div style=" display:flex; justify-content: space-between; background-color: #1a8656; padding: 1em; color: white;">
                <b>EARNINGS</b>
                <button class="btn btn-light btn-sm" onclick="toggleModule('earningsModal')">Add Earning</button>
            </div>
            <table class="table">
                <thead>
                <tr class="table-success">
                    <th>#</th>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Amount ₱</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($records as $key => $value):
                    if ($value['7'] != "EARNING")
                        continue;
                    ?>
                    <tr>
                        <td><?= $value['0'] ?></td>
                        <td><?= $value['5'] ?></td>
                        <td><?= $value['6'] ?></td>
                        <td><?= $value['1'] ?></td>
                        <td>
                            <button class="btn btn-primary btn-sm">Edit</button>
                            <button class="btn btn-danger btn-sm">Remove</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <br>
            <hr>
            <!-- Deduction -->
            <!-- Deduction -->
            <!-- Deduction -->
            <div style=" display:flex; justify-content: space-between; background-color: #2177fa; padding: 1em; color: white;">
                <b>DEDUCTIONS</b>
                <button class="btn btn-light btn-sm" onclick="toggleModule('deductionModal')">Add Deduction</button>
            </div>
            <table class="table">
                <thead>
                <tr class="table-primary">
                    <th>#</th>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Amount ₱</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($records as $key => $value):
                    if ($value['7'] != "DEDUCTION")
                        continue;
                    ?>
                    <tr>
                        <td><?= $value['0'] ?></td>
                        <td><?= $value['5'] ?></td>
                        <td><?= $value['6'] ?></td>
                        <td><?= $value['1'] ?></td>
                        <td>
                            <button class="btn btn-primary btn-sm">Edit</button>
                            <button class="btn btn-danger btn-sm">Remove</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>


            <br>
            <hr>
            <!-- Loan -->
            <!-- Loan -->
            <!-- Loan -->
            <div style=" display:flex; justify-content: space-between; background-color: #fa3855; padding: 1em; color: white;">
                <b>LOANS</b>
                <button class="btn btn-light btn-sm" onclick="toggleModule('loanModal')">Add Loan</button>
            </div>
            <table class="table">
                <thead>
                <tr class="table-danger">
                    <th>#</th>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Amount ₱</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                <?php
                foreach ($records as $key => $value):
                    if ($value['7'] != "LOAN")
                        continue;
                    ?>
                    <tr>
                        <td><?= $value['0'] ?></td>
                        <td><?= $value['5'] ?></td>
                        <td><?= $value['6'] ?></td>
                        <td><?= $value['1'] ?></td>
                        <td>
                            <button class="btn btn-primary btn-sm">Edit</button>
                            <button class="btn btn-danger btn-sm">Remove</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

        <?php else: ?>
            <!-- EMPLOYEES -->
            <!-- EMPLOYEES -->
            <!-- EMPLOYEES -->
            <div style="background-color: #1a8656; padding: 1em; color: white;">
                <b>Employees</b>
            </div>
            <table class="table">
                <thead>
                <tr class="table-success">
                    <th scope="col">#</th>
                    <th scope="col">Lastname</th>
                    <th scope="col">Firstname</th>
                    <th scope="col">Middlename</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $query = "SELECT * FROM employees WHERE is_active = 1 ORDER BY lastname ASC";
                $res = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($res)):
                    $serialize = serialize($row);
                    ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['lastname'] ?></td>
                        <td><?= $row['firstname'] ?></td>
                        <td><?= $row['middlename'] ?></td>
                        <td>
                            <a href="?edl=true&employee=<?= base64_encode($serialize) ?>"
                               class="btn btn-primary btn-sm">
                                View
                            </a>
                        </td>
                    </tr>
                <?php
                endwhile;
                ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>


<!--- MODAL --->
<!--- MODAL --->
<!--- MODAL --->

<?php
$query = "SELECT * FROM edl_adjustment ORDER BY description ASC";
$res = mysqli_query($conn, $query);
$row = mysqli_fetch_all($res);
$records = $row;
?>

<!--- EARNINGS --->
<!--- EARNINGS --->
<!--- EARNINGS --->
<div class="earningsModal" style="
position: fixed;
top:0px;
left: 0px;
width: 100%;
height: 100%;
padding: 1em;
display:none;
background-color: rgba(0,0,0,0.5); ">
    <div style="width: 50%; margin: 0 auto; background-color: white; padding: 1em;">
        <h5>Add Earning</h5>
        <hr>
        <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Earning</label>
                <select class="form-select  mb-3" name="edl_id" aria-label=".form-select-lg example">
                    <?php
                    foreach ($records as $key => $value):
                        if ($value['3'] == "EARNING"):
                            ?>
                            <option value="<?= $value['0'] ?>"><?= $value['2'] ?></option>
                        <?php
                        endif;
                    endforeach;
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Amount</label>
                <input type="number" name="amount" class="form-control" id="exampleFormControlInput1"
                       placeholder="Amount" value="0.00" step="0.01" min="0"required>
            </div>
            <div style="display: flex; justify-content: end;">
                <button type="button" class="btn btn-danger" onclick="toggleModule('earningsModal')">Close</button>
                &nbsp;
                <button type="submit" class="btn btn-primary" name="save">Save</button>

            </div>
        </form>
    </div>
</div>

<!--- DEDUCTIONS --->
<!--- DEDUCTIONS --->
<!--- DEDUCTIONS --->
<div class="deductionModal" style="
position: fixed;
top:0px;
left: 0px;
width: 100%;
height: 100%;
padding: 1em;
display:none;
background-color: rgba(0,0,0,0.5); ">
    <div style="width: 50%; margin: 0 auto; background-color: white; padding: 1em;">
        <h5>Add Deduction</h5>
        <hr>
        <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Earning</label>
                <select class="form-select  mb-3" name="edl_id" aria-label=".form-select-lg example">
                    <?php
                    foreach ($records as $key => $value):
                        if ($value['3'] == "DEDUCTION"):
                            ?>
                            <option value="<?= $value['0'] ?>"><?= $value['2'] ?></option>
                        <?php
                        endif;
                    endforeach;
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Amount</label>
                <input type="number" name="amount" class="form-control" id="exampleFormControlInput1"
                       placeholder="Amount" value="0.00" step="0.01" min="0"required>
            </div>
            <div style="display: flex; justify-content: end;">
                <button type="button" class="btn btn-danger" onclick="toggleModule('deductionModal')">Close</button>
                &nbsp;
                <button type="submit" class="btn btn-primary" name="save">Save</button>

            </div>
        </form>
    </div>
</div>

<!--- LOANS --->
<!--- LOANS --->
<!--- LOANS --->
<div class="loanModal" style="
position: fixed;
top:0px;
left: 0px;
width: 100%;
height: 100%;
padding: 1em;
display:none;
background-color: rgba(0,0,0,0.5); ">
    <div style="width: 50%; margin: 0 auto; background-color: white; padding: 1em;">
        <h5>Add Loan</h5>
        <hr>
        <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Earning</label>
                <select class="form-select  mb-3" name="edl_id" aria-label=".form-select-lg example">
                    <?php
                    foreach ($records as $key => $value):
                        if ($value['3'] == "LOAN"):
                            ?>
                            <option value="<?= $value['0'] ?>"><?= $value['2'] ?></option>
                        <?php
                        endif;
                    endforeach;
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Amount</label>
                <input type="number" name="amount" class="form-control" id="exampleFormControlInput1"
                       placeholder="Amount" value="0.00" step="0.01" min="0"required>
            </div>
            <div style="display: flex; justify-content: end;">
                <button type="button" class="btn btn-danger" onclick="toggleModule('loanModal')">Close</button>
                &nbsp;
                <button type="submit" class="btn btn-primary" name="save">Save</button>

            </div>
        </form>
    </div>
</div>


<script>
    function toggleModule(className) {
        $("." + className).toggle();
    }
</script>
</body>
</html>