<?php
$mysqli = new mysqli("localhost", "root", "", "kantin2");
$result = $mysqli->query("SELECT * FROM siskal");
$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SISKAL Store</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    footer {
      background-color: grey;
      text-align: center;
    }
    section {
      margin: 50px;
    }
    .menu {
      flex: 2;
      padding: 20px;
    }
    .cart {
      flex: 1;
      background: #f4f4f4;
      padding: 20px;
      border-left: 2px solid #ccc;
    }
    .item {
      border: 1px solid #ccc;
      border-radius: 10px;
      padding: 10px;
      margin-bottom: 15px;
      background-color: #fff;
      display: flex;
      align-items: center;
    }
    button {
      margin-left: 10px;
    }
    #qr-code {
      margin-top: 20px;
      display: none;
      text-align: center;
    }
    #qr-code img {
      width: 200px;
    }
    #confirm-button {
      margin-top: 10px;
      display: none;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">KANTIN SEKOLAH</a>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="index.php">About Kantin</a></li>
          <li class="nav-item"><a class="nav-link" href="cafetarialist.php">Cafetaria List</a></li>
          <li class="nav-item"><a class="nav-link" href="howtobuy.php">How to Buy</a></li>
          <li class="nav-item"><a class="nav-link" href="contactus.php">Contact Us</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <section>
    <p class="fs-1 fw-bold">SISKAL</p>

    <div class="menu">
      <h2>Menu</h2>
      <?php foreach ($items as $item): ?>
        <div class="item" id="item-<?= $item['id'] ?>">
          <img src="img/<?= $item['gambar'] ?>" alt="<?= $item['barang'] ?>" style="width: 80px; height: 80px; object-fit: cover; margin-right: 10px; border-radius: 8px;">
          <div>
            <strong><?= $item['barang'] ?></strong><br>
            Harga: Rp<?= number_format($item['harga'], 0, ',', '.') ?><br>
            Stok: <span id="stock-<?= $item['id'] ?>"><?= $item['stok'] ?></span><br>
            <button onclick="addToCart(<?= $item['id'] ?>, '<?= $item['barang'] ?>', <?= $item['harga'] ?>)">Tambah</button>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="cart">
      <h2>Cart</h2>
      <ul id="cart-list"></ul>
      <p>Total: <span id="total">Rp0</span></p>
      <button onclick="checkout()">Checkout</button>
      <div id="qr-code">
        <p>Scan QR to pay:</p>
        <img src="https://api.qrserver.com/v1/create-qr-code/?data=Payment&size=200x200" />
        <br />
        <button id="confirm-button" onclick="confirmPayment()">Confirm Payment</button>
      </div>
    </div>
  </section>

  <footer>
    <p>copyright daffi</p>
  </footer>

  <script>
    const stock = {
      <?php foreach ($items as $item): ?>
        <?= $item['id'] ?>: <?= $item['stok'] ?>,
      <?php endforeach; ?>
    };

    const cart = [];
    let total = 0;

    function formatRupiah(angka) {
      return 'Rp' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function addToCart(id, name, price) {
      if (stock[id] > 0) {
        cart.push({ id, name, price });
        total += price;
        updateCart();
      } else {
        alert(name + ' is out of stock!');
      }
    }

    function updateCart() {
      const cartList = document.getElementById('cart-list');
      cartList.innerHTML = '';

      cart.forEach((item, index) => {
        const li = document.createElement('li');
        li.innerHTML = `${item.name} - ${formatRupiah(item.price)} 
          <button onclick="removeFromCart(${index})" style="margin-left:10px;">Hapus</button>`;
        cartList.appendChild(li);
      });

      document.getElementById('total').textContent = formatRupiah(total);
    }

    function removeFromCart(index) {
      total -= cart[index].price;
      cart.splice(index, 1);
      updateCart();
    }

    function checkout() {
      if (cart.length === 0) return alert('Cart is empty!');

      cart.forEach(item => {
        stock[item.id]--;
        document.getElementById('stock-' + item.id).textContent = stock[item.id];
      });

      fetch('checkout_siskal.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(cart)
      });

      document.getElementById('qr-code').style.display = 'block';
      document.getElementById('confirm-button').style.display = 'inline-block';
    }

    function confirmPayment() {
      cart.length = 0;
      total = 0;
      updateCart();
      document.getElementById('qr-code').style.display = 'none';
      document.getElementById('confirm-button').style.display = 'none';
      alert('Payment confirmed!');
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
