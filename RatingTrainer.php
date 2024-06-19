<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rating Summary</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            border: 3px solid black;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #333;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: blue;
        }
        a:hover {
            color: red;
        }
    </style>
</head>
<body>
    <h2>Rating Summary</h2>
    <?php
    require 'connection.php';

    // Calculate average rating for each trainer
    $avgQuery = "SELECT t.name AS trainer_name, AVG(rt.rating) AS avg_rating
                 FROM ratingtrainer rt
                 INNER JOIN trainer t ON rt.trainer_id = t.trainer_id
                 GROUP BY t.name";
    $avgResult = mysqli_query($con, $avgQuery);

    // Display average rating
    echo "<table>";
    echo "<tr><th colspan='3'>Average Rating for each Trainer:</th></tr>";
    while ($avgRow = mysqli_fetch_array($avgResult)) {
        echo "<tr>
                <td colspan='2'></td>
                <td>" . $avgRow["trainer_name"] . "</td>
                <td>" . $avgRow["avg_rating"] . "</td>
              </tr>";
    }
    echo "</table>";

    // Display rating details
    echo "<table>";
    echo "<tr>
            <th>User Name</th>
            <th>Trainer Name</th>
            <th>Rating</th>
          </tr>";

    $query = "SELECT rt.rating_id, u.username AS user_name, t.name AS trainer_name, rt.rating 
              FROM ratingtrainer rt 
              INNER JOIN trainer t ON rt.trainer_id = t.trainer_id
              INNER JOIN user u ON rt.user_id = u.user_id";
    $result = mysqli_query($con, $query);

    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>
                <td>" . $row["user_name"] . "</td>
                <td>" . $row["trainer_name"] . "</td>
                <td>" . $row["rating"] . "</td>
              </tr>";
    }

    mysqli_close($con);
    ?>
    </table>
    <a href="HomePage.php">Back</a>
</body>
</html>
