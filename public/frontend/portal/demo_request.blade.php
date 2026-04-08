<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Demo - Horntech LTD SaaS</title>
    
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
            background: #f8f9fa;
        }
        
        .demo-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 2rem 0;
        }
        
        .demo-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .demo-sidebar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 3rem 2rem;
            min-height: 100%;
        }
        
        .logo-section {
            margin-bottom: 2rem;
        }
        
        .logo-icon {
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .demo-sidebar h2 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .demo-sidebar p {
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.6;
            margin-bottom: 2rem;
        }
        
        .demo-features {
            list-style: none;
        }
        
        .demo-features li {
            display: flex;
            align-items: start;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .feature-icon {
            width: 40px;
            height: 40px;
            background: rgba(153, 204, 51, 0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--secondary-color);
            flex-shrink: 0;
        }
        
        .feature-text h6 {
            margin-bottom: 0.25rem;
            font-weight: 600;
        }
        
        .feature-text p {
            margin: 0;
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.8);
        }
        
        .demo-form-section {
            padding: 3rem 2rem;
        }
        
        .form-title {
            font-family: 'Poppins', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }
        
        .form-subtitle {
            color: #6c757d;
            margin-bottom: 2rem;
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
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 65, 97, 0.1);
        }
        
        textarea.form-control {
            min-height: 120px;
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
        
        .time-slot {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 0.75rem;
            margin-top: 1rem;
        }
        
        .time-slot-btn {
            padding: 0.75rem;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            background: white;
            text-align: center;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .time-slot-btn:hover {
            border-color: var(--primary-color);
            background: rgba(0, 65, 97, 0.05);
        }
        
        .time-slot-btn.selected {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }
        
        .info-box {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border-left: 4px solid #2196f3;
            padding: 1rem;
            border-radius: 8px;
            margin-top: 2rem;
        }
        
        .info-box h6 {
            color: #1976d2;
            font-weight: 700;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .info-box p {
            color: #0d47a1;
            font-size: 0.875rem;
            margin: 0;
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
            text-decoration: underline;
        }
        
        @media (max-width: 768px) {
            .demo-sidebar {
                padding: 2rem 1.5rem;
            }
            
            .demo-form-section {
                padding: 2rem 1.5rem;
            }
            
            .time-slot {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <div class="demo-container">
        <div class="container">
            <div class="demo-card">
                <div class="row g-0">
                    <!-- Sidebar -->
                    <div class="col-lg-5">
                        <div class="demo-sidebar">
                            <div class="logo-section">
                                <div class="logo-icon">
                                    <i class="bi bi-shop"></i>
                                </div>
                                <h2>Request a Demo</h2>
                                <p>See Horntech LTD in action with a personalized demonstration tailored to your business needs.</p>
                            </div>
                            
                            <ul class="demo-features">
                                <li>
                                    <div class="feature-icon">
                                        <i class="bi bi-clock"></i>
                                    </div>
                                    <div class="feature-text">
                                        <h6>30-Minute Session</h6>
                                        <p>Quick, focused demo covering key features</p>
                                    </div>
                                </li>
                                
                                <li>
                                    <div class="feature-icon">
                                        <i class="bi bi-person-video2"></i>
                                    </div>
                                    <div class="feature-text">
                                        <h6>Live with Expert</h6>
                                        <p>Interactive session with our product specialist</p>
                                    </div>
                                </li>
                                
                                <li>
                                    <div class="feature-icon">
                                        <i class="bi bi-card-checklist"></i>
                                    </div>
                                    <div class="feature-text">
                                        <h6>Customized Walkthrough</h6>
                                        <p>Demo tailored to your industry and needs</p>
                                    </div>
                                </li>
                                
                                <li>
                                    <div class="feature-icon">
                                        <i class="bi bi-question-circle"></i>
                                    </div>
                                    <div class="feature-text">
                                        <h6>Q&A Session</h6>
                                        <p>Get all your questions answered</p>
                                    </div>
                                </li>
                                
                                <li>
                                    <div class="feature-icon">
                                        <i class="bi bi-gift"></i>
                                    </div>
                                    <div class="feature-text">
                                        <h6>Free Trial Access</h6>
                                        <p>14-day trial immediately after demo</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Form -->
                    <div class="col-lg-7">
                        <div class="demo-form-section">
                            <h1 class="form-title">Schedule Your Demo</h1>
                            <p class="form-subtitle">Fill in the details below and we'll get back to you shortly</p>
                            
                            <form id="demoForm" action="saas-demo-confirmation-horntech.html">
                                <!-- Contact Information -->
                                <div class="mb-4">
                                    <h6 class="text-primary fw-bold mb-3">Contact Information</h6>
                                    
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">First Name <span class="required">*</span></label>
                                            <input type="text" class="form-control" placeholder="John" required>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label class="form-label">Last Name <span class="required">*</span></label>
                                            <input type="text" class="form-control" placeholder="Smith" required>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label class="form-label">Email <span class="required">*</span></label>
                                            <input type="email" class="form-control" placeholder="john@company.com" required>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label class="form-label">Phone <span class="required">*</span></label>
                                            <input type="tel" class="form-control" placeholder="+966 50 123 4567" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Company Information -->
                                <div class="mb-4">
                                    <h6 class="text-primary fw-bold mb-3">Company Information</h6>
                                    
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Company Name <span class="required">*</span></label>
                                            <input type="text" class="form-control" placeholder="Your Company" required>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label class="form-label">Job Title <span class="required">*</span></label>
                                            <input type="text" class="form-control" placeholder="CEO, Manager, etc." required>
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
                                        
                                        <div class="col-12">
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
                                    </div>
                                </div>
                                
                                <!-- Demo Preferences -->
                                <div class="mb-4">
                                    <h6 class="text-primary fw-bold mb-3">Demo Preferences</h6>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Preferred Date <span class="required">*</span></label>
                                        <input type="date" class="form-control" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Preferred Time <span class="required">*</span></label>
                                        <div class="time-slot">
                                            <div class="time-slot-btn" onclick="selectTime(this)">09:00 AM</div>
                                            <div class="time-slot-btn" onclick="selectTime(this)">10:00 AM</div>
                                            <div class="time-slot-btn" onclick="selectTime(this)">11:00 AM</div>
                                            <div class="time-slot-btn" onclick="selectTime(this)">02:00 PM</div>
                                            <div class="time-slot-btn" onclick="selectTime(this)">03:00 PM</div>
                                            <div class="time-slot-btn" onclick="selectTime(this)">04:00 PM</div>
                                        </div>
                                        <input type="hidden" id="selectedTime" name="time" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Areas of Interest</label>
                                        <div class="row g-2">
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="inventory">
                                                    <label class="form-check-label" for="inventory">Inventory Management</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="sales">
                                                    <label class="form-check-label" for="sales">Sales Management</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="accounting">
                                                    <label class="form-check-label" for="accounting">Accounting & Finance</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="purchasing">
                                                    <label class="form-check-label" for="purchasing">Purchase Management</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="crm">
                                                    <label class="form-check-label" for="crm">CRM</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="hrm">
                                                    <label class="form-check-label" for="hrm">HR Management</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Additional Notes</label>
                                        <textarea class="form-control" placeholder="Tell us about your specific requirements or questions..."></textarea>
                                    </div>
                                </div>
                                
                                <!-- Submit -->
                                <button type="submit" class="btn btn-success w-100 mb-3">
                                    <i class="bi bi-calendar-check me-2"></i>Schedule Demo
                                </button>
                                
                                <div class="text-center text-muted">
                                    <small>We'll confirm your demo within 24 hours</small>
                                </div>
                            </form>
                            
                            <!-- Info Box -->
                            <div class="info-box">
                                <h6>
                                    <i class="bi bi-info-circle"></i>
                                    What happens next?
                                </h6>
                                <p>After submitting this form, our team will review your request and send you a calendar invite with a meeting link within 24 hours.</p>
                            </div>
                            
                            <!-- Back Link -->
                            <div class="back-link">
                                <a href="saas-landing-page-horntech.html">
                                    <i class="bi bi-arrow-left me-2"></i>Back to Home
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Time Slot Selection
        function selectTime(element) {
            // Remove selection from all slots
            document.querySelectorAll('.time-slot-btn').forEach(btn => {
                btn.classList.remove('selected');
            });
            
            // Add selection to clicked slot
            element.classList.add('selected');
            
            // Store value in hidden input
            document.getElementById('selectedTime').value = element.textContent;
        }
        
        // Set minimum date to today
        document.querySelector('input[type="date"]').min = new Date().toISOString().split('T')[0];
        
        // Form validation
        document.getElementById('demoForm').addEventListener('submit', function(e) {
            const selectedTime = document.getElementById('selectedTime').value;
            if (!selectedTime) {
                e.preventDefault();
                alert('Please select a preferred time slot');
                return false;
            }
        });
    </script>
</body>
</html>
