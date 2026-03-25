<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import type { BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Dashboard', href: dashboard() },
];

type Role = 'seeker' | 'provider';
const activeRole = ref<Role>('seeker');

// Mock data – replace with real backend data later
const seekerStats = {
  activeBookings: 5,
  pendingRequests: 2,
  completedServices: 12,
};

const providerStats = {
  totalEarnings: 2847,
  earningsChange: 12.5,
  activeGigs: 8,
  activeGigsChange: 2,
  completedJobs: 43,
  completedJobsChange: 8,
  avgRating: 4.9,
  ratingChange: 0.2,
};

const setRole = (role: Role) => {
  activeRole.value = role;
};
</script>

<template>
  <Head title="Dashboard" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <!-- Put the role toggle into the layout header only on this page -->
    <template #header-right>
      <div
        class="inline-flex rounded-full bg-slate-100 p-1 text-sm font-medium"
      >
        <button
          type="button"
          class="rounded-full px-4 py-1.5 transition"
          :class="
            activeRole === 'seeker'
              ? 'bg-blue-600 text-white shadow'
              : 'text-slate-600 hover:text-slate-900'
          "
          @click="setRole('seeker')"
        >
          Seeker
        </button>
        <button
          type="button"
          class="rounded-full px-4 py-1.5 transition"
          :class="
            activeRole === 'provider'
              ? 'bg-blue-600 text-white shadow'
              : 'text-slate-600 hover:text-slate-900'
          "
          @click="setRole('provider')"
        >
          Provider
        </button>
      </div>
    </template>

    <!-- Page content (what you already have) -->
    <div class="flex h-full flex-1 flex-col gap-6 bg-white dark:bg-slate-950 p-4">
      <!-- Seeker dashboard -->
      <main
        v-if="activeRole === 'seeker'"
        class="flex flex-col gap-6"
      >
        <!-- Header + primary stats -->
        <section
          class="flex h-full flex-1 flex-col gap-6 bg-white dark:bg-slate-950 px-6"
        >
          <div class="flex flex-col gap-1">
            <h1 class="pt-4 flex items-center gap-2 text-2xl font-bold text-slate-900 dark:text-white">
              <span>🔍</span>
              <span>Seeker Dashboard</span>
            </h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">
              Find and book local services in your area
            </p>
          </div>

          <div class="mt-3 grid gap-4 md:grid-cols-3">
            <!-- Active Bookings -->
            <div
              class="flex items-center justify-between rounded-xl border border-slate-100 dark:border-slate-700 bg-slate-50 dark:bg-slate-700/50 px-5 py-4"
            >
              <div>
                <h3 class="text-sm font-semibold text-slate-700 dark:text-slate-300">
                  Active Bookings
                </h3>
                <p class="mt-2 text-3xl font-semibold text-slate-900 dark:text-white">
                  {{ seekerStats.activeBookings }}
                </p>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                  Upcoming appointments
                </p>
              </div>
              <div
                class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-100 text-xl"
              >
                📅
              </div>
            </div>

            <!-- Pending Requests -->
            <div
              class="flex items-center justify-between rounded-xl border border-slate-100 dark:border-slate-700 bg-slate-50 dark:bg-slate-700/50 px-5 py-4"
            >
              <div>
                <h3 class="text-sm font-semibold text-slate-700 dark:text-slate-300">
                  Pending Requests
                </h3>
                <p class="mt-2 text-3xl font-semibold text-slate-900 dark:text-white">
                  {{ seekerStats.pendingRequests }}
                </p>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                  Awaiting confirmation
                </p>
              </div>
              <div
                class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-100 text-xl"
              >
                ⏰
              </div>
            </div>

            <!-- Completed Services -->
            <div
              class="flex items-center justify-between rounded-xl border border-slate-100 dark:border-slate-700 bg-slate-50 dark:bg-slate-700/50 px-5 py-4"
            >
              <div>
                <h3 class="text-sm font-semibold text-slate-700 dark:text-slate-300">
                  Completed Services
                </h3>
                <p class="mt-2 text-3xl font-semibold text-slate-900 dark:text-white">
                  {{ seekerStats.completedServices }}
                </p>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                  Services received
                </p>
              </div>
              <div
                class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-xl"
              >
                ✅
              </div>
            </div>
          </div>
        </section>

        <!-- Quick actions + quality services -->
        <section class="mx-6 grid gap-4 lg:grid-cols-3">
          <div
            class="lg:col-span-2 rounded-xl bg-white dark:bg-slate-800 px-6 py-5 shadow-sm border border-slate-200 dark:border-slate-700"
          >
            <h2 class="flex items-center gap-2 text-sm font-semibold text-slate-800 dark:text-white">
              <span>⚡</span>
              <span>Quick Actions</span>
            </h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
              Get started quickly
            </p>

            <div class="mt-4 grid gap-4 md:grid-cols-2">
              <button
                type="button"
                class="flex items-center justify-between rounded-xl bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 text-left text-white shadow-md hover:from-blue-700 hover:to-blue-800"
              >
                <div>
                  <p class="text-xs font-medium uppercase tracking-wide">
                    Find Services
                  </p>
                  <p class="mt-1 text-sm text-blue-100">
                    Browse trusted providers near you
                  </p>
                </div>
                <div class="text-3xl">🔍</div>
              </button>

              <button
                type="button"
                class="flex items-center justify-between rounded-xl border border-slate-200 bg-white dark:bg-slate-800 dark:border-slate-700 px-6 py-4 text-left hover:bg-slate-50 dark:hover:bg-slate-700"
              >
                <div>
                  <p class="text-xs font-medium uppercase tracking-wide text-slate-700 dark:text-slate-300">
                    View My Bookings
                  </p>
                  <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Manage your upcoming appointments
                  </p>
                </div>
                <div class="text-3xl">📅</div>
              </button>
            </div>
          </div>

          <div
            class="rounded-xl bg-blue-50 dark:bg-blue-900/20 px-6 py-5 shadow-sm border border-blue-100 dark:border-blue-800"
          >
            <h3 class="text-sm font-semibold text-slate-800 dark:text-white">
              Quality Services
            </h3>
            <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">
              All service providers are verified and rated by the community.
            </p>
          </div>
        </section>

        <!-- Recent activity + recommended -->
        <section class="mx-6 grid gap-4 lg:grid-cols-3">
          <div class="rounded-xl bg-white dark:bg-slate-800 px-6 py-5 shadow-sm lg:col-span-2 border border-slate-200 dark:border-slate-700">
            <h2 class="flex items-center gap-2 text-sm font-semibold text-slate-800 dark:text-white">
              <span>🕒</span>
              <span>Recent Activity</span>
            </h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
              Your latest updates
            </p>

            <ul class="mt-4 space-y-3 text-sm">
              <li class="flex items-start gap-3">
                <span class="mt-0.5 text-lg">📅</span>
                <div>
                  <p class="font-medium text-slate-800 dark:text-white">
                    New booking confirmed with Jennifer Adams
                  </p>
                  <p class="text-xs text-slate-500 dark:text-slate-400">2 hours ago</p>
                </div>
              </li>
              <li class="flex items-start gap-3">
                <span class="mt-0.5 text-lg">⭐</span>
                <div>
                  <p class="font-medium text-slate-800 dark:text-white">
                    You left a 5-star review for Home Repair Service
                  </p>
                  <p class="text-xs text-slate-500 dark:text-slate-400">5 hours ago</p>
                </div>
              </li>
            </ul>
          </div>

          <div class="rounded-xl bg-white dark:bg-slate-800 px-6 py-5 shadow-sm border border-slate-200 dark:border-slate-700">
            <h2 class="text-sm font-semibold text-slate-800 dark:text-white">
              Recommended Services
            </h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
              Based on your recent activity
            </p>

            <ul class="mt-4 space-y-3 text-sm">
              <li>
                <p class="font-medium text-slate-800 dark:text-white">
                  Home Cleaning &amp; Organization
                </p>
                <p class="text-xs text-slate-500 dark:text-slate-400">4.9 • 120 reviews</p>
              </li>
              <li>
                <p class="font-medium text-slate-800 dark:text-white">
                  Tutoring – Math &amp; Science
                </p>
                <p class="text-xs text-slate-500 dark:text-slate-400">4.8 • 85 reviews</p>
              </li>
            </ul>
          </div>
        </section>
      </main>

      <!-- Provider dashboard -->
      <main
        v-else
        class="flex flex-col gap-6"
      >
        <!-- Header + KPIs -->
        <section
          class="rounded-xl bg-white dark:bg-slate-800 px-6 py-5 shadow-sm border border-slate-200 dark:border-slate-700"
        >
          <div class="flex flex-col gap-1">
            <h1 class="flex items-center gap-2 text-2xl font-bold text-slate-900 dark:text-white">
              <span>🧰</span>
              <span>Provider Dashboard</span>
            </h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">
              Track your gigs, earnings, and performance
            </p>
          </div>

          <div class="mt-6 grid gap-4 md:grid-cols-4">
            <!-- Total Earnings -->
            <div
              class="rounded-xl border border-slate-100 dark:border-slate-700 bg-slate-50 dark:bg-slate-700/50 px-5 py-4"
            >
              <p class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-400">
                Total Earnings
              </p>
              <p class="mt-3 text-3xl font-semibold text-slate-900 dark:text-white">
                ${{ providerStats.totalEarnings.toLocaleString() }}
              </p>
              <p class="mt-1 text-xs font-medium text-emerald-600 dark:text-emerald-400">
                +{{ providerStats.earningsChange }}% This month
              </p>
            </div>

            <!-- Active Gigs -->
            <div
              class="rounded-xl border border-slate-100 dark:border-slate-700 bg-slate-50 dark:bg-slate-700/50 px-5 py-4"
            >
              <p class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-400">
                Active Gigs
              </p>
              <p class="mt-3 text-3xl font-semibold text-slate-900 dark:text-white">
                {{ providerStats.activeGigs }}
              </p>
              <p class="mt-1 text-xs font-medium text-emerald-600 dark:text-emerald-400">
                +{{ providerStats.activeGigsChange }} Currently listed
              </p>
            </div>

            <!-- Completed Jobs -->
            <div
              class="rounded-xl border border-slate-100 dark:border-slate-700 bg-slate-50 dark:bg-slate-700/50 px-5 py-4"
            >
              <p class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-400">
                Completed Jobs
              </p>
              <p class="mt-3 text-3xl font-semibold text-slate-900 dark:text-white">
                {{ providerStats.completedJobs }}
              </p>
              <p class="mt-1 text-xs font-medium text-emerald-600 dark:text-emerald-400">
                +{{ providerStats.completedJobsChange }} This month
              </p>
            </div>

            <!-- Avg. Rating -->
            <div
              class="rounded-xl border border-slate-100 dark:border-slate-700 bg-slate-50 dark:bg-slate-700/50 px-5 py-4"
            >
              <p class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-400">
                Avg. Rating
              </p>
              <p class="mt-3 text-3xl font-semibold text-slate-900 dark:text-white">
                {{ providerStats.avgRating }}
              </p>
              <p class="mt-1 text-xs font-medium text-emerald-600 dark:text-emerald-400">
                +{{ providerStats.ratingChange }} From 127 reviews
              </p>
            </div>
          </div>
        </section>

        <!-- Bookings preview + recent activity -->
        <section class="mx-6 grid gap-4 lg:grid-cols-3">
          <!-- Bookings -->
          <div class="rounded-xl bg-white dark:bg-slate-800 px-6 py-5 shadow-sm lg:col-span-2 border border-slate-200 dark:border-slate-700">
            <div class="flex items-center justify-between">
              <div>
                <h2 class="text-sm font-semibold text-slate-800 dark:text-white">
                  Bookings
                </h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                  Manage your upcoming appointments
                </p>
              </div>
              <div
                class="inline-flex rounded-full bg-slate-100 dark:bg-slate-700 p-1 text-xs font-medium"
              >
                <button
                  type="button"
                  class="rounded-full px-3 py-1.5 bg-white dark:bg-slate-600 shadow-sm text-slate-900 dark:text-white"
                >
                  Confirmed
                </button>
                <button
                  type="button"
                  class="rounded-full px-3 py-1.5 text-slate-500 dark:text-slate-400"
                >
                  Pending
                </button>
              </div>
            </div>

            <div
              class="mt-4 rounded-xl border border-slate-100 dark:border-slate-700 bg-slate-50 dark:bg-slate-700/50 px-4 py-3"
            >
              <div class="flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                  <div
                    class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-300 dark:bg-slate-600"
                  >
                    🙂
                  </div>
                  <div>
                    <p class="text-sm font-semibold text-slate-900 dark:text-white">
                      Home Repair &amp; Handyman Services
                    </p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                      Client: Jennifer Adams
                    </p>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                      March 26, 2026 • 10:00 AM
                    </p>
                  </div>
                </div>
                <div class="text-right">
                  <p class="text-sm font-semibold text-emerald-600 dark:text-emerald-400">
                    $90
                  </p>
                  <span
                    class="mt-1 inline-flex items-center rounded-full bg-emerald-100 dark:bg-emerald-900/30 px-2 py-0.5 text-[11px] font-medium text-emerald-700 dark:text-emerald-400"
                  >
                    Confirmed
                  </span>
                </div>
              </div>
            </div>
          </div>

          <!-- Recent Activity -->
          <div class="rounded-xl border border-slate-100 dark:border-slate-700 bg-white dark:bg-slate-800 px-6 py-5">
            <h2 class="text-sm font-semibold text-slate-800 dark:text-white">
              Recent Activity
            </h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
              Your latest updates
            </p>

            <ul class="mt-4 space-y-3 text-sm">
              <li class="flex items-start gap-3">
                <span class="mt-0.5 text-lg">📅</span>
                <div>
                  <p class="font-medium text-slate-800 dark:text-slate-200">
                    New booking request from Jennifer Adams
                  </p>
                  <p class="text-xs text-slate-500 dark:text-slate-400">2 hours ago</p>
                </div>
              </li>
              <li class="flex items-start gap-3">
                <span class="mt-0.5 text-lg">⭐</span>
                <div>
                  <p class="font-medium text-slate-800 dark:text-slate-200">
                    Sarah Johnson left a 5-star review
                  </p>
                  <p class="text-xs text-slate-500 dark:text-slate-400">5 hours ago</p>
                </div>
              </li>
            </ul>
          </div>
        </section>

        <!-- Performance summary + quick actions -->
        <section class="mx-6 grid gap-4 lg:grid-cols-3">
          <div class="rounded-xl border border-slate-100 dark:border-slate-700 bg-white dark:bg-slate-800 px-6 py-5">
            <h2 class="text-sm font-semibold text-slate-800 dark:text-white">
              Performance Summary
            </h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
              Overview for the current month
            </p>

            <ul class="mt-4 space-y-2 text-sm text-slate-700 dark:text-slate-300">
              <li>• 43 jobs completed (+8 vs last month)</li>
              <li>• 4.9 average rating from 127 reviews</li>
              <li>• $2,847 total earnings (+12.5% this month)</li>
            </ul>
          </div>

          <div class="rounded-xl border border-slate-100 dark:border-slate-700 bg-white dark:bg-slate-800 px-6 py-5">
            <h2 class="text-sm font-semibold text-slate-800 dark:text-white">
              Quick Actions
            </h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
              Manage your services
            </p>

            <div class="mt-4 space-y-3">
              <button
                type="button"
                class="flex w-full items-center justify-between rounded-xl bg-gradient-to-r from-blue-600 to-blue-700 px-5 py-3 text-sm font-medium text-white shadow-md hover:from-blue-700 hover:to-blue-800"
              >
                <span>Add Service</span>
                <span class="text-lg">➕</span>
              </button>
              <button
                type="button"
                class="flex w-full items-center justify-between rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 px-5 py-3 text-sm font-medium text-slate-800 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-600"
              >
                <span>View Booking Requests</span>
                <span class="text-lg">📥</span>
              </button>
            </div>
          </div>
        </section>
      </main>
    </div>
  </AppLayout>
</template>
