<?php   
/*
iPuzzle.WebPieces
Copyright (C) 2004 David Blanchard

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
*/

include_once('ipz_mysqlconn.php');
include_once('ipz_misc.php');
require_once('fpdf.php');

class pz_pdf extends FPDF {

	var $HEADER_LEFT_TEXT="";
	var $HEADER_CENTER_TEXT="";
	var $HEADER_RIGHT_TEXT="";
	var $HEADER_caption_NAME="Arial";
	var $HEADER_caption_SIZE="10";
	var $HEADER_caption_STYLE="";
	var $HEADER_IMAGE_PATH="";
	var $HEADER_IMAGE_POSITION="L";
	var $HEADER_IMAGE_WIDTH=32;
	var $HEADER_IMAGE_HEIGHT=32;
	
	var $FOOTER_LEFT_TEXT="";
	var $FOOTER_CENTER_TEXT="";
	var $FOOTER_RIGHT_TEXT="";
	var $FOOTER_caption_NAME="Arial";
	var $FOOTER_caption_SIZE="10";
	var $FOOTER_caption_STYLE="";

	//Tableau coloré avec données provenant d'une base
	function CreateTableFromQuery($sql, $caption_name, $caption_size, $col_widths, $colors, $cs) {
	
		$table_width=array_sum($col_widths);

		if($this->CurOrientation=="L") 
			$table_offset=$this->GetTopMargin()+round(($this->GetWorkSpaceHeight()-$table_width)/2);
		else
			$table_offset=$this->GetLeftMargin()+round(($this->GetWorkSpaceWidth()-$table_width)/2);
		//$this->SetX($table_offset);
	
		$stmt = $cs->query($sql);
		
		//Récupération des noms de champs
		$n=$result->num_fields;
		$fieldnames=array();
		for($i=0;$i<$n;$i++) $fieldnames[]=$field->name;
		
		//Données
		$fill=0;
		$begin_page=true;
		$end_page=false;
		while($rows=$stmt->fetch_array(PDO::FETCH_BOTH)) {
		
			if($begin_page) {
				//Ecriture de l'entête de tableau en début de page
				$this->SetFillColor(255,0,0);
				$this->SetTextColor(255);
				$this->SetDrawColor(128,0,0);
				$this->SetLineWidth(.3);
				$this->SetFont($caption_name,'B', $caption_size);
				$this->SetX($table_offset);
				
				for($i=0;$i<$n;$i++) $this->Cell($col_widths[$i],7,$fieldnames[$i],1,0,'C',1);
					
				$this->Ln();
				$this->SetX($table_offset);
		
				//Restauration des couleurs et de la police
				$this->SetFillColor(224,235,255);
				$this->SetTextColor(0);
				$this->SetFont('');
				$begin_page=false;
			}

			for($i=0;$i<$n;$i++) {

				$value=$rows[$i];
				if(mysqli_field_type($result, $i)=="date") $value=date_mysql_to_french($value);
				$this->Cell($col_widths[$i],6,$value,'LR',0,'L',$fill);
				
				//$this->Cell($w[1],6,$rows[1],'LR',0,'L',$fill);
				//$this->Cell($w[2],6,number_format($rows[2],0,',',' '),'LR',0,'R',$fill);
				//$this->Cell($w[3],6,number_format($row[3],0,',',' '),'LR',0,'R',$fill);
				
			}
			$this->Ln();
			$this->SetX($table_offset);
			$fill=!$fill;
			if($this->CurOrientation=="L")
				$end_page=$this->GetY()>=210-$this->rMargin-20;
			elseif($this->CurOrientation=="P")
				$end_page=$this->GetY()>=297-$this->bMargin-15;
			
			
			if($end_page) {
				$this->Cell($table_width,0,'','T');
				$this->Ln();
				$this->AddPage();
				$end_page=false;
				$begin_page=true;
			}
		}
		$this->Cell($table_width,0,'','T');
		$this->Ln();
	}

