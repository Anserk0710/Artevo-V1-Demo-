<script setup>
</script>

<template>
  <div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-r from-blue-400 to-indigo-600 p-6 animate-gradient-x">
    <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8 animate-fade-in">
      <slot />
    </div>
  </div>
</template>

<style scoped>
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in {
  animation: fadeIn 0.8s ease forwards;
}

@keyframes gradientX {
  0%, 100% {
    background-position: 0% center;
  }
  50% {
    background-position: 100% center;
  }
}

.animate-gradient-x {
  background-size: 200% 200%;
  animation: gradientX 8s ease infinite;
}
</style>
