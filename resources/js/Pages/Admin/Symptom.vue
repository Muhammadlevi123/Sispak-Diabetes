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
                <div class="pt-16 lg:p-6 ">
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
                                        <span class="ml-1 text-gray-400 md:ml-2" aria-current="page">Symptoms</span>
                                    </div>
                                </li>
                            </ol>
                        </nav>

                        <!-- Page Title -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">
                                    Symptom Management
                                </h1>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    Manage all symptoms in your system ({{ localSymptoms.length }} total symptoms)
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
                                        placeholder="Search for symptoms">
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex items-center space-x-2">
                                    <button @click="openAddModal" type="button"
                                        class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        Add Symptom
                                    </button>

                                    <button @click="exportSymptoms" type="button"
                                        class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex items-center dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Export
                                    </button>

                                    <!-- Filter Dropdown -->
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
                                                    <a href="#" @click="sortSymptoms('asc')"
                                                        class="flex items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600"
                                                        :class="{ 'bg-blue-50 text-blue-600': sortOrder === 'asc' }">
                                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 8a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 12a1 1 0 011-1h4a1 1 0 110 2H4a1 1 0 01-1-1z"></path>
                                                        </svg>
                                                        A-Z
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" @click="sortSymptoms('desc')"
                                                        class="flex items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600"
                                                        :class="{ 'bg-blue-50 text-blue-600': sortOrder === 'desc' }">
                                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M3 4a1 1 0 011-1h4a1 1 0 110 2H4a1 1 0 01-1-1zM3 8a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 12a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"></path>
                                                        </svg>
                                                        Z-A
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Symptoms Table -->
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
                                                Symptom Code
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Name
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        <tr v-for="symptom in paginatedSymptoms" :key="symptom.id"
                                            class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="p-4">
                                                <div class="flex items-center">
                                                    <input :id="`checkbox-${symptom.id}`" type="checkbox" :value="symptom.id"
                                                        v-model="selectedSymptoms"
                                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                    <label :for="`checkbox-${symptom.id}`" class="sr-only">checkbox</label>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center space-x-3">
                                                    <div>
                                                        <div class="text-sm font-bold text-blue-600 dark:text-blue-400">
                                                            {{ symptom.code }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ symptom.name }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex items-center space-x-2">
                                                    <button @click="openEditModal(symptom)"
                                                        class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                                                        Edit
                                                    </button>
                                                    <button @click="openDeleteModal(symptom)"
                                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-medium">
                                                        Delete
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr v-if="paginatedSymptoms.length === 0">
                                            <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                                <div class="flex flex-col items-center">
                                                    <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                    <p class="text-lg font-medium">No symptoms found</p>
                                                    <p class="text-sm">{{ searchQuery ? 'Try adjusting your search terms' : 'Get started by adding your first symptom' }}</p>
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

        <!-- Add/Edit Symptom Modal -->
        <div v-if="showEditModal" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 text-center">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="closeEditModal"></div>

                <div
                    class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                            {{ isEditMode ? 'Edit Symptom' : 'Add Symptom' }}
                        </h3>

                        <form @submit.prevent="submitSymptom">
                            <div class="grid grid-cols-1 gap-4">
                                <!-- Symptom Code Field -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Symptom Code *</label>
                                    <input type="text" v-model="symptomForm.code" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        placeholder="Enter symptom code (e.g., G001)">
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        Use a unique code identifier for this symptom
                                    </p>
                                </div>

                                <!-- Symptom Name Field -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Symptom Name *</label>
                                    <input type="text" v-model="symptomForm.name" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        placeholder="Enter symptom name">
                                </div>

                            </div>

                            <div class="mt-6 flex justify-end space-x-3">
                                <button type="button" @click="closeEditModal"
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
                                        {{ isEditMode ? 'Updating...' : 'Adding...' }}
                                    </span>
                                    <span v-else>{{ isEditMode ? 'Update Symptom' : 'Add Symptom' }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Symptom Modal -->
        <div v-if="showDeleteModal" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 text-center">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="closeDeleteModal"></div>

                <div
                    class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex items-start">
                            <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.268 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                                    Delete User
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Are you sure you want to delete <strong>{{ symptomToDelete?.code }}</strong>? This action
                                        cannot be undone.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button @click="confirmDelete" type="button" :disabled="isLoading"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-white font-medium hover:bg-red-700 disabled:bg-red-400 disabled:cursor-not-allowed sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            <span v-if="isLoading" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Deleting...
                            </span>
                            <span v-else>Delete</span>
                        </button>

                        <button @click="closeDeleteModal" type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm dark:bg-gray-600 dark:text-gray-300 dark:border-gray-500 dark:hover:bg-gray-500">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div v-if="showSuccessModal" class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 text-center">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="closeSuccessModal"></div>

            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full">
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex items-center">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 success-icon">
                            <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Success!</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ successMessage }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div v-if="showErrorModal" class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 text-center">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="closeErrorModal"></div>

            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full error-modal">
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.268 16.5c-.77.833.192 2.5 1.732 2.5z" />
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
                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                        <button type="button" @click="closeErrorModal"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Close
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
    symptoms: Array,
    currentUser: Object
});

