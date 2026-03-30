<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Badge } from '@/components/ui/badge';
import {
  Card,
  CardContent,
  CardHeader,
  CardTitle,
} from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { useInitials } from '@/composables/useInitials';
import { MapPin, CalendarDays, Star, Bell, CreditCard, Shield } from 'lucide-vue-next';
import { edit as editProfile } from '@/routes/profile';
import { edit as editPassword } from '@/routes/user-password';
import { show as showTwoFactor } from '@/routes/two-factor';
import type { BreadcrumbItem, User } from '@/types';

type PageProps = {
  auth: { user: User };
};

const page = usePage<PageProps>();
const user = computed(() => page.props.auth.user);

const { getInitials } = useInitials();

const memberSince = computed(() => {
  if (!user.value?.created_at) return '';
  return new Date(user.value.created_at).toLocaleDateString();
});

// Simple split of full name for display only
const firstName = computed(() => {
  const parts = (user.value?.name || '').trim().split(' ');
  return parts[0] || '';
});

const lastName = computed(() => {
  const parts = (user.value?.name || '').trim().split(' ');
  return parts.length > 1 ? parts.slice(1).join(' ') : '';
});

// Optional extra fields if you add them to the users table
const locationDisplay = computed(() => {
  const u = user.value as any;
  return u?.location || 'Add your location in profile settings';
});

const phoneDisplay = computed(() => {
  const u = user.value as any;
  return u?.phone || '+ Add a phone number';
});

const bioDisplay = computed(() => {
  const u = user.value as any;
  return (
    u?.bio ||
    "Write a short bio about what you do and how you help clients."
  );
});

// Mock stats for now – wire these to real data when available
const rating = 4.9;
const reviewsCount = 38;
const gigsCompleted = 47;

// Tabs
type TabId = 'personal' | 'settings' | 'security';
const activeTab = ref<TabId>('personal');

// Settings tab – local UI state only (no backend yet)
const emailNotifications = ref(true);
const pushNotifications = ref(true);
const marketingEmails = ref(false);

