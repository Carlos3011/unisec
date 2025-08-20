<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Panel de Administración - UNISEC</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  @vite('resources/css/app.css')
  <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>
</head>
<body class="bg-black font-['Inter']">
  <!-- Capa de partículas -->
  <div class="fixed inset-0 z-0 pointer-events-none">
    <canvas id="starsCanvas" class="absolute inset-0 w-full h-full"></canvas>
  </div>
  
  <div class="flex h-screen">
    <!-- Sidebar -->
    <aside class="w-72 bg-gradient-to-b from-primary-500 to-purple-700 shadow-xl h-full p-6 text-gray-100 space-y-6">
      <!-- Logo y Título -->
      <div class="flex flex-col items-center space-y-4 pb-6 border-b border-white/10">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
          <img src="{{ asset('images/logo.png') }}" alt="Logo de UniSec" class="w-36 h-auto">
        </a>
        <h2 class="text-xl font-semibold text-white/90">Panel de Control</h2>
      </div>

      <!-- Menú Principal -->
      <nav class="space-y-2">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-white/10 transition-all group">
          <i class="fas fa-home text-lg w-6 text-center text-white/80 group-hover:text-white"></i>
          <span class="ml-3 font-medium">Dashboard</span>
        </a>

        <!-- Gestión Académica -->
        <div x-data="{ open: false }" class="relative">
          <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 rounded-lg hover:bg-white/10 transition-all group">
            <div class="flex items-center">
              <i class="fas fa-cogs text-lg w-6 text-center text-white/80 group-hover:text-white"></i>
              <span class="ml-3 font-medium">Gestión Académica</span>
            </div>
            <i class="fas fa-chevron-down text-sm transition-transform" :class="{ 'transform rotate-180': open }"></i>
          </button>
          <div x-show="open" class="mt-2 space-y-1" x-collapse>
            <div class="pl-10 border-l-2 border-white/10">
              <a href="{{ route('admin.categorias.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/10 transition-all text-sm">
                <i class="fas fa-tags mr-2"></i>Categorías
              </a>
              <a href="{{ route('admin.cursos.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/10 transition-all text-sm">
                <i class="fas fa-book mr-2"></i>Cursos
              </a>
              <a href="{{ route('admin.talleres.index')}}" class="block px-4 py-2 rounded-lg hover:bg-white/10 transition-all text-sm">
                <i class="fas fa-chalkboard mr-2"></i>Talleres
              </a>
              <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/10 transition-all text-sm">
                <i class="fas fa-presentation mr-2"></i>Ponencias
              </a>
            </div>
          </div>
        </div>

        <!-- Gestión de Concursos -->
        <div x-data="{ open: false }" class="relative">
          <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 rounded-lg hover:bg-white/10 transition-all group">
            <div class="flex items-center">
              <i class="fa-solid fa-medal text-lg w-6 text-center text-white/80 group-hover:text-white"></i>
              <span class="ml-3 font-medium">Gestión Concursos</span>
            </div>
            <i class="fas fa-chevron-down text-sm transition-transform" :class="{ 'transform rotate-180': open }"></i>
          </button>
          <div x-show="open" class="mt-2 space-y-1" x-collapse>
            <div class="pl-10 border-l-2 border-white/10">
              <a href="{{ route('admin.concursos.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/10 transition-all text-sm">
                <i class="fas fa-list mr-2"></i>Concursos
              </a>
              <a href="{{ route('admin.concursos.convocatorias.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/10 transition-all text-sm">
                <i class="fas fa-bullhorn mr-2"></i>Convocatorias
              </a>
              <a href="{{ route('admin.concursos.pre-registros.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/10 transition-all text-sm">
                <i class="fas fa-clipboard-list mr-2"></i>Pre-Registro
              </a>
            </div>
          </div>
        </div>

        <!-- Gestión de Congresos -->
        <div x-data="{ open: false }" class="relative">
          <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 rounded-lg hover:bg-white/10 transition-all group">
            <div class="flex items-center">
              <i class="fa-solid fa-graduation-cap text-lg w-6 text-center text-white/80 group-hover:text-white"></i>
              <span class="ml-3 font-medium">Gestión Congresos</span>
            </div>
            <i class="fas fa-chevron-down text-sm transition-transform" :class="{ 'transform rotate-180': open }"></i>
          </button>
          <div x-show="open" class="mt-2 space-y-1" x-collapse>
            <div class="pl-10 border-l-2 border-white/10">
              <a href="{{ route('admin.congresos.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/10 transition-all text-sm">
                <i class="fas fa-list mr-2"></i>Congresos
              </a>
              <a href="{{ route('admin.congresos.convocatorias.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/10 transition-all text-sm">
                <i class="fas fa-bullhorn mr-2"></i>Convocatorias
              </a>
              <a href="{{ route('admin.congresos.inscripciones.index')  }}" class="block px-4 py-2 rounded-lg hover:bg-white/10 transition-all text-sm">
                <i class="fas fa-user-plus mr-2"></i>Inscripciones
              </a>
            </div>
          </div>
        </div>

        <!-- Gestión de Noticias -->
        <div x-data="{ open: false }" class="relative">
          <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 rounded-lg hover:bg-white/10 transition-all group">
            <div class="flex items-center">
              <i class="fas fa-newspaper text-lg w-6 text-center text-white/80 group-hover:text-white"></i>
              <span class="ml-3 font-medium">Gestión Noticias</span>
            </div>
            <i class="fas fa-chevron-down text-sm transition-transform" :class="{ 'transform rotate-180': open }"></i>
          </button>
          <div x-show="open" class="mt-2 space-y-1" x-collapse>
            <div class="pl-10 border-l-2 border-white/10">
              <a href="{{ route('admin.noticias.secciones.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/10 transition-all text-sm">
                <i class="fas fa-folder mr-2"></i>Secciones
              </a>
              <a href="{{ route('admin.noticias.noticia.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/10 transition-all text-sm">
                <i class="fas fa-file-alt mr-2"></i>Noticias
              </a>
            </div>
          </div>
        </div>

        <!-- Gestión de Usuarios -->
        <div x-data="{ open: false }" class="relative">
          <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 rounded-lg hover:bg-white/10 transition-all group">
            <div class="flex items-center">
              <i class="fas fa-user-tie text-lg w-6 text-center text-white/80 group-hover:text-white"></i>
              <span class="ml-3 font-medium">Gestión de Usuarios</span>
            </div>
            <i class="fas fa-chevron-down text-sm transition-transform" :class="{ 'transform rotate-180': open }"></i>
          </button>
          <div x-show="open" class="mt-2 space-y-1" x-collapse>
            <div class="pl-10 border-l-2 border-white/10">
              <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/10 transition-all text-sm">
                <i class="fas fa-users mr-2"></i>Usuarios
              </a>
              <a href="{{ route('admin.ponentes.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/10 transition-all text-sm">
                <i class="fas fa-chalkboard-teacher mr-2"></i>Ponentes
              </a>
            </div>
          </div>
        </div>

        <!-- Administración Financiera -->
        <div x-data="{ open: false }" class="relative">
          <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 rounded-lg hover:bg-white/10 transition-all group">
            <div class="flex items-center">
              <i class="fas fa-file-invoice text-lg w-6 text-center text-white/80 group-hover:text-white"></i>
              <span class="ml-3 font-medium">Administración Financiera</span>
            </div>
            <i class="fas fa-chevron-down text-sm transition-transform" :class="{ 'transform rotate-180': open }"></i>
          </button>
          <div x-show="open" class="mt-2 space-y-1" x-collapse>
            <div class="pl-10 border-l-2 border-white/10">
              <a href="{{ route('admin.pagos-terceros.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/10 transition-all text-sm">
                <i class="fas fa-exchange-alt mr-2"></i>Pagos Transferencias Concurso
              </a>
              <a href="{{ route('admin.congresos.pagos-terceros.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/10 transition-all text-sm">
                <i class="fas fa-exchange-alt mr-2"></i>Pagos Transferencias Congreso
              </a>
              <a href="{{ route('admin.becas') }}" class="block px-4 py-2 rounded-lg hover:bg-white/10 transition-all text-sm">
                <i class="fas fa-gift mr-2"></i>Becas
              </a>
            </div>
          </div>
        </div>

        <!-- Pagos con PayPal -->
        <div x-data="{ open: false }" class="relative">
          <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 rounded-lg hover:bg-white/10 transition-all group">
            <div class="flex items-center">
              <i class="fab fa-paypal text-lg w-6 text-center text-white/80 group-hover:text-white"></i>
              <span class="ml-3 font-medium">Pagos con PayPal</span>
            </div>
            <i class="fas fa-chevron-down text-sm transition-transform" :class="{ 'transform rotate-180': open }"></i>
          </button>
          <div x-show="open" class="mt-2 space-y-1" x-collapse>
            <div class="pl-10 border-l-2 border-white/10">
              <a href="{{ route('admin.pagos.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/10 transition-all text-sm">
                <i class="fas fa-credit-card mr-2"></i>Pagos Concursos
              </a>
              <a href="{{ route('admin.congresos.pagos.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/10 transition-all text-sm">
                <i class="fas fa-credit-card mr-2"></i>Pagos Congresos
              </a>
            </div>
          </div>
        </div>

        
        <!-- Separador -->
        <div class="border-t border-white/10 my-4"></div>

        <!-- Perfil de Usuario -->
        <div x-data="{ open: false }" class="relative">
          <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 rounded-lg hover:bg-white/10 transition-all group">
            <div class="flex items-center">
              <i class="fas fa-user-circle text-lg w-6 text-center text-white/80 group-hover:text-white"></i>
              <span class="ml-3 font-medium">{{ Auth::user()->name }}</span>
            </div>
            <i class="fas fa-chevron-down text-sm transition-transform" :class="{ 'transform rotate-180': open }"></i>
          </button>
          <div x-show="open" class="mt-2 space-y-1" x-collapse>
            <div class="pl-10 border-l-2 border-white/10">
              <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/10 transition-all text-sm">
                <i class="fas fa-user-cog mr-2"></i>Perfil
              </a>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 rounded-lg hover:bg-white/10 transition-all text-sm">
                  <i class="fas fa-sign-out-alt mr-2"></i>Cerrar Sesión
                </button>
              </form>
            </div>
          </div>
        </div>
      </nav>
    </aside>
    
    <!-- Contenido Principal -->
    <main class="flex-1 p-8 overflow-auto  shadow-md rounded-lg">
      @yield('contenido')
    </main>
  </div>

  @vite('resources/js/app.js')
  @stack('scripts')

  <style>
    /* Estilos para el sidebar */
    .sidebar-link {
      @apply flex items-center px-4 py-3 rounded-lg transition-all;
    }
    
    .sidebar-link:hover {
      @apply bg-white/10;
    }
    
    .sidebar-icon {
      @apply w-6 text-center text-white/80;
    }
    
    .sidebar-link:hover .sidebar-icon {
      @apply text-white;
    }
    
    /* Animación para los submenús */
    [x-cloak] {
      display: none !important;
    }
    
    /* Estilo para el menú activo */
    .active-menu {
      @apply bg-white/20;
    }
    
    .active-menu .sidebar-icon {
      @apply text-white;
    }
  </style>
</body>
</html>