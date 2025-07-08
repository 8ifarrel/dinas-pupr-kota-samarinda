@extends('guest.layouts.profil')

@section('slot')

<div class="px-5 sm:px-10 py-5 md:py-6 md:px-12">
	<div class="block bg-white rounded-xl shadow-xl">
		@if($kepala_dinas)
			<div class="bg-blue static h-36 rounded-t-xl flex justify-center pt-[72px] mb-[72px]">
				<img class="bg-white absolute rounded-full h-36 border-2 border-black" src="https://pupr.samarindakota.go.id/temp/desy-damayanti-st-mt.png" alt="">	
			</div>

			<div class="pb-10 pt-5 px-5 md:px-10 lg:px-14">
				<div class="text-center flex flex-col justify-center mb-5">
					<h1 class="font-bold text-2xl md:text-3xl uppercase mb-1">{{ $kepala_dinas->nama }}</h1>
					<p>{{ $kepala_dinas->susunanOrganisasi->deskripsi_susunan_organisasi }}</p>
				</div>

				{{-- Ini jadi tapi ga sama panjang --}}
				{{-- <div class="grid grid-cols-2 gap-10 place-content-center mx-auto w-3/4">
					<div>
						<h1 class="font-bold text-xl uppercase mb-2 text-end">Riwayat Pendidikan</h1>

						<ol class="relative border-e text-end border-gray-200 dark:border-gray-700">                  
							<li class="mb-8 ms-6 sm:me-6">
								<span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 sm:-end-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
									<svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
										<path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
									</svg>
								</span>
								<h3 class="mb-1 text-base lg:text-lg font-medium text-gray-900 dark:text-white">Institut Teknologi Sepuluh Nopember S2 Teknik Sipil-Manajemen Aset</h3>
								<time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">2069</time>
							</li>
							
							<li class="mb-8 ms-6 sm:me-6">
								<span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 sm:-end-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
									<svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
										<path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
									</svg>
								</span>
								<h3 class="mb-1 text-base lg:text-lg font-medium text-gray-900 dark:text-white">Institut Teknologi Nasional Malang S1 Teknik Sipil Perencanaan</h3>
								<time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">2068</time>
							</li>

							<li class="mb-8 ms-6 sm:me-6">
								<span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 sm:-end-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
									<svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
										<path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
									</svg>
								</span>
								<h3 class="mb-1 text-base lg:text-lg font-medium text-gray-900 dark:text-white">SMA Negeri 1 Malang</h3>
								<time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">2067</time>
							</li>

							<li class="mb-8 ms-6 sm:me-6">
								<span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 sm:-end-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
									<svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
										<path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
									</svg>
								</span>
								<h3 class="mb-1 text-base lg:text-lg font-medium text-gray-900 dark:text-white">SMP Negeri 1 Samarinda</h3>
								<time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">2067</time>
							</li>

							<li class="me-6">
								<span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 sm:-end-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
									<svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
										<path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
									</svg>
								</span>
								<h3 class="mb-1 text-base lg:text-lg font-medium text-gray-900 dark:text-white">SD Negeri 005</h3>
								<time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">2067</time>
							</li>
						</ol>				
					</div>

					<div>
						<h1 class="font-bold text-xl uppercase mb-2">Jenjang Karir</h1>

						<ol class="relative border-s border-gray-200 dark:border-gray-700">                  
							<li class="mb-8 ms-6">
								<span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
									<svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
										<path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
									</svg>
								</span>
								<h3 class="mb-1 text-base lg:text-lg font-medium text-gray-900 dark:text-white">Sekretaris DPUPR Kota Samarinda</h3>
								<time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">27 April 2021</time>
							</li>

							<li class="mb-8 ms-6">
								<span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
									<svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
										<path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
									</svg>
								</span>
								<h3 class="mb-1 text-base lg:text-lg font-medium text-gray-900 dark:text-white">Kepala Bidang Pelaksanaan Jaringan Sumber Air</h3>
								<time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">06 Desember 2017</time>
							</li>

							<li class="mb-8 ms-6">
								<span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
									<svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
										<path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
									</svg>
								</span>
								<h3 class="mb-1 text-base lg:text-lg font-medium text-gray-900 dark:text-white">Kepala Bidang Pemukiman</h3>
								<time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">18 Januari 2017</time>
							</li>

							<li class="mb-8 ms-6">
								<span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
									<svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
										<path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
									</svg>
								</span>
								<h3 class="mb-1 text-base lg:text-lg font-medium text-gray-900 dark:text-white">Kepala Bidang Pengendalian Banjir</h3>
								<time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">09 Oktober 2014</time>
							</li>

							<li class="mb-8 ms-6">
								<span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
									<svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
										<path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
									</svg>
								</span>
								<h3 class="mb-1 text-base lg:text-lg font-medium text-gray-900 dark:text-white">Kepala Bidang Bina Teknik</h3>
								<time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">07 Februari 2014</time>
							</li>
							
							<li class="ms-6">
								<span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
									<svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
										<path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
									</svg>
								</span>
								<h3 class="mb-1 text-base lg:text-lg font-medium text-gray-900 dark:text-white">Kepala UPTD Perawatan laboratorium</h3>
								<time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">29 April 2009</time>
							</li>
						</ol>				
					</div>
				</div> --}}

				{{-- Ini yang jadi dan sama panjang--}}
				<div class="flex flex-col justify-center items-center max-w-3xl mx-auto">
					<div class="hidden sm:grid sm:grid-cols-2 sm:gap-20">
						<h1 class="font-bold text-base md:text-lg lg:text-xl uppercase mb-2 text-end">Riwayat Pendidikan</h1>
						<h1 class="font-bold text-base md:text-lg lg:text-xl uppercase mb-2 text-start">Jenjang Karir</h1>
					</div>

					<div class="sm:grid sm:grid-cols-2 sm:gap-10 lg:gap-20">
						<h1 class="block sm:hidden font-bold text-base md:text-lg lg:text-xl uppercase mb-2 text-start">Riwayat Pendidikan</h1>                 
						<ol class="relative border-s sm:border-e sm:border-s-0 border-gray-200 text-start sm:text-end"> 
							@foreach ($riwayat_pendidikan as $item)
								<li class="mb-8 ms-6 sm:me-6">
									<span class="sm:flex absolute hidden items-center justify-center w-6 h-6 bg-blue-100 rounded-full sm:!-end-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
										<svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
											<path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
										</svg>
									</span>
									<span class="flex sm:hidden absolute items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
										<svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
											<path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
										</svg>
									</span>
									<h3 class="mb-1 text-base lg:text-lg font-medium text-gray-900 dark:text-white">{{ $item->nama_pendidikan }}</h3>
									{{-- <time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d M Y') }}
									</time> --}}
								</li>
							@endforeach
						</ol>	

						<h1 class="block sm:hidden font-bold text-base md:text-lg lg:text-xl uppercase mb-2 text-start mt-5">Jenjang Karir</h1>
						<ol class="relative border-s border-gray-200">  
							@foreach ($jenjang_karir as $item)
								<li class="mb-8 ms-6">
									<span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
										<svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
											<path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
										</svg>
									</span>
									<h3 class="mb-1 text-base lg:text-lg font-medium text-gray-900 dark:text-white">{{ $item->nama_karir }}</h3>
									<time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d M Y') }}</time>
								</li>								
							@endforeach                
						</ol>
					</div>
				</div>

				{{-- Ini versi Huda --}}
				{{-- <div class="mx-10 ">
					<div class="py-5">
						<h1 class="font-bold text-lg md:text-xl uppercase mb-3 text-center">Riwayat Pendidikan</h1>

						<ol class="ms-3 relative border-s border-gray-200 dark:border-gray-700">                  
							<li class="mb-10 ms-6">            
									<span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
											<svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
													<path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
											</svg>
									</span>
									<h3 class="flex items-center mb-1 text-lg font-medium text-gray-900 dark:text-white">Institut Teknologi Sepuluh Nopember S2 Teknik Sipil-Manajemen Aset</h3>
									<time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">2022</time>
							</li>
							<li class="mb-10 ms-6">
									<span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
											<svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
													<path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
											</svg>
									</span>
									<h3 class="mb-1 text-lg font-medium text-gray-900 dark:text-white">Universitas Institut Teknologi Nasional Malang S1 Teknik Sipil Perencanaan</h3>
									<time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">2021</time>
							</li>
							<li class="mb-10 ms-6">
								<span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
										<svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
												<path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
										</svg>
								</span>
								<h3 class="mb-1 text-lg font-medium text-gray-900 dark:text-white">SMA Negeri 1 Malang</h3>
								<time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">2021</time>
							</li>
							<li class="mb-10 ms-6">
								<span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
										<svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
												<path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
										</svg>
								</span>
								<h3 class="mb-1 text-lg font-medium text-gray-900 dark:text-white">SMP Negeri 1 Samarinda</h3>
								<time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">2021</time>
							</li>
							<li class="ms-6">
									<span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
											<svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
													<path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
											</svg>
									</span>
									<h3 class="mb-1 text-lg font-medium text-gray-900 dark:text-white">SD Negeri 005</h3>
									<time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">2021</time>
							</li>
						</ol>
					</div>

					<div>
						<h1 class="font-bold text-lg md:text-xl uppercase mb-3 text-center">Jenjang Karir</h1>

						<ol class="sm:flex">
							<li class="relative mb-6 sm:mb-0">
									<div class="flex items-center">
											<div class="z-10 flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full ring-0 ring-white dark:bg-blue-900 sm:ring-8 dark:ring-gray-900 shrink-0">
													<svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
															<path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
													</svg>
											</div>
											<div class="hidden sm:flex w-full bg-gray-200 h-0.5 dark:bg-gray-700"></div>
									</div>
									<div class="mt-3 sm:pe-3">
											<h3 class="text-lg font-medium text-gray-900 dark:text-white">Kepala UPTD Perawatan Laboratorium</h3>
											<time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">29 April 2009</time>
									</div>
							</li>
							<li class="relative mb-6 sm:mb-0">
								<div class="flex items-center">
										<div class="z-10 flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full ring-0 ring-white dark:bg-blue-900 sm:ring-8 dark:ring-gray-900 shrink-0">
												<svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
														<path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
												</svg>
										</div>
										<div class="hidden sm:flex w-full bg-gray-200 h-0.5 dark:bg-gray-700"></div>
								</div>
								<div class="mt-3 sm:pe-3">
										<h3 class="text-lg font-medium text-gray-900 dark:text-white">Kepala Bidang Bina Teknik</h3>
										<time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">07 Februari 2014</time>
								</div>
							</li>
							<li class="relative mb-6 sm:mb-0">
									<div class="flex items-center">
											<div class="z-10 flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full ring-0 ring-white dark:bg-blue-900 sm:ring-8 dark:ring-gray-900 shrink-0">
													<svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
															<path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
													</svg>
											</div>
											<div class="hidden sm:flex w-full bg-gray-200 h-0.5 dark:bg-gray-700"></div>
									</div>
									<div class="mt-3 sm:pe-3">
											<h3 class="text-lg font-medium text-gray-900 dark:text-white">Kepala Bidang Pengendalian Banjir</h3>
											<time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">09 Oktober 2014</time>
									</div>
							</li>
							<li class="relative mb-6 sm:mb-0">
									<div class="flex items-center">
											<div class="z-10 flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full ring-0 ring-white dark:bg-blue-900 sm:ring-8 dark:ring-gray-900 shrink-0">
													<svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
															<path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
													</svg>
											</div>
											<div class="hidden sm:flex w-full bg-gray-200 h-0.5 dark:bg-gray-700"></div>
									</div>
									<div class="mt-3 sm:pe-3">
											<h3 class="text-lg font-medium text-gray-900 dark:text-white">Kepala Bidang Pemukiman</h3>
											<time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">18 Januari 2017</time>
									</div>
							</li>
							<li class="relative mb-6 sm:mb-0">
								<div class="flex items-center">
										<div class="z-10 flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full ring-0 ring-white dark:bg-blue-900 sm:ring-8 dark:ring-gray-900 shrink-0">
												<svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
														<path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
												</svg>
										</div>
										<div class="hidden sm:flex w-full bg-gray-200 h-0.5 dark:bg-gray-700"></div>
								</div>
								<div class="mt-3 sm:pe-5">
										<h3 class="text-lg font-medium text-gray-900 dark:text-white">Kepala Bidang Pelaksanaan Jaringan Sumber Air</h3>
										<time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">06 Desember 2017</time>
								</div>
							</li>
							<li class="relative mb-6 sm:mb-0">
								<div class="flex items-center">
										<div class="z-10 flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full ring-0 ring-white dark:bg-blue-900 sm:ring-8 dark:ring-gray-900 shrink-0">
												<svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
														<path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
												</svg>
										</div>
										<div class="hidden sm:flex w-full bg-gray-200 h-0.5 dark:bg-gray-700"></div>
								</div>
								<div class="mt-3">
										<h3 class="text-lg font-medium text-gray-900 dark:text-white">Sekretaris DPUPR Kota Samarinda</h3>
										<time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">27 April 2021</time>
								</div>
							</li>
						</ol>				
					</div>
				</div> --}}
			</div>
		@endif
	</div>
</div>

@endsection