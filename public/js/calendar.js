function removeOptions(selectbox) {
    var i;
    for(i=selectbox.options.length-1;i>=0;i--)
    {
        selectbox.remove(i);
    }
}

function fillDays() {
	removeOptions(document.getElementById('days'));
	var month = document.forms["forms"]["months"].value;
		select = document.getElementById('days');
		min = 1;
		max = 99;
	if(month ==  "January" || month == "March" || month == "May" || month == "July" || month == "August" || month == "October" || month == "December") {
		max = 31;
	}
	else if(month == "February") {
		max = 29;
	}
	else if(month == "April" || month == "June" || month == "September" || month == "November") {
		max = 30;
	}
	for(var i = min; i <= max; i++) {
		var opt = document.createElement('option');
		opt.value = i;
		opt.innerHTML = i;
		select.appendChild(opt);
	}
}

function fillYears() {
	removeOptions(document.getElementById('years'));
	var select = document.getElementById('years');
	for(var i = 1916; i <= 2116; i++) {
		var opt = document.createElement("option");
		if(i == 2016) {
			opt.setAttribute('selected', 'selected');
		}
		opt.value = i;
		opt.innerHTML = i;
		select.appendChild(opt);
	}
}