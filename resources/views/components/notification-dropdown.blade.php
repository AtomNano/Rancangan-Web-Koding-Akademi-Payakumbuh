@props(['user'])

<div x-data="notifications(
    '{{ route('notifications.index') }}',
    '{{ route('notifications.read', ['id' => '__ID__']) }}',
    '{{ route('notifications.read.all') }}',
    '{{ csrf_token() }}'
)" 
     x-init="fetchNotifications(); setInterval(() => fetchNotifications(), 15000)" 
     class="relative">
    
    <!-- Notification Icon Trigger -->
    <button @click="open = !open" class="relative inline-flex items-center p-2 text-sm font-medium text-center text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg focus:outline-none transition-colors">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
        <span class="sr-only">Notifikasi</span>
        <!-- Unread count badge -->
        <template x-if="unreadCount > 0">
            <div x-text="unreadCount" class="absolute inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-1 -right-1"></div>
        </template>
    </button>

    <!-- Dropdown Panel -->
    <div x-show="open"
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute right-0 z-50 mt-2 w-80 sm:w-96 origin-top-right bg-white divide-y divide-gray-100 rounded-xl shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none"
         x-cloak>
        
        <div class="px-4 py-3">
            <div class="flex justify-between items-center">
                <p class="text-sm font-semibold text-gray-900">
                    Notifikasi
                </p>
                <button x-show="unreadCount > 0" @click="markAllAsRead" class="text-xs font-medium text-indigo-600 hover:text-indigo-800">
                    Tandai semua dibaca
                </button>
            </div>
        </div>

        <div class="max-h-96 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
            <!-- Unread Notifications -->
            <template x-if="unread.length > 0">
                <div class="divide-y divide-gray-100">
                    <template x-for="notification in unread" :key="notification.id">
                        <a :href="notification.data.url" @click="markAsRead(notification.id)" class="block px-4 py-3 hover:bg-gray-50">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 pt-0.5">
                                    <!-- Icon based on notification type -->
                                    <svg class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div class="ml-3 w-0 flex-1">
                                    <p class="text-sm font-semibold text-gray-800" x-text="notification.data.title"></p>
                                    <p class="mt-1 text-sm text-gray-600" x-text="notification.data.message"></p>
                                    <p class="mt-1 text-xs text-gray-400" x-text="timeAgo(notification.created_at)"></p>
                                </div>
                            </div>
                        </a>
                    </template>
                </div>
            </template>
            <!-- Read Notifications -->
            <template x-if="read.length > 0 && unread.length == 0">
                 <div class="divide-y divide-gray-100 border-t border-gray-200">
                    <div class="px-4 pt-3 pb-2 text-xs font-medium text-gray-400 uppercase">Terbaru</div>
                    <template x-for="notification in read" :key="notification.id">
                         <a :href="notification.data.url" class="block px-4 py-3 bg-white opacity-70">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 pt-0.5">
                                    <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div class="ml-3 w-0 flex-1">
                                    <p class="text-sm font-medium text-gray-600" x-text="notification.data.title"></p>
                                    <p class="mt-1 text-sm text-gray-500" x-text="notification.data.message"></p>
                                    <p class="mt-1 text-xs text-gray-400" x-text="timeAgo(notification.created_at)"></p>
                                </div>
                            </div>
                        </a>
                    </template>
                </div>
            </template>
            <!-- Empty State -->
            <template x-if="unread.length === 0 && read.length === 0">
                <div class="text-center py-12 px-4">
                     <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada notifikasi</h3>
                    <p class="mt-1 text-sm text-gray-500">Semua notifikasi akan muncul di sini.</p>
                </div>
            </template>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('notifications', (fetchUrl, markReadUrl, markAllReadUrl, csrfToken) => ({
        open: false,
        unread: [],
        read: [],
        unreadCount: 0,
        fetchNotifications() {
            fetch(fetchUrl)
                .then(response => response.json())
                .then(data => {
                    this.unread = data.unread;
                    this.read = data.read;
                    this.unreadCount = data.unread_count;
                });
        },
        markAsRead(notificationId) {
            let url = markReadUrl.replace('__ID__', notificationId);
            fetch(url, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken },
            }).then(() => {
                this.unread = this.unread.filter(n => n.id !== notificationId);
                this.unreadCount = this.unread.length;
                // We don't need to manually move it to the 'read' array, a page refresh will show it.
                // Or let the next poll handle it.
            });
            // Let the link navigation proceed
        },
        markAllAsRead() {
            fetch(markAllReadUrl, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken },
            }).then(() => {
                this.unread = [];
                this.unreadCount = 0;
                this.fetchNotifications(); // Refresh to show them in the 'read' list
            });
        },
        timeAgo(dateString) {
            const date = new Date(dateString);
            const seconds = Math.floor((new Date() - date) / 1000);
            let interval = seconds / 31536000;
            if (interval > 1) return Math.floor(interval) + " tahun lalu";
            interval = seconds / 2592000;
            if (interval > 1) return Math.floor(interval) + " bulan lalu";
            interval = seconds / 86400;
            if (interval > 1) return Math.floor(interval) + " hari lalu";
            interval = seconds / 3600;
            if (interval > 1) return Math.floor(interval) + " jam lalu";
            interval = seconds / 60;
            if (interval > 1) return Math.floor(interval) + " menit lalu";
            return Math.floor(seconds) + " detik lalu";
        }
    }));
});
</script>
