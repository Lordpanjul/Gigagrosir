<!-- Navbar -->
<nav class="main-header navbar navbar-expand-md navbar-light" style="background-color: navajowhite;">
	<div class="container">
		<a href="<?= base_url() ?>" class="navbar-brand text-dark">
			<i class="fas fa-store text-dark"></i>
			<span class="brand-text font-weight-light text-dark"><b>GIGAGROSIR</b></span>
		</a>


		<button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse order-3" id="navbarCollapse">
			<!-- Left navbar links -->
			<ul class="navbar-nav">
				<li class="nav-item">
					<a href="<?= base_url() ?>" class="nav-link text-dark">Home</a>
				</li>
				<?php $kategori =  $this->m_home->get_all_data_kategori(); ?>
				<li class="nav-item dropdown">
					<a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle text-dark">Kategori</a>
					<ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
						<?php foreach ($kategori as $key => $value) { ?>
							<li><a href="<?= base_url('home/kategori/' . $value->id_kategori) ?>" class="dropdown-item"> <?= $value->nama_kategori ?></a></li>
						<?php } ?>


					</ul>
				</li>

				<li class="nav-item">
					<a href="#" class="nav-link text-dark" data-toggle="modal" data-target="#exampleModal">Contact</a>
				</li>

				
			</ul>


		</div>
					

					<!-- Right navbar links -->
		<ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
			<!-- Messages Dropdown Menu -->
			
				<?php if ($this->session->userdata('email') == "") { ?>
				<li class="nav-item dropdown">
					<a class="nav-link text-white" data-toggle="dropdown" href="">
					<span class="nav-brand text-dark">Login/Registrasi</span>
					</a>
				<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
						<a href="<?= base_url('auth/login_user') ?>" class="dropdown-item">
							<p>Admin</p>
						</a>
						<a href="<?= base_url('pelanggan/login') ?>" class="dropdown-item">
							<p>Pelanggan</p>
						</a>
				</div>
			</li>

				<?php } else { ?>
					<a class="nav-link" data-toggle="dropdown" href="#">
						<span class="brand-text text-dark"><?= $this->session->userdata('nama_pelanggan')  ?></span>
						<img src="<?= base_url('assets/foto/no-pic.png') ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
					</a>
					<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
						<div class="dropdown-divider"></div>
						<a href="<?= base_url('pelanggan/akun') ?>" class="dropdown-item ">
							<i class="fas fa-user mr-2"></i> Akun Saya
						</a>
						<div class="dropdown-divider"></div>
						<a href="<?= base_url('pesanan_saya') ?>" class="dropdown-item">
							<i class="fas fa-shopping-cart mr-2"></i>Pesanan Saya
						</a>
						<div class="dropdown-divider"></div>
						<a href="<?= base_url('pelanggan/logout')  ?>" class="dropdown-item dropdown-footer">Log Out</a>
					</div>
				<?php } ?>
			
			<?php
			$keranjang = $this->cart->contents();
			$jml_item = 0;
			foreach ($keranjang as $key => $value) {
				$jml_item = $jml_item + $value['qty'];
			}
			?>
			<li class="nav-item dropdown">
				<a class="nav-link text-dark" data-toggle="dropdown" href="">
					<i class="fas fa-shopping-cart"></i>
					<span class="badge badge-danger navbar-badge"><?= $jml_item ?></span>
				</a>
				<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
					<?php if (empty($keranjang)) { ?>
						<a href="#" class="dropdown-item">
							<p>Keranjang Belanja Kosong</p>
						</a>
						<?php } else {
						foreach ($keranjang as $key => $value) {
							$barang = $this->m_home->detail_barang($value['id']);
						?>
							<!-- barang start -->
							<a href="<?= base_url('belanja') ?>" class="dropdown-item">
								<div class="media">
									<img src="<?= base_url('assets/gambar/' . $barang->gambar) ?>" alt="User Avatar" class="img-size-50 mr-3">
									<div class="media-body">
										<h3 class="dropdown-item-title">
											<?= $value['name'] ?>
										</h3>
										<p class="text-sm"><?= $value['qty'] ?> x Rp.<?= number_format($value['price'], 0) ?></p>
										<p class="text-sm text-muted">
											<i class="fa fa-calculator"></i> Rp.<?= $this->cart->format_number($value['subtotal']); ?>
										</p>
									</div>
								</div>
							</a>
							<div class="dropdown-divider"></div>
						<?php } ?>
						<!-- barang End -->
						<a href="<?= base_url('belanja') ?>" class="dropdown-item">
							<div class="media">
								<div class="media-body">
									<tr>
										<td colspan="2"> </td>
										<td class="right"><strong>Total:</strong></td>
										<td class="right">Rp.<?= $this->cart->format_number($this->cart->total()); ?></td>
									</tr>
								</div>
							</div>
						</a>

						<div class="dropdown-divider"></div>
						<a href="<?= base_url('belanja') ?>" class="dropdown-item dropdown-footer">View Cart</a>
						<a href="<?= base_url('belanja/cekout')  ?>" class="dropdown-item dropdown-footer">Check Out</a>
					<?php } ?>

				</div>
			</li>
			<!-- Notifications Dropdown Menu -->


		</ul>
	</div>
</nav>
<!-- /.navbar -->


<!-- isikan Kontak disini -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Contact</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>WA    : 085</p>
		<p>EMAIL : panjul@gmail.com</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!--
<div class="content-wrapper
	<div class="content-header">
		<div class="container">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark"> <?= $title ?></h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="">GIGAGROSIR</a></li>
						<li class="breadcrumb-item"><a href=""><?= $title ?></a></li>
					</ol>
				</div>
			</div>
		</div>
	</div>
	-->

	<!-- Main content -->
	<div class="content">
		<div class="container">
