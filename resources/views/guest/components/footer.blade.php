<footer class="bg-[#D9D9D9D9] flex flex-col items-center">
  <div
    class="xs:grid xs:grid-cols-2 md:grid-cols-[auto_auto_300px] lg:grid-cols-[auto_auto_350px] lg:w-[930px] xl:w-auto lg:auto-cols-auto xl:flex xl:justify-between p-[1.35rem] md:p-8 lg:py-8 lg:px-0 xl:p-12 xl:h-[360px]">
    <figure class="xs:col-span-2 md:col-span-3 mb-4 xl:mb-0 xl:w-[35%]">
      <span class="flex gap-2 mb-1 xl:mb-2">
        <img class="h-[50px] xl:h-[75px]" src="{{ asset('image/logo/pemkot-samarinda.png') }}"
          alt="Pemerintah Kota Samarinda" />
        <img class="h-[50px] xl:h-[75px]" src="{{ config('app.logo_dinas') }}" alt="{{ config('app.nama_dinas') }}" />
      </span>

      <figcaption class="font-bold text-lg lg:text-xl uppercase mb-1 xl:mb-2">
        {{ config('app.nama_dinas') }}
      </figcaption>

      <figcaption>
        Jalan H. Achmad Amins, Kelurahan Gn. Lingai, Kecamatan Sungai Pinang, Kota Samarinda, Provinsi Kalimantan Timur,
        75117
      </figcaption>
    </figure>

    <ul class="mb-3 lg:mb-0 xl:mb-0 text-base xl:text-lg p-0 m-0 flex flex-col justify-between w-fit">
      <li class="mb-1 xs:mb-0 font-bold text-lg xl:text-xl">
        TAUTAN PENTING
      </li>
      <li>
        <a href="{{ route('guest.portal.index') }}">
          <i class="fa-solid fa-thumbtack me-1" style="color: #080808;"></i>
          Portal
        </a>
      </li>
      <li>
        <a href="{{ url('https://simbg.pu.go.id/') }}" target="_blank">
          <i class="fa-solid fa-thumbtack me-1" style="color: #080808;"></i>
          SIMBG
        </a>
      </li>
      <li>
        <a href="{{ url('https://sijakon.samarindakota.go.id/') }}" target="_blank">
          <i class="fa-solid fa-thumbtack me-1" style="color: #080808;"></i>
          Sijakon
        </a>
      </li>
      <li>
        <a href="{{ url('https://gistaru.samarindakota.go.id/') }}" target="_blank">
          <i class="fa-solid fa-thumbtack me-1" style="color: #080808;"></i>
          Gistaru
        </a>
      </li>
      <li>
        <span>
          <i class="fa-solid fa-thumbtack me-1" style="color: #080808;"></i>
          Jalan Peduli (soon)
        </span>
      </li>
    </ul>
    <ul
      class="xs:mx-auto sm:mx-0 mb-3 lg:mb-0 xl:mb-0 text-base xl:text-lg p-0 m-0 flex flex-col justify-between w-fit">
      <li class="mb-1 xs:mb-0 font-bold text-lg xl:text-xl">
        KONTAK KAMI
      </li>
      <li>
        <a href="https://www.facebook.com/dpuprkotasamarinda/" target="_blank" class="flex items-center">
          <i class="fa-brands fa-facebook me-1" style="color: #000000;"></i>
          Facebook
        </a>
      </li>
      <li>
        <a href="https://www.instagram.com/dpuprkotasamarinda/" target="_blank" class="flex items-center">
          <i class="fa-brands fa-instagram me-1" style="color: #000000;"></i>
          Instagram
        </a>
      </li>
      <li>
        <a href="https://www.youtube.com/@dinaspuprkotasamarinda" target="_blank" class="flex items-center">
          <i class="fa-brands fa-youtube me-1" style="color: #000000;"></i>
          YouTube
        </a>
      </li>
      <li>
        <a href="mailto:dpuprkotasamarinda@gmail.com" class="flex items-center">
          <i class="fa-regular fa-envelope me-1" style="color: #000000;"></i>
          Email
        </a>
      </li>
      <li>
        <a href="tel:0541203785" class="flex items-center">
          <i class="fa-solid fa-phone me-1" style="color: #000000;"></i>
          0541-203785
        </a>
      </li>
      <li>
        <a href="tel:0541732072" class="flex items-center">
          <i class="fa-solid fa-phone me-1" style="color: #000000;"></i>
          0541-732072
        </a>
      </li>
    </ul>

    <div>
      <h1 class="mb-1 font-bold text-lg xl:text-xl">
        PETA
      </h1>
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.690298112536!2d117.17512067507042!3d-0.45899179953650165!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df5d6033b793f91%3A0xe380dade32764edd!2sKantor%20PUPR%20Samarinda!5e0!3m2!1sen!2sid!4v1704714282337!5m2!1sen!2sid"
        class="h-[193.517px] w-[250px] xs:w-[300px] lg:w-[350px]" style="border:0;" allowfullscreen="" loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
  </div>

  <div class="bg-brand-blue p-1.5 w-full">
    <p class="text-white text-center text-sm">
      © 2024 {{ config('app.nama_dinas') }}. <br>
      Powered by Tim IT {{ config('app.nama_singkatan_dinas') }}.
    </p>
  </div>
</footer>
