<template>
  <div
    class="max-w-lg mx-auto p-6 bg-white rounded-lg shadow-lg ring-1 ring-gray-300 opacity-0 transform translate-y-6"
    :class="{'opacity-100 translate-y-0 transition-all duration-700 ease-out': animate}"
  >
    <h1 class="text-2xl font-bold mb-6 text-center text-gray-900 tracking-tight">Tambah Produk</h1>
    <form @submit.prevent="submit" novalidate class="space-y-6">
      <div>
        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Produk</label>
        <input
          id="name"
          v-model="form.name"
          type="text"
          placeholder="Masukkan nama produk"
          class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-400 transition duration-300 ease-in-out"
          :class="{'border-red-500 animate-shake': form.errors.name}"
        />
        <p v-if="form.errors.name" class="text-red-600 text-xs mt-1 animate-pulse">{{ form.errors.name }}</p>
      </div>

      <div>
        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
        <textarea
          id="description"
          v-model="form.description"
          placeholder="Deskripsikan produk secara singkat"
          rows="5"
          class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-400 transition duration-300 ease-in-out resize-none"
          :class="{'border-red-500 animate-shake': form.errors.description}"
        ></textarea>
        <p v-if="form.errors.description" class="text-red-600 text-xs mt-1 animate-pulse">{{ form.errors.description }}</p>
      </div>

      <div class="grid grid-cols-2 gap-6">
        <div>
          <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">Harga</label>
          <input
            id="price"
            type="number"
            v-model="form.price"
            placeholder="Rp"
            class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-400 transition duration-300 ease-in-out"
            :class="{'border-red-500 animate-shake': form.errors.price}"
          />
          <p v-if="form.errors.price" class="text-red-600 text-xs mt-1 animate-pulse">{{ form.errors.price }}</p>
        </div>

        <div>
          <label for="size" class="block text-sm font-semibold text-gray-700 mb-2">Ukuran</label>
          <input
            id="size"
            v-model="form.size"
            placeholder="Contoh: 40cm x 80cm"
            class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-400 transition duration-300 ease-in-out"
            :class="{'border-red-500 animate-shake': form.errors.size}"
          />
          <p v-if="form.errors.size" class="text-red-600 text-xs mt-1 animate-pulse">{{ form.errors.size }}</p>
        </div>
      </div>

      <div>
        <label for="material" class="block text-sm font-semibold text-gray-700 mb-2">Bahan</label>
        <input
          id="material"
          v-model="form.material"
          placeholder="Jenis bahan produk"
          class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-400 transition duration-300 ease-in-out"
          :class="{'border-red-500 animate-shake': form.errors.material}"
        />
        <p v-if="form.errors.material" class="text-red-600 text-xs mt-1 animate-pulse">{{ form.errors.material }}</p>
      </div>

      <div>
        <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">Gambar</label>
        <input
          id="image"
          type="file"
          @change="onFileChange"
          accept="image/*"
          class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-400 transition duration-300 ease-in-out"
          :class="{'border-red-500': form.errors.image || imageError}"
        />
        <p v-if="form.errors.image" class="text-red-600 text-xs mt-1 animate-pulse">{{ form.errors.image }}</p>
        <p v-if="imageError" class="text-red-600 text-xs mt-1 animate-pulse">{{ imageError }}</p>
        <div v-if="imageFile" class="mt-3 opacity-0 transition-opacity duration-700 ease-in-out" :class="{'opacity-100': imageFile !== null}">
          <p class="text-sm font-semibold mb-1 text-gray-800">Preview Gambar:</p>
          <img v-if="imageFile !== null" :src="URL.createObjectURL(imageFile)" alt="Preview Gambar Produk" class="w-full h-36 object-contain rounded-md border border-gray-300 shadow-sm" />
        </div>
      </div>

      <button
        :disabled="form.processing"
        type="submit"
        class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300 ease-in-out disabled:opacity-50 disabled:cursor-not-allowed focus:outline-none focus:ring-4 focus:ring-blue-400 flex justify-center items-center shadow-md"
      >
        <svg v-if="form.processing" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
        </svg>
        Simpan
      </button>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useForm } from '@inertiajs/vue3'

const form = useForm({
  name: '',
  description: '',
  price: '',
  size: '',
  material: '',
  image: null, // change to null for file upload
})

const imageFile = ref(null)
const imageError = ref('')
const animate = ref(false)

function onFileChange(event) {
  const file = event.target.files[0]
  if (file && file.size > 2 * 1024 * 1024) { // 2MB limit
    imageError.value = 'Ukuran gambar terlalu besar. Maksimal 2MB.'
    imageFile.value = null
    form.image = null
  } else {
    imageError.value = ''
    imageFile.value = file
    form.image = file
  }
}

function submit() {
  form.post(route('admin.products.store'), {
    forceFormData: true,
  })
}

onMounted(() => {
  animate.value = true
})
</script>

<style>
@keyframes shake {
  0%, 100% {
    transform: translateX(0);
  }
  20%, 60% {
    transform: translateX(-6px);
  }
  40%, 80% {
    transform: translateX(6px);
  }
}

.animate-shake {
  animation: shake 0.4s ease-in-out;
}
</style>