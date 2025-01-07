<!-- resources/views/user/dashboard.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Tableau de bord Raaaa</h1>
        <p>Bienvenue, {{ auth()->user()->name }} !</p>
        <!-- Contenu spécifique à l'utilisateur -->
    </div>
@endsection