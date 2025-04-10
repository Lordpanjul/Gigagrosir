<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Belanja extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_transaksi');
	}

	public function index()
	{
		if (empty($this->cart->contents())) {
			redirect('home');
		}
		$data = array(
			'title' => 'Keranjang Belanja',
			'isi' => 'v_belanja',
		);
		$this->load->view('layout/v_wrapper_frontend', $data, FALSE);
	}

	public function add()
	{
		$redirect_page = $this->input->post('redirect_page');
		$data = array(
			'id'    => $this->input->post('id'),
			'qty'   => $this->input->post('qty'),
			'price' => $this->input->post('price'),
			'name'  => $this->input->post('name'),
		);
		$this->cart->insert($data);
		redirect($redirect_page, 'refresh');
	}

	public function delete($rowid)
	{
		$this->cart->remove($rowid);
		redirect('belanja');
	}

	public function update()
	{
		$i = 1;
		foreach ($this->cart->contents() as  $items) {
			$data = array(
				'rowid' => $items['rowid'],
				'qty'   => $this->input->post($i . '[qty]'),
			);
			$this->cart->update($data);
			$i++;
		}
		$this->session->set_flashdata('pesan', 'Keranjang Berhasil Di Update !!!');
		redirect('belanja');
	}

	public function clear()
	{
		$this->cart->destroy();
		redirect('belanja');
	}

	public function cekout()
{
	$this->pelanggan_login->proteksi_halaman();

	$this->form_validation->set_rules('alamat', 'Alamat', 'required');
	$this->form_validation->set_rules('kode_pos', 'Kode POS', 'required');
	$this->form_validation->set_rules('nama_penerima', 'Nama Penerima', 'required');
	$this->form_validation->set_rules('hp_penerima', 'HP Penerima', 'required');

	if ($this->form_validation->run() == FALSE) {
		$data = array(
			'title' => 'Cek Out Belanja',
			'isi' => 'v_cekout',
		);
		$this->load->view('layout/v_wrapper_frontend', $data, FALSE);
	} else {
		// Validasi MOQ sebelum simpan
		foreach ($this->cart->contents() as $item) {
			$this->db->where('id_barang', $item['id']);
			$query = $this->db->get('tbl_barang')->row();
			if ($item['qty'] < $query->moq) {
				$this->session->set_flashdata('pesan', 'Minimal pembelian untuk produk ' . $query->nama_barang . ' adalah ' . $query->moq . ' pcs.');
				redirect('belanja');
			}
		}

		// Data transaksi
		$data = array(
			'id_pelanggan'   => $this->session->userdata('id_pelanggan'),
			'no_order'       => $this->input->post('no_order'),
			'tgl_order'      => date('Y-m-d'),
			'nama_penerima'  => $this->input->post('nama_penerima'),
			'hp_penerima'    => $this->input->post('hp_penerima'),
			'provinsi'       => '-',
			'kota'           => '-',
			'alamat'         => $this->input->post('alamat'),
			'kode_pos'       => $this->input->post('kode_pos'),
			'expedisi'       => 'Kurir Toko',
			'paket'          => 'Reguler',
			'estimasi'       => $this->input->post('estimasi'),
			'ongkir'         => $this->input->post('ongkir'),
			'berat'          => $this->input->post('berat'),
			'grand_total'    => $this->input->post('grand_total'),
			'total_bayar'    => $this->input->post('total_bayar'),
			'status_bayar'   => '0',
			'status_order'   => '0',
		);
		$this->m_transaksi->simpan_transaksi($data);

		// Simpan rincian produk
		$i = 1;
		foreach ($this->cart->contents() as $item) {
			$data_rinci = array(
				'no_order'  => $this->input->post('no_order'),
				'id_barang' => $item['id'],
				'qty'       => $this->input->post('qty' . $i++),
			);
			$this->m_transaksi->simpan_rinci_transaksi($data_rinci);
		}

		$this->session->set_flashdata('pesan', 'Pesanan Berhasil Di Proses !!!');
		$this->cart->destroy();
		redirect('pesanan_saya');
	}
}

}
