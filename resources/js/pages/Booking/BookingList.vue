<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import type { BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Dashboard', href: dashboard() },
  { title: 'My Bookings', href: '/my-bookings' },
];

type BookingStatus = 'confirmed' | 'pending' | 'completed' | 'cancelled';
type BookingType = 'upcoming' | 'past';

type Booking = {
  id: number;
  service: string;
  provider: string;
  date: string;
  time: string;
  price: string;
  status: BookingStatus;
  type: BookingType;
  location: string;
};

// Mock data – replace with real backend data later
const bookings = ref<Booking[]>([
  {
    id: 1,
    service: 'Home Repair & Handyman Services',
    provider: 'Jennifer Adams',
    date: 'March 26, 2026',
    time: '10:00 AM',
    price: '$90',
    status: 'confirmed',
    type: 'upcoming',
    location: 'Downtown, Springfield',
  },
  {
    id: 2,
    service: 'Home Cleaning & Organization',
    provider: 'Sarah Johnson',
    date: 'March 28, 2026',
    time: '2:30 PM',
    price: '$120',
    status: 'pending',
    type: 'upcoming',
    location: 'Northside, Springfield',
  },
  {
    id: 3,
    service: 'Tutoring – Math & Science',
    provider: 'Alex Martinez',
    date: 'March 18, 2026',
    time: '4:00 PM',
    price: '$60',
    status: 'completed',
    type: 'past',
    location: 'Online',
  },
  {
    id: 4,
    service: 'Dog Walking & Pet Care',
    provider: 'Emily Clark',
    date: 'March 15, 2026',
    time: '8:30 AM',
    price: '$35',
    status: 'cancelled',
    type: 'past',
    location: 'Westside, Springfield',
  },
]);

const activeTab = ref<BookingType>('upcoming');
const searchTerm = ref('');

const filteredBookings = computed(() =>
  bookings.value.filter((b) => {
    if (b.type !== activeTab.value) return false;

    if (!searchTerm.value.trim()) return true;
    const q = searchTerm.value.toLowerCase();

    return (
      b.service.toLowerCase().includes(q) ||
      b.provider.toLowerCase().includes(q) ||
      b.location.toLowerCase().includes(q)
    );
  }),
);

const statusBadgeClass = (status: BookingStatus) => {
  switch (status) {
    case 'confirmed':
      return 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400';
    case 'pending':
      return 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400';
    case 'completed':
      return 'bg-slate-100 text-slate-700 dark:bg-slate-700/60 dark:text-slate-200';
    case 'cancelled':
      return 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400';
    default:
      return 'bg-slate-100 text-slate-700 dark:bg-slate-700/60 dark:text-slate-200';
  }
};
</script>

