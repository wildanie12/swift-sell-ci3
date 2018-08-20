	<?php 
		foreach ($filter as $item => $value) {
	?>
	<tr style="border: 0">
		<th style="width: 250px" colspan="3"><?=$item?></th>
		<td colspan="5">: <?=$value?></td>
	</tr>
	<?php
		}
	?>
	<tr>
		<th>No</th>
		<th>Nomor<br/> Faktur</th>
		<th>Tanggal Faktur</th>
		<th>Supplier</th>
		<th>Jumlah <br/>Barang</th>
		<th>Jumlah <br/>Stok</th>
		<th>Jenis<br/> Pembayaran</th>
		<th class="text-right" style="min-width: 150px">Harga Beli</th>
		<th class="d-print-none"></th>
	</tr>
	<?php 
		$no = 0 + $offset;
		$total_harga_beli = 0;
		foreach ($data_filtered as $transaksi) {
			$total_harga_beli += $transaksi->harga_beli;
			$supplier = $this->SupplierModel->single($transaksi->supplier_id, 'OBJECT');

			// Data Stok
			$this->db->where('transaksi_id', $transaksi->id);
			$data_stok = $this->StokModel->show(0, 0, 'OBJECT');
			$this->db->reset_query();
			$total_stok = 0;
			$total_barang = 0;
			$barang_id = -1;
			foreach ($data_stok as $stok) {
				$total_stok += $stok->stok;
				if ($barang_id != $stok->barang_id) {
					$total_barang++;
					$barang_id = $stok->barang_id;
				}
			}
			$no++;
	?>
	<tr class="clickable-tr">
		<td style="max-width: 10px"><?=$no?></td>
		<td><?=$transaksi->no_faktur?></td>
		<td><?=date('d-m-Y', strtotime($transaksi->tanggal_faktur))?></td>
		<td><?=$supplier->nama?></td>
		<td><?=$total_barang?></td>
		<td><?=$total_stok?></td>
		<td><?=($transaksi->jenis_pembayaran == 'kredit')?'kredit <br/>(Jatuh tempo: '.date('d F Y', strtotime($transaksi->jatuh_tempo)).')': $transaksi->jenis_pembayaran?></td>
		<td class="text-right">Rp. <?=number_format($transaksi->harga_beli, 0, '', '.')?>,-</td>
		<td class="d-print-none">
			<a href="#" class="content-view-transaksi btn btn-icon-only rounded-circle" data-selesai="<?=(($transaksi->kredit_selesai == 0) ? (($transaksi->jenis_pembayaran == 'kredit' || $transaksi->jenis_pembayaran == 'konsinyasi') ? 'Ya' : 'Tidak') : 'Tidak')?>" data-id="<?=$transaksi->id?>" data-toggle='tooltip' title="Klik untuk lihat rincian transaksi">
				<i class="fas fa-eye"></i>
			</a> 
			<a href="#" class="content-delete btn btn-sm btn-icon-only btn-danger rounded-circle" data-id="<?=$transaksi->id?>" data-toggle='tooltip' title="Hapus Transaksi">
				<i class="fas fa-times"></i>
			</a>
		</td>
	</tr>
	<?php
		}
	?>
	<tr>
		<td colspan="7" class="text-right font-weight-bold">Total</td>
		<td class="text-right font-weight-bold">Rp. <?=((is_numeric($total_harga_beli))? number_format($total_harga_beli, 0, '', '.') : '')?>,-</td>
	</tr>
	<?php 
		if ($no <= 0) {
	?>
	<tr>
		<td colspan="8" class="text-center">
			<span style="font-style: italic; color: darkgrey">Tidak ada data</span>
		</td>
	</tr>
	<?php
		}
	?>
