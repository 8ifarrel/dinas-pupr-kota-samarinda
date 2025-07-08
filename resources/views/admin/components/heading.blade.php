<div class="mb-5 flex flex-col gap-1">
  <h1
    class="relative inline-block font-semibold text-2xl md:text-3xl text-gray-800 
     after:content-[''] after:inline-block after:h-[3px] after:bg-black after:align-middle
     after:ml-1 after:sm:min-w-[75px] after:min-w-[60px]">
    {{ $page_title }}
  </h1>

  @if (!empty($page_description))
    <p class="text-gray-600 text-sm md:text-base leading-relaxed">
      {{ $page_description }}
    </p>
  @endif
</div>
