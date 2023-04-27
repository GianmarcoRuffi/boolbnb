@extends('layouts.admin')
@section('content')

<div id="feedback" class="container d-flex justify-content-center align-items-center">

    <h4>Pagamento avvenuto con successo! Attendi mentre vieni reindirizzato ai tuoi appartamenti...</h4>

</div>

<div class="py-12">
    @csrf
    <div id="dropin-container" style="display: flex;justify-content: center;align-items: center;"></div>
    <div style="display: flex;justify-content: center;align-items: center; color: white">
        <a id="submit-button" class="btn btn-sm btn-success">Submit payment</a>
    </div>
    <script>
        var button = document.querySelector('#submit-button');
        braintree.dropin.create({
            authorization: '{{$token}}',
            container: '#dropin-container'
        }, function (createErr, instance) {
            button.addEventListener('click', function () {
    instance.requestPaymentMethod(function (err, payload) {
        (function($) {
            $(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{route('admin.token')}}",
                    data: {nonce : payload.nonce, amount: {{$amount}}, sponsorshipId: {{$sponsorshipId}},  sponsorshipDuration: {{$duration}}, apartmentId: {{$apartmentId}}},
                    success: function (data) {
                    document.getElementById("feedback").style.visibility = 'visible';
                    setTimeout(function () {
                     let alert = document.getElementById("feedback");
                      alert.style.visibility = 'hidden';
                       window.location.replace("/admin");
                         },        3000);
                        
                        console.log('success',payload.nonce)
                    },
                    error: function (data) {
                        
                        console.log('error',payload.nonce)
                    }
                });
            });
        })(jQuery);
    });
});
        });
    </script>
</div>



@endsection