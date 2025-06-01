<?php
$mysqli = new mysqli("localhost", "root", "", "kantin2");
$result = $mysqli->query("SELECT * FROM smutes"); $items = []; while ($row =
$result->fetch_assoc()) { $items[] = $row; } 
?>

<!--
checkout
<?php
$mysqli = new mysqli("localhost", "root", "", "kantin2");

$data = json_decode(file_get_contents("php://input"), true);

foreach ($data as $item) {
    $mysqli->query("UPDATE smutes SET stok = stok - 1 WHERE id = {$item['id']}");
}
?>
-->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <style>
    footer{
      background-color: grey;
      text-align: center;
    }
    section{
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
        margin-bottom: 10px;
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
      .item {
        border: 1px solid #ccc;
        border-radius: 10px;
        padding: 10px;
        margin-bottom: 15px;
        background-color: #fff;
      }

  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">KANTIN SEKOLAH</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">About Kantin</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="cafetarialist.php">Cafetaria List</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="howtobuy.php">How to buy</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contactus.php">Contact Us</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

      <section>
      <p class="fs-1 fw-bold">SMUTES</p>

      <div class="menu">
        <h2>Menu</h2>
        <?php foreach ($items as $item): ?>
        <div class="item" id="item-<?= $item['id'] ?>" style="display: flex; align-items: center; margin-bottom: 10px;">
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
          <img
            src="https://api.qrserver.com/v1/create-qr-code/?data=Payment&size=200x200"
          />
          <br />
          <button id="confirm-button" onclick="confirmPayment()">
            Confirm Payment
          </button>
        </div>
      </div>

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

          fetch('checkout.php', {
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

      <br />
      <br />
      <br />
      <br />
      <br>
    </section>

    <footer>
      <p>copyright daffi</p>
    </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>
</html>
