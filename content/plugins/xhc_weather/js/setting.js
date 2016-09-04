$(function() {
	var defcity= $('#cityname').val();
	var defprovince =$('#provincename').val();
	creatCity('#province', '#city',defprovince,defcity);
});

function creatCity($province, $city, defprovince, defcity) {
	$province = $($province);
	$city = $($city);
	var province = null,
		provinceHtml = [];
	for (province in CITYS) {
		if (defprovince == province) provinceHtml.push('<option selected="selected">' + province + '</option>');
		else provinceHtml.push('<option>' + province + '</option>');
	}
	$province.html(provinceHtml.join('')).change(function() {
		city($(this).val());
	}).trigger('change');

	function city(province) {
		var i = 0,
			citys = CITYS[province],
			city_len = citys.length,
			cityHtml = [];
		for (; i < city_len; i++) {
			if (defcity == citys[i]) cityHtml.push('<option selected="selected">' + citys[i] + '</option>');
			else cityHtml.push('<option>' + citys[i] + '</option>');
		}
		$city.html(cityHtml.join(''));
	}
};