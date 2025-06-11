<template>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <!-- Navbar Component -->
        <Navbar :user="user" :notifications="notifications" :app-name="appName" @toggle-sidebar="handleSidebarToggle"
            @search="handleSearch" @logout="handleLogout" />

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
                    <!-- Header Section -->
                    <div class="mb-6">
                        <!-- Breadcrumb -->
                        <nav class="flex mb-5" aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                                <li class="inline-flex items-center">
                                    <a href="/admin/dashboard"
                                        class="inline-flex items-center text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400">
                                        <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                        </svg>
                                        Home
                                    </a>
                                </li>
                                <li>
                                    <div class="flex items-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="ml-1 text-gray-400 md:ml-2" aria-current="page">Diagnosis</span>
                                    </div>
                                </li>
                            </ol>
                        </nav>

                        <!-- Page Title -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">
                                    Diagnosa
                                </h1>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    Manage all diagnosa records in your system ({{ localDiagnoses.length }} total records)
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Search and Actions Bar -->
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg mb-6">
                        <div class="p-4">
                            <div class="flex flex-col md:flex-row items-start md:items-center md:justify-between gap-4">
                                <!-- Search Input -->
                                <div class="relative flex-1 max-w-md">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-500" aria-hidden="true" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <input type="text" v-model="searchQuery" @input="handleSearchInput"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                        placeholder="Search for diagnosa records">
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex items-center space-x-2">
                                    <button @click="openAddModal" type="button"
                                        class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Add Diagnosa
                                    </button>

                                    <button @click="exportDiagnoses" type="button"
                                        class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex items-center dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Export
                                    </button>

                                    <!-- Sort Dropdown -->
                                    <div class="relative">
                                        <button @click="toggleSortDropdown"
                                            class="flex items-center justify-center p-2 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 focus:ring-4 focus:ring-gray-300 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700"
                                            type="button">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                        <div v-show="showSortDropdown"
                                            class="absolute right-0 z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700">
                                            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200">
                                                <li>
                                                    <a href="#" @click="sortDiagnoses('asc')"
                                                        class="flex items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600"
                                                        :class="{ 'bg-blue-50 text-blue-600': sortOrder === 'asc' }">
                                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 8a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 12a1 1 0 011-1h4a1 1 0 110 2H4a1 1 0 01-1-1z"></path>
                                                        </svg>
                                                        Oldest First
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" @click="sortDiagnoses('desc')"
                                                        class="flex items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600"
                                                        :class="{ 'bg-blue-50 text-blue-600': sortOrder === 'desc' }">
                                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M3 4a1 1 0 011-1h4a1 1 0 110 2H4a1 1 0 01-1-1zM3 8a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 12a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"></path>
                                                        </svg>
                                                        Newest First
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Diagnosis Table -->
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                        <div class="p-6">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th scope="col" class="p-4">
                                                <div class="flex items-center">
                                                    <input id="checkbox-all" type="checkbox" v-model="selectAll"
                                                        @change="toggleSelectAll"
                                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                    <label for="checkbox-all" class="sr-only">checkbox</label>
                                                </div>
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Patient
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Disease
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Diagnosed At
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Status
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        <tr v-for="diagnosis in paginatedDiagnoses" :key="diagnosis.id"
                                            class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="p-4">
                                                <div class="flex items-center">
                                                    <input :id="`checkbox-${diagnosis.id}`" type="checkbox" :value="diagnosis.id"
                                                        v-model="selectedDiagnoses"
                                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                    <label :for="`checkbox-${diagnosis.id}`" class="sr-only">checkbox</label>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                                                        <span class="text-sm font-medium text-blue-600 dark:text-blue-300">
                                                            {{ diagnosis.user.name.charAt(0).toUpperCase() }}
                                                        </span>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                            {{ diagnosis.user.name }}
                                                        </div>
                                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                                            {{ diagnosis.user.email }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div v-if="diagnosis.disease">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ diagnosis.disease.name }}
                                                    </div>
                                                    <div class="text-sm text-red-600 dark:text-red-400">
                                                        {{ diagnosis.disease.code }}
                                                    </div>
                                                </div>
                                                <div v-else class="text-sm text-gray-500 dark:text-gray-400">
                                                    No disease detected
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-white">
                                                    {{ formatDate(diagnosis.diagnosed_at) }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span v-if="diagnosis.disease"
                                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                    Diagnosed
                                                </span>
                                                <span v-else
                                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                    Healthy
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex items-center space-x-2">
                                                    <button @click="openViewModal(diagnosis)"
                                                        class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 font-medium">
                                                        View
                                                    </button>
                                                    <button @click="openDeleteModal(diagnosis)"
                                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-medium">
                                                        Delete
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr v-if="paginatedDiagnoses.length === 0">
                                            <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                                <div class="flex flex-col items-center">
                                                    <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                    <p class="text-lg font-medium">No diagnosa records found</p>
                                                    <p class="text-sm">{{ searchQuery ? 'Try adjusting your search terms' : 'Get started by adding your first diagnosa record' }}</p>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div v-if="totalPages > 1" class="flex items-center justify-between mt-6">
                                <div class="text-sm text-gray-700 dark:text-gray-300">
                                    Showing {{ paginationInfo.from }} to {{ paginationInfo.to }} of {{
                                    paginationInfo.total }} results
                                </div>
                                <div class="flex items-center space-x-2">
                                    <button @click="previousPage" :disabled="currentPage === 1"
                                        class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white disabled:opacity-50 disabled:cursor-not-allowed">
                                        Previous
                                    </button>
                                    <template v-for="page in visiblePages" :key="page">
                                        <button v-if="page !== '...'" @click="goToPage(page)" :class="{
                                            'bg-blue-50 border-blue-500 text-blue-600 dark:bg-blue-900 dark:border-blue-600 dark:text-blue-300': page === currentPage,
                                            'bg-white border-gray-300 text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white': page !== currentPage
                                        }" class="px-3 py-2 text-sm font-medium border rounded-lg">
                                            {{ page }}
                                        </button>
                                        <span v-else class="px-3 py-2 text-sm text-gray-500">...</span>
                                    </template>
                                    <button @click="nextPage" :disabled="currentPage === totalPages"
                                        class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white disabled:opacity-50 disabled:cursor-not-allowed">
                                        Next
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <!-- Mobile Sidebar Overlay -->
        <div v-if="isSidebarOpen && isMobile" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden"
            @click="closeSidebar"></div>

        <!-- Add Diagnosis Modal -->
        <div v-if="showAddModal" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 text-center">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="closeAddModal"></div>

                <div
                    class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                            Add New Diagnosa Record
                        </h3>

                        <form @submit.prevent="submitAddDiagnosis">
                            <div class="grid grid-cols-1 gap-4">
                                <!-- User Selection -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Patient *</label>
                                    <select v-model="addForm.user_id" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <option value="">Select a patient</option>
                                        <option v-for="user in users" :key="user.id" :value="user.id">
                                            {{ user.name }}
                                        </option>
                                    </select>
                                </div>

                                <!-- Disease Selection -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Disease (Optional)</label>
                                    <select v-model="addForm.penyakit_id"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <option value="">No disease detected (Healthy)</option>
                                        <option v-for="disease in diseases" :key="disease.id" :value="disease.id">
                                            {{ disease.nama_penyakit }} ({{ disease.kode_penyakit }})
                                        </option>
                                    </select>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        Leave empty if the patient is healthy
                                    </p>
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end space-x-3">
                                <button type="button" @click="closeAddModal"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 dark:bg-gray-600 dark:text-gray-300 dark:hover:bg-gray-500">
                                    Cancel
                                </button>
                                <button type="submit" :disabled="isLoading"
                                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 disabled:bg-blue-400 disabled:cursor-not-allowed">
                                    <span v-if="isLoading" class="flex items-center">
                                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Adding...
                                    </span>
                                    <span v-else>Add Diagnosa</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- View Diagnosis Modal -->
        <div v-if="showViewModal" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 text-center">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="closeViewModal"></div>

                <div
                    class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Diagnosa Details</h3>

                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Patient Name</label>
                                    <div class="text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-3 rounded-md">
                                        {{ viewDiagnosis?.user?.name || '-' }}
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Patient Email</label>
                                    <div class="text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-3 rounded-md">
                                        {{ viewDiagnosis?.user?.email || '-' }}
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Disease Name</label>
                                    <div class="text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-3 rounded-md">
                                        {{ viewDiagnosis?.disease?.name || 'No disease detected' }}
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Disease Code</label>
                                    <div class="text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-3 rounded-md">
                                        {{ viewDiagnosis?.disease?.code || '-' }}
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Diagnosed At</label>
                                    <div class="text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-3 rounded-md">
                                        {{ formatDate(viewDiagnosis?.diagnosed_at) }}
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                                    <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-md">
                                        <span v-if="viewDiagnosis?.disease"
                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                            Diagnosed
                                        </span>
                                        <span v-else
                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            Healthy
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div v-if="viewDiagnosis?.disease?.description">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Disease Description</label>
                                <div class="text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-3 rounded-md">
                                    {{ viewDiagnosis.disease.description }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="button" @click="closeViewModal"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 dark:bg-gray-600 dark:text-gray-300 dark:hover:bg-gray-500">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div v-if="showDeleteModal" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 text-center">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="closeDeleteModal"></div>

                <div
                    class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Delete Diagnosa Record</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Are you sure you want to delete this diagnosa record for
                                        <span class="font-medium">{{ diagnosisToDelete?.user?.name }}</span>?
                                        This action cannot be undone.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button @click="confirmDelete" :disabled="isLoading"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm disabled:bg-red-400 disabled:cursor-not-allowed">
                            <span v-if="isLoading" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Deleting...
                            </span>
                            <span v-else>Delete</span>
                        </button>
                        <button @click="closeDeleteModal" :disabled="isLoading"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 disabled:cursor-not-allowed disabled:opacity-50">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Modal -->
        <div v-if="showSuccessModal" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 text-center">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-50 transition-opacity" @click="closeSuccessModal"></div>

                <div
                    class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full">
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 dark:bg-green-900 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Success</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ successMessage }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button @click="closeSuccessModal"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                            OK
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Error Modal -->
        <div v-if="showErrorModal" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 text-center">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-50 transition-opacity" @click="closeErrorModal"></div>

                <div
                    class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Error</h3>
                                <div class="mt-2">
                                    <ul class="text-sm text-gray-500 dark:text-gray-400 list-disc list-inside">
                                        <li v-for="error in errorMessages" :key="error">{{ error }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button @click="closeErrorModal"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            OK
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3'
import { ref, reactive, computed, onMounted, onUnmounted } from 'vue'
import Navbar from '@/Layouts/Navbar.vue'
import Sidebar from '@/Layouts/Sidebar.vue'

const props = defineProps({
    users: Array,
    diagnoses: Array,
    diseases: Array,
    currentUser: Object
});

const user = computed(() => ({
    id: props.currentUser?.id || '1',
    name: props.currentUser?.name || 'Admin',
    email: props.currentUser?.email || 'admin@gmail.com',
    role: props.currentUser?.role || 'admin',
    avatar: null,
}))

// Create local reference to diagnoses prop
const localDiagnoses = ref(props.diagnoses || [])

// Props & Reactive Data
const appName = ref('Admin Panel')
const showSortDropdown = ref(false)
const sortOrder = ref('')

const notifications = ref([
    { id: 1, message: 'New diagnosa added', time: '5 minutes ago', read: false },
    { id: 2, message: 'System backup completed', time: '1 hour ago', read: true }
])

// Layout State
const isSidebarOpen = ref(false)
const isMobile = ref(false)
const currentRoute = ref('diagnosis')

// Menu Items
const menuItems = ref([
    { name: 'Dashboard', icon: 'home', route: 'dashboard', active: false },
    { name: 'Diseases', icon: 'medical', route: 'diseases', active: false },
    { name: 'Diagnosis', icon: 'clipboard', route: 'diagnosis', active: true },
    { name: 'Users', icon: 'users', route: 'users', active: false },
    { name: 'Settings', icon: 'settings', route: 'settings', active: false }
])

// Diagnosis Management State
const searchQuery = ref('')
const selectedDiagnoses = ref([])
const selectAll = ref(false)
const currentPage = ref(1)
const itemsPerPage = ref(10)

// Modal States
const showAddModal = ref(false)
const showViewModal = ref(false)
const showDeleteModal = ref(false)
const diagnosisToDelete = ref(null)
const viewDiagnosis = ref(null)
const isLoading = ref(false)

// Success and Error Modal States
const showSuccessModal = ref(false)
const showErrorModal = ref(false)
const successMessage = ref('')
const errorMessages = ref([])

// Add Form
const addForm = reactive({
    user_id: '',
    penyakit_id: ''
})

const paginatedDiagnoses = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value
    const end = start + itemsPerPage.value
    return filteredDiagnoses.value.slice(start, end)
})

