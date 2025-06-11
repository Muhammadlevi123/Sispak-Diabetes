<template>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-indigo-50/50 dark:from-gray-900 dark:via-slate-900 dark:to-gray-900">
        <!-- Navbar Component -->
        <Navbar :user="currentUser" :notifications="notifications" :app-name="appName"
            @toggle-sidebar="handleSidebarToggle" @search="handleSearch" @logout="handleLogout" />

        <div class="flex">
            <!-- Sidebar Component -->
            <Sidebar :is-open="isSidebarOpen" :current-route="currentRoute" :menu-items="menuItems"
                @close="closeSidebar" @navigate="handleNavigation" />

            <!-- Main Content Area -->
            <main class="flex-1 transition-all duration-300 ease-in-out pt-20" :class="{
                'pt-20': isSidebarOpen,
                'ml-0': !isSidebarOpen
            }">
                <!-- Content wrapper with proper spacing -->
                <div class="pt-16 lg:p-6">
                    <!-- Page Header with gradient -->
                    <div class="mb-8">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div class="relative">
                                <h1 class="text-3xl lg:text-4xl font-bold bg-gradient-to-r from-gray-900 via-blue-800 to-indigo-700 dark:from-white dark:via-blue-200 dark:to-indigo-300 bg-clip-text text-transparent">
                                    Dashboard
                                </h1>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 font-medium">
                                    Welcome back, <span class="text-blue-600 dark:text-blue-400">{{ currentUser?.name }}</span>! Here's today's system overview.
                                </p>
                                <!-- Decorative line -->
                                <div class="mt-3 h-1 w-16 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Cards with enhanced design -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 lg:gap-6 mb-8">
                        <!-- Total Users Card -->
                        <div class="group bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm shadow-xl hover:shadow-2xl transition-all duration-300 rounded-xl border border-gray-100 dark:border-gray-700 hover:border-blue-200 dark:hover:border-blue-600 hover:-translate-y-1">
                            <div class="p-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Total Users</p>
                                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-400 group-hover:scale-105 transition-transform">{{
                                            stats.total_users }}</p>
                                    </div>
                                    <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900 dark:to-blue-800 rounded-xl group-hover:scale-110 transition-transform shadow-xl">
                                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Diseases Card -->
                        <div class="group bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm shadow-xl hover:shadow-2xl transition-all duration-300 rounded-xl border border-gray-100 dark:border-gray-700 hover:border-green-200 dark:hover:border-green-600 hover:-translate-y-1">
                            <div class="p-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Total Diseases</p>
                                        <p class="text-2xl font-bold text-green-600 dark:text-green-400 group-hover:scale-105 transition-transform">{{
                                            stats.total_penyakit }}</p>
                                    </div>
                                    <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-green-100 to-green-200 dark:from-green-900 dark:to-green-800 rounded-xl group-hover:scale-110 transition-transform shadow-xl">
                                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Symptoms Card -->
                        <div class="group bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm shadow-xl hover:shadow-2xl transition-all duration-300 rounded-xl border border-gray-100 dark:border-gray-700 hover:border-cyan-200 dark:hover:border-cyan-600 hover:-translate-y-1">
                            <div class="p-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Total Symptoms</p>
                                        <p class="text-2xl font-bold text-cyan-600 dark:text-cyan-400 group-hover:scale-105 transition-transform">{{
                                            stats.total_gejala }}</p>
                                    </div>
                                    <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-cyan-100 to-cyan-200 dark:from-cyan-900 dark:to-cyan-800 rounded-xl group-hover:scale-110 transition-transform shadow-xl">
                                        <svg class="w-6 h-6 text-cyan-600 dark:text-cyan-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Rules Card -->
                        <div class="group bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm shadow-xl hover:shadow-2xl transition-all duration-300 rounded-xl border border-gray-100 dark:border-gray-700 hover:border-yellow-200 dark:hover:border-yellow-600 hover:-translate-y-1">
                            <div class="p-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Total Rules</p>
                                        <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400 group-hover:scale-105 transition-transform">{{
                                            stats.total_rules }}</p>
                                    </div>
                                    <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-yellow-100 to-yellow-200 dark:from-yellow-900 dark:to-yellow-800 rounded-xl group-hover:scale-110 transition-transform shadow-xl">
                                        <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Diagnoses Card -->
                        <div class="group bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm shadow-xl hover:shadow-2xl transition-all duration-300 rounded-xl border border-gray-100 dark:border-gray-700 hover:border-purple-200 dark:hover:border-purple-600 hover:-translate-y-1">
                            <div class="p-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Total Diagnoses</p>
                                        <p class="text-2xl font-bold text-purple-600 dark:text-purple-400 group-hover:scale-105 transition-transform">{{
                                            stats.total_diagnosa }}</p>
                                    </div>
                                    <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-purple-100 to-purple-200 dark:from-purple-900 dark:to-purple-800 rounded-xl group-hover:scale-110 transition-transform shadow-xl">
                                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content Grid with enhanced cards -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                        <!-- Most Popular Diseases -->
                        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm shadow-xl hover:shadow-2xl transition-all duration-300 rounded-xl border border-gray-100 dark:border-gray-700">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-6">
                                    <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
                                        <div class="w-2 h-6 bg-gradient-to-b from-green-500 to-green-600 rounded-full mr-3"></div>
                                        Most Popular Diseases
                                    </h2>
                                    <div class="px-3 py-1 bg-green-100 dark:bg-green-900 rounded-full">
                                        <span class="text-xs font-medium text-green-600 dark:text-green-400">{{ penyakit_populer.length }} items</span>
                                    </div>
                                </div>
                                <div class="space-y-3 max-h-80 overflow-y-auto custom-scrollbar">
                                    <div v-for="(penyakit, index) in penyakit_populer.slice(0, 8)" :key="penyakit.id"
                                        class="group flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-green-50/50 dark:from-gray-700 dark:to-green-900/20 rounded-lg hover:from-green-50 hover:to-green-100 dark:hover:from-gray-600 dark:hover:to-green-800/30 transition-all duration-200 border border-transparent hover:border-green-200 dark:hover:border-green-700">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-br from-green-100 to-green-200 dark:from-green-900 dark:to-green-800 rounded-xl flex-shrink-0 group-hover:scale-110 transition-transform">
                                                <span class="text-sm font-bold text-green-600 dark:text-green-400">{{ penyakit.code }}</span>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ penyakit.name }}</p>
                                                <p class="text-xs text-gray-600 dark:text-gray-400 flex items-center mt-1">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    {{ penyakit.diagnosa_count }} diagnoses
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <div class="text-right">
                                                <div class="w-16 bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                                    <div class="bg-gradient-to-r from-green-500 to-green-600 h-2 rounded-full" :style="`width: ${Math.min((penyakit.diagnosa_count / Math.max(...penyakit_populer.map(p => p.diagnosa_count))) * 100, 100)}%`"></div>
                                                </div>
                                            </div>
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-green-100 to-green-200 text-green-800 dark:from-green-900 dark:to-green-800 dark:text-green-300 min-w-max">
                                                {{ penyakit.diagnosa_count }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Most Popular Symptoms -->
                        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm shadow-xl hover:shadow-2xl transition-all duration-300 rounded-xl border border-gray-100 dark:border-gray-700">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-6">
                                    <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
                                        <div class="w-2 h-6 bg-gradient-to-b from-cyan-500 to-cyan-600 rounded-full mr-3"></div>
                                        Most Popular Symptoms
                                    </h2>
                                    <div class="px-3 py-1 bg-cyan-100 dark:bg-cyan-900 rounded-full">
                                        <span class="text-xs font-medium text-cyan-600 dark:text-cyan-400">{{ gejala_populer.length }} items</span>
                                    </div>
                                </div>
                                <div class="space-y-3 max-h-80 overflow-y-auto custom-scrollbar">
                                    <div v-for="(gejala, index) in gejala_populer.slice(0, 8)" :key="gejala.id"
                                        class="group flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-cyan-50/50 dark:from-gray-700 dark:to-cyan-900/20 rounded-lg hover:from-cyan-50 hover:to-cyan-100 dark:hover:from-gray-600 dark:hover:to-cyan-800/30 transition-all duration-200 border border-transparent hover:border-cyan-200 dark:hover:border-cyan-700">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-br from-cyan-100 to-cyan-200 dark:from-cyan-900 dark:to-cyan-800 rounded-xl flex-shrink-0 group-hover:scale-110 transition-transform">
                                                <span class="text-sm font-bold text-cyan-600 dark:text-cyan-400">{{ gejala.code }}</span>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ gejala.name }}</p>
                                                <p class="text-xs text-gray-600 dark:text-gray-400 flex items-center mt-1">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    {{ gejala.diagnosa_count }} diagnoses
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <div class="text-right">
                                                <div class="w-16 bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                                    <div class="bg-gradient-to-r from-cyan-500 to-cyan-600 h-2 rounded-full" :style="`width: ${Math.min((gejala.diagnosa_count / Math.max(...gejala_populer.map(g => g.diagnosa_count))) * 100, 100)}%`"></div>
                                                </div>
                                            </div>
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-cyan-100 to-cyan-200 text-cyan-800 dark:from-cyan-900 dark:to-cyan-800 dark:text-cyan-300 min-w-max">
                                                {{ gejala.diagnosa_count }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Diagnoses with enhanced table -->
                    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm shadow-xl hover:shadow-2xl transition-all duration-300 rounded-xl border border-gray-100 dark:border-gray-700">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
                                    <div class="w-2 h-6 bg-gradient-to-b from-purple-500 to-purple-600 rounded-full mr-3"></div>
                                    Recent Diagnoses
                                </h2>
                                <a href="/admin/diagnosis"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 bg-blue-50 dark:bg-blue-900/30 hover:bg-blue-100 dark:hover:bg-blue-900/50 rounded-lg transition-all duration-200 border border-blue-200 dark:border-blue-700 hover:border-blue-300 dark:hover:border-blue-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                    View All Diagnoses
                                </a>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600">
                                        <tr>
                                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                                ID
                                            </th>
                                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                                User
                                            </th>
                                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                                Disease
                                            </th>
                                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                                Disease Code
                                            </th>
                                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                                Date
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        <tr v-for="diagnosa in all_diagnosa.slice(0, 10)" :key="diagnosa.id"
                                            class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 dark:hover:from-gray-700 dark:hover:to-blue-900/20 transition-all duration-200">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-bold text-gray-900 dark:text-white">
                                                <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded-md">#{{ diagnosa.id }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center space-x-3">
                                                    <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-br from-blue-100 to-indigo-100 dark:from-blue-900 dark:to-indigo-900 rounded-full ring-2 ring-white dark:ring-gray-800">
                                                        <span class="text-sm font-bold text-blue-600 dark:text-blue-400">{{ diagnosa.user.name.charAt(0) }}</span>
                                                    </div>
                                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ diagnosa.user.name }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                                {{ diagnosa.penyakit?.name || 'Not found' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span v-if="diagnosa.penyakit"
                                                    class="inline-flex px-3 py-1 text-xs font-bold rounded-full bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 dark:from-blue-900 dark:to-indigo-900 dark:text-blue-300 border border-blue-200 dark:border-blue-700">
                                                    {{ diagnosa.penyakit.code }}
                                                </span>
                                                <span v-else
                                                    class="inline-flex px-3 py-1 text-xs font-bold rounded-full bg-gradient-to-r from-gray-100 to-gray-200 text-gray-800 dark:from-gray-800 dark:to-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600">
                                                    N/A
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400 font-medium">
                                                {{ formatDate(diagnosa.created_at) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <!-- Mobile Sidebar Overlay -->
        <div v-if="isSidebarOpen && isMobile" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden backdrop-blur-sm"
            @click="closeSidebar"></div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3'
import { ref, onMounted, onUnmounted } from 'vue'
import Navbar from '@/Layouts/Navbar.vue'
import Sidebar from '@/Layouts/Sidebar.vue'

export default {
    name: 'AdminDashboard',
    components: {
        Navbar,
        Sidebar,
        Link,
    },
    props: {
        stats: {
            type: Object,
            required: true
        },
        users: {
            type: Array,
            default: () => []
        },
        penyakit_populer: {
            type: Array,
            default: () => []
        },
        gejala_populer: {
            type: Array,
            default: () => []
        },
        all_diagnosa: {
            type: Array,
            default: () => []
        },
        currentUser: {
            type: Object,required: true
        },
        notifications: {
            type: Array,
            default: () => []
        },
        appName: {
            type: String,
            default: 'Admin Panel'
        },
        menuItems: {
            type: Array,
            default: () => []
        },
        currentRoute: {
            type: String,
            default: 'dashboard'
        }
    },
    setup(props) {
        const isSidebarOpen = ref(false)
        const isMobile = ref(false)

        const checkMobile = () => {
            isMobile.value = window.innerWidth < 1024
            if (!isMobile.value) {
                isSidebarOpen.value = false
            }
        }

        const handleSidebarToggle = () => {
            isSidebarOpen.value = !isSidebarOpen.value
        }

        const closeSidebar = () => {
            isSidebarOpen.value = false
        }

        const handleNavigation = (route) => {
            // Handle navigation logic
            console.log('Navigate to:', route)
        }

        const handleSearch = (query) => {
            // Handle search logic
            console.log('Search:', query)
        }

        const handleLogout = () => {
            // Handle logout logic
            console.log('Logout')
        }

        const formatDate = (dateString) => {
            const options = {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            }
            return new Date(dateString).toLocaleDateString('en-US', options)
        }

        onMounted(() => {
            checkMobile()
            window.addEventListener('resize', checkMobile)
        })

        onUnmounted(() => {
            window.removeEventListener('resize', checkMobile)
        })

        return {
            isSidebarOpen,
            isMobile,
            handleSidebarToggle,
            closeSidebar,
            handleNavigation,
            handleSearch,
            handleLogout,
            formatDate
        }
    }
}
</script>

<style scoped>
/* Custom scrollbar for webkit browsers */
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    @apply bg-gray-100 dark:bg-gray-700 rounded-full;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    @apply bg-gray-300 dark:bg-gray-600 rounded-full hover:bg-gray-400 dark:hover:bg-gray-500;
}

/* Smooth transitions for all interactive elements */
* {
    transition-property: transform, box-shadow, background-color, border-color;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 200ms;
}

/* Enhanced hover effects for cards */
.group:hover {
    transform: translateY(-2px);
}

/* Glassmorphism effect enhancement */
.backdrop-blur-sm {
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
}

/* Gradient text animation */
.bg-clip-text {
    background-clip: text;
    -webkit-background-clip: text;
}

/* Mobile responsive adjustments */
@media (max-width: 768px) {
    .grid-cols-1.md\:grid-cols-2.lg\:grid-cols-5 {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1rem;
    }

    .text-3xl.lg\:text-4xl {
        font-size: 1.875rem;
        line-height: 2.25rem;
    }

    .p-6 {
        padding: 1rem;
    }
}

/* Loading animation for stats cards */
@keyframes pulse-glow {
    0%, 100% {
        opacity: 1;
        transform: scale(1);
    }
    50% {
        opacity: 0.8;
        transform: scale(1.02);
    }
}

.group:hover .group-hover\:scale-105 {
    animation: pulse-glow 0.3s ease-in-out;
}

/* Enhanced table styling */
table thead th {
    position: sticky;
    top: 0;
    z-index: 10;
}

/* Progress bar animation */
.h-2.rounded-full {
    transition: width 0.8s ease-in-out;
}

/* Enhanced button hover effects */
.hover\:shadow-xl:hover {
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* Dark mode enhancements */
@media (prefers-color-scheme: dark) {
    .backdrop-blur-sm {
        background-color: rgba(31, 41, 55, 0.8);
    }
}

/* Accessibility improvements */
@media (prefers-reduced-motion: reduce) {
    * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
}

/* Focus states for better accessibility */
.focus\:ring-2:focus {
    outline: 2px solid transparent;
    outline-offset: 2px;
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
}

/* Enhanced gradient backgrounds */
.bg-gradient-to-br {
    background-image: linear-gradient(to bottom right, var(--tw-gradient-stops));
}

.bg-gradient-to-r {
    background-image: linear-gradient(to right, var(--tw-gradient-stops));
}

/* Improved spacing for mobile */
@media (max-width: 640px) {
    .space-y-3 > * + * {
        margin-top: 0.5rem;
    }

    .gap-6 {
        gap: 1rem;
    }

    .mb-8 {
        margin-bottom: 1.5rem;
    }
}

/* Loading skeleton animation */
@keyframes shimmer {
    0% {
        background-position: -200px 0;
    }
    100% {
        background-position: calc(200px + 100%) 0;
    }
}

.loading-skeleton {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200px 100%;
    animation: shimmer 1.5s infinite;
}

/* Enhanced tooltip styles */
.tooltip {
    position: relative;
}

.tooltip::before {
    content: attr(data-tooltip);
    position: absolute;
    bottom: 125%;
    left: 50%;
    transform: translateX(-50%);
    background-color: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 0.5rem;
    border-radius: 0.375rem;
    font-size: 0.75rem;
    white-space: nowrap;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s, visibility 0.3s;
    z-index: 1000;
}

.tooltip:hover::before {
    opacity: 1;
    visibility: visible;
}

/* Enhanced card borders with subtle glow */
.border-gray-100:hover {
    border-color: rgba(59, 130, 246, 0.3);
    box-shadow: 0 0 0 1px rgba(59, 130, 246, 0.1);
}

.dark .border-gray-700:hover {
    border-color: rgba(59, 130, 246, 0.5);
    box-shadow: 0 0 0 1px rgba(59, 130, 246, 0.2);
}

/* Improved text readability */
.text-gray-600 {
    color: rgb(75, 85, 99);
}

.dark .text-gray-400 {
    color: rgb(156, 163, 175);
}

/* Enhanced button states */
.btn-primary {
    @apply inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2;
}

.btn-secondary {
    @apply inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2;
}

/* Enhanced responsive grid */
@media (min-width: 1024px) {
    .lg\:grid-cols-5 {
        grid-template-columns: repeat(5, minmax(0, 1fr));
    }
}

@media (min-width: 768px) and (max-width: 1023px) {
    .md\:grid-cols-2 {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}
</style>
