@extends('template.user')
@section('content')

<div id="carouselExampleCrossfade" 
     class="carousel slide carousel-fade travel-carousel" 
     data-mdb-ride="carousel" 
     data-mdb-carousel-init>

  <div class="carousel-indicators">
    <button type="button" data-mdb-target="#carouselExampleCrossfade" data-mdb-slide-to="0"
      class="active travel-dot"></button>
    <button type="button" data-mdb-target="#carouselExampleCrossfade" data-mdb-slide-to="1"
      class="travel-dot"></button>
    <button type="button" data-mdb-target="#carouselExampleCrossfade" data-mdb-slide-to="2"
      class="travel-dot"></button>
  </div>

  <div class="carousel-inner" style="height: 399px">
    <div class="carousel-item active" >
      <img src="{{ asset('img/slide1.png') }}" class="d-block w-100  travel-img" style="height: 399px">
    </div>
    <div class="carousel-item">
      <img src="{{ asset('img/slide2.jpg') }}" class="d-block w-100 travel-img" style="height: 399px">
    </div>
    <div class="carousel-item">
      <img src="{{ asset('img/slide3.png') }}" class="d-block w-100 travel-img" style="height: 399px">
    </div>
  </div>

  <button class="carousel-control-prev travel-btn m-2" type="button" 
          data-mdb-target="#carouselExampleCrossfade" data-mdb-slide="prev">
    <span class="carousel-control-prev-icon custom-arrow"></span>
  </button>

  <button class="carousel-control-next travel-btn m-2" type="button" 
          data-mdb-target="#carouselExampleCrossfade" data-mdb-slide="next">
    <span class="carousel-control-next-icon custom-arrow"></span>
  </button>

</div>

<div>
  <!-- AKUN (HTML) -->
  <div id="akunBox" role="navigation" aria-label="Akun pengguna">
    <div class="akun-left">
      <div class="akun-icon" aria-hidden="true"><i class="fa-solid fa-user"></i></div>
      <div class="akun-name">
        @if (Auth::check())
        <h6 class="m-0 fw-bold">{{ auth()->user()->name }}</h6>
        @else
          <a href="{{ route('login') }}" data-mdb-ripple-init type="button" class="btn btn-link px-3 me-2">
            Login
          </a>
          <a href="{{ route('singup') }}" data-mdb-ripple-init type="button" class="btn btn-primary me-3">
            Sign up
          </a>
        @endif
      </div>
    </div>

    
    <div class="dropdown">
      <button class="btn-setting dropdown-toggle" id="btnSetting" aria-haspopup="true" aria-expanded="false" title="Pengaturan">
        <i class="fa-solid fa-gear"></i>
      </button>

        <ul class="setting-dropdown dropdown-menu dropdown-menu-end mt-2" id="settingDropdown" role="menu" aria-hidden="true">
          @if (Auth::check())
          <li><a class="dropdown-item" href="#"><i class="bi bi-person-circle me-2"></i> Profil</a></li>
          <li><a class="dropdown-item" href="#"><i class="bi bi-ticket-perforated me-2"></i> Tiket Saya</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item text-danger" href="{{ route('logout') }}"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
          @else
          <li><a class="dropdown-item" href="{{ route('index') }}"><i class="bi bi-person-circle me-2"></i> Home</a></li>
          @endif
        </ul>
      </div>
    </div>
  </div>

  <!-- spacer untuk mencegah page jump saat akun jadi fixed -->
  <div id="akunSpacer"></div>

  <!-- CAROUSEL / SLIDER (manual 5 item) -->
  <div class="carousel-wrapper" aria-label="Menu fitur">
    <button class="arrow-btn" id="btnLeft" aria-label="Sebelumnya">‹</button>

    <div class="carousel-container" role="region" aria-roledescription="carousel">
      <div class="carousel-track" id="track">

        <a class="menu-item" href="#cari_ticket">
          <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
          <span>Cari Ticket</span>
        </a>

        <a class="menu-item" href="#promosi">
          <i class="fa-solid fa-tag" aria-hidden="true"></i>
          <span>Promo</span>
        </a>

        <a class="menu-item" href="#">
          <i class="fa-solid fa-newspaper" aria-hidden="true"></i>
          <span>Berita</span>
        </a>

      </div>
    </div>

    <button class="arrow-btn" id="btnRight" aria-label="Berikutnya">›</button>
  </div>
</div>

