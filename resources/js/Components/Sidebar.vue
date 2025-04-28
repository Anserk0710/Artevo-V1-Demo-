<script setup>
import { Link, usePage } from '@inertiajs/vue3';

const props = defineProps({
  isOpen: {
    type: Boolean,
    required: true
  },
  toggleSidebar: {
    type: Function,
    required: true
  }
});

const page = usePage();

const menuItems = [
  { name: 'Dashboard', href: '/admin/dashboard', icon: 'M3 12h18M3 6h18M3 18h18' },
  { name: 'Users', href: '/admin/users', icon: 'M16 7a4 4 0 11-8 0 4 4 0 018 0z M12 14c-4 0-6 2-6 4v1h12v-1c0-2-2-4-6-4z' },
  { name: 'Settings', href: '/admin/settings', icon: 'M12 8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z M19.4 15a7.9 7.9 0 01-1.4 2.4l1.4 1.4-1.4 1.4-1.4-1.4a7.9 7.9 0 01-2.4 1.4v2h-2v-2a7.9 7.9 0 01-2.4-1.4l-1.4 1.4-1.4-1.4 1.4-1.4a7.9 7.9 0 01-1.4-2.4h-2v-2h2a7.9 7.9 0 011.4-2.4l-1.4-1.4 1.4-1.4 1.4 1.4a7.9 7.9 0 012.4-1.4v-2h2v2a7.9 7.9 0 012.4 1.4l1.4-1.4 1.4 1.4-1.4 1.4a7.9 7.9 0 011.4 2.4h2v2h-2z' },
  { name: 'Products', href: '/admin/products', icon: 'M3 3h18v18H3V3z M9 9h6v6H9V9z' },
];
</script>

<template>
  <div class="flex">
    <aside
      id="sidebar"
      :class="[
        'bg-indigo-600 min-h-screen text-white transition-all duration-300 ease-in-out flex flex-col',
        isOpen ? 'w-64' : 'w-0 overflow-hidden'
      ]"
      role="navigation"
      aria-label="Admin menu"
    >
      <div class="flex items-center justify-between p-4 border-b border-indigo-400" v-show="isOpen">
        <div class="text-2xl font-bold">
          Admin Menu
        </div>
      </div>
      <nav class="mt-4 flex-1 overflow-auto" v-show="isOpen">
        <ul>
          <li v-for="item in menuItems" :key="item.name">
            <Link
              :href="item.href"
              class="flex items-center px-4 py-2 hover:bg-indigo-500"
              :class="{ 'bg-indigo-500': page.url.startsWith(item.href) }"
            >
              <svg
                class="h-5 w-5 me-2 flex-shrink-0"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                viewBox="0 0 24 24"
                aria-hidden="true"
              >
                <path :d="item.icon" />
              </svg>
              {{ item.name }}
            </Link>
          </li>
        </ul>
      </nav>
    </aside>
  </div>
</template>

<style scoped>
/* Sidebar specific styles */
</style>
