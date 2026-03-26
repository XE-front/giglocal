<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import type { BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Dashboard', href: dashboard() },
  { title: 'My Gigs', href: '/my-gigs' },
];

type GigStatus = 'active' | 'paused';

type Gig = {
  id: number;
  title: string;
  category: string;
  price: string;
  status: GigStatus;
  createdAt: string;
  bookingsCount: number;
};

// TODO: Replace with backend data from Inertia props
const gigs = ref<Gig[]>([
  {
    id: 1,
    title: 'House Cleaning (2‑bedroom apartment)',
    category: 'Cleaning',
    price: '$80',
    status: 'active',
    createdAt: 'Mar 10, 2026',
    bookingsCount: 12,
  },
  {
    id: 2,
    title: 'Math Tutoring (High School)',
    category: 'Tutoring',
    price: '$45',
    status: 'paused',
    createdAt: 'Feb 22, 2026',
    bookingsCount: 7,
  },
]);

const searchTerm = ref('');
const statusFilter = ref<'all' | GigStatus>('all');

const filteredGigs = computed(() =>
  gigs.value.filter((gig) => {
    if (statusFilter.value !== 'all' && gig.status !== statusFilter.value) {
      return false;
    }

    if (!searchTerm.value.trim()) return true;
    const q = searchTerm.value.toLowerCase();

    return (
      gig.title.toLowerCase().includes(q) ||
      gig.category.toLowerCase().includes(q)
    );
  }),
);

const statusBadgeClass = (status: GigStatus) => {
  return status === 'active'
    ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400'
    : 'bg-slate-100 text-slate-700 dark:bg-slate-700/60 dark:text-slate-200';
};

// Stub actions – later these should call Inertia form/POST routes
const toggleStatus = (gig: Gig) => {
  gig.status = gig.status === 'active' ? 'paused' : 'active';
};

const deleteGig = (gigId: number) => {
  if (!confirm('Are you sure you want to delete this gig?')) return;
  gigs.value = gigs.value.filter((g) => g.id !== gigId);
};

const createNewGig = () => {
  // Later: redirect to "Create Gig" page using Inertia
  alert('Navigate to "Create Gig" form (to be implemented)');
};
</script>

