<header>
    <div class="search-section">
        <form action="/search" method="get">
            <input type="search" name="query" placeholder="Buscar archivos..." required>
            <input type="submit" value="Buscar">
        </form>
    </div>
    <div class="title">
        @auth
            Bienvenido, {{ Auth::user()->name }}
        @endauth
    </div>
    <div class="auth-section">
        @auth
            <a href="/logout" style="color: white;">Logout</a>
        @else
            <a href="/login" style="color: white;">Login</a>
        @endauth
    </div>
</header>
<aside>
    <h3>Menú</h3>
    <ul>
        <li class="{{ request()->is('/') ? 'active' : '' }}">
            <a href="/">Mi Unidad</a>
        </li>
        <li class="{{ request()->is('trash') ? 'active' : '' }}">
            <a href="/trash">Papelera</a>
        </li>
        <li class="{{ request()->is('shared') ? 'active' : '' }}">
            <a href="/shared">Compartido Conmigo</a>
        </li>
        <li class="{{ request()->is('storage') ? 'active' : '' }}">
            <a href="/storage">Almacenamiento</a>
        </li>
    </ul>
    <!-- etiquetas -->
    <div class="tags-menu">
        <ul>
            @foreach ($tags as $tag)
                <li><a href="/tags/{{ $tag->name }}">{{ $tag->name }}</a></li>
            @endforeach
        </ul>

        <!-- Añadir etiqueta -->
        <form class="add-tag" action="/tags/add" method="POST">
            @csrf
            <input type="text" id="tag-name" name="tag_name" placeholder="Nombre de la etiqueta" required>
            <button type="submit">Añadir Etiqueta</button>
        </form>
    </div>
</aside>
