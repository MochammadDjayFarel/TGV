<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TGV</title>
        <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.min.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" />
<style>
        :root{
            --color: #AAC4F5;
            --accent: #356dff;
            --bg: #e7efff;
            --card: #ffffff;
        }
        *{ box-sizing: border-box; margin:0; padding:0; }
        body { background: var(--bg); font-family: Arial, sans-serif; height: 300vh; }

  /* ========================
      Promosi benner
     ======================== */
.travel-carousel {
    width: 94%;
    margin: 20px auto;
    border-radius: 20px;
    overflow: hidden;
    background: #e8f1ff;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.15);
}

/* Gambar Carousel */
.travel-img {
    height: 300px;
    object-fit: cover;
}

/* Button bulat */
.travel-btn {
    background: rgba(255, 255, 255, 0.9);
    width: 45px;          /* ukuran bulatan */
    height: 45px;         /* ukuran bulatan */
    border-radius: 50%;
    top: 50%;
    transform: translateY(-50%);
    transition: 0.2s;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    display: flex;             /* memastikan panah center */
    justify-content: center;
    align-items: center;
}

/* Hilangkan default icon */
.carousel-control-prev-icon,
.carousel-control-next-icon {
    background-image: none !important;
    width: 28px;            /* ukuran area panah */
    height: 28px;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Panah Kiri */
.carousel-control-prev-icon.custom-arrow::after {
    content: '‹';
    font-size: 34px;        /* ukuran panah */
    font-weight: bold;
    color: #356dff;
    line-height: 0;
}

/* Panah Kanan */
.carousel-control-next-icon.custom-arrow::after {
    content: '›';
    font-size: 34px;        /* ukuran panah */
    font-weight: bold;
    color: #356dff;
    line-height: 0;
}

/* Indikator dot */
.travel-dot {
    width: 12px !important;
    height: 12px !important;
    border-radius: 50%;
    background-color: #a8c6ff !important;
    margin: 6px !important;
    transition: 0.2s;
}

.travel-dot.active {
    background-color: var(--terdcolor) !important;
}

  /* ========================
      AKUN CARD BESAR & CLEAR
     ======================== */
  #akunBox {
    width: 89%;
    max-width: 100%;
    margin: 22px auto;
    background: var(--card);
    border-radius: 18px;
    padding: 20px 26px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    box-shadow: 0 8px 28px rgba(11,59,102,0.08);
    transition: .22s ease;
    position: relative;
    z-index: 40;
  }

  .akun-left { display: flex; align-items: center; gap: 18px; }

  .akun-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display:flex;
    align-items:center;
    justify-content:center;
    background: linear-gradient(180deg,#fff,#f6fbff);
    border: 3px solid var(--color);
    color: var(--accent);
    font-size: 32px;
    box-shadow: 0 6px 18px rgba(11,59,102,0.08);
  }

  .akun-name {
    font-size: 22px;
    font-weight: 700;
    color: #0b3b66;
  }

  .btn-setting {
    width: 54px;
    height: 54px;
    border-radius: 14px;
    background: var(--card);
    border: none;
    display:flex;
    align-items:center;
    justify-content:center;
    box-shadow: 0 6px 20px rgba(11,59,102,0.10);
    cursor:pointer;
    color: var(--accent);
    font-size: 24px;
  }

          .dropdown-menu {
            border-radius: 15px;
            padding: 10px 0;
            box-shadow: 0 6px 20px rgba(0,0,0,0.12);
        }

        .dropdown-item {
            padding: 10px 20px;
        }

        .dropdown-item:hover {
            background: #f0f6ff;
        }

  /* .setting-dropdown {
    position: absolute;
    top: 100px;
    left: 1193px;
    border-radius: 14px;
    font-size: 18px;
  }
  .setting-dropdown li{list-style: none}
  .setting-dropdown a { padding: 14px 50px; } */

  .setting-dropdown a:hover { background-color: var(--bg); color: var(--card) }

  /* sticky mode (lebih besar supaya enak dilihat) */
  .navbar-fixed {
    position: fixed !important;
    top: 12px !important;
    left: 50% !important;
    transform: translateX(-50%) scale(.98);
    width: 95% !important;
    padding: 14px 22px !important;
    border-radius: 16px !important;
    box-shadow: 0 10px 32px rgba(11,59,102,0.20) !important;
  }
  .navbar-fixed .akun-icon { width:55px; height:55px; font-size:26px; }
  .navbar-fixed .akun-name { font-size:19px; }

  #akunSpacer { display:none; height:0; }

  /* ========================
     SLIDER FITURE
     ======================== */
  .carousel-wrapper {
    width: 95%;
    max-width: 100%;
    margin: 26px auto 46px;
    display: flex;
    align-items: center;
    gap: 20px;
  }

  .arrow-btn {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    background: var(--card);
    border: none;
    box-shadow: 0 8px 22px rgba(11,59,102,0.12);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size: 28px;
    color: var(--accent);
    cursor: pointer;
  }

  .carousel-container { overflow:hidden; flex:1; }
  .carousel-track { display:flex; gap: 18px; transition: .35s; }

  .menu-item {
    flex: 0 0 calc((100% - 36px) / 3); 
    background: var(--card);
    border-radius: 16px;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    padding: 24px 14px;
    min-height: 150px;
    text-align:center;
    box-shadow: 0 8px 22px rgba(11,59,102,0.08);
    color: #0b3b66;
    font-weight:700;
  }

  .menu-item i { font-size: 40px; color: var(--accent); }
  .menu-item span { font-size: 16px; margin-top: 10px; }

  /* HP mode */
  @media (max-width:700px){
    #akunBox, .carousel-wrapper { width: 96%; }

    .akun-icon { width:60px; height:60px; font-size:28px; }
    .akun-name { font-size:19px; }

    .arrow-btn { width:48px; height:48px; font-size:24px; }

    .menu-item {
      padding: 18px 12px;
      min-height:130px;
    }
    .menu-item i { font-size:32px; }
    .menu-item span { font-size:14px; }
  }

    /* ========================
      TAB PENCARIAN TICKET 
     ======================== */