	//Entête
	function Header()
	{
		$this->SetY(0);
	        
		if($this->HEADER_IMAGE_PATH!="") {
				$this->Image($this->HEADER_IMAGE_PATH, $this->lMargin, $this->HEADER_IMAGE_HEIGHT, $this->HEADER_IMAGE_WIDTH);
		}
				
		$this->SetFont($this->HEADER_caption_NAME, $this->HEADER_caption_STYLE, $this->HEADER_caption_SIZE);
		
		if($this->HEADER_LEFT_TEXT!="")
			$this->Cell(0,10, $this->HEADER_LEFT_TEXT, 0,0,'L');

		if($this->HEADER_CENTER_TEXT!="")
			$this->Cell(0,10, $this->HEADER_CENTER_TEXT, 0,0,'C');

		if($this->HEADER_RIGHT_TEXT!="")
			$this->Cell(0,10, $this->HEADER_RIGHT_TEXT, 0,0,'R');

		//Saut de ligne
		$this->Ln(20);
	}
	
	//Pied de page
	function Footer()
	{
		$this->SetY(-10);
		
		$this->SetFont($this->FOOTER_caption_NAME, $this->FOOTER_caption_STYLE, 
		
		$this->FOOTER_caption_SIZE);
		
		$left_text=$this->FOOTER_LEFT_TEXT;
		$center_text=$this->FOOTER_CENTER_TEXT;
		$right_text=$this->FOOTER_RIGHT_TEXT;
		
		if($left_text=="#") $left_text='Page '.$this->PageNo().'/{nb}';
		if($center_text=="#") $center_text='Page '.$this->PageNo().'/{nb}';
		if($right_text=="#") $right_text='Page '.$this->PageNo().'/{nb}';
	
		if($left_text!="") 
			$this->Cell(0,10, $left_text, 0,0,'L');
		
		if($center_text!="") 
			$this->Cell(0,10, $center_text, 0,0,'C');
		
		if($right_text!="") 
			$this->Cell(0,10, $right_text, 0,0,'R');
		
	}
	
	//Entête
	function PrepareHeader($left, $center, $right, $caption_name, $caption_size, $caption_style)
	{
		$left=trim($left);
		$center=trim($center);
		$right=trim($right);
		$caption_name=trim($caption_name);
		$caption_style=trim($caption_style);
		
		$this->HEADER_LEFT_TEXT=$left;
		$this->HEADER_CENTER_TEXT=$center;
		$this->HEADER_RIGHT_TEXT=$right;
		if($caption_name!="") $this->HEADER_caption_NAME=$caption_name;
		if($caption_size>0) $this->HEADER_caption_SIZE=$caption_size;
		if($caption_style!="") $this->HEADER_caption_STYLE=$caption_style;
		
	}
	
	//Entête avec image
	function PrepareHeaderWithImage($image_path, $image_position, $image_width, $image_height, $text, $caption_name, $caption_size, $caption_style) {
		$image_path=trim($image_path);
		$image_position=trim($image_position);
		$text=trim($text);
		$caption_name=trim($caption_name);
		$caption_style=trim($caption_style);

		$this->HEADER_IMAGE_PATH=$image_path;
		$this->HEADER_IMAGE_POSITION=$image_position;
		$this->HEADER_IMAGE_WIDTH=$image_width;
		$this->HEADER_IMAGE_HEIGHT=$image_height;
		
		if($image_position=="L") {
			$this->HEADER_RIGHT_TEXT=$text;
		} else {
			$this->HEADER_LEFT_TEXT=$text;
		}
						
		if($caption_name!="") $this->HEADER_caption_NAME=$caption_name;
		if($caption_size>0) $this->HEADER_caption_SIZE=$caption_size;
		if($caption_style!="") $this->HEADER_caption_STYLE=$caption_style;
		
	}
	
