<div class="col-md-12">
	<div class="card card-primary">
		<div class="card-header">
			<h3 class="card-title">Form Tambah Barang</h3>
		</div>

		<div class="card-body">
			<?php
			// Notif validasi
			echo validation_errors('<div class="alert alert-danger alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<h5><i class="icon fas fa-info"></i>', '</h5> </div>');

			// Notif upload gagal
			if (isset($error_upload)) {
				echo '<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<h5><i class="icon fas fa-info"></i>' . $error_upload . '</h5> </div>';
			}

			echo form_open_multipart('barang/add') ?>
			<div class="form-group">
				<label>Nama Barang</label>
				<input name="nama_barang" class="form-control" placeholder="Nama Barang" value="<?= set_value('nama_barang') ?>">
			</div>

			<div class="row">
				<div class="col-sm-3">
					<div class="form-group">
						<label>Kategori</label>
						<select name="id_kategori" class="form-control">
							<option value="">-- Pilih Kategori --</option>
							<?php foreach ($kategori as $key => $value) { ?>
								<option value="<?= $value->id_kategori ?>" <?= set_select('id_kategori', $value->id_kategori) ?>>
									<?= $value->nama_kategori ?>
								</option>
							<?php } ?>
						</select>
					</div>
				</div>

				<div class="col-sm-3">
					<div class="form-group">
						<label>Harga</label>
						<input type="number" name="harga" class="form-control" placeholder="Harga Barang" value="<?= set_value('harga') ?>">
					</div>
				</div>

				<div class="col-sm-3">
					<div class="form-group">
						<label>Berat (Gram)</label>
						<input type="number" name="berat" min="0" class="form-control" placeholder="Berat Barang (Gr)" value="<?= set_value('berat') ?>">
					</div>
				</div>

				<div class="col-sm-3">
					<div class="form-group">
						<label>MOQ</label>
						<input type="number" name="moq" min="1" class="form-control" placeholder="Contoh: 10" value="<?= set_value('moq') ?>">
					</div>
				</div>
			</div>

			<div class="form-group">
				<label>Deskripsi Barang</label>
				<textarea name="deskripsi" class="form-control" rows="5" placeholder="Deskripsi..."><?= set_value('deskripsi') ?></textarea>
			</div>

			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label>Gambar</label>
						<input type="file" name="gambar" class="form-control" id="preview_gambar" accept="image/*">
					</div>
				</div>

				<div class="col-sm-6 text-center">
					<div class="form-group">
						<label>Preview</label><br>
						<img src="<?= base_url('assets/gambar/nofoto.jpg') ?>" id="gambar_load" width="300px" class="img-thumbnail">
					</div>
				</div>
			</div>

			<div class="form-group text-right">
				<a href="<?= base_url('barang') ?>" class="btn btn-secondary btn-sm">Kembali</a>
				<button type="submit" class="btn btn-primary btn-sm">Simpan</button>
			</div>
			<?php echo form_close() ?>
		</div>
	</div>
</div>

<script>
	function bacaGambar(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#gambar_load').attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

	$("#preview_gambar").change(function() {
		bacaGambar(this);
	});
</script>
