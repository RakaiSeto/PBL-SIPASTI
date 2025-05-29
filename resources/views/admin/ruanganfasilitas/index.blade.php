@extends('layouts.app')

@section('content')
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
	<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
	<div class="bg-white p-6 rounded shadow space-y-4">
		<!-- Filter & Pencarian -->
		<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
			<div class="flex gap-3 w-full md:w-auto">
				<!-- Filter Lokasi -->
				<div class="flex items-center gap-2">
					<label for="filterLokasi" class="text-sm font-medium text-slate-700">Filter :</label>
					<div class="relative group">
						<button id="dropdown-button"
							class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
							<span class="mr-2" id="selected-option">Pilih Ruangan</span>
							<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2 -mr-1" viewBox="0 0 20 20"
								fill="currentColor" aria-hidden="true">
								<path fill-rule="evenodd"
									d="M6.293 9.293a1 1 0 011.414 0L10 11.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
									clip-rule="evenodd" />
							</svg>
						</button>
						<div id="dropdown-menu"
							class="hidden absolute right-0 mt-2 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 p-1 space-y-1 z-50">
							<!-- Search input -->
							<input id="search-input"
								class="block w-full px-4 py-2 text-gray-800 border rounded-md  border-gray-300 focus:outline-none"
								type="text" placeholder="Search ruangan" autocomplete="off">
							<!-- Dropdown content goes here -->
							<option selected disabled value=""
								class="block px-4 py-2 bg-gray-100 cursor-pointer rounded-md">Pilih Ruangan</option>
							@foreach ($ruangan as $item)
								<option value="{{ $item->ruangan_id }}"
									class="block px-4 py-2 text-gray-700 hover:bg-gray-100 active:bg-blue-100 cursor-pointer rounded-md">
									{{ $item->ruangan_nama }} - Lantai {{ $item->lantai }}
								</option>
							@endforeach
						</div>
					</div>
				</div>
			</div>

			<!-- Tombol Tambah -->
			<button onclick="openModal('addModal')" class="btn-primary">
				Tambah Data
			</button>
		</div>

		<!-- TABEL -->
		<div class="overflow-auto rounded">
			<table id="tabelData" class="w-full text-left  border border-slate-200 rounded"
				style="border-collapse: separate; border-spacing: 0;">
				<thead class="bg-slate-100 text-slate-700 font-medium">
					<tr>
						<th class="p-3 w-10">No</th>
						<th class="p-3 w-10">Id</th>
						<th class="p-3 w-32">Nama Ruangan</th>
						<th class="p-3 w-32">Fasilitas</th>
						<th class="p-3 w-32">Lantai</th>
						<th class="p-3 w-28">Aksi</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>

	<!-- Modal Lihat Fasilitas -->
	<div id="fasilitasModal" class="fixed inset-0 z-50 bg-black/40 hidden justify-center items-center">
		<div class="bg-white w-full max-w-md p-6 rounded shadow space-y-4">
			<div class="flex justify-between items-center">
				<h2 class="text-lg font-semibold text-slate-700">Fasilitas Ruangan</h2>
				<button onclick="closeFasilitasModal()" class="text-slate-500 hover:text-red-500">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div id="fasilitasContent" class="text-sm text-slate-600 space-y-2">
			</div>
		</div>
	</div>

	<!-- MODAL TAMBAH -->
	<div id="addModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
		<div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
			<h2 class="text-2xl font-semibold mb-4">Tambah Ruang dan Fasilitas</h2>
			<form onsubmit="event.preventDefault(); closeModal('addModal'); showSuccess('Data berhasil ditambahkan!');">
				<div class="space-y-2 text-slate-900">
					<div>
						<label for="addRole" class="block mb-1 font-medium">Ruangan</label>
						<select id="addRole" class="w-full border-gray-200 px-3 py-2 rounded" required>
							<option value="" selected disabled>Pilih Ruangan</option>
							@foreach ($ruangan as $item)
								<option value="{{ $item->ruangan_id }}">{{ $item->ruangan_nama }} - Lantai {{ $item->lantai }}
								</option>
							@endforeach
						</select>
					</div>
				</div>

				{{-- resources/views/your-view.blade.php --}}

				<div class="space-y-2 text-slate-900">
					<label for="select-fasilitas" class="block mb-1 font-medium">Fasilitas</label>
					{{-- We will target this ID with JavaScript --}}
					<select id="select-fasilitas" name="fasilitas[]" multiple placeholder="Pilih Fasilitas..." autocomplete="off">
						{{-- The "Pilih Ruangan" is now a placeholder, not an option --}}
						@foreach ($fasilitas as $item)
							<option value="{{ $item->fasilitas_id }}">{{ $item->fasilitas_nama }}
							</option>
						@endforeach
					</select>
				</div>

				<div class="flex justify-end gap-2 mt-6">
					<button type="button" onclick="closeModal('addModal')"
						class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-sm">Batal</button>
					<button type="button" class="btn-primary" id="btnTambahRuanganFasilitas">Simpan</button>
				</div>
			</form>
			<button onclick="closeModal('addModal')"
				class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-lg">&times;</button>
		</div>
	</div>


	<!-- MODAL DETAIL -->
	<div id="detailModal"
		class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 hidden transition-opacity duration-300">
		<div
			class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-xl max-h-[90vh] overflow-y-auto transform transition-all duration-300 scale-95 flex flex-col justify-between">

			<!-- Header -->
			<div class="relative mb-6">
				<h2 class="text-2xl font-bold text-gray-800">Detail Laporan</h2>
				<button
					class="absolute right-0 top-0 text-gray-500 hover:text-red-500 text-xl font-semibold transition duration-200"
					onclick="closeModal('detailModal')">×</button>
			</div>

			<!-- Informasi Laporan -->
			<div class="flex-1">
				<div class="grid grid-cols-1 md:grid-cols-[auto,1fr] gap-4">
					<div class="w-48 aspect-[3/4] overflow-hidden rounded">
						<img src="{{ asset('assets/image/10.jpg') }}" alt="Foto" class="w-full h-full object-cover">
					</div>
					<div class="space-y-3">
						<div>
							<h4 class="text-base font-medium text-gray-500">Nama Lengkap</h4>
							<p class="text-lg text-gray-800">Agung Fradiansyah</p>
						</div>
						<div>
							<h4 class="text-sm font-medium text-gray-500">Username</h4>
							<p class="text-lg text-gray-800">agungAdmin</p>
						</div>
						<div>
							<h4 class="text-sm font-medium text-gray-500">Role</h4>
							<p class="text-lg text-gray-800">Admin</p>
						</div>
						<div>
							<h4 class="text-sm font-medium text-gray-500">Email</h4>
							<p class="text-lg text-gray-800">agung@gmail.com</p>
						</div>
					</div>
				</div>
			</div>

			<!-- Tombol Aksi -->
			<div class="flex justify-end gap-2 mt-6">
				<button type="button" onclick="closeModal('detailModal')"
					class="px-4 py-2 bg-blue-800 text-white rounded hover:bg-blue-700 text-sm">Tutup</button>
			</div>

		</div>
	</div>


	<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
		<div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
			<h2 class="text-2xl font-semibold mb-4">Edit Pengguna</h2>

			<form onsubmit="event.preventDefault(); closeModal('editModal'); showSuccess('Data berhasil diubah!'); ">
				<div class="space-y-2 text-slate-800">
					<div>
						<label class="block mb-1 font-medium text-sm">Nama Lengkap</label>
						<input type="text" class="w-full border-gray-200 text-sm  rounded"
							placeholder="Masukkan Nama Lengkap" required>
					</div>
					<div>
						<label class="block mb-1 font-medium text-sm">Username</label>
						<input type="text" class="w-full border-gray-200 text-sm rounded" placeholder="Masukkan Username">
					</div>
					<div>
						<label class="block mb-1 font-medium text-sm">Email</label>
						<input type="email" class="w-full border-gray-200 text-sm rounded" placeholder="Masukkan Email"
							required>
					</div>
					<div>
						<label class="block mb-1 font-medium text-sm">Role</label>
						<select class="w-full border-gray-200 px-2 py-2 text-sm rounded" required>
							<option value="">Pilih Role</option>
							<option value="Admin">Admin</option>
							<option value="Sarpras">Sarpras</option>
							<option value="Civitas">Civitas</option>
							<option value="Teknisi">Teknisi</option>
						</select>
					</div>
				</div>

				<div class="flex justify-end gap-2 mt-6">
					<button type="button" onclick="closeModal('editModal')"
						class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-sm">Batal</button>
					<button type="submit"
						class="px-4 py-2 bg-blue-800 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
				</div>
			</form>

			<button onclick="closeModal('editModal')"
				class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-lg">&times;</button>
		</div>
	</div>
	@include('component.popsukses')

	<!--modalhapus-->
	<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
		<div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
			<h2 class="text-xl font-semibold text-slate-800 mb-4">Konfirmasi Hapus</h2>
			<p class="text-sm text-slate-600 mb-4">Apakah Anda yakin ingin menghapus pengguna berikut ini?</p>

			<div class="text-sm text-slate-700 space-y-2 mb-5">
				<div><span class="font-medium">Nama Lengkap:</span> <span id="delNama"></span></div>
				<div><span class="font-medium">Username:</span> <span id="delUsername"></span></div>
				<div><span class="font-medium">Role:</span> <span id="delRole"></span></div>
				<div><span class="font-medium">Email:</span> <span id="delEmail"></span></div>
			</div>
			<div class="flex justify-end gap-2 mt-6">
				<button type="button" onclick="closeModal('deleteModal')"
					class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-sm">Batal</button>
				<button type="button" onclick="closeModal('deleteModal'); showDelete('deleteSuccess');"
					class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm">Hapus</button>
			</div>
			<button onclick="closeModal('deleteModal')"
				class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-lg">&times;</button>
		</div>
	</div>
	@include('component.pophapus')
	<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
	<script>
		document.addEventListener('DOMContentLoaded', () => {
			new TomSelect('#select-fasilitas', {
				plugins: ['remove_button'],
			});
		});
	</script>
	<script>
		document.getElementById('select-fasilitas').addEventListener('change', () => {
			let dataArr = [];
			for (let i = 0; i < document.getElementById('select-fasilitas').options.length; i++) {
				if (document.getElementById('select-fasilitas').options[i].selected) {
					dataArr.push(document.getElementById('select-fasilitas').options[i].value);
				}
			}
		});
		document.getElementById('btnTambahRuanganFasilitas').addEventListener('click', () => {
			const ruanganId = document.getElementById('addRole').value;
			let dataArr = [];
			for (let i = 0; i < document.getElementById('select-fasilitas').options.length; i++) {
				if (document.getElementById('select-fasilitas').options[i].selected) {
					dataArr.push(document.getElementById('select-fasilitas').options[i].value);
				}
			}
			$.ajax({
				url: '{{ url("/api/kelola-fasilitas-ruang/create") }}',
				type: 'POST',
				data: {
					ruangan_id: ruanganId,	
					fasilitas_id: dataArr
				},
				success: function(response) {
					closeModal('addModal');
					showSuccess('Data berhasil ditambahkan!');
					table.ajax.reload();
				},
				error: function(xhr, status, error) {
					showError('Data gagal ditambahkan!');
				}
			});
		});
	</script>
	<script>
		var table;
		const dropdownButton = document.getElementById('dropdown-button');
		const dropdownMenu = document.getElementById('dropdown-menu');
		const searchInput = document.getElementById('search-input');
		const itemRuanganFilter = dropdownMenu.querySelectorAll('option');
		const selectedOption = document.getElementById('selected-option');
		let isOpen = false; // Set to true to open the dropdown by default

		// Function to toggle the dropdown state
		function toggleDropdown() {
			isOpen = !isOpen;
			searchInput.value = '';
			searchInput.dispatchEvent(new Event('input'));
			dropdownMenu.classList.toggle('hidden', !isOpen);
		}

		dropdownButton.addEventListener('click', () => {
			toggleDropdown();
		});

		searchInput.addEventListener('input', () => {
			const searchTerm = searchInput.value.toLowerCase();

			itemRuanganFilter.forEach((item) => {
				const text = item.textContent.toLowerCase();
				if (text.includes(searchTerm)) {
					item.style.display = 'block';
				} else {
					item.style.display = 'none';
				}
			});
		});

		$(document).ready(function () {
			table = $('#tabelData').DataTable({
				processing: true,
				serverSide: true,
				searching: false,
				ajax: {
					url: '{{ url("/api/kelola-fasilitas-ruang") }}',
					type: 'POST',
					data: function (d) {
						d.ruangan_id = $('#selected-option').val();
						d.search = $('#search-input').val();
					},
				},
				columns: [
					{
						data: null,
						name: 'no',
						render: function (data, type, row, meta) {
							return meta.row + meta.settings._iDisplayStart + 1;
						}
					},
					{ data: 'fasilitas_ruang_id', name: 'fasilitas_ruang_id', searchable: true },
					{ data: 'ruangan.ruangan_nama', name: 'ruangan_nama' },
					{ data: 'fasilitas.fasilitas_nama', name: 'fasilitas_nama', searchable: true },
					{ data: 'ruangan.lantai', name: 'ruangan_lantai' },
					{ data: 'action', name: 'action', searchable: true },
				]
			});
		});

		itemRuanganFilter.forEach((item) => {
			item.addEventListener('click', () => {
				selectedOption.textContent = item.textContent;
				selectedOption.value = item.value;
				toggleDropdown();
				table.ajax.reload();
			});
		});

		function openModal(id) {
			document.getElementById(id).classList.remove('hidden');
		}

		function closeModal(id) {
			document.getElementById(id).classList.add('hidden');
		}

		function openDetail() {
			openModal('detailModal');
		}


		function openFasilitas() {
			openModal('detailModal');
		}
		function openModal(id) {
			document.getElementById(id).classList.remove('hidden');
		}

		function closeModal(id) {
			document.getElementById(id).classList.add('hidden');
		}

		function openEdit() {
			openModal('editModal');
		}

		function openDelete() {
			openModal('deleteModal');
		}

		$(document).ready(function () {
			$('#addFasilitas').select2({
				placeholder: "Pilih Fasilitas",
				width: '100%',
				allowClear: true
			});
		});

	</script>
@endsection