const totalPages = computed(() => {
    return Math.ceil(filteredDiagnoses.value.length / itemsPerPage.value)
})

const paginationInfo = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value + 1
    const end = Math.min(start + itemsPerPage.value - 1, filteredDiagnoses.value.length)
    return {
        from: start,
        to: end,
        total: filteredDiagnoses.value.length
    }
})

const visiblePages = computed(() => {
    const pages = []
    const total = totalPages.value
    const current = currentPage.value

    if (total <= 7) {
        for (let i = 1; i <= total; i++) {
            pages.push(i)
        }
    } else {
        if (current <= 4) {
            for (let i = 1; i <= 5; i++) {
                pages.push(i)
            }
            pages.push('...')
            pages.push(total)
        } else if (current >= total - 3) {
            pages.push(1)
            pages.push('...')
            for (let i = total - 4; i <= total; i++) {
                pages.push(i)
            }
        } else {
            pages.push(1)
            pages.push('...')
            for (let i = current - 1; i <= current + 1; i++) {
                pages.push(i)
            }
            pages.push('...')
            pages.push(total)
        }
    }

    return pages
})

// Computed properties for sorting and filtering
const sortedAndFilteredDiagnoses = computed(() => {
    let filtered = localDiagnoses.value

    // Apply search filter
    if (searchQuery.value) {
        const query = searchQuery.value.toLowerCase()
        filtered = filtered.filter(diagnosis =>
            diagnosis.user.name.toLowerCase().includes(query) ||
            diagnosis.user.email.toLowerCase().includes(query) ||
            (diagnosis.disease && diagnosis.disease.name.toLowerCase().includes(query)) ||
            (diagnosis.disease && diagnosis.disease.code.toLowerCase().includes(query))
        )
    }

    // Apply sorting
    if (sortOrder.value === 'asc') {
        filtered = [...filtered].sort((a, b) => new Date(a.diagnosed_at) - new Date(b.diagnosed_at))
    } else if (sortOrder.value === 'desc') {
        filtered = [...filtered].sort((a, b) => new Date(b.diagnosed_at) - new Date(a.diagnosed_at))
    }

    return filtered
})

