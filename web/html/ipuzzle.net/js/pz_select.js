function AddFromSelToSel(lib_plus, lib_moins) {
	var index; var item; var long;
	
	index=lib_plus.selectedIndex;
	item=lib_plus.options[index].text;
	long=lib_moins.length;
	lib_moins.options[long] = new Option(item);
	
	/*
	index=id_plus.selectedIndex;
	item=id_plus.options[index].text;
	long=id_moins.length;
	id_moins.options[long] = new Option(item);
	*/
}

function RemoveFromSel(lib_moins) {
	var index;
	
	index=lib_moins.selectedIndex;
	lib_moins.options[index] = null;
	//id_moins.options[index] = null;
}

function SelectOptions(List) {
	long=List.length;
	for(i=0; i<long; i++) {
		List.options[i].selected=true;
	}
}

function SelectAll() {
	/*
	SelectOptions(id_jrn_m);
	SelectOptions(id_org_m);
	SelectOptions(id_rub_m);
	SelectOptions(id_tpr_m);
	SelectOptions(id_gro_m);
	SelectOptions(id_jfo_m);
	SelectOptions(id_per_m);
	SelectOptions(id_tit_m);
	SelectOptions(id_pay_m);
	*/
	
	SelectOptions(lib_jrn_m);
	SelectOptions(lib_org_m);
	SelectOptions(lib_rub_m);
	SelectOptions(lib_tpr_m);
	SelectOptions(lib_gro_m);
	SelectOptions(lib_jfo_m);
	SelectOptions(lib_per_m);
	SelectOptions(lib_tit_m);
	SelectOptions(lib_pay_m);
}
