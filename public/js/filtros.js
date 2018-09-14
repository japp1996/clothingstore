Vue.filter('number',value => {
	if (value == '')
		return '';
	return formatMoney(parseFloat(value));
});

Vue.filter('VES',value => {
	if (value == '')
		return '';
	return formatMoney(parseFloat(value)) + ' Bs. S';
});

Vue.filter('USD',value => {
	if (value == '')
		return '';
	return formatMoney(parseFloat(value)) + ' USD';
});

Vue.filter('date',value => {
	if (value == '')
		return '';
	return moment(value).format('DD/MM/YYYY');
});

Vue.filter('metodo',value => {
	if (value == '')
		return '';
	let respuesta = "";
	value = parseInt(value);
	switch (value) {
		case 1:
			respuesta = "MercadoPago";
			break;

		case 2:
			respuesta = "PayPal";
			break;

		case 3:
			respuesta = _transfer;
			break;
	}
	return respuesta;
});

function formatMoney(n, c, d, t) {
  var c = isNaN(c = Math.abs(c)) ? 2 : c,
    d = d == undefined ? "." : d,
    t = t == undefined ? "," : t,
    s = n < 0 ? "-" : "",
    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
    j = (j = i.length) > 3 ? j % 3 : 0;

  return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};