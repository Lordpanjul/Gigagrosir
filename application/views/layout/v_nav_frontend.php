<!-- Navbar -->
<nav class="main-header navbar navbar-expand-md navbar-light" style="background-color: navajowhite;">
    <div class="container">
        <a href="<?= base_url() ?>" class="navbar-brand text-dark">
            <i class="fas fa-store"></i>
            <span class="brand-text font-weight-bold">GIGAGROSIR</span>
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Semua menu di sebelah kanan -->
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="<?= base_url() ?>" class="nav-link text-dark">Home</a>
                </li>
                <?php $kategori = $this->m_home->get_all_data_kategori(); ?>
                <li class="nav-item dropdown">
                    <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle text-dark">Kategori</a>
                    <ul class="dropdown-menu border-0 shadow">
                        <?php foreach ($kategori as $key => $value) { ?>
                            <li><a href="<?= base_url('home/kategori/' . $value->id_kategori) ?>" class="dropdown-item"><?= $value->nama_kategori ?></a></li>
                        <?php } ?>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-dark" data-toggle="modal" data-target="#exampleModal">Contact</a>
                </li>

                <!-- Login / Akun -->
                <?php if ($this->session->userdata('email') == "") { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-dark" data-toggle="dropdown" href="#">Login/Registrasi</a>
                        <div class="dropdown-menu">
                            <a href="<?= base_url('auth/login_user') ?>" class="dropdown-item">Admin</a>
                            <a href="<?= base_url('pelanggan/login') ?>" class="dropdown-item">Pelanggan</a>
                        </div>
                    </li>
                <?php } else { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-dark d-flex align-items-center" data-toggle="dropdown" href="#">
                            <img src="<?= base_url('assets/foto/no-pic.png') ?>" class="rounded-circle mr-2" style="width: 30px; height: 30px;">
                            <?= $this->session->userdata('nama_pelanggan') ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="<?= base_url('pelanggan/akun') ?>" class="dropdown-item"><i class="fas fa-user mr-2"></i> Akun Saya</a>
                            <a href="<?= base_url('pesanan_saya') ?>" class="dropdown-item"><i class="fas fa-shopping-cart mr-2"></i> Pesanan Saya</a>
                            <div class="dropdown-divider"></div>
                            <a href="<?= base_url('pelanggan/logout') ?>" class="dropdown-item text-danger">Log Out</a>
                        </div>
                    </li>
                <?php } ?>

                <!-- Keranjang -->
                <?php
                    $keranjang = $this->cart->contents();
                    $jml_item = 0;
                    foreach ($keranjang as $key => $value) {
                        $jml_item += $value['qty'];
                    }
                ?>
                <li class="nav-item dropdown">
                    <a class="nav-link text-dark" data-toggle="dropdown" href="#">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="badge badge-warning navbar-badge"><?= $jml_item ?></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <?php if (empty($keranjang)) { ?>
                            <a href="#" class="dropdown-item">Keranjang Belanja Kosong</a>
                        <?php } else {
                            foreach ($keranjang as $key => $value) {
                                $barang = $this->m_home->detail_barang($value['id']);
                        ?>
                            <a href="<?= base_url('belanja') ?>" class="dropdown-item">
                                <div class="media">
                                    <img src="<?= base_url('assets/gambar/' . $barang->gambar) ?>" class="img-size-50 mr-3">
                                    <div class="media-body">
                                        <h3 class="dropdown-item-title"><?= $value['name'] ?></h3>
                                        <p class="text-sm"><?= $value['qty'] ?> x Rp.<?= number_format($value['price'], 0) ?></p>
                                        <p class="text-sm text-muted"><i class="fa fa-calculator"></i> Rp.<?= $this->cart->format_number($value['subtotal']) ?></p>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                        <?php } ?>
                            <a href="<?= base_url('belanja') ?>" class="dropdown-item"><strong>Total:</strong> Rp.<?= $this->cart->format_number($this->cart->total()) ?></a>
                            <div class="dropdown-divider"></div>
                            <a href="<?= base_url('belanja') ?>" class="dropdown-item dropdown-footer">View Cart</a>
                            <a href="<?= base_url('belanja/cekout') ?>" class="dropdown-item dropdown-footer">Check Out</a>
                        <?php } ?>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
