<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            margin-top: 50px;
        }
        .table-custom {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        .table-custom th, .table-custom td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        .table-custom th {
            background-color: #343a40;
            color: #fff;
            position: sticky;
            top: 0;
        }
        .table-custom tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .table-custom tr:hover {
            background-color: #ddd;
        }
        .table-custom td {
            background-color: #fff;
        }
        .action-links {
            text-align: center;
            margin-top: 20px;
        }
        .action-links a {
            text-decoration: none;
            color: #007bff;
            margin: 0 10px;
            font-weight: bold;
        }
        .action-links a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Trainer Management</h2>
        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require 'connection.php';
                    $query = "SELECT * FROM `trainer`";
                    $result = mysqli_query($con, $query);

                    while ($row = mysqli_fetch_array($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["mobile"]) . "</td>";
                        echo "</tr>";
                    }
                    mysqli_close($con);
                    ?>
                </tbody>
            </table>
        </div>
        <div class="action-links">
            <p>Do you Want to Add a New Trainer? <a href="AddTrainer.php">Add</a></p>
            <p>Do you Want to Delete a Trainer? <a href="DeleteTrainer.php">Delete</a></p>
            <p>Do you Want to Edit a Trainer? <a href="EditTrainer.php">Edit</a></p>
            <p><a href="HomePage.php">Back</a></p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-qgMFSowS0IsFZnLgkW3CDIpX/Zb/yVmN5MRGq5InfiKx0YVZBlV1LVQxvZdEhZSm" crossorigin="anonymous"></script>
</body>
</html>
