<!-- Toast Container -->
<div x-data="toastManager()" 
     @toast.window="addToast($event.detail)"
     class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 space-y-3 w-full max-w-md px-4">
    
    <template x-for="toast in toasts" :key="toast.id">
        <div x-show="toast.visible"
             x-transition:enter="transform transition ease-out duration-300"
             x-transition:enter-start="-translate-y-full opacity-0"
             x-transition:enter-end="translate-y-0 opacity-100"
             x-transition:leave="transform transition ease-in duration-200"
             x-transition:leave-start="translate-y-0 opacity-100"
             x-transition:leave-end="-translate-y-full opacity-0"
             :class="{
                 'bg-green-50 border-green-200': toast.type === 'success',
                 'bg-blue-50 border-blue-200': toast.type === 'info',
                 'bg-yellow-50 border-yellow-200': toast.type === 'warning',
                 'bg-red-50 border-red-200': toast.type === 'error'
             }"
             class="border-2 rounded-lg shadow-lg p-4 flex items-start gap-3">
            
            <!-- Icon -->
            <div class="flex-shrink-0">
                <template x-if="toast.type === 'success'">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </template>
                <template x-if="toast.type === 'info'">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </template>
                <template x-if="toast.type === 'warning'">
                    <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </template>
                <template x-if="toast.type === 'error'">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </template>
            </div>

            <!-- Content -->
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-gray-900" x-text="toast.title"></p>
                <p class="text-sm text-gray-600 mt-1" x-text="toast.message" x-show="toast.message"></p>
                
                <!-- Actions -->
                <div class="flex gap-3 mt-3" x-show="toast.actions && toast.actions.length > 0">
                    <template x-for="action in toast.actions" :key="action.label">
                        <button @click="action.callback(); removeToast(toast.id)"
                                :class="{
                                    'bg-green-100 hover:bg-green-200 text-green-700': toast.type === 'success',
                                    'bg-blue-100 hover:bg-blue-200 text-blue-700': toast.type === 'info',
                                    'bg-yellow-100 hover:bg-yellow-200 text-yellow-700': toast.type === 'warning',
                                    'bg-red-100 hover:bg-red-200 text-red-700': toast.type === 'error'
                                }"
                                class="px-4 py-2 rounded-lg text-sm font-semibold transition"
                                x-text="action.label">
                        </button>
                    </template>
                </div>
            </div>

            <!-- Close Button -->
            <button @click="removeToast(toast.id)" class="flex-shrink-0 text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </template>
</div>

<script>
function toastManager() {
    return {
        toasts: [],
        nextId: 1,

        addToast(config) {
            const toast = {
                id: this.nextId++,
                type: config.type || 'info',
                title: config.title || '',
                message: config.message || '',
                actions: config.actions || [],
                visible: true,
                duration: config.duration || 5000
            };

            this.toasts.push(toast);

            // Auto remove after duration
            if (toast.duration > 0) {
                setTimeout(() => {
                    this.removeToast(toast.id);
                }, toast.duration);
            }
        },

        removeToast(id) {
            const index = this.toasts.findIndex(t => t.id === id);
            if (index > -1) {
                this.toasts[index].visible = false;
                setTimeout(() => {
                    this.toasts.splice(index, 1);
                }, 300);
            }
        }
    }
}

// Global toast helper
window.showToast = function(config) {
    window.dispatchEvent(new CustomEvent('toast', { detail: config }));
}
</script>
