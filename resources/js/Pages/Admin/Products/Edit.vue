<template>
    <div class="max-w-lg mx-auto p-4 bg-white rounded shadow">
      <h1 class="text-2xl font-bold mb-4">Edit Produk</h1>
      <form @submit.prevent="submit" novalidate class="space-y-5" v-if="form">
        <div v-for="field in fields" :key="field.name" class="mb-3">
          <label class="block mb-1 font-medium text-gray-700">{{ field.label }}</label>
          <input
            v-model="form[field.name]"
            :type="field.type || 'text'"
            class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
          />
          <p v-if="form.errors && form.errors[field.name]" class="text-red-600 text-xs mt-1">{{ form.errors[field.name] }}</p>
        </div>
        
        <div class="mb-3">
          <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Gambar</label>
          <input
            id="image"
            type="file"
            @change="onFileChange"
            accept="image/*"
            class="w-full border border-gray-300 p-2.5 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-150 ease-in-out"
            :class="{'border-red-500': (form.errors && form.errors.image) || imageError}"
          />
          <p v-if="form.errors && form.errors.image" class="text-red-600 text-xs mt-1">{{ form.errors.image }}</p>
          <p v-if="imageError" class="text-red-600 text-xs mt-1">{{ imageError }}</p>
          
          <!-- Current Image -->
          <div v-if="currentImage && !imagePreview" class="mt-3">
            <p class="text-sm font-semibold mb-1 text-gray-800">Gambar Saat Ini:</p>
            <img :src="currentImage" alt="Current Product Image" class="w-full h-36 object-contain rounded-md border border-gray-300 shadow-sm" />
          </div>
          
          <!-- New Image Preview -->
          <div v-if="imagePreview" class="mt-3">
            <p class="text-sm font-semibold mb-1 text-gray-800">Preview Gambar Baru:</p>
            <img :src="imagePreview" alt="Preview Gambar Produk" class="w-full h-36 object-contain rounded-md border border-gray-300 shadow-sm" />
          </div>
        </div>
        
        <button
          class="bg-blue-600 text-white px-4 py-2 rounded disabled:opacity-50"
          type="submit"
          :disabled="form.processing"
        >
          {{ form.processing ? 'Updating...' : 'Update' }}
        </button>
      </form>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'

const props = defineProps({ 
  product: {
    type: Object,
    required: true
  }
})

const allFields = [
  { name: 'name', label: 'Nama Produk' },
  { name: 'description', label: 'Deskripsi' },
  { name: 'price', label: 'Harga', type: 'number' },
  { name: 'size', label: 'Ukuran' },
  { name: 'material', label: 'Bahan' },
]

const fields = computed(() => allFields.filter(field => field.name !== 'image'))

const imageFile = ref(null)
const imagePreview = ref('')
const imageError = ref('')
const currentImage = ref('')

// Initialize form
const form = useForm({
  name: '',
  description: '',
  price: 0,
  size: '',
  material: '',
  image: null,
})

// Initialize form data when component mounts
onMounted(() => {
  console.log('Product prop:', props.product)
  if (props.product) {
    form.name = props.product.name || ''
    form.description = props.product.description || ''
    form.price = props.product.price || 0
    form.size = props.product.size || ''
    form.material = props.product.material || ''
    currentImage.value = props.product.image || ''
    console.log('Form initialized with:', form.data())
  }
})

function onFileChange(event) {
  const file = event.target.files[0]
  if (file) {
    if (!file.type.startsWith('image/')) {
      imageError.value = 'File harus berupa gambar.'
      imageFile.value = null
      imagePreview.value = ''
      form.image = null
      return
    }
    imageError.value = ''
    imageFile.value = file
    form.image = file
    const reader = new FileReader()
    reader.onload = e => {
      imagePreview.value = e.target.result
    }
    reader.readAsDataURL(file)
  }
}

function submit() {
  // Prepare form data - hanya kirim image jika ada file baru
  const formData = {
    name: form.name,
    description: form.description,
    price: form.price,
    size: form.size,
    material: form.material,
    _method: 'PUT'
  }
  
  // Hanya tambahkan image jika ada file baru yang dipilih
  if (imageFile.value) {
    formData.image = imageFile.value
  }

  // Reset form dengan data yang sudah difilter
  const updateForm = useForm(formData)
  
  updateForm.post(route('admin.products.update', props.product.id), {
    forceFormData: true,
    onSuccess: () => {
      console.log('Product updated successfully')
      // Reset preview tapi tetap pertahankan current image
      imageFile.value = null
      imagePreview.value = ''
    },
    onError: (errors) => {
      console.log('Update errors:', errors)
    }
  })
}
</script>