<?php
include_once __DIR__."/config/database.php";

if(isset($_POST['save'])):
    $description = $_POST['description'];
    $date = $_POST['date'];

    $query = "INSERT INTO CALENDARS (`description`, `date_of`) VALUES ('{$description}', '{$date}')";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <style>
        .container{
            margin: 0 auto;
            width: 75%;
        }
        .content{
            padding: 1em;
            clear: both;
        }
        .control{
            padding: 1em 0px;
            float:right;
        }
        .control > button{
            background-color: #0066ff;
            padding: 1em;
            color: white;
        }
        .module{
            display: none;
        }
    </style>
</head>
<body>
<?php include_once __DIR__.'/menu.php'; ?>


<div class="container">
    <div class="content">



        <div style="display: flex; justify-content: space-between;background-color: #373b3e; padding: .7em;">
            <div style="color: white;">
                <h4>Calendar</h4>
            </div>
            <div>
                <button class="btn btn-light btn-sm" onclick="toggleModule('addCalendarModule')">
                    &nbsp;New Holiday
                </button>
            </div>
        </div>
        <br>


        <table class="table">
            <thead>
            <tr class="table-dark">
                <th scope="col">#</th>
                <th scope="col">Description</th>
                <th scope="col">Date</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody class="table-group-divider">
            <?php
            $query = mysqli_query($conn, "SELECT * FROM CALENDARS ORDER BY date_of ASC");
            while($row=mysqli_fetch_assoc($query)):
                ?>
                <tr>
                    <th scope="row">1</th>
                    <td><?= $row['description'] ?></td>
                    <td><?php echo date_format(date_create($row['date_of']), "F d, Y - D") ?></td>
                    <td>
                        <button class="btn btn-primary">Edit</button>
                        <button class="btn btn-danger">Remove</button>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- MODAL -->

<div class="module addCalendarModule" style="position:absolute; top:0; left:0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); padding: 1em; ">
    <div style="width: 45%; margin: 0 auto; padding:1em; background-color: white;">
        <h5>Add Holiday</h5>
        <hr>
        <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Description</label>
                <input type="text" name="description"  class="form-control" id="exampleFormControlInput1" placeholder="Description">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Date</label>
                <input type="date" name="date"  class="form-control" id="exampleFormControlInput1" placeholder="Date">
            </div>
            <div style="display: flex; justify-content: end;">
                <button type="button" class="btn btn-danger" onclick="toggleModule('addCalendarModule')">Close</button>
                &nbsp;
                <button type="submit" class="btn btn-primary" name="save">Save Payroll</button>

            </div>
        </form>
    </div>
</div>

<script>
    function toggleModule(className){
        $("."+className).toggle();
    }
</script>
</body>
</html>