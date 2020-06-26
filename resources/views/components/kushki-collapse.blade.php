@push('styles')
@endpush

<div class="row">
  <aside class="col-sm-6">
    <article class="card">
      <div class="card-body p-5">
        <p>
          <i class="fab fa-cc-discover fa-2x"></i>
          <i class="fab fa-cc-visa"></i>
          <i class="fab fa-cc-mastercard"></i>
        </p>
        <p class="alert alert-success">Algún texto de éxito o error</p>

        <form role="form">
          <div class="form-group">
            <label for="username">Nombre completo (en la tarjeta)</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-user"></i></span>
              </div>
              <input type="text" class="form-control" name="username" placeholder="" >
            </div> <!-- input-group.// -->
          </div> <!-- form-group.// -->

          <div class="form-group">
            <label for="cardNumber">Número de tarjeta</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-credit-card"></i></span>
              </div>
              <input type="text" class="form-control" name="cardNumber" placeholder="">
            </div> <!-- input-group.// -->
          </div> <!-- form-group.// -->

          <div class="row">
            <div class="col-sm-8">
              <div class="form-group">
                <label><span class="hidden-xs">Vencimiento</span> </label>
                <div class="form-inline">
                  <select class="form-control" style="width:45%">
                    <option>MM</option>
                    <option>01 - Janiary</option>
                    <option>02 - February</option>
                    <option>03 - February</option>
                  </select>
                  <span style="width:10%; text-align: center"> / </span>
                  <select class="form-control" style="width:45%">
                    <option>YY</option>
                    <option>2018</option>
                    <option>2019</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label data-toggle="tooltip" title="" data-original-title="Código de 3 dígitos en el reverso de la tarjeta">CVV <i class="fa fa-question-circle"></i></label>
                <input class="form-control"  type="text">
              </div> <!-- form-group.// -->
            </div>
          </div> <!-- row.// -->
          <button class="subscribe btn btn-primary btn-block" type="button"> Confirmar  </button>
        </form>
      </div> <!-- card-body.// -->
    </article> <!-- card.// -->
  </aside>
</div>


@push('scriptsss')

@endpush
