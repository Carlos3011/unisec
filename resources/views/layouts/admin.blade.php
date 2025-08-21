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
    <aside class="w-80 bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 shadow-2xl h-full p-6 text-gray-100 space-y-6 border-r border-purple-500/20">
      <!-- Logo y Título -->
      <div class="flex flex-col items-center space-y-4 pb-6 border-b border-purple-400/30">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 hover:scale-105 transition-transform duration-300">
          <img src="{{ asset('images/logo.png') }}" alt="Logo de UniSec" class="w-40 h-auto drop-shadow-lg">
        </a>
        <div class="text-center">
          <h2 class="text-xl font-bold text-white bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">Panel de Control</h2>
          <p class="text-sm text-purple-300/80 mt-1">Administración UNISEC</p>
        </div>
      </div>

      <!-- Menú Principal -->
      <nav class="space-y-2">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-gradient-to-r hover:from-purple-600/30 hover:to-pink-600/30 transition-all duration-300 group border border-transparent hover:border-purple-400/30">
          <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
            <i class="fas fa-home text-white text-sm"></i>
          </div>
          <span class="ml-3 font-medium text-white group-hover:text-purple-200">Dashboard</span>
        </a>

        <!-- Gestión Académica -->
        <div x-data="{ open: false }" class="relative">
          <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 rounded-xl hover:bg-gradient-to-r hover:from-blue-600/30 hover:to-cyan-600/30 transition-all duration-300 group border border-transparent hover:border-blue-400/30">
            <div class="flex items-center">
              <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-cogs text-white text-sm"></i>
              </div>
              <span class="ml-3 font-medium text-white group-hover:text-blue-200">Gestión Académica</span>
            </div>
            <i class="fas fa-chevron-down text-sm transition-transform duration-300 text-blue-300" :class="{ 'transform rotate-180': open }"></i>
          </button>
          <div x-show="open" class="mt-2 space-y-1" x-collapse>
            <div class="pl-12 border-l-2 border-blue-400/30 ml-2">
              <a href="{{ route('admin.categorias.index') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-500/20 transition-all text-sm group">
                <i class="fas fa-tags mr-3 text-blue-400 group-hover:text-blue-300"></i>
                <span class="text-gray-300 group-hover:text-white">Categorías</span>
              </a>
              <!-- <a href="{{ route('admin.cursos.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/10 transition-all text-sm">
                <i class="fas fa-book mr-2"></i>Cursos
              </a>
              <a href="{{ route('admin.talleres.index')}}" class="block px-4 py-2 rounded-lg hover:bg-white/10 transition-all text-sm">
                <i class="fas fa-chalkboard mr-2"></i>Talleres
              </a>
              <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/10 transition-all text-sm">
                <i class="fas fa-presentation mr-2"></i>Ponencias
              </a> -->
            </div>
          </div>
        </div>

        <!-- Gestión de Concursos -->
        <div x-data="{ open: false }" class="relative">
          <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 rounded-xl hover:bg-gradient-to-r hover:from-yellow-600/30 hover:to-orange-600/30 transition-all duration-300 group border border-transparent hover:border-yellow-400/30">
            <div class="flex items-center">
              <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-yellow-500 to-orange-500 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <i class="fa-solid fa-medal text-white text-sm"></i>
              </div>
              <span class="ml-3 font-medium text-white group-hover:text-yellow-200">Gestión Concursos</span>
            </div>
            <i class="fas fa-chevron-down text-sm transition-transform duration-300 text-yellow-300" :class="{ 'transform rotate-180': open }"></i>
          </button>
          <div x-show="open" class="mt-2 space-y-1" x-collapse>
            <div class="pl-12 border-l-2 border-yellow-400/30 ml-2">
              <a href="{{ route('admin.concursos.index') }}" class="block px-4 py-2 rounded-lg hover:bg-yellow-500/20 transition-all text-sm group">
                <i class="fas fa-list mr-3 text-yellow-400 group-hover:text-yellow-300"></i>
                <span class="text-gray-300 group-hover:text-white">Concursos</span>
              </a>
              <a href="{{ route('admin.concursos.convocatorias.index') }}" class="block px-4 py-2 rounded-lg hover:bg-yellow-500/20 transition-all text-sm group">
                <i class="fas fa-bullhorn mr-3 text-yellow-400 group-hover:text-yellow-300"></i>
                <span class="text-gray-300 group-hover:text-white">Convocatorias</span>
              </a>
              <a href="{{ route('admin.concursos.pre-registros.index') }}" class="block px-4 py-2 rounded-lg hover:bg-yellow-500/20 transition-all text-sm group">
                <i class="fas fa-clipboard-list mr-3 text-yellow-400 group-hover:text-yellow-300"></i>
                <span class="text-gray-300 group-hover:text-white">Pre-Registro</span>
              </a>
              <!-- Pagos Transferencias -->
              <div x-data="{ openTransferencias: false }" class="relative">
                <button @click="openTransferencias = !openTransferencias" class="flex items-center justify-between w-full px-4 py-2 rounded-lg hover:bg-yellow-500/20 transition-all text-sm group">
                  <div class="flex items-center">
                    <i class="fas fa-exchange-alt mr-3 text-yellow-400 group-hover:text-yellow-300"></i>
                    <span class="text-gray-300 group-hover:text-white">Pagos Transferencias</span>
                  </div>
                  <i class="fas fa-chevron-down text-xs transition-transform duration-300 text-yellow-300" :class="{ 'transform rotate-180': openTransferencias }"></i>
                </button>
                <div x-show="openTransferencias" class="mt-1 space-y-1" x-collapse>
                  <div class="pl-6 border-l border-yellow-400/30">
                    <a href="{{ route('admin.concursos.pagos-terceros.index') }}" class="block px-3 py-1.5 rounded-lg hover:bg-yellow-500/30 transition-all text-xs group">
                      <i class="fas fa-clipboard-list mr-2 text-yellow-300 group-hover:text-yellow-200"></i>
                      <span class="text-gray-400 group-hover:text-white">Pre-Registro</span>
                    </a>
                    <a href="#" class="block px-3 py-1.5 rounded-lg hover:bg-yellow-500/30 transition-all text-xs opacity-60 group">
                      <i class="fas fa-user-check mr-2 text-yellow-300 group-hover:text-yellow-200"></i>
                      <span class="text-gray-400 group-hover:text-white">Inscripción</span>
                    </a>
                  </div>
                </div>
              </div>
              <!-- Pagos PayPal -->
              <div x-data="{ openPaypal: false }" class="relative">
                <button @click="openPaypal = !openPaypal" class="flex items-center justify-between w-full px-4 py-2 rounded-lg hover:bg-yellow-500/20 transition-all text-sm group">
                  <div class="flex items-center">
                    <i class="fas fa-credit-card mr-3 text-yellow-400 group-hover:text-yellow-300"></i>
                    <span class="text-gray-300 group-hover:text-white">Pagos PayPal</span>
                  </div>
                  <i class="fas fa-chevron-down text-xs transition-transform duration-300 text-yellow-300" :class="{ 'transform rotate-180': openPaypal }"></i>
                </button>
                <div x-show="openPaypal" class="mt-1 space-y-1" x-collapse>
                  <div class="pl-6 border-l border-yellow-400/30">
                    <a href="{{ route('admin.pagos.index') }}" class="block px-3 py-1.5 rounded-lg hover:bg-yellow-500/30 transition-all text-xs group">
                      <i class="fas fa-clipboard-list mr-2 text-yellow-300 group-hover:text-yellow-200"></i>
                      <span class="text-gray-400 group-hover:text-white">Pre-Registro</span>
                    </a>
                    <a href="#" class="block px-3 py-1.5 rounded-lg hover:bg-yellow-500/30 transition-all text-xs opacity-60 group">
                      <i class="fas fa-user-check mr-2 text-yellow-300 group-hover:text-yellow-200"></i>
                      <span class="text-gray-400 group-hover:text-white">Inscripción</span>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Gestión de Congresos -->
        <div x-data="{ open: false }" class="relative">
          <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 rounded-xl hover:bg-gradient-to-r hover:from-green-600/30 hover:to-emerald-600/30 transition-all duration-300 group border border-transparent hover:border-green-400/30">
            <div class="flex items-center">
              <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-green-500 to-emerald-500 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <i class="fa-solid fa-graduation-cap text-white text-sm"></i>
              </div>
              <span class="ml-3 font-medium text-white group-hover:text-green-200">Gestión Congresos</span>
            </div>
            <i class="fas fa-chevron-down text-sm transition-transform duration-300 text-green-300" :class="{ 'transform rotate-180': open }"></i>
          </button>
          <div x-show="open" class="mt-2 space-y-1" x-collapse>
            <div class="pl-12 border-l-2 border-green-400/30 ml-2">
              <a href="{{ route('admin.congresos.index') }}" class="block px-4 py-2 rounded-lg hover:bg-green-500/20 transition-all text-sm group">
                <i class="fas fa-list mr-3 text-green-400 group-hover:text-green-300"></i>
                <span class="text-gray-300 group-hover:text-white">Congresos</span>
              </a>
              <a href="{{ route('admin.congresos.convocatorias.index') }}" class="block px-4 py-2 rounded-lg hover:bg-green-500/20 transition-all text-sm group">
                <i class="fas fa-bullhorn mr-3 text-green-400 group-hover:text-green-300"></i>
                <span class="text-gray-300 group-hover:text-white">Convocatorias</span>
              </a>
              <a href="{{ route('admin.congresos.inscripciones.index')  }}" class="block px-4 py-2 rounded-lg hover:bg-green-500/20 transition-all text-sm group">
                <i class="fas fa-user-plus mr-3 text-green-400 group-hover:text-green-300"></i>
                <span class="text-gray-300 group-hover:text-white">Inscripciones</span>
              </a>
              <!-- Pagos Transferencias -->
              <div x-data="{ openTransferencias: false }" class="relative">
                <button @click="openTransferencias = !openTransferencias" class="flex items-center justify-between w-full px-4 py-2 rounded-lg hover:bg-green-500/20 transition-all text-sm group">
                  <div class="flex items-center">
                    <i class="fas fa-exchange-alt mr-3 text-green-400 group-hover:text-green-300"></i>
                    <span class="text-gray-300 group-hover:text-white">Pagos Transferencias</span>
                  </div>
                  <i class="fas fa-chevron-down text-xs transition-transform duration-300 text-green-300" :class="{ 'transform rotate-180': openTransferencias }"></i>
                </button>
                <div x-show="openTransferencias" class="mt-1 space-y-1" x-collapse>
                  <div class="pl-6 border-l border-green-400/30">
                    <a href="{{ route('admin.congresos.pagos-terceros.index') }}" class="block px-3 py-1.5 rounded-lg hover:bg-green-500/30 transition-all text-xs group">
                      <i class="fas fa-user-check mr-2 text-green-300 group-hover:text-green-200"></i>
                      <span class="text-gray-400 group-hover:text-white">Inscripción</span>
                    </a>
                  </div>
                </div>
              </div>
              <!-- Pagos PayPal -->
              <div x-data="{ openPaypal: false }" class="relative">
                <button @click="openPaypal = !openPaypal" class="flex items-center justify-between w-full px-4 py-2 rounded-lg hover:bg-green-500/20 transition-all text-sm group">
                  <div class="flex items-center">
                    <i class="fas fa-credit-card mr-3 text-green-400 group-hover:text-green-300"></i>
                    <span class="text-gray-300 group-hover:text-white">Pagos PayPal</span>
                  </div>
                  <i class="fas fa-chevron-down text-xs transition-transform duration-300 text-green-300" :class="{ 'transform rotate-180': openPaypal }"></i>
                </button>
                <div x-show="openPaypal" class="mt-1 space-y-1" x-collapse>
                  <div class="pl-6 border-l border-green-400/30">
                    <a href="{{ route('admin.congresos.pagos.index') }}" class="block px-3 py-1.5 rounded-lg hover:bg-green-500/30 transition-all text-xs group">
                      <i class="fas fa-user-check mr-2 text-green-300 group-hover:text-green-200"></i>
                      <span class="text-gray-400 group-hover:text-white">Inscripción</span>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Gestión de Noticias -->
        <div x-data="{ open: false }" class="relative">
          <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 rounded-xl hover:bg-gradient-to-r hover:from-red-600/30 hover:to-pink-600/30 transition-all duration-300 group border border-transparent hover:border-red-400/30">
            <div class="flex items-center">
              <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-red-500 to-pink-500 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-newspaper text-white text-sm"></i>
              </div>
              <span class="ml-3 font-medium text-white group-hover:text-red-200">Gestión Noticias</span>
            </div>
            <i class="fas fa-chevron-down text-sm transition-transform duration-300 text-red-300" :class="{ 'transform rotate-180': open }"></i>
          </button>
          <div x-show="open" class="mt-2 space-y-1" x-collapse>
            <div class="pl-12 border-l-2 border-red-400/30 ml-2">
              <a href="{{ route('admin.noticias.secciones.index') }}" class="block px-4 py-2 rounded-lg hover:bg-red-500/20 transition-all text-sm group">
                <i class="fas fa-folder mr-3 text-red-400 group-hover:text-red-300"></i>
                <span class="text-gray-300 group-hover:text-white">Secciones</span>
              </a>
              <a href="{{ route('admin.noticias.noticia.index') }}" class="block px-4 py-2 rounded-lg hover:bg-red-500/20 transition-all text-sm group">
                <i class="fas fa-file-alt mr-3 text-red-400 group-hover:text-red-300"></i>
                <span class="text-gray-300 group-hover:text-white">Noticias</span>
              </a>
            </div>
          </div>
        </div>

        <!-- Gestión de Usuarios -->
        <div x-data="{ open: false }" class="relative">
          <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 rounded-xl hover:bg-gradient-to-r hover:from-indigo-600/30 hover:to-purple-600/30 transition-all duration-300 group border border-transparent hover:border-indigo-400/30">
            <div class="flex items-center">
              <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-user-tie text-white text-sm"></i>
              </div>
              <span class="ml-3 font-medium text-white group-hover:text-indigo-200">Gestión de Usuarios</span>
            </div>
            <i class="fas fa-chevron-down text-sm transition-transform duration-300 text-indigo-300" :class="{ 'transform rotate-180': open }"></i>
          </button>
          <div x-show="open" class="mt-2 space-y-1" x-collapse>
            <div class="pl-12 border-l-2 border-indigo-400/30 ml-2">
              <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 rounded-lg hover:bg-indigo-500/20 transition-all text-sm group">
                <i class="fas fa-users mr-3 text-indigo-400 group-hover:text-indigo-300"></i>
                <span class="text-gray-300 group-hover:text-white">Usuarios</span>
              </a>
              <a href="{{ route('admin.ponentes.index') }}" class="block px-4 py-2 rounded-lg hover:bg-indigo-500/20 transition-all text-sm group">
                <i class="fas fa-chalkboard-teacher mr-3 text-indigo-400 group-hover:text-indigo-300"></i>
                <span class="text-gray-300 group-hover:text-white">Ponentes</span>
              </a>
            </div>
          </div>
        </div>

        
        <!-- Separador -->
        <div class="border-t border-purple-400/30 my-6"></div>

        <!-- Perfil de Usuario -->
        <div x-data="{ open: false }" class="relative">
          <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 rounded-xl hover:bg-gradient-to-r hover:from-gray-600/30 hover:to-slate-600/30 transition-all duration-300 group border border-transparent hover:border-gray-400/30">
            <div class="flex items-center">
              <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-user-circle text-white text-sm"></i>
              </div>
              <span class="ml-3 font-medium text-white group-hover:text-blue-200">{{ Auth::user()->name }}</span>
            </div>
            <i class="fas fa-chevron-down text-sm transition-transform duration-300 text-gray-300" :class="{ 'transform rotate-180': open }"></i>
          </button>
          <div x-show="open" class="mt-2 space-y-1" x-collapse>
            <div class="pl-12 border-l-2 border-gray-400/30 ml-2">
              <a href="#" class="block px-4 py-2 rounded-lg hover:bg-gray-500/20 transition-all text-sm group">
                <i class="fas fa-user-cog mr-3 text-gray-400 group-hover:text-gray-300"></i>
                <span class="text-gray-300 group-hover:text-white">Perfil</span>
              </a>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 rounded-lg hover:bg-red-500/20 transition-all text-sm group">
                  <i class="fas fa-sign-out-alt mr-3 text-red-400 group-hover:text-red-300"></i>
                  <span class="text-gray-300 group-hover:text-white">Cerrar Sesión</span>
                </button>
              </form>
            </div>
          </div>
        </div>
      </nav>
    </aside>
    
    <!-- Contenido Principal -->
    <main class="flex-1 p-8 overflow-auto  shadow-xl rounded-2xl m-4 ">
      <div class="max-w-7xl mx-auto">
        @yield('contenido')
      </div>
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