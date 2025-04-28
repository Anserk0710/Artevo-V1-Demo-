<script setup>
defineProps({
  product: Object
});
</script>

<template>
  <div class="w-full h-screen p-10 bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 flex flex-col">
    <nav class="mb-8 text-base text-gray-700" aria-label="Breadcrumb">
      <ol class="list-reset flex">
        <li><a href="/products" class="text-yellow-500 hover:underline" style="text-shadow: 1px 1px 2px black;">Produk</a></li>
        <li><span class="mx-3 text-gray-400" style="text-shadow: 1px 1px 2px black;">/</span></li>
        <li class="text-gray-500" style="text-shadow: 1px 1px 2px black;">{{ product.name }}</li>
      </ol>
    </nav>
    <div class="flex flex-1 flex-col md:flex-row md:space-x-12">
      <div class="md:w-1/2 flex justify-center items-end mb-8 md:mb-0" style="max-height: 600px;">
        <img
          :src="product.image || 'https://via.placeholder.com/600x600.png?text=Product+Image'"
          alt="Product Image"
          class="rounded-lg object-cover w-full max-h-full max-w-full shadow-md"
          style="max-height: 100%; max-width: 100%;"
        />
      </div>
      <div class="md:w-1/2 flex flex-col justify-between px-6 h-full text-black">
        <div>
          <h1 class="text-5xl font-extrabold mb-6 text-yellow-500" style="text-shadow: 2px 2px 4px black;">{{ product.name }}</h1>
          <p class="text-2xl text-yellow-400 font-semibold mb-6" style="text-shadow: 1px 1px 3px black;">Harga: Rp {{ product.price.toLocaleString() }}</p>
          <p class="text-lg mb-6" style="text-shadow: 1px 1px 2px black;">{{ product.description }}</p>
          <div class="flex space-x-10 mb-8">
            <div class="flex items-center space-x-3 text-yellow-400" style="text-shadow: 1px 1px 2px black;">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h4l3 8 4-16 3 8h4" />
              </svg>
              <span class="text-lg"><strong>Ukuran:</strong> {{ product.size }}</span>
            </div>
            <div class="flex items-center space-x-3 text-yellow-400" style="text-shadow: 1px 1px 2px black;">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m8.485-9h-1M4.515 12h-1m15.364 4.95l-.707-.707M6.343 6.343l-.707-.707m12.728 12.728l-.707-.707M6.343 17.657l-.707-.707" />
              </svg>
              <span class="text-lg"><strong>Bahan:</strong> {{ product.material }}</span>
            </div>
          </div>
        </div>
        <button
          type="button"
          class="inline-flex items-center px-8 py-4 bg-yellow-400 text-black text-lg font-semibold rounded-lg shadow-md hover:bg-yellow-500 transition duration-300 self-start"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m5-9v9m4-9v9m4-9l2 9" />
          </svg>
          Beli Sekarang
        </button>
      </div>
    </div>
  </div>
</template>