const user = computed(() => ({
    id: props.currentUser?.id || '1',
    name: props.currentUser?.name || 'Admin',
    email: props.currentUser?.email || 'admin@gmail.com',
    role: props.currentUser?.role || 'admin',
    avatar: null,
}))

// Create local reference to symptoms prop
const localSymptoms = ref(props.symptoms || [])

// Props & Reactive Data
const appName = ref('Admin Panel')
const showSortDropdown = ref(false)
const sortOrder = ref('')

const notifications = ref([
    { id: 1, message: 'New symptom added', time: '5 minutes ago', read: false },
    { id: 2, message: 'System backup completed', time: '1 hour ago', read: true }
])

// Layout State
const isSidebarOpen = ref(false)
const isMobile = ref(false)
const currentRoute = ref('symptoms')

// Menu Items
const menuItems = ref([
    { name: 'Dashboard', icon: 'home', route: 'dashboard', active: false },
    { name: 'Symptoms', icon: 'activity', route: 'symptoms', active: true },
    { name: 'Users', icon: 'users', route: 'users', active: false },
    { name: 'Settings', icon: 'settings', route: 'settings', active: false }
])

// Symptom Management State
const searchQuery = ref('')
const selectedSymptoms = ref([])
const selectAll = ref(false)
const currentPage = ref(1)
const itemsPerPage = ref(10)

// Modal States
const showEditModal = ref(false)
const showDeleteModal = ref(false)
const symptomToDelete = ref(null)
const isLoading = ref(false)
const isEditMode = ref(false)

// Success and Error Modal States
const showSuccessModal = ref(false)
const showErrorModal = ref(false)
const successMessage = ref('')
const errorMessages = ref([])

// Symptom Form
const symptomForm = reactive({
    id: null,
    code: '',
    name: '',
})

// Computed Properties
const paginatedSymptoms = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value
    const end = start + itemsPerPage.value
    return filteredSymptoms.value.slice(start, end)
})

const totalPages = computed(() => {
    return Math.ceil(filteredSymptoms.value.length / itemsPerPage.value)
})

