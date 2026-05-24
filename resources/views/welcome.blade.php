<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grand Hotel — Luxury Stay Experience</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero-bg {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        .fade-in {
            animation: fadeIn 1s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .gold { color: #D4AF37; }
        .bg-gold { background-color: #D4AF37; }
        .border-gold { border-color: #D4AF37; }
        .hover-gold:hover { background-color: #B8960C; }
    </style>
</head>
<body class="bg-gray-50">

    {{-- Navigation --}}
    <nav class="hero-bg shadow-lg fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            {{-- Logo --}}
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gold rounded-full flex items-center justify-center">
                    <i class="fas fa-hotel text-white text-lg"></i>
                </div>
                <div>
                    <h1 class="text-white font-bold text-lg leading-none">Grand Hotel</h1>
                    <p class="text-xs gold">Luxury & Comfort</p>
                </div>
            </div>

            {{-- Nav Links --}}
            <div class="hidden md:flex items-center gap-8">
                <a href="#rooms" class="text-gray-300 hover:text-white text-sm transition">Rooms</a>
                <a href="#amenities" class="text-gray-300 hover:text-white text-sm transition">Amenities</a>
                <a href="#about" class="text-gray-300 hover:text-white text-sm transition">About</a>
                <a href="#contact" class="text-gray-300 hover:text-white text-sm transition">Contact</a>
            </div>

            {{-- Auth Buttons --}}
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('admin.dashboard') }}"
                       class="bg-gold text-white px-5 py-2 rounded-lg text-sm font-medium hover-gold transition">
                        <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="text-gray-300 hover:text-white text-sm transition px-4 py-2">
                        Staff Login
                    </a>
                    <a href="{{ route('register') }}"
                       class="bg-gold text-white px-5 py-2 rounded-lg text-sm font-medium hover-gold transition">
                        Book Now
                    </a>
                @endauth
            </div>

        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="hero-bg min-h-screen flex items-center justify-center pt-20">
        <div class="text-center px-6 fade-in">
            <p class="gold text-sm font-medium tracking-widest uppercase mb-4">
                Welcome to Grand Hotel
            </p>
            <h2 class="text-5xl md:text-7xl font-bold text-white leading-tight mb-6">
                Experience<br>
                <span class="gold">Luxury</span> Living
            </h2>
            <p class="text-gray-300 text-lg md:text-xl max-w-2xl mx-auto mb-10">
                Discover the perfect blend of comfort, elegance, and world-class
                hospitality. Your dream stay awaits at Grand Hotel.
            </p>

            {{-- CTA Buttons --}}
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-16">
                <a href="{{ route('register') }}"
                   class="bg-gold hover-gold text-white px-8 py-4 rounded-xl text-base font-semibold transition w-full sm:w-auto">
                    <i class="fas fa-calendar-check mr-2"></i> Book Your Stay
                </a>
                <a href="#rooms"
                   class="border border-white text-white hover:bg-white hover:text-gray-900 px-8 py-4 rounded-xl text-base font-semibold transition w-full sm:w-auto">
                    <i class="fas fa-door-open mr-2"></i> View Rooms
                </a>
            </div>

            {{-- Quick Stats --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-3xl mx-auto">
                <div class="text-center">
                    <p class="text-4xl font-bold gold">11+</p>
                    <p class="text-gray-400 text-sm mt-1">Luxury Rooms</p>
                </div>
                <div class="text-center">
                    <p class="text-4xl font-bold gold">4</p>
                    <p class="text-gray-400 text-sm mt-1">Room Types</p>
                </div>
                <div class="text-center">
                    <p class="text-4xl font-bold gold">24/7</p>
                    <p class="text-gray-400 text-sm mt-1">Room Service</p>
                </div>
                <div class="text-center">
                    <p class="text-4xl font-bold gold">100%</p>
                    <p class="text-gray-400 text-sm mt-1">Satisfaction</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Room Types Section --}}
    <section id="rooms" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">

            <div class="text-center mb-14">
                <p class="gold text-sm font-medium tracking-widest uppercase mb-2">Our Rooms</p>
                <h3 class="text-4xl font-bold text-gray-800">Choose Your Perfect Room</h3>
                <p class="text-gray-500 mt-3 max-w-xl mx-auto">
                    From cozy standard rooms to lavish executive suites,
                    we have the perfect room for every occasion.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                {{-- Standard Room --}}
                <div class="card-hover bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="h-48 hero-bg flex items-center justify-center">
                        <i class="fas fa-bed text-6xl gold opacity-80"></i>
                    </div>
                    <div class="p-5">
                        <h4 class="font-bold text-gray-800 text-lg">Standard Room</h4>
                        <p class="text-gray-500 text-sm mt-1 mb-3">Perfect for solo travelers and couples</p>
                        <div class="flex flex-wrap gap-1 mb-4">
                            @foreach(['WiFi', 'AC', 'TV'] as $amenity)
                                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full">{{ $amenity }}</span>
                            @endforeach
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-2xl font-bold text-gray-800">$80</span>
                                <span class="text-gray-400 text-sm">/night</span>
                            </div>
                            <a href="{{ route('register') }}"
                               class="bg-gold text-white px-4 py-2 rounded-lg text-sm hover-gold transition">
                                Book Now
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Deluxe Room --}}
                <div class="card-hover bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="h-48 bg-gradient-to-br from-blue-900 to-blue-700 flex items-center justify-center">
                        <i class="fas fa-bed text-6xl text-blue-200 opacity-80"></i>
                    </div>
                    <div class="p-5">
                        <h4 class="font-bold text-gray-800 text-lg">Deluxe Room</h4>
                        <p class="text-gray-500 text-sm mt-1 mb-3">Spacious room with premium furnishings</p>
                        <div class="flex flex-wrap gap-1 mb-4">
                            @foreach(['WiFi', 'AC', 'Mini Bar'] as $amenity)
                                <span class="text-xs bg-blue-50 text-blue-600 px-2 py-1 rounded-full">{{ $amenity }}</span>
                            @endforeach
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-2xl font-bold text-gray-800">$130</span>
                                <span class="text-gray-400 text-sm">/night</span>
                            </div>
                            <a href="{{ route('register') }}"
                               class="bg-gold text-white px-4 py-2 rounded-lg text-sm hover-gold transition">
                                Book Now
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Junior Suite --}}
                <div class="card-hover bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden relative">
                    <div class="absolute top-3 right-3 z-10">
                        <span class="bg-gold text-white text-xs px-2 py-1 rounded-full font-medium">Popular</span>
                    </div>
                    <div class="h-48 bg-gradient-to-br from-purple-900 to-purple-700 flex items-center justify-center">
                        <i class="fas fa-crown text-6xl text-purple-200 opacity-80"></i>
                    </div>
                    <div class="p-5">
                        <h4 class="font-bold text-gray-800 text-lg">Junior Suite</h4>
                        <p class="text-gray-500 text-sm mt-1 mb-3">Suite with separate living area</p>
                        <div class="flex flex-wrap gap-1 mb-4">
                            @foreach(['WiFi', 'Bathtub', 'Lounge'] as $amenity)
                                <span class="text-xs bg-purple-50 text-purple-600 px-2 py-1 rounded-full">{{ $amenity }}</span>
                            @endforeach
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-2xl font-bold text-gray-800">$200</span>
                                <span class="text-gray-400 text-sm">/night</span>
                            </div>
                            <a href="{{ route('register') }}"
                               class="bg-gold text-white px-4 py-2 rounded-lg text-sm hover-gold transition">
                                Book Now
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Executive Suite --}}
                <div class="card-hover bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden relative">
                    <div class="absolute top-3 right-3 z-10">
                        <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full font-medium">Luxury</span>
                    </div>
                    <div class="h-48 bg-gradient-to-br from-yellow-800 to-yellow-600 flex items-center justify-center">
                        <i class="fas fa-gem text-6xl text-yellow-200 opacity-80"></i>
                    </div>
                    <div class="p-5">
                        <h4 class="font-bold text-gray-800 text-lg">Executive Suite</h4>
                        <p class="text-gray-500 text-sm mt-1 mb-3">Luxury suite with panoramic views</p>
                        <div class="flex flex-wrap gap-1 mb-4">
                            @foreach(['Jacuzzi', 'Butler', 'Bar'] as $amenity)
                                <span class="text-xs bg-yellow-50 text-yellow-700 px-2 py-1 rounded-full">{{ $amenity }}</span>
                            @endforeach
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-2xl font-bold text-gray-800">$350</span>
                                <span class="text-gray-400 text-sm">/night</span>
                            </div>
                            <a href="{{ route('register') }}"
                               class="bg-gold text-white px-4 py-2 rounded-lg text-sm hover-gold transition">
                                Book Now
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Amenities Section --}}
    <section id="amenities" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">

            <div class="text-center mb-14">
                <p class="gold text-sm font-medium tracking-widest uppercase mb-2">What We Offer</p>
                <h3 class="text-4xl font-bold text-gray-800">World-Class Amenities</h3>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                @foreach([
                    ['fas fa-wifi', 'Free WiFi', 'High-speed internet'],
                    ['fas fa-swimming-pool', 'Swimming Pool', 'Open 6am - 10pm'],
                    ['fas fa-spa', 'Spa & Wellness', 'Full body treatments'],
                    ['fas fa-utensils', 'Restaurant', '24/7 room service'],
                    ['fas fa-car', 'Airport Transfer', 'Pick up & drop off'],
                    ['fas fa-dumbbell', 'Fitness Center', 'Modern equipment'],
                ] as $amenity)
                    <div class="card-hover bg-white rounded-2xl p-5 text-center shadow-sm border border-gray-100">
                        <div class="w-12 h-12 bg-gold bg-opacity-10 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="{{ $amenity[0] }} gold text-xl"></i>
                        </div>
                        <h4 class="font-semibold text-gray-800 text-sm">{{ $amenity[1] }}</h4>
                        <p class="text-gray-400 text-xs mt-1">{{ $amenity[2] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- About Section --}}
    <section id="about" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

                <div>
                    <p class="gold text-sm font-medium tracking-widest uppercase mb-3">About Us</p>
                    <h3 class="text-4xl font-bold text-gray-800 mb-5">
                        A Legacy of Luxury<br>and Hospitality
                    </h3>
                    <p class="text-gray-500 mb-5 leading-relaxed">
                        Grand Hotel has been providing world-class hospitality services
                        for years. Our commitment to excellence ensures that every guest
                        experiences the finest in comfort, service, and luxury.
                    </p>
                    <p class="text-gray-500 mb-8 leading-relaxed">
                        From our elegantly designed rooms to our exceptional dining
                        experiences, every detail is crafted to make your stay
                        truly unforgettable.
                    </p>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-3xl font-bold gold">4</p>
                            <p class="text-gray-500 text-sm mt-1">Room Categories</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-3xl font-bold gold">11</p>
                            <p class="text-gray-500 text-sm mt-1">Luxury Rooms</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-3xl font-bold gold">6+</p>
                            <p class="text-gray-500 text-sm mt-1">Hotel Services</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-3xl font-bold gold">24/7</p>
                            <p class="text-gray-500 text-sm mt-1">Guest Support</p>
                        </div>
                    </div>
                </div>

                <div class="hero-bg rounded-3xl p-10 text-center">
                    <i class="fas fa-hotel text-9xl gold mb-6 block opacity-80"></i>
                    <h4 class="text-white text-2xl font-bold mb-3">Grand Hotel</h4>
                    <p class="text-gray-300 mb-6">Where luxury meets comfort</p>
                    <div class="flex justify-center gap-4">
                        <div class="text-center">
                            <i class="fas fa-star gold"></i>
                            <i class="fas fa-star gold"></i>
                            <i class="fas fa-star gold"></i>
                            <i class="fas fa-star gold"></i>
                            <i class="fas fa-star gold"></i>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm mt-2">5-Star Rated Hotel</p>
                </div>

            </div>
        </div>
    </section>

    {{-- Services Section --}}
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">

            <div class="text-center mb-14">
                <p class="gold text-sm font-medium tracking-widest uppercase mb-2">Our Services</p>
                <h3 class="text-4xl font-bold text-gray-800">Everything You Need</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach([
                    ['fas fa-concierge-bell', 'Room Service', 'Enjoy delicious meals delivered directly to your room, available 24 hours a day, 7 days a week.', '$15'],
                    ['fas fa-spa', 'Spa Treatment', 'Relax and rejuvenate with our full-body massage and wellness treatments by expert therapists.', '$80'],
                    ['fas fa-car-side', 'Airport Transfer', 'Comfortable and punctual airport pickup and drop-off service for a seamless travel experience.', '$35'],
                ] as $service)
                    <div class="card-hover bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <div class="w-14 h-14 bg-gold bg-opacity-10 rounded-2xl flex items-center justify-center mb-4">
                            <i class="{{ $service[0] }} gold text-2xl"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-lg mb-2">{{ $service[1] }}</h4>
                        <p class="text-gray-500 text-sm mb-4 leading-relaxed">{{ $service[2] }}</p>
                        <p class="gold font-bold text-lg">From {{ $service[3] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Contact Section --}}
    <section id="contact" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">

            <div class="text-center mb-14">
                <p class="gold text-sm font-medium tracking-widest uppercase mb-2">Get In Touch</p>
                <h3 class="text-4xl font-bold text-gray-800">Contact Us</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-3xl mx-auto">
                <div class="text-center">
                    <div class="w-14 h-14 bg-gold bg-opacity-10 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-map-marker-alt gold text-xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-800 mb-1">Address</h4>
                    <p class="text-gray-500 text-sm">Phnom Penh, Cambodia</p>
                </div>
                <div class="text-center">
                    <div class="w-14 h-14 bg-gold bg-opacity-10 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-phone gold text-xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-800 mb-1">Phone</h4>
                    <p class="text-gray-500 text-sm">+855 12 345 678</p>
                </div>
                <div class="text-center">
                    <div class="w-14 h-14 bg-gold bg-opacity-10 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-envelope gold text-xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-800 mb-1">Email</h4>
                    <p class="text-gray-500 text-sm">info@grandhotel.com</p>
                </div>
            </div>

        </div>
    </section>

    {{-- CTA Section --}}
    <section class="hero-bg py-20">
        <div class="max-w-3xl mx-auto px-6 text-center">
            <h3 class="text-4xl font-bold text-white mb-4">
                Ready for an Unforgettable Stay?
            </h3>
            <p class="text-gray-300 mb-8 text-lg">
                Book your room today and experience the finest hospitality
                that Grand Hotel has to offer.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('register') }}"
                   class="bg-gold hover-gold text-white px-8 py-4 rounded-xl text-base font-semibold transition w-full sm:w-auto">
                    <i class="fas fa-calendar-check mr-2"></i> Book Now
                </a>
                <a href="{{ route('login') }}"
                   class="border border-white text-white hover:bg-white hover:text-gray-900 px-8 py-4 rounded-xl text-base font-semibold transition w-full sm:w-auto">
                    <i class="fas fa-sign-in-alt mr-2"></i> Staff Login
                </a>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-400 py-8">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-gold rounded-full flex items-center justify-center">
                        <i class="fas fa-hotel text-white text-sm"></i>
                    </div>
                    <span class="text-white font-semibold">Grand Hotel</span>
                </div>
                <p class="text-sm text-center">
                    © {{ date('Y') }} Grand Hotel. Built with Laravel 12 by
                    <span class="gold">Team Hotel Management System</span> —
                    Royal University of Phnom Penh
                </p>
                <div class="flex gap-4">
                    <a href="{{ route('login') }}" class="text-sm hover:text-white transition">Staff Login</a>
                    <a href="#rooms" class="text-sm hover:text-white transition">Rooms</a>
                    <a href="#contact" class="text-sm hover:text-white transition">Contact</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>