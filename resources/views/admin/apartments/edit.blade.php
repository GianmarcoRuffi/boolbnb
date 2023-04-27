@extends('layouts.admin')

@section('content')
<div class="container">
  <div class="row">
    <div class="col">
      <form action="{{route('admin.apartments.update',$apartment->id)}}" method="POST" enctype="multipart/form-data" autocomplete="off" id="create_form">
        @csrf
        @method('PUT')
        <div class="form-group">
          <label for="Title">Titolo *</label>
          <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" aria-describedby="title" name="title" value="{{$apartment->title}}" required minlength="5">
          @error('title')
              <div class="alert alert-danger">{{$message}}</div>
          @enderror
        </div>
        <div class="form-group">
          <label for="description">Descrizione</label>
          <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" cols="30" rows="15">{{$apartment->description}}</textarea>
          @error('description')
              <div class="alert alert-danger">{{$message}}</div>
          @enderror
        </div>
        <div class="form-group">
          <label for="rooms">Numero di stanze *</label>
          <input type="number" class="form-control @error('rooms') is-invalid @enderror" id="rooms" aria-describedby="rooms" name="rooms" value={{$apartment->rooms}} min=1 max=50 required>
          @error('rooms')
              <div class="alert alert-danger">{{$message}}</div>
          @enderror
        </div>
        <div class="form-group">
          <label for="beds">Posti letto *</label>
          <input type="number" class="form-control @error('beds') is-invalid @enderror" id="beds" aria-describedby="beds" name="beds" value={{$apartment->beds}} min=1 max=50 required>
          @error('beds')
              <div class="alert alert-danger">{{$message}}</div>
          @enderror
        </div>
        <div class="form-group">
          <label for="bathrooms">Bagni in casa *</label>
          <input type="number" class="form-control @error('bathrooms') is-invalid @enderror" id="bathrooms" aria-describedby="bathrooms" name="bathrooms" value={{$apartment->bathrooms}} min=1 max=50 required>
          @error('bathrooms')
              <div class="alert alert-danger">{{$message}}</div>
          @enderror
        </div>
        <div class="form-group">
          <label for="square_meters">Metri quadri</label>
          <input type="number" class="form-control @error('square_meters') is-invalid @enderror" id="square_meters" aria-describedby="square_meters" name="square_meters" value={{$apartment->square_meters}} min="0">
          @error('square_meters')
              <div class="alert alert-danger">{{$message}}</div>
          @enderror
        </div>
        <div class="form-group">
          <label for="price">Prezzo per notte *</label>
          <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" aria-describedby="price" name="price" step=".01" value={{$apartment->price}} required min="1">
          @error('price')
              <div class="alert alert-danger">{{$message}}</div>
          @enderror
        </div>
        
      {{-- select --}}

        <div class="form-group">
          <label for="nation" class="form-label">Nazione *</label>
          <select name="nation" id="nation" class="form-control @error('nation') is-invalid @enderror" required>
            {{-- <option value="">Select Country</option> --}}
          <option value="{{$apartment->nation}}">{{$country}}</option>
            @foreach($countries as $key => $country)
            <option value="{{$key}}">{{$country}}</option>
            @endforeach
          </select>
            @error('nation')
            <div class="alert alert-danger">{{ $message }}</div>
          @enderror
        </div>

      {{-- /select --}}


        <div class="form-group">
          <label for="address">Indirizzo *</label>
          <input type="address" class="form-control @error('address') is-invalid @enderror" id="address" aria-describedby="address" name="address" value='{{$apartment->address}}' required>
          @error('address')
              <div class="alert alert-danger">{{$message}}</div>
          @enderror
          @if (session()->has('message'))
            <div class="alert alert-danger mb-3 mt-3">
                {{ session()->get('message') }}
            </div>
          @endif
        </div>
        <div class="form-group">
          <label for="image">Aggiungi delle immagini: (la dimensione massima per ogni immagine è di 1MB), </label>
          <label for="image">accetta formati: jpeg, png, bmp, gif, svg, or webp </label>
          <input type="file" class="form-control p-1 @error('image') is-invalid @enderror" id="image" aria-describedby="image" placeholder="Enter image url" name="image[]" multiple value="{{old('image[]')}}">
          @error('image')
              <div class="alert alert-danger">{{$message}}</div>
          @enderror
          <div class="row row-cols-5 pt-4">
            @foreach($apartment->images as $image)
              <div class="col">
                <img src="{{asset('storage/' . $image->image)}}" alt="Immagine appartamento" class="w-100">
              </div>
            @endforeach
          </div>
        </div>
        <div class="form-group">
          <h5>Servizi *</h5>
          @foreach($services as $service)
          <div class="form-check-inline">
            <div class="form-check">
              <input type="checkbox" class="form-check-input serv_check" id="{{$service->slug}}" name="services[]" value="{{$service->id}}" {{in_array($service->id,old("services",[]))}} 
              {{$apartment->services->contains($service->id) ? 'checked' : ''}}>
              <label class="form-check-label" for="{{$service->slug}}">{{$service->slug}}</label>
            </div>
          </div>
          @endforeach
        </div>
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="visible" name="visible" {{$apartment->visible ? 'checked': ''}}>
          <label class="form-check-label" for="visible">Pubblica</label>
        </div>
        <a class="btn btn-link my-2" href="{{route('admin.apartments.index')}}"><i class="fa-solid fa-rotate-left"></i> Torna agli appartamenti</a>
        <button type="submit" class="btn-success p-2 rounded">Salva</button>
      </form>
    </div>
  </div>
</div>

<script src="//js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
@endsection
@section('script')
  @include('scripts.checkbox_script')
@endsection