<?php
    $DATABASE = 'shoppingcart';
    $USERNAME = 'root';
    $PASSWORD = '';

    $connection = new PDO('mysql:host=localhost;dbname=' . $DATABASE, $USERNAME, $PASSWORD);


    function AddItemToCart($name, $quantity) {
        global $connection;

        $query = $connection->prepare('INSERT INTO tblitem (itemName, cartID, quantity) VALUES (:itemName, :cartID, :quantity)');

        $query->bindParam(':itemName', $name);
        $query->bindParam(':cartID', $_GET['id']);
        $query->bindParam(':quantity', $quantity);

        $query->execute();

        header("Location: cart.php?id={$_GET['id']}");
    }

    function GetCartItems() {
        global $connection;

        $query = $connection->prepare('SELECT * FROM tblitem WHERE cartID = :cartID');

        $query->bindParam(':cartID', $_GET['id']);

        $query->execute();

        $items = $query->fetchAll();

        return $items;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $quantity = $_POST['quantity'];

        AddItemToCart($name, $quantity);


        header("Location: cart.php?id={$_GET['id']}");
    }

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (isset($_GET['itemId'])) {
            $id = $_GET['itemId'];
        
            $query = $connection->prepare('DELETE FROM tblitem WHERE id = :id');
        
            $query->bindParam(':id', $id);
        
            $query->execute();
        
        
            header("Location: cart.php?id={$_GET['id']}");
        }
    }

    
    if (!isset($_GET['id'])  && $_SERVER['REQUEST_METHOD'] == 'GET') {
        echo 'No cart ID provided';
        

        exit();
        header('Location: index.php');
    }
?>

<html>

<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Cart</title>
</head>

<body>
    <h1 class="text-center text-5xl font-bold">Cart</h1>

    <div class="flex justify-center mt-10 flex-col mx-32 gap-5">
        <form action="cart.php?id=<?php echo $_GET['id']; ?>" method="POST">
            <input class="border px-4 py-2" type="text" name="name" placeholder="Item Name">
            <input class="border px-4 py-2" type="number" name="quantity" placeholder="Quantity">
            <button class="bg-cyan-500 hover:bg-cyan-600 hover:pointer w-32 rounded-full text-lg font-bold p-2" type="submit">Add Item</button>
        </form>
    </div>

    <div class="flex justify-center mt-10 flex-col mx-32 gap-5">
        <table>
            <thead>
                <tr>
                    <th class="border px-4 py-2">Item</th>
                    <th class="border px-4 py-2">Quantity</th>
                    <th class="border px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $items = GetCartItems();

                    foreach ($items as $item) {
                        echo '<tr>';
                        echo '<td class="border px-4 py-2">' . $item['itemName'] . '</td>';
                        echo '<td class="border px-4 py-2">' . $item['quantity'] . '</td>';
                        echo '<td class="border px-4 py-2">
                        <a href="cart.php?id=' . $_GET['id'] . '&itemId=' . $item['id'] . '" class="bg-red-500 hover:bg-red-600 hover:pointer w-32 rounded-full text-lg font-bold p-2">Delete</a>
                        </td>';
                        echo '</tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>