<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Party Statement - Horntech LTD</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #004161;
            --secondary-color: #99CC33;
            --primary-dark: #002d47;
            --sidebar-width: 260px;
            --header-height: 70px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: #f8f9fa;
            overflow-x: hidden;
        }
        
        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            z-index: 1000;
            transition: transform 0.3s ease;
            overflow-y: auto;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }
        
        .sidebar-brand {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-brand a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
        }
        
        .sidebar-logo {
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        
        .sidebar-logo svg {
            width: 24px;
            height: 24px;
            fill: var(--primary-color);
        }
        
        .sidebar-brand-text {
            font-size: 1.25rem;
            font-weight: 700;
            color: white;
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 1rem 0;
        }
        
        .sidebar-menu-item {
            margin-bottom: 0.25rem;
        }
        
        .sidebar-menu-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem 1.25rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .sidebar-menu-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        .sidebar-menu-link.active {
            background: var(--secondary-color);
            color: var(--primary-dark);
            font-weight: 600;
        }
        
        .sidebar-menu-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: white;
        }
        
        /* Header Styles */
        .header {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--header-height);
            background: white;
            z-index: 999;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            transition: left 0.3s ease;
        }
        
        .header-left {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        
        .header-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0;
        }
        
        .header-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        
        .header-search {
            position: relative;
        }
        
        .header-search input {
            width: 300px;
            padding: 0.625rem 1rem 0.625rem 2.5rem;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: all 0.3s;
        }
        
        .header-search input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 65, 97, 0.1);
        }
        
        .header-search i {
            position: absolute;
            left: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }
        
        .header-icon-btn {
            position: relative;
            background: none;
            border: none;
            font-size: 1.25rem;
            color: #6c757d;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .header-icon-btn:hover {
            background: #f8f9fa;
            color: var(--primary-color);
        }
        
        .header-icon-btn .badge {
            position: absolute;
            top: 0.25rem;
            right: 0.25rem;
            padding: 0.25rem 0.4rem;
            font-size: 0.65rem;
        }
        
        .user-menu {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            transition: background 0.3s;
        }
        
        .user-menu:hover {
            background: #f8f9fa;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--secondary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-dark);
            font-weight: 600;
            flex-shrink: 0;
        }
        
        .user-info h6 {
            margin: 0;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .user-info p {
            margin: 0;
            font-size: 0.75rem;
            color: #6c757d;
        }
        
        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--header-height);
            padding: 2rem;
            min-height: calc(100vh - var(--header-height));
            transition: margin-left 0.3s ease;
        }
        
        /* Page Header */
        .page-header {
            margin-bottom: 2rem;
        }
        
        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.25rem;
        }
        
        .page-subtitle {
            color: #6c757d;
            font-size: 0.95rem;
        }
        
        /* Stats Cards */
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            border: 1px solid transparent;
        }
        
        .stat-card:hover {
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        
        .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }
        
        .stat-label {
            color: #6c757d;
            font-size: 0.875rem;
        }
        
        /* Card */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            background: white;
            border-bottom: 2px solid #f8f9fa;
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
            border-radius: 12px 12px 0 0 !important;
        }
        
        /* Buttons */
        .btn-primary {
            background: var(--primary-color);
            border: none;
            padding: 0.625rem 1.25rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 65, 97, 0.3);
        }
        
        .btn-success {
            background: var(--secondary-color);
            color: var(--primary-dark);
            border: none;
            padding: 0.625rem 1.25rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-success:hover {
            background: #88bb22;
            color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(153, 204, 51, 0.3);
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            padding: 0.625rem 1.25rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-outline-primary:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }
        
        /* Form Controls */
        .form-control, .form-select {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 0.625rem 1rem;
            transition: all 0.3s;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 65, 97, 0.1);
        }
        
        /* Table */
        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
        }
        
        .table {
            margin: 0;
        }
        
        .table thead th {
            background: #f8f9fa;
            color: var(--primary-color);
            font-weight: 600;
            border: none;
            padding: 1rem;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }
        
        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f8f9fa;
        }
        
        .table tbody tr {
            transition: all 0.3s;
        }
        
        .table tbody tr:hover {
            background: #f8f9fa;
        }
        
        .table tfoot td {
            background: #f8f9fa;
            font-weight: 700;
            padding: 1rem;
            border-top: 2px solid #dee2e6;
        }
        
        /* Filter Icon */
        .filter-icon {
            cursor: pointer;
            color: #6c757d;
            font-size: 0.875rem;
            margin-left: 0.5rem;
            transition: color 0.3s;
        }
        
        .filter-icon:hover {
            color: var(--primary-color);
        }
        
        /* Text Alignment */
        .text-end {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        /* Amount Colors */
        .debit-amount {
            color: #dc3545;
            font-weight: 600;
        }
        
        .credit-amount {
            color: #28a745;
            font-weight: 600;
        }
        
        /* Badge */
        .badge {
            padding: 0.35rem 0.75rem;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.75rem;
        }
        
        /* Party Statement Summary */
        .statement-summary {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1.5rem;
            border: 1px solid #dee2e6;
        }
        
        .summary-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #dee2e6;
        }
        
        .summary-items {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }
        
        .summary-item {
            display: flex;
            flex-direction: column;
        }
        
        .summary-label {
            font-size: 0.875rem;
            color: #6c757d;
            margin-bottom: 0.25rem;
        }
        
        .summary-sublabel {
            font-size: 0.75rem;
            color: #adb5bd;
        }
        
        .summary-value {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary-color);
        }
        
        .receivable-box {
            background: linear-gradient(135deg, var(--secondary-color), #88bb22);
            padding: 1rem 1.5rem;
            border-radius: 8px;
            text-align: center;
            color: white;
        }
        
        .receivable-box .label {
            font-size: 0.875rem;
            opacity: 0.9;
            margin-bottom: 0.25rem;
        }
        
        .receivable-box .value {
            font-size: 1.75rem;
            font-weight: 700;
        }
        
        /* No Data State */
        .no-data {
            text-align: center;
            padding: 4rem 2rem;
            color: #6c757d;
        }
        
        .no-data i {
            font-size: 4rem;
            opacity: 0.3;
            margin-bottom: 1rem;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .header {
                left: 0;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .header-search input {
                width: 200px;
            }
        }
        
        @media (max-width: 768px) {
            .header {
                padding: 0 1rem;
            }
            
            .main-content {
                padding: 1rem;
            }
            
            .header-search {
                display: none;
            }
            
            .user-info {
                display: none;
            }
            
            .stat-card {
                margin-bottom: 1rem;
            }
        }
        
        @media print {
            .sidebar, .header, .no-print {
                display: none !important;
            }
            
            .main-content {
                margin-left: 0;
                margin-top: 0;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <a href="dashboard-horntech.html">
                <div class="sidebar-logo">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20 6h-2.18c.11-.31.18-.65.18-1 0-1.66-1.34-3-3-3-1.05 0-1.96.54-2.5 1.35l-.5.67-.5-.68C10.96 2.54 10.05 2 9 2 7.34 2 6 3.34 6 5c0 .35.07.69.18 1H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-5-2c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zM9 4c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm11 15H4v-2h16v2zm0-5H4V8h5.08L7 10.83 8.62 12 11 8.76l1-1.36 1 1.36L15.38 12 17 10.83 14.92 8H20v6z"/>
                    </svg>
                </div>
                <span class="sidebar-brand-text">Horntech LTD</span>
            </a>
        </div>
        
        <ul class="sidebar-menu">
            <li class="sidebar-menu-item">
                <a href="dashboard-horntech.html" class="sidebar-menu-link">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="inventory-products-horntech.html" class="sidebar-menu-link">
                    <i class="bi bi-box-seam"></i>
                    <span>Products</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="sale-invoices-list-horntech.html" class="sidebar-menu-link">
                    <i class="bi bi-receipt"></i>
                    <span>Sales</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="purchase-bills-horntech.html" class="sidebar-menu-link">
                    <i class="bi bi-cart3"></i>
                    <span>Purchases</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="customers-horntech.html" class="sidebar-menu-link">
                    <i class="bi bi-people"></i>
                    <span>Customers</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="suppliers-horntech.html" class="sidebar-menu-link">
                    <i class="bi bi-truck"></i>
                    <span>Suppliers</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="expenses-horntech.html" class="sidebar-menu-link">
                    <i class="bi bi-cash-coin"></i>
                    <span>Expenses</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="reports-dashboard-horntech.html" class="sidebar-menu-link active">
                    <i class="bi bi-bar-chart"></i>
                    <span>Reports</span>
                </a>
            </li>
        </ul>
    </aside>
    
    <!-- Header -->
    <header class="header">
        <div class="header-left">
            <button class="menu-toggle" id="menuToggle" style="display: none;">
                <i class="bi bi-list"></i>
            </button>
            <h1 class="header-title">Party Statement</h1>
        </div>
        
        <div class="header-right">
            <div class="header-search">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Search...">
            </div>
            
            <button class="header-icon-btn">
                <i class="bi bi-bell"></i>
                <span class="badge bg-danger">3</span>
            </button>
            
            <div class="user-menu">
                <div class="user-avatar">AH</div>
                <div class="user-info">
                    <h6>Ahmed Hassan</h6>
                    <p>Administrator</p>
                </div>
                <i class="bi bi-chevron-down"></i>
            </div>
        </div>
    </header>
    
    <!-- Main Content -->
    <main class="main-content">
        <!-- Page Header -->
        <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="page-title">Party Statement</h1>
                <p class="page-subtitle">Detailed transaction ledger for customers and suppliers</p>
            </div>
            <div class="d-flex gap-2 flex-wrap no-print">
                <button class="btn btn-outline-primary" onclick="window.print()">
                    <i class="bi bi-printer me-2"></i>Print
                </button>
                <button class="btn btn-success">
                    <i class="bi bi-file-earmark-excel me-2"></i>Export Excel
                </button>
                <button class="btn btn-primary">
                    <i class="bi bi-file-earmark-pdf me-2"></i>Export PDF
                </button>
            </div>
        </div>
        
        <!-- Stats Row -->
        <div class="row g-3 mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Total Receivable</div>
                            <div class="stat-value text-accent">SAR 45,670</div>
                            <small class="text-muted">Amount to collect</small>
                        </div>
                        <div class="stat-icon" style="background: rgba(40, 167, 69, 0.1); color: #28a745;">
                            <i class="bi bi-arrow-down-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Total Payable</div>
                            <div class="stat-value text-danger">SAR 28,450</div>
                            <small class="text-muted">Amount to pay</small>
                        </div>
                        <div class="stat-icon" style="background: rgba(220, 53, 69, 0.1); color: #dc3545;">
                            <i class="bi bi-arrow-up-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Total Transactions</div>
                            <div class="stat-value" style="color: var(--primary-color);">156</div>
                            <small class="text-muted">This period</small>
                        </div>
                        <div class="stat-icon" style="background: rgba(0, 65, 97, 0.1); color: var(--primary-color);">
                            <i class="bi bi-receipt"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Active Parties</div>
                            <div class="stat-value" style="color: var(--secondary-color);">87</div>
                            <small class="text-muted">Customers & Suppliers</small>
                        </div>
                        <div class="stat-icon" style="background: rgba(153, 204, 51, 0.1); color: var(--secondary-color);">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Filter Section -->
        <div class="card mb-4 no-print">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Party Type</label>
                        <select class="form-select">
                            <option selected>All Parties</option>
                            <option>Customers</option>
                            <option>Suppliers</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Select Party</label>
                        <select class="form-select">
                            <option selected>Mohammed Ali Trading</option>
                            <option>Fatima Ahmad Store</option>
                            <option>Abdullah Electronics</option>
                            <option>Modern Tech Suppliers</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">From Date</label>
                        <input type="date" class="form-control" value="2026-01-01">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">To Date</label>
                        <input type="date" class="form-control" value="2026-03-08">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <button class="btn btn-primary w-100">
                            <i class="bi bi-search me-2"></i>Search
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Statement Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-journal-text me-2"></i>Mohammed Ali Trading - Account Statement</span>
                <span class="badge bg-primary">Customer</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>
                                    DATE
                                    <i class="bi bi-funnel filter-icon"></i>
                                </th>
                                <th>
                                    TXN TYPE
                                    <i class="bi bi-funnel filter-icon"></i>
                                </th>
                                <th>
                                    REF NO.
                                    <i class="bi bi-funnel filter-icon"></i>
                                </th>
                                <th>
                                    PAYMENT
                                    <i class="bi bi-funnel filter-icon"></i>
                                </th>
                                <th class="text-end">
                                    DEBIT
                                    <i class="bi bi-funnel filter-icon"></i>
                                </th>
                                <th class="text-end">
                                    CREDIT
                                    <i class="bi bi-funnel filter-icon"></i>
                                </th>
                                <th class="text-end">
                                    RUNNING BALANCE
                                    <i class="bi bi-funnel filter-icon"></i>
                                </th>
                                <th class="text-center">
                                    PRINT
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>05-Jan-2026</td>
                                <td>
                                    <span class="badge bg-accent/10">Sale</span>
                                </td>
                                <td>INV-2026-001</td>
                                <td>-</td>
                                <td class="text-end debit-amount">12,450.00</td>
                                <td class="text-end">-</td>
                                <td class="text-end">12,450.00 Dr</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-printer"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>08-Jan-2026</td>
                                <td>
                                    <span class="badge bg-primary/10">Payment In</span>
                                </td>
                                <td>REC-2026-003</td>
                                <td>Cash</td>
                                <td class="text-end">-</td>
                                <td class="text-end credit-amount">5,000.00</td>
                                <td class="text-end">7,450.00 Dr</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-printer"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>15-Jan-2026</td>
                                <td>
                                    <span class="badge bg-accent/10">Sale</span>
                                </td>
                                <td>INV-2026-012</td>
                                <td>-</td>
                                <td class="text-end debit-amount">18,750.00</td>
                                <td class="text-end">-</td>
                                <td class="text-end">26,200.00 Dr</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-printer"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>22-Jan-2026</td>
                                <td>
                                    <span class="badge bg-primary/10">Payment In</span>
                                </td>
                                <td>REC-2026-015</td>
                                <td>Bank Transfer</td>
                                <td class="text-end">-</td>
                                <td class="text-end credit-amount">10,000.00</td>
                                <td class="text-end">16,200.00 Dr</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-printer"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>28-Jan-2026</td>
                                <td>
                                    <span class="badge bg-primary/10 text-dark">Sale Return</span>
                                </td>
                                <td>SRN-2026-002</td>
                                <td>-</td>
                                <td class="text-end">-</td>
                                <td class="text-end credit-amount">1,250.00</td>
                                <td class="text-end">14,950.00 Dr</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-printer"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>05-Feb-2026</td>
                                <td>
                                    <span class="badge bg-accent/10">Sale</span>
                                </td>
                                <td>INV-2026-025</td>
                                <td>-</td>
                                <td class="text-end debit-amount">24,560.00</td>
                                <td class="text-end">-</td>
                                <td class="text-end">39,510.00 Dr</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-printer"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>12-Feb-2026</td>
                                <td>
                                    <span class="badge bg-primary/10">Payment In</span>
                                </td>
                                <td>REC-2026-028</td>
                                <td>Cash</td>
                                <td class="text-end">-</td>
                                <td class="text-end credit-amount">20,000.00</td>
                                <td class="text-end">19,510.00 Dr</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-printer"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>28-Feb-2026</td>
                                <td>
                                    <span class="badge bg-accent/10">Sale</span>
                                </td>
                                <td>INV-2026-042</td>
                                <td>-</td>
                                <td class="text-end debit-amount">32,160.00</td>
                                <td class="text-end">-</td>
                                <td class="text-end">51,670.00 Dr</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-printer"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>05-Mar-2026</td>
                                <td>
                                    <span class="badge bg-primary/10">Payment In</span>
                                </td>
                                <td>REC-2026-051</td>
                                <td>Bank Transfer</td>
                                <td class="text-end">-</td>
                                <td class="text-end credit-amount">6,000.00</td>
                                <td class="text-end">45,670.00 Dr</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-printer"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4"><strong>Total</strong></td>
                                <td class="text-end debit-amount"><strong>SAR 87,920.00</strong></td>
                                <td class="text-end credit-amount"><strong>SAR 42,250.00</strong></td>
                                <td class="text-end"><strong>SAR 45,670.00 (Dr)</strong></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Party Statement Summary -->
        <div class="statement-summary">
            <div class="summary-header">
                <h5 class="mb-0" style="color: var(--primary-color);">
                    <i class="bi bi-file-earmark-text me-2"></i>Party Statement Summary
                </h5>
                <button class="btn btn-sm btn-outline-primary" type="button">
                    <i class="bi bi-chevron-down"></i>
                </button>
            </div>
            
            <div class="row">
                <div class="col-lg-9">
                    <div class="summary-items">
                        <div class="summary-item">
                            <div class="summary-label">
                                Total Sale: <strong>SAR 87,920.00</strong>
                            </div>
                            <div class="summary-sublabel">(Sale - Sale Return)</div>
                        </div>
                        
                        <div class="summary-item">
                            <div class="summary-label">
                                Total Purchase: <strong>SAR 0.00</strong>
                            </div>
                            <div class="summary-sublabel">(Purchase - Purchase Return)</div>
                        </div>
                        
                        <div class="summary-item">
                            <div class="summary-label">
                                Total Expense: <strong>SAR 0.00</strong>
                            </div>
                            <div class="summary-sublabel">&nbsp;</div>
                        </div>
                        
                        <div class="summary-item">
                            <div class="summary-label">
                                Total Money-In: <strong>SAR 42,250.00</strong>
                            </div>
                            <div class="summary-sublabel">&nbsp;</div>
                        </div>
                        
                        <div class="summary-item">
                            <div class="summary-label">
                                Total Money-out: <strong>SAR 0.00</strong>
                            </div>
                            <div class="summary-sublabel">&nbsp;</div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3">
                    <div class="receivable-box">
                        <div class="label">Total Receivable</div>
                        <div class="value">SAR 45,670.00</div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Menu Toggle for Mobile
        document.getElementById('menuToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('show');
        });
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            const sidebar = document.getElementById('sidebar');
            const menuToggle = document.getElementById('menuToggle');
            
            if (window.innerWidth <= 992) {
                if (!sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                    sidebar.classList.remove('show');
                }
            }
        });
    </script>
</body>
</html>

