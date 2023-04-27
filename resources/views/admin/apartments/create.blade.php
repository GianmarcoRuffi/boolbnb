@extends('layouts.admin')

@section('content')
<div class="container">
  <div class="row">
    <div class="col">
      <form action="{{route('admin.apartments.store')}}" method="POST" enctype="multipart/form-data" autocomplete="off" id="create_form">
        @csrf
        <div class="form-group">
          <label for="Title">Titolo *</label>
          <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" aria-describedby="title" placeholder="Inserisci titolo" name="title" value="{{old('title')}}" required minlength="5">
          @error('title')
              <div class="alert alert-danger">{{$message}}</div>
          @enderror
        </div>
        <div class="form-group">
          <label for="description">Descrizione</label>
          <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" cols="30" rows="15">{{old('description')}}</textarea>
          @error('description')
              <div class="alert alert-danger">{{$message}}</div>
          @enderror
        </div>
        <div class="form-group">
          <label for="rooms">Numero di stanze *</label>
          <input type="number" class="form-control @error('rooms') is-invalid @enderror" id="rooms" aria-describedby="rooms" placeholder="Numero di Stanze" name="rooms" value="{{old('rooms')}}" min=1 max=50 required>
          @error('rooms')
              <div class="alert alert-danger">{{$message}}</div>
          @enderror
        </div>
        <div class="form-group">
          <label for="beds">Posti letto *</label>
          <input type="number" class="form-control @error('beds') is-invalid @enderror" id="beds" aria-describedby="beds" placeholder="Posti letto" name="beds" value="{{old('beds')}}" min=1 max=50 required>
          @error('beds')
              <div class="alert alert-danger">{{$message}}</div>
          @enderror
        </div>
        <div class="form-group">
          <label for="bathrooms">Bagni in casa *</label>
          <input type="number" class="form-control @error('bathrooms') is-invalid @enderror" id="bathrooms" aria-describedby="bathrooms" placeholder="Bagni" name="bathrooms" value="{{old('bathrooms')}}" min=1 max=50 required>
          @error('bathrooms')
              <div class="alert alert-danger">{{$message}}</div>
          @enderror
        </div>
        <div class="form-group">
          <label for="square_meters">Metri quadrati</label>
          <input type="number" class="form-control @error('square_meters') is-invalid @enderror" id="square_meters" aria-describedby="square_meters" placeholder="Metri quadrati" name="square_meters" value="{{old('square_meters')}}" min="0">
          @error('square_meters')
              <div class="alert alert-danger">{{$message}}</div>
          @enderror
        </div>
        <div class="form-group">
          <label for="price">Prezzo per notte *</label>
          <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" aria-describedby="price" placeholder="Prezzo per notte" step=".01" name="price" value="{{old('price')}}" required min="1">
          @error('price')
              <div class="alert alert-danger">{{$message}}</div>
          @enderror
        </div>

        {{-- select --}}

        <div class="form-group">
          <label for="nation" class="form-label">Nazione *</label>
          <select name="nation" id="nation" class="form-control @error('nation') is-invalid @enderror" required>
            <option value="">Seleziona la nazione</option>
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
          <input type="address" class="form-control @error('address') is-invalid @enderror" id="address" aria-describedby="address" placeholder="Inserisci indirizzo, municipio" name="address" value="{{old('address')}}" required>
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
          <label for="image">Seleziona le immagini(la dimensione massima per ogni immagine è di 1MB), </label>
          <label for="image">accetta formati: jpeg, png, bmp, gif, svg, or webp </label>
          <input type="file" class="form-control p-1 @error('image') is-invalid @enderror" id="image" aria-describedby="image" placeholder="Enter image url" name="image[]" multiple value="{{old('image[]')}}">
          @error('image')
              <div class="alert alert-danger">{{$message}}</div>
          @enderror
        </div>
        <div class="form-group">
        <h5>Servizi *(min un servizio)</h5>
        @foreach($services as $service)
          <div class="form-check-inline">
              <div class="form-check">
                  <input type="checkbox" class="form-check-input serv_check" id="{{$service->slug}}" name="services[]" value="{{$service->id}}" {{in_array($service->id,old("services",[]))}} >
                  <label class="form-check-label" for="{{$service->slug}}">{{$service->name}}</label>
              </div>
          </div>
        @endforeach
        </div>
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="visible" name="visible" {{old('visible') ? 'checked': ''}}>
          <label class="form-check-label" for="visible">Pubblica</label>
        </div>
        <a class="btn btn-link my-2" href="{{route('admin.home')}}"><i class="fa-solid fa-rotate-left"></i> Torna alla Home</a>
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



