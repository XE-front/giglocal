<script setup lang="ts">
import type { BreadcrumbItem } from '@/types';

type Props = {
    breadcrumbs?: BreadcrumbItem[];
};

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
<<<<<<< Updated upstream
    <div>
        <slot />
=======
  <div class="min-h-screen bg-white dark:bg-slate-950">
    <!-- Global nav -->
    <header
      class="sticky top-0 z-50 flex items-center justify-between bg-white dark:bg-slate-800 px-4 py-3 shadow-sm border-b border-slate-200 dark:border-slate-700"
    >
      <div class="flex items-center gap-3">
        <!-- Hamburger -->
        <button
          type="button"
          class="flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 dark:border-slate-600 hover:bg-slate-100 dark:hover:bg-slate-700"
          @click="toggleMenu"
          aria-label="Open menu"
          :aria-expanded="isMenuOpen"
        >
          <span class="flex flex-col items-center justify-center w-5 h-5">
            <span class="block h-0.5 w-5 bg-slate-900 dark:bg-white rounded"></span>
            <span class="block h-0.5 w-5 bg-slate-900 dark:bg-white rounded my-1"></span>
            <span class="block h-0.5 w-5 bg-slate-900 dark:bg-white rounded"></span>
          </span>
        </button>

        <div class="flex items-center gap-2">
          <img
            src="/logo/GigLocalIcon.png"
            alt="GigLocal Logo"
            class="w-10 h-10 rounded-md"
          />
          <span class="text-lg font-semibold text-slate-900 dark:text-white">
            GigLocal
          </span>
        </div>
      </div>

      <!-- Right side: page-specific header content + notifications/profile -->
      <div class="flex items-center gap-6">
        <!-- Page-specific injected content (e.g. dashboard role toggle) -->
        <slot name="header-right" />

        <!-- Global notifications / profile -->
        <div class="flex items-center gap-3">
          <button
            type="button"
            class="relative flex h-9 w-9 items-center justify-center rounded-full bg-slate-100 text-slate-700 hover:bg-slate-200"
          >
            <span class="sr-only">Notifications</span>
            🔔
            <span
              class="absolute -right-0.5 -top-0.5 flex h-4 w-4 items-center justify-center rounded-full bg-slate-900 text-[10px] font-semibold text-white"
            >
              3
            </span>
          </button>
          <button
            type="button"
            class="relative flex h-9 w-9 items-center justify-center rounded-full bg-slate-100 text-slate-700 hover:bg-slate-200"
          >
            <span class="sr-only">Messages</span>
            💬
            <span
              class="absolute -right-0.5 -top-0.5 flex h-4 w-4 items-center justify-center rounded-full bg-slate-900 text-[10px] font-semibold text-white"
            >
              2
            </span>
          </button>
          <Link
            href="profile-page"
            class="flex h-9 w-9 items-center justify-center overflow-hidden rounded-full border border-slate-200"
          >
            <span class="sr-only">Profile</span>
            <span class="flex h-full w-full items-center justify-center bg-slate-800 text-xs font-semibold text-white">
              JD
            </span>
          </Link>
        </div>
      </div>
    </header>
    <div
      v-if="successMessage"
      class="bg-emerald-50 border-b border-emerald-200 text-emerald-800 px-4 py-2 text-sm"
    >
      {{ successMessage }}
>>>>>>> Stashed changes
    </div>
</template>