const filteredDiagnoses = computed(() => {
    return sortedAndFilteredDiagnoses.value
})

// Notification Methods
const showSuccess = (message) => {
    successMessage.value = message
    showSuccessModal.value = true
}

const showError = (errors) => {
    if (Array.isArray(errors)) {
        errorMessages.value = errors
    } else if (typeof errors === 'object') {
        errorMessages.value = Object.values(errors).flat()
    } else {
        errorMessages.value = [errors]
    }
    showErrorModal.value = true
}

const closeSuccessModal = () => {
    showSuccessModal.value = false
    successMessage.value = ''
}

const closeErrorModal = () => {
    showErrorModal.value = false
    errorMessages.value = []
}

// Auto close success modal after 3 seconds
const autoCloseSuccessModal = () => {
    setTimeout(() => {
        if (showSuccessModal.value) {
            closeSuccessModal()
        }
    }, 3000)
}

// Methods
const handleSidebarToggle = () => {
    isSidebarOpen.value = !isSidebarOpen.value
}

const closeSidebar = () => {
    isSidebarOpen.value = false
}

const handleSearch = (query) => {
    searchQuery.value = query
}

const handleSearchInput = () => {
    currentPage.value = 1
}

const handleLogout = () => {
    console.log('Logout clicked')
}

