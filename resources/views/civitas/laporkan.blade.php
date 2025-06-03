<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@extends('layouts.app')

@section('content')
    <div class="mx-auto bg-white p-4 rounded shadow-lg">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Form Pelaporan Kerusakan</h1>

        <form id="formPelaporan" class="space-y-4">
            <!-- Ruang -->
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Lantai</label>
                <select id="lantaiSelect"
                    class="w-full border border-gray-300 rounded bg-white p-3 focus:ring-2 focus:ring-blue-900" required
                    onchange="showRuang()">
                    <option value="" selected disabled>-- Pilih Lantai --</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                </select>
            </div>


            <!-- Ruang -->
            <div class="hidden" id="div-ruang">
                <label class="block mb-1 text-sm font-medium text-gray-700">Ruang</label>
                <select id="ruangSelect"
                    class="w-full border border-gray-300 rounded bg-white p-3 focus:ring-2 focus:ring-blue-900" required
                    onchange="showFasilitas()">
                    <option value="" selected disabled id="ruang-placeholder">-- Pilih Ruang --</option>
                    @foreach ($ruang as $r)
                        <option data-lantai="{{ $r->lantai }}" value="{{ $r->ruangan_id }}">{{ $r->ruangan_nama }} -
                            {{ $r->lantai }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Fasilitas -->
            <div class="hidden" id="div-fasilitas">
                <label class="block mb-1 text-sm font-medium text-gray-700">Fasilitas</label>
                <select id="fasilitasSelect"
                    class="w-full border border-gray-300 rounded p-3 bg-white focus:ring-2 focus:ring-blue-900" required>
                    <option value="" selected disabled id="fasilitas-placeholder">-- Pilih Fasilitas --</option>
                    @foreach ($fasilitas as $f)
                        <option data-ruang="{{ $f->ruangan_id }}" value="{{ $f->fasilitas_ruang_id }}">
                            {{ $f->fasilitas->fasilitas_nama }} - {{ $f->ruangan->ruangan_nama }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Deskripsi Kerusakan</label>
                <textarea maxlength="500" rows="4" id="deskripsiInput" placeholder="Contoh: Tidak menyala saat dinyalakan..."
                    class="w-full border border-gray-300 rounded p-3 focus:ring-2 focus:ring-blue-900 resize-none" required></textarea>
            </div>

            <!-- Unggah Foto -->
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Unggah Foto (JPG/PNG, maks. 2MB)</label>
                <input id="fotoInput" type="file" accept=".jpg,.jpeg,.png"
                    class="w-full border border-gray-300 rounded p-3 bg-white text-gray-700 cursor-pointer" required>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end gap-4 pt-4">
                <button type="reset"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold px-5 py-2 rounded shadow-sm transition duration-200">
                    Batal
                </button>
                <button type="submit"
                    class="bg-blue-800 hover:bg-blue-900 text-white font-semibold px-5 py-2 rounded shadow-md transition duration-200">
                    Kirim
                </button>
            </div>
        </form>
    </div>

    <script>
        function showRuang() {
            document.getElementById("div-fasilitas").classList.add("hidden");
            const lantai = document.getElementById("lantaiSelect").value;
            const ruang = document.getElementById("ruangSelect").getElementsByTagName("option");
            for (let i = 0; i < ruang.length; i++) {
                if (ruang[i].getAttribute("data-lantai") !== lantai) {
                    ruang[i].style.display = "none";
                } else {
                    ruang[i].style.display = "block";
                }
            }
            document.getElementById("ruang-placeholder").style.display = "block";
            document.getElementById("ruangSelect").selectedIndex = 0;
            document.getElementById("div-ruang").classList.remove("hidden");
        }

        function showFasilitas() {
            const ruang = document.getElementById("ruangSelect").value;
            const fasilitas = document.getElementById("fasilitasSelect").getElementsByTagName("option");
            for (let i = 0; i < fasilitas.length; i++) {
                if (fasilitas[i].getAttribute("data-ruang") !== ruang) {
                    fasilitas[i].style.display = "none";
                } else {
                    fasilitas[i].style.display = "block";
                }
            }
            document.getElementById("fasilitas-placeholder").style.display = "block";
            document.getElementById("fasilitasSelect").selectedIndex = 0;
            document.getElementById("div-fasilitas").classList.remove("hidden");
        }

        document.getElementById("formPelaporan").addEventListener("submit", function(e) {
            e.preventDefault();

            const file = document.getElementById("fotoInput").files[0];

            if (file && file.size > 2 * 1024 * 1024) {
                alert("Ukuran foto maksimal 2MB");
                return;
            }

            const formData = new FormData();

            formData.append("fasilitas_ruang_id", document.getElementById("fasilitasSelect").value);
            formData.append("deskripsi_laporan", document.getElementById("deskripsiInput").value);
            formData.append("lapor_foto", document.getElementById("fotoInput").files[0]);

            $.ajax({
                url: "{{ route('laporkan.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                success: function(response) {
                    showSuccess("Laporan terkirim");
                    setTimeout(() => {
                        window.location.href = "/civitas";
                    }, 2000); // Redirect setelah SweetAlert selesai
                },
                error: function(xhr, status, error) {
                    showError("Gagal mengirim laporan");
                }
            });
        });


        function showSuccess(message) {
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: message,
                timer: 2000,
                showConfirmButton: false
            });
        }

        function showError(message) {
            Swal.fire({
                icon: 'error',
                title: 'Kesalahan',
                text: message,
                timer: 3000,
                showConfirmButton: true
            });
        }
    </script>
@endsection
