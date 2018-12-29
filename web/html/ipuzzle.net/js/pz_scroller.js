	var t_out;
	var f_step=10;
	var f_coef=0.5;
	var PZ_OBJECT;
	
	function pz_object(thisObject, f_top, f_left, f_height, f_width, f_thickness) {
		this.path=pz_getPath(thisObject);
		this.object=eval(this.path);
		this.name=thisObject;
		this.top=f_top;
		this.left=f_left;
		this.height=f_height;
		this.width=f_width;
		this.thickness=f_thickness;
		this.isMoving=true;
		this.table=null;
		this.scrollerX=null;
		this.acceleratorX=null;
		this.cursorX=null;
		this.cursorXPos=0;
		this.scrollerY=null;
		this.acceleratorY=null;
		this.cursorY=null;
		this.cursorYPos=0;
		
		if(this.object) {
			this.style=this.object.style;
		} else {
			alert("L'objet "+this.name+" n'existe pas!");
			this.style=false;
		}
	}

	function pz_init() {
		this.step=f_step;
		this.isMoving=false;
		this.direction=1;
		this.offsetleft=this.left;
		this.offsettop=this.top;
		this.clipwidth=this.width;
		this.clipheight=this.height;
		this.cliptop=0;
		this.clipleft=0;
		this.timeout=30;

		this.scrollerX.style.left=this.left;
		this.scrollerX.style.top=this.top+this.height;
		//this.scrollerX.style.height=this.thickness;
		this.acceleratorX.style.width=this.width-26;
		//this.acceleratorX.style.height=this.thickness;
		this.scrollerY.style.left=this.left+this.width;
		this.scrollerY.style.top=this.top;
		//this.scrollerY.style.width=this.thickness;
		this.acceleratorY.style.height=this.height-26;
		//this.acceleratorY.style.width=this.thickness;

		this.style.left=this.offsetleft;
		this.style.width=this.clipwidth;
		this.style.top=this.offsettop;
		this.style.height=this.clipheight;
		this.style.clip="rect("+this.cliptop+","+this.clipwidth+","+this.clipheight+","+this.clipleft+")";
	}

	function pz_debug() {
		var dbg=document.debug;
		dbg.step.value=this.step;
		dbg.direction.value=this.direction;
		dbg.top.value=this.top;
		dbg.left.value=this.left;
		dbg.height.value=this.height;
		dbg.width.value=this.width;
		dbg.offsetleft.value=this.offsetleft;
		dbg.offsettop.value=this.offsettop;
		dbg.clipwidth.value=this.clipwidth;
		dbg.clipheight.value=this.clipheight;
		dbg.cliptop.value=this.cliptop;
		dbg.clipleft.value=this.clipleft;
		dbg.tablewidth.value=this.table.offsetWidth;
		dbg.tableheight.value=this.table.offsetHeight;
		dbg.cursorxpos.value=this.cursorXPos;
		dbg.cursorypos.value=this.cursorYPos;
		dbg.cursorleft.value=PZ_CURSOR.style.pixelLeft;
		dbg.cursortop.value=PZ_CURSOR.style.pixelTop;
	}

	function pz_show(){
		this.style.visibility="visible";
		this.style.clip="rect("+this.cliptop+","+this.clipwidth+","+this.clipheight+","+this.clipleft+")";
	}

	function pz_scrollX() {
		
		this.clipwidth=this.clipwidth+this.direction*-this.step;
		if(this.clipwidth<this.width) {
			this.clipleft=0;
			this.offsetleft=this.left;
			this.clipwidth=this.width;
		} else if(this.clipwidth>this.table.offsetWidth) {
			this.clipwidth=this.table.offsetWidth;
			this.clipleft=this.clipwidth-this.width;
			this.offsetleft=(this.clipleft-this.left)*PZ_OBJECT.direction;
		} else {
			this.clipleft=this.clipleft+this.direction*-this.step;
			this.offsetleft=this.offsetleft+this.direction*this.step;
		}

		PZ_OBJECT.cursorXPos=PZ_OBJECT.clipleft/(PZ_OBJECT.table.offsetWidth-PZ_OBJECT.width);
		PZ_CURSOR.moveByPercent();
	}

	function pz_scrollXByPercent() {
		this.clipleft=(this.table.offsetWidth-this.width)*PZ_OBJECT.cursorXPos;
		this.offsetleft=this.left-this.clipleft;
		this.clipwidth=this.width+this.clipleft;

		PZ_OBJECT.style.left=PZ_OBJECT.offsetleft;
		PZ_OBJECT.style.width=PZ_OBJECT.clipwidth;
		PZ_OBJECT.style.clip="rect("+PZ_OBJECT.cliptop+","+PZ_OBJECT.clipwidth+","+PZ_OBJECT.clipheight+","+PZ_OBJECT.clipleft+")";
		//PZ_OBJECT.debug();
	}

	function pz_scrollY() {
		this.clipheight=this.clipheight+this.direction*-this.step;
		if(this.clipheight<this.height) {
			this.cliptop=0;
			this.offsettop=this.top;
			this.clipheight=this.height;
		} else if(this.clipheight>this.table.offsetHeight) {
			this.clipheight=this.table.offsetHeight;
			this.cliptop=this.clipheight-this.height;
			this.offsettop=(this.cliptop-this.top)*PZ_OBJECT.direction;
		} else {
			this.cliptop=this.cliptop+this.direction*-this.step;
			this.offsettop=this.offsettop+this.direction*this.step;
		}

		PZ_OBJECT.cursorYPos=PZ_OBJECT.cliptop/(PZ_OBJECT.table.offsetHeight-PZ_OBJECT.height);
		PZ_CURSOR.moveByPercent();
	}
	
	function pz_scrollYByPercent(){
		this.cliptop=(this.table.offsetHeight-this.height)*PZ_OBJECT.cursorYPos;
		this.offsettop=this.top-this.cliptop;
		this.clipheight=this.height+this.cliptop;

		PZ_OBJECT.style.top=PZ_OBJECT.offsettop;
		PZ_OBJECT.style.height=PZ_OBJECT.clipheight;
		PZ_OBJECT.style.clip="rect("+PZ_OBJECT.cliptop+","+PZ_OBJECT.clipwidth+","+PZ_OBJECT.clipheight+","+PZ_OBJECT.clipleft+")";
		//PZ_OBJECT.debug();
	}
	
	function pz_scrollRight() {
		if(!PZ_OBJECT.isMoving) return;
		PZ_OBJECT.direction=-1;
		PZ_OBJECT.scrollX();
		t_out=setTimeout("pz_scrollRight()", 30);
	}
	
	function pz_scrollLeft() {
		if(!PZ_OBJECT.isMoving) return;
		PZ_OBJECT.direction=1;
		PZ_OBJECT.scrollX();
		t_out=setTimeout("pz_scrollLeft()", 30);
	}

	function pz_scrollBottom() {
		if(!PZ_OBJECT.isMoving) return;
		PZ_OBJECT.direction=-1;
		PZ_OBJECT.scrollY();
		t_out=setTimeout("pz_scrollBottom()", 30);
	}
	
	function pz_scrollTop() {
		if(!PZ_OBJECT.isMoving) return;
		PZ_OBJECT.direction=1;
		PZ_OBJECT.scrollY();
		t_out=setTimeout("pz_scrollTop()", 30);
	}

	function pz_stop() {
		this.isMoving=false;
		clearTimeout(t_out);
	}
	
	function pz_goRight() {
		this.isMoving=true;
		this.step=f_step;
		this.scrollRight();
	}

	function pz_goLeft() {
		this.isMoving=true;
		this.step=f_step;
		this.scrollLeft();
	}
	
	function pz_goUp() {
		this.isMoving=true;
		this.step=f_step;
		this.scrollTop();
	}

	function pz_goDown() {
		this.isMoving=true;
		this.step=f_step;
		this.scrollBottom();
	}
	
	function pz_goFastRight() {
		this.isMoving=true;
		this.step=this.width*f_coef;
		this.scrollRight();
	}
	
	function pz_goFastLeft() {
		this.isMoving=true;
		this.step=this.width*f_coef;
		if(window.event.clientX<PZ_CURSOR.style.pixelLeft)
			this.scrollLeft();
		else if(window.event.clientX>PZ_CURSOR.style.pixelLeft) 
			this.scrollRight();
	}
	
	function pz_goFastUp() {
		this.isMoving=true;
		this.step=this.height*f_coef;
		if(window.event.clientY<PZ_CURSOR.style.pixelTop)
			this.scrollTop();
		else if(window.event.clientY>PZ_CURSOR.style.pixelTop) 
			this.scrollBottom();
	}

	function pz_goFastDown() {
		this.isMoving=true;
		this.step=this.height*f_coef;
		this.scrollBottom();
	}
	
	function pz_goRightLimit() {
		this.isMoving=true;
		this.step=this.table.offsetWidth;
		this.scrollRight();
	}

	function pz_goLeftLimit() {
		this.isMoving=true;
		this.step=this.table.offsetWidth;
		this.scrollLeft();
	}
	
	function pz_goUpLimit() {
		this.isMoving=true;
		this.step=this.table.offsetHeight;
		this.scrollTop();
	}

	function pz_goDownLimit() {
		this.isMoving=true;
		this.step=this.table.offsetHeight;
		this.scrollBottom();
	}
	
	pz_object.prototype.init=pz_init;
	pz_object.prototype.show=pz_show;
	pz_object.prototype.debug=pz_debug;
	pz_object.prototype.scrollX=pz_scrollX;
	pz_object.prototype.scrollXByPercent=pz_scrollXByPercent;
	pz_object.prototype.scrollY=pz_scrollY;
	pz_object.prototype.scrollYByPercent=pz_scrollYByPercent;
	pz_object.prototype.scrollRight=pz_scrollRight;
	pz_object.prototype.scrollLeft=pz_scrollLeft;
	pz_object.prototype.scrollBottom=pz_scrollBottom;
	pz_object.prototype.scrollTop=pz_scrollTop;
	pz_object.prototype.stop=pz_stop;
	pz_object.prototype.goLeft=pz_goLeft;
	pz_object.prototype.goRight=pz_goRight;
	pz_object.prototype.goUp=pz_goUp;
	pz_object.prototype.goDown=pz_goDown;
	pz_object.prototype.goFastLeft=pz_goFastLeft;
	pz_object.prototype.goFastRight=pz_goFastRight;
	pz_object.prototype.goFastUp=pz_goFastUp;
	pz_object.prototype.goFastDown=pz_goFastDown;
	pz_object.prototype.goLeftLimit=pz_goLeftLimit;
	pz_object.prototype.goRightLimit=pz_goRightLimit;
	pz_object.prototype.goUpLimit=pz_goUpLimit;
	pz_object.prototype.goDownLimit=pz_goDownLimit;