const breadcrumbItems: BreadcrumbItem[] = [
  {
    title: 'Profile',
    href: editProfile(),
  },
];
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbItems">
    <Head title="Profile" />

    <section
      class="mx-auto flex w-full max-w-5xl flex-col gap-6 py-8"
    >
      <!-- PROFILE HEADER CARD -->
      <Card
        class="border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900"
      >
        <CardContent
          class="flex flex-col gap-6 p-6 sm:flex-row sm:items-center sm:justify-between"
        >
          <div class="flex items-center gap-4 sm:gap-6">
            <!-- Avatar -->
            <div class="relative">
              <Avatar class="h-20 w-20 rounded-full">
                <AvatarImage
                  v-if="(user as any).avatar"
                  :src="(user as any).avatar"
                  :alt="user.name"
                />
                <AvatarFallback
                  class="rounded-full bg-slate-200 text-lg font-semibold text-slate-800 dark:bg-slate-700 dark:text-white"
                >
                  {{ getInitials(user.name) }}
                </AvatarFallback>
              </Avatar>
            </div>

            <div class="space-y-2">
              <div class="flex flex-wrap items-center gap-2">
                <h1
                  class="text-2xl font-semibold text-slate-900 dark:text-white"
                >
                  {{ user.name }}
                </h1>

                <Badge
                  v-if="user.email_verified_at"
                  variant="outline"
                  class="gap-1 border-emerald-500/60 bg-emerald-50 text-emerald-700 dark:border-emerald-500/50 dark:bg-emerald-900/30 dark:text-emerald-300"
                >
                  <Shield class="h-3.5 w-3.5" />
                  Verified
                </Badge>
              </div>

              <div
                class="flex flex-wrap items-center gap-3 text-xs text-slate-500 dark:text-slate-400"
              >
                <span class="inline-flex items-center gap-1">
                  <MapPin class="h-3.5 w-3.5" />
                  <span>{{ locationDisplay }}</span>
                </span>
                <span class="inline-flex items-center gap-1">
                  <CalendarDays class="h-3.5 w-3.5" />
                  <span>Member since {{ memberSince }}</span>
                </span>
              </div>

              <div
                class="flex flex-wrap items-center gap-3 text-sm text-slate-700 dark:text-slate-200"
              >
                <span class="inline-flex items-center gap-1">
                  <Star
                    class="h-4 w-4 fill-yellow-400 text-yellow-400"
                  />
                  <span class="font-semibold">{{ rating }}</span>
                  <span class="text-xs text-slate-500 dark:text-slate-400">
                    ({{ reviewsCount }} reviews)
                  </span>
                </span>

                <span
                  class="h-1 w-1 rounded-full bg-slate-300 dark:bg-slate-600"
                ></span>

                <span class="text-xs text-slate-500 dark:text-slate-400">
                  {{ gigsCompleted }} gigs completed
                </span>
              </div>
            </div>
          </div>

          <div class="self-start">
            <Button as-child>
              <Link :href="editProfile()">
                Edit Profile
              </Link>
            </Button>
          </div>
        </CardContent>
      </Card>

      <!-- TABS -->
      <div
        class="rounded-full bg-slate-100 p-1 text-sm font-medium text-slate-600 dark:bg-slate-800 dark:text-slate-300"
      >
        <div class="grid grid-cols-3 gap-1">
          <button
            type="button"
            class="rounded-full px-4 py-2 transition"
            :class="
              activeTab === 'personal'
                ? 'bg-white text-slate-900 shadow-sm dark:bg-slate-900 dark:text-white'
                : 'text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white'
            "
            @click="activeTab = 'personal'"
          >
            Personal Info
          </button>
          <button
            type="button"
            class="rounded-full px-4 py-2 transition"
            :class="
              activeTab === 'settings'
                ? 'bg-white text-slate-900 shadow-sm dark:bg-slate-900 dark:text-white'
                : 'text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white'
            "
            @click="activeTab = 'settings'"
          >
            Settings
          </button>
          <button
            type="button"
            class="rounded-full px-4 py-2 transition"
            :class="
              activeTab === 'security'
                ? 'bg-white text-slate-900 shadow-sm dark:bg-slate-900 dark:text-white'
                : 'text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white'
            "
            @click="activeTab = 'security'"
          >
            Security
          </button>
        </div>
      </div>

      <!-- TAB CONTENT -->
      <Card
        class="border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900"
      >
        <CardHeader class="pb-3">
          <CardTitle class="text-base font-semibold text-slate-900 dark:text-white">
            <span v-if="activeTab === 'personal'">Personal Information</span>
            <span v-else-if="activeTab === 'settings'">Notifications &amp; Billing</span>
            <span v-else>Security</span>
          </CardTitle>
          <p
            v-if="activeTab === 'personal'"
            class="text-sm text-slate-500 dark:text-slate-400"
          >
            Update your personal details and how they appear to others.
          </p>
          <p
            v-else-if="activeTab === 'settings'"
            class="text-sm text-slate-500 dark:text-slate-400"
          >
            Manage notifications and payment methods.
          </p>
          <p
            v-else
            class="text-sm text-slate-500 dark:text-slate-400"
          >
            Keep your account secure with password and two-factor
            settings.
          </p>
        </CardHeader>

        <CardContent class="space-y-8">
          <!-- PERSONAL INFO TAB -->
          <div
            v-if="activeTab === 'personal'"
            class="space-y-6"
          >
            <div
              class="grid gap-4 md:grid-cols-2"
            >
              <div class="space-y-1.5">
                <label
                  class="text-xs font-medium text-slate-500 dark:text-slate-400"
                >
                  First Name
                </label>
                <input
                  :value="firstName"
                  disabled
                  class="block w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-900 shadow-sm dark:border-slate-700 dark:bg-slate-800 dark:text-white"
                />
              </div>
              <div class="space-y-1.5">
                <label
                  class="text-xs font-medium text-slate-500 dark:text-slate-400"
                >
                  Last Name
                </label>
                <input
                  :value="lastName"
                  disabled
                  class="block w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-900 shadow-sm dark:border-slate-700 dark:bg-slate-800 dark:text-white"
                />
              </div>
            </div>

            <div class="space-y-1.5">
              <label
                class="text-xs font-medium text-slate-500 dark:text-slate-400"
              >
                Email
              </label>
              <input
                :value="user.email"
                disabled
                class="block w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-900 shadow-sm dark:border-slate-700 dark:bg-slate-800 dark:text-white"
              />
            </div>

            <div class="space-y-1.5">
              <label
                class="text-xs font-medium text-slate-500 dark:text-slate-400"
              >
                Phone Number
              </label>
              <input
                :value="phoneDisplay"
                disabled
                class="block w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-900 shadow-sm dark:border-slate-700 dark:bg-slate-800 dark:text-white"
              />
            </div>

            <div class="space-y-1.5">
              <label
                class="text-xs font-medium text-slate-500 dark:text-slate-400"
              >
                Location
              </label>
              <input
                :value="locationDisplay"
                disabled
                class="block w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-900 shadow-sm dark:border-slate-700 dark:bg-slate-800 dark:text-white"
              />
            </div>

            <div class="space-y-1.5">
              <label
                class="text-xs font-medium text-slate-500 dark:text-slate-400"
              >
                Bio
              </label>
              <textarea
                :value="bioDisplay"
                disabled
                rows="3"
                class="block w-full resize-none rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-900 shadow-sm dark:border-slate-700 dark:bg-slate-800 dark:text-white"
              />
            </div>

            <div class="space-y-2">
              <p
                class="text-xs font-medium text-slate-500 dark:text-slate-400"
              >
                Skills
              </p>
              <div class="flex flex-wrap gap-2">
                <span
                  class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700 dark:bg-slate-800 dark:text-slate-200"
                >
                  Graphic Design
                </span>
                <span
                  class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700 dark:bg-slate-800 dark:text-slate-200"
                >
                  Organization
                </span>
                <span
                  class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700 dark:bg-slate-800 dark:text-slate-200"
                >
                  Event Planning
                </span>
              </div>
            </div>
          </div>

          <!-- SETTINGS TAB -->
          <div
            v-else-if="activeTab === 'settings'"
            class="space-y-8"
          >
            <!-- Notifications -->
            <div class="space-y-3">
              <h3
                class="flex items-center gap-2 text-sm font-semibold text-slate-900 dark:text-white"
              >
                <Bell class="h-4 w-4" />
                Notifications
              </h3>
              <p
                class="text-xs text-slate-500 dark:text-slate-400"
              >
                Manage how you receive notifications and updates.
              </p>

              <div class="divide-y divide-slate-200 text-sm dark:divide-slate-800">
                <div
                  class="flex items-center justify-between py-3"
                >
                  <div>
                    <p
                      class="font-medium text-slate-800 dark:text-slate-100"
                    >
                      Email Notifications
                    </p>
                    <p
                      class="text-xs text-slate-500 dark:text-slate-400"
                    >
                      Receive email updates about your bookings and
                      messages.
                    </p>
                  </div>
                  <button
                    type="button"
                    @click="emailNotifications = !emailNotifications"
                    :class="[
                      'relative inline-flex h-6 w-11 items-center rounded-full border transition-colors',
                      emailNotifications
                        ? 'bg-blue-600 border-blue-600'
                        : 'bg-slate-200 border-slate-300 dark:bg-slate-700 dark:border-slate-600',
                    ]"
                  >
                    <span
                      :class="[
                        'inline-block h-5 w-5 transform rounded-full bg-white shadow transition-transform',
                        emailNotifications ? 'translate-x-5' : 'translate-x-1',
                      ]"
                    />
                  </button>
                </div>

                <div
                  class="flex items-center justify-between py-3"
                >
                  <div>
                    <p
                      class="font-medium text-slate-800 dark:text-slate-100"
                    >
                      Push Notifications
                    </p>
                    <p
                      class="text-xs text-slate-500 dark:text-slate-400"
                    >
                      Get push notifications for important updates.
                    </p>
                  </div>
                  <button
                    type="button"
                    @click="pushNotifications = !pushNotifications"
                    :class="[
                      'relative inline-flex h-6 w-11 items-center rounded-full border transition-colors',
                      pushNotifications
                        ? 'bg-blue-600 border-blue-600'
                        : 'bg-slate-200 border-slate-300 dark:bg-slate-700 dark:border-slate-600',
                    ]"
                  >
                    <span
                      :class="[
                        'inline-block h-5 w-5 transform rounded-full bg-white shadow transition-transform',
                        pushNotifications ? 'translate-x-5' : 'translate-x-1',
                      ]"
                    />
                  </button>
                </div>

                <div
                  class="flex items-center justify-between py-3"
                >
                  <div>
                    <p
                      class="font-medium text-slate-800 dark:text-slate-100"
                    >
                      Marketing Emails
                    </p>
                    <p
                      class="text-xs text-slate-500 dark:text-slate-400"
                    >
                      Receive news, tips, and special offers.
                    </p>
                  </div>
                  <button
                    type="button"
                    @click="marketingEmails = !marketingEmails"
                    :class="[
                      'relative inline-flex h-6 w-11 items-center rounded-full border transition-colors',
                      marketingEmails
                        ? 'bg-blue-600 border-blue-600'
                        : 'bg-slate-200 border-slate-300 dark:bg-slate-700 dark:border-slate-600',
                    ]"
                  >
                    <span
                      :class="[
                        'inline-block h-5 w-5 transform rounded-full bg-white shadow transition-transform',
                        marketingEmails ? 'translate-x-5' : 'translate-x-1',
                      ]"
                    />
                  </button>
                </div>
              </div>
            </div>

            <!-- Payment methods -->
            <div class="space-y-3">
              <h3
                class="flex items-center gap-2 text-sm font-semibold text-slate-900 dark:text-white"
              >
                <CreditCard class="h-4 w-4" />
                Payment Methods
              </h3>
              <p
                class="text-xs text-slate-500 dark:text-slate-400"
              >
                Manage your payment and payout methods.
              </p>

              <div
                class="space-y-3 rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm dark:border-slate-700 dark:bg-slate-800/60"
              >
                <div
                  class="flex items-center justify-between gap-4 rounded-lg bg-white p-3 shadow-sm dark:bg-slate-900"
                >
                  <div class="flex items-center gap-3">
                    <div
                      class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-200"
                    >
                      <CreditCard class="h-4 w-4" />
                    </div>
                    <div>
                      <p
                        class="text-sm font-medium text-slate-900 dark:text-white"
                      >
                        •••• •••• •••• 4242
                      </p>
                      <p
                        class="text-xs text-slate-500 dark:text-slate-400"
                      >
                        Expires 12/26
                      </p>
                    </div>
                  </div>

                  <Badge
                    variant="outline"
                    class="text-xs text-slate-700 dark:text-slate-200"
                  >
                    Primary
                  </Badge>
                </div>

                <Button
                  variant="outline"
                  class="w-full justify-center text-xs"
                  type="button"
                >
                  + Add Payment Method
                </Button>
              </div>
            </div>
          </div>

          <!-- SECURITY TAB -->
          <div
            v-else
            class="space-y-6"
          >
            <div class="space-y-3">
              <h3
                class="flex items-center gap-2 text-sm font-semibold text-slate-900 dark:text-white"
              >
                <Shield class="h-4 w-4" />
                Account Security
              </h3>
              <p
                class="text-xs text-slate-500 dark:text-slate-400"
              >
                Use a strong password and enable two-factor authentication
                to keep your account secure.
              </p>
            </div>

            <div
              class="space-y-3 rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm dark:border-slate-700 dark:bg-slate-800/60"
            >
              <div class="flex items-center justify-between gap-4">
                <div>
                  <p
                    class="text-sm font-medium text-slate-900 dark:text-white"
                  >
                    Password
                  </p>
                  <p
                    class="text-xs text-slate-500 dark:text-slate-400"
                  >
                    Choose a long, random password you don’t reuse
                    elsewhere.
                  </p>
                </div>
                <Button
                  variant="outline"
                  size="sm"
                  as-child
                >
                  <Link :href="editPassword()">
                    Change password
                  </Link>
                </Button>
              </div>

              <div
                class="h-px w-full bg-slate-200 dark:bg-slate-700"
              ></div>

              <div class="flex items-center justify-between gap-4">
                <div>
                  <p
                    class="text-sm font-medium text-slate-900 dark:text-white"
                  >
                    Two-factor authentication
                  </p>
                  <p
                    class="text-xs text-slate-500 dark:text-slate-400"
                  >
                    Add an extra layer of security to your account.
                  </p>
                </div>
                <Button
                  variant="outline"
                  size="sm"
                  as-child
                >
                  <Link :href="showTwoFactor()">
                    Manage 2FA
                  </Link>
                </Button>
              </div>
            </div>

            <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
              <Checkbox disabled checked />
              <span>
                Your data is encrypted and stored securely.
              </span>
            </div>
          </div>
        </CardContent>
      </Card>
    </section>
  </AppLayout>
</template>