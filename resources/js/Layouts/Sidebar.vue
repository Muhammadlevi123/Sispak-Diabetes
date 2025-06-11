<template>
    <div>
        <!-- Mobile menu backdrop -->
        <div v-if="isDrawerOpen" class="fixed inset-0 z-30 bg-gray-900 bg-opacity-50 lg:hidden"
            @click="isDrawerOpen = false"></div>

        <!-- Mobile navbar -->
        <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 lg:hidden">
            <div class="px-3 py-3 lg:px-5 lg:pl-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center justify-start">
                        <button @click="isDrawerOpen = !isDrawerOpen"
                            class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <Link href="route('admin.dashboard')" class="flex ml-2 md:mr-24">
                        <span class="self-center text-xl font-semibold text-gray-900">Dashboard Admin</span>
                        </Link>
                    </div>
                    <div class="flex items-center">
                        <button @click="showMobileSearch = !showMobileSearch"
                            class="p-2 text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Sidebar -->
        <aside :class="[
            'fixed left-0 w-64 transition-transform bg-white border-r border-gray-200',
            'top-16 h-[calc(100vh-4rem)] lg:top-0 lg:h-screen',
            isDrawerOpen ? 'translate-x-0' : '-translate-x-full',
            'lg:translate-x-0'
        ]">
            <!-- Sidebar header -->
            <div class="h-full px-3 py-8 overflow-y-auto bg-white mt-16">

                <!-- Mobile search -->
                <div v-if="showMobileSearch" class="mb-4 lg:hidden">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <input v-model="searchQuery" type="text" placeholder="Search..."
                            class="w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Navigation menu -->
                <ul class="space-y-2 font-medium">
                    <!-- Dashboard -->
                    <li>
                        <Link href="/admin/dashboard" :class="[
                            'flex items-center p-2 rounded-lg group transition-all duration-200',
                            isCurrentRoute('/admin/dashboard')
                                ? 'bg-blue-100 text-blue-700 border-r-4 border-blue-700'
                                : 'text-gray-900 hover:bg-gray-100'
                        ]" @click="closeDrawer">
                        <svg :class="[
                            'w-5 h-5 transition duration-75',
                            isCurrentRoute('/admin/dashboard')
                                ? 'text-blue-700'
                                : 'text-gray-500 group-hover:text-gray-900'
                        ]" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                            <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                        </svg>
                        <span class="ml-3 font-medium">Dashboard</span>
                        </Link>
                    </li>

                    <!-- Users Section -->
                    <li>
                        <button @click="toggleMenu('users')" :class="[
                            'flex items-center w-full p-2 text-base transition duration-200 rounded-lg group',
                            isUserSectionActive
                                ? 'bg-blue-50 text-blue-700'
                                : 'text-gray-900 hover:bg-gray-100'
                        ]">
                            <svg :class="[
                                'flex-shrink-0 w-5 h-5 transition duration-75',
                                isUserSectionActive
                                    ? 'text-blue-700'
                                    : 'text-gray-500 group-hover:text-gray-900'
                            ]" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z">
                                </path>
                            </svg>
                            <span class="flex-1 ml-3 text-left whitespace-nowrap font-medium">Pengguna</span>
                            <svg :class="[
                                'w-3 h-3 transition-transform duration-200',
                                openMenus.users ? 'rotate-180' : '',
                                isUserSectionActive ? 'text-blue-700' : 'text-gray-500'
                            ]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <ul v-show="openMenus.users" class="py-2 space-y-2 transition-all duration-200">
                            <li>
                                <Link href="/admin/users" :class="[
                                    'flex items-center w-full p-2 transition duration-200 rounded-lg pl-11 group',
                                    isCurrentRoute('/admin/users')
                                        ? 'bg-blue-100 text-blue-700 border-r-4 border-blue-700 font-medium'
                                        : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900'
                                ]" @click="closeDrawer">
                                <span class="text-sm">User</span>
                                </Link>
                            </li>
                        </ul>
                    </li>

                    <!-- Knowledge Base Section -->
                    <li>
                        <button @click="toggleMenu('knowledge')" :class="[
                            'flex items-center w-full p-2 text-base transition duration-200 rounded-lg group',
                            isKnowledgeSectionActive
                                ? 'bg-blue-50 text-blue-700'
                                : 'text-gray-900 hover:bg-gray-100'
                        ]">

                            <svg :class="[
                                'flex-shrink-0 w-5 h-5 transition duration-75',
                                isKnowledgeSectionActive
                                    ? 'text-blue-700'
                                    : 'text-gray-500 group-hover:text-gray-900'
                            ]" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="flex-1 ml-3 text-left whitespace-nowrap font-medium">Basis Pengetahuan</span>
                            <svg :class="[
                                'w-3 h-3 transition-transform duration-200',
                                openMenus.knowledge ? 'rotate-180' : '',
                                isKnowledgeSectionActive ? 'text-blue-700' : 'text-gray-500'
                            ]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <ul v-show="openMenus.knowledge" class="py-2 space-y-2 transition-all duration-200">
                            <li>
                                <Link href="/admin/symptoms" :class="[
                                    'flex items-center w-full p-2 transition duration-200 rounded-lg pl-11 group',
                                    isCurrentRoute('/admin/symptoms')
                                        ? 'bg-blue-100 text-blue-700 border-r-4 border-blue-700 font-medium'
                                        : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900'
                                ]" @click="closeDrawer">
                                <span class="text-sm">Data Gejala</span>
                                </Link>
                            </li>
                            <li>
                                <Link href="/admin/diseases" :class="[
                                    'flex items-center w-full p-2 transition duration-200 rounded-lg pl-11 group',
                                    isCurrentRoute('/admin/diseases')
                                        ? 'bg-blue-100 text-blue-700 border-r-4 border-blue-700 font-medium'
                                        : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900'
                                ]" @click="closeDrawer">
                                <span class="text-sm">Data Penyakit</span>
                                </Link>
                            </li>
                            <li>
                                <Link href="/admin/rules" :class="[
                                    'flex items-center w-full p-2 transition duration-200 rounded-lg pl-11 group',
                                    isCurrentRoute('/admin/rules')
                                        ? 'bg-blue-100 text-blue-700 border-r-4 border-blue-700 font-medium'
                                        : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900'
                                ]" @click="closeDrawer">
                                <span class="text-sm">Data Aturan</span>
                                </Link>
                            </li>
                        </ul>
                    </li>

                    <!-- Diagnosis Section -->
                    <li>
                        <button @click="toggleMenu('diagnosis')" :class="[
                            'flex items-center w-full p-2 text-base transition duration-200 rounded-lg group',
                            isDiagnosisSectionActive
                                ? 'bg-blue-50 text-blue-700'
                                : 'text-gray-900 hover:bg-gray-100'
                        ]">
                            <svg :class="[
                                'flex-shrink-0 w-5 h-5 transition duration-75',
                                isDiagnosisSectionActive
                                    ? 'text-blue-700'
                                    : 'text-gray-500 group-hover:text-gray-900'
                            ]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="flex-1 ml-3 text-left whitespace-nowrap font-medium">Diagnosa</span>
                            <svg :class="[
                                'w-3 h-3 transition-transform duration-200',
                                openMenus.diagnosis ? 'rotate-180' : '',
                                isDiagnosisSectionActive ? 'text-blue-700' : 'text-gray-500'
                            ]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <ul v-show="openMenus.diagnosis" class="py-2 space-y-2 transition-all duration-200">
                            <li>
                                <Link href="/admin/diagnosis" :class="[
                                    'flex items-center w-full p-2 transition duration-200 rounded-lg pl-11 group',
                                    isCurrentRoute('/admin/diagnosis')
                                        ? 'bg-blue-100 text-blue-700 border-r-4 border-blue-700 font-medium'
                                        : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900'
                                ]" @click="closeDrawer">
                                <span class="text-sm">Riwayat Diagnosa</span>
                                </Link>
                            </li>
                        </ul>
                    </li>

                </ul>

                <!-- Bottom section -->
                <div class="mt-8 pt-4 border-t border-gray-200">
                    <!-- Settings -->
                    <ul class="space-y-2 font-medium">
                        <li>
                            <Link href="/settings" :class="[
                                'flex items-center p-2 rounded-lg group transition-all duration-200',
                                isCurrentRoute('/settings')
                                    ? 'bg-blue-100 text-blue-700 border-r-4 border-blue-700'
                                    : 'text-gray-900 hover:bg-gray-100'
                            ]" @click="closeDrawer">
                            <svg :class="[
                                'flex-shrink-0 w-5 h-5 transition duration-75',
                                isCurrentRoute('/settings')
                                    ? 'text-blue-700'
                                    : 'text-gray-500 group-hover:text-gray-900'
                            ]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-3 font-medium">Settings</span>
                            </Link>
                        </li>
                    </ul>

                    <!-- Language Selector -->
                    <div class="mt-4">
                        <div class="relative">
                            <button @click="showLanguageDropdown = !showLanguageDropdown"
                                class="flex items-center w-full p-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:outline-none focus:ring-blue-300 transition-all duration-200">
                                <div class="w-5 h-5 mr-2 overflow-hidden rounded-sm">
                                    <img :src="currentLanguage.flag" :alt="currentLanguage.name"
                                        class="w-full h-full object-cover" />
                                </div>
                                <span class="flex-1 text-left">{{ currentLanguage.name }}</span>
                                <svg :class="[
                                    'w-4 h-4 ml-2 transition-transform duration-200',
                                    showLanguageDropdown ? 'rotate-180' : ''
                                ]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <!-- Language dropdown -->
                            <div v-show="showLanguageDropdown"
                                class="absolute bottom-full left-0 z-10 w-full mb-1 bg-white border border-gray-200 rounded-lg shadow-lg">
                                <ul class="py-1 text-sm text-gray-700">
                                    <li v-for="lang in languages" :key="lang.code">
                                        <button @click="setLanguage(lang)" :class="[
                                            'flex items-center w-full px-4 py-2 transition-colors duration-200',
                                            currentLanguage.code === lang.code
                                                ? 'bg-blue-50 text-blue-700'
                                                : 'hover:bg-gray-100'
                                        ]">
                                            <div class="w-4 h-4 mr-2 overflow-hidden rounded-sm">
                                                <img :src="lang.flag" :alt="lang.name"
                                                    class="w-full h-full object-cover" />
                                            </div>
                                            <span>{{ lang.name }}</span>
                                            <svg v-if="currentLanguage.code === lang.code"
                                                class="w-4 h-4 ml-auto text-blue-700" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main content area -->
        <div class="lg:ml-64">
            <!-- Top padding for mobile navbar -->
            <div class="h-16 lg:h-0"></div>

            <!-- Main content -->
            <main class="p-2 bg-gray-50 min-h-screen">
                <slot />
            </main>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'

