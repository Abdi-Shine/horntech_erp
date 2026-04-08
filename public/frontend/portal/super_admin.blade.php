<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard - Horntech LTD SaaS</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
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
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: #f8f9fa;
            overflow-x: hidden;
        }
        
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            z-index: 1000;
            overflow-y: auto;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
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
            padding: 0.75rem 1.25rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }
        
        .sidebar-menu-link:hover,
        .sidebar-menu-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: var(--secondary-color);
        }
        
        /* Header */
        .header {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--header-height);
            background: white;
            z-index: 999;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            padding: 0 2rem;
        }
        
        .header-search input {
            width: 400px;
            padding: 0.625rem 1rem 0.625rem 2.75rem;
            border: 1px solid #dee2e6;
            border-radius: 8px;
        }
        
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--header-height);
            padding: 2rem;
            min-height: calc(100vh - var(--header-height));
        }
        
        /* Stats Cards */
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            height: 100%;
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
            margin-bottom: 1rem;
        }
        
        .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }
        
        .stat-label {
            color: #6c757d;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }
        
        .stat-change {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .stat-change.positive {
            color: #28a745;
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
        
        /* Table */
        .table thead th {
            background: #f8f9fa;
            color: var(--primary-color);
            font-weight: 600;
            border: none;
            padding: 1rem;
            font-size: 0.875rem;
            text-transform: uppercase;
        }
        
        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f8f9fa;
        }
        
        .badge {
            padding: 0.35rem 0.75rem;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.75rem;
        }
        
        .action-btn {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .page-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.25rem;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <a href="#">
                <div class="sidebar-logo">
                    <svg viewBox="0 0 24 24" fill="var(--primary-color)">
                        <path d="M20 6h-2.18c.11-.31.18-.65.18-1 0-1.66-1.34-3-3-3-1.05 0-1.96.54-2.5 1.35l-.5.67-.5-.68C10.96 2.54 10.05 2 9 2 7.34 2 6 3.34 6 5c0 .35.07.69.18 1H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-5-2c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zM9 4c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm11 15H4v-2h16v2zm0-5H4V8h5.08L7 10.83 8.62 12 11 8.76l1-1.36 1 1.36L15.38 12 17 10.83 14.92 8H20v6z"/>
                    </svg>
                </div>
                <span class="sidebar-brand-text">Super Admin</span>
            </a>
        </div>
        
        <ul class="sidebar-menu">
            <li class="sidebar-menu-item">
                <a href="#" class="sidebar-menu-link active">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="#" class="sidebar-menu-link">
                    <i class="bi bi-building"></i>
                    <span>Companies</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="#" class="sidebar-menu-link">
                    <i class="bi bi-people"></i>
                    <span>Users</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="#" class="sidebar-menu-link">
                    <i class="bi bi-credit-card"></i>
                    <span>Subscriptions</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="#" class="sidebar-menu-link">
                    <i class="bi bi-cash-stack"></i>
                    <span>Payments</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="#" class="sidebar-menu-link">
                    <i class="bi bi-tags"></i>
                    <span>Pricing Plans</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="#" class="sidebar-menu-link">
                    <i class="bi bi-calendar-check"></i>
                    <span>Demo Requests</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="#" class="sidebar-menu-link">
                    <i class="bi bi-file-earmark-bar-graph"></i>
                    <span>Reports</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="#" class="sidebar-menu-link">
                    <i class="bi bi-gear"></i>
                    <span>Settings</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Header -->
    <header class="header">
        <div class="header-search">
            <i class="bi bi-search position-absolute" style="left: 1rem; top: 50%; transform: translateY(-50%); color: #6c757d;"></i>
            <input type="text" class="form-control" placeholder="Search companies, users, subscriptions...">
        </div>
        
        <div class="ms-auto d-flex align-items-center gap-3">
            <button class="btn btn-sm btn-outline-primary">
                <i class="bi bi-bell me-2"></i>
                <span class="badge bg-danger">8</span>
            </button>
            <div class="d-flex align-items-center gap-2">
                <div style="width: 40px; height: 40px; background: var(--secondary-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--primary-dark); font-weight: 600;">
                    SA
                </div>
                <div>
                    <div style="font-weight: 600; font-size: 0.9rem;">Super Admin</div>
                    <div style="font-size: 0.75rem; color: #6c757d;">System Administrator</div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="page-title">Platform Overview</h1>
                <p class="text-muted">Monitor and manage your entire ERP SaaS platform</p>
            </div>
            <div>
                <button class="btn btn-primary">
                    <i class="bi bi-download me-2"></i>Export Report
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(0, 123, 255, 0.1); color: #007bff;">
                        <i class="bi bi-building"></i>
                    </div>
                    <div class="stat-value" style="color: #007bff;">487</div>
                    <div class="stat-label">Active Companies</div>
                    <div class="stat-change positive">
                        <i class="bi bi-arrow-up"></i>
                        <span>+23 this month</span>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(153, 204, 51, 0.1); color: #99CC33;">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div class="stat-value" style="color: #99CC33;">SAR 142.8K</div>
                    <div class="stat-label">Monthly Revenue</div>
                    <div class="stat-change positive">
                        <i class="bi bi-arrow-up"></i>
                        <span>+15.3% vs last month</span>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(255, 193, 7, 0.1); color: #ffc107;">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="stat-value" style="color: #ffc107;">2,845</div>
                    <div class="stat-label">Total Users</div>
                    <div class="stat-change positive">
                        <i class="bi bi-arrow-up"></i>
                        <span>+187 this month</span>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(220, 53, 69, 0.1); color: #dc3545;">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <div class="stat-value" style="color: #dc3545;">12</div>
                    <div class="stat-label">Expiring Soon</div>
                    <div class="stat-change">
                        <span class="text-muted">Next 7 days</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Companies -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-building me-2"></i>Recent Companies</h5>
                <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Company</th>
                                <th>Plan</th>
                                <th>Users</th>
                                <th>Status</th>
                                <th>Revenue</th>
                                <th>Joined</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="width: 40px; height: 40px; background: #e3f2fd; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 600; color: #1565c0;">AT</div>
                                        <div>
                                            <div class="fw-bold">Al-Tijara Corp</div>
                                            <small class="text-muted">VAT: 300123456789003</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-success">Business</span></td>
                                <td>15 / 20</td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td class="fw-bold">SAR 899</td>
                                <td>Jan 15, 2026</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <button class="action-btn" style="background: rgba(0, 65, 97, 0.1); color: var(--primary-color);">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="action-btn" style="background: rgba(153, 204, 51, 0.1); color: var(--secondary-color);">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="width: 40px; height: 40px; background: #f3e5f5; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 600; color: #6a1b9a;">ME</div>
                                        <div>
                                            <div class="fw-bold">Modern Electronics Ltd</div>
                                            <small class="text-muted">VAT: 300987654321009</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-primary">Starter</span></td>
                                <td>3 / 5</td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td class="fw-bold">SAR 299</td>
                                <td>Feb 22, 2026</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <button class="action-btn" style="background: rgba(0, 65, 97, 0.1); color: var(--primary-color);">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="action-btn" style="background: rgba(153, 204, 51, 0.1); color: var(--secondary-color);">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="width: 40px; height: 40px; background: #fff3e0; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 600; color: #e65100;">GT</div>
                                        <div>
                                            <div class="fw-bold">Global Trading Co</div>
                                            <small class="text-muted">VAT: 300555666777008</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-warning text-dark">Enterprise</span></td>
                                <td>45 / ∞</td>
                                <td><span class="badge bg-warning">Expiring Soon</span></td>
                                <td class="fw-bold">SAR 2,499</td>
                                <td>Oct 10, 2025</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <button class="action-btn" style="background: rgba(0, 65, 97, 0.1); color: var(--primary-color);">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="action-btn" style="background: rgba(153, 204, 51, 0.1); color: var(--secondary-color);">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Revenue Trend</h5>
                    </div>
                    <div class="card-body">
                        <div style="height: 300px; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 8px;">
                            <div class="text-center">
                                <i class="bi bi-bar-chart-line" style="font-size: 4rem; color: #dee2e6;"></i>
                                <p class="text-muted mt-2">Revenue chart would be displayed here</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-pie-chart me-2"></i>Plan Distribution</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Starter</span>
                                <strong>245 (50%)</strong>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar" style="width: 50%; background: var(--primary-color);"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Business</span>
                                <strong>185 (38%)</strong>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar" style="width: 38%; background: var(--secondary-color);"></div>
                            </div>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Enterprise</span>
                                <strong>57 (12%)</strong>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-warning" style="width: 12%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
