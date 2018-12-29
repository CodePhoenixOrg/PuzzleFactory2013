var PZ_CUR_ROW_COLOR="lightgrey";
var PZ_CUR_TEXT_COLOR="black";
var PZ_DEF_HL_BACK_COLOR="grey";
var PZ_DEF_HL_TEXT_COLOR="white";

function pz_shadow(thisName) {

	table=eval(document.getElementById(thisName));
	shadow=eval(document.getElementById(thisName+"_shadow"));
	shadow_width=eval(document.getElementById(thisName+"_sw"));
	shadow_height=eval(document.getElementById(thisName+"_sh"));

	shadow.style.width=table.offsetWidth+11+"px";
	shadow_width.style.width=table.offsetWidth-8+"px";
	shadow_height.style.height=table.offsetHeight-8+"px";

}

function setRowColor(thisRow, hlBackColor, hlTextColor) {
	var id=thisRow.id;
	if(hlBackColor=="") hlBackColor=PZ_DEF_HL_BACK_COLOR;
	if(hlTextColor=="") hlTextColor=PZ_DEF_HL_TEXT_COLOR;
	PZ_CUR_ROW_COLOR=thisRow.cells[0].style.backgroundColor;
	// var font=document.getElementById("caption_"+id+"0");
	var font=document.querySelector("span[id='caption_"+id+"0']");

	if(font !== null) PZ_CUR_TEXT_COLOR=font.style.color;
	CellCount=thisRow.cells.length;
	for(i=0; i<CellCount; i++) {
		thisRow.cells[i].style.backgroundColor=hlBackColor;
		// thisRow.cells[i].style.color=hlTextColor;
		var font=document.querySelector("span[id='caption_"+id+i+"']");
		if(font !== null) font.style.color=hlTextColor;
	}
}

function setBackRowColor(thisRow) {
	var id=thisRow.id;
	CellCount=thisRow.cells.length;
	for(i=0; i<CellCount; i++) {
		thisRow.cells[i].style.backgroundColor=PZ_CUR_ROW_COLOR;
		//thisRow.cells[i].style.fontColor=PZ_CUR_TEXT_COLOR;
		var font=document.querySelector("span[id='caption_"+id+i+"']");
		if(font !== null) font.style.color=PZ_CUR_TEXT_COLOR;
	}
}