const paginationInfo = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value + 1
    const end = Math.min(start + itemsPerPage.value - 1, filteredSymptoms.value.length)
    return {
        from: start,
        to: end,
        total: filteredSymptoms.value.length
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

const sortedAndFilteredSymptoms = computed(() => {
    let filtered = localSymptoms.value

    // Apply search filter
    if (searchQuery.value) {
        const query = searchQuery.value.toLowerCase()
        filtered = filtered.filter(symptom =>
            symptom.name.toLowerCase().includes(query) ||
            symptom.code.toLowerCase().includes(query)
        )
    }

    // Apply sorting
    if (sortOrder.value === 'asc') {
        filtered = [...filtered].sort((a, b) => a.name.toLowerCase().localeCompare(b.name.toLowerCase()))
    } else if (sortOrder.value === 'desc') {
        filtered = [...filtered].sort((a, b) => b.name.toLowerCase().localeCompare(a.name.toLowerCase()))
    }

    return filtered
})

const filteredSymptoms = computed(() => {
    return sortedAndFilteredSymptoms.value
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

const autoCloseSuccessModal = () => {
    setTimeout(() => {
        if (showSuccessModal.value) {
            closeSuccessModal()
        }
    }, 3000)
}

// Layout Methods
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

// Selection Methods
const toggleSelectAll = () => {
    if (selectAll.value) {
        selectedSymptoms.value = paginatedSymptoms.value.map(symptom => symptom.id)
    } else {
        selectedSymptoms.value = []
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
    isEditMode.value = false
    resetSymptomForm()
    showEditModal.value = true
}

const openEditModal = (symptom) => {
    isEditMode.value = true
    symptomForm.id = symptom.id
    symptomForm.code = symptom.code
    symptomForm.name = symptom.name
    showEditModal.value = true
}

const closeEditModal = () => {
    showEditModal.value = false
    resetSymptomForm()
}

const openDeleteModal = (symptom) => {
    symptomToDelete.value = symptom
    showDeleteModal.value = true
}

const closeDeleteModal = () => {
    showDeleteModal.value = false
    symptomToDelete.value = null
}

const resetSymptomForm = () => {
    symptomForm.id = null
    symptomForm.code = ''
    symptomForm.name = ''
}

// Form Validation
const validateSymptomForm = () => {
    const errors = []

    if (!symptomForm.code.trim()) {
        errors.push('Symptom code is required')
    }

    if (!symptomForm.name.trim()) {
        errors.push('Symptom name is required')
    }

    // Check for duplicate code (excluding current symptom)
    const existingSymptomWithCode = localSymptoms.value.find(symptom =>
        symptom.code === symptomForm.code && symptom.id !== symptomForm.id
    )
    if (existingSymptomWithCode) {
        errors.push('Symptom code already exists')
    }

    return errors
}

// CRUD Operations - Fixed Version
const submitSymptom = () => {
    const validationErrors = validateSymptomForm()

    if (validationErrors.length > 0) {
        showError(validationErrors)
        return
    }

    isLoading.value = true

    const formData = {
        code: symptomForm.code,
        name: symptomForm.name
    }

    if (isEditMode.value) {
        // Update existing symptom
        const originalSymptomIndex = localSymptoms.value.findIndex(symptom => symptom.id === symptomForm.id)
        const originalSymptom = originalSymptomIndex !== -1 ? { ...localSymptoms.value[originalSymptomIndex] } : null

        // Optimistically update UI
        if (originalSymptomIndex !== -1) {
            localSymptoms.value[originalSymptomIndex] = {
                ...localSymptoms.value[originalSymptomIndex],
                code: symptomForm.code,
                name: symptomForm.name,
                updated_at: new Date().toISOString()
            }
        }

        router.put(route('admin.symptoms.update', symptomForm.id), formData, {
            onSuccess: (response) => {
                isLoading.value = false
                closeEditModal()
                showSuccess('Symptom updated successfully!')
                autoCloseSuccessModal()

                // Method 1: Refresh menggunakan Inertia visit
                setTimeout(() => {
                    router.visit(route('admin.symptoms.index'), {
                        preserveScroll: true,
                        preserveState: false
                    })
                }, 1500)
            },
            onError: (errors) => {
                isLoading.value = false

                // Rollback optimistic update
                if (originalSymptom && originalSymptomIndex !== -1) {
                    localSymptoms.value[originalSymptomIndex] = originalSymptom
                }

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
    } else {
        // Create new symptom
        router.post(route('admin.symptoms.store'), formData, {
            onSuccess: (response) => {
                isLoading.value = false
                closeEditModal()
                showSuccess('Symptom added successfully!')
                autoCloseSuccessModal()

                // SOLUSI 1: Menggunakan data dari response backend
                if (response.props && response.props.symptoms) {
                    localSymptoms.value = response.props.symptoms
                } else if (response.data && response.data.symptom) {
                    // Jika backend mengembalikan data symptom baru
                    localSymptoms.value.unshift(response.data.symptom)
                } else {
                    // SOLUSI 2: Refresh halaman untuk mendapatkan data terbaru
                    setTimeout(() => {
                        router.visit(route('admin.symptoms.index'), {
                            preserveScroll: true,
                            preserveState: false
                        })
                    }, 1500)
                }
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
}

const confirmDelete = () => {
    if (symptomToDelete.value) {
        isLoading.value = true

        const symptomIndex = localSymptoms.value.findIndex(symptom => symptom.id === symptomToDelete.value.id)
        const symptomToRemove = symptomToDelete.value

        router.delete(route('admin.symptoms.destroy', symptomToDelete.value.id), {
            onSuccess: (response) => {
                isLoading.value = false

                // Remove symptom from local array
                if (symptomIndex !== -1) {
                    localSymptoms.value.splice(symptomIndex, 1)
                }

                // Update pagination if necessary
                if (paginatedSymptoms.value.length === 0 && currentPage.value > 1) {
                    currentPage.value = currentPage.value - 1
                }

                // Clear selected symptoms if the deleted symptom was selected
                selectedSymptoms.value = selectedSymptoms.value.filter(id => id !== symptomToRemove.id)

                closeDeleteModal()
                showSuccess(`Symptom "${symptomToRemove.code}" has been deleted successfully!`)
                autoCloseSuccessModal()
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

                closeDeleteModal()
                showError(errorArray.length > 0 ? errorArray : ['Failed to delete symptom. Please try again.'])
            },
            preserveScroll: true
        })
    }
}

// Utility Methods
const exportSymptoms = () => {
    window.open(route('admin.symptoms.export'), '_blank')
}

const toggleSortDropdown = () => {
    showSortDropdown.value = !showSortDropdown.value
}

const sortSymptoms = (order) => {
    sortOrder.value = order
    showSortDropdown.value = false
    currentPage.value = 1
}

const formatDate = (dateString) => {
    if (!dateString) return '-'
    const date = new Date(dateString)
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
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
/* Custom styles */
.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 300ms;
}

input:focus, select:focus, textarea:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Modal animation styles */
.modal-enter-active, .modal-leave-active {
    transition: opacity 0.3s ease;
}

.modal-enter-from, .modal-leave-to {
    opacity: 0;
}

/* Success modal pulse animation */
@keyframes pulse-green {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}

.success-icon {
    animation: pulse-green 0.6s ease-in-out;
}

/* Error modal shake animation */
@keyframes shake {
    0%, 100% {
        transform: translateX(0);
    }
    25% {
        transform: translateX(-5px);
    }
    75% {
        transform: translateX(5px);
    }
}

.error-modal {
    animation: shake 0.5s ease-in-out;
}
</style>
