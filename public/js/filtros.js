Vue.filter('number',value => {
	if (value == '')
		return '';
	return parseFloat(value).toFixed(2);
});

Vue.filter('VES',value => {
	if (value == '')
		return '';
	return parseFloat(value).toFixed(2) + ' Bs. S';
});

Vue.filter('USD',value => {
	if (value == '')
		return '';
	return parseFloat(value).toFixed(2) + ' USD';
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
			respuesta = "PayPal";
			break;

		case 2:
			respuesta = "MercadoPago";
			break;
	}
	return respuesta;
});