<template>
  <Head title="My Gigs" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-6 bg-white dark:bg-slate-950 p-4">
      <!-- Header -->
      <section
        class="rounded-xl bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-5 text-white shadow-md"
      >
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
          <div>
            <h1 class="flex items-center gap-2 text-2xl font-bold">
              <span>🛠️</span>
              <span>My Gigs (Provider)</span>
            </h1>
            <p class="mt-1 text-sm text-emerald-100">
              Manage the services you offer and keep your listings up to date.
            </p>
          </div>

          <button
            type="button"
            class="inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-sm font-semibold text-emerald-700 shadow-sm hover:bg-emerald-50"
            @click="createNewGig"
          >
            <span>＋</span>
            <span>Add New Gig</span>
          </button>
        </div>
      </section>

      <!-- Filters -->
      <section
        class="rounded-xl bg-white dark:bg-slate-800 px-6 py-4 shadow-sm border border-slate-200 dark:border-slate-700"
      >
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
          <div>
            <h2 class="text-sm font-semibold text-slate-800 dark:text-white">
              Your gig listings
            </h2>
            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
              Search and filter through the gigs you offer as a provider.
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
                placeholder="Search by title or category"
                class="w-full rounded-lg border border-slate-200 bg-white px-9 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 dark:border-slate-600 dark:bg-slate-900 dark:text-white"
              />
            </div>

            <select
              v-model="statusFilter"
              class="md:ml-3 w-full md:w-40 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 dark:border-slate-600 dark:bg-slate-900 dark:text-white"
            >
              <option value="all">All statuses</option>
              <option value="active">Active</option>
              <option value="paused">Paused</option>
            </select>
          </div>
        </div>
      </section>

      <!-- Gig list -->
      <section
        class="rounded-xl bg-white dark:bg-slate-800 px-4 py-4 shadow-sm border border-slate-200 dark:border-slate-700"
      >
        <!-- Desktop table -->
        <div class="hidden md:block">
          <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700 text-sm">
            <thead class="bg-slate-50 dark:bg-slate-900/40">
              <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
                  Gig
                </th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
                  Category
                </th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
                  Price
                </th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
                  Bookings
                </th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
                  Status
                </th>
                <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-700/70">
              <tr
                v-for="gig in filteredGigs"
                :key="gig.id"
                class="hover:bg-slate-50/80 dark:hover:bg-slate-700/40 transition"
              >
                <td class="px-4 py-3 align-top">
                  <p class="font-medium text-slate-900 dark:text-white">
                    {{ gig.title }}
                  </p>
                  <p class="text-xs text-slate-500 dark:text-slate-400">
                    Created {{ gig.createdAt }}
                  </p>
                </td>
                <td class="px-4 py-3 align-top text-slate-700 dark:text-slate-200">
                  {{ gig.category }}
                </td>
                <td class="px-4 py-3 align-top text-slate-700 dark:text-slate-200">
                  {{ gig.price }}
                </td>
                <td class="px-4 py-3 align-top text-slate-700 dark:text-slate-200">
                  {{ gig.bookingsCount }}
                </td>
                <td class="px-4 py-3 align-top">
                  <span
                    class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium"
                    :class="statusBadgeClass(gig.status)"
                  >
                    {{ gig.status === 'active' ? 'Active' : 'Paused' }}
                  </span>
                </td>
                <td class="px-4 py-3 align-top text-right">
                  <div class="inline-flex items-center gap-2">
                    <button
                      type="button"
                      class="rounded-full border border-slate-200 px-3 py-1 text-xs font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-600 dark:text-slate-100 dark:hover:bg-slate-700"
                      @click="toggleStatus(gig)"
                    >
                      {{ gig.status === 'active' ? 'Pause' : 'Activate' }}
                    </button>
                    <button
                      type="button"
                      class="rounded-full border border-slate-200 px-3 py-1 text-xs font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-600 dark:text-slate-100 dark:hover:bg-slate-700"
                    >
                      Edit
                    </button>
                    <button
                      type="button"
                      class="rounded-full border border-rose-200 px-3 py-1 text-xs font-medium text-rose-700 hover:bg-rose-50 dark:border-rose-700 dark:text-rose-300 dark:hover:bg-rose-950/40"
                      @click="deleteGig(gig.id)"
                    >
                      Delete
                    </button>
                  </div>
                </td>
              </tr>

              <tr v-if="!filteredGigs.length">
                <td
                  colspan="6"
                  class="px-4 py-6 text-center text-sm text-slate-500 dark:text-slate-400"
                >
                  You don’t have any gigs that match these filters yet.
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Mobile cards -->
        <div class="space-y-3 md:hidden">
          <div
            v-for="gig in filteredGigs"
            :key="gig.id"
            class="rounded-lg border border-slate-200 bg-white p-4 text-sm shadow-sm dark:border-slate-700 dark:bg-slate-900"
          >
            <div class="flex items-start justify-between gap-3">
              <div>
                <h3 class="font-semibold text-slate-900 dark:text-white">
                  {{ gig.title }}
                </h3>
                <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                  {{ gig.category }} • Created {{ gig.createdAt }}
                </p>
              </div>
              <span
                class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium"
                :class="statusBadgeClass(gig.status)"
              >
                {{ gig.status === 'active' ? 'Active' : 'Paused' }}
              </span>
            </div>

            <div class="mt-3 flex items-center justify-between">
              <p class="text-sm font-medium text-slate-900 dark:text-white">
                {{ gig.price }}
              </p>
              <p class="text-xs text-slate-500 dark:text-slate-400">
                {{ gig.bookingsCount }} bookings
              </p>
            </div>

            <div class="mt-3 flex items-center justify-end gap-2 text-xs">
              <button
                type="button"
                class="rounded-full border border-slate-200 px-3 py-1 font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-600 dark:text-slate-100 dark:hover:bg-slate-700"
                @click="toggleStatus(gig)"
              >
                {{ gig.status === 'active' ? 'Pause' : 'Activate' }}
              </button>
              <button
                type="button"
                class="rounded-full border border-slate-200 px-3 py-1 font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-600 dark:text-slate-100 dark:hover:bg-slate-700"
              >
                Edit
              </button>
              <button
                type="button"
                class="rounded-full border border-rose-200 px-3 py-1 font-medium text-rose-700 hover:bg-rose-50 dark:border-rose-700 dark:text-rose-300 dark:hover:bg-rose-950/40"
                @click="deleteGig(gig.id)"
              >
                Delete
              </button>
            </div>
          </div>

          <p v-if="!filteredGigs.length" class="text-center text-sm text-slate-500 dark:text-slate-400">
            You don’t have any gigs that match these filters yet.
          </p>
        </div>
      </section>
    </div>
  </AppLayout>
</template>