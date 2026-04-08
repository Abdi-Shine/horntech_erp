@extends('admin.admin_master')
@section('page_title', 'Feature Settings')
@section('admin')

    <div class="px-4 py-8 md:px-8 md:py-10 bg-background min-h-screen font-inter">

        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 animate-in fade-in slide-in-from-top-4 duration-500">
            <div>
                <h1 class="text-[20px] font-bold text-primary-dark">Feature Settings</h1>
                <p class="text-[13px] text-gray-400 font-medium mt-0.5">Configure and manage active system modules</p>
            </div>
            <div class="flex items-center gap-3">
                <button onclick="resetToDefault()" class="flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 text-gray-600 font-semibold rounded-[0.5rem] hover:bg-gray-50 transition-all text-sm shadow-sm">
                    <i class="bi bi-arrow-counterclockwise"></i>
                    <span>Reset to Default</span>
                </button>
                <button onclick="saveSettings()" class="btn-premium-primary group normal-case">
                    <i class="bi bi-check2-circle group-hover:scale-110 transition-transform duration-200"></i>
                    <span>Save Changes</span>
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Total Features -->
            <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
                <div>
                    <p class="text-[12px] text-gray-400 font-medium mb-1">Total Features</p>
                    <h3 class="text-[18px] font-black text-primary" id="totalFeatures">0</h3>
                    <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">
                        <i class="bi bi-cpu-fill text-[10px]"></i> System capacity
                    </p>
                </div>
                <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                    <i class="bi bi-grid text-lg"></i>
                </div>
            </div>

            <!-- Enabled -->
            <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
                <div>
                    <p class="text-[12px] text-gray-400 font-medium mb-1">Enabled</p>
                    <h3 class="text-[18px] font-black text-primary" id="enabledFeatures">0</h3>
                    <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">
                        <i class="bi bi-toggle-on text-[10px] text-accent"></i> Active modules
                    </p>
                </div>
                <div class="w-11 h-11 bg-accent/10 rounded-[0.6rem] flex items-center justify-center text-accent flex-shrink-0">
                    <i class="bi bi-check-circle text-lg"></i>
                </div>
            </div>

            <!-- Disabled -->
            <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
                <div>
                    <p class="text-[12px] text-gray-400 font-medium mb-1">Disabled</p>
                    <h3 class="text-[18px] font-black text-primary" id="disabledFeatures">0</h3>
                    <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">
                        <i class="bi bi-toggle-off text-[10px]"></i> Inactive modules
                    </p>
                </div>
                <div class="w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0">
                    <i class="bi bi-slash-circle text-lg"></i>
                </div>
            </div>

            <!-- Date -->
            <div class="bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between hover:-translate-y-0.5 transition-transform duration-200">
                <div>
                    <p class="text-[12px] text-gray-400 font-medium mb-1">Current Date</p>
                    <h3 class="text-[16px] font-black text-primary">{{ date('M d, Y') }}</h3>
                    <p class="text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1">
                        <i class="bi bi-clock-history text-[10px]"></i> System runtime
                    </p>
                </div>
                <div class="w-11 h-11 bg-accent/10 rounded-[0.6rem] flex items-center justify-center text-accent flex-shrink-0">
                    <i class="bi bi-calendar3 text-lg"></i>
                </div>
            </div>
        </div>

        <!-- Filter & Content Card -->
        <div class="bg-white rounded-[1rem] border border-gray-200/80 shadow-sm overflow-hidden mb-6">

            <!-- Filter Bar -->
            <div class="p-4 border-b border-gray-100 flex flex-col md:flex-row items-center gap-3">
                <!-- Search -->
                <div class="relative group min-w-[250px] flex-1 w-full">
                    <i class="bi bi-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm group-focus-within:text-primary-dark"></i>
                    <input type="text" id="searchInput" onkeyup="searchFeatures()" placeholder="Search features..."
                        class="w-full pl-9 pr-4 py-2 bg-white border border-gray-200 rounded-[0.5rem] text-[13px] font-medium text-gray-700 focus:ring-1 focus:ring-primary/20 focus:border-primary outline-none transition-all placeholder-gray-400">
                </div>

                <div class="flex items-center gap-3 w-full md:w-auto">
                    <!-- Module Filter -->
                    <div class="relative min-w-[180px] flex-1 md:flex-none">
                        <select onchange="filterByModule()" id="moduleFilter"
                            class="w-full pl-3 pr-8 py-2 bg-white border border-gray-200 rounded-[0.5rem] text-[13px] font-medium text-gray-600 focus:ring-1 focus:ring-primary/20 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                            <option value="all">All Modules</option>
                            <option value="sales">Sales & POS</option>
                            <option value="inventory">Inventory & Warehouse</option>
                            <option value="purchase">Purchase & Vendors</option>
                            <option value="hr">HR & Payroll</option>
                            <option value="finance">Finance & Accounting</option>
                            <option value="reports">Reports & Analytics</option>
                        </select>
                        <i class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
                    </div>

                    <!-- Status Filter -->
                    <div class="relative min-w-[140px] flex-1 md:flex-none">
                        <select onchange="filterByStatus()" id="statusFilter"
                            class="w-full pl-3 pr-8 py-2 bg-white border border-gray-200 rounded-[0.5rem] text-[13px] font-medium text-gray-600 focus:ring-1 focus:ring-primary/20 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                            <option value="all">All Status</option>
                            <option value="enabled">Enabled</option>
                            <option value="disabled">Disabled</option>
                        </select>
                        <i class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
                    </div>
                </div>
            </div>

            <!-- Section Title -->
            <div class="px-5 py-3 flex items-center gap-2 border-b border-gray-100 bg-background/50">
                <i class="bi bi-toggles text-primary-dark text-sm"></i>
                <h2 class="text-xs font-bold text-primary-dark uppercase tracking-wider">System Modules</h2>
            </div>

            <!-- Modules -->
            <div class="p-5 space-y-5" spellcheck="false">
                @foreach($modules as $key => $module)
                <div class="module-section border border-gray-100 rounded-[0.8rem] overflow-hidden" data-module="{{ $key }}">

                    <!-- Module Header -->
                    <div class="px-5 py-4 bg-primary/5 border-b border-primary/10 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-white rounded-[0.5rem] shadow-sm border border-gray-100 flex items-center justify-center text-primary flex-shrink-0">
                                <i class="bi {{ $module['icon'] }}"></i>
                            </div>
                            <div>
                                <h2 class="text-[13px] font-black text-primary-dark tracking-tight">{{ $module['title'] }}</h2>
                                <p class="text-[11px] text-gray-400 font-medium">{{ $module['desc'] }}</p>
                            </div>
                        </div>
                        <button onclick="toggleModule('{{ $key }}')"
                            class="flex items-center gap-1.5 px-3 py-1.5 bg-white border border-gray-200 text-primary-dark text-[11px] font-black rounded-[0.4rem] hover:border-primary hover:text-primary hover:bg-primary/5 transition-all uppercase tracking-wider shadow-sm">
                            <i class="bi bi-toggles text-[10px]"></i>
                            Toggle All
                        </button>
                    </div>

                    <!-- Feature Cards -->
                    <div class="p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($module['features'] as $f)
                        <div class="feature-item flex flex-col justify-between p-4 bg-background/60 border border-gray-100 rounded-[0.6rem] hover:border-primary/20 hover:bg-white hover:shadow-sm transition-all group"
                             data-module="{{ $key }}" data-status="{{ $f['enabled'] ? 'enabled' : 'disabled' }}">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-[12px] font-black text-primary-dark group-hover:text-primary transition-colors leading-tight">{{ $f['name'] }}</h3>
                                    <p class="text-[11px] text-gray-400 font-medium mt-1 leading-relaxed">{{ $f['desc'] }}</p>
                                </div>
                                <!-- Toggle Switch -->
                                <label class="premium-switch flex-shrink-0 mt-0.5">
                                    <input type="checkbox" name="feature_{{ $f['key'] }}" id="toggle_{{ $f['key'] }}"
                                           class="toggle-checkbox" {{ $f['enabled'] ? 'checked' : '' }}
                                           data-key="{{ $f['key'] }}"
                                           onchange="updateCounts()">
                                    <span class="premium-slider"></span>
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>

    <style>
        .premium-switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 24px;
        }
        .premium-switch input { opacity: 0; width: 0; height: 0; }
        .premium-slider {
            position: absolute;
            cursor: pointer;
            inset: 0;
            background-color: #e2e8f0;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 50px;
            border: 1px solid #cbd5e1;
        }
        .premium-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 2px;
            bottom: 2px;
            background-color: white;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 50%;
            box-shadow: 0 1px 3px rgba(0,0,0,0.15);
        }
        input:checked + .premium-slider {
            background-color: #99CC33;
            border-color: #88bb22;
        }
        input:checked + .premium-slider:before {
            transform: translateX(24px);
        }
        .feature-item[data-status="enabled"] {
            border-color: rgba(153,204,51,0.25);
            background-color: rgba(153,204,51,0.04);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            updateCounts();
        });

        function updateCounts() {
            const checkboxes = document.querySelectorAll('.toggle-checkbox');
            const total = checkboxes.length;
            let enabled = 0;

            checkboxes.forEach(checkbox => {
                const item = checkbox.closest('.feature-item');
                if (checkbox.checked) {
                    enabled++;
                    item.dataset.status = 'enabled';
                } else {
                    item.dataset.status = 'disabled';
                }
            });

            const disabled = total - enabled;
            document.getElementById('totalFeatures').textContent = total;
            document.getElementById('enabledFeatures').textContent = enabled;
            document.getElementById('disabledFeatures').textContent = disabled;
        }

        function toggleModule(module) {
            const checkboxes = document.querySelectorAll(`.feature-item[data-module="${module}"] .toggle-checkbox`);
            if (checkboxes.length === 0) return;
            const targetState = !checkboxes[0].checked;
            checkboxes.forEach(cb => { cb.checked = targetState; });
            updateCounts();
        }

        function searchFeatures() {
            const query = document.getElementById('searchInput').value.toLowerCase();
            document.querySelectorAll('.feature-item').forEach(item => {
                const match = item.innerText.toLowerCase().includes(query);
                item.style.display = match ? 'flex' : 'none';
            });
            document.querySelectorAll('.module-section').forEach(section => {
                const visible = Array.from(section.querySelectorAll('.feature-item')).some(i => i.style.display !== 'none');
                section.style.display = (visible || query === '') ? 'block' : 'none';
            });
        }

        function filterByModule() {
            const val = document.getElementById('moduleFilter').value;
            document.querySelectorAll('.module-section').forEach(s => {
                s.style.display = (val === 'all' || s.dataset.module === val) ? 'block' : 'none';
            });
        }

        function filterByStatus() {
            const val = document.getElementById('statusFilter').value;
            document.querySelectorAll('.feature-item').forEach(item => {
                item.style.display = (val === 'all' || item.dataset.status === val) ? 'flex' : 'none';
            });
        }

        function resetToDefault() {
            Swal.fire({
                title: 'Enable All Features?',
                text: 'This will activate all system features and modules.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#004161',
                cancelButtonColor: '#99CC33',
                confirmButtonText: 'Yes, enable all!',
                cancelButtonText: 'Cancel',
                customClass: {
                    popup: 'rounded-[1.5rem]',
                    confirmButton: 'rounded-[0.5rem] px-6 py-2 text-xs font-bold uppercase tracking-widest',
                    cancelButton: 'rounded-[0.5rem] px-6 py-2 text-xs font-bold uppercase tracking-widest'
                }
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const response = await fetch("{{ route('feature-settings.reset') }}", {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                        });
                        const res = await response.json();
                        if (res.success) {
                            Swal.fire({ icon: 'success', title: 'Reset Successful', text: res.message, timer: 2000, showConfirmButton: false })
                                .then(() => location.reload());
                        }
                    } catch (e) { console.error(e); }
                }
            });
        }

        async function saveSettings() {
            const features = {};
            document.querySelectorAll('.toggle-checkbox').forEach(cb => { features[cb.dataset.key] = cb.checked; });

            try {
                const response = await fetch("{{ route('feature-settings.update') }}", {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ features })
                });
                const result = await response.json();
                if (result.success) {
                    Swal.fire({
                        icon: 'success', title: 'Saved!', text: result.message,
                        timer: 2000, showConfirmButton: false,
                        customClass: { popup: 'rounded-[1.5rem]' }
                    });
                }
            } catch (e) {
                Swal.fire({
                    icon: 'error', title: 'Error', text: 'Something went wrong while saving.',
                    customClass: { popup: 'rounded-[1.5rem]' }
                });
            }
        }
    </script>

@endsection
