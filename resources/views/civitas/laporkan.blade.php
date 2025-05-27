@extends('layouts.app')

@section('content')
<div class="mx-auto bg-white p-4 rounded shadow-lg">
  <h1 class="text-3xl font-bold text-gray-800 mb-6">Form Pelaporan Kerusakan</h1>

  <form id="formPelaporan" class="space-y-6">
    <!-- Ruang -->
    <div>
      <label class="block mb-1 text-sm font-medium text-gray-700">Lantai</label>
      <select class="w-full border border-gray-300 rounded-lg bg-white p-3 focus:ring-2 focus:ring-blue-500" required>
        <option value="RT001">01</option>
      </select>
    </div>


    <!-- Ruang -->
    <div>
      <label class="block mb-1 text-sm font-medium text-gray-700">Ruang</label>
      <select class="w-full border border-gray-300 rounded-lg bg-white p-3 focus:ring-2 focus:ring-blue-500" required>
        <option value="RT001">RT001</option>
      </select>
    </div>

    <!-- Fasilitas -->
    <div>
      <label class="block mb-1 text-sm font-medium text-gray-700">Fasilitas</label>
      <select id="fasilitasSelect" class="w-full border border-gray-300 rounded-lg p-3 bg-white focus:ring-2 focus:ring-blue-500" required>
        <option value="">-- Pilih Fasilitas --</option>
        <option value="Proyektor">Proyektor</option>
        <option value="Komputer">Komputer</option>
        <option value="AC">AC</option>
      </select>
    </div>

    <!-- Tanggal -->
    <div>
      <label class="block mb-1 text-sm font-medium text-gray-700">Tanggal Pelaporan</label>
      <input type="date" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500" required>
    </div>

    <!-- Deskripsi -->
    <div>
      <label class="block mb-1 text-sm font-medium text-gray-700">Deskripsi Kerusakan</label>
      <textarea maxlength="500" rows="4" placeholder="Contoh: Tidak menyala saat dinyalakan..."
        class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 resize-none" required></textarea>
    </div>

    <!-- Unggah Foto -->
    <div>
      <label class="block mb-1 text-sm font-medium text-gray-700">Unggah Foto (JPG/PNG, maks. 2MB)</label>
      <input id="fotoInput" type="file" accept=".jpg,.jpeg,.png"
        class="w-full border border-gray-300 rounded-lg p-3 bg-white text-gray-700 cursor-pointer" required>
    </div>

    <!-- Tombol Aksi -->
    <div class="flex justify-end gap-4 pt-4">
      <button type="reset"
        class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold px-5 py-2 rounded-lg shadow-sm transition duration-200">
        Batal
      </button>
      <button type="submit"
        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg shadow-md transition duration-200">
        Kirim
      </button>
    </div>
  </form>
</div>

<script>
  document.getElementById("formPelaporan").addEventListener("submit", function(e) {
    e.preventDefault();

    const file = document.getElementById("fotoInput").files[0];

    if (file && file.size > 2 * 1024 * 1024) {
      alert("Ukuran foto maksimal 2MB");
      return;
    }

    alert("Laporan terkirim");
    window.location.href = "/laporkan-kerusakan"; // Ganti dengan route Laravel kamu
  });
</script>
@endsection
