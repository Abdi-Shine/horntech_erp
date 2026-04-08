$files = @(
  'resources/views/frontend/product/category.blade.php',
  'resources/views/frontend/product/add_product.blade.php',
  'resources/views/frontend/branch/store_transfer.blade.php',
  'resources/views/frontend/branch/store_management.blade.php',
  'resources/views/frontend/branch/stores.blade.php',
  'resources/views/frontend/branch/branch_transfer.blade.php',
  'resources/views/frontend/branch/branch_store_transfer.blade.php'
)
foreach ($f in $files) {
  $c = Get-Content $f -Raw -Encoding UTF8
  $c = $c -replace 'premium-page-header[^"]*', 'flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4'
  $c = $c -replace 'premium-page-title', 'text-[20px] font-bold text-primary-dark'
  $c = $c -replace 'premium-stats-grid[^"]*', 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6'
  $c = $c -replace 'premium-stats-card[^"]*', 'bg-white p-5 rounded-[1rem] border border-gray-100 shadow-sm flex items-start justify-between'
  $c = $c -replace 'premium-stats-label', 'text-[12px] text-gray-400 font-medium mb-1'
  $c = $c -replace 'premium-stats-value[^"]*', 'text-[18px] font-black text-primary'
  $c = $c -replace 'premium-stats-subtext', 'text-xs font-bold text-primary-dark mt-1.5 flex items-center gap-1'
  $c = $c -replace 'premium-stats-icon-box bg-primary/10 text-primary border border-primary/10', 'w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0'
  $c = $c -replace 'premium-stats-icon-box bg-primary/10 text-primary', 'w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0'
  $c = $c -replace 'premium-stats-icon-box bg-accent/10 text-accent', 'w-11 h-11 bg-accent/10 rounded-[0.6rem] flex items-center justify-center text-accent flex-shrink-0'
  $c = $c -replace 'premium-stats-icon-box[^"]*', 'w-11 h-11 bg-primary/10 rounded-[0.6rem] flex items-center justify-center text-primary flex-shrink-0'
  $c = $c -replace 'premium-filter-container[^"]*', 'bg-white rounded-[1rem] border border-gray-200/80 shadow-sm overflow-hidden mb-6'
  $c = $c -replace 'premium-filter-bar', 'p-4 border-b border-gray-100 flex items-center gap-3 overflow-x-auto custom-scrollbar whitespace-nowrap'
  $c = $c -replace 'premium-input-search', 'w-full pl-9 pr-4 py-2 bg-white border border-gray-200 rounded-[0.5rem] text-[13px] font-medium text-gray-700 focus:ring-1 focus:ring-primary/20 focus:border-primary outline-none transition-all placeholder-gray-400'
  $c = $c -replace 'premium-input-select', 'w-full pl-3 pr-8 py-2 bg-white border border-gray-200 rounded-[0.5rem] text-[13px] font-medium text-gray-600 focus:ring-1 focus:ring-primary/20 focus:border-primary outline-none transition-all appearance-none cursor-pointer'
  $c = $c -replace 'premium-table-title-bar', 'px-5 py-3 flex items-center gap-2 border-b border-gray-100 bg-background/50'
  $c = $c -replace 'premium-table-title', 'text-[13px] font-black text-primary-dark uppercase tracking-wider'
  $c = $c -replace 'premium-data-table', 'w-full whitespace-nowrap text-left'
  $c = $c -replace 'premium-pagination-container', 'px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4'
  $c = $c -replace 'premium-pagination-info[^"]*', 'text-[11px] font-black text-gray-400 uppercase tracking-widest'
  $c = $c -replace 'btn-pagination btn-pagination-disabled', 'w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-300 cursor-not-allowed shadow-sm'
  $c = $c -replace 'btn-pagination btn-pagination-active', 'w-8 h-8 flex items-center justify-center rounded-lg bg-primary text-white font-black text-xs shadow-md shadow-primary/20'
  $c = $c -replace 'btn-pagination btn-pagination-inactive', 'w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-400 hover:bg-gray-50 transition-all shadow-sm'
  $c = $c -replace 'premium-badge-active', 'text-[12px] font-semibold text-primary-dark capitalize'
  $c = $c -replace 'premium-badge-inactive', 'text-[12px] font-semibold text-gray-400 capitalize'
  $c = $c -replace 'premium-badge[^"]*', 'text-[12px] font-semibold text-primary-dark capitalize'
  $c = $c -replace 'premium-status-badge[^"]*', 'text-[12px] font-semibold text-primary-dark capitalize'
  $c = $c -replace 'btn-premium-primary group uppercase', 'flex items-center gap-2 px-5 py-2.5 bg-primary text-white font-semibold rounded-[0.5rem] hover:bg-primary-dark transition-all text-[13px] shadow-sm uppercase'
  $c = $c -replace 'btn-premium-primary group', 'flex items-center gap-2 px-5 py-2.5 bg-primary text-white font-semibold rounded-[0.5rem] hover:bg-primary-dark transition-all text-[13px] shadow-sm'
  $c = $c -replace 'btn-premium-primary', 'flex items-center gap-2 px-6 py-2.5 bg-primary text-white font-bold rounded-lg hover:bg-primary-dark transition-all text-[13px] shadow-sm'
  $c = $c -replace 'btn-premium-accent', 'px-5 py-2.5 bg-white border border-gray-200 text-gray-600 font-semibold rounded-lg hover:bg-gray-50 transition-all text-[13px] shadow-sm'
  $c = $c -replace 'btn-premium-outline', 'flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 text-primary font-semibold rounded-[0.5rem] hover:bg-gray-50 transition-all text-[13px] shadow-sm'
  $c = $c -replace 'premium-modal-box max-w-4xl', 'bg-white rounded-[1.25rem] w-full max-w-4xl max-h-[90vh] overflow-hidden shadow-2xl flex flex-col relative'
  $c = $c -replace 'premium-modal-box max-w-2xl', 'bg-white rounded-[1.25rem] w-full max-w-2xl max-h-[90vh] overflow-hidden shadow-2xl flex flex-col relative'
  $c = $c -replace 'premium-modal-box', 'bg-white rounded-[1.25rem] w-full max-w-2xl max-h-[90vh] overflow-hidden shadow-2xl flex flex-col relative'
  $c = $c -replace 'premium-modal-overlay', 'fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm'
  $c = $c -replace 'premium-modal-header', 'px-6 py-6 bg-primary relative overflow-hidden shrink-0'
  $c = $c -replace 'premium-modal-header-content', 'flex items-center justify-between relative z-10'
  $c = $c -replace 'premium-modal-title-group', 'flex items-center gap-4'
  $c = $c -replace 'premium-modal-icon-box', 'w-12 h-12 bg-white/10 border border-white/10 rounded-xl flex items-center justify-center text-xl shadow-inner backdrop-blur-md text-white'
  $c = $c -replace 'premium-modal-close-btn', 'w-8 h-8 bg-white/10 border border-white/10 text-white rounded-lg hover:bg-white/20 transition-all flex items-center justify-center shadow-sm'
  $c = $c -replace 'premium-modal-body', 'px-6 py-6 overflow-y-auto custom-scrollbar flex-grow bg-white'
  $c = $c -replace 'premium-modal-footer', 'px-6 py-4 border-t border-gray-100 bg-gray-50/80 flex items-center justify-between'
  $c = $c -replace 'premium-form-group', 'space-y-1.5'
  $c = $c -replace 'premium-form-label', 'text-[11px] font-bold text-gray-700 uppercase tracking-wider'
  $c = $c -replace 'premium-form-input', 'w-full pl-4 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-[13px] font-medium text-gray-700 focus:bg-white focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none transition-all'
  $c = $c -replace 'premium-form-icon-input', 'w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-[13px] font-medium text-gray-700 focus:bg-white focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none transition-all'
  $c = $c -replace 'premium-input-icon', 'absolute right-4 top-1/2 -translate-y-1/2 text-gray-400'
  Set-Content $f $c -Encoding UTF8
  Write-Output "Done: $f"
}
