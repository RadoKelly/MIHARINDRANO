<link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
<link rel="stylesheet" href="{{ asset('css/all.min.css') }}">

<!-- partial:index.partial.html -->
<div id="nav-bar">
  <input id="nav-toggle" type="checkbox"/>
  <div id="nav-header"><a id="nav-title" target="_blank">C<i class="fab fa-codepen"></i>DEPEN</a>
    <label for="nav-toggle"><span id="nav-toggle-burger"></span></label>
    <hr/>
  </div>
  <div id="nav-content">
    <a class="nav-button" href="{{ route('clients.index',['site'=>$site->id]) }}"><i class="fas fa-palette"></i><span>Client</span></a>
    <a class="nav-button" href="{{ route('compteur.index',['site'=>$site->id]) }}"><i class="fas fa-palette"></i><span>Compteur/Tarif</span></a>
    <a class="nav-button" href="{{ route('consommation.index',['site'=>$site->id]) }}"><i class="fas fa-images"></i><span>Consommation</span></a>
    <a class="nav-button" href="{{ route('facture.index',['site'=>$site->id]) }}"><i class="fas fa-thumbtack"></i><span>Facture</span></a>
    <hr/>
    <a class="nav-button" href="{{ route('payement.index',['site'=>$site->id]) }}"><i class="fas fa-heart"></i><span>Payement</span></a>
    <a class="nav-button" href="{{ route('caisse.index',['site'=>$site->id]) }}"><i class="fas fa-chart-line"></i><span>Caisse</span></a>
    <div id="nav-content-highlight"></a></div>
  </div>
  <input id="nav-footer-toggle" type="checkbox"/>
  <div id="nav-footer">
    <div id="nav-footer-heading">
      <div id="nav-footer-avatar"><img src="https://gravatar.com/avatar/4474ca42d303761c2901fa819c4f2547"/></div>
      <div id="nav-footer-titlebox"><a id="nav-footer-title" href="https://codepen.io/uahnbu/pens/public" target="_blank">uahnbu</a><span id="nav-footer-subtitle">Admin</span></div>
      <label for="nav-footer-toggle"><i class="fas fa-caret-up"></i></label>
    </div>
    <div id="nav-footer-content">
      <Lorem>ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</Lorem>
    </div>
  </div>
</div>
<!-- partial -->

