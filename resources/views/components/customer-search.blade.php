@props([
    'name' => 'customer_id',
    'selected' => null,
    'placeholder' => 'Search for a customer...',
    'required' => true,
    'class' => ''
])

<div class="relative max-w-2xl {{ $class }}" x-data="customerSearch({
    selected: @json($selected),
    name: '{{ $name }}',
    searchUrl: '{{ route('credit.customers.search') }}'
})">
    <!-- Hidden input for form submission -->
    <input type="hidden" :name="name" :value="selectedCustomer ? selectedCustomer.id : ''" {{ $required ? 'required' : '' }}>
    
    <!-- Search Interface -->
    <div class="relative">
        <!-- Search Input with Icons -->
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            
            <input 
                type="text" 
                x-model="searchQuery"
                @input.debounce.300ms="search()"
                @focus="handleFocus()"
                @keydown.escape="$el.blur()"
                @keydown.arrow-down.prevent="highlightNext()"
                @keydown.arrow-up.prevent="highlightPrevious()"
                @keydown.enter.prevent="selectHighlighted()"
                placeholder="{{ $placeholder }}"
                class="block w-full pl-12 pr-12 py-3.5 text-sm border-0 rounded-lg bg-gray-50 dark:bg-gray-800 ring-1 ring-gray-300 dark:ring-gray-600 placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:bg-white dark:focus:bg-gray-700 transition-all duration-200"
                :class="{ 
                    'ring-green-300 bg-green-50 dark:bg-green-900/20': selectedCustomer,
                    'ring-blue-300': showDropdown && !selectedCustomer 
                }"
            >
            
            <!-- Loading indicator / Clear button -->
            <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                <div x-show="loading" class="mr-2">
                    <svg class="animate-spin h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
                <button 
                    type="button"
                    x-show="selectedCustomer && !loading"
                    @click="clearSelection()"
                    class="text-gray-400 hover:text-red-500 transition-colors rounded-full p-1 hover:bg-red-50 dark:hover:bg-red-900/20"
                    title="Clear selection"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        
    </div>
    
    <!-- Customer Search Results -->
    <div x-show="!selectedCustomer" class="w-full max-w-2xl mt-4 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-600 overflow-hidden">
        <!-- Search Header -->
        <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 border-b border-gray-100 dark:border-gray-600">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span x-show="!loading && results.length > 0 && searchQuery.length >= 2">
                        <span x-text="results.length"></span> customer<span x-show="results.length !== 1">s</span> found
                    </span>
                    <span x-show="!loading && results.length > 0 && searchQuery.length < 2">
                        Recent customers
                    </span>
                    <span x-show="loading">Searching customers...</span>
                    <span x-show="!loading && searchQuery.length < 2 && results.length === 0">Customer Search</span>
                    <span x-show="!loading && searchQuery.length >= 2 && results.length === 0">No Results</span>
                </div>
                <div class="text-xs text-gray-400">
                    <kbd class="px-1.5 py-0.5 text-xs font-semibold text-gray-800 bg-gray-100 border border-gray-200 rounded dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500">↑↓</kbd> navigate
                    <kbd class="px-1.5 py-0.5 text-xs font-semibold text-gray-800 bg-gray-100 border border-gray-200 rounded dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500">↵</kbd> select
                </div>
            </div>
        </div>
        
        <!-- Results Container -->
        <div class="max-h-80 overflow-y-auto">
            <!-- Empty/Initial State -->
            <div x-show="!loading && searchQuery.length < 2 && results.length === 0" class="px-4 py-8">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-full mb-3">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-900 dark:text-white font-medium mb-1">Start typing to search</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Enter at least 2 characters to find customers</p>
                </div>
            </div>

            <!-- Loading State -->
            <div x-show="loading" class="px-4 py-8">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-full mb-3">
                        <svg class="animate-spin w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Searching customers...</p>
                </div>
            </div>
            
            <!-- No Results State -->
            <div x-show="!loading && searchQuery.length >= 2 && results.length === 0" class="px-4 py-8">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-full mb-3">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-900 dark:text-white font-medium mb-1">No customers found</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Try searching with a different term</p>
                </div>
            </div>
            
            <!-- Customer Results -->
            <div x-show="!loading && results.length > 0" class="divide-y divide-gray-100 dark:divide-gray-700">
                <template x-for="(customer, index) in results" :key="customer.id">
                    <div 
                        @click="selectCustomer(customer)"
                        :class="{ 
                            'bg-blue-50 dark:bg-blue-900/20 border-l-4 border-l-blue-500': index === highlightedIndex,
                            'hover:bg-gray-50 dark:hover:bg-gray-700': index !== highlightedIndex
                        }"
                        class="px-4 py-4 cursor-pointer transition-all duration-150 group"
                    >
                        <div class="flex items-start justify-between">
                            <!-- Customer Info -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center space-x-3">
                                    <!-- Avatar -->
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-semibold text-white" x-text="customer.name.charAt(0)"></span>
                                        </div>
                                    </div>
                                    
                                    <!-- Details -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center space-x-2">
                                            <h4 class="text-sm font-semibold text-gray-900 dark:text-white truncate" x-text="customer.name"></h4>
                                        </div>
                                        
                                        <div class="mt-1 flex items-center space-x-4 text-xs text-gray-500 dark:text-gray-400">
                                            <div class="flex items-center space-x-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                </svg>
                                                <span class="truncate max-w-32" x-text="customer.email"></span>
                                            </div>
                                            <div x-show="customer.phone" class="flex items-center space-x-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                                </svg>
                                                <span x-text="customer.phone"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </template>
            </div>
        </div>
        
        <!-- Footer -->
        <div x-show="!loading && results.length > 0" class="px-4 py-2 bg-gray-50 dark:bg-gray-700 border-t border-gray-100 dark:border-gray-600">
            <p class="text-xs text-gray-500 dark:text-gray-400 text-center">
                Showing <span x-text="results.length"></span> of matching customers
            </p>
        </div>
    </div>
    
    <!-- Enhanced Selected Customer Display -->
    <div x-show="selectedCustomer" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         class="mt-3 max-w-2xl">
        <div class="relative p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-green-200 dark:border-green-700/50">
            <div class="flex items-start justify-between">
                <!-- Customer Details -->
                <div class="flex items-center space-x-4">
                    <!-- Enhanced Avatar -->
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center ring-4 ring-white dark:ring-gray-800">
                            <span class="text-lg font-bold text-white" x-text="selectedCustomer?.name?.charAt(0)"></span>
                        </div>
                    </div>
                    
                    <!-- Info -->
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white" x-text="selectedCustomer?.name"></h3>
                        <div class="mt-1 flex items-center space-x-4 text-sm text-gray-600 dark:text-gray-400">
                            <div class="flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <span x-text="selectedCustomer?.email"></span>
                            </div>
                            <div x-show="selectedCustomer?.phone" class="flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <span x-text="selectedCustomer?.phone"></span>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            
            <!-- Clear Selection Button -->
            <button 
                type="button"
                @click="clearSelection(); $nextTick(() => $el.closest('[x-data]').querySelector('input[type=text]').focus())"
                class="absolute top-2 right-2 text-gray-400 hover:text-red-500 dark:hover:text-red-400 transition-colors p-1 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20"
                title="Remove selection"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
