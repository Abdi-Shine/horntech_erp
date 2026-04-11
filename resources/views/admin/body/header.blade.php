
<header class="bg-white border-b border-border h-20 sticky top-0 z-40 lg:ml-[260px]">
    <div class="flex items-center justify-between h-full px-8">
        <!-- Left Section: Dashboard Title -->
        <div class="flex items-center gap-4">
            <button id="menuToggle" class="lg:hidden p-2 text-text-secondary hover:text-primary transition-colors">
                <i class="bi bi-list text-2xl"></i>
            </button>

        </div>
        
        <!-- Right Section -->
        <div class="flex items-center gap-6">
            <!-- Quick Navigation Search -->
            <div class="relative hidden lg:block"
                 x-data="{
                     query: '',
                     open: false,
                     pages: [
                         { label: 'Dashboard',              icon: 'bi-speedometer2',        url: '{{ route('dashboard') }}' },
                         { label: 'Customers',              icon: 'bi-person-lines-fill',   url: '{{ route('customer.index') }}' },
                         { label: 'Suppliers',              icon: 'bi-truck',               url: '{{ route('supplier.index') }}' },
                         { label: 'Branches',               icon: 'bi-building',            url: '{{ route('branches-view') }}' },
                         { label: 'Products',               icon: 'bi-box-seam',            url: '{{ route('product.index') }}' },
                         { label: 'Categories',             icon: 'bi-tag',                 url: '{{ route('category.index') }}' },
                         { label: 'Low Stock Alerts',       icon: 'bi-exclamation-triangle', url: '{{ route('low-stock.view') }}' },
                         { label: 'Stock Adjustment',       icon: 'bi-pencil-square',       url: '{{ route('stock-adjustment.view') }}' },
                         { label: 'Purchase Orders',        icon: 'bi-file-earmark-text',   url: '{{ route('purchase.order.index') }}' },
                         { label: 'Purchase Bills',         icon: 'bi-receipt',             url: '{{ route('purchase.bill') }}' },
                         { label: 'Purchase Returns',       icon: 'bi-arrow-return-left',   url: '{{ route('purchase.returns') }}' },
                         { label: 'Supplier Payments',      icon: 'bi-send',                url: '{{ route('view_payment_out') }}' },
                         { label: 'Sales Invoices',         icon: 'bi-file-earmark-check',  url: '{{ route('sales.invoice.view') }}' },
                         { label: 'POS Terminal',           icon: 'bi-display',             url: '{{ route('sales.pos.view') }}' },
                         { label: 'Customer Payments',      icon: 'bi-cash-coin',           url: '{{ route('view_payment_in') }}' },
                         { label: 'Sale Returns',           icon: 'bi-arrow-return-right',  url: '{{ route('sales.return.view') }}' },
                         { label: 'Expenses',               icon: 'bi-credit-card-2-front', url: '{{ route('expenses_view_all') }}' },
                         { label: 'Payroll',                icon: 'bi-people',              url: '{{ route('payroll.index') }}' },
                         { label: 'Loans',                  icon: 'bi-bank2',               url: '{{ route('loan.view') }}' },
                         { label: 'Chart of Accounts',      icon: 'bi-diagram-3',           url: '{{ route('account.index') }}' },
                         { label: 'Journal Entry',          icon: 'bi-journal-text',        url: '{{ route('journal.index') }}' },

                         { label: 'Trial Balance',          icon: 'bi-bar-chart-steps',     url: '{{ route('account.trial-balance') }}' },
                         { label: 'Cash Management',        icon: 'bi-safe',                url: '{{ route('cash_management.index') }}' },
                         { label: 'Reports',                icon: 'bi-graph-up-arrow',      url: '{{ route('all_reports') }}' },
                         { label: 'Company Settings',       icon: 'bi-building-gear',       url: '{{ route('company-settings') }}' },
                         { label: 'Employees',              icon: 'bi-person-badge',        url: '{{ route('employee.index') }}' },
                         { label: 'Roles & Permissions',    icon: 'bi-shield-lock',         url: '{{ route('role.index') }}' },
                         { label: 'Backup & Restore',       icon: 'bi-cloud-arrow-up',      url: '{{ route('backup-restore') }}' },
                         { label: 'Audit Logs',             icon: 'bi-clock-history',       url: '{{ route('audit-logs') }}' },
                     ],
                     get results() {
                         if (!this.query.trim()) return [];
                         const q = this.query.toLowerCase();
                         return this.pages.filter(p => p.label.toLowerCase().includes(q)).slice(0, 6);
                     }
                 }"
                 @keydown.escape="open = false; query = ''"
                 @click.away="open = false">

                <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 transition-colors z-10"
                   :class="open ? 'text-primary' : ''"></i>
                <input
                    type="text"
                    placeholder="Jump to page..."
                    x-model="query"
                    @focus="open = true"
                    @input="open = true"
                    @keydown.enter.prevent="if (results.length) { window.location = results[0].url; query=''; open=false; }"
                    class="pl-11 pr-4 py-2 border border-gray-100 rounded-xl text-sm focus:outline-none focus:ring-4 focus:ring-primary/5 focus:border-primary w-[280px] bg-gray-50/50 transition-all placeholder:text-gray-400 font-medium"
                >

                <!-- Results Dropdown -->
                <div x-show="open && results.length > 0"
                     x-cloak
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="absolute top-full left-0 mt-2 w-full bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden z-50">
                    <template x-for="page in results" :key="page.url">
                        <a :href="page.url"
                           @click="query = ''; open = false"
                           class="flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50 transition-colors">
                            <i :class="'bi ' + page.icon + ' text-primary/50 text-sm'"></i>
                            <span class="text-[13px] font-semibold text-primary" x-text="page.label"></span>
                        </a>
                    </template>
                </div>
            </div>

            <!-- Notification Bell & Dropdown -->
            @php $totalNotifs = $lowStockAlerts->count() + $globalBackups->count(); @endphp
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" @click.away="open = false" class="relative p-2 text-gray-400 hover:text-primary transition-all focus:outline-none">
                    <i class="bi bi-bell text-2xl"></i>
                    @if($totalNotifs > 0)
                        <span class="absolute top-1 right-1 min-w-[18px] h-[18px] bg-red-500 text-white text-[9px] font-black rounded-full border-2 border-white flex items-center justify-center px-0.5">{{ $totalNotifs }}</span>
                    @endif
                </button>

                <!-- Notification Dropdown -->
                <div x-show="open"
                     x-cloak
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                     class="absolute right-0 mt-3 w-[340px] bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden z-50">

                    <div class="px-5 py-3 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                        <h3 class="text-xs font-black text-primary-dark uppercase tracking-widest">Notifications</h3>
                        <span class="px-2 py-0.5 bg-red-50 text-red-600 text-[9px] font-bold rounded-full border border-red-100">{{ $totalNotifs }} Alert(s)</span>
                    </div>

                    <div class="max-h-[380px] overflow-y-auto custom-scrollbar">

                        {{-- Low Stock Alerts --}}
                        @if($lowStockAlerts->count() > 0)
                            <div class="px-5 py-2 bg-red-50/60 border-b border-red-100">
                                <span class="text-[9px] font-black text-red-500 uppercase tracking-widest">⚠ Low Stock — Critical</span>
                            </div>
                            @foreach($lowStockAlerts as $item)
                            <a href="{{ route('low-stock.view') }}" class="flex gap-3 px-5 py-3.5 hover:bg-red-50/40 border-b border-gray-50 transition-colors group">
                                <div class="w-9 h-9 rounded-xl bg-red-100 flex items-center justify-center text-red-500 shrink-0 group-hover:bg-red-500 group-hover:text-white transition-all duration-200">
                                    <i class="bi bi-exclamation-triangle-fill text-sm"></i>
                                </div>
                                <div class="flex flex-col gap-0.5 min-w-0">
                                    <p class="text-[12px] font-bold text-primary-dark leading-tight truncate">{{ $item->name }}</p>
                                    <p class="text-[10px] text-red-500 font-bold">Stock: {{ $item->current_stock }} / Min: {{ $item->low_stock_threshold }}</p>
                                    <span class="text-[9px] font-black text-white bg-red-500 rounded px-1.5 py-0.5 w-fit uppercase tracking-tighter">CRITICAL</span>
                                </div>
                            </a>
                            @endforeach
                        @endif

                        {{-- Backup Alerts --}}
                        @if($globalBackups->count() > 0)
                            <div class="px-5 py-2 bg-primary/5 border-b border-primary/10">
                                <span class="text-[9px] font-black text-primary uppercase tracking-widest">✓ Recent Backups</span>
                            </div>
                            @foreach($globalBackups as $notif)
                            <div class="px-5 py-3.5 hover:bg-slate-50 border-b border-gray-50 transition-colors group">
                                <div class="flex gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-primary/5 flex items-center justify-center text-primary shrink-0 group-hover:bg-primary group-hover:text-white transition-all duration-200">
                                        <i class="bi bi-shield-check text-sm"></i>
                                    </div>
                                    <div class="flex flex-col gap-0.5">
                                        <p class="text-[12px] font-bold text-primary-dark leading-tight">Backup Verified</p>
                                        <p class="text-[10px] text-slate-500">{{ $notif->filename }}</p>
                                        <span class="text-[9px] text-slate-400 italic">{{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif

                        @if($totalNotifs === 0)
                        <div class="px-5 py-10 text-center">
                            <div class="flex flex-col items-center gap-2 opacity-30">
                                <i class="bi bi-bell-slash text-3xl text-gray-400"></i>
                                <p class="text-[11px] font-black uppercase tracking-widest text-gray-400">No Alerts</p>
                            </div>
                        </div>
                        @endif
                    </div>

                    @if($lowStockAlerts->count() > 0)
                    <a href="{{ route('low-stock.view') }}" class="block px-5 py-3 bg-red-50 text-center text-[10px] font-bold text-red-600 hover:text-red-700 transition-colors uppercase tracking-widest border-t border-red-100">
                        View All Stock Alerts →
                    </a>
                    @else
                    <a href="{{ route('backup-restore') }}" class="block px-5 py-3 bg-gray-50 text-center text-[10px] font-bold text-primary hover:text-primary-dark transition-colors uppercase tracking-widest border-t border-gray-100">
                        View Archival Ledger →
                    </a>
                    @endif
                </div>
            </div>
            
            <!-- Vertical Divider -->
            <div class="h-10 w-px bg-gray-100 hidden sm:block"></div>

            <!-- User Menu Profile with Dropdown -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 group cursor-pointer focus:outline-none">
                    <!-- Avatar -->
                    <div class="w-11 h-11 bg-accent rounded-full flex items-center justify-center shadow-md shadow-accent/20 group-hover:scale-105 transition-all duration-300 border border-white overflow-hidden">
                        @if(Auth::user()->photo)
                            <img src="{{ url('upload/user_images/'.Auth::user()->photo) }}" class="w-full h-full object-cover" alt="User">
                        @else
                            <span class="text-primary text-sm font-black uppercase tracking-tighter">{{ substr(Auth::user()->name, 0, 2) }}</span>
                        @endif
                    </div>
                    
                    <!-- Text Details -->
                    <div class="hidden md:flex flex-col text-left leading-tight">
                        <div class="flex items-center gap-2">
                            <span class="text-[15px] font-bold text-[#004161] tracking-tight">{{ Auth::user()->fullname ?? Auth::user()->name }}</span>
                            <i class="bi bi-chevron-down text-gray-400 text-[10px] transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                        </div>
                        <span class="text-[12px] text-gray-400 font-medium">{{ Auth::user()->role ?? 'Administrator' }}</span>
                    </div>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open" 
                     x-cloak
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                     class="absolute right-0 mt-2 w-[220px] bg-white rounded-[20px] overflow-hidden profile-dropdown-shadow z-50">
                    
                    <!-- Dropdown Header -->
                    <div class="bg-primary px-4 py-4 flex items-center gap-3">
                        <div class="w-11 h-11 bg-white/10 rounded-full flex items-center justify-center text-white border border-white/20 overflow-hidden">
                            @if(Auth::user()->photo)
                                <img src="{{ url('upload/user_images/'.Auth::user()->photo) }}" class="w-full h-full object-cover" alt="User">
                            @else
                                <span class="text-sm font-bold">{{ substr(Auth::user()->name, 0, 2) }}</span>
                            @endif
                        </div>
                        <div class="leading-tight">
                            <h4 class="text-white font-bold text-sm leading-tight">{{ Auth::user()->fullname ?? Auth::user()->name }}</h4>
                            <p class="text-white/60 text-[11px] font-medium mt-0.5 uppercase tracking-wider">{{ Auth::user()->role ?? 'Administrator' }}</p>
                        </div>
                    </div>

                    <!-- Dropdown Links -->
                    <div class="py-2 px-1">
                        <a href="{{ route('profile-user') }}" class="flex items-center gap-3 px-3 py-2.5 text-primary font-bold hover:bg-gray-50 rounded-lg transition-colors">
                            <i class="bi bi-person text-lg"></i>
                            <span class="text-[14px]">My Profile</span>
                        </a>
                        <a href="{{ route('lock-screen') }}" class="flex items-center gap-3 px-3 py-2.5 text-primary font-bold hover:bg-gray-50 rounded-xl transition-colors">
                            <i class="bi bi-lock text-lg"></i>
                            <span class="text-[14px]">Lock Screen</span>
                        </a>
                    </div>

                    <!-- Logout -->
                    <div class="border-t border-gray-100 py-2 px-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 text-error font-bold hover:bg-red-50 rounded-lg transition-colors text-left cursor-pointer">
                                <i class="bi bi-box-arrow-right text-lg"></i>
                                <span class="text-[14px]">Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
