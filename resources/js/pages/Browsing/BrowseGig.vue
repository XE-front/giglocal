<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Browse Gigs', href: '#' },
];

type Gig = {
  id: number;
  title: string;
  category: string;
  price: number;
  rating: number;
  reviews: number;
  provider: string;
  description: string;
  featured?: boolean;
};

const searchQuery = ref('');
const selectedCategory = ref('All Categories');
const selectedRating = ref(0);
const priceMin = ref(0);
const priceMax = ref(500);

const categories = [
  'All Categories',
  'Tutoring',
  'Home Repair',
  'Cleaning',
  'Writing',
  'Fitness',
  'Photography',
  'Plumbing',
];

// Mock gigs data - replace with backend data later
const allGigs: Gig[] = [
  {
    id: 1,
    title: 'Professional Writing',
    category: 'Writing',
    price: 50,
    rating: 4.9,
    reviews: 120,
    provider: 'Jane Smith',
    description: 'Expert writing for blogs, articles, and marketing content.',
    featured: true,
  },
  {
    id: 2,
    title: 'House Cleaning Service',
    category: 'Cleaning',
    price: 75,
    rating: 4.8,
    reviews: 95,
    provider: 'Clean Crew',
    description: 'Thorough and reliable cleaning for homes and offices.',
  },
  {
    id: 3,
    title: 'Personal Tutoring',
    category: 'Tutoring',
    price: 45,
    rating: 4.7,
    reviews: 80,
    provider: 'John Tutor',
    description: 'Math, Science, and English tutoring for all levels.',
    featured: true,
  },
  {
    id: 4,
    title: 'Plumbing Services',
    category: 'Plumbing',
    price: 100,
    rating: 4.6,
    reviews: 60,
    provider: 'Pro Plumbers',
    description: 'Emergency plumbing repairs and maintenance.',
  },
  {
    id: 5,
    title: 'Home Repair',
    category: 'Home Repair',
    price: 80,
    rating: 4.9,
    reviews: 110,
    provider: 'Bob Builder',
    description: 'General home repairs and handyman services.',
  },
  {
    id: 6,
    title: 'Fitness Coaching',
    category: 'Fitness',
    price: 60,
    rating: 4.8,
    reviews: 75,
    provider: 'Fitness Pro',
    description: 'Personal training and fitness coaching online.',
    featured: true,
  },
];

const filteredGigs = computed(() => {
  return allGigs.filter((gig) => {
    const q = searchQuery.value.toLowerCase().trim();

    const matchesSearch =
      !q ||
      gig.title.toLowerCase().includes(q) ||
      gig.description.toLowerCase().includes(q) ||
      gig.provider.toLowerCase().includes(q);

    const matchesCategory =
      !selectedCategory.value ||
      selectedCategory.value === 'All Categories' ||
      gig.category === selectedCategory.value;

    const matchesRating =
      selectedRating.value === 0 || gig.rating >= selectedRating.value;

    const min = Number.isNaN(Number(priceMin.value)) ? 0 : Number(priceMin.value);
    const max = Number.isNaN(Number(priceMax.value)) ? 999999 : Number(priceMax.value);
    const matchesPrice = gig.price >= min && gig.price <= max;

    return matchesSearch && matchesCategory && matchesRating && matchesPrice;
  });
});

const featuredGigs = computed(() => filteredGigs.value.filter((g) => g.featured));
const otherGigs = computed(() => filteredGigs.value.filter((g) => !g.featured));
</script>