// Get current page from Inertia
const page = usePage()

// Reactive data
const isDrawerOpen = ref(false)
const showMobileSearch = ref(false)
const showLanguageDropdown = ref(false)
const searchQuery = ref('')

const openMenus = reactive({
    users: false,
    knowledge: false,
    diagnosis: false
})

const languages = ref([
    {
        code: 'en',
        name: 'English (US)',
        flag: 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMTUiIHZpZXdCb3g9IjAgMCAyMCAxNSIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjIwIiBoZWlnaHQ9IjE1IiBmaWxsPSIjYjIyMzM0Ii8+CjxyZWN0IHdpZHRoPSIyMCIgaGVpZ2h0PSIxLjUiIGZpbGw9IndoaXRlIi8+CjxyZWN0IHk9IjMiIHdpZHRoPSIyMCIgaGVpZ2h0PSIxLjUiIGZpbGw9IndoaXRlIi8+CjxyZWN0IHk9IjYiIHdpZHRoPSIyMCIgaGVpZ2h0PSIxLjUiIGZpbGw9IndoaXRlIi8+CjxyZWN0IHk9IjkiIHdpZHRoPSIyMCIgaGVpZ2h0PSIxLjUiIGZpbGw9IndoaXRlIi8+CjxyZWN0IHk9IjEyIiB3aWR0aD0iMjAiIGhlaWdodD0iMS41IiBmaWxsPSJ3aGl0ZSIvPgo8cmVjdCB3aWR0aD0iOCIgaGVpZ2h0PSI3IiBmaWxsPSIjM2MzYjZlIi8+Cjwvc3ZnPgo='
    },
    {
        code: 'id',
        name: 'Bahasa Indonesia',
        flag: 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMTUiIHZpZXdCb3g9IjAgMCAyMCAxNSIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjIwIiBoZWlnaHQ9IjcuNSIgZmlsbD0iI2ZmMDAwMCIvPgo8cmVjdCB5PSI3LjUiIHdpZHRoPSIyMCIgaGVpZ2h0PSI3LjUiIGZpbGw9IndoaXRlIi8+Cjwvc3ZnPgo='
    }
])

