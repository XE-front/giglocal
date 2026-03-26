<script setup lang="ts">
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import type { BreadcrumbItem } from '@/types';

type Props = {
  breadcrumbs?: BreadcrumbItem[];
};

withDefaults(defineProps<Props>(), {
  breadcrumbs: () => [],
});

type NavItem = {
  label: string;
  href: string;
};

const isMenuOpen = ref(false);

const navItems: NavItem[] = [
  { label: 'Dashboard', href: '/dashboard' },
  { label: 'Browse Gigs (As Client)', href: '/browse-gigs' },
  { label: 'Booking Request (As Client)', href: '/booking-list' },
  { label: 'My Gigs (As Provider)', href: '/my-gigs' },
  { label: 'My Bookings (As Provider)', href: '/my-bookings' },
];

const toggleMenu = () => {
  isMenuOpen.value = !isMenuOpen.value;
};

const closeMenu = () => {
  isMenuOpen.value = false;
};
</script>

<template>
  <div class="min-h-screen bg-white dark:bg-slate-950">
    <!-- Global nav -->
    <header
      class="flex items-center justify-between bg-white dark:bg-slate-800 px-4 py-3 shadow-sm border border-slate-200 dark:border-slate-700"
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
          <button
            type="button"
            class="flex h-9 w-9 items-center justify-center overflow-hidden rounded-full border border-slate-200"
          >
            <span class="sr-only">Profile</span>
            <span
              class="flex h-full w-full items-center justify-center bg-slate-800 text-xs font-semibold text-white"
            >
              JD
            </span>
          </button>
        </div>
      </div>
    </header>

    <!-- Overlay -->
    <div
      v-if="isMenuOpen"
      class="fixed inset-0 z-40 bg-black/40"
      @click="closeMenu"
    />

    <!-- Hamburger menu panel (dropdown below header) -->
    <nav
      v-if="isMenuOpen"
      class="relative z-50 bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700 shadow-md px-4 py-3"
    >
      <ul class="max-w-7xl mx-auto space-y-1 text-sm">
        <li v-for="item in navItems" :key="item.href">
          <Link
            :href="item.href"
            class="block rounded px-3 py-2 text-slate-700 dark:text-slate-200 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-700 transition font-medium cursor-pointer"
            @click="closeMenu"
          >
            {{ item.label }}
          </Link>
        </li>
      </ul>
    </nav>

    <!-- Page content -->
    <main class="flex h-full flex-1 flex-col gap-6 bg-white dark:bg-slate-950 p-4">
      <slot />
    </main>
  </div>
</template>
