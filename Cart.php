<?php
require 'db_conn.php';
if (!is_logged_in()) { header("Location: signin.php"); exit; }
$cart = $_SESSION['cart'] ?? [];
if (!$cart) { header("Location: cart.php"); exit; }
$ids = implode(',', array_map('intval', array_keys($cart)));
$res = $mysqli->query("SELECT id,price,stock FROM books WHERE id IN ($ids)");
$total = 0; $books = [];
while ($r = $res->fetch_assoc()) {
    $id = $r['id']; $qty = $cart[$id] ?? 0;
    if ($qty > $r['stock']) die("Not enough stock for book id $id");
    $books[$id] = $r; $total += $r['price'] * $qty;
}
$ins = $mysqli->prepare("INSERT INTO orders (user_id,total) VALUES (?,?)");
$uid = current_user_id(); $ins->bind_param('id',$uid,$total); $ins->execute();
$order_id = $mysqli->insert_id;
$it_stmt = $mysqli->prepare("INSERT INTO order_items (order_id,book_id,qty,price) VALUES (?,?,?,?)");
$upd = $mysqli->prepare("UPDATE books SET stock = stock - ? WHERE id = ?");
foreach ($cart as $bid => $qty) {
    $price = $books[$bid]['price'];
    $it_stmt->bind_param('iiid',$order_id,$bid,$qty,$price); $it_stmt->execute();
    $upd->bind_param('ii',$qty,$bid); $upd->execute();
}
unset($_SESSION['cart']);
header("Location: index.php?ordered=1"); exit;
