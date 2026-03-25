<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { computed, ref, onMounted, onUnmounted } from 'vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Card } from '@/components/ui/card';
import { dashboard, login, register } from '@/routes';


type Props = {
    canRegister: boolean;
};

defineProps<Props>();

const activeSection = ref('browse-section');

onMounted(() => {
    const sectionIds = ['browse-section', 'categories-section', 'featured-section', 'learn-more-section'];
    const observers: IntersectionObserver[] = [];

    sectionIds.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
        const observer = new window.IntersectionObserver(
            (entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                activeSection.value = id;
                }
            });
            },
            { threshold: 1 }
        );
        observer.observe(el);
        observers.push(observer);
        }
  });

  onUnmounted(() => {
    observers.forEach(observer => observer.disconnect());
  });
});

const searchQuery = ref('');

// Mock categories data - replace with actual data from backend
const categories = [
    { id: 1, name: 'Tutoring', icon: '📚' },
    { id: 2, name: 'Home Repair', icon: '🔨' },
    { id: 3, name: 'Cleaning', icon: '✨' },
    { id: 4, name: 'Handwriting', icon: '✍️' },
    { id: 5, name: 'Fitness', icon: '💪' },
    { id: 6, name: 'Plumbing', icon: '🔧' },
];

// Mock featured services - replace with actual data from backend
const featuredServices = [
    { id: 1, name: 'Professional Tutoring', category: 'Tutoring', rating: 4.8, reviews: 120, provider: 'Jane Smith' },
    { id: 2, name: 'House Cleaning', category: 'Cleaning', rating: 4.9, reviews: 95, provider: 'Clean Crew' },
    { id: 3, name: 'Plumbing Services', category: 'Plumbing', rating: 4.7, reviews: 80, provider: 'Pro Plumbers' },
];

const handleBrowse = () => {
    // Navigate to services page or apply filter
    console.log('Browse services');
};

const handleSearch = () => {
    // Handle search with searchQuery
    console.log('Searching for:', searchQuery.value);
};

const scrollToSection = (sectionId: string) => {
    const element = document.getElementById(sectionId);
    if (element) {
        element.scrollIntoView({ behavior: 'smooth' });
    }
};
</script>