/* Card utama */
.ticket-modern-card {
    width: 100%;
    max-width: 1100px;
    margin: auto;
    padding: 35px;
    border-radius: 25px;
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(18px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

/* Tabs modern */
.modern-tabs .nav-link {
    border-radius: 50px;
    padding: 10px 25px;
    margin-right: 10px;
    font-weight: 600;
    color: #4a4a4a;
    background: #f1f1f1;
    transition: 0.25s;
}

/* Hover tab agar naik / ngangkat */
.modern-tabs .nav-link:hover {
    transform: translateY(-4px) scale(1.03);
    box-shadow: 0 8px 16px rgba(0, 106, 255, 0.25);
    transition: 0.25s ease;
}


.modern-tabs .nav-link.active {
    background: #2a72ff;
    color: white;
    box-shadow: 0 5px 15px rgba(0, 106, 255, 0.4);
}

/* Label */
.modern-label {
    font-weight: 600;
    margin-bottom: 6px;
}

/* Input modern */
.modern-input {
    display: flex;
    align-items: center;
    padding: 12px 18px;
    border-radius: 15px;
    background: #ffffff;
    box-shadow: inset 0 0 0 1px #d7d7d7;
    transition: 0.2s;
}

.modern-input i {
    font-size: 18px;
    color: #007bff;
    margin-right: 12px;
}

.modern-input input {
    border: none;
    outline: none;
    width: 100%;
    background: transparent;
    font-size: 15px;
    font-weight: 500;
}

.modern-input:hover {
    box-shadow: inset 0 0 0 1px #007bff;
}

/* Tombol cari modern */
.modern-search-btn {
    text-align: right;
    margin-top: 30px;
}

.btn-search-modern {
    background: #007bff;
    color: white;
    padding: 15px 45px;
    border: none;
    border-radius: 18px;
    font-size: 17px;
    font-weight: 700;
    transition: 0.3s;
    box-shadow: 0 8px 20px rgba(0, 115, 255, 0.35);
}

.btn-search-modern:hover {
    background: #005ce6;
    transform: translateY(-3px);
}

  /* ========================
      PROMOSI TICKET
     ======================== */
/* ———— NEGARA POPULER ———— */

.popular-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  gap: 22px;
}

.popular-card {
  position: relative;
  overflow: hidden;
  border-radius: 16px;
  height: 220px;
}

.popular-card img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.popular-label {
  position: absolute;
  bottom: 0;
  width: 100%;
  padding: 16px;
  background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
  color: white;
}

.popular-label h4 {
  margin: 0;
  font-size: 18px;
  font-weight: 700;
}

.popular-label p {
  margin: 0;
  font-size: 14px;
  opacity: 0.85;
}



/* ———— PROMO TICKET ———— */

.promo-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
  gap: 20px;
}

/* BATAS MAKSIMAL 5 ITEM */
.limited-grid > *:nth-child(n+6) {
  display: none;
}

.promo-card {
  background: #fff;
  border-radius: 14px;
  overflow: hidden;
  box-shadow: 0 5px 18px rgba(0,0,0,0.08);
  transition: 0.2s;
}

.promo-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 24px rgba(0,0,0,0.12);
}

.promo-card img {
  width: 100%;
  height: 150px;
  object-fit: cover;
}

.promo-body {
  padding: 15px;
}

.promo-body h4 {
  font-size: 16px;
  font-weight: 700;
  margin: 0;
}

.promo-body p {
  font-size: 13px;
  color: #444;
  margin: 6px 0 14px;
}

.price {
  color: #007bff;
  font-weight: 700;
  font-size: 14px;
}

.promo-btn {
  width: 100%;
  padding: 10px;
  background: #3A8DFF;
  border: none;
  color: white;
  font-weight: 600;
  border-radius: 10px;
  transition: 0.2s;
}

.promo-btn:hover {
  background: #246fe0;
}


</style>

</head>
<body>
<!-- Container wrapper -->


<main>
    @yield('content')
</main>
@stack('script')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" 
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"
        integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK" crossorigin="anonymous"></script>
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.umd.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.js"></script>
</body>
</html>