<script setup>
</script>

<template>
  <div class="min-h-screen flex flex-col items-center justify-center p-6 animate-gradient-x custom-gradient-bg">
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
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
}

.animate-gradient-x {
  background-size: 600% 600%;
  animation: gradientX 30s ease infinite;
  background-repeat: no-repeat;
}

.custom-gradient-bg {
  background-image: linear-gradient(90deg, rgba(255, 0, 0, 0.5), rgba(0, 255, 0, 0.5), rgba(0, 0, 255, 0.5));
}
</style>
