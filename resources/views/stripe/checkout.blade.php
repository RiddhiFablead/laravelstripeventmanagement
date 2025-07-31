@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm p-4">
        <h3 class="mb-4">Complete Your Payment</h3>
        <p><strong>Name:</strong> {{ $name }}</p>
        <p><strong>Email:</strong> {{ $email }}</p>
        <p><strong>Amount:</strong> ₹{{ $amount }}</p>

        <form id="payment-form" method="POST">
            @csrf
            <div class="mb-3">
                <label for="card-element">Card Details</label>
                <div id="card-element" class="form-control" style="padding: 10px;"></div>
                <div id="card-errors" class="text-danger mt-2"></div>
            </div>
            <button  type="button" id="submit" class="btn btn-success mt-3">Pay ₹{{ $amount }}</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    
document.addEventListener('DOMContentLoaded', function () {
 
  const stripe=Stripe("{{env('STRIPE_KEY')}}");
    const elements = stripe.elements();
    const card = elements.create('card', { style: { base: { fontSize: '16px' } } });
    card.mount('#card-element');

    card.on('change', function (event) {
        document.getElementById('card-errors').textContent = event.error ? event.error.message : '';
    });

    const form = document.getElementById('submit');
    form.addEventListener('click', function (e) {
        // e.preventDefault();
        alert('STRIPE_KEY');

        stripe.confirmCardPayment("{{ $clientSecret }}", {
            payment_method: {
                card: card,
                billing_details: {
                    name: "{{ $name }}",
                    email: "{{ $email }}"
                }
            }
        }).then(function (result) {
            if (result.error) {
                document.getElementById('card-errors').textContent = result.error.message;
            } else if (result.paymentIntent && result.paymentIntent.status === 'succeeded') {
                window.location.href = "{{ route('stripe.success') }}";
            }
        });
    });
});
</script>
@endpush
