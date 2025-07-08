<nav class="fixed top-0 z-40 w-full bg-white border-b border-gray-200">
  <div class="px-3 py-3 lg:px-5 lg:pl-3">
    <div class="flex items-center justify-between">
      <div class="flex items-center justify-start rtl:justify-end">
        <button
          class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200"
          data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button">

          <span class="sr-only">
            Open sidebar
          </span>

          <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path
              d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"
              clip-rule="evenodd" fill-rule="evenodd">
            </path>
          </svg>
        </button>

        <a class="flex ms-2 md:me-24" href="{{ route('admin.dashboard.index') }}">
          <img class="h-11 me-3 my-auto" src="{{ config('app.logo_dinas') }}" alt="{{ config('app.nama_dinas') }}" />

          <div class="flex flex-col justify-center">
            <span class="text-xl sm:text-sm font-semibold whitespace-nowrap">
              E-Panel
            </span>

            <span class="hidden sm:block text-xl font-semibold whitespace-nowrap">
              {{ config('app.nama_singkatan_dinas') }}
            </span>
          </div>
        </a>
      </div>

      <div class="flex items-center">
        <div class="flex items-center ms-3">
          <div>
            <button class="flex" type="button" aria-expanded="false" data-dropdown-toggle="dropdown-user">

              <span class="sr-only">
                Open user menu
              </span>

              <i class="fa-solid fa-circle-user fa-xl"></i>
            </button>
          </div>

          <div class="z-40 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow"
            id="dropdown-user">
            <div class="px-4 py-3" role="none">

              <p class="text-sm text-gray-900 font-semibold" role="none">
                {{ Auth::user()->fullname }}
              </p>

              <p class="text-sm text-gray-900" role="none">
                {{ Auth::user()->susunanOrganisasi->nama_susunan_organisasi ?? 'Super Admin' }}
              </p>
            </div>
            <ul class="py-1" role="none">
              <li>
                <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="#" role="menuitem">
                  Kelola Akun
                </a>
              </li>
              <li>
                <form method="POST" action="{{ route('admin.logout') }}">
                  @csrf
                  <button class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" type="submit">
                    Log out
                  </button>
                </form>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</nav>
