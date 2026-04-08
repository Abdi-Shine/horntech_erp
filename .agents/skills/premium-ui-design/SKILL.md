---
name: Premium UI Design
description: Strict guidelines and standards for building and refactoring Blade UI views using the application's global premium CSS classes.
---

# Premium UI Design Language

When creating or modifying Blade views, forms, tables, and modals in this application, you **MUST strictly follow** the established "Premium Design Language." This ensures a consistent, high-quality, and modern UI across the entire application.

**CRITICAL RULE: DO NOT USE INLINE CSS.** All structural and aesthetic styling must come from Tailwind utility classes or custom global classes defined in `resources/css/app.css`.

---

## 1. Page Structure & Headers

Every page should be wrapped in a container that handles the background and spacing:
```html
<div class="px-4 py-8 md:px-8 md:py-10 bg-background min-h-screen">
    <!-- Page Content here -->
</div>
```

**Page Headers** must use `.premium-page-header`. Action buttons go on the right side.
```html
<div class="premium-page-header animate-in fade-in slide-in-from-top-4 duration-500">
    <div>
        <h1 class="text-[20px] font-bold text-primary-dark">Page Title</h1>
    </div>
    <div class="flex items-center gap-3">
        <!-- Buttons here -->
    </div>
</div>
```

---

## 2. Buttons

Always use the standard global button classes instead of manual padding/colors:
- **Primary Actions:** `.btn-premium-primary` (Dark blue primary color)
- **Secondary/Accent Actions:** `.btn-premium-accent` (Light green accent color)
- **Outline Buttons:** `.btn-premium-outline` (White background, light border)

```html
<button class="btn-premium-primary">
    <i class="bi bi-plus-lg"></i> Add Item
</button>
<button class="btn-premium-accent">
    <i class="bi bi-check2-circle"></i> Save
</button>
<button class="btn-premium-outline">Cancel</button>
```

---

## 3. KPI / Stats Cards

Whenever presenting summary metrics at the top of a page, use the `.premium-stats-grid` and `.premium-stats-card`.

```html
<div class="premium-stats-grid">
    <div class="premium-stats-card group">
        <div>
            <p class="premium-stats-label">Total Customers</p>
            <h3 class="premium-stats-value">1,234</h3>
            <p class="premium-stats-subtext">
                <i class="bi bi-arrow-up"></i> 12% from last month
            </p>
        </div>
        <!-- Note: Use relevant colors for the icon box, e.g., bg-primary/10 text-primary -->
        <div class="premium-stats-icon-box bg-primary/10 text-primary group-hover:bg-primary group-hover:text-white">
            <i class="bi bi-people text-lg"></i>
        </div>
    </div>
    <!-- Additional cards... -->
</div>
```

---

## 4. Tables and Filters

All data tables must be placed inside a `.premium-filter-container`.

### Filters
Wrap filters in `.premium-filter-bar`. Inputs must use `.premium-input-search` and `.premium-input-select`.
```html
<div class="premium-filter-container">
    <div class="premium-filter-bar">
        <!-- Search Input -->
        <div class="relative group min-w-[250px] flex-1">
            <i class="bi bi-search absolute left-3.5 top-1/2 -translate-y-1/2"></i>
            <input type="text" placeholder="Search..." class="premium-input-search">
        </div>
        <!-- Select Filter -->
        <div class="relative min-w-[150px]">
            <select class="premium-input-select">
                <option value="">All Status</option>
            </select>
        </div>
    </div>

    <!-- Table Title -->
    <div class="premium-table-title-bar">
        <i class="bi bi-list-ul text-primary-dark text-sm"></i>
        <h2 class="premium-table-title">Item List</h2>
    </div>

    <!-- The actual table -->
    <div class="overflow-x-auto">
        <table class="premium-data-table">
            <thead>
                <tr>
                    <th class="w-16 text-center">#</th>
                    <th>Name</th>
                    <th class="text-center">Status</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <!-- Rows go here -->
            </tbody>
        </table>
    </div>
</div>
```

### Table Action Buttons
Inside the `<td>` for actions, use the specific `.btn-action-*` classes:
- View: `.btn-action-view` (Blue tint)
- Edit: `.btn-action-edit` (Green tint)
- Delete: `.btn-action-delete` (Red tint)

```html
<div class="flex items-center justify-end gap-1">
    <a href="..." class="btn-action-view"><i class="bi bi-eye"></i></a>
    <button class="btn-action-edit"><i class="bi bi-pencil"></i></button>
    <button class="btn-action-delete"><i class="bi bi-trash3"></i></button>
</div>
```

### Empty States (No data)
```html
<tr>
    <td colspan="10" class="px-5 py-16 text-center text-gray-400">
        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
            <i class="bi bi-inbox text-2xl"></i>
        </div>
        <p class="text-[13px] font-bold uppercase tracking-widest text-gray-400">No records found</p>
    </td>
</tr>
```

---

## 5. Forms (Inside Modals or Pages)

For forms, use the `.premium-form-group`, `.premium-form-label`, and `.premium-form-input` classes.
For inputs with icons, use `.premium-form-icon-input`.

```html
<div class="premium-form-group">
    <label class="premium-form-label">Full Name <span class="text-rose-500">*</span></label>
    <div class="relative group">
        <input type="text" class="premium-form-icon-input" required>
        <i class="bi bi-person premium-input-icon"></i>
    </div>
</div>

<div class="premium-form-group">
    <label class="premium-form-label">Category</label>
    <select class="premium-input-select">
        <option>Option 1</option>
    </select>
</div>
```

---

## 6. Modals (AlpineJS)

Use AlpineJS (`x-show`, `x-data`) for toggling modals. The modal must use the structured overlays and boxes:
- Overlay: `.premium-modal-overlay`
- Box: `.premium-modal-box`
- Header: `.premium-modal-header`
- Content: `.premium-modal-header-content`
- Body: `.premium-modal-body`
- Footer: `.premium-modal-footer`

```html
<div class="premium-modal-overlay">
    <div class="premium-modal-box max-w-4xl">
        <div class="premium-modal-header">
            <div class="premium-modal-header-content">
                <div class="premium-modal-title-group">
                    <div class="premium-modal-icon-box">
                        <i class="bi bi-person-plus"></i>
                    </div>
                    <div class="flex flex-col">
                        <h2 class="text-xl font-bold tracking-tight text-white">Modal Title</h2>
                        <p class="text-xs text-blue-100/70 font-medium mt-0.5">Subtitle text here</p>
                    </div>
                </div>
                <!-- Close Button -->
                <button class="premium-modal-close-btn"><i class="bi bi-x-lg text-xs"></i></button>
            </div>
        </div>

        <div class="premium-modal-body">
            <!-- Form content goes here -->
        </div>

        <div class="premium-modal-footer flex justify-between">
            <button type="button" class="btn-premium-accent">Cancel</button>
            <button type="submit" class="btn-premium-primary">Save changes</button>
        </div>
    </div>
</div>
```

---

## 7. Status Badges
Instead of random span colors, use the global premium status badges:
- `<span class="premium-status-badge status-completed">Completed</span>`
- `<span class="premium-status-badge status-pending">Pending</span>`
- `<span class="premium-status-badge status-rejected">Rejected</span>`

There are also predefined utility classes like `.report-premium-badge-success`, `.report-premium-badge-error`, `.report-premium-badge-warning`, and `.report-premium-badge-info`.
