<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import type { BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Dashboard', href: dashboard() },
  { title: 'My Gigs', href: '/my-gigs' },
  { title: 'Add Gig', href: '/my-gigs/add' },
];

const props = defineProps<{
  categories: { id: number; name: string }[];
  barangays: { id: number; name: string }[];
}>();

const categories = props.categories;
const barangays = props.barangays;

const priceTypes = ['per hour', 'per day', 'per project'] as const;
const statuses = ['active', 'inactive'] as const;

const form = useForm({
  title: '',
  category_id: '',
  description: '',
  street: '',
  barangay: '',
  price: '',
  price_type: 'per hour',
  availability: '',
  status: 'active',
  image: null as File | null,
});

const submit = () => {
  // Adjust URL/route name to match your backend store route
  form.post('gigs.store', {
    forceFormData: true, 
  });
};

const handleFileChange = (e: Event) => {
  const target = e.target as HTMLInputElement;
  form.image = target.files?.[0] ?? null;
};
</script>

<template>
  <Head title="Add Gig" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-6 bg-white dark:bg-slate-950 p-4">
      <!-- Header -->
      <section
        class="rounded-xl bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-5 text-white shadow-md"
      >
        <div class="flex flex-col gap-2">
          <h1 class="flex items-center gap-2 text-2xl font-bold">
            <span>➕</span>
            <span>Add New Gig / Service</span>
          </h1>
          <p class="mt-1 text-sm text-blue-100">
            Describe the service you provide so clients can find and book you.
          </p>
        </div>
      </section>

      <!-- Form -->
      <section
        class="rounded-xl max-w-8xl"
      >
      
      <form @submit.prevent="submit" class="space-y-6">
        <div class="grid gap-8 md:grid-cols-3">
          <!-- LEFT CARD: gig details -->
          <div class="col-span-2 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 p-6 space-y-5 shadow-sm">
            <!-- Title -->
            <div>
              <label class="block text-sm font-medium text-slate-800 dark:text-slate-100">
                Gig title
              </label>
              <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">
                Make it clear and specific, e.g. “House Cleaning for 2‑Bedroom Apartment”.
              </p>
              <input
                v-model="form.title"
                type="text"
                class="mt-1 block w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-600 dark:bg-slate-900 dark:text-white"
                required
              />
            </div>

            <!-- Category -->
            <div>
              <label class="block text-sm font-medium text-slate-800 dark:text-slate-100">
                Category
              </label>
              <select
                v-model="form.category_id"
                class="mt-1 block w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-600 dark:bg-slate-900 dark:text-white"
                required
              >
                <option value="" disabled>Select a category</option>
                <option
                  v-for="cat in categories"
                  :key="cat.id"
                  :value="cat.id"
                >
                  {{ cat.name }}
                </option>
              </select>
            </div>

            <!-- Description -->
            <div>
              <label class="block text-sm font-medium text-slate-800 dark:text-slate-100">
                Description
              </label>
              <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">
                Explain what you offer, what’s included, and any requirements.
              </p>
              <textarea
                v-model="form.description"
                rows="4"
                class="mt-1 block w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-600 dark:bg-slate-900 dark:text-white"
                required
              />
            </div>
            <div class="grid gap-5 md:grid-cols-2">
              <!-- Street -->
              <div>
                <label class="block text-sm font-medium text-slate-800 dark:text-slate-100">
                  Street
                </label>
                <input
                  v-model="form.street"
                  type="text"
                  class="mt-1 block w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-600 dark:bg-slate-900 dark:text-white"
                />
              </div>

              <!-- Barangay -->
              <div>
                <label class="block text-sm font-medium text-slate-800 dark:text-slate-100">
                  Barangay
                </label>
                <select
                  v-model="form.barangay"
                  class="mt-1 block w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-600 dark:bg-slate-900 dark:text-white"
                >
                  <option value="" disabled>Select barangay</option>
                  <option v-for="b in barangays" :key="b.id" :value="b.name">
                    {{ b.name }}
                  </option>
                </select>
              </div>
            </div>  
          </div>
          
          <!-- RIGHT CARD: pricing & availability -->
          <div class="rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 p-6 space-y-5 shadow-sm">
            <!-- Price + price type -->
            <div>
              <label class="block text-sm font-medium text-slate-800 dark:text-slate-100">
                Price
              </label>
              <div class="mt-1 flex gap-2">
                <input
                  v-model="form.price"
                  type="number"
                  min="0"
                  step="0.01"
                  placeholder="80.00"
                  class="block w-1/2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-600 dark:bg-slate-900 dark:text-white"
                  required
                />
                <select
                  v-model="form.price_type"
                  class="block w-1/2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-600 dark:bg-slate-900 dark:text-white"
                  required
                >
                  <option v-for="t in priceTypes" :key="t" :value="t">
                    {{ t }}
                  </option>
                </select>
              </div>
            </div>
            
            <!-- Availability -->
            <div>
              <label class="block text-sm font-medium text-slate-800 dark:text-slate-100">
                Availability date
              </label>
              <input
                v-model="form.availability"
                type="date"
                class="mt-1 block w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-600 dark:bg-slate-900 dark:text-white"
              />
              <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                Optional. Leave empty if you are generally available.
              </p>
            </div>

            <!-- Status -->
            <div>
              <label class="block text-sm font-medium text-slate-800 dark:text-slate-100">
                Status
              </label>
              <select
                v-model="form.status"
                class="mt-1 block w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-600 dark:bg-slate-900 dark:text-white"
                required
              >
                <option v-for="s in statuses" :key="s" :value="s">
                  {{ s.charAt(0).toUpperCase() + s.slice(1) }}
                </option>
              </select>
            </div>

            <!-- Image -->
            <div>
              <label class="block text-sm font-medium text-slate-800 dark:text-slate-100">
                Cover image
              </label>
              <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">
                Optional. Upload a photo representing your service.
              </p>
              <input
                type="file"
                accept="image/*"
                class="mt-1 block w-full text-sm text-slate-900 dark:text-slate-100"
                @change="handleFileChange"
              />
            </div>
          </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3 pt-3">
          <a
            href="/my-gigs"
            class="inline-flex items-center rounded-full border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-600 dark:text-slate-100 dark:hover:bg-slate-800"
          >
            Cancel
          </a>
          <button
            type="submit"
            class="inline-flex items-center rounded-full bg-blue-600 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 disabled:opacity-60"
            :disabled="form.processing"
          >
            Save Gig
          </button>
        </div>
      </form>
      </section>
      
    </div>
  </AppLayout>
</template>