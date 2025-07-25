@if (isset($page_subtitle) && $page_subtitle)
  <div class="text-center mb-2 lg:mb-3">
    <span
      class="bg-brand-blue uppercase font-bold text-brand-yellow text-sm lg:text-base me-2 px-4 py-1 rounded-full dark:bg-blue-900 dark:text-blue-300">{{ $page_subtitle }}
    </span>
  </div>
@endif


<h1 class="text-center font-bold text-2xl lg:text-3xl pb-6 lg:pb-12 whitespace-pre-line">{{ $page_title }}</h1>
