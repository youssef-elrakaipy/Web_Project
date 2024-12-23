<?php
$servername = "localhost";
$username = "root";
$password = "";

// Get the car model, car ID, and brand (database) from the URL parameters
$car_model = isset($_GET['car_model']) ? $_GET['car_model'] : '340i'; // Default to '340i'
$car_id = isset($_GET['car_id']) ? intval($_GET['car_id']) : 1; // Default to car ID 1
$brand = isset($_GET['brand']) ? $_GET['brand'] : 'bmw'; // Default to 'bmw'

// Switch between different databases based on the brand
switch ($brand) {
    case 'bmw':
        $dbname = "bmw";
        break;
    case 'mitsubishi':
        $dbname = "mitsubishi";
        break;
    case 'mercedes':
        $dbname = "mercedes";
        break;
    case 'peugeot':
        $dbname = "peugeot";
        break;
        
    default:
        die("Unknown brand specified.");
}

// Create connection to the chosen database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch car data
$sql = "SELECT * FROM `" . $car_model . "` WHERE id = $car_id"; // Add backticks around $car_model
$result = $conn->query($sql);

// Fetch car data
if ($result === false) {
    echo "Error: " . $conn->error . "<br>";
    exit;
}

if ($result->num_rows > 0) {
    $car = $result->fetch_assoc();
} else {
    echo "No car found with the provided ID.<br>";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lily Car Rental and Purchase</title>
    <link rel="stylesheet" href="./css/normalize.css">
    <link rel="stylesheet" href="./css/all.min.css">
    <link rel="stylesheet" href="./css/buy_rent.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="./JS/script.js" defer></script>
    <style>
        /* Global Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            width: 90%;
            margin: 0 auto;
        }

        header {
            background-color: #333;
            color: white;
            padding: 15px 0;
            text-align: center;
        }

        header h1 {
            font-size: 2.5em;
        }

        nav ul {
            list-style: none;
            padding: 0;
        }

        nav ul li {
            display: inline;
            margin: 0 20px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 1.2em;
        }

        nav ul li a:hover {
            color: rgb(20, 51, 61);
        }

        /* Section for Car Details */
        .det {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 40px 0;
        }

        .box_1 {
            flex: 0 0 50%;
            padding-right: 40px;
            box-sizing: border-box;
        }

        .box_1 h2 {
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #333;
        }

        .color {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .circle {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            cursor: pointer;
            border: 3px solid #ddd;
            transition: 0.3s;
        }

        .circle:hover {
            transform: scale(1.1);
            border-color:rgb(20, 51, 61);
        }

        .circle.black {
            background-color: black;
        }

        .circle.white {
            background-color: white;
        }

        .circle.red {
            background-color: red;
        }

        /* Car Image */
        .image {
            flex: 0 0 45%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .image img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Buttons */
        button {
            background-color:rgb(20, 51, 61);
            color: white;
            font-size: 1.2em;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background-color:rgb(20, 51, 61);
        }

        /* Table for Car Specifications */
        .table {
            background-color: #fff;
            padding: 40px 0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border-radius: 10px;
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        table td {
            padding: 15px;
            font-size: 1.1em;
            border-bottom: 1px solid #ddd;
        }

        table tr:last-child td {
            border-bottom: none;
        }

        table td:nth-child(1) {
            font-weight: 600;
            color: #555;
        }

        /* Footer */
        footer {
            background-color: #333;
            color: white;
            padding: 20px 0;
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>

<body>

    <header>
        <div class="container">
            <nav>
                <h1>Lil Suzy</h1>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="car_collection_2.html">Car Collection</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="det">
        <div class="container">
            <!-- Car Info and Color Selection -->
            <div class="box_1">
                <h2><?php echo strtoupper($car_model); ?></h2>
                <div>
                    <a href="cart.php?car_model=<?php echo urlencode($car_model); ?>&car_id=<?php echo $car_id; ?>&brand=<?php echo urlencode($brand); ?>&color=black&action=buy">
                        <button type="button">Buy</button>
                    </a>
                    <a href="cart.php?car_model=<?php echo urlencode($car_model); ?>&car_id=<?php echo $car_id; ?>&brand=<?php echo urlencode($brand); ?>&color=black&action=rent">
                        <button type="button">Rent</button>
                    </a>
                </div>

                <div class="color">
                    <span class="circle black" data-color="black"></span>
                    <span class="circle white" data-color="white"></span>
                    <span class="circle red" data-color="red"></span>
                </div>
            </div>

            <!-- Car Image -->
            <div class="image">
                <img id="carImage" src="data:image/png;base64,<?php echo base64_encode($car['picblack']); ?>" alt="<?php echo strtoupper($car_model); ?>">
            </div>
        </div>
    </section>

    <!-- Car Specifications Table -->
    <section class="table">
        <div class="container">
            <table>
                <tr>
                    <td>Motor</td>
                    <td><?php echo $car['motor']; ?></td>
                </tr>
                <tr>
                    <td>Horsepower</td>
                    <td><?php echo $car['hp']; ?></td>
                </tr>
                <tr>
                    <td>Type</td>
                    <td><?php echo $car['type']; ?></td>
                </tr>
                <tr>
                    <td>Drive Train</td>
                    <td><?php echo $car['drivetrain']; ?></td>
                </tr>
            </table>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 Lily Car Rental. All rights reserved.</p>
    </footer>

    <script>
        document.querySelectorAll('.circle').forEach(circle => {
            circle.addEventListener('click', () => {
                const color = circle.dataset.color;
                const carImages = {
                    black: 'data:image/png;base64,<?php echo base64_encode($car['picblack']); ?>',
                    white: 'data:image/png;base64,<?php echo base64_encode($car['picwhite']); ?>',
                    red: 'data:image/png;base64,<?php echo base64_encode($car['picred']); ?>'
                };
                document.getElementById('carImage').src = carImages[color];

                // Update links with selected color
                document.querySelectorAll('a').forEach(a => {
                    a.href = a.href.replace(/color=[^&]*/, 'color=' + color);
                });
            });
        });
    </script>
</body>

</html>