<template>
  <Head title="Browse Gigs" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <!-- Hero -->
    <section
      class="bg-gradient-to-r from-blue-600 to-blue-800 dark:from-blue-900 dark:to-slate-900 py-12 px-4 -mx-4 -mt-4 mb-6"
    >
      <div class="max-w-7xl mx-auto text-center">
        <h1 class="text-4xl sm:text-5xl font-bold text-white mb-4">
          Browse Local Gigs
        </h1>
        <p class="text-lg text-blue-100 mb-6 max-w-2xl mx-auto">
          Find trusted providers for tutoring, home repair, cleaning, and more.
        </p>

        <!-- Search -->
        <div class="max-w-2xl mx-auto flex flex-col sm:flex-row gap-3">
          <div
            class="flex-1 flex items-center bg-white dark:bg-slate-800 rounded-lg overflow-hidden shadow-sm"
          >
            <svg
              class="w-5 h-5 text-slate-400 ml-4"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
              />
            </svg>
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Search gigs, skills, providers..."
              class="flex-1 border-0 px-4 py-3 bg-transparent dark:text-white focus:outline-none"
            />
          </div>
        </div>
      </div>
    </section>

    <!-- Filters -->
    <section class="mb-8 mx-6">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Category -->
        <div
          class="bg-white dark:bg-slate-800 rounded-lg p-4 border border-slate-200 dark:border-slate-700"
        >
          <h3 class="text-sm font-semibold text-slate-800 dark:text-white mb-2">
            Category
          </h3>
          <select
            v-model="selectedCategory"
            class="mt-1 w-full rounded-md border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 px-3 py-2 text-sm text-slate-800 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
            <option v-for="cat in categories" :key="cat" :value="cat">
              {{ cat }}
            </option>
          </select>
        </div>

        <!-- Rating -->
        <div
          class="bg-white dark:bg-slate-800 rounded-lg p-4 border border-slate-200 dark:border-slate-700"
        >
          <h3 class="text-sm font-semibold text-slate-800 dark:text-white mb-2">
            Minimum Rating
          </h3>
          <div class="flex items-center gap-2 text-sm">
            <select
              v-model.number="selectedRating"
              class="mt-1 w-full rounded-md border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 px-3 py-2 text-sm text-slate-800 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              <option :value="0">Any rating</option>
              <option :value="3">3.0 ★ and up</option>
              <option :value="4">4.0 ★ and up</option>
              <option :value="4.5">4.5 ★ and up</option>
            </select>
          </div>
        </div>

        <!-- Price -->
        <div
          class="bg-white dark:bg-slate-800 rounded-lg p-4 border border-slate-200 dark:border-slate-700 md:col-span-2"
        >
          <h3 class="text-sm font-semibold text-slate-800 dark:text-white mb-2">
            Price Range ($)
          </h3>
          <div class="flex items-center gap-3 text-sm">
            <div class="flex-1">
              <label class="block text-xs text-slate-500 dark:text-slate-400 mb-1">
                Min
              </label>
              <input
                v-model.number="priceMin"
                type="number"
                min="0"
                class="w-full rounded-md border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 px-3 py-2 text-sm text-slate-800 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
              />
            </div>
            <div class="flex-1">
              <label class="block text-xs text-slate-500 dark:text-slate-400 mb-1">
                Max
              </label>
              <input
                v-model.number="priceMax"
                type="number"
                min="0"
                class="w-full rounded-md border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 px-3 py-2 text-sm text-slate-800 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
              />
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Featured Gigs -->
    <section v-if="featuredGigs.length" class="mx-6 mb-10">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-slate-900 dark:text-white">
          Featured Gigs
        </h2>
        <p class="text-xs text-slate-500 dark:text-slate-400">
          Handpicked top-rated services
        </p>
      </div>

      <div class="grid gap-6 md:grid-cols-3">
        <article
          v-for="gig in featuredGigs"
          :key="gig.id"
          class="overflow-hidden rounded-xl border border-blue-200 dark:border-blue-800 bg-white dark:bg-slate-900 shadow-sm"
        >
          <div
            class="h-24 bg-gradient-to-r from-blue-600 to-blue-700 dark:from-blue-700 dark:to-blue-900 flex items-center justify-between px-4"
          >
            <span class="text-xs font-semibold uppercase tracking-wide text-blue-100">
              Featured
            </span>
            <span class="text-3xl">⭐</span>
          </div>
          <div class="p-5 space-y-3">
            <div class="flex items-center justify-between">
              <h3 class="text-base font-semibold text-slate-900 dark:text-white">
                {{ gig.title }}
              </h3>
              <span class="text-sm font-semibold text-blue-600 dark:text-blue-300">
                ${{ gig.price }}
              </span>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400">
              {{ gig.category }} • by {{ gig.provider }}
            </p>
            <p class="text-sm text-slate-600 dark:text-slate-300 line-clamp-3">
              {{ gig.description }}
            </p>
            <div class="flex items-center justify-between pt-2">
              <div class="flex items-center gap-1 text-xs text-slate-500 dark:text-slate-400">
                <span class="text-yellow-400">★</span>
                <span class="font-semibold text-slate-800 dark:text-slate-100">
                  {{ gig.rating.toFixed(1) }}
                </span>
                <span>({{ gig.reviews }} reviews)</span>
              </div>
              <button
                type="button"
                class="rounded-md bg-blue-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-blue-700"
              >
                View Details
              </button>
            </div>
          </div>
        </article>
      </div>
    </section>

    <!-- All Gigs -->
    <section class="mx-6 mb-12">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-slate-900 dark:text-white">
          All Gigs
        </h2>
        <p class="text-xs text-slate-500 dark:text-slate-400">
          {{ filteredGigs.length }} result<span v-if="filteredGigs.length !== 1">s</span>
        </p>
      </div>

      <div v-if="filteredGigs.length" class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        <article
          v-for="gig in otherGigs.length ? otherGigs : filteredGigs"
          :key="gig.id"
          class="rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 flex flex-col justify-between"
        >
          <div>
            <h3 class="text-base font-semibold text-slate-900 dark:text-white mb-1">
              {{ gig.title }}
            </h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">
              {{ gig.category }} • by {{ gig.provider }}
            </p>
            <p class="text-sm text-slate-600 dark:text-slate-300 line-clamp-3 mb-3">
              {{ gig.description }}
            </p>
          </div>

          <div class="flex items-center justify-between mt-2">
            <div class="space-y-1">
              <p class="text-sm font-semibold text-slate-900 dark:text-white">
                ${{ gig.price }}
              </p>
              <div class="flex items-center gap-1 text-xs text-slate-500 dark:text-slate-400">
                <span class="text-yellow-400">★</span>
                <span class="font-semibold text-slate-800 dark:text-slate-100">
                  {{ gig.rating.toFixed(1) }}
                </span>
                <span>({{ gig.reviews }} reviews)</span>
              </div>
            </div>
            <button
              type="button"
              class="rounded-md border border-blue-600 text-blue-600 dark:border-blue-400 dark:text-blue-300 px-3 py-1.5 text-xs font-semibold hover:bg-blue-50 dark:hover:bg-blue-900/30"
            >
              Book Now
            </button>
          </div>
        </article>
      </div>

      <div
        v-else
        class="rounded-xl border border-dashed border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/40 p-8 text-center"
      >
        <p class="text-sm font-medium text-slate-700 dark:text-slate-200 mb-1">
          No gigs found
        </p>
        <p class="text-xs text-slate-500 dark:text-slate-400">
          Try adjusting your filters or search terms.
        </p>
      </div>
    </section>
  </AppLayout>
</template> 