const handleNavigation = (route) => {
    currentRoute.value = route
    console.log('Navigate to:', route)
}

const toggleSelectAll = () => {
    if (selectAll.value) {
        selectedDiagnoses.value = paginatedDiagnoses.value.map(diagnosis => diagnosis.id)
    } else {
        selectedDiagnoses.value = []
    }
}

// Pagination Methods
const previousPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--
    }
}

const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++
    }
}

const goToPage = (page) => {
    currentPage.value = page
}

// Modal Methods
const openAddModal = () => {
    resetAddForm()
    showAddModal.value = true
}

const openViewModal = (diagnosis) => {
    viewDiagnosis.value = diagnosis
    showViewModal.value = true
}

const openDeleteModal = (diagnosis) => {
    diagnosisToDelete.value = diagnosis
    showDeleteModal.value = true
}

const closeAddModal = () => {
    showAddModal.value = false
    resetAddForm()
}

const closeViewModal = () => {
    showViewModal.value = false
    viewDiagnosis.value = null
}

const closeDeleteModal = () => {
    showDeleteModal.value = false
    diagnosisToDelete.value = null
}

// Form validation
const validateForm = () => {
    const errors = []

    if (!addForm.user_id) {
        errors.push('User is required')
    }

    return errors
}

const resetAddForm = () => {
    addForm.user_id = ''
    addForm.penyakit_id = ''
}