</div>

<script>
function customerSearch(config) {
    return {
        searchQuery: '',
        results: [],
        selectedCustomer: config.selected || null,
        loading: false,
        showDropdown: false,
        highlightedIndex: -1,
        name: config.name,
        searchUrl: config.searchUrl,

        init() {
            if (this.selectedCustomer) {
                this.searchQuery = this.selectedCustomer.display || this.selectedCustomer.name;
            }
        },

        handleFocus() {
            if (this.searchQuery.length >= 2) {
                this.search();
            } else {
                // Always load initial/recent customers when focused
                this.loadInitialCustomers();
            }
        },

        async loadInitialCustomers() {
            this.loading = true;
            
            try {
                const response = await fetch(`${this.searchUrl}?limit=10`);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const data = await response.json();
                this.results = Array.isArray(data) ? data : [];
            } catch (error) {
                console.error('Error loading initial customers:', error);
                this.results = [];
            } finally {
                this.loading = false;
            }
        },

        async search() {
            if (this.searchQuery.length < 2) {
                // Load initial customers instead of hiding dropdown
                this.loadInitialCustomers();
                return;
            }

            this.loading = true;
            this.highlightedIndex = -1;
            
            try {
                const response = await fetch(`${this.searchUrl}?q=${encodeURIComponent(this.searchQuery)}&limit=20`);
                const data = await response.json();
                this.results = data;
            } catch (error) {
                console.error('Customer search error:', error);
                this.results = [];
            } finally {
                this.loading = false;
            }
        },

        selectCustomer(customer) {
            this.selectedCustomer = customer;
            this.searchQuery = customer.display;
            this.results = [];
            this.highlightedIndex = -1;
        },

        clearSelection() {
            this.selectedCustomer = null;
            this.searchQuery = '';
            this.loadInitialCustomers();
            this.highlightedIndex = -1;
        },

        highlightNext() {
            if (this.highlightedIndex < this.results.length - 1) {
                this.highlightedIndex++;
            }
        },

        highlightPrevious() {
            if (this.highlightedIndex > 0) {
                this.highlightedIndex--;
            }
        },

        selectHighlighted() {
            if (this.highlightedIndex >= 0 && this.results[this.highlightedIndex]) {
                this.selectCustomer(this.results[this.highlightedIndex]);
            }
        }
    }
}
</script>