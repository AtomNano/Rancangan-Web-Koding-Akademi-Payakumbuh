<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Coding Academy Payakumbuh - Platform E-Learning Terpercaya')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo/logo-transparent.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo/logo-transparent.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo/logo-transparent.png') }}">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Color Palette - High Contrast */
            --primary-blue: #1e40af;
            --primary-blue-light: #3b82f6;
            --primary-blue-dark: #1e3a8a;
            --accent-purple: #7c3aed;
            --accent-purple-dark: #6b21a8;
            --text-white: #ffffff;
            --text-white-90: rgba(255, 255, 255, 0.95);
            --text-white-80: rgba(255, 255, 255, 0.85);
            --text-white-70: rgba(255, 255, 255, 0.75);
            
            /* Glass Effects */
            --glass-bg: rgba(255, 255, 255, 0.12);
            --glass-border: rgba(255, 255, 255, 0.25);
            --glass-shadow: rgba(0, 0, 0, 0.15);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            font-weight: 400;
            line-height: 1.7;
            color: var(--text-white);
            background: linear-gradient(135deg, #080d1a 0%, #111827 25%, #1e3a8a 50%, #312e81 75%, #4c1d95 100%);
            background-size: 400% 400%;
            animation: gradientShift 20s ease infinite;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Typography Scale */
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', 'Inter', sans-serif;
            font-weight: 700;
            line-height: 1.2;
            letter-spacing: -0.02em;
        }

        h1 { font-size: clamp(2.5rem, 5vw, 4.5rem); font-weight: 800; }
        h2 { font-size: clamp(2rem, 4vw, 3.5rem); font-weight: 700; }
        h3 { font-size: clamp(1.5rem, 3vw, 2.25rem); font-weight: 600; }
        h4 { font-size: clamp(1.25rem, 2.5vw, 1.75rem); font-weight: 600; }

        p {
            font-size: clamp(1rem, 1.5vw, 1.125rem);
            line-height: 1.75;
            color: var(--text-white-90);
        }

        /* Enhanced Gradient Background Animation */
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .gradient-bg {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 25%, #3b82f6 50%, #6366f1 75%, #7c3aed 100%);
        }
        
        .hero-bg {
            background-image: url('{{ asset('images/grupbelajar.jpg') }}');
            background-size: cover;
            background-position: center;
        }

        /* Enhanced Glassmorphism Styles */
        .glass {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(12px) saturate(180%);
            -webkit-backdrop-filter: blur(12px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 8px 32px 0 rgba(15, 23, 42, 0.4), 
                        inset 0 1px 0 0 rgba(255, 255, 255, 0.2);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glass:hover {
            background: rgba(255, 255, 255, 0.18);
            border-color: rgba(255, 255, 255, 0.35);
            box-shadow: 0 12px 48px 0 rgba(15, 23, 42, 0.5),
                        inset 0 1px 0 0 rgba(255, 255, 255, 0.3);
        }

        .glass-strong {
            background: linear-gradient(135deg, 
                rgba(30, 58, 138, 0.5) 0%, 
                rgba(59, 130, 246, 0.4) 50%, 
                rgba(124, 58, 237, 0.5) 100%);
            backdrop-filter: blur(24px) saturate(180%);
            -webkit-backdrop-filter: blur(24px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 16px 48px 0 rgba(30, 58, 138, 0.4), 
                        0 8px 24px 0 rgba(124, 58, 237, 0.3),
                        inset 0 1px 0 0 rgba(255, 255, 255, 0.25);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glass-strong:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 56px 0 rgba(30, 58, 138, 0.5), 
                        0 12px 32px 0 rgba(124, 58, 237, 0.4),
                        inset 0 1px 0 0 rgba(255, 255, 255, 0.35);
        }

        .glass-card {
            background: linear-gradient(135deg, 
                rgba(255, 255, 255, 0.18) 0%, 
                rgba(255, 255, 255, 0.08) 100%);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 12px 40px 0 rgba(15, 23, 42, 0.3), 
                        0 6px 20px 0 rgba(59, 130, 246, 0.25),
                        inset 0 1px 0 0 rgba(255, 255, 255, 0.2);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glass-card:hover {
            background: linear-gradient(135deg, 
                rgba(255, 255, 255, 0.25) 0%, 
                rgba(255, 255, 255, 0.12) 100%);
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 56px 0 rgba(15, 23, 42, 0.4), 
                        0 12px 32px 0 rgba(59, 130, 246, 0.35),
                        inset 0 1px 0 0 rgba(255, 255, 255, 0.3);
        }

        .glass-nav {
            background: rgba(15, 23, 42, 0.7); /* slate-900/70 */
            backdrop-filter: blur(24px) saturate(180%);
            -webkit-backdrop-filter: blur(24px) saturate(180%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px 0 rgba(15, 23, 42, 0.25);
            transition: all 0.3s ease;
        }

        /* Smooth Scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Enhanced Animations */
        @keyframes blob {
            0%, 100% { 
                transform: translate(0, 0) scale(1); 
            }
            25% { 
                transform: translate(20px, -30px) scale(1.1); 
            }
            50% { 
                transform: translate(0, 40px) scale(0.9); 
            }
            75% { 
                transform: translate(-30px, -20px) scale(1.05); 
            }
        }

        .animate-blob {
            animation: blob 15s infinite ease-in-out;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        .animation-delay-6000 {
            animation-delay: 6s;
        }

        @keyframes gradient {
            0%, 100% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
        }

        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient 4s ease infinite;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            opacity: 0; /* Mulai tersembunyi */
            animation: fadeInUp 0.8s ease-out forwards;
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-slide-in-left {
            animation: slideInLeft 0.8s ease-out forwards;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-slide-in-right {
            animation: slideInRight 0.8s ease-out forwards;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.7;
            }
        }

        .animate-pulse-slow {
            animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 12px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(15, 23, 42, 0.3);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #1e40af, #3b82f6, #6366f1, #7c3aed);
            border-radius: 10px;
            border: 2px solid rgba(15, 23, 42, 0.2);
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #1e3a8a, #2563eb, #4f46e5, #6d28d9);
        }

        /* Section Backgrounds with Glass Effect */
        .section-glass {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            position: relative;
        }

        /* Button Enhancements */
        .btn-primary {
            background-image: linear-gradient(to right, #2563EB, #9333EA); /* blue-600 to purple-600 */
            transition: all 0.3s ease;
            box-shadow: 0 8px 24px rgba(59, 130, 246, 0.4);
        }

        .btn-primary:hover {
            box-shadow: 0 10px 20px rgba(147, 51, 234, 0.3); /* Glow effect */
            transform: translateY(-2px);
        }
        
        /* Shadow Effects dengan Warna */
        .hover\:shadow-blue-500\/30:hover {
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
        }
        
        .hover\:shadow-purple-500\/30:hover {
            box-shadow: 0 10px 25px rgba(168, 85, 247, 0.3);
        }
        
        .hover\:shadow-indigo-500\/30:hover {
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.3);
        }
        
        .hover\:shadow-blue-500\/20:hover {
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.2);
        }

        /* Text Gradient */
        .text-gradient {
            background-image: linear-gradient(to right, #2563EB, #9333EA); /* from-blue-600 to-purple-600 */
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            color: transparent;
        }

        /* Accessibility - High Contrast Text */
        .text-high-contrast {
            color: var(--text-white);
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        /* Responsive Typography */
        @media (max-width: 768px) {
            h1 { font-size: 2.5rem; }
            h2 { font-size: 2rem; }
            h3 { font-size: 1.5rem; }
        }

        /* Scroll Animation Styles */
        .scroll-fade-in {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }

        .scroll-fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .scroll-fade-in-delay-1 {
            transition-delay: 0.1s;
        }

        .scroll-fade-in-delay-2 {
            transition-delay: 0.2s;
        }

        .scroll-fade-in-delay-3 {
            transition-delay: 0.3s;
        }

        /* Smooth Section Transitions */
        section {
            position: relative;
        }

        .section-transition-top {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 150px;
            background: linear-gradient(to bottom, 
                rgba(15, 23, 42, 1) 0%,
                rgba(15, 23, 42, 0.9) 20%,
                rgba(15, 23, 42, 0.7) 40%,
                rgba(15, 23, 42, 0.4) 60%,
                rgba(15, 23, 42, 0.2) 80%,
                transparent 100%);
            pointer-events: none;
            z-index: 1;
        }

        .section-transition-bottom {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 150px;
            background: linear-gradient(to top, 
                rgba(15, 23, 42, 1) 0%,
                rgba(15, 23, 42, 0.9) 20%,
                rgba(15, 23, 42, 0.7) 40%,
                rgba(15, 23, 42, 0.4) 60%,
                rgba(15, 23, 42, 0.2) 80%,
                transparent 100%);
            pointer-events: none;
            z-index: 1;
        }

    </style>
    @yield('styles')
</head>
<body>

    @include('landing.header')

    <main>
        @yield('content')
    </main>
    
    @include('landing.footer')

    <script>
        // Script untuk mobile menu
        document.addEventListener('DOMContentLoaded', function () {
            const menuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (menuButton) {
                menuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
            
            // Opsional: Tutup menu saat link di-klik (untuk navigasi #)
            const menuLinks = document.querySelectorAll('#mobile-menu a[href^="#"]');
            menuLinks.forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenu.classList.add('hidden');
                });
            });

            // Scroll Animation dengan Intersection Observer
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        // Optional: Unobserve setelah animasi untuk performa
                        // observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            // Observe semua elemen dengan class scroll-fade-in
            document.querySelectorAll('.scroll-fade-in').forEach(el => {
                observer.observe(el);
            });

            // Animate child elements dengan delay
            document.querySelectorAll('.scroll-fade-in-children > *').forEach((child, index) => {
                child.classList.add('scroll-fade-in');
                if (index > 0) {
                    child.classList.add(`scroll-fade-in-delay-${Math.min(index, 3)}`);
                }
                observer.observe(child);
            });
        });
    </script>
    @yield('scripts')
</body>
</html>