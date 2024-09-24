<?php
    $DATABASE = 'shoppingcart';
    $USERNAME = 'root';
    $PASSWORD = '';

    $connection = new PDO('mysql:host=localhost;dbname=' . $DATABASE, $USERNAME, $PASSWORD);

    function CreateCart($name) {

        global $connection;

        $query = $connection->prepare('INSERT INTO tblcart (cartName) VALUES (:cartName)');

        $query->bindParam(':cartName', $name);

        $query->execute();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];

        CreateCart($name);

        header('Location: index.php');
    }
?>

<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Add Cart</title>
</head>

<body>
    <a class="absolute ml-3 mt-3 text-center bg-cyan-500 hover:bg-cyan-600 hover:pointer w-32 rounded-full text-lg font-bold p-2" href="index.php">Back</a>
    <h1 class="text-center text-5xl font-bold">Add Cart</h1>

    <div class="flex justify-center mt-10 flex-col mx-32 gap-5">
        <form action="addcart.php" method="POST">
            <input class="border px-4 py-2" type="text" name="name" placeholder="Cart Name">
            <button class="bg-cyan-500 hover:bg-cyan-600 hover:pointer w-32 rounded-full text-lg font-bold p-2" type="submit">Add Cart</button>
        </form>
    </div>
</body>
</html>