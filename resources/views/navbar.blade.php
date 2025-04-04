<link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
{{-- <link rel="stylesheet" href="{{ asset('css/all.min.css') }}"> --}}

<div id="nav-bar">
  <input id="nav-toggle" type="checkbox"/>
  <div id="nav-header">
    <a id="nav-title" target="_blank">MIHARINDRANO</a> 
    <label for="nav-toggle"><span id="nav-toggle-burger"></span></label>
    <hr/>
  </div>
  <div id="nav-content">
    {{-- On applique la classe "active" si la route correspond --}}
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

    <a class="nav-button {{ request()->routeIs('facture.index') ? 'active' : '' }}" 
       href="{{ route('facture.index', ['site' => $site->id]) }}">
       <i class="fas fa-file-invoice"></i><span>Facture</span>
    </a>

    <hr/>

    <a class="nav-button {{ request()->routeIs('caisse.index') ? 'active' : '' }}" 
       href="{{ route('caisse.index', ['site' => $site->id]) }}">
       <i class="fas fa-cash-register"></i><span>Caisse</span>
    </a>

    <div id="nav-content-highlight"></div>
  </div>

</div>
