    @extends('admin.layout')

    @section('title', $page_title)

    @section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">{{ $page_title }}</h1>
        <p class="mb-6 text-gray-600">{{ $page_description }}</p>

        <form action="{{ route('admin.sedot-tinja.update-status', $data->id) }}" 
            method="POST" 
            class="bg-white p-6 border rounded-lg shadow-md space-y-4">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div>
                <label class="block font-medium mb-1">Nama</label>
                <input type="text" name="nama_pelanggan" 
                    value="{{ old('nama_pelanggan', $data->nama_pelanggan) }}" 
                    class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300" required>
                @error('nama_pelanggan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nomor Telepon --}}
            <div>
                <label class="block font-medium mb-1">Nomor Telepon</label>
                <input type="text" name="nomor_telepon_pelanggan" 
                    value="{{ old('nomor_telepon_pelanggan', $data->nomor_telepon_pelanggan) }}" 
                    class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300" required>
                @error('nomor_telepon_pelanggan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Alamat --}}
            <div>
                <label class="block font-medium mb-1">Alamat</label>
                <textarea name="alamat" rows="3"
                        class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300" required>{{ old('alamat', $data->alamat) }}</textarea>
                @error('alamat')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Alamat Detail --}}
            <div>
                <label class="block font-medium mb-1">Alamat Detail</label>
                <input type="text" name="alamat_detail" 
                    value="{{ old('alamat_detail', $data->alamat_detail) }}" 
                    class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">
                @error('alamat_detail')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Layanan --}}
            <div>
                <label class="block font-medium mb-1">Layanan</label>
                <input type="text" name="layanan" 
                    value="{{ old('layanan', $data->layanan) }}" 
                    class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">
            </div>

            {{-- Detail Laporan --}}
            <div>
                <label class="block font-medium mb-1">Detail Laporan</label>
                <textarea name="detail_laporan" rows="3"
                        class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">{{ old('detail_laporan', $data->detail_laporan) }}</textarea>
            </div>

            {{-- Kabupaten / Kota --}}
            <div>
                <label class="block font-medium mb-1">Kabupaten/Kota</label>
                <input type="text" name="kabkota_id" 
                    value="{{ old('kabkota_id', $data->kabkota_id) }}" 
                    class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">
            </div>

            {{-- Kecamatan --}}
            <div>
                <label class="block font-medium mb-1">Kecamatan</label>
                <input type="text" name="kecamatan_id" 
                    value="{{ old('kecamatan_id', $data->kecamatan_id) }}" 
                    class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">
            </div>

            {{-- Kelurahan --}}
            <div>
                <label class="block font-medium mb-1">Kelurahan</label>
                <input type="text" name="kelurahan_id" 
                    value="{{ old('kelurahan_id', $data->kelurahan_id) }}" 
                    class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">
            </div>

            {{-- Longitude --}}
            <div>
                <label class="block font-medium mb-1">Longitude</label>
                <input type="text" name="longitude" 
                    value="{{ old('longitude', $data->longitude) }}" 
                    class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">
            </div>

            {{-- Latitude --}}
            <div>
                <label class="block font-medium mb-1">Latitude</label>
                <input type="text" name="latitude" 
                    value="{{ old('latitude', $data->latitude) }}" 
                    class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">
            </div>

            {{-- Jenis Bangunan --}}
            <div>
                <label class="block font-medium mb-1">Jenis Bangunan</label>
                <input type="text" name="jenis_bangunan" 
                    value="{{ old('jenis_bangunan', $data->jenis_bangunan) }}" 
                    class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">
            </div>

            {{-- Nomor Bangunan --}}
            <div>
                <label class="block font-medium mb-1">Nomor Bangunan</label>
                <input type="number" name="nomor_bangunan" 
                    value="{{ old('nomor_bangunan', $data->nomor_bangunan) }}" 
                    class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">
            </div>

            {{-- RT --}}
            <div>
                <label class="block font-medium mb-1">RT</label>
                <input type="number" name="rt" 
                    value="{{ old('rt', $data->rt) }}" 
                    class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">
            </div>

            {{-- Rating --}}
            <div>
                <label class="block font-medium mb-1">Rating</label>
                <input type="number" name="rating" min="1" max="5"
                    value="{{ old('rating', $data->rating) }}" 
                    class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">
            </div>

            {{-- Kritik --}}
            <div>
                <label class="block font-medium mb-1">Kritik</label>
                <textarea name="kritik" rows="2"
                        class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">{{ old('kritik', $data->kritik) }}</textarea>
            </div>

            {{-- Saran --}}
            <div>
                <label class="block font-medium mb-1">Saran</label>
                <textarea name="saran" rows="2"
                        class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">{{ old('saran', $data->saran) }}</textarea>
            </div>

            {{-- Status Pengerjaan --}}
            <div>
                <label class="block font-medium mb-1">Status Pengerjaan</label>
                <select name="status_pengerjaan" class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">
                    <option value="Belum dikerjakan" {{ old('status_pengerjaan', $data->status_pengerjaan) == 'Belum dikerjakan' ? 'selected' : '' }}>Belum dikerjakan</option>
                    <option value="Sedang dikerjakan" {{ old('status_pengerjaan', $data->status_pengerjaan) == 'Sedang dikerjakan' ? 'selected' : '' }}>Sedang dikerjakan</option>
                    <option value="Selesai" {{ old('status_pengerjaan', $data->status_pengerjaan) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            {{-- Setuju --}}
            <div class="flex items-center mt-2">
                <input type="checkbox" name="setuju" value="1"
                    {{ old('setuju', $data->setuju) ? 'checked' : '' }}
                    class="mr-2">
                <label class="font-medium">Setuju</label>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex items-center space-x-3">
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2 rounded-lg">
                    Simpan
                </button>
                <a href="{{ route('admin.sedot-tinja.data-pesanan') }}" 
                class="text-blue-600 hover:underline">
                    Batal
                </a>
            </div>
        </form>
    </div>
    @endsection