<template>
    <Head title="GigLocal - Find Local Services in Your Community" />
    <div class="min-h-screen bg-white dark:bg-slate-950">
        <!-- Navigation Header -->
        <header class="sticky top-0 z-50 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800">
            <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <img
                        src="/logo/GigLocalIcon.png"
                        alt="GigLocal Logo"
                        class="w-10 h-10 rounded-md"/>
                    <span class="font-bold text-lg text-slate-900 dark:text-white hidden sm:inline">GigLocal</span>
                </div>
                
                <div class="hidden md:flex items-center gap-6">
                    <button class="text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white text-sm"
                        :class="activeSection === 'browse-section' ? 'border-blue-600 dark:border-blue-400 font-bold' : 'border-transparent'"
                        @click="scrollToSection('browse-section')"
                    >
                        Browse
                    </button>
                    <button class="text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white text-sm"
                        :class="activeSection === 'categories-section' ? 'border-blue-600 dark:border-blue-400 font-bold' : 'border-transparent'"
                        @click="scrollToSection('categories-section')"
                    >
                        Categories
                    </button>
                    <button class="text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white text-sm"
                        :class="activeSection === 'featured-section' ? 'border-blue-600 dark:border-blue-400 font-bold' : 'border-transparent'"
                        @click="scrollToSection('featured-section')"
                    >
                        Featured Services
                    </button>
                    <button class="text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white text-sm"
                        :class="activeSection === 'learn-more-section' ? 'border-blue-600 dark:border-blue-400 font-bold' : 'border-transparent'"
                        @click="scrollToSection('learn-more-section')"
                    >
                        Learn More
                    </button>
                </div>

                <div class="flex items-center gap-3">
                    <template v-if="$page.props.auth.user">
                        <Link
                            :href="dashboard()"
                            class="text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white text-sm"
                        >
                            Dashboard
                        </Link>
                    </template>
                    <template v-else>
                        <Link
                            :href="login()"
                            class="text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white text-sm"
                        >
                            Log in
                        </Link>
                        <Link
                            v-if="canRegister"
                            :href="register()"
                            class="bg-slate-900 dark:bg-white text-white dark:text-slate-900 px-4 py-1.5 rounded-md text-sm font-medium hover:bg-slate-800 dark:hover:bg-slate-100"
                        >
                            Register    
                        </Link>
                    </template>
                </div>
            </nav>
        </header>

        <!-- Hero Section -->
        <section id="browse-section" class="bg-gradient-to-r from-blue-600 to-blue-800 dark:from-blue-900 dark:to-slate-900 py-20 px-4">
            <div class="max-w-7xl mx-auto text-center">
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-white mb-6">
                    Find Local Services in Your Community
                </h1>
                <p class="text-lg sm:text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                    Connect with trusted professionals for tutoring, repairs, errands, freelance work, and more—all in your neighborhood.
                </p>

                <!-- Search Bar -->
                <div class="max-w-2xl mx-auto flex flex-col sm:flex-row gap-3 mb-8">
                    <div class="flex-1 flex items-center bg-white dark:bg-slate-800 rounded-lg overflow-hidden">
                        <svg class="w-5 h-5 text-slate-400 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <Input
                            v-model="searchQuery"
                            type="text"
                            placeholder="Search services..."
                            class="flex-1 border-0 px-4 py-3 dark:bg-slate-800 dark:text-white"
                        />
                    </div>
                    <Button
                        @click="handleSearch"
                        class="bg-slate-900 dark:bg-white text-white dark:text-slate-900 px-8 py-3 rounded-lg hover:bg-slate-800 dark:hover:bg-slate-100"
                    >
                        Search
                    </Button>
                </div>

                <Button
                    @click="handleBrowse"
                    variant="outline"
                    class="border-white text-white hover:bg-white hover:text-blue-600 dark:border-slate-400 dark:text-slate-200"
                >
                    Browse All Services
                </Button>
            </div>
        </section>

        <!-- Popular Categories Section -->
        <section id="categories-section" class="py-16 px-4 bg-slate-50 dark:bg-slate-900">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-2 text-center">
                    Popular Categories
                </h2>
                <p class="text-slate-600 dark:text-slate-400 text-center mb-12">
                    Browse services by category
                </p>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                    <div
                        v-for="category in categories"
                        :key="category.id"
                        class="bg-white dark:bg-slate-800 rounded-lg p-6 text-center hover:shadow-lg transition-shadow cursor-pointer"
                    >
                        <div class="text-4xl mb-3">{{ category.icon }}</div>
                        <h3 class="font-semibold text-slate-900 dark:text-white text-sm sm:text-base">
                            {{ category.name }}
                        </h3>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Services Section -->
        <section id="featured-section" class="py-16 px-4">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">
                    Featured Services
                </h2>
                <p class="text-slate-600 dark:text-slate-400 mb-12">
                    Check out some of our top-rated services
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <Card
                        v-for="service in featuredServices"
                        :key="service.id"
                        class="overflow-hidden hover:shadow-lg transition-shadow dark:bg-slate-800 dark:border-slate-700"
                    >
                        <div class="h-40 bg-gradient-to-br from-blue-100 to-blue-50 dark:from-slate-700 dark:to-slate-600 flex items-center justify-center">
                            <div class="text-6xl">📌</div>
                        </div>
                        <div class="p-6">
                            <div class="inline-block bg-blue-100 dark:bg-slate-700 text-blue-700 dark:text-blue-300 px-3 py-1 rounded-full text-xs font-semibold mb-3">
                                {{ service.category }}
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">
                                {{ service.name }}
                            </h3>
                            <p class="text-slate-600 dark:text-slate-400 text-sm mb-4">
                                by {{ service.provider }}
                            </p>
                            <div class="flex items-center gap-1 mb-4">
                                <span class="text-yellow-400">★</span>
                                <span class="font-semibold text-slate-900 dark:text-white">{{ service.rating }}</span>
                                <span class="text-slate-600 dark:text-slate-400 text-sm">({{ service.reviews }} reviews)</span>
                            </div>
                            <Button class="w-full bg-blue-600 hover:bg-blue-700 text-white">
                                View Details
                            </Button>
                        </div>
                    </Card>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section id="learn-more-section" class="bg-slate-900 dark:bg-slate-950 text-white py-16 px-4">
            <div class="max-w-7xl mx-auto text-center">
                <h2 class="text-3xl font-bold mb-6">Ready to get started?</h2>
                <p class="text-slate-300 mb-8 text-lg">
                    Post your first gig today and start connecting with your community
                </p>
                <div class="flex gap-4 justify-center flex-wrap">
                    <Link
                        v-if="canRegister"
                        :href="register()"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors"
                    >
                        Get Started
                    </Link>
                    <Link
                        v-else
                        :href="login()"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors"
                    >
                        Sign In
                    </Link>
                    <button class="border-2 border-white text-white hover:bg-white hover:text-slate-900 px-8 py-3 rounded-lg font-semibold transition-colors">
                        Learn More
                    </button>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-slate-100 dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 py-12 px-4">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-8">
                    <div>
                        <h4 class="font-bold text-slate-900 dark:text-white mb-4">About</h4>
                        <ul class="space-y-2 text-sm text-slate-600 dark:text-slate-400">
                            <li><a href="#" class="hover:text-slate-900 dark:hover:text-white">About Us</a></li>
                            <li><a href="#" class="hover:text-slate-900 dark:hover:text-white">Blog</a></li>
                            <li><a href="#" class="hover:text-slate-900 dark:hover:text-white">Careers</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 dark:text-white mb-4">Support</h4>
                        <ul class="space-y-2 text-sm text-slate-600 dark:text-slate-400">
                            <li><a href="#" class="hover:text-slate-900 dark:hover:text-white">Help Center</a></li>
                            <li><a href="#" class="hover:text-slate-900 dark:hover:text-white">Contact Us</a></li>
                            <li><a href="#" class="hover:text-slate-900 dark:hover:text-white">FAQ</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 dark:text-white mb-4">Legal</h4>
                        <ul class="space-y-2 text-sm text-slate-600 dark:text-slate-400">
                            <li><a href="#" class="hover:text-slate-900 dark:hover:text-white">Privacy</a></li>
                            <li><a href="#" class="hover:text-slate-900 dark:hover:text-white">Terms</a></li>
                            <li><a href="#" class="hover:text-slate-900 dark:hover:text-white">Cookie Policy</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 dark:text-white mb-4">Follow</h4>
                        <ul class="space-y-2 text-sm text-slate-600 dark:text-slate-400">
                            <li><a href="#" class="hover:text-slate-900 dark:hover:text-white">Twitter</a></li>
                            <li><a href="#" class="hover:text-slate-900 dark:hover:text-white">Facebook</a></li>
                            <li><a href="#" class="hover:text-slate-900 dark:hover:text-white">Instagram</a></li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-slate-200 dark:border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                    <p class="text-slate-600 dark:text-slate-400 text-sm">
                        © 2025 GigLocal. All rights reserved.
                    </p>
                    <div class="flex gap-6 mt-4 md:mt-0">
                        <a href="#" class="text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white text-sm">
                            Privacy Policy
                        </a>
                        <a href="#" class="text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white text-sm">
                            Terms of Service
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>
