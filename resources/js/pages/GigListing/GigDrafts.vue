<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import type { BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Dashboard', href: dashboard() },
  { title: 'My Gigs', href: '/my-gigs' },
  { title: 'Drafts', href: '/my-gigs/drafts' },
];

type GigStatus = 'active' | 'paused';

type Gig = {
  id: number;
  title: string;
  category: string | null;
  street: string | null;
  barangay: string | null;
  price: string | number;
  price_type: string;
  status: GigStatus;
  updated_at: string;
  bookingsCount: number;
};

const props = defineProps<{
  gigs: Gig[];
}>();

const gigs = ref<Gig[]>([...props.gigs]);
const searchTerm = ref('');

const filteredGigs = computed(() =>
  gigs.value.filter((gig) => {
    if (!searchTerm.value.trim()) return true;
    const q = searchTerm.value.toLowerCase();
    return (
      gig.title.toLowerCase().includes(q) ||
      (gig.category ?? '').toLowerCase().includes(q)
    );
  }),
);
const openMenuId = ref<number | null>(null);

const toggleMenu = (id: number) => {
  openMenuId.value = openMenuId.value === id ? null : id;
};

const goToEdit = (gigId: number) => {
  router.visit(`/gigs/${gigId}/edit`);
};

const deleteGig = (gig: Gig) => {
  if (!confirm('Delete this draft gig?')) return;
  // TODO: call Inertia delete route here
  console.log('Delete draft', gig.id);
};

</script>

<template>
  <Head title="Draft Gigs" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-6 bg-white dark:bg-slate-950 p-4">
      <!-- Header -->
      <section
        class="rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-5 text-white shadow-md"
      >
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
          <div>
            <h1 class="flex items-center gap-2 text-2xl font-bold">
              <span>📝</span>
              <span>Draft Gigs</span>
            </h1>
            <p class="mt-1 text-sm text-amber-100">
              These gigs are saved as drafts and are not visible to clients yet.
            </p>
          </div>

          <Link
            href="/my-gigs"
            class="inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-sm font-semibold text-amber-700 shadow-sm hover:bg-amber-50"
          >
            <span>←</span>
            <span>Back to My Gigs</span>
          </Link>
        </div>
      </section>

      <!-- Filters -->
      <section
        class="rounded-xl bg-white dark:bg-slate-800 px-6 py-4 shadow-sm border border-slate-200 dark:border-slate-700"
      >
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
          <div>
            <h2 class="text-sm font-semibold text-slate-800 dark:text-white">
              Your draft gigs
            </h2>
            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
              Continue editing drafts and publish them when you're ready.
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
                class="w-full rounded-lg border border-slate-200 bg-white px-9 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 shadow-sm focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/20 dark:border-slate-600 dark:bg-slate-900 dark:text-white"
              />
            </div>
          </div>
        </div>
      </section>

      <!-- Draft gig list -->
      <section
        class="rounded-xl bg-white dark:bg-slate-800 px-4 py-4 shadow-sm border border-slate-200 dark:border-slate-700"
      >
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
                  Last updated
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
                    {{ gig.title || 'Untitled draft' }}
                  </p>
                </td>
                <td class="px-4 py-3 align-top text-slate-700 dark:text-slate-200">
                  {{ gig.category || '—' }}
                </td>
                <td class="px-4 py-3 align-top text-slate-700 dark:text-slate-200">
                  <span v-if="gig.price !== null && gig.price !== ''">
                    {{ gig.price }}
                    <span class="text-xs text-slate-500 dark:text-slate-400">
                      / {{ gig.price_type.replace('per ', '') }}
                    </span>
                  </span>
                  <span v-else class="text-slate-400 text-xs">
                    Not set
                  </span>
                </td>
                <td class="px-4 py-3 align-top text-slate-700 dark:text-slate-200">
                  {{ gig.updated_at }}
                </td>
                <td class="px-4 py-3 align-top text-right relative">
                    <button
                        type="button"
                        class="inline-flex h-8 w-8 items-center justify-center rounded-full text-slate-500 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-700"
                        @click="toggleMenu(gig.id)"
                    >
                        ⋮
                    </button>

                    <div
                        v-if="openMenuId === gig.id"
                        class="absolute right-0 mt-1 w-32 rounded-md border border-slate-200 bg-white py-1 text-xs shadow-lg dark:border-slate-700 dark:bg-slate-800"
                    >
                        <button
                        type="button"
                        class="block w-full px-3 py-1.5 text-left text-slate-700 hover:bg-slate-50 dark:text-slate-100 dark:hover:bg-slate-700"
                        @click="goToEdit(gig.id)"
                        >
                        Edit
                        </button>
                        <button
                        type="button"
                        class="block w-full px-3 py-1.5 text-left text-rose-600 hover:bg-rose-50 dark:text-rose-300 dark:hover:bg-rose-900/40"
                        @click="deleteGig(gig)"
                        >
                        Delete
                        </button>
                    </div>
                    </td>
              </tr>

              <tr v-if="!filteredGigs.length">
                <td
                  colspan="4"
                  class="px-4 py-6 text-center text-sm text-slate-500 dark:text-slate-400"
                >
                  You don't have any draft gigs yet.
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
            <h3 class="font-semibold text-slate-900 dark:text-white">
              {{ gig.title || 'Untitled draft' }}
            </h3>
            <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
              {{ gig.category || 'No category' }} • {{ gig.updated_at }}
            </p>
            <p class="mt-2 text-sm text-slate-800 dark:text-slate-100">
              <span v-if="gig.price !== null && gig.price !== ''">
                {{ gig.price }}
                <span class="text-xs text-slate-500 dark:text-slate-400">
                  / {{ gig.price_type.replace('per ', '') }}
                </span>
              </span>
              <span v-else class="text-slate-400 text-xs">
                Price not set
              </span>
            </p>
          </div>

          <p v-if="!filteredGigs.length" class="text-center text-sm text-slate-500 dark:text-slate-400">
            You don't have any draft gigs yet.
          </p>
        </div>
      </section>
    </div>
  </AppLayout>
</template>