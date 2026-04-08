<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horntech LTD SaaS - Complete Business Management Solution</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #004161;
            --secondary-color: #99CC33;
            --primary-dark: #002d47;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: #ffffff;
            overflow-x: hidden;
        }
        
        /* Navigation */
        .navbar {
            background: white;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .logo-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--secondary-color), #88bb22);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 4px 15px rgba(153, 204, 51, 0.3);
        }
        
        .nav-link {
            color: #333;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            transition: color 0.3s;
        }
        
        .nav-link:hover {
            color: var(--primary-color);
        }
        
        .btn-primary {
            background: var(--primary-color);
            border: none;
            padding: 0.625rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 65, 97, 0.3);
        }
        
        .btn-success {
            background: var(--secondary-color);
            border: none;
            color: var(--primary-dark);
            padding: 0.625rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-success:hover {
            background: #88bb22;
            color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(153, 204, 51, 0.4);
        }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            padding: 5rem 0;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(153, 204, 51, 0.1) 0%, transparent 70%);
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
        }
        
        .hero-title {
            font-family: 'Poppins', sans-serif;
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }
        
        .hero-subtitle {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        
        .hero-stats {
            display: flex;
            gap: 3rem;
            margin-top: 3rem;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--secondary-color);
        }
        
        .stat-label {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.8);
        }
        
        /* Features Section */
        .features-section {
            padding: 5rem 0;
            background: #f8f9fa;
        }
        
        .section-title {
            font-family: 'Poppins', sans-serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 1rem;
        }
        
        .section-subtitle {
            text-align: center;
            color: #6c757d;
            font-size: 1.1rem;
            margin-bottom: 3rem;
        }
        
        .feature-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            height: 100%;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s;
            border: 2px solid transparent;
        }
        
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            border-color: var(--secondary-color);
        }
        
        .feature-icon {
            width: 70px;
            height: 70px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 1.5rem;
        }
        
        .feature-title {
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 1rem;
            font-size: 1.25rem;
        }
        
        .feature-description {
            color: #6c757d;
            line-height: 1.6;
        }
        
        /* Modules Section */
        .modules-section {
            padding: 5rem 0;
            background: white;
        }
        
        .module-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s;
            border: 2px solid transparent;
            height: 100%;
        }
        
        .module-card:hover {
            background: white;
            border-color: var(--primary-color);
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        
        .module-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .module-name {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 1rem;
        }
        
        /* Pricing Preview */
        .pricing-preview {
            padding: 5rem 0;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }
        
        .pricing-card {
            background: white;
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
            height: 100%;
        }
        
        .pricing-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }
        
        .pricing-card.featured {
            border: 3px solid var(--secondary-color);
            position: relative;
        }
        
        .featured-badge {
            position: absolute;
            top: -15px;
            right: 20px;
            background: var(--secondary-color);
            color: var(--primary-dark);
            padding: 0.5rem 1.5rem;
            border-radius: 20px;
            font-weight: 700;
            font-size: 0.85rem;
        }
        
        .plan-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .plan-price {
            font-size: 3rem;
            font-weight: 800;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }
        
        .plan-period {
            color: #6c757d;
            margin-bottom: 2rem;
        }
        
        .plan-features {
            list-style: none;
            margin-bottom: 2rem;
        }
        
        .plan-features li {
            padding: 0.75rem 0;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .plan-features i {
            color: var(--secondary-color);
            font-size: 1.25rem;
        }
        
        /* CTA Section */
        .cta-section {
            padding: 5rem 0;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            text-align: center;
        }
        
        .cta-title {
            font-family: 'Poppins', sans-serif;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .cta-subtitle {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
        }
        
        /* Footer */
        .footer {
            background: #1a1a1a;
            color: white;
            padding: 4rem 0 2rem;
        }
        
        .footer-title {
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: var(--secondary-color);
        }
        
        .footer-link {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            display: block;
            padding: 0.5rem 0;
            transition: color 0.3s;
        }
        
        .footer-link:hover {
            color: var(--secondary-color);
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 2rem;
            margin-top: 3rem;
            text-align: center;
            color: rgba(255, 255, 255, 0.5);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
            }
            
            .hero-stats {
                flex-direction: column;
                gap: 1.5rem;
            }
            
            .section-title {
                font-size: 1.75rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
                <div class="logo-icon">
                    <i class="bi bi-shop"></i>
                </div>
                <span>Horntech LTD</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#modules">Modules</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#pricing">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="saas-demo-request-horntech.html">Request Demo</a>
                    </li>
                    <li class="nav-item ms-3">
                        <a href="login-horntech.html" class="btn btn-primary">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                        </a>
                    </li>
                    <li class="nav-item ms-2">
                        <a href="saas-registration-horntech.html" class="btn btn-success">
                            Get Started
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content">
                    <h1 class="hero-title">Complete ERP Solution for Growing Businesses</h1>
                    <p class="hero-subtitle">
                        Streamline your operations with our cloud-based ERP platform. Manage inventory, sales, purchases, accounting, and more - all in one place.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="saas-registration-horntech.html" class="btn btn-success btn-lg">
                            <i class="bi bi-rocket-takeoff me-2"></i>Start Free Trial
                        </a>
                        <a href="saas-demo-request-horntech.html" class="btn btn-outline-light btn-lg">
                            <i class="bi bi-play-circle me-2"></i>Request Demo
                        </a>
                    </div>
                    <div class="hero-stats">
                        <div class="stat-item">
                            <div class="stat-number">500+</div>
                            <div class="stat-label">Active Companies</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">10K+</div>
                            <div class="stat-label">Daily Transactions</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">99.9%</div>
                            <div class="stat-label">Uptime</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&auto=format&fit=crop" 
                         alt="ERP Dashboard" class="img-fluid rounded-3 shadow-lg">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section" id="features">
        <div class="container">
            <h2 class="section-title">Why Choose Horntech LTD?</h2>
            <p class="section-subtitle">Powerful features designed to help your business grow</p>
            
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon" style="background: rgba(0, 123, 255, 0.1); color: #007bff;">
                            <i class="bi bi-cloud-check"></i>
                        </div>
                        <h3 class="feature-title">Cloud-Based Platform</h3>
                        <p class="feature-description">Access your business data anytime, anywhere. No installation required, just login and start working.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon" style="background: rgba(153, 204, 51, 0.1); color: #99CC33;">
                            <i class="bi bi-building"></i>
                        </div>
                        <h3 class="feature-title">Multi-Company Support</h3>
                        <p class="feature-description">Manage multiple companies from a single account with complete data isolation and security.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon" style="background: rgba(220, 53, 69, 0.1); color: #dc3545;">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h3 class="feature-title">Enterprise Security</h3>
                        <p class="feature-description">Bank-level encryption, role-based access control, and regular backups keep your data safe.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon" style="background: rgba(255, 193, 7, 0.1); color: #ffc107;">
                            <i class="bi bi-lightning-charge"></i>
                        </div>
                        <h3 class="feature-title">Real-Time Updates</h3>
                        <p class="feature-description">Get instant notifications and real-time data synchronization across all devices.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon" style="background: rgba(111, 66, 193, 0.1); color: #6f42c1;">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                        <h3 class="feature-title">Advanced Analytics</h3>
                        <p class="feature-description">Comprehensive reports and dashboards help you make data-driven decisions.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon" style="background: rgba(32, 201, 151, 0.1); color: #20c997;">
                            <i class="bi bi-people"></i>
                        </div>
                        <h3 class="feature-title">User Management</h3>
                        <p class="feature-description">Flexible role-based permissions allow you to control who can access what.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modules Section -->
    <section class="modules-section" id="modules">
        <div class="container">
            <h2 class="section-title">Complete Business Modules</h2>
            <p class="section-subtitle">Everything you need to run your business efficiently</p>
            
            <div class="row g-4">
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="module-card">
                        <div class="module-icon">
                            <i class="bi bi-building"></i>
                        </div>
                        <div class="module-name">Company Management</div>
                    </div>
                </div>
                
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="module-card">
                        <div class="module-icon">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <div class="module-name">Inventory Management</div>
                    </div>
                </div>
                
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="module-card">
                        <div class="module-icon">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <div class="module-name">Sales Management</div>
                    </div>
                </div>
                
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="module-card">
                        <div class="module-icon">
                            <i class="bi bi-cart-plus"></i>
                        </div>
                        <div class="module-name">Purchase Management</div>
                    </div>
                </div>
                
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="module-card">
                        <div class="module-icon">
                            <i class="bi bi-calculator"></i>
                        </div>
                        <div class="module-name">Accounting & Finance</div>
                    </div>
                </div>
                
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="module-card">
                        <div class="module-icon">
                            <i class="bi bi-receipt"></i>
                        </div>
                        <div class="module-name">Expense Management</div>
                    </div>
                </div>
                
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="module-card">
                        <div class="module-icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="module-name">CRM</div>
                    </div>
                </div>
                
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="module-card">
                        <div class="module-icon">
                            <i class="bi bi-person-badge"></i>
                        </div>
                        <div class="module-name">HR Management</div>
                    </div>
                </div>
                
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="module-card">
                        <div class="module-icon">
                            <i class="bi bi-file-earmark-bar-graph"></i>
                        </div>
                        <div class="module-name">Reports & Analytics</div>
                    </div>
                </div>
                
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="module-card">
                        <div class="module-icon">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                        <div class="module-name">Point of Sale</div>
                    </div>
                </div>
                
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="module-card">
                        <div class="module-icon">
                            <i class="bi bi-truck"></i>
                        </div>
                        <div class="module-name">Supplier Management</div>
                    </div>
                </div>
                
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="module-card">
                        <div class="module-icon">
                            <i class="bi bi-gear"></i>
                        </div>
                        <div class="module-name">System Settings</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Preview -->
    <section class="pricing-preview" id="pricing">
        <div class="container">
            <h2 class="section-title">Choose Your Plan</h2>
            <p class="section-subtitle">Flexible pricing for businesses of all sizes</p>
            
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="pricing-card">
                        <h3 class="plan-name">Starter</h3>
                        <div class="plan-price">SAR 299</div>
                        <div class="plan-period">per month</div>
                        <ul class="plan-features">
                            <li><i class="bi bi-check-circle-fill"></i> Up to 5 Users</li>
                            <li><i class="bi bi-check-circle-fill"></i> 1 Company</li>
                            <li><i class="bi bi-check-circle-fill"></i> 1,000 Products</li>
                            <li><i class="bi bi-check-circle-fill"></i> Basic Reports</li>
                            <li><i class="bi bi-check-circle-fill"></i> Email Support</li>
                        </ul>
                        <a href="saas-registration-horntech.html" class="btn btn-outline-primary w-100">Get Started</a>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="pricing-card featured">
                        <div class="featured-badge">Most Popular</div>
                        <h3 class="plan-name">Business</h3>
                        <div class="plan-price">SAR 899</div>
                        <div class="plan-period">per month</div>
                        <ul class="plan-features">
                            <li><i class="bi bi-check-circle-fill"></i> Up to 20 Users</li>
                            <li><i class="bi bi-check-circle-fill"></i> 3 Companies</li>
                            <li><i class="bi bi-check-circle-fill"></i> Unlimited Products</li>
                            <li><i class="bi bi-check-circle-fill"></i> Advanced Reports</li>
                            <li><i class="bi bi-check-circle-fill"></i> Priority Support</li>
                            <li><i class="bi bi-check-circle-fill"></i> API Access</li>
                        </ul>
                        <a href="saas-registration-horntech.html" class="btn btn-primary w-100">Get Started</a>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="pricing-card">
                        <h3 class="plan-name">Enterprise</h3>
                        <div class="plan-price">Custom</div>
                        <div class="plan-period">contact us</div>
                        <ul class="plan-features">
                            <li><i class="bi bi-check-circle-fill"></i> Unlimited Users</li>
                            <li><i class="bi bi-check-circle-fill"></i> Unlimited Companies</li>
                            <li><i class="bi bi-check-circle-fill"></i> Unlimited Products</li>
                            <li><i class="bi bi-check-circle-fill"></i> Custom Reports</li>
                            <li><i class="bi bi-check-circle-fill"></i> 24/7 Support</li>
                            <li><i class="bi bi-check-circle-fill"></i> Dedicated Account Manager</li>
                        </ul>
                        <a href="saas-demo-request-horntech.html" class="btn btn-outline-primary w-100">Contact Sales</a>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-5">
                <a href="subscription-plans-horntech.html" class="btn btn-primary btn-lg">
                    View Detailed Pricing
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2 class="cta-title">Ready to Transform Your Business?</h2>
            <p class="cta-subtitle">Start your 14-day free trial today. No credit card required.</p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="saas-registration-horntech.html" class="btn btn-success btn-lg">
                    <i class="bi bi-rocket-takeoff me-2"></i>Start Free Trial
                </a>
                <a href="saas-demo-request-horntech.html" class="btn btn-outline-light btn-lg">
                    <i class="bi bi-calendar-check me-2"></i>Schedule Demo
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="logo-icon">
                            <i class="bi bi-shop"></i>
                        </div>
                        <h3 style="color: white; margin: 0; font-weight: 700;">Horntech LTD</h3>
                    </div>
                    <p class="text-white-50">Complete cloud-based ERP solution for growing businesses in Saudi Arabia and beyond.</p>
                </div>
                
                <div class="col-lg-2 col-md-4 mb-4">
                    <h5 class="footer-title">Product</h5>
                    <a href="#features" class="footer-link">Features</a>
                    <a href="#modules" class="footer-link">Modules</a>
                    <a href="#pricing" class="footer-link">Pricing</a>
                    <a href="saas-demo-request-horntech.html" class="footer-link">Request Demo</a>
                </div>
                
                <div class="col-lg-2 col-md-4 mb-4">
                    <h5 class="footer-title">Company</h5>
                    <a href="#" class="footer-link">About Us</a>
                    <a href="#" class="footer-link">Contact</a>
                    <a href="#" class="footer-link">Careers</a>
                    <a href="#" class="footer-link">Blog</a>
                </div>
                
                <div class="col-lg-2 col-md-4 mb-4">
                    <h5 class="footer-title">Support</h5>
                    <a href="#" class="footer-link">Help Center</a>
                    <a href="#" class="footer-link">Documentation</a>
                    <a href="#" class="footer-link">API Reference</a>
                    <a href="#" class="footer-link">System Status</a>
                </div>
                
                <div class="col-lg-2 col-md-4 mb-4">
                    <h5 class="footer-title">Legal</h5>
                    <a href="#" class="footer-link">Privacy Policy</a>
                    <a href="#" class="footer-link">Terms of Service</a>
                    <a href="#" class="footer-link">Cookie Policy</a>
                    <a href="#" class="footer-link">GDPR</a>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2026 Horntech LTD. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
