@push('styles')
<style type="text/css">

</style>
@endpush
<small class="form-text text-muted" id="cardErrors" role="alert"></small>
<p>Detalles de la cuenta bancaria</p>
<dl class="param">
  <dt>BANCO: </dt>
  <dd>PICHINCHA</dd>
</dl>
<dl class="param">
  <dt>NÚMERO DE CUENTA: </dt>
  <dd>123456789</dd>
</dl>
<dl class="param">
  <dt>NOMBRE: </dt>
  <dd> FISHYGO</dd>
</dl>
<dl class="param">
  <dt>CEDULA: </dt>
  <dd> 123456789</dd>
</dl>
<p><strong>Note:</strong> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labore et dolore magna aliqua. </p>

@push('scriptsss')
<script>
  const paymentForm = document.getElementById('paymentForm');
  const payBtn = document.getElementById('payButton');

  payBtn.addEventListener('click', async(e) => {
    if (paymentForm.elements.payment_platform.value === "{{ $paymentPlatform->id }}") {
      e.preventDefault();
      console.log({{ $paymentPlatform->id }});
      var data = new FormData(document.getElementById("paymentForm"));
      paymentForm.action="{{ route('payTransfer') }}";
      paymentForm.submit();
    }
  });
</script>
@endpush
