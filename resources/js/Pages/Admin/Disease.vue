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
                                        <span class="ml-1 text-gray-400 md:ml-2" aria-current="page">Diseases</span>
                                    </div>
                                </li>
                            </ol>
                        </nav>

                        <!-- Page Title -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">
                                    Disease Management
                                </h1>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    Manage all diseases in your system ({{ localDiseases.length }} total diseases)
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
                                        placeholder="Search for diseases">
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
                                        Add Disease
                                    </button>

                                    <button @click="exportDiseases" type="button"
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
                                                    <a href="#" @click="sortDiseases('asc')"
                                                        class="flex items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600"
                                                        :class="{ 'bg-blue-50 text-blue-600': sortOrder === 'asc' }">
                                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 8a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 12a1 1 0 011-1h4a1 1 0 110 2H4a1 1 0 01-1-1z"></path>
                                                        </svg>
                                                        A-Z
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" @click="sortDiseases('desc')"
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

                    <!-- Diseases Table -->
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
                                                Code
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Disease Name
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Description
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        <tr v-for="disease in paginatedDiseases" :key="disease.id"
                                            class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="p-4">
                                                <div class="flex items-center">
                                                    <input :id="`checkbox-${disease.id}`" type="checkbox" :value="disease.id"
                                                        v-model="selectedDiseases"
                                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                    <label :for="`checkbox-${disease.id}`" class="sr-only">checkbox</label>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center ">
                                                    <div>
                                                        <div class="text-sm font-medium text-red-600 dark:text-red-400">
                                                            {{ disease.code }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ disease.name }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ disease.description ? (disease.description.length > 100 ? disease.description.substring(0, 100) + '...' : disease.description) : '-' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex items-center space-x-2">
                                                    <button @click="openViewModal(disease)"
                                                        class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 font-medium">
                                                        View
                                                    </button>
                                                    <button @click="openEditModal(disease)"
                                                        class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                                                        Edit
                                                    </button>
                                                    <button @click="openDeleteModal(disease)"
                                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-medium">
                                                        Delete
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr v-if="paginatedDiseases.length === 0">
                                            <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                                <div class="flex flex-col items-center">
                                                    <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                    <p class="text-lg font-medium">No diseases found</p>
                                                    <p class="text-sm">{{ searchQuery ? 'Try adjusting your search terms' : 'Get started by adding your first disease' }}</p>
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

        <!-- Add/Edit Disease Modal -->
        <div v-if="showEditModal" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 text-center">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="closeEditModal"></div>

                <div
                    class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                            {{ isEditMode ? 'Edit Disease' : 'Add New Disease' }}
                        </h3>

                        <form @submit.prevent="submitEditDisease">
                            <div class="grid grid-cols-1 gap-4">
                                <!-- Code Field -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Disease Code *</label>
                                    <input type="text" v-model="editForm.code" required maxlength="10"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        placeholder="Enter disease code (max 10 characters)">
                                </div>

                                <!-- Name Field -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Disease Name *</label>
                                    <input type="text" v-model="editForm.name" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        placeholder="Enter disease name">
                                </div>

                                <!-- Description Field -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                    <textarea v-model="editForm.description" rows="4"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        placeholder="Enter disease description"></textarea>
                                </div>

                                <!-- Solution Field -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Solution</label>
                                    <textarea v-model="editForm.solution" rows="4"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        placeholder="Enter disease solution or treatment"></textarea>
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
                                    <span v-else>{{ isEditMode ? 'Update Disease' : 'Add Disease' }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- View Disease Modal -->
        <div v-if="showViewModal" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 text-center">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="closeViewModal"></div>

                <div
                    class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Disease Details</h3>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Disease Code</label>
                                <div class="text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-3 rounded-md">
                                    {{ viewDisease?.code || '-' }}
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Disease Name</label>
                                <div class="text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-3 rounded-md">
                                    {{ viewDisease?.name || '-' }}
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                                <div class="text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-3 rounded-md min-h-[100px]">
                                    {{ viewDisease?.description || 'No description available' }}
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Solution</label>
                                <div class="text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-3 rounded-md min-h-[100px]">
                                    {{ viewDisease?.solution || 'No solution available' }}
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Created At</label>
                                    <div class="text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-3 rounded-md">
                                        {{ viewDisease?.created_at ? new Date(viewDisease.created_at).toLocaleDateString() : '-' }}
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Updated At</label>
                                    <div class="text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-3 rounded-md">
                                        {{ viewDisease?.updated_at ? new Date(viewDisease.updated_at).toLocaleDateString() : '-' }}
                                    </div>
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
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Delete Disease</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Are you sure you want to delete "{{ diseaseToDelete?.name }}"? This action cannot be undone.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" @click="confirmDelete" :disabled="isLoading"
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
                        <button type="button" @click="closeDeleteModal"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Modal -->
        <div v-if="showSuccessModal" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 text-center">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="closeSuccessModal"></div>
                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10 success-icon">
                                <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                        <button type="button" @click="closeSuccessModal"
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
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="closeErrorModal"></div>
                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full error-modal">
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Error</h3>
                                <div class="mt-2">
                                    <ul class="text-sm text-red-600 dark:text-red-400">
                                        <li v-for="error in errorMessages" :key="error">{{ error }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" @click="closeErrorModal"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            OK
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div v-if="isSidebarOpen && isMobile" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden"
        @click="closeSidebar"></div>
</template>

<script setup>
import { router } from '@inertiajs/vue3'
import { ref, reactive, computed, onMounted, onUnmounted } from 'vue'
import Navbar from '@/Layouts/Navbar.vue'
import Sidebar from '@/Layouts/Sidebar.vue'

const props = defineProps({
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

// Create local reference to diseases prop
const localDiseases = ref(props.diseases || [])

// Props & Reactive Data
const appName = ref('Admin Panel')
const showSortDropdown = ref(false)
const sortOrder = ref('')

const notifications = ref([
    { id: 1, message: 'New disease added', time: '5 minutes ago', read: false },
    { id: 2, message: 'System backup completed', time: '1 hour ago', read: true }
])

// Layout State
const isSidebarOpen = ref(false)
const isMobile = ref(false)
const currentRoute = ref('diseases')

// Menu Items
const menuItems = ref([
    { name: 'Dashboard', icon: 'home', route: 'dashboard', active: false },
    { name: 'Diseases', icon: 'medical', route: 'diseases', active: true },
    { name: 'Users', icon: 'users', route: 'users', active: false },
    { name: 'Settings', icon: 'settings', route: 'settings', active: false }
])

// Disease Management State
const searchQuery = ref('')
const selectedDiseases = ref([])
const selectAll = ref(false)
const currentPage = ref(1)
const itemsPerPage = ref(10)

// Modal States
const showEditModal = ref(false)
const showViewModal = ref(false)
const showDeleteModal = ref(false)
const diseaseToDelete = ref(null)
const viewDisease = ref(null)
const isLoading = ref(false)
const isEditMode = ref(false)

// Success and Error Modal States
const showSuccessModal = ref(false)
const showErrorModal = ref(false)
const successMessage = ref('')
const errorMessages = ref([])

// Edit Form
const editForm = reactive({
    id: null,
    code: '',
    name: '',
    description: '',
    solution: ''
})

const paginatedDiseases = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value
    const end = start + itemsPerPage.value
    return filteredDiseases.value.slice(start, end)
})

const totalPages = computed(() => {
    return Math.ceil(filteredDiseases.value.length / itemsPerPage.value)
})

const paginationInfo = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value + 1
    const end = Math.min(start + itemsPerPage.value - 1, filteredDiseases.value.length)
    return {
        from: start,
        to: end,
        total: filteredDiseases.value.length
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
const sortedAndFilteredDiseases = computed(() => {
    let filtered = localDiseases.value

    // Apply search filter
    if (searchQuery.value) {
        const query = searchQuery.value.toLowerCase()
        filtered = filtered.filter(disease =>
            disease.name.toLowerCase().includes(query) ||
            disease.code.toLowerCase().includes(query) ||
            (disease.description && disease.description.toLowerCase().includes(query))
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

const filteredDiseases = computed(() => {
    return sortedAndFilteredDiseases.value
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
        selectedDiseases.value = paginatedDiseases.value.map(disease => disease.id)
    } else {
        selectedDiseases.value = []
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
    resetEditForm()
    showEditModal.value = true
}

const openEditModal = (disease) => {
    isEditMode.value = true
    editForm.id = disease.id
    editForm.code = disease.code
    editForm.name = disease.name
    editForm.description = disease.description || ''
    editForm.solution = disease.solution || ''
    showEditModal.value = true
}

const openViewModal = (disease) => {
    viewDisease.value = disease
    showViewModal.value = true
}

const openDeleteModal = (disease) => {
    diseaseToDelete.value = disease
    showDeleteModal.value = true
}

const closeEditModal = () => {
    showEditModal.value = false
    resetEditForm()
}

const closeViewModal = () => {
    showViewModal.value = false
    viewDisease.value = null
}

const closeDeleteModal = () => {
    showDeleteModal.value = false
    diseaseToDelete.value = null
}

// Form validation
const validateForm = () => {
    const errors = []

    if (!editForm.code.trim()) {
        errors.push('Disease code is required')
    } else if (editForm.code.length > 10) {
        errors.push('Disease code must not exceed 10 characters')
    }

    if (!editForm.name.trim()) {
        errors.push('Disease name is required')
    }

    // Check for duplicate code (excluding current disease)
    const existingDiseaseWithCode = localDiseases.value.find(disease =>
        disease.code === editForm.code && disease.id !== editForm.id
    )
    if (existingDiseaseWithCode) {
        errors.push('Disease code already exists')
    }

    return errors
}

const resetEditForm = () => {
    editForm.id = null
    editForm.code = ''
    editForm.name = ''
    editForm.description = ''
    editForm.solution = ''
}

// CRUD Operations - Fixed Disease Submit Version
const submitEditDisease = () => {
    const validationErrors = validateForm()

    if (validationErrors.length > 0) {
        showError(validationErrors)
        return
    }

    isLoading.value = true

    const formData = {
        code: editForm.code,
        name: editForm.name,
        description: editForm.description,
        solution: editForm.solution
    }

    if (isEditMode.value) {
        // Update existing disease
        const originalDiseaseIndex = localDiseases.value.findIndex(disease => disease.id === editForm.id)
        const originalDisease = originalDiseaseIndex !== -1 ? { ...localDiseases.value[originalDiseaseIndex] } : null

        // Optimistically update UI
        if (originalDiseaseIndex !== -1) {
            localDiseases.value[originalDiseaseIndex] = {
                ...localDiseases.value[originalDiseaseIndex],
                code: editForm.code,
                name: editForm.name,
                description: editForm.description,
                solution: editForm.solution,
                updated_at: new Date().toISOString()
            }
        }

        router.put(route('admin.diseases.update', editForm.id), formData, {
            onSuccess: (response) => {
                isLoading.value = false
                closeEditModal()
                showSuccess('Disease updated successfully!')
                autoCloseSuccessModal()

                // Method 1: Refresh menggunakan Inertia visit
                setTimeout(() => {
                    router.visit(route('admin.diseases.index'), {
                        preserveScroll: true,
                        preserveState: false
                    })
                }, 1500)
            },
            onError: (errors) => {
                isLoading.value = false

                // Rollback optimistic update
                if (originalDisease && originalDiseaseIndex !== -1) {
                    localDiseases.value[originalDiseaseIndex] = originalDisease
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
        // Create new disease
        router.post(route('admin.diseases.store'), formData, {
            onSuccess: (response) => {
                isLoading.value = false
                closeEditModal()
                showSuccess('Disease added successfully!')
                autoCloseSuccessModal()

                // SOLUSI 1: Menggunakan data dari response backend
                if (response.props && response.props.diseases) {
                    localDiseases.value = response.props.diseases
                } else if (response.data && response.data.disease) {
                    // Jika backend mengembalikan data disease baru
                    localDiseases.value.unshift(response.data.disease)
                } else {
                    // SOLUSI 2: Refresh halaman untuk mendapatkan data terbaru
                    setTimeout(() => {
                        router.visit(route('admin.diseases.index'), {
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

// Confirm Delete
const confirmDelete = () => {
    if (diseaseToDelete.value) {
        isLoading.value = true

        const diseaseIndex = localDiseases.value.findIndex(disease => disease.id === diseaseToDelete.value.id)
        const diseaseToRemove = diseaseToDelete.value

        router.delete(route('admin.diseases.destroy', diseaseToDelete.value.id), {
            onSuccess: (response) => {
                isLoading.value = false

                if (diseaseIndex !== -1) {
                    localDiseases.value.splice(diseaseIndex, 1)
                }

                if (paginatedDiseases.value.length === 0 && currentPage.value > 1) {
                    currentPage.value = currentPage.value - 1
                }

                selectedDiseases.value = selectedDiseases.value.filter(id => id !== diseaseToRemove.id)

                closeDeleteModal()
                showSuccess(`Disease "${diseaseToRemove.name}" has been deleted successfully!`)
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
                showError(errorArray.length > 0 ? errorArray : ['Failed to delete disease. Please try again.'])
            },
            preserveScroll: true
        })
    }
}

const exportDiseases = () => {
    window.open(route('admin.diseases.export'), '_blank')
}

const toggleSortDropdown = () => {
    showSortDropdown.value = !showSortDropdown.value
}

const sortDiseases = (order) => {
    sortOrder.value = order
    showSortDropdown.value = false
    currentPage.value = 1
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

.modal-enter-active, .modal-leave-active {
    transition: opacity 0.3s ease;
}

.modal-enter-from, .modal-leave-to {
    opacity: 0;
}

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
