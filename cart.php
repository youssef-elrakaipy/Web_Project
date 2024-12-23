<?php
$servername = "localhost";
$username = "root";
$password = "";

// Get the car model, car ID, brand, and selected color from the URL parameters
$car_model = isset($_GET['car_model']) ? $_GET['car_model'] : '340i';
$car_id = isset($_GET['car_id']) ? intval($_GET['car_id']) : 1;
$brand = isset($_GET['brand']) ? $_GET['brand'] : 'bmw';
$color = isset($_GET['color']) ? $_GET['color'] : 'black';  // Default to black if no color is selected

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

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM `" . $car_model . "` WHERE id = $car_id";
$result = $conn->query($sql);

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

// Handling form submission
$form_submitted = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Process form data (for now just simulate success)
    $form_submitted = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final Page</title>
    <link rel="stylesheet" href="./css/normalize.css">
    <link rel="stylesheet" href="./css/all.min.css">
    <link rel="stylesheet" href="./css/cart.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>

<body>
    <div class="main">
        <div class="container">
            <div class="right">
                <?php if ($form_submitted): ?>
                    <!-- Show thank you message after form submission -->
                    <p class="thank-you-message">Thank you for your order! We'll get in touch with you shortly.</p>
                <?php else: ?>
                    <!-- Form for the user to fill -->
                    <form action="" method="POST">
                        <input type="text" name="name" placeholder="Enter your name" required>
                        <input type="email" name="email" placeholder="Enter your email" required>
                        <input type="text" name="phone" placeholder="Enter your number" required>
                        <textarea name="address" placeholder="Enter your address"></textarea>
                        <button type="submit">Check out</button>
                    </form>
                <?php endif; ?>
            </div>
            <div class="left">
                <!-- Display the selected car image based on color -->
                <?php
                $carImages = [
                    'black' => base64_encode($car['picblack']),
                    'white' => base64_encode($car['picwhite']),
                    'red' => base64_encode($car['picred']),
                ];
                $carImageSrc = isset($carImages[$color]) ? $carImages[$color] : $carImages['black'];  // Default to black if color is not found
                ?>
                <img src="data:image/png;base64,<?php echo $carImageSrc; ?>" alt="Car Image">
                <p>Price: $<?php echo isset($car['price']) ? $car['price'] : '12,000$'; ?></p>
                <a href="buy_rent.php">
                    <button>Back</button>
                </a>
            </div>
        </div>
    </div>

    <style>
        .thank-you-message {
            font-size: 18px;
            color: rgb(0 0 0 / 55%);
            font-weight: bold;
        }
    </style>

</body>

</html>
