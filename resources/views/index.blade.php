@extends('layouts.main')

@section('title', 'Ultrafort - Home')

@section('content')




<div class="relative pt-18 pb-24 sm:pb-32 lg:pt-36 lg:pb-62">
  <div class="container mx-auto px-4 relative">
    <div class="max-w-lg xl:max-w-xl mx-auto text-center">
      <h1 class="font-heading text-5xl xs:text-7xl xl:text-8xl tracking-tight text-white mb-8">ULTRALIGHT</h1>
      <p class="max-w-md xl:max-w-none text-lg text-white opacity-80 mb-10">Simpel, ringan, tapi siap hadapi cuaca dan waktu. Karena keamanan bukan tentang beratnya perlengkapan, tapi cerdasnya pilihan.</p><a class="inline-flex py-4 px-6 items-center justify-center text-lg font-medium text-teal-900 border border-lime-500 hover:border-white bg-lime-500 hover:bg-white rounded-full transition duration-200" href="{{ route('katalog')}}">See our solutions</a>
    </div>
  </div>
</div>
</section>
</div>
<section class="py-12 lg:py-24">
  <div class="container mx-auto px-4">
    <div class="flex flex-wrap -mx-4">
      <div class="w-full sm:w-1/2 md:w-1/4 px-4 mb-10 md:mb-0">
        <div class="text-center">
          <h5 class="text-2xl xs:text-3xl lg:text-4xl xl:text-5xl mb-4">10 Kg</h5><span class="text-base lg:text-lg text-gray-700">Beban Berkurang. Kebebasan Bertambah.</span>
        </div>
      </div>
      <div class="w-full sm:w-1/2 md:w-1/4 px-4 mb-10 md:mb-0">
        <div class="text-center">
          <h5 class="text-2xl xs:text-3xl lg:text-4xl xl:text-5xl mb-4">2,500+</h5><span class="text-base lg:text-lg text-gray-700">Pendaki Sudah Beralih ke Ultralight Life.</span>
        </div>
      </div>
      <div class="w-full sm:w-1/2 md:w-1/4 px-4 mb-10 sm:mb-0">
        <div class="text-center">
          <h5 class="text-2xl xs:text-3xl lg:text-4xl xl:text-5xl mb-4">100+</h5><span class="text-base lg:text-lg text-gray-700">Gunung sudah kami Uji</span>
        </div>
      </div>
      <div class="w-full sm:w-1/2 md:w-1/4 px-4">
        <div class="text-center">
          <h5 class="text-2xl xs:text-3xl lg:text-4xl xl:text-5xl mb-4">75%</h5><span class="text-base lg:text-lg text-gray-700">Lebih Efisiean</span>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="relative py-12 lg:py-24 overflow-hidden"><img class="absolute top-0 right-0" src="fauna-assets/pricing/waves-right-top.png" alt="" />
  <div class="container mx-auto px-4 relative">
    <div class="max-w-2xl mx-auto text-center mb-20">
      <h1 class="font-heading text-5xl sm:text-6xl tracking-xs mb-6">Best Seller</h1>
      <p class="text-lg text-gray-700">Produk favorit para ultralighter! Dipakai dan direkomendasikan oleh komunitas pendaki dari berbagai daerah.</p>
    </div>
    <div class="flex flex-wrap -mx-4 mb-24">
      <div class="w-full lg:w-1/3 px-4 mb-8 lg:mb-0">
        <div class="relative pt-14 pb-8 px-8 bg-orange-50 rounded-2xl overflow-hidden"> <img src="fauna-assets/content/kompor.webp" alt="">
          <div class="absolute top-0 left-0 h-1 w-full bg-lime-500"></div><span class="block text-2xl font-medium mb-6">Firemaple Kompor Lipat</span>
          <div class="flex items-center mb-6"><span class="text-red-600 text-3xl" style="color: #dc2626;">Rp. 200.000</span>
            <span class="ml-4 line-through  text-xl font-medium text-gray-700 ">Disc 20%</span>
          </div>
          <a class="inline-flex w-full group py-4 px-6 items-center justify-center text-lg font-medium text-black hover:text-white border border-teal-900 hover:bg-teal-900 rounded-full transition duration-200" href="{{ route('produk.detail', 2) }}"><span class="mr-2">Get started</span> <span class="transform group-hover:translate-x-1 transition-transform duration-200">
              <svg width="21" height="20" viewbox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5.25 10H15.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M10.5 4.75L15.75 10L10.5 15.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
              </svg></span></a>
        </div>
      </div>
      <div class="w-full lg:w-1/3 px-4 mb-8 lg:mb-0">
        <div class="relative pt-14 pb-8 px-8 bg-lime-500 rounded-2xl overflow-hidden"><img src="fauna-assets/content/bsmsk.webp" alt="">
          <div class="absolute top-0 left-0 w-full py-0.5 flex items-center justify-center bg-teal-900"><span class="text-xs leading-7 text-white">TOP 1</span></div><span class="block text-2xl font-medium mb-6">Blacksherpa Moska Pro</span>
          <div class="flex items-center mb-6"><span class="text-red-600 text-3xl style=" color: #dc2626;">Rp. 1.200.000</span> </div>
          <a class="inline-flex w-full group py-4 px-6 items-center justify-center text-lg font-medium text-black hover:text-white border border-teal-900 hover:bg-teal-900 rounded-full transition duration-200" href="{{ route('produk.detail', 1) }}"><span class="mr-2">Get started</span> <span class="transform group-hover:translate-x-1 transition-transform duration-200">
              <svg width="21" height="20" viewbox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5.25 10H15.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M10.5 4.75L15.75 10L10.5 15.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
              </svg></span></a>
        </div>
      </div>
      <div class="w-full lg:w-1/3 px-4">
        <div class="relative pt-14 pb-8 px-8 bg-orange-50 rounded-2xl overflow-hidden"><img src="fauna-assets/content/bsking.webp" alt="">
          <div class="absolute top-0 left-0 h-1 w-full bg-lime-500"></div><span class="block text-2xl font-medium mb-6">Sleeping bag Base King</span>
          <span class="text-red-600 text-3xl" style="color: #dc2626;">Rp. 350.000</span>><a class="inline-flex w-full group py-4 px-6 items-center justify-center text-lg font-medium text-black hover:text-white border border-teal-900 hover:bg-teal-900 rounded-full transition duration-200" href="{{ route('produk.detail', 3) }}"><span class="mr-2">Get started</span> <span class="transform group-hover:translate-x-1 transition-transform duration-200">
              <svg width="21" height="20" viewbox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5.25 10H15.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M10.5 4.75L15.75 10L10.5 15.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
              </svg></span></a>
        </div>
      </div>
    </div>

  </div>
