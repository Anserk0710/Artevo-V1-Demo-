<script setup>
import { ref } from 'vue';
import Sidebar from '../Components/Sidebar.vue';
import Dropdown from '../Components/Dropdown.vue';
import DropdownLink from '../Components/DropdownLink.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
const isOpen = ref(true);

function toggleSidebar() {
  isOpen.value = !isOpen.value;
}

function toggleNavigationDropdown() {
  showingNavigationDropdown.value = !showingNavigationDropdown.value;
}
</script>

<template>
  <div>
    <div class="min-h-screen bg-gray-100 flex">
      <Sidebar :isOpen="isOpen" :toggleSidebar="toggleSidebar" />

      <div class="flex-1 flex flex-col">
<nav class="border-b border-gray-300 bg-white shadow-md">
          <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
<div class="flex h-16 justify-between font-sans">
              <div class="flex">
                <!-- Logo and Hamburger -->
                <div class="flex shrink-0 items-center space-x-4">
                  <Link :href="route('admin.dashboard')">
                    <svg
                      class="block h-9 w-auto fill-current text-gray-800"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 48 48"
                      fill="none"
                    >
                      <path
                        fill="currentColor"
                        d="M24 4C12.954 4 4 12.954 4 24s8.954 20 20 20 20-8.954 20-20S35.046 4 24 4z"
                      />
                    </svg>
                  </Link>
                  <!-- Sidebar Toggle Button -->
                  <div class="flex items-center">
                    <button
                      @click="toggleSidebar"
                      type="button"
                      class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                      aria-label="Toggle sidebar"
                      :aria-expanded="isOpen.toString()"
                      aria-controls="sidebar"
                    >
                      <svg
                        v-if="isOpen"
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        aria-hidden="true"
                      >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                      </svg>
                      <svg
                        v-else
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        aria-hidden="true"
                      >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                      </svg>
                    </button>
                  </div>
                  <!-- Navigation Dropdown Hamburger -->
                  <div class="-me-2 flex items-center sm:hidden">
                    <button
                      @click="toggleNavigationDropdown"
                      class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none"
                      type="button"
                      aria-haspopup="true"
                      aria-expanded="false"
                      aria-controls="dropdown-menu"
                    >
                      <!-- User Avatar Icon -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 rounded-full" fill="currentColor" viewBox="0 0 24 24" stroke="none" aria-hidden="true">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM12 14c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                      </svg>
                    </button>
                  </div>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                  <Link
                    :href="route('admin.dashboard')"
                    class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700 transition"
                    :class="{ 'border-b-2 border-indigo-400 text-gray-900': route().current('admin.dashboard') }"
                  >
                    Dashboard
                  </Link>
                </div>
              </div>

              <div class="hidden sm:ms-6 sm:flex sm:items-center">
                <!-- Settings Dropdown -->
                <div class="relative ms-3">
                  <Dropdown align="right" width="48">
                    <template #trigger>
                      <span class="inline-flex rounded-md">
                        <button
                          @click="$emit('toggle-dropdown')"
                          type="button"
                          class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
                          aria-label="User menu"
                          aria-haspopup="true"
                          aria-expanded="false"
                        >
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 transform transition-transform duration-300"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            aria-hidden="true"
                            :class="{ 'rotate-180': showingNavigationDropdown }"
                          >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                          </svg>
                        </button>
                      </span>
                    </template>

                    <template #content>
                      <DropdownLink :href="route('profile.edit')">Profile</DropdownLink>
                      <DropdownLink :href="route('logout')" method="post" as="button">
                        Log Out
                      </DropdownLink>
                    </template>
                  </Dropdown>
                </div>
              </div>

              <!-- Hamburger -->
              <div class="-me-2 flex items-center sm:hidden">
                <button
                  @click="showingNavigationDropdown = !showingNavigationDropdown"
                  class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none"
                >
                  <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path
                      :class="{ hidden: showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"
                    />
                    <path
                      :class="{ hidden: !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"
                    />
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </nav>

        <div class="p-4 border-b border-gray-200">
          <slot name="header" />
        </div>

        <div class="p-4">
          <slot />
        </div>

      </div>
    </div>
  </div>
</template>
