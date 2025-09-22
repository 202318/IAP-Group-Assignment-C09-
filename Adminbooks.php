<?php
require 'db_conn.php';
$q = trim($_GET['q'] ?? '');
$books = [];
if ($q !== '') {
    $like = "%$q%";
    $stmt = $mysqli->prepare("SELECT id,title,author,price,stock FROM books WHERE title LIKE ? OR author LIKE ? LIMIT 200");
    $stmt->bind_param('ss',$like,$like);
} else {
    $stmt = $mysqli->prepare("SELECT id,title,author,price,stock FROM books ORDER BY created_at DESC LIMIT 200");
}
$stmt->execute(); $res = $stmt->get_result();
while($r = $res->fetch_assoc()) $books[] = $r;
?>
<!doctype html>
<head>
    <title>Bookstore</title>
</head>

<body>
        <?php if(is_logged_in()): ?>
            <p>Hi <?=htmlspecialchars($_SESSION['user_name'])?> | <a href="Cart.php">Cart</a> | <a href="sign out.php">Sign out</a></p>
        <?php else: ?>
            <p><a href="signin.php">Sign in</a> | <a href="SignUp.php">Sign up</a></p>
        <?php endif; ?>

        <?php if(is_admin()): ?><p><a href="Adminbooks.php">Manage Books</a></p><?php endif; ?>

        <h1>Catalog</h1>
        <form method="get">
            <input name="q" placeholder="Search title or author" value="<?=htmlspecialchars($q)?>"> <button>Search</button>
        </form>

        <?php if(empty($books)): ?><p>No books found.</p><?php else: ?>
            <table border="1" cellpadding="6">
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
                
                <?php foreach($books as $b): ?>
                    <tr>
                        <td><?=htmlspecialchars($b['title'])?></td>
                        <td><?=htmlspecialchars($b['author'])?></td>
                        <td><?=number_format($b['price'],2)?></td>
                        <td><?=intval($b['stock'])?></td>
                        <td>
                            <form method="post" action="Cart.php" style="display:inline;">
                                <input type="hidden" name="book_id" value="<?=$b['id']?>">
                                <input type="number" name="qty" value="1" min="1" max="<?=$b['stock']?>" style="width:60px">
                                <button>Add</button>
                            </form>
                        </td>
                 </tr>
             <?php endforeach; ?>

            </table>


<?php endif; ?>


</body>


</html>