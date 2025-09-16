<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materi Online - Platform E-Learning</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .gradient-bg {
            background-image: linear-gradient(to right, #6D28D9, #8B5CF6);
        }
        
        .hero-bg {
            background-image: url('{{ asset('images/grupbelajar.jpg') }}');
            background-size: cover;
            background-position: center;
        }

    </style>
</head>
<body class="bg-gray-50">

    @include('landing.header')

    <main>
        @include('landing.hero')
        @include('landing.fitur')
        @include('landing.kelas')
        @include('landing.alur')
        @include('landing.cta')
    </main>
    
    @include('landing.footer')

    <script>
        // Script untuk mobile menu
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>

</body>
</html>