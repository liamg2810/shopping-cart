<?php
    $DATABASE = 'shoppingcart';
    $USERNAME = 'root';
    $PASSWORD = '';

    $connection = new PDO('mysql:host=localhost;dbname=' . $DATABASE, $USERNAME, $PASSWORD);

    function QueryCarts() {

        global $connection;

        $query = $connection->prepare('SELECT * FROM tblcart');

        $query->execute();

        $carts = $query->fetchAll();

        return $carts;
    }

    function DeleteCart($id) {

        global $connection;

        $query = $connection->prepare('DELETE FROM tblcart WHERE id = :id');

        $query->bindParam(':id', $id);

        $query->execute();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            DeleteCart($id);

            header('Location: index.php');
        }
    }
?>

<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Home</title>
</head>

<body>
    <h1 class="text-center text-5xl font-bold">Welcome To Your Shopping Carts</h1>

    
    <div class="flex justify-center mt-10 flex-col mx-32 gap-5">
        <a class="text-center bg-cyan-500 hover:bg-cyan-600 hover:pointer w-32 rounded-full text-lg font-bold p-2" href="addcart.php">Add Cart</a>
        <table>
            <thead>
                <tr>
                    <th class="border px-4 py-2">Cart</th>
                    <th class="border px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $carts = QueryCarts();

                    if (count($carts) == 0) {
                        echo '<tr>';
                        echo '<td class="border px-4 py-2" colspan="2">No Carts Found</td>';
                        echo '</tr>';
                    }

                    foreach ($carts as $cart) {
                        echo '<tr>';
                        echo '<td class="border px-4 py-2">' . $cart['cartName'] . '</td>';
                        echo
                        '<td class="border px-4 py-2">
                            <div class="flex justify-left gap-2">
                                <a class="bg-cyan-500 px-4 text-lg rounded-full" href="cart.php?id=' . $cart['id'] . '">View</a>
                                <a class="bg-red-500  px-4  text-lg rounded-full" href="index.php?id=' . $cart['id'] . '">Delete</a>
                            </div>
                        </td>';
                        echo '</tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>