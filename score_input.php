<?php
require 'db.php';
session_start();

$sql = "SELECT * FROM `players`";
$myquery = mysqli_query($conn, $sql);

$players = [];
while ($row = mysqli_fetch_array($myquery)) {
    $players[$row['id']] = $row['name'];
}
if (isset($_POST['btn_save'])) {
    $_SESSION['match'] = $_POST['match'];
    $_SESSION['player'] = $_POST['player'];

    $sql = "
        INSERT INTO `player_scores`(`match_id`, `date`, `player_id`, `p1`, `p2`, `p3`, `total`) VALUES (
        '" . $_POST['match'] . "','" . $_POST['date'] . "','" . $_POST['player'] . "','" . $_POST['point1'] . "',
        '" . $_POST['point2'] . "','" . $_POST['point3'] . "','" . $_POST['point1'] + $_POST['point2'] + $_POST['point3'] . "'
        )";
    $myquery = mysqli_query($conn, $sql);
}


$sql2 = "SELECT * FROM `player_matches` WHERE date='$today'";
$myquery2 = mysqli_query($conn, $sql2);

$sql3 = "SELECT * FROM `player_scores` ORDER BY id DESC";
$myquery3 = mysqli_query($conn, $sql3);
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
                <div class="card-header text-center">Score Input</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <form action="" method="POST">
                                <div class="mb-2">
                                    <label class="">Date</label>
                                    <input type="date" name="date" value="<?php echo $today; ?>" class="form-control" readonly>
                                </div>
                                <div class="mb-2">
                                    <label class="">Match Select</label>
                                    <select name="match" class="form-control" id="mat_id" required>
                                        <?php
                                        echo '<option value="">select one</option>';
                                        while ($row = mysqli_fetch_array($myquery2)) {
                                            if (isset($_SESSION['match'])) {
                                                if ($_SESSION['match'] == $row['id']) {
                                                    echo '<option value="' . $row['id'] . '" selected>' . $players[$row['player1']] . ' VS ' . $players[$row['player2']] . '</option>';
                                                } else {
                                                    echo '<option value="' . $row['id'] . '">' . $players[$row['player1']] . ' VS ' . $players[$row['player2']] . '</option>';
                                                }
                                            } else {
                                                echo '<option value="' . $row['id'] . '">' . $players[$row['player1']] . ' VS ' . $players[$row['player2']] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="">Player</label>
                                    <select name="player" class="form-control" id="playr_id" required>
                                        <option value="">select one</option>
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <div class="mb-2">
                                            <label class="">Point1</label>
                                            <input type="text" class="form-control" name="point1" required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="mb-2">
                                            <label class="">Point2</label>
                                            <input type="text" class="form-control" name="point2" required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="mb-2">
                                            <label class="">Point3</label>
                                            <input type="text" class="form-control" name="point3" required>
                                        </div>
                                    </div>
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
                                        <th scope="col">id</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Player</th>
                                        <th scope="col">P1</th>
                                        <th scope="col">P2</th>
                                        <th scope="col">P3</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $cnt = 0;
                                    while ($row = mysqli_fetch_array($myquery3)) {
                                    ?>
                                        <tr>
                                            <th scope="row"><?php echo $row['id']; ?></th>
                                            <td><?php echo $row['date']; ?></td>
                                            <td><?php echo $players[$row['player_id']]; ?></td>
                                            <td><?php echo $row['p1']; ?></td>
                                            <td><?php echo $row['p2']; ?></td>
                                            <td><?php echo $row['p3']; ?></td>
                                            <td><?php echo $row['total']; ?></td>
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
        $(document).ready(function() {
            <?php
            if (isset($_SESSION['match'])) {
            ?>
                $.ajax({
                    url: "ajax_fetch.php?mat=" + <?php echo $_SESSION['match'] ?>,
                    success: function(result) {
                        $("#playr_id").text('');
                        $("#playr_id").append(result);
                    }
                });
            <?php
            }
            ?>

            $("#mat_id").change(function() {
                let match_id = $('#mat_id').val();
                $.ajax({
                    url: "ajax_fetch.php?mat=" + match_id,
                    success: function(result) {
                        $("#playr_id").text('');
                        $("#playr_id").append(result);
                    }
                });
            });
        });
    </script>
</body>

</html>


<?php
$conn->close();
?>