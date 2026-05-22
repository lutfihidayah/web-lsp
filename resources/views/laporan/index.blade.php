@extends('layouts.app')

@section('title', 'Laporan & Ekspor')
@section('page-title', 'Laporan & Ekspor')

@section('content')

<div class="space-y-6">

    {{-- FORM FILTER LAPORAN --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6 no-print">
        <h2 class="font-bold text-gray-800 text-lg mb-4">Filter Laporan</h2>
        <form method="GET" action="{{ route('laporan.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                
                {{-- Tipe Laporan --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Tipe Laporan</label>
                    <select name="type" id="reportTypeSelect" onchange="toggleFilterFields()" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-700 font-medium">
                        <option value="peserta" {{ request('type') == 'peserta' ? 'selected' : '' }}>Laporan Peserta</option>
                        <option value="pembayaran" {{ request('type', 'pembayaran') == 'pembayaran' ? 'selected' : '' }}>Laporan Pembayaran</option>
                        <option value="hasil" {{ request('type') == 'hasil' ? 'selected' : '' }}>Laporan Hasil & Sertifikasi</option>
                        <option value="jadwal" {{ request('type') == 'jadwal' ? 'selected' : '' }}>Laporan Jadwal Asesmen</option>
                    </select>
                </div>

                {{-- Rentang Tanggal --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Tanggal Mulai</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-700">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Tanggal Selesai</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-700">
                </div>

                {{-- Skema Sertifikasi --}}
                <div id="skemaFilterField">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Skema Sertifikasi</label>
                    <select name="skema_id" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-700">
                        <option value="">Semua Skema</option>
                        @foreach($skemas as $sk)
                            <option value="{{ $sk->id }}" {{ request('skema_id') == $sk->id ? 'selected' : '' }}>{{ $sk->nama }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Status --}}
                <div id="statusFilterField">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Status</label>
                    <select name="status" id="statusSelect" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-700">
                        {{-- Opsi dinamis via javascript --}}
                    </select>
                </div>

            </div>

            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                <span class="text-xs text-gray-400">Pilih tipe laporan dan rentang tanggal untuk menyaring data</span>
                <div class="flex items-center gap-2">
                    <a href="{{ route('laporan.index') }}" class="px-4 py-2 border border-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition">
                        Reset Filter
                    </a>
                    <button type="submit" class="px-5 py-2 bg-[#1e3a6e] text-white text-sm font-medium rounded-lg hover:bg-[#16305c] transition">
                        Terapkan Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- SUMMARY STATISTIK --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        
        @if($type === 'peserta')
            <div class="bg-white p-5 rounded-xl border border-gray-200 flex items-center gap-4 shadow-sm">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-lg">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Total Peserta</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $summary['total'] ?? 0 }}</h3>
                </div>
            </div>
            <div class="bg-white p-5 rounded-xl border border-gray-200 flex items-center gap-4 shadow-sm">
                <div class="p-3 bg-green-50 text-green-600 rounded-lg">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Peserta Aktif</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $summary['aktif'] ?? 0 }}</h3>
                </div>
            </div>
            <div class="bg-white p-5 rounded-xl border border-gray-200 flex items-center gap-4 shadow-sm">
                <div class="p-3 bg-red-50 text-red-600 rounded-lg">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Peserta Nonaktif</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $summary['nonaktif'] ?? 0 }}</h3>
                </div>
            </div>

        @elseif($type === 'pembayaran')
            <div class="bg-white p-5 rounded-xl border border-gray-200 flex items-center gap-4 shadow-sm">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-lg">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Total Pembayaran</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $summary['total'] ?? 0 }}</h3>
                </div>
            </div>
            <div class="bg-white p-5 rounded-xl border border-gray-200 flex items-center gap-4 shadow-sm">
                <div class="p-3 bg-green-50 text-green-600 rounded-lg">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9 12l2 2 4-4"/></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Lunas (Paid)</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $summary['paid'] ?? 0 }}</h3>
                </div>
            </div>
            <div class="bg-white p-5 rounded-xl border border-gray-200 flex items-center gap-4 shadow-sm">
                <div class="p-3 bg-yellow-50 text-yellow-600 rounded-lg">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Total Pendapatan</p>
                    <h3 class="text-2xl font-bold text-gray-800">Rp {{ number_format($summary['total_amount'] ?? 0, 0, ',', '.') }}</h3>
                </div>
            </div>

        @elseif($type === 'hasil')
            <div class="bg-white p-5 rounded-xl border border-gray-200 flex items-center gap-4 shadow-sm">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-lg">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Total Ujian</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $summary['total'] ?? 0 }}</h3>
                </div>
            </div>
            <div class="bg-white p-5 rounded-xl border border-gray-200 flex items-center gap-4 shadow-sm">
                <div class="p-3 bg-green-50 text-green-600 rounded-lg">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M5 13l4 4L19 7"/></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Kompeten (Lulus)</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $summary['lulus'] ?? 0 }}</h3>
                </div>
            </div>
            <div class="bg-white p-5 rounded-xl border border-gray-200 flex items-center gap-4 shadow-sm">
                <div class="p-3 bg-red-50 text-red-600 rounded-lg">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Belum Kompeten</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $summary['tidak_lulus'] ?? 0 }}</h3>
                </div>
            </div>

        @elseif($type === 'jadwal')
            <div class="bg-white p-5 rounded-xl border border-gray-200 flex items-center gap-4 shadow-sm col-span-1 md:col-span-2">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-lg">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Total Agenda Jadwal</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $summary['total'] ?? 0 }} Sesi</h3>
                </div>
            </div>
            <div class="bg-white p-5 rounded-xl border border-gray-200 flex items-center gap-4 shadow-sm">
                <div class="p-3 bg-green-50 text-green-600 rounded-lg">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Total Kuota Tersedia</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $summary['total_kuota'] ?? 0 }} Orang</h3>
                </div>
            </div>
        @endif

    </div>

    {{-- TABEL PRATINJAU DATA --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        
        {{-- Header Tabel --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="font-bold text-gray-800 text-lg">Pratinjau Laporan</h2>
                <p class="text-sm text-gray-400">Menampilkan {{ $data->count() }} baris data</p>
            </div>
            <div class="flex items-center gap-2 no-print">
                <button type="button" onclick="exportPDF()" class="px-4 py-2 border border-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition flex items-center gap-2">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    Cetak PDF / Print
                </button>
                <button type="button" onclick="exportExcel('Laporan_{{ ucfirst($type) }}_{{ date('Ymd') }}')" class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition flex items-center gap-2">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Unduh Excel
                </button>
            </div>
        </div>

        {{-- Table Element --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                
                @if($type === 'peserta')
                    <thead>
                        <tr class="border-b border-gray-100 text-gray-400 text-xs">
                            <th class="text-left pb-3 font-semibold">No</th>
                            <th class="text-left pb-3 font-semibold">Nama Lengkap</th>
                            <th class="text-left pb-3 font-semibold">Email</th>
                            <th class="text-left pb-3 font-semibold">Tanggal Registrasi</th>
                            <th class="text-left pb-3 font-semibold">Status Akun</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($data as $row)
                            <tr class="hover:bg-gray-50/50">
                                <td class="py-3 text-gray-400">{{ $loop->iteration }}</td>
                                <td class="py-3 font-semibold text-gray-800">{{ $row->name }}</td>
                                <td class="py-3 text-gray-500">{{ $row->email }}</td>
                                <td class="py-3 text-gray-500">{{ $row->created_at->format('d M Y, H:i') }}</td>
                                <td class="py-3">
                                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $row->status === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ ucfirst($row->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-400">Tidak ada data ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>

                @elseif($type === 'pembayaran')
                    <thead>
                        <tr class="border-b border-gray-100 text-gray-400 text-xs">
                            <th class="text-left pb-3 font-semibold">No</th>
                            <th class="text-left pb-3 font-semibold">Nama Peserta</th>
                            <th class="text-left pb-3 font-semibold">Skema</th>
                            <th class="text-left pb-3 font-semibold">Order ID</th>
                            <th class="text-left pb-3 font-semibold">Nominal</th>
                            <th class="text-left pb-3 font-semibold">Tipe Pembayaran</th>
                            <th class="text-left pb-3 font-semibold">Tanggal Pembayaran</th>
                            <th class="text-left pb-3 font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($data as $row)
                            <tr class="hover:bg-gray-50/50">
                                <td class="py-3 text-gray-400">{{ $loop->iteration }}</td>
                                <td class="py-3 font-semibold text-gray-800">{{ $row->user->name ?? '-' }}</td>
                                <td class="py-3 text-gray-500">{{ $row->skema->nama ?? '-' }}</td>
                                <td class="py-3 text-gray-500 font-mono">{{ $row->order_id }}</td>
                                <td class="py-3 text-gray-800 font-semibold">{{ $row->formatted_amount }}</td>
                                <td class="py-3 text-gray-500 uppercase">{{ $row->payment_type ?? '-' }}</td>
                                <td class="py-3 text-gray-500">{{ $row->paid_at ? $row->paid_at->format('d M Y, H:i') : '-' }}</td>
                                <td class="py-3">
                                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $row->status_color }}">
                                        {{ $row->status_label }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-8 text-center text-gray-400">Tidak ada data ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>

                @elseif($type === 'hasil')
                    <thead>
                        <tr class="border-b border-gray-100 text-gray-400 text-xs">
                            <th class="text-left pb-3 font-semibold">No</th>
                            <th class="text-left pb-3 font-semibold">Nama Peserta</th>
                            <th class="text-left pb-3 font-semibold">Skema</th>
                            <th class="text-left pb-3 font-semibold">Nilai Quiz</th>
                            <th class="text-left pb-3 font-semibold">No Sertifikat</th>
                            <th class="text-left pb-3 font-semibold">Status Kelulusan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($data as $row)
                            <tr class="hover:bg-gray-50/50">
                                <td class="py-3 text-gray-400">{{ $loop->iteration }}</td>
                                <td class="py-3 font-semibold text-gray-800">{{ $row->pendaftaran->user->name ?? '-' }}</td>
                                <td class="py-3 text-gray-500">{{ $row->pendaftaran->skema->nama ?? '-' }}</td>
                                <td class="py-3 text-gray-800 font-bold">{{ $row->nilai_quiz !== null ? number_format($row->nilai_quiz, 1) : '-' }}</td>
                                <td class="py-3 text-gray-500 font-mono">{{ $row->no_sertifikat ?? '-' }}</td>
                                <td class="py-3">
                                    @if($row->status === 'lulus')
                                        <span class="px-2 py-0.5 bg-green-100 text-green-800 rounded-full text-xs font-semibold">Kompeten</span>
                                    @elseif($row->status === 'tidak_lulus')
                                        <span class="px-2 py-0.5 bg-red-100 text-red-800 rounded-full text-xs font-semibold">Belum Kompeten</span>
                                    @else
                                        <span class="px-2 py-0.5 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">Berlangsung</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-400">Tidak ada data ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>

                @elseif($type === 'jadwal')
                    <thead>
                        <tr class="border-b border-gray-100 text-gray-400 text-xs">
                            <th class="text-left pb-3 font-semibold">No</th>
                            <th class="text-left pb-3 font-semibold">Judul Sesi</th>
                            <th class="text-left pb-3 font-semibold">Skema Sertifikasi</th>
                            <th class="text-left pb-3 font-semibold">Tanggal Asesmen</th>
                            <th class="text-left pb-3 font-semibold">Kuota Peserta</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($data as $row)
                            <tr class="hover:bg-gray-50/50">
                                <td class="py-3 text-gray-400">{{ $loop->iteration }}</td>
                                <td class="py-3 font-semibold text-gray-800">{{ $row->judul }}</td>
                                <td class="py-3 text-gray-500">{{ $row->skema->nama ?? '-' }}</td>
                                <td class="py-3 text-gray-500">{{ Carbon\Carbon::parse($row->tanggal)->format('d M Y, H:i') }}</td>
                                <td class="py-3 text-gray-800 font-semibold">{{ $row->kuota }} Peserta</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-400">Tidak ada data ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                @endif

            </table>
        </div>
    </div>
</div>

<script>
    const reportStatuses = {
        peserta: [
            { value: '', label: 'Semua Status' },
            { value: 'aktif', label: 'Aktif' },
            { value: 'nonaktif', label: 'Nonaktif' }
        ],
        pembayaran: [
            { value: '', label: 'Semua Status' },
            { value: 'paid', label: 'Lunas (Paid)' },
            { value: 'pending', label: 'Menunggu Pembayaran (Pending)' },
            { value: 'failed', label: 'Gagal (Failed)' },
            { value: 'expired', label: 'Kadaluarsa (Expired)' }
        ],
        hasil: [
            { value: '', label: 'Semua Hasil' },
            { value: 'lulus', label: 'Kompeten (Lulus)' },
            { value: 'tidak_lulus', label: 'Belum Kompeten (Tidak Lulus)' },
            { value: 'berlangsung', label: 'Berlangsung' }
        ],
        jadwal: []
    };

    function toggleFilterFields() {
        const type = document.getElementById('reportTypeSelect').value;
        
        // Toggle Skema Filter Visibility
        const skemaField = document.getElementById('skemaFilterField');
        if (type === 'peserta') {
            skemaField.classList.add('hidden');
        } else {
            skemaField.classList.remove('hidden');
        }

        // Toggle and Populate Status Filter
        const statusField = document.getElementById('statusFilterField');
        const statusSelect = document.getElementById('statusSelect');
        const statuses = reportStatuses[type] || [];

        if (statuses.length === 0) {
            statusField.classList.add('hidden');
        } else {
            statusField.classList.remove('hidden');
            
            // Simpan status lama jika ada agar tidak ter-reset jika bertipe sama
            const oldStatus = "{{ request('status') }}";
            statusSelect.innerHTML = '';
            
            statuses.forEach(s => {
                const opt = document.createElement('option');
                opt.value = s.value;
                opt.textContent = s.label;
                if (s.value === oldStatus) {
                    opt.selected = true;
                }
                statusSelect.appendChild(opt);
            });
        }
    }

    // Jalankan saat load halaman
    document.addEventListener("DOMContentLoaded", function() {
        toggleFilterFields();
    });
</script>

@endsection
