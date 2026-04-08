<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Plans - Horntech LTD</title>
    
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
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }
        
        .page-subtitle {
            color: #6c757d;
            font-size: 1.1rem;
            max-width: 700px;
            margin: 0 auto;
        }
        
        /* Pricing Cards */
        .pricing-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s;
            border: 3px solid transparent;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .pricing-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }
        
        .pricing-card.popular {
            border-color: var(--secondary-color);
            position: relative;
        }
        
        .popular-badge {
            position: absolute;
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--secondary-color);
            color: var(--primary-dark);
            padding: 0.5rem 1.5rem;
            border-radius: 20px;
            font-weight: 700;
            font-size: 0.85rem;
            box-shadow: 0 4px 12px rgba(153, 204, 51, 0.3);
        }
        
        .pricing-card.enterprise {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
        }
        
        .pricing-card.enterprise .plan-name,
        .pricing-card.enterprise .plan-description,
        .pricing-card.enterprise .feature-item {
            color: white;
        }
        
        .pricing-card.enterprise .feature-item i {
            color: var(--secondary-color);
        }
        
        .plan-name {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }
        
        .plan-description {
            color: #6c757d;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }
        
        .price-container {
            margin-bottom: 1.5rem;
        }
        
        .price {
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary-color);
            line-height: 1;
        }
        
        .pricing-card.enterprise .price {
            color: white;
        }
        
        .price-currency {
            font-size: 1.5rem;
            vertical-align: super;
        }
        
        .price-period {
            font-size: 1rem;
            color: #6c757d;
            font-weight: 400;
        }
        
        .pricing-card.enterprise .price-period {
            color: rgba(255, 255, 255, 0.8);
        }
        
        .annual-price {
            font-size: 0.9rem;
            color: #198754;
            font-weight: 600;
            margin-top: 0.5rem;
        }
        
        .pricing-card.enterprise .annual-price {
            color: var(--secondary-color);
        }
        
        .plan-features {
            list-style: none;
            padding: 0;
            margin: 1.5rem 0;
            flex-grow: 1;
        }
        
        .feature-item {
            padding: 0.75rem 0;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            color: #495057;
            font-size: 0.95rem;
        }
        
        .feature-item i {
            color: var(--secondary-color);
            font-size: 1.1rem;
            margin-top: 0.15rem;
            flex-shrink: 0;
        }
        
        .feature-item.disabled {
            color: #adb5bd;
            text-decoration: line-through;
        }
        
        .feature-item.disabled i {
            color: #dee2e6;
        }
        
        .btn-select-plan {
            width: 100%;
            padding: 1rem;
            border-radius: 10px;
            font-weight: 700;
            font-size: 1.1rem;
            border: none;
            transition: all 0.3s;
            margin-top: auto;
        }
        
        .btn-select-plan.btn-primary {
            background: var(--primary-color);
            color: white;
        }
        
        .btn-select-plan.btn-primary:hover {
            background: var(--primary-dark);
            transform: scale(1.02);
        }
        
        .btn-select-plan.btn-success {
            background: var(--secondary-color);
            color: var(--primary-dark);
        }
        
        .btn-select-plan.btn-success:hover {
            background: #88bb22;
            transform: scale(1.02);
        }
        
        .btn-select-plan.btn-light {
            background: white;
            color: var(--primary-color);
            border: 2px solid white;
        }
        
        .btn-select-plan.btn-light:hover {
            background: var(--secondary-color);
            color: var(--primary-dark);
        }
        
        /* Comparison Table */
        .comparison-section {
            margin-top: 4rem;
            background: white;
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        
        .comparison-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 2rem;
            text-align: center;
        }
        
        .comparison-table {
            width: 100%;
            margin-bottom: 0;
        }
        
        .comparison-table thead th {
            background: var(--primary-color);
            color: white;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            padding: 1.25rem 1rem;
            border: none;
            text-align: center;
        }
        
        .comparison-table thead th:first-child {
            text-align: left;
            border-radius: 12px 0 0 0;
        }
        
        .comparison-table thead th:last-child {
            border-radius: 0 12px 0 0;
        }
        
        .comparison-table tbody td {
            padding: 1rem;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: middle;
        }
        
        .comparison-table tbody tr:hover {
            background: #f8f9fa;
        }
        
        .comparison-table tbody td:first-child {
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .comparison-table tbody td:not(:first-child) {
            text-align: center;
        }
        
        .table-check {
            color: var(--secondary-color);
            font-size: 1.3rem;
        }
        
        .table-times {
            color: #dee2e6;
            font-size: 1.3rem;
        }
        
        .category-header {
            background: #f8f9fa !important;
            font-weight: 700 !important;
            color: var(--primary-color) !important;
            text-transform: uppercase;
            font-size: 0.9rem !important;
            letter-spacing: 0.5px;
        }
        
        /* FAQ Section */
        .faq-section {
            margin-top: 4rem;
            background: white;
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        
        .faq-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 2rem;
            text-align: center;
        }
        
        .accordion-button {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 1.05rem;
        }
        
        .accordion-button:not(.collapsed) {
            background: var(--primary-color);
            color: white;
        }
        
        .accordion-button:focus {
            box-shadow: none;
            border-color: var(--primary-color);
        }
        
        /* CTA Section */
        .cta-section {
            margin-top: 4rem;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            border-radius: 16px;
            padding: 3rem;
            text-align: center;
            color: white;
        }
        
        .cta-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .cta-subtitle {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn-cta {
            padding: 1rem 2.5rem;
            border-radius: 10px;
            font-weight: 700;
            font-size: 1.1rem;
            border: 2px solid white;
            transition: all 0.3s;
        }
        
        .btn-cta.btn-light {
            background: white;
            color: var(--primary-color);
        }
        
        .btn-cta.btn-light:hover {
            background: var(--secondary-color);
            border-color: var(--secondary-color);
            color: var(--primary-dark);
        }
        
        .btn-cta.btn-outline-light:hover {
            background: white;
            color: var(--primary-color);
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
            
            .pricing-card {
                margin-bottom: 2rem;
            }
        }
        
        @media (max-width: 768px) {
            .header {
                padding: 0 1rem;
            }
            
            .main-content {
                padding: 1rem;
            }
            
            .user-info {
                display: none;
            }
            
            .page-title {
                font-size: 2rem;
            }
            
            .comparison-table {
                font-size: 0.85rem;
            }
            
            .cta-buttons {
                flex-direction: column;
            }
            
            .btn-cta {
                width: 100%;
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
                <a href="company-settings-redesign-horntech.html" class="sidebar-menu-link">
                    <i class="bi bi-gear"></i>
                    <span>Settings</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="subscription-plans-horntech.html" class="sidebar-menu-link active">
                    <i class="bi bi-credit-card"></i>
                    <span>Subscription Plans</span>
                </a>
            </li>
        </ul>
    </aside>
    
    <!-- Header -->
    <header class="header">
        <div class="header-left">
            <button class="btn d-lg-none" onclick="toggleSidebar()">
                <i class="bi bi-list fs-4"></i>
            </button>
            <h1 class="header-title">Subscription Plans</h1>
        </div>
        
        <div class="header-right">
            <div class="user-menu">
                <div class="user-avatar">AD</div>
                <div class="user-info">
                    <h6>Admin User</h6>
                    <p>System Administrator</p>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Main Content -->
    <main class="main-content">
        <div class="page-header">
            <h2 class="page-title">Choose Your Perfect Plan</h2>
            <p class="page-subtitle">Flexible, scalable subscription plans designed to grow with your business. Start with a 14-day free trial, no credit card required.</p>
        </div>
        
        <!-- Pricing Cards -->
        <div class="row mb-5">
            <!-- Starter Plan -->
            <div class="col-lg-4 mb-4">
                <div class="pricing-card">
                    <h3 class="plan-name">Starter</h3>
                    <p class="plan-description">Perfect for small retail shops and single-location businesses</p>
                    
                    <div class="price-container">
                        <div class="price">
                            <span class="price-currency">SAR</span> 299<span class="price-period">/month</span>
                        </div>
                        <div class="annual-price">
                            <i class="bi bi-tag-fill me-1"></i>SAR 2,990/year (Save 17%)
                        </div>
                    </div>
                    
                    <ul class="plan-features">
                        <li class="feature-item"><i class="bi bi-check-circle-fill"></i> <strong>1 Branch</strong> location</li>
                        <li class="feature-item"><i class="bi bi-check-circle-fill"></i> Up to <strong>3 Users</strong></li>
                        <li class="feature-item"><i class="bi bi-check-circle-fill"></i> <strong>500 Products</strong> limit</li>
                        <li class="feature-item"><i class="bi bi-check-circle-fill"></i> <strong>2 GB</strong> Cloud Storage</li>
                        <li class="feature-item"><i class="bi bi-check-circle-fill"></i> Basic Inventory Management</li>
                        <li class="feature-item"><i class="bi bi-check-circle-fill"></i> Single POS Terminal</li>
                        <li class="feature-item"><i class="bi bi-check-circle-fill"></i> Customer Database (500)</li>
                        <li class="feature-item"><i class="bi bi-check-circle-fill"></i> Basic Sales Reports</li>
                        <li class="feature-item"><i class="bi bi-check-circle-fill"></i> Mobile App Access</li>
                        <li class="feature-item"><i class="bi bi-check-circle-fill"></i> Email Support (48hrs)</li>
                        <li class="feature-item disabled"><i class="bi bi-x-circle-fill"></i> Multi-branch Management</li>
                        <li class="feature-item disabled"><i class="bi bi-x-circle-fill"></i> Purchase Workflow</li>
                        <li class="feature-item disabled"><i class="bi bi-x-circle-fill"></i> Advanced Analytics</li>
                    </ul>
                    
                    <button class="btn-select-plan btn-primary" onclick="selectPlan('Starter')">
                        Start Free Trial
                    </button>
                </div>
            </div>
            
            <!-- Business Plan -->
            <div class="col-lg-4 mb-4">
                <div class="pricing-card popular">
                    <span class="popular-badge">⭐ MOST POPULAR</span>
                    <h3 class="plan-name">Business</h3>
                    <p class="plan-description">Ideal for growing businesses with multiple locations</p>
                    
                    <div class="price-container">
                        <div class="price">
                            <span class="price-currency">SAR</span> 899<span class="price-period">/month</span>
                        </div>
                        <div class="annual-price">
                            <i class="bi bi-tag-fill me-1"></i>SAR 8,990/year (Save 17%)
                        </div>
                    </div>
                    
                    <ul class="plan-features">
                        <li class="feature-item"><i class="bi bi-check-circle-fill"></i> Up to <strong>5 Branches</strong></li>
                        <li class="feature-item"><i class="bi bi-check-circle-fill"></i> Up to <strong>15 Users</strong></li>
                        <li class="feature-item"><i class="bi bi-check-circle-fill"></i> <strong>Unlimited Products</strong></li>
                        <li class="feature-item"><i class="bi bi-check-circle-fill"></i> <strong>20 GB</strong> Cloud Storage</li>
                        <li class="feature-item"><i class="bi bi-check-circle-fill"></i> Multi-Warehouse Management</li>
                        <li class="feature-item"><i class="bi bi-check-circle-fill"></i> Inter-Branch Transfers</li>
                        <li class="feature-item"><i class="bi bi-check-circle-fill"></i> 5-Step Purchase Workflow</li>
                        <li class="feature-item"><i class="bi bi-check-circle-fill"></i> Purchase Expense Tracking</li>
                        <li class="feature-item"><i class="bi bi-check-circle-fill"></i> Chart of Accounts</li>
                        <li class="feature-item"><i class="bi bi-check-circle-fill"></i> 50+ Advanced Reports</li>
                        <li class="feature-item"><i class="bi bi-check-circle-fill"></i> Up to 10 POS Terminals</li>
                        <li class="feature-item"><i class="bi bi-check-circle-fill"></i> Priority Support (24hrs)</li>
                        <li class="feature-item"><i class="bi bi-check-circle-fill"></i> Phone Support</li>
                    </ul>
                    
                    <button class="btn-select-plan btn-success" onclick="selectPlan('Business')">
                        Start Free Trial
                    </button>
                </div>
            </div>
            
            <!-- Enterprise Plan -->
            <div class="col-lg-4 mb-4">
                <div class="pricing-card enterprise">
                    <h3 class="plan-name">Enterprise</h3>
                    <p class="plan-description">For large retail chains and complex operations</p>
                    
                    <div class="price-container">
                        <div class="price">Custom</div>
                        <div class="price-period" style="margin-top: 0.5rem;">Starting from SAR 2,999/month</div>
                    </div>
                    
                    <ul class="plan-features">
                        <li class="feature-item"><i class="bi bi-check-circle-fill"></i> <strong>Unlimited Branches</strong></li>
                        <li class="feature-item"><i class="bi bi-check-circle-fill"></i> <strong>Unlimited Users</strong></li>
                        <li class="feature-item"><i class="bi bi-check-circle-fill"></i> <strong>Unlimited Everything</strong></li>
                        <li class="feature-item"><i class="bi bi-check-circle-fill"></i> Full REST API Access</li>
                        <li class="feature-item"><i class="bi bi-check-circle-fill"></i> ERP Integration</li>
                        <li class="feature-item"><i class="bi bi-check-circle-fill"></i> E-commerce Integration</li>
                        <li class="feature-item"><i class="bi bi-check-circle-fill"></i> AI-Powered Forecasting</li>
                        <li class="feature-item"><i class="bi bi-check-circle-fill"></i> White-Label Branding</li>
                        <li class="feature-item"><i class="bi bi-check-circle-fill"></i> Custom Workflows</li>
                        <li class="feature-item"><i class="bi bi-check-circle-fill"></i> On-Premise Option</li>
                        <li class="feature-item"><i class="bi bi-check-circle-fill"></i> 24/7 Priority Support</li>
                        <li class="feature-item"><i class="bi bi-check-circle-fill"></i> Dedicated Account Manager</li>
                        <li class="feature-item"><i class="bi bi-check-circle-fill"></i> On-Site Training</li>
                    </ul>
                    
                    <button class="btn-select-plan btn-light" onclick="contactSales()">
                        Contact Sales
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Comparison Table -->
        <div class="comparison-section">
            <h3 class="comparison-title">Detailed Feature Comparison</h3>
            <div class="table-responsive">
                <table class="table comparison-table">
                    <thead>
                        <tr>
                            <th>Feature</th>
                            <th>Starter</th>
                            <th>Business</th>
                            <th>Enterprise</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4" class="category-header">CAPACITY & LIMITS</td>
                        </tr>
                        <tr>
                            <td>Number of Branches</td>
                            <td>1</td>
                            <td>Up to 5</td>
                            <td>Unlimited</td>
                        </tr>
                        <tr>
                            <td>Number of Users</td>
                            <td>Up to 3</td>
                            <td>Up to 15</td>
                            <td>Unlimited</td>
                        </tr>
                        <tr>
                            <td>Product SKU Limit</td>
                            <td>500</td>
                            <td>Unlimited</td>
                            <td>Unlimited</td>
                        </tr>
                        <tr>
                            <td>Cloud Storage</td>
                            <td>2 GB</td>
                            <td>20 GB</td>
                            <td>Unlimited</td>
                        </tr>
                        <tr>
                            <td>POS Terminals</td>
                            <td>1</td>
                            <td>Up to 10</td>
                            <td>Unlimited</td>
                        </tr>
                        
                        <tr>
                            <td colspan="4" class="category-header">CORE FEATURES</td>
                        </tr>
                        <tr>
                            <td>Product Management</td>
                            <td><i class="bi bi-check-circle-fill table-check"></i></td>
                            <td><i class="bi bi-check-circle-fill table-check"></i></td>
                            <td><i class="bi bi-check-circle-fill table-check"></i></td>
                        </tr>
                        <tr>
                            <td>Stock Tracking</td>
                            <td><i class="bi bi-check-circle-fill table-check"></i></td>
                            <td><i class="bi bi-check-circle-fill table-check"></i></td>
                            <td><i class="bi bi-check-circle-fill table-check"></i></td>
                        </tr>
                        <tr>
                            <td>Low Stock Alerts</td>
                            <td><i class="bi bi-check-circle-fill table-check"></i></td>
                            <td><i class="bi bi-check-circle-fill table-check"></i></td>
                            <td><i class="bi bi-check-circle-fill table-check"></i></td>
                        </tr>
                        <tr>
                            <td>Point of Sale (POS)</td>
                            <td><i class="bi bi-check-circle-fill table-check"></i></td>
                            <td><i class="bi bi-check-circle-fill table-check"></i></td>
                            <td><i class="bi bi-check-circle-fill table-check"></i></td>
                        </tr>
                        
                        <tr>
                            <td colspan="4" class="category-header">ADVANCED INVENTORY</td>
                        </tr>
                        <tr>
                            <td>Multi-Warehouse Management</td>
                            <td><i class="bi bi-x-circle-fill table-times"></i></td>
                            <td><i class="bi bi-check-circle-fill table-check"></i></td>
                            <td><i class="bi bi-check-circle-fill table-check"></i></td>
                        </tr>
                        <tr>
                            <td>Inter-Branch Transfers</td>
                            <td><i class="bi bi-x-circle-fill table-times"></i></td>
                            <td><i class="bi bi-check-circle-fill table-check"></i></td>
                            <td><i class="bi bi-check-circle-fill table-check"></i></td>
                        </tr>
                        <tr>
                            <td>Batch/Serial Tracking</td>
                            <td><i class="bi bi-x-circle-fill table-times"></i></td>
                            <td><i class="bi bi-check-circle-fill table-check"></i></td>
                            <td><i class="bi bi-check-circle-fill table-check"></i></td>
                        </tr>
                        
                        <tr>
                            <td colspan="4" class="category-header">PURCHASE MANAGEMENT</td>
                        </tr>
                        <tr>
                            <td>5-Step Purchase Workflow</td>
                            <td><i class="bi bi-x-circle-fill table-times"></i></td>
                            <td><i class="bi bi-check-circle-fill table-check"></i></td>
                            <td><i class="bi bi-check-circle-fill table-check"></i></td>
                        </tr>
                        <tr>
                            <td>Purchase Expense Tracking</td>
                            <td><i class="bi bi-x-circle-fill table-times"></i></td>
                            <td><i class="bi bi-check-circle-fill table-check"></i></td>
                            <td><i class="bi bi-check-circle-fill table-check"></i></td>
                        </tr>
                        <tr>
                            <td>Supplier Management</td>
                            <td><i class="bi bi-x-circle-fill table-times"></i></td>
                            <td><i class="bi bi-check-circle-fill table-check"></i></td>
                            <td><i class="bi bi-check-circle-fill table-check"></i></td>
                        </tr>
                        
                        <tr>
                            <td colspan="4" class="category-header">REPORTING & ANALYTICS</td>
                        </tr>
                        <tr>
                            <td>Pre-Built Reports</td>
                            <td>10 Basic</td>
                            <td>50+ Advanced</td>
                            <td>100+ Enterprise</td>
                        </tr>
                        <tr>
                            <td>Custom Report Builder</td>
                            <td><i class="bi bi-x-circle-fill table-times"></i></td>
                            <td><i class="bi bi-check-circle-fill table-check"></i></td>
                            <td><i class="bi bi-check-circle-fill table-check"></i></td>
                        </tr>
                        <tr>
                            <td>AI-Powered Forecasting</td>
                            <td><i class="bi bi-x-circle-fill table-times"></i></td>
                            <td><i class="bi bi-x-circle-fill table-times"></i></td>
                            <td><i class="bi bi-check-circle-fill table-check"></i></td>
                        </tr>
                        
                        <tr>
                            <td colspan="4" class="category-header">INTEGRATIONS</td>
                        </tr>
                        <tr>
                            <td>Mobile App (iOS/Android)</td>
                            <td><i class="bi bi-check-circle-fill table-check"></i></td>
                            <td><i class="bi bi-check-circle-fill table-check"></i></td>
                            <td><i class="bi bi-check-circle-fill table-check"></i></td>
                        </tr>
                        <tr>
                            <td>API Access</td>
                            <td><i class="bi bi-x-circle-fill table-times"></i></td>
                            <td><i class="bi bi-x-circle-fill table-times"></i></td>
                            <td><i class="bi bi-check-circle-fill table-check"></i></td>
                        </tr>
                        <tr>
                            <td>ERP Integration</td>
                            <td><i class="bi bi-x-circle-fill table-times"></i></td>
                            <td><i class="bi bi-x-circle-fill table-times"></i></td>
                            <td><i class="bi bi-check-circle-fill table-check"></i></td>
                        </tr>
                        
                        <tr>
                            <td colspan="4" class="category-header">SUPPORT</td>
                        </tr>
                        <tr>
                            <td>Email Support</td>
                            <td>48 hours</td>
                            <td>24 hours</td>
                            <td>24/7</td>
                        </tr>
                        <tr>
                            <td>Phone Support</td>
                            <td><i class="bi bi-x-circle-fill table-times"></i></td>
                            <td>Business Hours</td>
                            <td>24/7</td>
                        </tr>
                        <tr>
                            <td>Dedicated Account Manager</td>
                            <td><i class="bi bi-x-circle-fill table-times"></i></td>
                            <td><i class="bi bi-x-circle-fill table-times"></i></td>
                            <td><i class="bi bi-check-circle-fill table-check"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- FAQ Section -->
        <div class="faq-section">
            <h3 class="faq-title">Frequently Asked Questions</h3>
            <div class="accordion" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                            Can I switch plans mid-cycle?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Yes, you can upgrade or downgrade your plan at any time. Upgrades take effect immediately with prorated billing adjustment. Downgrades take effect at the next billing cycle to ensure you don't lose access to features you've already paid for.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                            What happens if I exceed my user limit?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            You'll receive a notification when you're approaching your user limit. You can either upgrade to a higher plan or purchase additional user licenses at SAR 50/month per user. The system will not lock you out, but you'll need to adjust within 7 days.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                            Is there a setup fee?
                        </button>
                    </h2>
                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            No setup fees for Starter and Business plans. You can start using the system immediately after signing up. Enterprise plans may have implementation fees depending on customization requirements, data migration complexity, and integration needs.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                            Can I cancel anytime?
                        </button>
                    </h2>
                    <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Yes for monthly plans - you can cancel anytime and your subscription will remain active until the end of the current billing period. Annual plans can be cancelled but are non-refundable after the 30-day money-back guarantee period. Your data will be available for export for 90 days after cancellation.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                            Is my data secure?
                        </button>
                    </h2>
                    <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Absolutely. All plans include enterprise-grade security with SSL/TLS encryption, regular automated backups, secure data centers, and compliance with international data protection standards (ISO 27001, SOC 2). Enterprise plans offer additional security features including on-premise deployment and advanced encryption options.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq6">
                            Do you offer discounts for non-profits?
                        </button>
                    </h2>
                    <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Yes, we offer 20% discounts for registered non-profit organizations and educational institutions. Contact our sales team with your organization details and registration documents to apply for the discount.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- CTA Section -->
        <div class="cta-section">
            <h3 class="cta-title">Ready to Transform Your Business?</h3>
            <p class="cta-subtitle">Start your 14-day free trial today. No credit card required. Cancel anytime.</p>
            <div class="cta-buttons">
                <button class="btn btn-cta btn-light" onclick="startFreeTrial()">
                    <i class="bi bi-rocket-takeoff me-2"></i>Start Free Trial
                </button>
                <button class="btn btn-cta btn-outline-light" onclick="scheduleDemoCall()">
                    <i class="bi bi-calendar-check me-2"></i>Schedule a Demo
                </button>
            </div>
            <p class="mt-4 mb-0" style="opacity: 0.9;">
                <i class="bi bi-telephone me-2"></i>Questions? Call us: +966 11 XXX XXXX
                <span class="mx-3">|</span>
                <i class="bi bi-envelope me-2"></i>sales@horntech.com
            </p>
        </div>
    </main>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }
        
        function selectPlan(planName) {
            alert('🎉 Starting Free Trial for ' + planName + ' Plan!\n\nWhat happens next:\n\n✓ Create your account\n✓ Get immediate access to all ' + planName + ' features\n✓ 14-day free trial (no credit card required)\n✓ Cancel anytime, no commitment\n\nLet\'s get started!');
            // In production, this would redirect to signup page
            // window.location.href = '/signup?plan=' + planName.toLowerCase();
        }
        
        function contactSales() {
            alert('📞 Contact Sales - Enterprise Plan\n\nOur enterprise team will:\n\n✓ Understand your specific needs\n✓ Provide custom pricing quote\n✓ Schedule personalized demo\n✓ Discuss integration requirements\n✓ Plan implementation timeline\n\nEmail: enterprise@horntech.com\nPhone: +966 11 XXX XXXX\n\nWe\'ll get back to you within 24 hours!');
        }
        
        function startFreeTrial() {
            alert('🚀 Starting Your Free Trial!\n\n✓ 14 days full access\n✓ No credit card required\n✓ All features unlocked\n✓ Cancel anytime\n\nChoose your plan on the next page!');
            // In production, redirect to signup
            // window.location.href = '/signup';
        }
        
        function scheduleDemoCall() {
            alert('📅 Schedule a Demo Call\n\nOur product specialist will:\n\n✓ Show you the platform live\n✓ Answer your questions\n✓ Demonstrate key features\n✓ Discuss your specific needs\n✓ Recommend the best plan\n\nDuration: 30 minutes\nAvailable: Sun-Thu, 9AM-6PM AST\n\nBook your preferred time slot!');
            // In production, redirect to calendar booking
            // window.location.href = '/demo/schedule';
        }
    </script>
</body>
</html>
