<link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
<link rel="stylesheet" href="{{ asset('css/all.min.css') }}">

<div id="nav-container">
    <input id="nav-toggle" type="checkbox" />
    <div id="nav-bar">
        <div id="nav-header">
            <a id="nav-title" target="_blank">MIHARINDRANO</a>
            <label for="nav-toggle">
                <i id="nav-toggle-icon" class="fas fa-bars"></i>
            </label>
            <hr />
        </div>
        <div id="nav-content">
            <a class="nav-button {{ request()->routeIs('clients.index') ? 'active' : '' }}"
               href="{{ route('clients.index', ['site' => $site->id]) }}">
                <i class="fas fa-users"></i><span>Client</span>
            </a>

            <a class="nav-button {{ request()->routeIs('compteur.index') ? 'active' : '' }}"
               href="{{ route('compteur.index', ['site' => $site->id]) }}">
                <i class="fas fa-faucet"></i><span>Compteur</span>
            </a>

            <a class="nav-button {{ request()->routeIs('consommation.index') ? 'active' : '' }}"
               href="{{ route('tarifs.index', ['site' => $site->id]) }}">
                <i class="fas fa-tint"></i><span>Tarifs</span>
            </a>

            <a class="nav-button {{ request()->routeIs('listeFacture') ? 'active' : '' }}"
               href="{{ route('listeFacture', ['site' => $site->id]) }}">
                <i class="fas fa-file-invoice"></i><span>Facture</span>
            </a>

            <a class="nav-button {{ request()->routeIs('payments.index') ? 'active' : '' }}"
               href="{{ route('payments.index', ['site' => $site->id]) }}">
                <i class="fas fa-money-bill-wave"></i><span>Payment</span>
            </a>

            <hr />

            <div class="nav-section-bottom">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <a class="nav-button logout" onclick="event.preventDefault(); if(confirm('Êtes-vous sûr de vouloir vous déconnecter ?')) document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i><span>Déconnexion</span>
                </a>
            </div>

            <div id="nav-content-highlight"></div>
        
    </div>
</div>

<script>
    document.getElementById('nav-toggle').addEventListener('change', function() {
        var icon = document.getElementById('nav-toggle-icon');
        if (this.checked) {
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-times');
        } else {
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
        }
    });
</script>