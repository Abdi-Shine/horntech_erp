<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Horntech LTD SaaS</title>
    
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
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 2rem 0;
        }
        
        .registration-container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .registration-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .registration-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 2.5rem;
            text-align: center;
        }
        
        .logo-icon {
            width: 70px;
            height: 70px;
            background: white;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }
        
        .registration-title {
            font-family: 'Poppins', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .registration-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
        }
        
        .registration-body {
            padding: 2.5rem;
        }
        
        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
            position: relative;
        }
        
        .step-indicator::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 0;
            right: 0;
            height: 2px;
            background: #e9ecef;
            z-index: 0;
        }
        
        .step {
            position: relative;
            z-index: 1;
            text-align: center;
            flex: 1;
        }
        
        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e9ecef;
            color: #6c757d;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .step.active .step-number {
            background: var(--primary-color);
            color: white;
        }
        
        .step.completed .step-number {
            background: var(--secondary-color);
            color: var(--primary-dark);
        }
        
        .step-label {
            font-size: 0.75rem;
            color: #6c757d;
            font-weight: 500;
        }
        
        .step.active .step-label {
            color: var(--primary-color);
            font-weight: 700;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        
        .form-label .required {
            color: #dc3545;
        }
        
        .form-control, .form-select {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            transition: all 0.3s;
            font-size: 0.95rem;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 65, 97, 0.1);
        }
        
        .input-group-text {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 10px 0 0 10px;
            border-right: none;
        }
        
        .input-group .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }
        
        .btn-primary {
            background: var(--primary-color);
            border: none;
            padding: 0.875rem 2rem;
            border-radius: 10px;
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
            padding: 0.875rem 2rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-success:hover {
            background: #88bb22;
            color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(153, 204, 51, 0.4);
        }
        
        .benefits-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 2rem;
            border-radius: 12px;
            margin-top: 2rem;
        }
        
        .benefit-item {
            display: flex;
            align-items: start;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        
        .benefit-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--secondary-color);
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1.25rem;
        }
        
        .benefit-text h6 {
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.25rem;
        }
        
        .benefit-text p {
            font-size: 0.875rem;
            color: #6c757d;
            margin: 0;
        }
        
        .divider {
            text-align: center;
            margin: 2rem 0;
            position: relative;
        }
        
        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e9ecef;
        }
        
        .divider span {
            background: white;
            padding: 0 1rem;
            position: relative;
            color: #6c757d;
            font-size: 0.875rem;
        }
        
        .social-login {
            display: flex;
            gap: 1rem;
        }
        
        .social-btn {
            flex: 1;
            padding: 0.875rem;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            background: white;
            font-weight: 600;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .social-btn:hover {
            border-color: var(--primary-color);
            background: #f8f9fa;
        }
        
        .password-strength {
            height: 4px;
            background: #e9ecef;
            border-radius: 2px;
            margin-top: 0.5rem;
            overflow: hidden;
        }
        
        .password-strength-bar {
            height: 100%;
            width: 0%;
            transition: all 0.3s;
        }
        
        .password-strength-bar.weak {
            width: 33%;
            background: #dc3545;
        }
        
        .password-strength-bar.medium {
            width: 66%;
            background: #ffc107;
        }
        
        .password-strength-bar.strong {
            width: 100%;
            background: var(--secondary-color);
        }
        
        .back-link {
            text-align: center;
            margin-top: 2rem;
        }
        
        .back-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }
        
        .back-link a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }
        
        @media (max-width: 768px) {
            .registration-body {
                padding: 1.5rem;
            }
            
            .registration-header {
                padding: 2rem 1.5rem;
            }
            
            .social-login {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="registration-container">
            <div class="registration-card">
                <div class="registration-header">
                    <div class="logo-icon">
                        <i class="bi bi-shop"></i>
                    </div>
                    <h1 class="registration-title">Create Your Account</h1>
                    <p class="registration-subtitle">Join thousands of businesses using Horntech LTD</p>
                </div>
                
                <div class="registration-body">
                    <!-- Step Indicator -->
                    <div class="step-indicator">
                        <div class="step active">
                            <div class="step-number">1</div>
                            <div class="step-label">Company Info</div>
                        </div>
                        <div class="step">
                            <div class="step-number">2</div>
                            <div class="step-label">Admin Details</div>
                        </div>
                        <div class="step">
                            <div class="step-number">3</div>
                            <div class="step-label">Choose Plan</div>
                        </div>
                    </div>
                    
                    <!-- Registration Form -->
                    <form id="registrationForm" action="saas-payment-horntech.html">
                        <!-- Company Information -->
                        <div class="mb-4">
                            <h5 class="text-primary fw-bold mb-3">
                                <i class="bi bi-building me-2"></i>Company Information
                            </h5>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Company Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" placeholder="Enter company name" required>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Legal Name</label>
                                    <input type="text" class="form-control" placeholder="Legal company name">
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Industry <span class="required">*</span></label>
                                    <select class="form-select" required>
                                        <option value="">Select industry</option>
                                        <option>Retail & Trading</option>
                                        <option>Manufacturing</option>
                                        <option>Wholesale Distribution</option>
                                        <option>Food & Beverage</option>
                                        <option>Electronics & Technology</option>
                                        <option>Healthcare</option>
                                        <option>Construction</option>
                                        <option>Professional Services</option>
                                        <option>Other</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Company Size <span class="required">*</span></label>
                                    <select class="form-select" required>
                                        <option value="">Select size</option>
                                        <option>1-10 employees</option>
                                        <option>11-50 employees</option>
                                        <option>51-200 employees</option>
                                        <option>201-500 employees</option>
                                        <option>500+ employees</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">VAT Number</label>
                                    <input type="text" class="form-control" placeholder="300123456789003">
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Commercial Registration</label>
                                    <input type="text" class="form-control" placeholder="CR Number">
                                </div>
                                
                                <div class="col-12">
                                    <label class="form-label">Company Address <span class="required">*</span></label>
                                    <input type="text" class="form-control" placeholder="Street address" required>
                                </div>
                                
                                <div class="col-md-4">
                                    <label class="form-label">City <span class="required">*</span></label>
                                    <input type="text" class="form-control" placeholder="City" required>
                                </div>
                                
                                <div class="col-md-4">
                                    <label class="form-label">Country <span class="required">*</span></label>
                                    <select class="form-select" required>
                                        <option value="">Select country</option>
                                        <option selected>Saudi Arabia</option>
                                        <option>United Arab Emirates</option>
                                        <option>Kuwait</option>
                                        <option>Bahrain</option>
                                        <option>Qatar</option>
                                        <option>Oman</option>
                                        <option>Other</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-4">
                                    <label class="form-label">Postal Code</label>
                                    <input type="text" class="form-control" placeholder="12345">
                                </div>
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        
                        <!-- Admin User Information -->
                        <div class="mb-4">
                            <h5 class="text-primary fw-bold mb-3">
                                <i class="bi bi-person-badge me-2"></i>Admin User Details
                            </h5>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">First Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" placeholder="First name" required>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Last Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" placeholder="Last name" required>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Email Address <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-envelope"></i>
                                        </span>
                                        <input type="email" class="form-control" placeholder="admin@company.com" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Phone Number <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-telephone"></i>
                                        </span>
                                        <input type="tel" class="form-control" placeholder="+966 50 123 4567" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Password <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-lock"></i>
                                        </span>
                                        <input type="password" class="form-control" id="password" placeholder="Create password" required>
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    <div class="password-strength">
                                        <div class="password-strength-bar" id="strengthBar"></div>
                                    </div>
                                    <small class="text-muted">Minimum 8 characters with uppercase, lowercase, and numbers</small>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Confirm Password <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-lock-fill"></i>
                                        </span>
                                        <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm password" required>
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirmPassword')">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        
                        <!-- Plan Selection -->
                        <div class="mb-4">
                            <h5 class="text-primary fw-bold mb-3">
                                <i class="bi bi-credit-card me-2"></i>Select Your Plan
                            </h5>
                            
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="plan" id="starter" value="starter" checked>
                                        <label class="form-check-label w-100" for="starter">
                                            <div class="border rounded-3 p-3">
                                                <h6 class="fw-bold text-primary">Starter</h6>
                                                <div class="h4 text-primary mb-0">SAR 299<small class="text-muted">/mo</small></div>
                                                <small class="text-muted">Up to 5 users</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="plan" id="business" value="business">
                                        <label class="form-check-label w-100" for="business">
                                            <div class="border border-success border-2 rounded-3 p-3 position-relative">
                                                <span class="badge bg-success position-absolute top-0 end-0 m-2">Popular</span>
                                                <h6 class="fw-bold text-primary">Business</h6>
                                                <div class="h4 text-primary mb-0">SAR 899<small class="text-muted">/mo</small></div>
                                                <small class="text-muted">Up to 20 users</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="plan" id="enterprise" value="enterprise">
                                        <label class="form-check-label w-100" for="enterprise">
                                            <div class="border rounded-3 p-3">
                                                <h6 class="fw-bold text-primary">Enterprise</h6>
                                                <div class="h4 text-primary mb-0">Custom</div>
                                                <small class="text-muted">Unlimited users</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-center mt-3">
                                <a href="subscription-plans-horntech.html" class="text-primary text-decoration-none">
                                    <small>View detailed pricing comparison <i class="bi bi-arrow-right"></i></small>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Terms and Conditions -->
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="terms" required>
                            <label class="form-check-label" for="terms">
                                I agree to the <a href="#" class="text-primary">Terms of Service</a> and <a href="#" class="text-primary">Privacy Policy</a>
                            </label>
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-success w-100 mb-3">
                            <i class="bi bi-rocket-takeoff me-2"></i>Create Account & Continue to Payment
                        </button>
                        
                        <div class="text-center text-muted">
                            <small>14-day free trial • No credit card required for trial</small>
                        </div>
                    </form>
                    
                    <!-- Social Login -->
                    <div class="divider">
                        <span>Or sign up with</span>
                    </div>
                    
                    <div class="social-login">
                        <button class="social-btn">
                            <i class="bi bi-google" style="color: #DB4437;"></i>
                            Google
                        </button>
                        <button class="social-btn">
                            <i class="bi bi-microsoft" style="color: #00A4EF;"></i>
                            Microsoft
                        </button>
                    </div>
                    
                    <!-- Benefits Section -->
                    <div class="benefits-section">
                        <h6 class="fw-bold text-primary mb-3">What you'll get:</h6>
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="bi bi-check-lg"></i>
                            </div>
                            <div class="benefit-text">
                                <h6>14-Day Free Trial</h6>
                                <p>No credit card required. Full access to all features.</p>
                            </div>
                        </div>
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <div class="benefit-text">
                                <h6>Secure & Compliant</h6>
                                <p>Bank-level encryption and ZATCA e-invoicing ready.</p>
                            </div>
                        </div>
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="bi bi-headset"></i>
                            </div>
                            <div class="benefit-text">
                                <h6>24/7 Support</h6>
                                <p>Dedicated support team available whenever you need help.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Back to Login -->
                    <div class="back-link">
                        Already have an account? <a href="login-horntech.html">Sign In</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Password Toggle
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const button = field.nextElementSibling;
            const icon = button.querySelector('i');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }
        
        // Password Strength Indicator
        document.getElementById('password')?.addEventListener('input', function(e) {
            const password = e.target.value;
            const strengthBar = document.getElementById('strengthBar');
            
            let strength = 0;
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            
            strengthBar.className = 'password-strength-bar';
            if (strength === 1) strengthBar.classList.add('weak');
            if (strength === 2) strengthBar.classList.add('medium');
            if (strength === 3) strengthBar.classList.add('strong');
        });
        
        // Form Validation
        document.getElementById('registrationForm')?.addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match!');
                return false;
            }
        });
    </script>
</body>
</html>
