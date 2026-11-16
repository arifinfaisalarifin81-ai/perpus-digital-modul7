<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Koleksi Buku') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Banner Atas Modern & Bersih -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 tracking-tight">Katalog Koleksi Buku</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Kelola data buku, kategori, dan pembaruan secara real-time dengan sistem interaktif.</p>
                </div>
                <button onclick="window.location.reload()" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-50 hover:bg-gray-100 text-gray-700 text-xs font-semibold rounded-xl border border-gray-200 transition duration-150 shadow-xs">
                    🔄 Muat Ulang Data
                </button>
            </div>

            <!-- Grid Layout: Form (Kiri) & Tabel (Kanan) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                
                <!-- Form Input Buku (Sticky) -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 space-y-5 lg:col-span-1 sticky top-6">
                    <div class="flex justify-between items-center border-b border-gray-100 pb-3">
                        <h4 id="formTitle" class="text-xs font-bold text-gray-800 uppercase tracking-widest">Tambah Buku Baru</h4>
                        <button type="button" id="btnCancelEdit" onclick="resetForm()" class="hidden text-xs text-gray-400 hover:text-red-600 font-semibold transition">
                            Batal Edit
                        </button>
                    </div>
                    
                    <form id="formTambahBuku" class="space-y-4">
                        <input type="hidden" id="buku_id">
                        
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Kategori Buku</label>
                            <select id="kategori_id" class="w-full bg-gray-50/50 border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 rounded-xl text-sm py-2.5 px-3 transition shadow-2xs" required>
                                <option value="">Pilih Kategori...</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Judul Buku</label>
                            <input type="text" id="judul" placeholder="Contoh: Pemrograman Web Lanjut" class="w-full bg-gray-50/50 border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 rounded-xl text-sm py-2.5 px-3 transition shadow-2xs" required>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Penulis</label>
                            <input type="text" id="penulis" placeholder="Nama penulis..." class="w-full bg-gray-50/50 border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 rounded-xl text-sm py-2.5 px-3 transition shadow-2xs" required>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Tahun Terbit (1999 – 2026)</label>
                            <input type="number" id="tahun_terbit" placeholder="2026" min="1999" max="2026" class="w-full bg-gray-50/50 border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 rounded-xl text-sm py-2.5 px-3 transition shadow-2xs" required>
                        </div>

                        <button type="submit" id="submitBtn" class="w-full py-3 px-4 bg-gray-900 hover:bg-gray-800 text-white font-semibold text-xs uppercase tracking-widest rounded-xl shadow-md hover:shadow-lg transition duration-200">
                            Simpan Buku
                        </button>
                    </form>
                </div>

                <!-- Tabel Data Buku -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 lg:col-span-2 space-y-4">
                    <div class="flex justify-between items-center border-b border-gray-100 pb-3">
                        <h4 class="text-xs font-bold text-gray-800 uppercase tracking-widest">Daftar Inventaris Buku</h4>
                        <span id="totalBuku" class="text-xs font-bold bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full border border-indigo-100/60">0 Buku</span>
                    </div>

                    <div class="overflow-x-auto rounded-xl border border-gray-100">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/70 text-gray-400 text-xs uppercase tracking-wider border-b border-gray-100">
                                    <th class="p-3.5 font-bold">#</th>
                                    <th class="p-3.5 font-bold">Kategori</th>
                                    <th class="p-3.5 font-bold">Judul Buku</th>
                                    <th class="p-3.5 font-bold">Penulis</th>
                                    <th class="p-3.5 font-bold">Tahun</th>
                                    <th class="p-3.5 font-bold text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tabelBukuBody" class="divide-y divide-gray-100 text-sm text-gray-600">
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-gray-400 font-medium">Memuat data dari server...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- Script JavaScript Interaktif SPA CRUD -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const apiUrlBuku = "/api/buku";
            const apiUrlKategori = "/api/kategoris";
            const tableBody = document.getElementById("tabelBukuBody");
            const form = document.getElementById("formTambahBuku");
            const selectKategori = document.getElementById("kategori_id");
            const formTitle = document.getElementById("formTitle");
            const submitBtn = document.getElementById("submitBtn");
            const btnCancelEdit = document.getElementById("btnCancelEdit");
            const bukuIdInput = document.getElementById("buku_id");
            const totalBukuBadge = document.getElementById("totalBuku");

            let listBukuGlobal = [];

            // 1. Ambil data kategori untuk dropdown
            function loadKategori() {
                fetch(apiUrlKategori)
                    .then(res => res.json())
                    .then(res => {
                        let dataKategori = Array.isArray(res) ? res : (res.data || []);
                        selectKategori.innerHTML = '<option value="">Pilih Kategori...</option>';
                        dataKategori.forEach(kat => {
                            let namaKat = kat.nama || kat.name || kat.kategori || "Kategori";
                            selectKategori.innerHTML += `<option value="${kat.id}">${namaKat}</option>`;
                        });
                    })
                    .catch(err => console.error("Gagal memuat kategori:", err));
            }

            // 2. Ambil & Tampilkan Data Buku (GET)
            window.loadBuku = function() {
                fetch(apiUrlBuku)
                    .then(res => res.json())
                    .then(res => {
                        let data = Array.isArray(res) ? res : (res.data || []);
                        listBukuGlobal = data;
                        totalBukuBadge.innerText = `${data.length} Buku`;

                        if (data.length === 0) {
                            tableBody.innerHTML = `<tr><td colspan="6" class="p-8 text-center text-gray-400 font-medium">Belum ada data buku tersimpan.</td></tr>`;
                            return;
                        }

                        tableBody.innerHTML = "";
                        data.forEach((item, index) => {
                            let namaKategori = '-';
                            if (item.kategori) {
                                namaKategori = item.kategori.nama || item.kategori.name || item.kategori.kategori || '-';
                            } else {
                                let opt = selectKategori.querySelector(`option[value="${item.kategori_id}"]`);
                                if (opt) namaKategori = opt.text;
                            }

                            tableBody.innerHTML += `
                                <tr class="hover:bg-gray-50/60 transition duration-150">
                                    <td class="p-3.5 font-medium text-gray-400">${index + 1}</td>
                                    <td class="p-3.5">
                                        <span class="inline-flex items-center px-2.5 py-1 bg-indigo-50/60 text-indigo-700 font-medium rounded-lg text-xs border border-indigo-100/50">
                                            ${namaKategori}
                                        </span>
                                    </td>
                                    <td class="p-3.5 font-bold text-gray-900">${item.judul}</td>
                                    <td class="p-3.5 text-gray-600">${item.penulis}</td>
                                    <td class="p-3.5 font-medium text-gray-500">${item.tahun_terbit}</td>
                                    <td class="p-3.5 text-center whitespace-nowrap">
                                        <div class="inline-flex items-center justify-center gap-2">
                                            <button onclick="editBuku(${item.id})" class="px-3 py-1.5 bg-amber-50 hover:bg-amber-500 hover:text-white text-amber-700 rounded-xl text-xs font-semibold border border-amber-200/60 transition shadow-2xs">
                                                Edit
                                            </button>
                                            <button onclick="hapusBuku(${item.id})" class="px-3 py-1.5 bg-red-50 hover:bg-red-600 hover:text-white text-red-600 rounded-xl text-xs font-semibold border border-red-200/60 transition shadow-2xs">
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            `;
                        });
                    })
                    .catch(err => {
                        console.error("Gagal memuat buku:", err);
                        tableBody.innerHTML = `<tr><td colspan="6" class="p-8 text-center text-red-500 font-medium">Gagal terhubung ke server API.</td></tr>`;
                    });
            }

            // Jalankan saat pertama kali dibuka
            loadKategori();
            setTimeout(loadBuku, 200);

            // 3. Proses Simpan / Update (POST & PUT)
            form.addEventListener("submit", function(e) {
                e.preventDefault();
                const id = bukuIdInput.value;
                const isEdit = id !== "";

                const formData = {
                    kategori_id: selectKategori.value,
                    judul: document.getElementById("judul").value,
                    penulis: document.getElementById("penulis").value,
                    tahun_terbit: document.getElementById("tahun_terbit").value,
                };

                const url = isEdit ? `${apiUrlBuku}/${id}` : apiUrlBuku;
                const method = isEdit ? "PUT" : "POST";

                fetch(url, {
                    method: method,
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                    },
                    body: JSON.stringify(formData)
                })
                .then(res => {
                    if (!res.ok) return res.json().then(err => { throw err; });
                    return res.json();
                })
                .then(data => {
                    alert(isEdit ? "Buku berhasil diperbarui!" : "Buku baru berhasil ditambahkan!");
                    resetForm();
                    loadBuku();
                })
                .catch(error => {
                    console.error("Error:", error);
                    let pesan = error.message || "Terjadi kesalahan.";
                    if (error.errors) pesan = Object.values(error.errors).flat().join("\n");
                    alert("Gagal menyimpan:\n" + pesan);
                });
            });

            // 4. Mode Edit
            window.editBuku = function(id) {
                const buku = listBukuGlobal.find(b => b.id == id);
                if (!buku) return;

                bukuIdInput.value = buku.id;
                selectKategori.value = buku.kategori_id;
                document.getElementById("judul").value = buku.judul;
                document.getElementById("penulis").value = buku.penulis;
                document.getElementById("tahun_terbit").value = buku.tahun_terbit;

                formTitle.innerText = "Edit Data Buku";
                submitBtn.innerText = "Perbarui Buku";
                submitBtn.classList.replace("bg-gray-900", "bg-amber-600");
                submitBtn.classList.replace("hover:bg-gray-800", "hover:bg-amber-700");
                btnCancelEdit.classList.remove("hidden");

                window.scrollTo({ top: 0, behavior: 'smooth' });
            }

            // 5. Reset Form
            window.resetForm = function() {
                form.reset();
                bukuIdInput.value = "";
                formTitle.innerText = "Tambah Buku Baru";
                submitBtn.innerText = "Simpan Buku";
                submitBtn.classList.replace("bg-amber-600", "bg-gray-900");
                submitBtn.classList.replace("hover:bg-amber-700", "hover:bg-gray-800");
                btnCancelEdit.classList.add("hidden");
            }

            // 6. Fungsi Hapus Buku
            window.hapusBuku = function(id) {
                if (confirm("Apakah Anda yakin ingin menghapus buku ini?")) {
                    fetch(`${apiUrlBuku}/${id}`, {
                        method: "DELETE",
                        headers: {
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                        }
                    })
                    .then(res => {
                        if (res.ok) {
                            alert("Buku berhasil dihapus.");
                            loadBuku();
                        } else {
                            alert("Gagal menghapus buku.");
                        }
                    })
                    .catch(err => console.error("Error:", err));
                }
            }
        });
    </script>
</x-app-layout>