const currentLanguage = ref(languages.value[1]) // Default to Indonesian

// Computed properties untuk mengecek section aktif
const isUserSectionActive = computed(() => {
    const currentPath = page.url
    return currentPath.includes('/admin/users') ||
           currentPath.startsWith('/admin/users/')
})

const isKnowledgeSectionActive = computed(() => {
    const currentPath = page.url
    return currentPath.includes('/admin/symptoms') ||
           currentPath.includes('/admin/diseases') ||
           currentPath.includes('/admin/rules') ||
           currentPath.startsWith('/admin/symptoms/') ||
           currentPath.startsWith('/admin/diseases/') ||
           currentPath.startsWith('/admin/rules/')
})

const isDiagnosisSectionActive = computed(() => {
    const currentPath = page.url
    return currentPath.includes('/admin/diagnosis') ||
           currentPath.startsWith('/admin/diagnosis/')
})

// Methods
const toggleMenu = (menuKey) => {
    openMenus[menuKey] = !openMenus[menuKey]
}

const closeDrawer = () => {
    isDrawerOpen.value = false
}

const setLanguage = (language) => {
    currentLanguage.value = language
    showLanguageDropdown.value = false
    // You can emit language change event or make API call here
}

// Fungsi untuk mengecek rute aktif (disederhanakan)
const isCurrentRoute = (routePath) => {
    const currentPath = page.url

    // Exact match atau startsWith untuk nested routes
    return currentPath === routePath || currentPath.startsWith(routePath + '/')
}

