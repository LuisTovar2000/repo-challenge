<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - E-commerce</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-white shadow">
        <div class="container mx-auto px-6 py-3">
            <div class="flex justify-between items-center">
                <div>
                    <a href="{{ route('home') }}" class="text-xl font-bold text-gray-800">E-commerce</a>
                </div>
                <div>
                    <a href="{{ url('admin/login') }}" class="text-gray-800 text-sm font-semibold hover:text-blue-600">Login</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="bg-blue-600 text-white text-center py-16">
        <h1 class="text-4xl font-bold">Bienvenido a Nuestro E-commerce</h1>
        <p class="mt-4 text-lg">Explora nuestros productos y encuentra lo que necesitas</p>
    </header>

    <!-- Product Section -->
    <section class="container mx-auto px-6 py-12">
        <h2 class="text-2xl font-bold text-gray-800">Productos Destacados</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
            @forelse($products as $product)
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <img src="https://via.placeholder.com/400x300" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-800">{{ $product->name }}</h3>
                        <p class="text-gray-600 mt-2">{{ $product->price }} {{ $product->currency }}</p>
                        <a href="#" class="mt-4 block text-blue-600 font-semibold hover:text-blue-800">Ver más</a>
                    </div>
                </div>
            @empty
                <p class="col-span-3 text-gray-600">No hay productos disponibles.</p>
            @endforelse
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 E-commerce. Todos los derechos reservados.</p>
        </div>
    </footer>

</body>
</html>
