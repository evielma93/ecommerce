/**/
// Closure
(function() {
  /**
   * Ajuste decimal de un número.
   *
   * @param {String}  type  El tipo de ajuste.
   * @param {Number}  value El número.
   * @param {Integer} exp   El exponente (El logaritmo de ajuste en base 10).
   * @returns {Number} El valor ajustado.
   */
   function decimalAdjust(type, value, exp) {
    // Si exp es undefined o cero...
    if (typeof exp === 'undefined' || +exp === 0) {
    	return Math[type](value);
    }
    value = +value;
    exp = +exp;
    // Si el valor no es un número o exp no es un entero...
    if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0)) {
    	return NaN;
    }
    // Shift
    value = value.toString().split('e');
    value = Math[type](+(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp)));
    // Shift back
    value = value.toString().split('e');
    return +(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp));
}

  // Decimal round
  if (!Math.round10) {
  	Math.round10 = function(value, exp) {
  		return decimalAdjust('round', value, exp);
  	};
  }
  // Decimal floor
  if (!Math.floor10) {
  	Math.floor10 = function(value, exp) {
  		return decimalAdjust('floor', value, exp);
  	};
  }
  // Decimal ceil
  if (!Math.ceil10) {
  	Math.ceil10 = function(value, exp) {
  		return decimalAdjust('ceil', value, exp);
  	};
  }
})();

$(document).ready(function() {
	var cont = 0;
	$('input[name="product_id[]"]').each(function(){
		cont++;
	});
	for (var i = 0; i<=cont; i++) {
		var vunit    = parseFloat($('#vunit'+i).val());
		var cant     = parseFloat($('#cant'+i).val());
		var vtotal   = parseFloat(cant)*parseFloat(vunit);
		vtotal       = Math.round10(vtotal,-3);
		$('#vtotal'+i).html(vtotal);
		$('#vtotal2'+i).val(vtotal);
		resumen();
	}
});

function calcular(obj,cont)
{
	var cantidad = parseFloat(obj);
	var vunit 	 = parseFloat($('#vunit'+cont).val());
	var vtotal   = parseFloat(cantidad)*parseFloat(vunit);
	vtotal = Math.round10(vtotal,-3);
	$('#vtotal'+cont).html(vtotal);
	$('#vtotal2'+cont).val(vtotal);
	resumen();
}

function resumen()
{
	var subtotal = 0;
	var subiva 	 = 0;
	var iva      = 0.12;
	var total    = 0;
	$('.vtotal').each(function(){
		if (isNaN($(this).val())){
			subtotal += parseFloat(0);
		}else{
			subtotal += parseFloat($(this).text()) || 0;
		}
	});

	var envio = document.getElementById("detalleEnvio").value || 0;
	total  = parseFloat(subtotal)+parseFloat(envio);
	subtotal = Math.round10(subtotal,-2);
	total = Math.round10(total,-2);
	$('#subto').html('$'+subtotal);
	$('#total').html('$'+total);
	$('#valueTot').val(total);
}

$(document).on('click','.eliminar',function(e){
	var id = $(this).val();
	var objinput = $(this);
	console.log(id);
	console.log(objinput);
	e.stopImmediatePropagation();
	let url = 'product/delete/'+id;
	$.ajax({
		url: url,
		type: 'get',
		success: function(resp){
			alert(resp.message);
			location.reload();
		}
	});
});

