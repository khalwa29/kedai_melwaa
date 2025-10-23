<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kedai KhaMelicious</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
  <script src="https://unpkg.com/feather-icons"></script>
  <!--fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />

    
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      scroll-behavior: smooth;
      background-color: #f9f2f1ff;
    }

    /* HEADER */
    /* HEADER */
header {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  background: #f38686ff;
  box-shadow: 0 2px 10px rgba(0,0,0,0.2);
  z-index: 1000;
}

.header-container {
  display: flex;
  justify-content: space-between;
  flex-direction: row;  
  align-items: center;
  max-width: 1200px;
  margin: 0 auto;
  padding: 1rem 2rem;
}

.logo {
  font-family: 'Pacifico', cursive;
  color: white;
  margin: 0;
  font-size: 2.5rem;
}

/* NAV WRAPPER untuk menu + hamburger */
.nav-wrapper {
  display: flex;
  align-items: center;
  gap: 1rem;
  font-size: 1.5rem;
}

nav {
  display: flex;
  gap: 1rem;
}

nav a {
  color: white;
  text-decoration: none;
  font-weight: bold;
}

nav a:hover {
  text-decoration: underline;
}

.menu-toggle {
  display: none;
  cursor: pointer;
  color: white;
}

/* MOBILE RESPONSIVE */
@media (max-width: 768px) {
  nav {
    display: none;
    flex-direction: column;
    position: absolute;
    top: 70px;
    right: 0;
    background: #d02323ff;
    width: 200px;
    padding: 1rem;
    box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    border-bottom-left-radius: 10px;
  }

  nav.active {
    display: flex;
  }

  .menu-toggle {
    display: block;
  }
}


    /* SECTION */
    section {
      min-height: 100vh;
      padding: 6rem 2rem 2rem 2rem;
    }

    #home {
      background: url('img/fotoo.jpg') no-repeat center center/cover;
      color: white;
      display: flex;
      align-items: center;
      justify-content: flex-start;
      text-align: center;
      flex-direction: column;
      min-height: 100vh;
      position: relative;
    }
#home .overlay {
  font-size: 2rem;
  background: rgba(0, 0, 0, 0.5);
  padding: 2rem;
  border-radius: 10px;
  max-width: 700px;

  text-align: center;     /* <— teks jadi rata kiri */
  margin-center: 0;       /* pastikan tidak auto-center */
}


    #home h2,
    #home p {
    margin: 0 auto;            /* teks tetap di tengah */
}

.btn-beli {
    border: none;
    border-radius: 8px;
    background-color: #403636ff;
    color: #fff;
    cursor: pointer;
    transition: transform 0.2s ease;
}

.btn-beli:hover {
    transform: scale(1.05); /* efek hover sedikit membesar */
}



    /* GRID MENU RESPONSIF */
    /* MENU CARD LEBIH RAPIH & BULAT */
.menu-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
  gap: 1.5rem;
  margin-top: 2rem;
  justify-items: center;
}

.menu-card {
  display: inline-block;   /* Bisa disesuaikan layout grid/flex */
  padding: 10px;
  background-color: #f9f9f9; /* Kotak terlihat rapi */
  text-align: center;       /* Tengah-tengahkan gambar */
  border-radius: 8px;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.menu-card-img-container {
  width: 150px;
  height: 150px;
  overflow: hidden;
  border-radius: 8px;
}

.menu-card-img-container img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}


.menu-card:hover {
  transform: translateY(-5px);
}

/* Gambar bulat */
.menu-card-img {
  max-width: 150px;
  max-height: 150px;
  width: auto;
  height: auto;
  object-fit: contain;
}



.menu-card-title {
  font-size: 1rem;
  margin: 0.5rem 0;
  font-weight: bold;
}

