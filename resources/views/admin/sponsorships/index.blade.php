@extends('layouts.admin')

@section('content')
<h2 class="text-center">Promuovi il tuo appartamento!</h2>
<div class="p-3">
  @if (session()->has('success_message'))
      <div class="alert alert-success mb-3 mt-3">
          {{ session()->get('success_message') }}
      </div>
  @endif
  @if (session()->has('error_message'))
    <div class="alert alert-danger mb-3 mt-3">
        {{ session()->get('error_message') }}
    </div>
  @endif
  <table class="table">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Titolo</th>
        @foreach($sponsors as $sponsor)
          <th scope="col">€{{$sponsor->price}}/{{$sponsor->duration}}h</th>
        @endforeach
      </tr>
    </thead>
    <tbody>
      @foreach ($apartments as $apartment)
      <tr>
        <th scope="row">{{$apartment->id}}</th>
        <td><a href="{{route('admin.apartments.show',$apartment->id)}}" class="apartment_card text-decoration-none text-muted text-black">{{$apartment->title}}</a></td>
        @foreach($sponsors as $sponsor)
        <td>
          <form action="{{route('admin.token')}}" method="POST">
            @csrf
            <input type="hidden" name="sponsorship_id" value="{{$sponsor->id}}">
            <input type="hidden" name="duration" value="{{$sponsor->duration}}">
            <input type="hidden" name="apartment" value="{{$apartment->id}}">
            <input type="hidden" name="price" value="{{$sponsor->price}}">
            <button class="btn silver-btn" type="submit">{{$sponsor->name}}</button>
          </form>
        </td>
        @endforeach
      </tr>
      @endforeach
    </tbody>
  </table>
  <a class="btn btn-link my-2" href="{{route('admin.home')}}"><i class="fa-solid fa-rotate-left"></i> Torna alla Home</a>

</div>

@endsection
