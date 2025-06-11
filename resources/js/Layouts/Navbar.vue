<template>
  <nav class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700 fixed w-full z-20 top-0 start-0 p-2 backdrop-blur-sm">
    <div class="max-w-full flex flex-wrap items-center justify-between mx-auto px-4 py-3">
      <!-- Left Section: Logo -->
      <div class="flex items-center space-x-3">
        <Link :href="route('dashboard')" class="flex items-center space-x-3">
          <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
              <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z" />
              <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z" />
            </svg>
          </div>
          <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">
            {{ appName }}
          </span>
        </Link>
      </div>

      <!-- Center Section: System Status -->
      <div class="hidden lg:flex items-center space-x-6 text-sm">
        <div class="flex items-center space-x-2">
          <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
          <span class="text-gray-600 dark:text-gray-300">System Online</span>
        </div>
        <div class="text-gray-600 dark:text-gray-300">
          <span class="font-medium">{{ activeUsers }}</span> Active Users
        </div>
      </div>

      <!-- Right Section: Actions & Profile -->
      <div class="flex items-center space-x-2 md:space-x-3 gap-2">
        <!-- Mobile Search Button -->
        <button
          @click="toggleMobileSearch"
          type="button"
          class="md:hidden p-2 text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600 transition-all duration-200"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
          <span class="sr-only">Search</span>
        </button>

        <!-- Notifications -->
        <div class="relative" ref="notificationRef">
          <button
            @click="toggleNotifications"
            type="button"
            class="relative p-2 text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600 transition-all duration-200"
          >
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 14 20">
              <path d="M12.133 10.632v-1.8A5.406 5.406 0 0 0 7.979 3.57.946.946 0 0 0 8 3.464V1.1a1 1 0 0 0-2 0v2.364a.946.946 0 0 0 .021.106 5.406 5.406 0 0 0-4.154 5.262v1.8C1.867 13.018 0 13.614 0 14.807 0 15.4 0 16 .538 16h12.924C14 16 14 15.4 14 14.807c0-1.193-1.867-1.789-1.867-4.175ZM3.823 17a3.453 3.453 0 0 0 6.354 0H3.823Z" />
            </svg>
            <span class="sr-only">Notifications</span>
            <div
              v-if="notificationCount > 0"
              class="absolute inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-white bg-red-500 rounded-full -top-1 -end-1 animate-bounce"
            >
              {{ notificationCount > 9 ? '9+' : notificationCount }}
            </div>
          </button>

          <!-- Notifications Dropdown -->
          <div
            v-if="isNotificationsOpen"
            class="absolute right-0 top-12 z-50 my-2 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-lg dark:bg-gray-700 dark:divide-gray-600 w-80 animate-in slide-in-from-top-2"
          >
            <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-600">
              <div class="flex justify-between items-center">
                <div>
                  <span class="block text-sm font-medium text-gray-900 dark:text-white">Notifications</span>
                  <span class="block text-xs text-gray-500 dark:text-gray-400">
                    {{ notificationCount }} new notifications
                  </span>
                </div>
                <button
                  v-if="notificationCount > 0"
                  @click="markAllNotificationsAsRead"
                  class="text-xs text-blue-600 hover:text-blue-800 dark:text-blue-400"
                >
                  Mark all read
                </button>
              </div>
            </div>
            <div class="py-2 max-h-64 overflow-y-auto">
              <div
                v-if="notifications.length > 0"
                v-for="notification in notifications"
                :key="notification.id"
                @click="markNotificationAsRead(notification.id)"
                :class="[
                  'flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-600 border-b border-gray-50 dark:border-gray-600 last:border-b-0 cursor-pointer transition-colors',
                  notification.unread ? 'bg-blue-50 dark:bg-blue-900/20' : ''
                ]"
              >
                <div class="flex-shrink-0">
                  <div :class="[
                    'w-8 h-8 rounded-full flex items-center justify-center',
                    notification.unread
                      ? 'bg-blue-100 dark:bg-blue-900'
                      : 'bg-gray-100 dark:bg-gray-600'
                  ]">
                    <svg :class="[
                      'w-4 h-4',
                      notification.unread
                        ? 'text-blue-600 dark:text-blue-400'
                        : 'text-gray-600 dark:text-gray-400'
                    ]" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" />
                    </svg>
                  </div>
                </div>
                <div class="flex-1 ml-3">
                  <div :class="[
                    'text-sm',
                    notification.unread
                      ? 'text-gray-900 dark:text-white font-medium'
                      : 'text-gray-700 dark:text-gray-300'
                  ]">
                    {{ notification.message }}
                  </div>
                  <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    {{ notification.time }}
                  </div>
                </div>
                <div v-if="notification.unread" class="w-2 h-2 bg-blue-600 rounded-full mt-2"></div>
              </div>
              <div v-else class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                <svg class="w-8 h-8 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM9 7h6m0 10v-3H9v3h6zM9 7V4a1 1 0 011-1h4a1 1 0 011 1v3M9 7H6a1 1 0 00-1 1v8a1 1 0 001 1h3" />
                </svg>
                No new notifications
              </div>
            </div>
            <div class="py-2 border-t border-gray-100 dark:border-gray-600">
              <Link
                :href="route('notifications.index')"
                class="block w-full px-4 py-2 text-sm text-center text-blue-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-blue-400 dark:hover:text-blue-300 transition-colors"
              >
                View all notifications
              </Link>
            </div>
          </div>
        </div>

        <!-- Theme Toggle -->
        <button
          @click="toggleTheme"
          type="button"
          class="p-2 text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600 transition-all duration-200"
        >
          <svg v-if="isDarkMode" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" />
          </svg>
          <svg v-else class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
          </svg>
          <span class="sr-only">Toggle theme</span>
        </button>

        <!-- User Profile Dropdown -->
        <div class="relative" ref="userMenuRef">
          <button
            @click="toggleUserMenu"
            type="button"
            class="flex items-center text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600 transition-all duration-200 hover:ring-2 hover:ring-gray-300"
          >
            <span class="sr-only">Open user menu</span>
            <img
              class="w-8 h-8 rounded-full"
              :src="user.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&background=3B82F6&color=fff`"
              :alt="user.name"
            />
          </button>

          <!-- User Dropdown menu -->
          <div
            v-if="isUserMenuOpen"
            class="absolute right-0 top-12 z-50 my-2 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-lg dark:bg-gray-700 dark:divide-gray-600 min-w-48 animate-in slide-in-from-top-2"
          >
            <div class="px-4 py-3">
              <span class="block text-sm text-gray-900 dark:text-white font-medium">{{ user.name }}</span>
              <span class="block text-sm text-gray-500 truncate dark:text-gray-400">{{ user.email }}</span>
            </div>
            <ul class="py-2">
              <li>
                <Link
                  :href="route('profile.edit')"
                  class="flex w-full items-center px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white transition-colors"
                  @click="closeUserMenu"
                >
                  <svg class="w-4 h-4 me-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                  </svg>
                  Profile
                </Link>
              </li>
              <li>
                <hr class="my-1 border-gray-200 dark:border-gray-600" />
              </li>
              <li>
                <button
                  @click="handleLogout"
                  :disabled="isLoggingOut"
                  class="flex w-full items-center px-4 py-2 text-sm text-left text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-red-400 dark:hover:text-red-300 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  <svg v-if="isLoggingOut" class="w-4 h-4 me-3 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                    <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                  </svg>
                  <svg v-else class="w-4 h-4 me-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                  </svg>
                  {{ isLoggingOut ? 'Logging out...' : 'Sign out' }}
                </button>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Mobile Search (Dropdown below navbar) -->
    <div
      v-if="isMobileSearchOpen"
      class="md:hidden p-4 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 animate-in slide-in-from-top-2"
    >
      <div class="flex items-center space-x-3">
        <div class="relative flex-1">
          <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </div>
          <input
            ref="mobileSearchInput"
            type="search"
            v-model="searchQuery"
            @keyup.enter="handleSearch"
            class="block w-full p-2.5 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-colors"
            placeholder="Search users, reports, settings..."
          />
        </div>
        <button
          @click="handleSearch"
          class="p-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors"
        >
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
          <span class="sr-only">Search</span>
        </button>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, nextTick } from 'vue'
