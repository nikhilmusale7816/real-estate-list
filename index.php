<?php
if ($_POST) {
    if ($_POST['city']) {
        $city = $_POST['city'];
        $offset = $_POST['offset'];
    }
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://us-real-estate.p.rapidapi.com/agents/agents-search?state_code=PA&city=" . $city . "&limit=100&offset=" . $offset,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "x-rapidapi-host: us-real-estate.p.rapidapi.com",
            "x-rapidapi-key: c8ad8bd0camsh22179469c0db01ap1a42d4jsnebd5a6f97020"
        ],
    ]);
} else {
    $city = 'Harrisburg';
    $offset = 0;
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://us-real-estate.p.rapidapi.com/agents/agents-search?state_code=PA&city=Harrisburg&limit=100&offset=0",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "x-rapidapi-host: us-real-estate.p.rapidapi.com",
            "x-rapidapi-key: c8ad8bd0camsh22179469c0db01ap1a42d4jsnebd5a6f97020"
        ],
    ]);
}

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    $response = json_decode($response, true);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $city ?> Agents Data</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
</head>
<body>

<div class="container-fluid">
    <!-- Form Section -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="" method="post">
                <div class="form-group">
                    <label for="inputCity">Selected City</label>
                    <select class="form-control" name="city" id="inputCity">
                        <option <?php if ($city == 'Harrisburg') echo 'selected'; ?> value="Harrisburg">Harrisburg</option>
                        <option <?php if ($city == 'Philadelphia') echo 'selected'; ?> value="Philadelphia">Philadelphia</option>
                        <option <?php if ($city == 'Uniontown') echo 'selected'; ?> value="Uniontown">Uniontown</option>
                        <option <?php if ($city == 'Pottstown') echo 'selected'; ?> value="Pottstown">Pottstown</option>
                        <option <?php if ($city == 'Coatesville') echo 'selected'; ?> value="Coatesville">Coatesville</option>
                        <option <?php if ($city == 'Lewistown') echo 'selected'; ?> value="Lewistown">Lewistown</option>
                        <option <?php if ($city == 'Erie') echo 'selected'; ?> value="Erie">Erie</option>
                        <option <?php if ($city == 'Lebanon') echo 'selected'; ?> value="Lebanon">Lebanon</option>
                        <option <?php if ($city == 'Lancaster') echo 'selected'; ?> value="Lancaster">Lancaster</option>
                        <option <?php if ($city == 'Chambersburg') echo 'selected'; ?> value="Chambersburg">Chambersburg</option>
                        <option <?php if ($city == 'Pittsburgh') echo 'selected'; ?> value="Pittsburgh">Pittsburgh</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="inputOffset">Select Offset</label>
                    <select class="form-control" name="offset" id="inputOffset">
                        <option <?php if ($offset == 0) echo 'selected'; ?> value="0">0</option>
                        <option <?php if ($offset == 1) echo 'selected'; ?> value="1">1</option>
                        <option <?php if ($offset == 2) echo 'selected'; ?> value="2">2</option>
                        <option <?php if ($offset == 3) echo 'selected'; ?> value="3">3</option>
                        <option <?php if ($offset == 4) echo 'selected'; ?> value="4">4</option>
                        <option <?php if ($offset == 5) echo 'selected'; ?> value="5">5</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Submit</button>
            </form>
        </div>
    </div>

    <!-- Data Table Section -->
    <div class="row">
        <div class="col-md-12">
            <h4 class="text-center">Leads</h4>
            <table id="example" class="table table-bordered table-striped text-center">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Phone (Mobile)</th>
                        <th>Phone (Home)</th>
                        <th>Phone (Office)</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($x = 0; $x <= 99; $x++) {
                        echo "<tr>";
                        echo "<td>" . ($x + 1) . "</td>";
                        echo "<td>" . $response['data']['agents'][$x]['name'] . "</td>";
                        echo "<td>" . $response['data']['agents'][$x]['email'] . "</td>";
                        echo "<td>" . $response['data']['agents'][$x]['office']['phones'][0]['number'] . "</td>";
                        echo "<td>" . $response['data']['agents'][$x]['phones'][0]['number'] . "</td>";
                        echo "<td>" . $response['data']['agents'][$x]['phones'][1]['number'] . "</td>";
                        echo "<td>" . $response['data']['agents'][$x]['phones'][2]['number'] . "</td>";
                        echo "<td>" . $response['data']['agents'][$x]['address']['line'] . ', ' . $response['data']['agents'][$x]['address']['city'] . '-' . $response['data']['agents'][$x]['address']['state'] . ', ' . $response['data']['agents'][$x]['address']['postal_code'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

<!-- DataTables Buttons JS -->
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>

<!-- JSZip for exporting Excel -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<!-- DataTables Initialization with CSV Export -->
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: ['csvHtml5']
        });
    });
</script>

</body>
</html>