<template>
  <Head title="My Bookings" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-6 bg-white dark:bg-slate-950 p-4">
      <!-- Page header -->
      <section
        class="rounded-xl bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-5 text-white shadow-md"
      >
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
          <div>
            <h1 class="flex items-center gap-2 text-2xl font-bold">
              <span>📅</span>
              <span>My Bookings</span>
            </h1>
            <p class="mt-1 text-sm text-blue-100">
              Track your upcoming appointments and review your past services.
            </p>
          </div>

          <div
            class="inline-flex rounded-full bg-blue-500/40 p-1 text-xs font-medium backdrop-blur"
          >
            <button
              type="button"
              class="rounded-full px-4 py-1.5 transition"
              :class="
                activeTab === 'upcoming'
                  ? 'bg-white text-blue-700 shadow-sm'
                  : 'text-blue-100 hover:text-white'
              "
              @click="activeTab = 'upcoming'"
            >
              Upcoming
            </button>
            <button
              type="button"
              class="rounded-full px-4 py-1.5 transition"
              :class="
                activeTab === 'past'
                  ? 'bg-white text-blue-700 shadow-sm'
                  : 'text-blue-100 hover:text-white'
              "
              @click="activeTab = 'past'"
            >
              Past
            </button>
          </div>
        </div>
      </section>

      <!-- Filters -->
      <section
        class="rounded-xl bg-white dark:bg-slate-800 px-6 py-4 shadow-sm border border-slate-200 dark:border-slate-700"
      >
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
          <div>
            <h2 class="text-sm font-semibold text-slate-800 dark:text-white">
              {{ activeTab === 'upcoming' ? 'Upcoming bookings' : 'Past bookings' }}
            </h2>
            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
              Use search to quickly find a specific booking.
            </p>
          </div>

          <div class="flex w-full flex-col gap-2 md:w-auto md:flex-row md:items-center">
            <div class="relative w-full md:w-64">
              <span
                class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400"
              >
                🔍
              </span>
              <input
                v-model="searchTerm"
                type="text"
                placeholder="Search by service, provider, or area"
                class="w-full rounded-lg border border-slate-200 bg-white px-9 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-600 dark:bg-slate-900 dark:text-white"
              />
            </div>
          </div>
        </div>
      </section>

      <!-- Booking list -->
      <section
        class="rounded-xl bg-white dark:bg-slate-800 px-4 py-4 shadow-sm border border-slate-200 dark:border-slate-700"
      >
        <div class="hidden md:block">
          <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700 text-sm">
            <thead class="bg-slate-50 dark:bg-slate-900/40">
              <tr>
                <th
                  scope="col"
                  class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400"
                >
                  Service
                </th>
                <th
                  scope="col"
                  class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400"
                >
                  Provider
                </th>
                <th
                  scope="col"
                  class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400"
                >
                  Date & time
                </th>
                <th
                  scope="col"
                  class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400"
                >
                  Location
                </th>
                <th
                  scope="col"
                  class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400"
                >
                  Price
                </th>
                <th
                  scope="col"
                  class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400"
                >
                  Status
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-700/70">
              <tr
                v-for="booking in filteredBookings"
                :key="booking.id"
                class="hover:bg-slate-50/80 dark:hover:bg-slate-700/40 transition"
              >
                <td class="px-4 py-3 align-top">
                  <p class="font-medium text-slate-900 dark:text-white">
                    {{ booking.service }}
                  </p>
                </td>
                <td class="px-4 py-3 align-top">
                  <p class="text-slate-700 dark:text-slate-200">
                    {{ booking.provider }}
                  </p>
                </td>
                <td class="px-4 py-3 align-top">
                  <p class="text-slate-700 dark:text-slate-200">
                    {{ booking.date }}
                  </p>
                  <p class="text-xs text-slate-500 dark:text-slate-400">
                    {{ booking.time }}
                  </p>
                </td>
                <td class="px-4 py-3 align-top">
                  <p class="text-slate-700 dark:text-slate-200">
                    {{ booking.location }}
                  </p>
                </td>
                <td class="px-4 py-3 align-top">
                  <p class="font-semibold text-slate-900 dark:text-white">
                    {{ booking.price }}
                  </p>
                </td>
                <td class="px-4 py-3 align-top">
                  <span
                    class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold"
                    :class="statusBadgeClass(booking.status)"
                  >
                    {{ booking.status.charAt(0).toUpperCase() + booking.status.slice(1) }}
                  </span>
                </td>
              </tr>
            </tbody>
          </table>

          <div
            v-if="!filteredBookings.length"
            class="flex flex-col items-center justify-center gap-2 py-10 text-center text-sm text-slate-500 dark:text-slate-400"
          >
            <span class="text-3xl">🔍</span>
            <p class="font-medium">No bookings found</p>
            <p class="text-xs">
              Try adjusting your filters or clearing the search.
            </p>
          </div>
        </div>

        <!-- Mobile cards -->
        <div class="space-y-3 md:hidden">
          <div
            v-for="booking in filteredBookings"
            :key="booking.id"
            class="rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-sm dark:border-slate-700 dark:bg-slate-900/70"
          >
            <div class="flex items-start justify-between gap-3">
              <div>
                <p class="text-sm font-semibold text-slate-900 dark:text-white">
                  {{ booking.service }}
                </p>
                <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                  {{ booking.provider }} • {{ booking.location }}
                </p>
              </div>
              <span
                class="inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-semibold"
                :class="statusBadgeClass(booking.status)"
              >
                {{ booking.status.charAt(0).toUpperCase() + booking.status.slice(1) }}
              </span>
            </div>

            <div class="mt-3 flex items-center justify-between text-xs text-slate-600 dark:text-slate-300">
              <div>
                <p>{{ booking.date }}</p>
                <p class="mt-0.5 text-slate-500 dark:text-slate-400">
                  {{ booking.time }}
                </p>
              </div>
              <p class="text-sm font-semibold text-slate-900 dark:text-white">
                {{ booking.price }}
              </p>
            </div>
          </div>

          <div
            v-if="!filteredBookings.length"
            class="flex flex-col items-center justify-center gap-2 py-8 text-center text-sm text-slate-500 dark:text-slate-400"
          >
            <span class="text-3xl">🔍</span>
            <p class="font-medium">No bookings found</p>
            <p class="text-xs">
              Try adjusting your filters or clearing the search.
            </p>
          </div>
        </div>
      </section>
    </div>
  </AppLayout>
</template>