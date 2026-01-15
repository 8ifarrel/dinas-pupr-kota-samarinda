@if (session('status'))
  <div class="max-w-4xl mx-auto px-4 mt-4">
    <div class="rounded-xl border bg-green-50 text-green-800 px-4 py-3">
      {{ session('status') }}
    </div>
  </div>
@endif

@if ($errors->any())
  <div class="max-w-4xl mx-auto px-4 mt-4">
    <div class="rounded-xl border bg-red-50 text-red-800 px-4 py-3">
      <ul class="list-disc ml-5">
        @foreach ($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  </div>
@endif
