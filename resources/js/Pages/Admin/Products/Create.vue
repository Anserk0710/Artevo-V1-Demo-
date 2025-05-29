<template>
  <div class="max-w-md mx-auto p-5 bg-white rounded-md shadow ring-1 ring-gray-200">
    <h1 class="text-xl font-semibold mb-5 text-center text-gray-900 tracking-tight">Tambah Produk</h1>
    <form @submit.prevent="submit" novalidate class="space-y-5">
      <div>
        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
        <input
          id="name"
          v-model="form.name"
          type="text"
          placeholder="Masukkan nama produk"
          class="w-full border border-gray-300 p-2.5 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-150 ease-in-out"
          :class="{'border-red-500': form.errors.name}"
        />
        <p v-if="form.errors.name" class="text-red-600 text-xs mt-1">{{ form.errors.name }}</p>
      </div>

      <div>
        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
        <textarea
          id="description"
          v-model="form.description"
          placeholder="Deskripsikan produk secara singkat"
          rows="4"
          class="w-full border border-gray-300 p-2.5 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-150 ease-in-out resize-none"
          :class="{'border-red-500': form.errors.description}"
        ></textarea>
        <p v-if="form.errors.description" class="text-red-600 text-xs mt-1">{{ form.errors.description }}</p>
      </div>

      <div class="grid grid-cols-2 gap-3">
        <div>
          <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
          <input
            id="price"
            type="number"
            v-model="form.price"
            placeholder="Rp"
            class="w-full border border-gray-300 p-2.5 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-150 ease-in-out"
            :class="{'border-red-500': form.errors.price}"
          />
          <p v-if="form.errors.price" class="text-red-600 text-xs mt-1">{{ form.errors.price }}</p>
        </div>

        <div>
          <label for="size" class="block text-sm font-medium text-gray-700 mb-1">Ukuran</label>
          <input
            id="size"
            v-model="form.size"
            placeholder="Contoh: 40cm x 80cm"
            class="w-full border border-gray-300 p-2.5 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-150 ease-in-out"
            :class="{'border-red-500': form.errors.size}"
          />
          <p v-if="form.errors.size" class="text-red-600 text-xs mt-1">{{ form.errors.size }}</p>
        </div>
      </div>

      <div>
        <label for="material" class="block text-sm font-medium text-gray-700 mb-1">Bahan</label>
        <input
          id="material"
          v-model="form.material"
          placeholder="Jenis bahan produk"
          class="w-full border border-gray-300 p-2.5 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-150 ease-in-out"
          :class="{'border-red-500': form.errors.material}"
        />
        <p v-if="form.errors.material" class="text-red-600 text-xs mt-1">{{ form.errors.material }}</p>
      </div>

      <div>
        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Gambar</label>
        <input
          id="image"
          type="file"
          @change="onFileChange"
          accept="image/*"
          class="w-full border border-gray-300 p-2.5 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-150 ease-in-out"
          :class="{'border-red-500': form.errors.image || imageError}"
        />
        <p v-if="form.errors.image" class="text-red-600 text-xs mt-1">{{ form.errors.image }}</p>
        <p v-if="imageError" class="text-red-600 text-xs mt-1">{{ imageError }}</p>
        <div v-if="imageFile" class="mt-3">
          <p class="text-sm font-semibold mb-1 text-gray-800">Preview Gambar:</p>
          <img :src="URL.createObjectURL(imageFile)" alt="Preview Gambar Produk" class="w-full h-36 object-contain rounded-md border border-gray-300 shadow-sm" />
        </div>
      </div>

      <button
        :disabled="form.processing"
        type="submit"
        class="w-full bg-blue-600 text-white py-2.5 rounded-md font-semibold hover:bg-blue-700 transition duration-150 ease-in-out disabled:opacity-50 disabled:cursor-not-allowed focus:outline-none focus:ring-2 focus:ring-blue-400"
      >
        Simpan
      </button>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue'
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
  form.post(route('products.store'), {
    forceFormData: true,
  })
}
</script>