import { Link, router } from '@inertiajs/vue3'

// Props
const props = defineProps({
  appName: {
    type: String,
    default: 'AdminPanel'
  },
  user: {
    type: Object,
    required: true
  },
  notifications: {
    type: Array,
    default: () => []
  },
  activeUsers: {
    type: Number,
    default: 0
  }
})

// Reactive data
const searchQuery = ref('')
const isDarkMode = ref(false)
const isMobileSearchOpen = ref(false)
const isUserMenuOpen = ref(false)
const isNotificationsOpen = ref(false)
const isLoggingOut = ref(false)
const localNotifications = ref([...props.notifications])

// Refs for DOM elements
const mobileSearchInput = ref(null)
const userMenuRef = ref(null)
const notificationRef = ref(null)

// Computed properties
const notificationCount = computed(() => {
  return localNotifications.value.filter(n => n.unread).length
})

// Methods
const toggleTheme = () => {
  isDarkMode.value = !isDarkMode.value

  if (isDarkMode.value) {
    document.documentElement.classList.add('dark')
    localStorage.setItem('theme', 'dark')
  } else {
    document.documentElement.classList.remove('dark')
    localStorage.setItem('theme', 'light')
  }
}

const toggleMobileSearch = async () => {
  isMobileSearchOpen.value = !isMobileSearchOpen.value
  if (isMobileSearchOpen.value) {
    await nextTick()
    mobileSearchInput.value?.focus()
  }
}

