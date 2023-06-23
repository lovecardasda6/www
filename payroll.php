<?php
include_once __DIR__ . "/config/database.php";

if (isset($_POST['save'])):
    $code = $_POST['code'];
    $description = $_POST['description'];
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];

    $query = "INSERT INTO PAYROLLS (`code`, `description`, `from_date`, `to_date`) VALUES ('{$code}', '{$description}', '{$from_date}', '{$to_date}')";
    $res = mysqli_query($conn, $query);
endif;

if (isset($_POST['post_payroll'])):
    $payroll_id = $_POST['payroll_id'];
    $res = mysqli_query($conn, "UPDATE payrolls SET is_posted = 1 WHERE id ='{$payroll_id}'");
endif;

if (isset($_POST['unpost_payroll'])):
    $payroll_id = $_POST['payroll_id'];
    $res = mysqli_query($conn, "UPDATE payrolls SET is_posted = 0 WHERE id ='{$payroll_id}'");
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
                <h4>Payroll</h4>
            </div>
            <div>
                <button class="btn btn-light btn-sm" onclick="toggleModule('addPayrollModule')">&nbsp; New Payroll
                    &nbsp;
                </button>
            </div>
        </div>
        <br>

        <table class="table">
            <thead>
            <tr class="table-dark">
                <th scope="col">#</th>
                <th scope="col">Code</th>
                <th scope="col">Description</th>
                <th scope="col">From</th>
                <th scope="col">To</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody class="table-group-divider">
            <?php
            $query = mysqli_query($conn, "SELECT * FROM PAYROLLS ORDER BY id DESC");
            while ($row = mysqli_fetch_assoc($query)):
                ?>
                <tr>
                    <th scope="row">
                        <?php if ($row['is_posted'] == 1): ?>
                            <span class="badge bg-success">POSTED</span></h6>
                        <?php elseif ($row['is_posted'] == 0): ?>
                            <span class="badge bg-warning">UNPOSTED</span></h6>
                        <?php endif; ?>
                    </th>
                    <td><?= $row['code'] ?></td>
                    <td><?= $row['description'] ?></td>
                    <td><?= $row['from_date'] ?></td>
                    <td><?= $row['to_date'] ?></td>
                    <td style="display: flex; justify-content: end">
                        <button class="btn btn-primary btn-sm">Edit</button> &nbsp;
                        <button class="btn btn-danger btn-sm">Remove</button> &nbsp;

                        <?php if ($row['is_posted'] == 1): ?>
                            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                                <input type="hidden" name="payroll_id" value="<?= $row['id'] ?>">
                                <button class="btn btn-warning btn-sm" name="unpost_payroll" type="submit">UnPost
                                    Payroll
                                </button>
                            </form> &nbsp;
                        <?php elseif ($row['is_posted'] == 0): ?>
                            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                                <input type="hidden" name="payroll_id" value="<?= $row['id'] ?>">
                                <button class="btn btn-success btn-sm" name="post_payroll" type="submit">Post Payroll
                                </button>
                            </form> &nbsp;
                        <?php endif; ?>


                        <button class="btn btn-info btn-sm"
                            <?php if ($row['is_posted'] == 0): ?>
                                disabled="disabled"
                            <?php endif; ?>
                        ><a href="print_payslips.php?payroll_id=<?= $row['id'] ?>"
                            style="text-decoration: none; color: white;"
                            target="_blank">Print Payslips</a></button> &nbsp;

                        <button class="btn btn-dark btn-sm">
                            <a href="payroll_register.php?payroll_id=<?= $row['id'] ?>"
                                                               style="text-decoration: none; color: white;"
                                                               target="_blank">Print Payroll Register</a>
                        </button>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- MODAL -->

<div class="addPayrollModule"
     style="position:absolute; top:0; left:0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); padding: 1em; ">
    <div style="width: 45%; margin: 0 auto; padding:1em; background-color: white;">
        <h5>Add Payroll</h5>
        <hr>
        <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Code</label>
                <input type="text" name="code" class="form-control" id="exampleFormControlInput1" placeholder="Code">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Description</label>
                <input type="text" name="description" class="form-control" id="exampleFormControlInput1"
                       placeholder="Description">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">From Date</label>
                <input type="date" name="from_date" class="form-control" id="exampleFormControlInput1"
                       placeholder="From Date">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">To Date</label>
                <input type="date" name="to_date" class="form-control" id="exampleFormControlInput1"
                       placeholder="To Date">
            </div>
            <div style="display: flex; justify-content: end;">
                <button type="button" class="btn btn-danger" onclick="toggleModule('addPayrollModule')">Close</button>
                &nbsp;
                <button type="submit" class="btn btn-primary" name="save">Save Payroll</button>

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