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
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php"><img src="img/logokantin.png" alt="" height="50px"></a>
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
    <p class="fs-1 fw-bold">KANTIN SEKOLAH</p>
    <img src="img/kantin.jpg" alt="..." width="70%">
    <br>
    <br>
    <video width="420" height="340" controls>
      <source src="movie.mp4" type="video/mp4">
      <source src="movie.ogg" type="video/ogg">
    Your browser does not support the video tag.
    </video>
    <div style="width: 70%;">

      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus officia illo beatae quia nihil, eaque porro, excepturi totam dolore assumenda aperiam minima minus non veritatis, vero libero! Quasi, provident possimus!</p>
    </div>
  </section>


  <footer>
    copyright daffi
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>
</html>