.menu-card-price {
  font-size: 0.9rem;
  color: #d02323ff;
  font-weight: bold;
}

    /* RESPONSIVE GRID */
    @media (max-width: 992px) {
      .menu-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (max-width: 600px) {
      .menu-grid {
        grid-template-columns: 1fr;
      }
    }

    /* FOOTER */
    footer {
      background: #333;
      color: white;
      padding: 2rem;
      text-align: center;
    }

    .socials a {
      color: white;
      margin: 0 10px;
      font-size: 1.5rem;
    }

    .links a {
      display: inline-block;
      margin: 0 10px;
      color: white;
      text-decoration: none;
    }

    .links a:hover {
      text-decoration: underline;
    }

    .credit p {
      margin-top: 1rem;
      font-size: 0.9rem;
      color: #aaa;
    }
  </style>
</head>
<body>


<!-- HEADER -->
<header>
  <div class="header-container">
    <h1 class="logo">Kedai KhaMelicious</h1>

    <!-- NAV + HAMBURGER -->
    <div class="nav-wrapper">
      <nav id="nav-menu">
        <a href="#home">Home</a>
        <a href="#about">Tentang</a>
        <a href="#menu">Menu</a>
        <a href="#contact">Kontak</a>
        <a href="<?= base_url('auth/login') ?>" class="btn btn-primary">Login Admin</a>
        <a href="<?= base_url('auth/loginAsUser') ?>" class="btn btn-success">Login User</a>
      </nav>

      <!-- HAMBURGER -->
      <div class="menu-toggle" id="menu-toggle">
        <i data-feather="menu"></i>
      </div>
    </div>
  </div>
</header>


  <!-- SECTION HOME -->
<section id="home">
  <div class="overlay">
    <h2>Selamat Datang di Kedai KhaMelicious</h2>
    <p>"Nikmati sajian makanan dan minuman istimewa di Kedai KhaMelicious."</p>
  </div>
</section>


  <!-- SECTION ABOUT -->
  <section id="about">
    <h2 style="text-align:center;">Tentang Kami</h2>
    <img src="<?= base_url('img/melwa.png') ?>" alt="Foto Kedai KhaMelicious" class="foto-tentang">

    <h3>Kenapa memilih Kedai KhaMelicious???</h3>
          <p>
            Kedai KhaMelicious hadir untuk kamu yang ingin lebih dari sekadar
            makan dan minum. Kami menyajikan aneka makanan pedas gurih dan
            minuman segar yang diracik dengan penuh ketelitian, disajikan dalam
            suasana hangat dan ramah sehingga setiap suapan dan tegukan jadi
            pengalaman istimewa. Dengan harga bersahabat dan pelayanan penuh
            senyum, kami percaya setiap kunjungan bisa membawa cerita baru
            untukmu.
          </p>
          <p>
            Setiap hidangan yang kami sajikan bukan hanya sekadar menu, tetapi
            juga perjalanan rasa. Dari bahan pilihan yang segar hingga racikan
            akhir koki kami, semuanya diolah dengan sepenuh hati untuk
            menghadirkan kenikmatan yang tulus. Di Kedai KhaMelicious, kami
            percaya bahwa setiap sajian bisa menjadi penghubung cerita, tempat
            berbagi tawa, dan ruang kecil untuk menemukan kenyamanan.
          </p>
          <p>
            Kedai KhaMelicious lahir dari frekuensi yang sama: kami sama-sama
            suka jajan dan menikmati kuliner. Dari hobi itu, kami ingin berbagi
            rasa sekaligus menyalurkannya menjadi sebuah bisnis yang bisa
            menghadirkan kebahagiaan lewat setiap sajian.
          </p>
  </section>

  <!-- SECTION MENU -->
  <section id="menu">
    <h2 style="text-align:center;">Menu Kami</h2>
    <p>
        Nikmati berbagai pilihan makanan dan minuman yang kami sajikan dengan
        sepenuh hati. Menu Kedai KhaMelicious dibuat untuk menemani setiap momen
        Anda, baik saat bersantai sendiri maupun bersama orang tersayang.
    </p>

  <div class="menu-grid">
  <?php foreach ($minuman as $m): ?>
    <div class="menu-card">
       <img src="<?= base_url('img/menu/'.$m['foto']) ?>" 
            alt="<?= esc($m['menu']) ?>"
            class="menu-card-img"
            loading="lazy">
      <h3 class="menu-card-title">- <?= esc($m['menu']) ?> -</h3>
      <p class="menu-card-price">Rp.<?= number_format($m['harga'],0,',','.') ?></p>
    </div>
<?php endforeach; ?>

</div>

<div class="menu-grid">
  <?php foreach ($makanan as $m): ?>
    <div class="menu-card">
      <img src="<?= base_url('img/menu/'.$m['foto']) ?>"
           alt="<?= esc($m['menu']) ?>"
           class="menu-card-img"
           loading="lazy">
      <h3 class="menu-card-title">- <?= esc($m['menu']) ?> -</h3>
      <p class="menu-card-price">Rp.<?= number_format($m['harga'],0,',','.') ?></p>
    </div>
<?php endforeach; ?>

</div>



  </section>

  <!-- SECTION CONTACT -->
  <section id="contact">
    <h2 style="text-align:center;">Kontak</h2>
    <p>Hubungi kami melalui Instagram atau Facebook. Atau kunjungi kedai kami langsung!</p>
    <div class="row">
        <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d405.7338538480065!2d109.02517608936523!3d-7.281463409040566!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1suniversitas%20peradaban%20bumiayu!5e1!3m2!1sid!2sid!4v1759072780019!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

        <form id="contactForm">
          <div class="input-group">
            <i data-feather="user"></i>
            <input type="text" placeholder="nama" />
          </div>
          <div class="input-group">
            <i data-feather="mail"></i>
            <input type="text" placeholder="email" />
          </div>
          <div class="input-group">
            <i data-feather="phone"></i>
            <input type="text" placeholder="no hp" />
          </div>
          <button type="submit" class="btn">Kirim Pesan</button>
        </form>
      </div>
  </section>

  <!-- FOOTER -->
  <footer>
    <div class="socials">
      <a href="#"><i data-feather="instagram"></i> melwa512 </a>
      <a href="#"><i data-feather="facebook"></i> Khalwa Amel </a>
    </div>
    
    <div class="links">
      <a href="#home">Home</a>
      <a href="#about">Tentang Kami</a>
      <a href="#menu">Menu</a>
      <a href="#contact">Kontak</a>
      <a href="#log-in">Log In</a>
    </div>
    <div class="credit">
      <p>Kedai KhaMelicious | by.Melwa.</p>
    </div>
  </footer>

  <script>
    feather.replace();

    // Toggle menu saat hamburger diklik
    const menuToggle = document.querySelector('.menu-toggle');
    const navMenu = document.getElementById('nav-menu');

    menuToggle.addEventListener('click', () => {
      navMenu.classList.toggle('active');
    });

    // Tutup menu setelah klik link (untuk HP)
    navMenu.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        navMenu.classList.remove('active');
      });
    });
  </script>
</body>
</html>
