@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-body text-center">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                
            </div>
        </div>
    </div>
    <div class="row my-3 align-items-center">
        <div class="col-12 col-md-6">
            <img class="img-fluid py-2" src="{{asset('/images/creaappartamento.png')}}" alt="">
        </div>
        <div class="col-12 col-md-6">
            <p class="font-weight-bold">Inserisci un altro appartamento sulla nostra piattaforma, noi penseremo a metterti in contatto con viaggiatori da tutto il mondo!</p>
            <a class="btn btn-link my-3 text-decoration-none"href="{{route('admin.apartments.create')}}"><i class="fa-solid fa-house-chimney"></i> Crea appartamento</a>
        </div>
    </div>
    <div class="row my-3 align-items-center py-3">
         <div class="col-12 col-md-6">
            <img class="img-fluid py-2" src="{{asset('/images/modificaappartamenti.png')}}" alt="">
        </div>
        <div class="col-12 col-md-6">
            <p class="font-weight-bold">Accedi alla lista dei tuoi appartamenti, potrai visualizzarne e/o eliminarne le informazioni, e nel caso dovesse servire, eliminarli.</p>
            <a class="btn btn-link my-3 text-decoration-none"href="{{route('admin.apartments.index')}}"><i class="fa-solid fa-magnifying-glass"></i> Visualizza i tuoi appartamenti</a>
        </div>
    </div>
    <div class="row my-3 align-items-center py-3">
        <div class="col-12 col-md-6">
            <img class="img-fluid py-2" src="{{asset('/images/sponsorizza.png')}}" alt="">
        </div>
        <div class="col-12 col-md-6">
            <p class="font-weight-bold">Metti in risalto i tuoi appartamenti, compariranno nella home page e in cima ai risultati di ricerca, il guadagno extra è dietro l'angolo!</p>
            <a class="btn btn-link my-3 text-decoration-none"href="{{route('admin.sponsorships.index')}}"><i class="fa-solid fa-magnifying-glass-dollar"></i> Sponsorizza un appartamento</a>
        </div>
    </div>
</div>


@endsection
