@extends('admin.layouts.partner')

@section('css')
    @vite('resources/css/admin/berita.css')
    <link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet"/>
    <link href="https://unpkg.com/trix/dist/trix.css" rel="stylesheet"/>
@endsection

@section('slot')
    <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="id_berita_kategori" value="{{ $kategori->id_berita_kategori }}">

        <div class="mb-4">
            <label for="judul_berita" class="block text-sm font-medium text-gray-700">Judul Berita</label>
            <input type="text" name="judul_berita" id="judul_berita"
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required />
        </div>

        <div class="mb-4 relative">
            <label for="foto_berita" class="block text-sm font-medium text-gray-700">Foto Berita</label>
            <input type="file" name="foto_berita" id="foto_berita" class="mt-1" />

            <a type="button" id="edit-image-button" style="display:none;"
                class="p-1 bg-black border-2 border-white text-white rounded-full absolute left-1/2 transform -translate-x-1/2 bottom-7">
                <i class="fa-solid fa-pencil p-1"></i>
            </a>
        </div>

        <div class="mb-4">
            <label for="sumber_foto_berita" class="block text-sm font-medium text-gray-700">Sumber Foto Berita</label>
            <input type="text" name="sumber_foto_berita" id="sumber_foto_berita"
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md" />
        </div>

        <div class="mb-4">
            <label for="isi_berita" class="block text-sm font-medium text-gray-700">Isi Berita</label>
            <input id="isi_berita" type="hidden" name="isi_berita">
            <trix-editor input="isi_berita"></trix-editor>
        </div>

        <div class="mb-4">
            <label for="preview_berita" class="block text-sm font-medium text-gray-700">Preview Berita</label>
            <input type="text" name="preview_berita" id="preview_berita"
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required />
        </div>

        <div class="mb-4">
            <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-md">Simpan</button>
        </div>
    </form>

    <!-- Modal -->
    <div id="cropperModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Crop Image
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="cropperModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <div>
                        <img id="image-to-crop" src="" alt="Image to crop" />
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="button" id="crop-button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Crop</button>
                    <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600" data-modal-hide="cropperModal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @vite('resources/js/admin/berita.js')
    <script src="https://unpkg.com/trix/dist/trix.js"></script>
@endsection
