<?php
session_start();

// Remover item do carrinho
if (isset($_GET['remove'])) {
    $product = $_GET['remove'];
    unset($_SESSION['cart'][$product]);
}

// Contador de produtos no carrinho
$cart_count = array_sum(array_column($_SESSION['cart'], 'quantity'));

// Finalizar a compra
if (isset($_POST['finalize_purchase'])) {
    $_SESSION['cart'] = []; // Limpa o carrinho após a compra
    header('Location: index.php'); // Redireciona para a página inicial
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" type="text/css" href="style-index.css">
</head>
<body>

<header>
    <h1>Carrinho de Compras</h1>
</header>

<section id="carrinho">
    <h2>Produtos no Carrinho</h2>
    <?php if (empty($_SESSION['cart'])): ?>
        <p>Seu carrinho está vazio.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($_SESSION['cart'] as $product => $details): ?>
                <li>
                    <?php echo $product; ?> - R$<?php echo $details['price']; ?>,00 - Quantidade: <?php echo $details['quantity']; ?>
                    <a href="checkout.php?remove=<?php echo urlencode($product); ?>">Remover</a>
                </li>
            <?php endforeach; ?>
        </ul>

        <p>Total: R$
            <?php
            $total = 0;
            foreach ($_SESSION['cart'] as $details) {
                $total += $details['price'] * $details['quantity'];
            }
            echo $total;
            ?>,00
        </p>

        <form method="POST">
            <button type="submit" name="finalize_purchase">Finalizar Compra</button>
        </form>
    <?php endif; ?>
</section>

</body>
</html>
