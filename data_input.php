<?php
require 'db.php';
$sql = "SELECT * FROM `players`";
$myquery = mysqli_query($conn, $sql);

$res_arr = [];
while ($row = mysqli_fetch_array($myquery)) {
    $res_arr[$row['id']] = $row['name'];
}
if (isset($_POST['btn_save'])) {
    if ($_POST['player1'] == $_POST['player2']) {
        echo "Insert Failed!";
    } else {
        $sql = "
        INSERT INTO `player_matches`(`date`, `player1`, `player2`)
        VALUES('" . $_POST['date'] . "', '" . $_POST['player1'] . "', '" . $_POST['player2'] . "')";
        $myquery = mysqli_query($conn, $sql);
    }
}

$sql2 = "SELECT * FROM `player_matches`";
$myquery2 = mysqli_query($conn, $sql2);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous" />
    <title>Dart Tournament 2022</title>
</head>

<body>

    <div class="container">
        <div class="main mt-4">
            <h1 class="text-center">Dart Tournament 2022</h1>
            <hr>

            <div class="card mt-1">
                <div class="card-header text-center">Match Chart</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <form action="" method="POST">
                                <div class="mb-2">
                                    <label class="">Date</label>
                                    <input type="date" name="date" class="form-control" required>
                                </div>
                                <div class="mb-2">
                                    <label class="">Player 1</label>
                                    <select name="player1" class="form-control" id="" required>
                                        <?php
                                        echo '<option value="">select one</option>';
                                        foreach ($res_arr as $key => $value) {
                                            echo '<option value="' . $key . '">' . $value . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="">Player 2</label>
                                    <select name="player2" class="form-control" id="" required>
                                        <?php
                                        echo '<option value="">select one</option>';
                                        foreach ($res_arr as $key => $value) {
                                            echo '<option value="' . $key . '">' . $value . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <input type="submit" value="Save" name="btn_save" class="btn btn-outline-success">
                                </div>
                            </form>
                        </div>
                        <div class="col">
                            <table class="table table-striped table-hover table-bordered">
                                <thead>
                                    <tr class="table-success">
                                        <th scope="col">#</th>
                                        <th scope="col">Player 1</th>
                                        <th scope="col">Player 2</th>
                                        <th scope="col">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $cnt = 0;
                                    while ($row = mysqli_fetch_array($myquery2)) {
                                    ?>
                                        <tr>
                                            <th scope="row"><?php echo ++$cnt; ?></th>
                                            <td><?php echo $res_arr[$row['player1']]; ?></td>
                                            <td><?php echo $res_arr[$row['player2']]; ?></td>
                                            <td><?php echo $row['date']; ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>

                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    <script>

    </script>
</body>

</html>


<?php
$conn->close();
?>