// Auto-expand menus based on current route
const autoExpandMenus = () => {
    if (isUserSectionActive.value) {
        openMenus.users = true
    }

    if (isKnowledgeSectionActive.value) {
        openMenus.knowledge = true
    }

    if (isDiagnosisSectionActive.value) {
        openMenus.diagnosis = true
    }
}

// Initialize menu state
autoExpandMenus()
</script>

<style scoped>
/* Enhanced transitions and animations */
.transition-transform {
    transition-property: transform;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 300ms;
}

.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

.duration-200 {
    transition-duration: 200ms;
}

.duration-75 {
    transition-duration: 75ms;
}

/* Ensure proper layering */
@media (max-width: 1024px) {

    /* Mobile navbar should be above sidebar */
    nav {
        z-index: 50;
    }

    /* Sidebar should be below navbar but above backdrop */
    aside {
        z-index: 40;
    }

    /* Backdrop should be below sidebar */
    .bg-gray-900.bg-opacity-50 {
        z-index: 30;
    }
}

/* Enhanced hover effects */
a:hover,
button:hover {
    transform: translateX(2px);
}

/* Active state border effect */
.border-r-4 {
    position: relative;
}

.border-r-4::before {
    content: '';
    position: absolute;
    right: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background-color: currentColor;
    border-radius: 2px 0 0 2px;
}

/* Custom scrollbar for sidebar */
aside::-webkit-scrollbar {
    width: 6px;
}

aside::-webkit-scrollbar-track {
    background: #f1f1f1;
}

aside::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

aside::-webkit-scrollbar-thumb:hover {
    background: #a1a1a1;
}

/* Smooth menu collapse/expand animation */
ul[v-show] {
    transition: max-height 0.3s ease-out, opacity 0.2s ease-out;
}

/* Language dropdown animation */
.language-dropdown-enter-active,
.language-dropdown-leave-active {
    transition: all 0.3s ease;
}

.language-dropdown-enter-from,
.language-dropdown-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}

/* Focus styles for accessibility */
button:focus,
a:focus {
    outline: 2px solid #3b82f6;
    outline-offset: 2px;
}

/* Mobile optimizations */
@media (max-width: 640px) {
    .sidebar-content {
        padding: 1rem;
    }

    .menu-item {
        padding: 0.75rem;
    }
}

/* Dark mode support (optional) */
@media (prefers-color-scheme: dark) {
    .bg-white {
        background-color: #1f2937;
    }

    .text-gray-900 {
        color: #f9fafb;
    }

    .border-gray-200 {
        border-color: #374151;
    }
}

/* Loading state animation */
.loading-spinner {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from {
        transform: rotate(0deg);
    }

    to {
        transform: rotate(360deg);
    }
}

/* Enhanced mobile menu backdrop blur effect */
.backdrop-blur {
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
}

/* Improved focus-within styles for menu items */
.menu-group:focus-within {
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
    border-radius: 0.5rem;
}

/* Subtle shadow for active menu items */
.active-menu-item {
    box-shadow: 0 2px 4px rgba(59, 130, 246, 0.1);
}
</style>