const toggleUserMenu = () => {
  isUserMenuOpen.value = !isUserMenuOpen.value
  isNotificationsOpen.value = false
}

const toggleNotifications = () => {
  isNotificationsOpen.value = !isNotificationsOpen.value
  isUserMenuOpen.value = false
}

const closeUserMenu = () => {
  isUserMenuOpen.value = false
}

const handleSearch = async () => {
  if (searchQuery.value.trim()) {
    // Pastikan route search tersedia atau sesuaikan dengan route yang ada
    router.get(route('search'), {
      query: searchQuery.value
    }, {
      preserveState: true,
      onSuccess: () => {
        if (isMobileSearchOpen.value) {
          isMobileSearchOpen.value = false
        }
      }
    })
  }
}

const handleLogout = async () => {
  if (isLoggingOut.value) return

  isLoggingOut.value = true

  try {
    await router.post(route('logout'), {}, {
      onFinish: () => {
        isLoggingOut.value = false
        isUserMenuOpen.value = false
      }
    })
  } catch (error) {
    console.error('Logout failed:', error)
    isLoggingOut.value = false
  }
}

const markNotificationAsRead = async (id) => {
  // Update local state immediately
  localNotifications.value = localNotifications.value.map(notification =>
    notification.id === id
      ? { ...notification, unread: false }
      : notification
  )

  // Send request to backend jika ada route untuk notifications
  try {
    await router.patch(route('notifications.read', id), {}, {
      preserveState: true
    })
  } catch (error) {
    console.error('Failed to mark notification as read:', error)
  }
}

const markAllNotificationsAsRead = async () => {
  // Update local state immediately
  localNotifications.value = localNotifications.value.map(notification => ({
    ...notification,
    unread: false
  }))

  // Send request to backend jika ada route untuk notifications
  try {
    await router.patch(route('notifications.read-all'), {}, {
      preserveState: true
    })
  } catch (error) {
    console.error('Failed to mark all notifications as read:', error)
  }
}

// Click outside handler
const handleClickOutside = (event) => {
  if (userMenuRef.value && !userMenuRef.value.contains(event.target)) {
    isUserMenuOpen.value = false
  }
  if (notificationRef.value && !notificationRef.value.contains(event.target)) {
    isNotificationsOpen.value = false
  }
}

// Initialize theme
const initializeTheme = () => {
  const savedTheme = localStorage.getItem('theme')
  if (savedTheme) {
    const isDark = savedTheme === 'dark'
    isDarkMode.value = isDark
    if (isDark) {
      document.documentElement.classList.add('dark')
    }
  } else {
    const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches
    isDarkMode.value = systemPrefersDark
    if (systemPrefersDark) {
      document.documentElement.classList.add('dark')
    }
  }
}

// Lifecycle hooks
onMounted(() => {
  initializeTheme()
  document.addEventListener('mousedown', handleClickOutside)
})

onUnmounted(() => {
  document.removeEventListener('mousedown', handleClickOutside)
})
</script>
