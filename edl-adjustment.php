<?php
include_once __DIR__."/config/database.php";

if (isset($_POST['save'])):
    $code = $_POST['code'];
    $description = $_POST['description'];
    $type = $_POST['type'];

    $query = "INSERT INTO edl_adjustment (`code`, `description`, `type`) VALUES ('{$code}', '{$description}', '{$type}')";
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
                <h4>EDL / Adjustment</h4>
            </div>
            <div>
                <button class="btn btn-light btn-sm" onclick="toggleModule('addCalendarModule')">&nbsp; New EDL/Adjustment &nbsp;</button>
            </div>
        </div>

        <br>

        <?php
        $query = "SELECT `id`, `code`, `description`, `type` FROM `edl_adjustment` ORDER by description ASC";
        $res = mysqli_query($conn, $query);
        $row = mysqli_fetch_all($res);
        $records = $row;
        ?>

        <!-- Earnings -->
        <!-- Earnings -->
        <!-- Earnings -->
        <div style="background-color: #1a8656; padding: 1em; color: white;">
            <b>EARNINGS</b>
        </div>
        <table class="table">
            <thead>
            <tr class="table-success">
                <th scope="col">#</th>
                <th scope="col">Code</th>
                <th scope="col">Description</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($records as $key => $value):
                if ($value['3'] != "EARNING")
                    continue;
                ?>
                <tr>
                    <td><?= $value['0'] ?></td>
                    <td><?= $value['1'] ?></td>
                    <td><?= $value['2'] ?></td>
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
        <div style="background-color: #2177fa; padding: 1em; color: white;">
            <b>DEDUCTIONS</b>
        </div>
        <table class="table">
            <thead>
            <tr class="table-primary">
                <th scope="col">#</th>
                <th scope="col">Code</th>
                <th scope="col">Description</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($records as $key => $value):
                if ($value['3'] != "DEDUCTION")
                    continue;
                ?>
                <tr>
                    <td><?= $value['0'] ?></td>
                    <td><?= $value['1'] ?></td>
                    <td><?= $value['2'] ?></td>
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
        <div style="background-color: #fa3855; padding: 1em; color: white;">
            <b>LOANS</b>
        </div>
        <table class="table">
            <thead>
            <tr class="table-danger">
                <th scope="col">#</th>
                <th scope="col">Code</th>
                <th scope="col">Description</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            <?php
            foreach ($records as $key => $value):
                if ($value['3'] != "LOAN")
                    continue;
                ?>
                <tr>
                    <td><?= $value['0'] ?></td>
                    <td><?= $value['1'] ?></td>
                    <td><?= $value['2'] ?></td>
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
        <!-- Debit -->
        <!-- Debit -->
        <!-- Debit -->
        <div style="background-color: #1a8656; padding: 1em; color: white;">
            <b>DEBIT ADJUSTMENTS</b>
        </div>
        <table class="table">
            <thead>
            <tr class="table-success">
                <th scope="col">#</th>
                <th scope="col">Code</th>
                <th scope="col">Description</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            <?php
            foreach ($records as $key => $value):
                if ($value['3'] != "DEBIT")
                    continue;
                ?>
                <tr>
                    <td><?= $value['0'] ?></td>
                    <td><?= $value['1'] ?></td>
                    <td><?= $value['2'] ?></td>
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
        <!-- Credit -->
        <!-- Credit -->
        <!-- Credit -->
        <div style="background-color: #fa3855; padding: 1em; color: white;">
            <b>CREDIT ADJUSTMENTS</b>
        </div>
        <table class="table">
            <thead>
            <tr class="table-danger">
                <th scope="col">#</th>
                <th scope="col">Code</th>
                <th scope="col">Description</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            <?php
            foreach ($records as $key => $value):
                if ($value['3'] != "CREDIT")
                    continue;
                ?>
                <tr>
                    <td><?= $value['0'] ?></td>
                    <td><?= $value['1'] ?></td>
                    <td><?= $value['2'] ?></td>
                    <td>
                        <button class="btn btn-primary btn-sm">Edit</button>
                        <button class="btn btn-danger btn-sm">Remove</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- MODAL -->

<div class="module addCalendarModule"
     style="position:absolute; top:0; left:0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); padding: 1em; ">
    <div style="width: 45%; margin: 0 auto; padding:1em; background-color: white;">
        <h5>Add EDL-Adjustment</h5>
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
                <label for="exampleFormControlInput1" class="form-label">EDL - Adj Type</label>
                <select class="form-select  mb-3" name="type" aria-label=".form-select-lg example">
                    <option value="select" selected>Select type</option>
                    <option value="EARNING">Earning</option>
                    <option value="DEDUCTION">Deduction</option>
                    <option value="LOAN">Loan</option>
                    <option value="DEBIT">Debit Adjustment</option>
                    <option value="CREDIT">Credit Adjustment</option>
                </select>
            </div>
            <div style="display: flex; justify-content: end;">
                <button type="button" class="btn btn-danger" onclick="toggleModule('addCalendarModule')">Close</button>
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