	//Pied de page
	function PrepareFooter($left, $center, $right, $caption_name, $caption_size, $caption_style)
	{
		$left=trim($left);
		$center=trim($center);
		$right=trim($right);
		$caption_name=trim($caption_name);
		$caption_style=trim($caption_style);
		
		//if($left=="#") $left='Page '.$this->PageNo().'/{nb}';
		//if($center=="#") $center='Page '.$this->PageNo().'/{nb}';
		//if($right=="#") $right='Page '.$this->PageNo().'/{nb}';
	
		$this->FOOTER_LEFT_TEXT=$left;
		$this->FOOTER_CENTER_TEXT=$center;
		$this->FOOTER_RIGHT_TEXT=$right;
		if($caption_name!="") $this->FOOTER_caption_NAME=$caption_name;
		if($caption_size>0) $this->FOOTER_caption_SIZE=$caption_size;
		if($caption_style!="") $this->FOOTER_caption_STYLE=$caption_style;
		
	}

	function MoveX($x) {
		$this->SetX($this->GetX()+$x);
	} 
		
	function MoveY($y) {
		$this->SetY($this->GetY()+$y);
	} 
		
	function HtmlToRgbColor($color) {
		$a_rgb=array();
		
		if(strlen($color)<7 && $color[0]!='#') return array('r'=>0,'g'=>0,'b'=>0);
		
		$r=hexdec(substr($color, 1, 2));
		$g=hexdec(substr($color, 3, 2));
		$b=hexdec(substr($color, 5, 2));
		
		return array('r'=>$r,'g'=>$g,'b'=>$b);
	}
	
	function GetTopMargin() {
		return $this->tMargin;
	}
	
	function GetLeftMargin() {
		return $this->lMargin;
	}
	
	function GetRightMargin() {
		return $this->rMargin;
	}
	
	function GetBottomMargin() {
		return $this->bMargin;
	}
	
	function GetFontSizeMm() {
		return $this->FontSizePt/(72/25.4);
	}
	
	function GetWorkSpaceWidth() {
		return 210-$this->lMargin-$this->rMargin;
	}
	
	function GetWorkSpaceHeight() {
		return 297-$this->tMargin-$this->bMargin;
	}
	
	function DrawFrame($left, $top, $height, $width, $border, $background, $is_centered, $is_full_page) {
		if(!$is_full_page) $is_full_page=($height==0 && $width==0);
		
		if($border=="") $border='#000000';
		if($background=="") $background='#FFFFFF';
		
		$bordercolor=$this->HtmlToRgbColor($border);
		$backcolor=$this->HtmlToRgbColor($background);
		$this->SetDrawColor($bordercolor['r'], $bordercolor['g'], $bordercolor['b']);
		$this->SetFillColor($backcolor['r'], $backcolor['g'], $backcolor['b']);

		if($left=="") $left=$this->GetX();
		if($top=="") $top=$this->GetY();
			
		if($is_full_page) {
			$top=$this->tMargin;
			$left=$this->lMargin;
			$width=210-$this->lMargin-$this->rMargin;
			$height=297-$this->tMargin-$this->bMargin;
		}
			
		if($backcolor['r']+$backcolor['g']+$backcolor['b']!=0) 
			$fill='FD';
		else
			$fill='D';
			
		$this->Rect($left, $top, $width, $height, $fill);
		
	}
	