</section>
<section class="p-4 bg-white">
  <div class="pt-16 pb-24 px-5 xs:px-8 xl:px-12 bg-lime-500 rounded-3xl">
    <div class="container mx-auto px-4">
      <div class="flex mb-4 items-center">
        <svg width="8" height="8" viewbox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="4" cy="4" r="4" fill="#022C22"></circle>
        </svg><span class="inline-block ml-2 text-sm font-medium">UL GEAR</span>
      </div>
      <div class="border-t border-teal-900 border-opacity-25 pt-14">
        <h1 class="font-heading text-4xl sm:text-6xl mb-24">Kategory</h1>
        <div class="flex flex-wrap -mx-4">
          <div class="w-full sm:w-1/2 px-4 mb-16">
            <div>
              <img src="fauna-assets/content/tent.jpg" width="170" height="48" alt="">

              <path d="M0 8C0 3.58172 3.58172 0 8 0H40C44.4183 0 48 3.58172 48 8V40C48 44.4183 44.4183 48 40 48H8C3.58172 48 0 44.4183 0 40V8Z" fill="white"></path>
              <circle cx="16" cy="16" r="4" fill="#022C22"></circle>
              <circle cx="24" cy="32" r="4" fill="#022C22"></circle>
              <circle cx="32" cy="16" r="4" fill="#022C22"></circle>
              </svg>
              <div class="mt-6">
                <h5 class="text-2xl font-medium mb-3">Tenda </h5>
                <p class="mb-6">Perlindungan maksimal dengan bobot minimal. Tenda ultralight kami mudah dipasang, tahan cuaca, dan compact saat dikemas — solusi ideal bagi pendaki yang mengejar keseimbangan antara kenyamanan dan kepraktisan.</p><a class="inline-block text-lg  font-medium hover:text-teal-700" href="#!">Read more</a>
              </div>
            </div>
          </div>
          <div class="w-full sm:w-1/2 px-4 mb-16">
            <div>
              <img src="fauna-assets/content/sb.jpg" width="70" height="48" alt="">
              <path d="M0 8C0 3.58172 3.58172 0 8 0H40C44.4183 0 48 3.58172 48 8V40C48 44.4183 44.4183 48 40 48H8C3.58172 48 0 44.4183 0 40V8Z" fill="white"></path>
              <rect x="23" y="8" width="2" height="12" rx="1" fill="#022C22"></rect>
              <rect x="23" y="28" width="2" height="12" rx="1" fill="#022C22"></rect>
              <rect x="34.6066" y="11.9792" width="2" height="12" rx="1" transform="rotate(45 34.6066 11.9792)" fill="#022C22"></rect>
              <rect x="20.4645" y="26.1213" width="2" height="12" rx="1" transform="rotate(45 20.4645 26.1213)" fill="#022C22"></rect>
              <rect x="28" y="25" width="2" height="12" rx="1" transform="rotate(-90 28 25)" fill="#022C22"></rect>
              <rect x="8" y="25" width="2" height="12" rx="1" transform="rotate(-90 8 25)" fill="#022C22"></rect>
              <rect x="26.1213" y="27.5355" width="2" height="12" rx="1" transform="rotate(-45 26.1213 27.5355)" fill="#022C22"></rect>
              <rect x="11.9792" y="13.3934" width="2" height="12" rx="1" transform="rotate(-45 11.9792 13.3934)" fill="#022C22"></rect>
              </svg>
              <div class="mt-6">
                <h5 class="text-2xl font-medium mb-3">Sleeping Sistem</h5>
                <p class="mb-6">Nikmati istirahat optimal setelah perjalanan panjang. Sleeping system kami dirancang dengan material ringan, kompak, dan tetap hangat — memastikan tidur nyaman di alam terbuka tanpa menambah beban di ransel.</p><a class="inline-block text-lg  font-medium hover:text-teal-700" href="#!">Read more</a>
              </div>
            </div>
          </div>
          <div class="w-full sm:w-1/2 px-4 mb-16 sm:mb-0">
            <div>
              <img src="fauna-assets/content/cookingset.jpg" width="140" height="48" alt="">
              <path d="M0 8C0 3.58172 3.58172 0 8 0H40C44.4183 0 48 3.58172 48 8V40C48 44.4183 44.4183 48 40 48H8C3.58172 48 0 44.4183 0 40V8Z" fill="white"></path>
              <path d="M25 24C25 24.5523 24.5523 25 24 25C23.4477 25 23 24.5523 23 24C23 23.4477 23.4477 23 24 23C24.5523 23 25 23.4477 25 24Z" fill="#022C22"></path>
              <path fill-rule="evenodd" clip-rule="evenodd" d="M24 25C24.5523 25 25 24.5523 25 24C25 23.4477 24.5523 23 24 23C23.4477 23 23 23.4477 23 24C23 24.5523 23.4477 25 24 25Z" fill="#022C22"></path>
              <path fill-rule="evenodd" clip-rule="evenodd" d="M40 23C40.5523 23 41 23.4477 41 24C41 33.3888 33.3888 41 24 41C23.4477 41 23 40.5523 23 40C23 39.4477 23.4477 39 24 39C32.2843 39 39 32.2843 39 24C39 23.4477 39.4477 23 40 23Z" fill="#022C22"></path>
              <path fill-rule="evenodd" clip-rule="evenodd" d="M24 9C15.7157 9 9 15.7157 9 24C9 24.5523 8.55228 25 8 25C7.44772 25 7 24.5523 7 24C7 14.6112 14.6112 7 24 7C24.5523 7 25 7.44772 25 8C25 8.55228 24.5523 9 24 9Z" fill="#022C22"></path>
              <path fill-rule="evenodd" clip-rule="evenodd" d="M36 23C36.5523 23 37 23.4477 37 24C37 31.1797 31.1797 37 24 37C23.4477 37 23 36.5523 23 36C23 35.4477 23.4477 35 24 35C30.0751 35 35 30.0751 35 24C35 23.4477 35.4477 23 36 23Z" fill="#022C22"></path>
              <path fill-rule="evenodd" clip-rule="evenodd" d="M24 13C17.9249 13 13 17.9249 13 24C13 24.5523 12.5523 25 12 25C11.4477 25 11 24.5523 11 24C11 16.8203 16.8203 11 24 11C24.5523 11 25 11.4477 25 12C25 12.5523 24.5523 13 24 13Z" fill="#022C22"></path>
              <path fill-rule="evenodd" clip-rule="evenodd" d="M32 23C32.5523 23 33 23.4477 33 24C33 28.9706 28.9706 33 24 33C23.4477 33 23 32.5523 23 32C23 31.4477 23.4477 31 24 31C27.866 31 31 27.866 31 24C31 23.4477 31.4477 23 32 23Z" fill="#022C22"></path>
              <path fill-rule="evenodd" clip-rule="evenodd" d="M24 17C20.134 17 17 20.134 17 24C17 24.5523 16.5523 25 16 25C15.4477 25 15 24.5523 15 24C15 19.0294 19.0294 15 24 15C24.5523 15 25 15.4477 25 16C25 16.5523 24.5523 17 24 17Z" fill="#022C22"></path>
              </svg>
              <div class="mt-6">
                <h5 class="text-2xl font-medium mb-3">Cooking Set</h5>
                <p class="mb-6">Rasakan kemudahan memasak di gunung dengan peralatan ultralight yang efisien dan tahan lama. Dari kompor mini hingga set masak lipat, semua dirancang untuk hemat ruang, hemat bahan bakar, dan cepat digunakan.</p><a class="inline-block text-lg  font-medium hover:text-teal-700" href="#!">Read more</a>
              </div>
            </div>
          </div>
          <div class="w-full sm:w-1/2 px-4">
            <div>
              <img src="fauna-assets/content/bags.jpg" width="70" height="48" alt="">
              <path d="M0 8C0 3.58172 3.58172 0 8 0H40C44.4183 0 48 3.58172 48 8V40C48 44.4183 44.4183 48 40 48H8C3.58172 48 0 44.4183 0 40V8Z" fill="white"></path>
              <path d="M23.8425 12.3779C23.9008 12.238 24.0992 12.238 24.1575 12.3779L30.1538 26.7692C31.9835 31.1605 28.7572 36 24 36Lnan nanL24 36C19.2428 36 16.0165 31.1605 17.8462 26.7692L23.8425 12.3779Z" fill="#022C22"></path>
              </svg>
              <div class="mt-6">
                <h5 class="text-2xl font-medium mb-3">Bags</h5>
                <p class="mb-6">Bawa lebih ringan, jelajah lebih jauh. Rangkaian tas dan carrier ultralight kami mengutamakan ergonomi, daya tahan, serta distribusi beban yang seimbang agar langkah tetap stabil di setiap medan.</p><a class="inline-block text-lg  font-medium hover:text-teal-700" href="#!">Read more</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>



<div>
  <div>

    @endsection