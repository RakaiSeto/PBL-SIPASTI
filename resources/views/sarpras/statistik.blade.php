@extends('layouts.app')

@section('content')
<div class="bg-white p-4 rounded shadow">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Laporan Kerusakan</h1>

    <!-- Form Filter Periode -->
    <form id="filterForm" class="flex flex-wrap items-center gap-4 mb-8">
        <label for="periode" class="font-semibold text-gray-700">Periode:</label>
        <select id="periode" name="periode" class="border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Pilih Periode</option>
            <option value="semester1-2025">Semester 1 2025</option>
            <option value="semester2-2025">Semester 2 2025</option>
            <option value="semester1-2024">Semester 1 2024</option>
        </select>
        <button type="button" id="btnFilter" class="px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Filter</button>
    </form>

    <!-- Output: Grafik & Tabel -->
    <div id="outputArea" class="hidden">
        <!-- Diagram Batang -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <canvas id="barChartJumlah" class="w-full h-64"></canvas>
            </div>
            <div>
                <canvas id="barChartWaktu" class="w-full h-64"></canvas>
            </div>
        </div>

        <!-- Tabel -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border border-gray-300 rounded">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-300 p-3 font-semibold">Kategori</th>
                        <th class="border border-gray-300 p-3 font-semibold">Jumlah Kerusakan</th>
                        <th class="border border-gray-300 p-3 font-semibold">Rata-rata Waktu Perbaikan (hari)</th>
                    </tr>
                </thead>
                <tbody id="tableBody"></tbody>
            </table>
        </div>

        <!-- Tombol Unduh PDF -->
        <div class="mt-6 flex justify-end">
            <button id="btnDownloadPdf" class="px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">Unduh PDF</button>
        </div>
    </div>
</div>

<!-- Chart.js dan jsPDF CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
    const btnFilter = document.getElementById('btnFilter');
    const outputArea = document.getElementById('outputArea');
    const tableBody = document.getElementById('tableBody');
    let barChartJumlah, barChartWaktu;

    // Data dummy (ganti dengan fetch API di implementasi nyata)
    const dataByPeriode = {
        'semester1-2025': [
            { kategori: 'AC', jumlah: 10, rataWaktu: 2.5 },
            { kategori: 'Kursi', jumlah: 7, rataWaktu: 3.1 },
            { kategori: 'Lampu', jumlah: 15, rataWaktu: 1.8 },
        ],
        'semester2-2025': [
            { kategori: 'AC', jumlah: 5, rataWaktu: 2.2 },
            { kategori: 'Proyektor', jumlah: 3, rataWaktu: 4.0 },
            { kategori: 'Kipas Angin', jumlah: 9, rataWaktu: 3.5 },
        ],
        'semester1-2024': [
            { kategori: 'Lampu', jumlah: 8, rataWaktu: 2.0 },
            { kategori: 'Kursi', jumlah: 6, rataWaktu: 3.0 },
            { kategori: 'AC', jumlah: 12, rataWaktu: 2.8 },
        ],
    };

    // Fungsi untuk membuat chart
    function createChart(canvasId, labels, data, label, backgroundColor, title) {
        const ctx = document.getElementById(canvasId).getContext('2d');
        return new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: label,
                    data: data,
                    backgroundColor: backgroundColor,
                    borderRadius: 5,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: ctx => `${label}: ${ctx.parsed.y}`
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: title }
                    },
                    x: {
                        title: { display: true, text: 'Kategori' }
                    }
                }
            }
        });
    }

    // Fungsi untuk update UI
    function updateUI(selectedData) {
        outputArea.classList.remove('hidden');

        // Update Tabel
        tableBody.innerHTML = '';
        selectedData.forEach(row => {
            tableBody.innerHTML += `
                <tr>
                    <td class="border border-gray-300 p-3">${row.kategori}</td>
                    <td class="border border-gray-300 p-3">${row.jumlah}</td>
                    <td class="border border-gray-300 p-3">${row.rataWaktu.toFixed(1)}</td>
                </tr>
            `;
        });

        // Update Charts
        const labels = selectedData.map(d => d.kategori);
        const jumlahKerusakan = selectedData.map(d => d.jumlah);
        const rataWaktu = selectedData.map(d => d.rataWaktu);

        // Destroy chart jika sudah ada
        if (barChartJumlah) barChartJumlah.destroy();
        if (barChartWaktu) barChartWaktu.destroy();

        // Chart Jumlah Kerusakan
        barChartJumlah = createChart(
            'barChartJumlah',
            labels,
            jumlahKerusakan,
            'Jumlah Kerusakan',
            '#1652B7',
            'Jumlah Kerusakan'
        );

        // Chart Rata-rata Waktu Perbaikan
        barChartWaktu = createChart(
            'barChartWaktu',
            labels,
            rataWaktu,
            'Rata-rata Waktu (hari)',
            '#ea8a14',
            'Rata-rata Waktu Perbaikan (hari)'
        );
    }

    // Event Filter
    btnFilter.addEventListener('click', () => {
        const periode = document.getElementById('periode').value;
        if (!periode) {
            alert('Silakan pilih periode.');
            return;
        }

        const selectedData = dataByPeriode[periode] || [];
        if (selectedData.length === 0) {
            alert('Data tidak ditemukan untuk periode ini.');
            outputArea.classList.add('hidden');
            return;
        }

        updateUI(selectedData);
    });

    // Event Unduh PDF
    document.getElementById('btnDownloadPdf').addEventListener('click', () => {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        // Tambahkan judul
        doc.setFontSize(16);
        doc.text('Laporan Kerusakan Fasilitas', 20, 20);
        doc.setFontSize(12);
        doc.text(`Periode: ${document.getElementById('periode').value.replace('-', ' ')}`, 20, 30);

        // Tambahkan tabel
        doc.autoTable({
            startY: 40,
            head: [['Kategori', 'Jumlah Kerusakan', 'Rata-rata Waktu Perbaikan (hari)']],
            body: Array.from(tableBody.querySelectorAll('tr')).map(row =>
                Array.from(row.querySelectorAll('td')).map(cell => cell.textContent)
            ),
        });

        // Simpan PDF
        doc.save(`laporan_kerusakan_${document.getElementById('periode').value}.pdf`);
    });
</script>
@endsection