	function TextBox($text, $left, $top, $height, $width, $border, $background, $is_centered, $is_full_page) {
		
		if($border=="") $border='#000000';
		if($background=="") $background='#FFFFFF';
		
		$bordercolor=$this->HtmlToRgbColor($border);
		$backcolor=$this->HtmlToRgbColor($background);
		$this->SetDrawColor($bordercolor['r'], $bordercolor['g'], $bordercolor['b']);
		$this->SetFillColor($backcolor['r'], $backcolor['g'], $backcolor['b']);

		$real_width=$this->GetStringWidth($text);
		$ln=1;
		if($width=="") {
			$width=$real_width+3;
		} elseif($real_width>$width) {
			$lineh=$this->GetFontSizeMm();
			$linehh=$lineh/2;
			$linehe=$lineh*1.3;
			if($height!="") $ln=abs($height/$lineh);
		}
		
		if($height=="") $height=$this->GetFontSizeMm()+2;
		
		if($left=="") {
			$left_back=$this->GetX();
			$left=$this->GetX();
		}

		if($top=="") {
			$offset=($this->GetFontSizeMm()+2)/2;
			$top_back=$this->GetY();
			$top=$this->GetY()-$offset;
		}
		
		if($is_full_page) {
			$top=$this->tMargin;
			$left=$this->lMargin;
			$width=210-$this->lMargin-$this->rMargin;
			$height=297-$this->tMargin-$this->bMargin;
		}
			
		if($backcolor['r']+$backcolor['g']+$backcolor['b']!=0) 
			$fill='FD';
		else
			$fill='D';
			
		$this->Rect($left, $top, $width, $height, $fill);
		$this->SetX($left);
		
		if($ln==1) 
			$this->Cell($width, 0, $text);
		elseif($ln>1) {
			$this->MoveY(-$linehh);
			$this->SetX($left);
			$this->MultiCell($width, $linehe, $text);
		}
		
		$this->SetX($left+$width);
	}
	
}

function create_pdf_from_query($filename, $sql, $caption_name, $caption_size, $col_widths, $orientation, $header, $title, $footer, $colors, $cs) {
	$pdf=new pz_pdf();
	$pdf->Open();
	$pdf->AliasNbPages(); 
	$table_width=array_sum($col_widths);
	
	if($table_width>$pdf->GetWorkSpaceWidth()) {
		$pdf->DefOrientation="L";
	} else {
		$pdf->DefOrientation="P";
	}
		
	$pdf->PrepareHeader($header, "", $footer, $caption_name, $caption_size, "");
	$pdf->AddPage();
	$pdf->PrepareFooter("", "#", "", $caption_name, $caption_size, "");
	$pdf->SetFont($caption_name,'',$caption_size);
	
	$pdf->SetFont($caption_name,'',$caption_size+2);
	$pdf->Cell(0,10, $title, 0,0,'C');
	$pdf->Ln();
	$pdf->SetFont($caption_name,'',$caption_size);
	$pdf->CreateTableFromQuery($sql, $caption_name, $caption_size, $col_widths, $colors, $cs);
	
	if($filename!="") $pdf->Output($filename, false);
	
	return $pdf;
}

function create_pdf_from_query_with_image($filename, $image_path, $image_position, $image_heigth, $image_width, $sql, $caption_name, $caption_size, $col_widths, $orientation, $header, $title, $footer, $colors, $cs) {
	$pdf=new pz_pdf();
	$pdf->Open();
	$pdf->AliasNbPages(); 
	$table_width=array_sum($col_widths);
	
	if($table_width>$pdf->GetWorkSpaceWidth()) {
		$pdf->DefOrientation="L";
	} else {
		$pdf->DefOrientation="P";
	}
		
    $pdf->PrepareHeaderWithImage($image_path, $image_position, $image_width, $image_height, $header, $caption_name, $caption_size, "");
	$pdf->AddPage();
	$pdf->PrepareFooter($footer, "", "#", $caption_name, $caption_size, "");
	$pdf->SetFont($caption_name,'',$caption_size);
	
	$pdf->SetFont($caption_name,'',$caption_size+2);
	$pdf->Cell(0,10, $title, 0,0,'C');
	$pdf->Ln();
	$pdf->SetFont($caption_name,'',$caption_size);
	$pdf->CreateTableFromQuery($sql, $caption_name, $caption_size, $col_widths, $colors, $cs);
	
	if($filename!="") $pdf->Output($filename, false);
	
	return $pdf;
}

?> 
