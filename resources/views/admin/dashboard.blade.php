<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Tableau de bord Radonirina</h1>
        <p>Bienvenue, {{ auth()->user()->name }} !</p>
        <!-- Contenu spécifique à l'admin -->
    </div>
@endsection