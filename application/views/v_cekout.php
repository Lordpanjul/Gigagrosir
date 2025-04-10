<!-- Main content -->
<div class="invoice p-3 mb-3">
	<!-- title row -->
	<div class="row">
		<div class="col-12">
			<h4>
				<i class="fas fa-shopping-cart"></i> Checkout.
				<small class="float-right">Date: <?= date('d-m-Y') ?></small>
			</h4>
		</div>
	</div>

	<!-- Table row -->
	<div class="row">
		<div class="col-12 table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Qty</th>
						<th width="150px" class="text-center">Harga</th>
						<th>Produk</th>
						<th class="text-center">Subtotal</th>
						<th class="text-center">Berat</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$tot_berat = 0;
					foreach ($this->cart->contents() as $items) {
						$barang = $this->m_home->detail_barang($items['id']);
						$berat = $items['qty'] * $barang->berat;
						$tot_berat += $berat;
					?>
						<tr>
							<td><?= $items['qty']; ?></td>
							<td class="text-center">Rp. <?= number_format($items['price'], 0); ?></td>
							<td><?= $items['name']; ?></td>
							<td class="text-center">Rp. <?= number_format($items['subtotal'], 0); ?></td>
							<td class="text-center"><?= $berat ?> gr</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>

	<?php
	echo validation_errors('<div class="alert alert-danger alert-dismissible">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
	echo form_open('belanja/cekout');
	$no_order = date('Ymd') . strtoupper(random_string('alnum', 8));
	?>

	<div class="row">
		<div class="col-sm-8">
			<h5>Tujuan Pengiriman</h5>
			<div class="form-group">
				<label>Alamat Lengkap</label>
				<input name="alamat" class="form-control" required>
			</div>
			<div class="form-group">
				<label>Kode POS</label>
				<input name="kode_pos" class="form-control" required>
			</div>
			<div class="form-group">
				<label>Nama Penerima</label>
				<input name="nama_penerima" class="form-control" required>
			</div>
			<div class="form-group">
				<label>No. HP Penerima</label>
				<input name="hp_penerima" class="form-control" required>
			</div>
		</div>

		<div class="col-4">
			<h5>Ringkasan Pembayaran</h5>
			<div class="table-responsive">
				<table class="table">
					<tr>
						<th>Grand Total:</th>
						<th>Rp. <?= number_format($this->cart->total(), 0) ?></th>
					</tr>
					<tr>
						<th>Berat:</th>
						<th><?= $tot_berat ?> gr</th>
					</tr>
					<tr>
						<th>Ongkir:</th>
						<th>Rp. <?= number_format(10000, 0) ?></th>
					</tr>
					<tr>
						<th>Total Bayar:</th>
						<th>Rp. <?= number_format($this->cart->total() + 10000, 0) ?></th>
					</tr>
				</table>
			</div>
		</div>
	</div>

	<!-- Data yang akan dikirim ke controller -->
	<input type="hidden" name="no_order" value="<?= $no_order ?>">
	<input type="hidden" name="estimasi" value="2-3 Hari">
	<input type="hidden" name="ongkir" value="10000">
	<input type="hidden" name="berat" value="<?= $tot_berat ?>">
	<input type="hidden" name="grand_total" value="<?= $this->cart->total() ?>">
	<input type="hidden" name="total_bayar" value="<?= $this->cart->total() + 10000 ?>">

	<?php
	$i = 1;
	foreach ($this->cart->contents() as $items) {
		echo form_hidden('qty' . $i++, $items['qty']);
	}
	?>

	<div class="row no-print">
		<div class="col-12">
			<a href="<?= base_url('belanja') ?>" class="btn btn-warning"><i class="fas fa-backward"></i> Kembali Ke Keranjang</a>
			<button type="submit" class="btn btn-primary float-right"><i class="fas fa-shopping-cart"></i> Proses Checkout</button>
		</div>
	</div>
	<?= form_close(); ?>
</div>