<div class="ticket-modern-card" id="cari_ticket">
    
    <!-- Tabs -->
    <ul class="nav nav-pills modern-tabs mb-4" id="ticketTabs" role="tablist">
      <li class="nav-item">
        <a data-mdb-tab-init class="nav-link active" href="#tab1">Sekali Jalan</a>
      </li>
      <li class="nav-item">
        <a data-mdb-tab-init class="nav-link" href="#tab2">Pulang Pergi</a>
      </li>
      <li class="nav-item">
        <a data-mdb-tab-init class="nav-link" href="#tab3">Lintas Kota</a>
      </li>
    </ul>

    <div class="tab-content">
      <!-- Sekali Jalan -->
      <div class="tab-pane fade show active" id="tab1">
        <form class="row g-3 align-items-end" action="{{ route('ticket') }}" method="GET">
          <input type="hidden" name="ticket_type" value="sekali_jalan">
          <div class="col-md-4">
            <label for="departure_city_1" class="form-label">Dari</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
              <select class="form-select" name="departure_city" id="departure_city_1">
                <option value="">Pilih Kota Asal</option>
                @foreach($airports as $airport)
                <option value="{{ $airport->id }}">{{ $airport->country == 'Indonesia' ? '🇮🇩' : '🌍' }} {{ $airport->city }}, {{ $airport->country }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <label for="arrival_city_1" class="form-label">Ke</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-location-arrow"></i></span>
              <select class="form-select" name="arrival_city" id="arrival_city_1">
                <option value="">Pilih Kota Tujuan</option>
                @foreach($airports as $airport)
                <option value="{{ $airport->id }}">{{ $airport->country == 'Indonesia' ? '🇮🇩' : '🌍' }} {{ $airport->city }}, {{ $airport->country }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <label for="tgl_berangkat_1" class="form-label">Tanggal Berangkat</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
              <input class="form-control" id="tgl_berangkat_1" name="tgl_berangkat" type="date" placeholder="Tanggal Berangkat">
            </div>
          </div>
          <div class="col-12 text-end">
            <button type="submit" class="btn btn-primary px-4">
              <i class="fas fa-search"></i> Cari Tiket
            </button>
          </div>
        </form>
      </div>
      <!-- Pulang Pergi -->
      <div class="tab-pane fade" id="tab2">
        <form class="row g-3 align-items-end" action="{{ route('ticket') }}" method="GET">
          <input type="hidden" name="ticket_type" value="pulang_pergi">
          <div class="col-md-3">
            <label for="departure_city_2" class="form-label">Dari</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
              <select class="form-select" name="departure_city" id="departure_city_2">
                <option value="">Pilih Kota Asal</option>
                @foreach($airports as $airport)
                <option value="{{ $airport->id }}">{{ $airport->country == 'Indonesia' ? '🇮🇩' : '🌍' }} {{ $airport->city }}, {{ $airport->country }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <label for="arrival_city_2" class="form-label">Ke</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-location-arrow"></i></span>
              <select class="form-select" name="arrival_city" id="arrival_city_2">
                <option value="">Pilih Kota Tujuan</option>
                @foreach($airports as $airport)
                <option value="{{ $airport->id }}">{{ $airport->country == 'Indonesia' ? '🇮🇩' : '🌍' }} {{ $airport->city }}, {{ $airport->country }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <label for="tgl_berangkat_2" class="form-label">Tanggal Berangkat</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
              <input class="form-control" id="tgl_berangkat_2" name="tgl_berangkat" type="date" placeholder="Tanggal Berangkat">
            </div>
          </div>
          <div class="col-md-3">
            <label for="tgl_pulang_2" class="form-label">Tanggal Pulang</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
              <input class="form-control" id="tgl_pulang_2" name="tgl_pulang" type="date" placeholder="Tanggal Pulang">
            </div>
          </div>
          <div class="col-12 text-end">
            <button type="submit" class="btn btn-primary px-4">
              <i class="fas fa-search"></i> Cari Tiket
            </button>
          </div>
        </form>
      </div>
      <!-- Lintas Kota -->
      <div class="tab-pane fade" id="tab3">
        <form class="row g-3 align-items-end" action="{{ route('ticket') }}" method="GET">
          <input type="hidden" name="ticket_type" value="lintas_kota">
          <div class="col-md-8">
            <label for="rute_kota" class="form-label">Rute Kota</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-route"></i></span>
              <input class="form-control" id="rute_kota" name="rute_kota" type="text" placeholder="Contoh: Jakarta → Bandung → Surabaya">
            </div>
          </div>
          <div class="col-md-4">
            <label for="tgl_berangkat_3" class="form-label">Tanggal Berangkat</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
              <input class="form-control" id="tgl_berangkat_3" name="tgl_berangkat" type="date" placeholder="Tanggal Berangkat">
            </div>
          </div>
          <div class="col-12 text-end">
            <button type="submit" class="btn btn-primary px-4">
              <i class="fas fa-search"></i> Cari Tiket
            </button>
          </div>
        </form>
      </div>
    </div>

</div>

<!-- Pomasi -->
<!-- POPULAR COUNTRIES + PROMO TICKET SECTION -->
<section class="container mt-5">

  <!-- NEGARA POPULER -->
  <h3 class="promo-title mb-3">Negara Populer 🌍</h3>

  <div class="popular-grid">

    <div class="popular-card">
      <img src="{{ asset('img/licensed-image.jfif') }}" />
      <div class="popular-label">
        <h4>Jepang</h4>
        <p>1.2 Juta pengunjung</p>
      </div>
    </div>

    <div class="popular-card">
      <img src="{{ asset('img/licensed-image (1).jfif') }}" />
      <div class="popular-label">
        <h4>Singapura</h4>
        <p>980 Ribu pengunjung</p>
      </div>
    </div>

    <div class="popular-card">
      <img src="{{ asset('img/licensed-image (2).jfif') }}" />
      <div class="popular-label">
        <h4>Prancis</h4>
        <p>2.4 Juta pengunjung</p>
      </div>
    </div>

    <div class="popular-card">
      <img src="{{ asset('img/licensed-image (3).jfif') }}" />
      <div class="popular-label">
        <h4>Korea Selatan</h4>
        <p>1.8 Juta pengunjung</p>
      </div>
    </div>

  </div>

  <!-- PROMO TICKET -->
  <h3 class="promo-title mt-5 mb-3" id="promosi">Promo Tiket Terbaik ✈️</h3>
  <h4><a href="{{ route('ticket') }}">Lihat semua</a></h4>


  <!-- Tabs nav -->
  <ul class="nav nav-tabs mb-3" id="promoTab" role="tablist">
    <li class="nav-item"><a data-mdb-tab-init class="nav-link active" href="#promo-jakarta" role="tab">Jakarta</a></li>
    <li class="nav-item"><a data-mdb-tab-init class="nav-link" href="#promo-bali" role="tab">Bali</a></li>
    <li class="nav-item"><a data-mdb-tab-init class="nav-link" href="#promo-bandung" role="tab">Bandung</a></li>
    <li class="nav-item"><a data-mdb-tab-init class="nav-link" href="#promo-surabaya" role="tab">Surabaya</a></li>
  </ul>  

  <!-- Tabs Content -->
  <div class="tab-content">

    <!-- JAKARTA -->
    <div class="tab-pane fade show active" id="promo-jakarta" role="tabpanel">
      <div class="promo-grid limited-grid">

        <div class="promo-card">
          <img src="{{ asset('img/images.jpg') }}" />
          <div class="promo-body">
            <h4>Jakarta ➝ Bali</h4>
            <p>Mulai dari <span class="price">Rp 850.000</span></p>
            <button class="promo-btn">Lihat Promo</button>
          </div>
        </div>

        <div class="promo-card">
          <img src="{{ asset('img/images.jpg') }}" />
          <div class="promo-body">
            <h4>Jakarta ➝ Lombok</h4>
            <p>Mulai dari <span class="price">Rp 640.000</span></p>
            <button class="promo-btn">Lihat Promo</button>
          </div>
        </div>

        <div class="promo-card">
          <img src="{{ asset('img/images.jpg') }}" />
          <div class="promo-body">
            <h4>Jakarta ➝ Jepang</h4>
            <p>Mulai dari <span class="price">Rp 4.800.000</span></p>
            <button class="promo-btn">Lihat Promo</button>
          </div>
        </div>

        <div class="promo-card">
          <img src="{{ asset('img/images.jpg') }}" />
          <div class="promo-body">
            <h4>Jakarta ➝ Singapura</h4>
            <p>Mulai dari <span class="price">Rp 1.150.000</span></p>
            <button class="promo-btn">Lihat Promo</button>
          </div>
        </div>

        <div class="promo-card">
          <img src="{{ asset('img/images.jpg') }}" />
          <div class="promo-body">
            <h4>Jakarta ➝ Thailand</h4>
            <p>Mulai dari <span class="price">Rp 1.900.000</span></p>
            <button class="promo-btn">Lihat Promo</button>
          </div>
        </div>

      </div>
    </div>

    <!-- BALI -->
    <div class="tab-pane fade" id="promo-bali" role="tabpanel">
      <div class="promo-grid limited-grid">
        <div class="promo-card">
          <img src="{{ asset('img/images.jpg') }}" />
          <div class="promo-body">
            <h4>Bali ➝ Jakarta</h4>
            <p>Mulai dari <span class="price">Rp 870.000</span></p>
            <button class="promo-btn">Lihat Promo</button>
          </div>
        </div>

        <div class="promo-card">
          <img src="{{ asset('img/images.jpg') }}" />
          <div class="promo-body">
            <h4>Bali ➝ Bandung</h4>
            <p>Mulai dari <span class="price">Rp 950.000</span></p>
            <button class="promo-btn">Lihat Promo</button>
          </div>
        </div>

      </div>
    </div>

    <!-- BANDUNG -->
    <div class="tab-pane fade" id="promo-bandung" role="tabpanel">
      <div class="promo-grid limited-grid">

        <div class="promo-card">
          <img src="{{ asset('img/images.jpg') }}" />
          <div class="promo-body">
            <h4>Bandung ➝ Surabaya</h4>
            <p>Mulai dari <span class="price">Rp 560.000</span></p>
            <button class="promo-btn">Lihat Promo</button>
          </div>
        </div>

        <div class="promo-card">
          <img src="{{ asset('img/images.jpg') }}" />
          <div class="promo-body">
            <h4>Bandung ➝ Bali</h4>
            <p>Mulai dari <span class="price">Rp 990.000</span></p>
            <button class="promo-btn">Lihat Promo</button>
          </div>
        </div>

      </div>
    </div>

    <!-- SURABAYA -->
    <div class="tab-pane fade" id="promo-surabaya" role="tabpanel">
      <div class="promo-grid limited-grid">

        <div class="promo-card">
          <img src="{{ asset('img/images.jpg') }}" />
          <div class="promo-body">
            <h4>Surabaya ➝ Bali</h4>
            <p>Mulai dari <span class="price">Rp 450.000</span></p>
            <button class="promo-btn">Lihat Promo</button>
          </div>
        </div>

        <div class="promo-card">
          <img src="{{ asset('img/images.jpg') }}" />
          <div class="promo-body">
            <h4>Surabaya ➝ Jakarta</h4>
            <p>Mulai dari <span class="price">Rp 780.000</span></p>
            <button class="promo-btn">Lihat Promo</button>
          </div>
        </div>

      </div>
    </div>

  </div>

</section>

<div class="ticket-modern-card mt-5" id="berita">
  <h1>berita</h1>
  <div>
    <p>Ini adalah halaman berita.</p>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci nam fugiat amet incidunt molestias, beatae culpa minus ad magnam dolore dolor tenetur nemo alias ullam recusandae totam consectetur. Libero, repellat.</p>
</div>

@endsection

@push('script')
  
<script>
let current = 0;
const totalSlides = 3;
const track = document.getElementById("carouselTrack");

function updateCarousel() {
    track.style.transform = `translateX(-${current * 100}%)`;
}

// tombol kanan
function nextSlide() {
    current = (current + 1) % totalSlides;
    updateCarousel();
}

// tombol kiri
function prevSlide() {
    current = (current - 1 + totalSlides) % totalSlides;
    updateCarousel();
}

</script>

<script>
  (function(){
    // ----- Dropdown Setting -----
    const btnSetting = document.getElementById('btnSetting');
    const dropdown = document.getElementById('settingDropdown');

    function toggleDropdown(show){
      if(show){
        dropdown.style.display = 'block';
        dropdown.setAttribute('aria-hidden','false');
        btnSetting.setAttribute('aria-expanded','true');
      } else {
        dropdown.style.display = 'none';
        dropdown.setAttribute('aria-hidden','true');
        btnSetting.setAttribute('aria-expanded','false');
      }
    }

    btnSetting.addEventListener('click', function(e){
      e.stopPropagation();
      toggleDropdown(dropdown.style.display !== 'block');
    });

    document.addEventListener('click', function(){
      toggleDropdown(false);
    });

    // close dropdown on ESC
    document.addEventListener('keydown', function(e){
      if(e.key === 'Escape') toggleDropdown(false);
    });

    // ----- Carousel logic (3 visible, loop) -----
    const track = document.getElementById('track');
    const btnLeft = document.getElementById('btnLeft');
    const btnRight = document.getElementById('btnRight');
    const items = Array.from(track.querySelectorAll('.menu-item'));

    let index = 0;
    const visible = 3;
    let itemWidth = 0;
    const gap = 12; // must match CSS .carousel-track gap

    function calcItemWidth(){
      // computed width of an item (flex-basis)
      // get bounding of first item
      const r = items[0].getBoundingClientRect();
      itemWidth = Math.round(r.width + gap); // include gap
    }

    function move() {
      // clamp index in looping style: index is the leftmost visible item index
      // allowed indices: 0 .. items.length - visible
      const maxIndex = Math.max(0, items.length - visible);
      if(index > maxIndex) index = 0;
      if(index < 0) index = maxIndex;
      track.style.transform = `translateX(-${index * itemWidth}px)`;
    }

    btnRight.addEventListener('click', function(){
      index++;
      const maxIndex = Math.max(0, items.length - visible);
      if(index > maxIndex) index = 0;
      move();
    });

    btnLeft.addEventListener('click', function(){
      index--;
      const maxIndex = Math.max(0, items.length - visible);
      if(index < 0) index = maxIndex;
      move();
    });

    // recalc on load + resize
    window.addEventListener('load', function(){
      calcItemWidth();
      move(); // ensure initial pos
    });
    window.addEventListener('resize', function(){
      // small delay to allow layout to recalc
      setTimeout(function(){
        calcItemWidth();
        move();
      }, 60);
    });

    // allow clicking item to navigate (optional)
    items.forEach((it, idx) => {
      it.addEventListener('click', function(){
        // when clicked, treat it as selecting that item - center it if possible
        const maxIndex = Math.max(0, items.length - visible);
        // set index so that clicked item is the leftmost if possible,
        // or if it's near the end, show last page.
        let newIndex = Math.min(idx, maxIndex);
        index = newIndex;
        move();
        // optionally: perform action per item, e.g. navigate
        // const key = it.dataset.key; window.location.href = '/'+key;
      });
    });

    // ----- Sticky akun (Mode A: card-like, centered when fixed) -----
    const akun = document.getElementById('akunBox');
    const spacer = document.getElementById('akunSpacer');
    let akunTop = akun.getBoundingClientRect().top + window.scrollY;

    function updateAkunTop(){
      akunTop = akun.getBoundingClientRect().top + window.scrollY;
    }

    function onScrollAkun(){
      // add threshold margin so it's more natural
      const threshold = 8;
      if(window.scrollY > akunTop + threshold){
        if(!akun.classList.contains('navbar-fixed')){
          // set spacer height to original akun height to avoid layout jump
          spacer.style.display = 'block';
          spacer.style.height = akun.getBoundingClientRect().height + 'px';
          akun.classList.add('navbar-fixed');
        }
      } else {
        if(akun.classList.contains('navbar-fixed')){
          akun.classList.remove('navbar-fixed');
          spacer.style.display = 'none';
          spacer.style.height = '0px';
          // recalc posisi
          setTimeout(updateAkunTop, 20);
        }
      }
    }

    window.addEventListener('scroll', onScrollAkun);
    window.addEventListener('resize', function(){
      // when resize, recalc everything
      calcItemWidth();
      updateAkunTop();
      move();
    });

    // initial calc
    calcItemWidth();
    updateAkunTop();

    // safety: ensure dropdown closes if user scrolls
    window.addEventListener('scroll', function(){ toggleDropdown(false); });

  })();
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    
    function updateMinDates() {
        const today = new Date().toISOString().split("T")[0];

        const ids = [
            "tgl_berangkat_1",
            "tgl_berangkat_2",
            "tgl_pulang_2",
            "tgl_berangkat_3"
        ];

        ids.forEach(id => {
            const el = document.getElementById(id);
            if (el) el.setAttribute("min", today);
        });
    }

    updateMinDates();

    document.querySelectorAll('[data-mdb-tab-init]').forEach(tab => {
        tab.addEventListener("shown.bs.tab", function () {
            updateMinDates();
        });
    });

});
</script>



@endpush