// CRUD Operations
const submitAddDiagnosis = () => {
    const validationErrors = validateForm()

    if (validationErrors.length > 0) {
        showError(validationErrors)
        return
    }

    isLoading.value = true

    const formData = {
        user_id: addForm.user_id,
        penyakit_id: addForm.penyakit_id || null
    }

    router.post(route('admin.diagnosis.store'), formData, {
        onSuccess: (response) => {
            isLoading.value = false
            closeAddModal()
            showSuccess('Diagnosis added successfully!')
            autoCloseSuccessModal()

            // Refresh page to get latest data
            setTimeout(() => {
                router.visit(route('admin.diagnosis.index'), {
                    preserveScroll: true,
                    preserveState: false
                })
            }, 1500)
        },
        onError: (errors) => {
            isLoading.value = false

            const errorArray = []
            Object.values(errors).forEach(error => {
                if (Array.isArray(error)) {
                    errorArray.push(...error)
                } else {
                    errorArray.push(error)
                }
            })
            showError(errorArray)
        },
        preserveScroll: true
    })
}

// Confirm Delete
const confirmDelete = () => {
    if (diagnosisToDelete.value) {
        isLoading.value = true

        const diagnosisIndex = localDiagnoses.value.findIndex(diagnosis => diagnosis.id === diagnosisToDelete.value.id)
        const diagnosisToRemove = diagnosisToDelete.value

        router.delete(route('admin.diagnosis.destroy', diagnosisToDelete.value.id), {
            onSuccess: (response) => {
                isLoading.value = false

                if (diagnosisIndex !== -1) {
                    localDiagnoses.value.splice(diagnosisIndex, 1)
                }

                if (paginatedDiagnoses.value.length === 0 && currentPage.value > 1) {
                    currentPage.value = currentPage.value - 1
                }

                selectedDiagnoses.value = selectedDiagnoses.value.filter(id => id !== diagnosisToRemove.id)

                closeDeleteModal()
                showSuccess(`Diagnosa has been deleted successfully!`)
                autoCloseSuccessModal()
            },
            onError: (errors) => {
                isLoading.value = false
                console.error('Delete failed:', errors)

                const errorArray = []
                Object.values(errors).forEach(error => {
                    if (Array.isArray(error)) {
                        errorArray.push(...error)
                    } else {
                        errorArray.push(error)
                    }
                })

                closeDeleteModal()
                showError(errorArray.length > 0 ? errorArray : ['Failed to delete diagnosa. Please try again.'])
            },
            preserveScroll: true
        })
    }
}

const exportDiagnoses = () => {
    window.open(route('admin.diagnosis.export'), '_blank')
}

const toggleSortDropdown = () => {
    showSortDropdown.value = !showSortDropdown.value
}

const sortDiagnoses = (order) => {
    sortOrder.value = order
    showSortDropdown.value = false
    currentPage.value = 1
}

// Format date helper
const formatDate = (dateString) => {
    const date = new Date(dateString)
    return date.toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    })
}

// Mobile Detection
const checkMobile = () => {
    isMobile.value = window.innerWidth < 1024
}

// Close dropdowns when clicking outside
const closeDropdowns = (event) => {
    if (!event.target.closest('.relative')) {
        showSortDropdown.value = false
    }
}

// Lifecycle
onMounted(() => {
    checkMobile()
    window.addEventListener('resize', checkMobile)
    document.addEventListener('click', closeDropdowns)
})

onUnmounted(() => {
    window.removeEventListener('resize', checkMobile)
    document.removeEventListener('click', closeDropdowns)
})
</script>

<style scoped>
/* Custom styles if needed */
.transition-all {
  transition-property: all;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 300ms;
}
</style>
