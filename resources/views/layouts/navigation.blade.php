<nav class="border-b border-slate-200 bg-white">
    <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-4 px-4 py-4">
        <a href="{{ route('dashboard') }}" class="text-lg font-bold tracking-tight text-slate-900">
            SIPeIP
        </a>

        @auth
            <div class="flex flex-wrap items-center gap-3">
                <div class="flex flex-wrap gap-1 rounded-lg bg-slate-100 p-1 text-sm font-medium">
                    <a href="{{ route('dashboard') }}"
                       class="rounded-md px-3 py-1.5 transition {{ request()->routeIs('dashboard') ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                        Inicio
                    </a>
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('users.index') }}"
                           class="rounded-md px-3 py-1.5 transition {{ request()->routeIs('users.*') ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                            Usuarios
                        </a>
                    @else
                        <span class="rounded-md px-3 py-1.5 text-slate-400">Usuarios</span>
                    @endif
                    <span class="rounded-md px-3 py-1.5 text-slate-400">Entidades</span>
                    <span class="rounded-md px-3 py-1.5 text-slate-400">Objetivos</span>
                    <span class="rounded-md px-3 py-1.5 text-slate-400">Planes</span>
                    <span class="rounded-md px-3 py-1.5 text-slate-400">Reportes</span>
                </div>

                <a href="{{ route('profile.edit') }}"
                   class="hidden rounded-md px-3 py-1.5 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 sm:inline-flex">
                    Mi perfil
                </a>

                <span class="hidden text-sm text-slate-600 sm:inline">{{ auth()->user()->name }}</span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-sm font-medium text-slate-700 hover:bg-slate-50">
                        Salir
                    </button>
                </form>
            </div>
        @else
            <div class="flex items-center gap-2 text-sm font-medium">
                <a href="{{ route('login') }}" class="rounded-lg px-3 py-2 text-slate-700 hover:bg-slate-100">
                    Iniciar sesion
                </a>
                <a href="{{ route('register') }}" class="rounded-lg bg-slate-900 px-3 py-2 text-white hover:bg-slate-800">
                    Registrarse
                </a>
            </div>
        @endauth
    </div>
</nav>
