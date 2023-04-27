@extends('layouts.admin') 

@include('partials/popupdelete')

@section('content')
<div class="container">
         <a class="btn btn-link m-2 text-decoration-none" href="{{route('admin.apartments.index')}}"><i class="fa-solid fa-rotate-left"></i> Torna ai tuoi appartamenti</a>
   <div class="row">
      <div class="col">
         <div class="" class="w-100">
            <div class="container">
               <div class="row">
                  @foreach ($apartment->images as $images)
                  <div class="col-12 col-md-4 col-lg py-1">
                     <img src="{{asset('storage/' . $images->image)}}" class="img-thumbnail" alt="{{ $apartment->title }}">
                  </div>
                  @endforeach
               </div>
            </div>
            <div class="card-body">
               <h3 class="card-title font-weight-bold">{{$apartment->title}}</h3>
               <p class="card-text">{!!$apartment->description!!}</p>
               <p class="card-text">Stanze : {{$apartment->rooms}}</p>
               <p class="card-text">Letti : {{$apartment->beds}}</p>
               <p class="card-text">Bagni : {{$apartment->bathrooms}}</p>
               @if(isset($apartment->square_meters))
                  <p class="card-text">Metri quadrati: {{$apartment->square_meters}}</p>
               @endif
               <p class="card-text">Prezzo : €{{$apartment->price}}/notte</p>
               <span class="card-text">Indirizzo : {{$apartment->address}}</span>
               <p>Servizi :</p>
               <ul>
                  @foreach($apartment->services as $service)
                     <li>{{$service->name}}</li>
                  @endforeach
               </ul>
               @if (count($apartment->messages) > 0)
               <div class="message-box my-3">
                  <h3 class="text-center" >I Tuoi Messaggi</h3>
                  @foreach ($apartment->messages as $message)
                     <div class="card my-2 p-2 message-card shadow-sm">
                        <h4>Inviato da: {{$message->name}}</h4>
                        <span> Del : {{$message->created_at}}</span>
                        <span>Email : {{$message->email}} </span>
                        <p class="my-2"> - {{$message->content}}</p>
                     </div>
                  @endforeach
               </div>
               @endif
               <div class="py-3">
                  <a href="{{route('admin.apartments.edit',$apartment->id)}}" class="btn btn-primary text-decoration-none">Modifica appartamento</a>
               </div>
               <form action="{{route('admin.apartments.destroy',$apartment->id)}}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn"
                  onclick="boolbnb.openModal(event, {{$apartment->id}})">Elimina appartamento</button>
              </form>
            </div>
         </div>
      </div>
   </div>
</div>

@endsection
