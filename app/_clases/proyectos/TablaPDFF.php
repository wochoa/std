<?php

namespace App\_clases\proyectos;

use App\_clases\utilitarios\Money;
use Codedge\Fpdf\Fpdf\Fpdf;
use Carbon\Carbon;


class TablaPDFF extends Fpdf{

	var $wLine; // Maximum width of the line
	var $hLine; // Height of the line
	var $Text; // Text to display
	var $border;
	var $align; // Justification of the text
	var $fill;
	var $Padding;
	var $lPadding;
	var $tPadding;
	var $bPadding;
	var $rPadding;
	var $TagStyle; // Style for each tag
	var $Indent;
	var $Space; // Minimum space between words
	var $PileStyle; 
	var $Line2Print; // Line to display
	var $NextLineBegin; // Buffer between lines 
	var $TagName;
	var $Delta; // Maximum width minus width
	var $StringLength; 
	var $LineLength;
	var $wTextLine; // Width minus paddings
	var $nbSpace; // Number of spaces in the line
	var $Xini; // Initial position
	var $href; // Current URL
	var $TagHref; // URL for a cell
	var $Pspace; //space bettwen paragraph


    var $angle=0;//rotation


	public $cm = 9.05; // A4
	private $himg = '';
    private $proy= null;
    private $version= null;
    private $resp= null;
    private $fuente=null;
	private $fimg= '';
	private $ftxt= '';
	private $wini;
	private $type='LT';

	var $widths;
	var $aligns;


	function Header(){
		if ($this->proy != null) {
		    switch ($this->type){
                case 'LT':{$this->HeaderLT();}break;
                case 'MD':{$this->HeaderMD();}break;
            }

		}
	}
	function HeaderLT(){
        $this->SetY(5);
        $this->SetFont('Arial','',10);
        $this->SetFontSize(13);
        $mid_x=$this->GetPageWidth()/2;
        $midle = $this->GetPageWidth()-($this->lMargin+$this->rMargin);

        $txt = 'GERENCIA REGIONAL DE INFRAESTRUCTURA';
        $this->MultiCell(379, 3, $txt, 0, 'C');
        $this->Ln();
        $txt = 'Linea de tiempo de proyecto ('.(($this->fuente!=null)?$this->fuente:'a toda fuente de financiamiento').')';
        $this->MultiCell(379, 3, $txt, 0, 'C');
        $this->Ln();
        $this->SetFontSize(9);
        $this->Cell(30,6,'Proyecto',0,0,'L');
        $this->Cell(5,6,':',0,0,'L');
        $txt = utf8_decode('"'.$this->proy->proy_cod_siaf.' - '.$this->proy->proy_nombre.'"');
        $this->MultiCell(344, 4, $txt, 0, 'L');
        $this->Ln();
        $this->Cell(30,6,'Elaborado por',0,0,'L');
        $this->Cell(5,6,':',0,0,'L');
        $this->Cell(154,6,utf8_decode($this->resp),0,0,'L');
        $this->Cell(30,6,'FECHA',0,0,'L');
        $this->Cell(5,6,':',0,0,'L');
        $this->Cell(59,6,$this->version->vers_fecha,0,0,'L');
        $this->Cell(30,6,'VERSION',0,0,'L');
        $this->Cell(5,6,':',0,0,'L');
        $this->Cell(59,6,($this->version->id>1)?$this->version->vers_anio.'.'.$this->version->vers_version:'',0,0,'L');
        $this->Ln();
        $this->Ln();

        //Put the watermark
        $this->SetFont('Arial','B',50);
        $this->SetTextColor(255,192,203);
        if ($this->version->id==1) {
            $wathermark='B O R R A D O R';
            $this->RotatedText(35, 120, $wathermark, 45);
            $this->RotatedText(250, 120, $wathermark, 45);
            $this->RotatedText(35, 270, $wathermark, 45);
            $this->RotatedText(250, 270, $wathermark, 45);
        }
    }

	function HeaderMD(){
        $this->SetY(5);
        $this->SetFont('Arial','',10);
        $this->SetFontSize(13);
        $mid_x=$this->GetPageWidth()/2;
        $midle = $this->GetPageWidth()-($this->lMargin+$this->rMargin);

        $txt = 'GERENCIA REGIONAL DE INFRAESTRUCTURA';
        $this->MultiCell(379, 3, $txt, 0, 'C');
        $this->Ln();
        $txt = 'PROPUESTA DE MODIFICATORIA';
        $this->MultiCell(379, 3, $txt, 0, 'C');
        $this->Ln();
        $this->SetFontSize(9);
        $this->Cell(30,6,'Proyecto',0,0,'L');
        $this->Cell(5,6,':',0,0,'L');
        $txt = utf8_decode('"'.$this->proy->proy_cod_siaf.' - '.$this->proy->proy_nombre.'"');
        $this->MultiCell(344, 4, $txt, 0, 'L');
        $this->Ln();
        $this->Cell(30,6,'Elaborado por',0,0,'L');
        $this->Cell(5,6,':',0,0,'L');
        $this->Cell(154,6,utf8_decode($this->resp),0,0,'L');
        $this->Cell(30,6,'FECHA',0,0,'L');
        $this->Cell(5,6,':',0,0,'L');
        $this->Cell(59,6,$this->version->vers_fecha,0,0,'L');
        $this->Cell(30,6,'VERSION',0,0,'L');
        $this->Cell(5,6,':',0,0,'L');
        $this->Cell(59,6,($this->version->id>1)?$this->version->vers_anio.'.'.$this->version->vers_version:'',0,0,'L');
        $this->Ln();
        $this->Ln();

        //Put the watermark
        $this->SetFont('Arial','B',50);
        $this->SetTextColor(255,192,203);
        if ($this->version->id==1) {
            $wathermark='B O R R A D O R';
            $this->RotatedText(35, 120, $wathermark, 45);
            $this->RotatedText(250, 120, $wathermark, 45);
            $this->RotatedText(35, 270, $wathermark, 45);
            $this->RotatedText(250, 270, $wathermark, 45);
        }
    }

    function Rotate($angle,$x=-1,$y=-1)
    {
        if($x==-1)
            $x=$this->x;
        if($y==-1)
            $y=$this->y;
        if($this->angle!=0)
            $this->_out('Q');
        $this->angle=$angle;
        if($angle!=0)
        {
            $angle*=M_PI/180;
            $c=cos($angle);
            $s=sin($angle);
            $cx=$x*$this->k;
            $cy=($this->h-$y)*$this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
        }
    }

    function _endpage()
    {
        if($this->angle!=0)
        {
            $this->angle=0;
            $this->_out('Q');
        }
        parent::_endpage();
    }
    function RotatedText($x, $y, $txt, $angle)
    {
        //Text rotated around its origin
        $this->Rotate($angle,$x,$y);
        $this->Text($x,$y,$txt);
        $this->Rotate(0);
    }
	function SetHeader($proy=null, $v, $r, $f, $t='LT'){
		$this->proy = $proy;
		$this->version = $v;
		$this->resp = ($r!=null)?$r->adm_name.' '.$r->adm_lastname:'';
		$this->fuente = $f;
		$this->type=$t;
	}

	function Footer(){
		$this->SetY(-22,625);
        $this->Line($this->GetX(), $this->GetY() , $this->GetX()+60, $this->GetY());
        $this->Cell(60,4, $this->resp,0,1,'C');
        $this->Cell(60,4, $this->version->vers_cargo,0,1,'C');
	}
	function SetFooter($fimg='', $ftxt=''){
		$this->fimg = $fimg;
		$this->ftxt = $ftxt;
	}

	function Writeh($h, $txt, $alling)
	{
		// Output text in flowing mode
		if(!isset($this->CurrentFont))
			$this->Error('No font has been set');
		$cw = &$this->CurrentFont['cw'];
		$w = $this->w-$this->rMargin-$this->x;
		$wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
		$s = str_replace("\r",'',$txt);
		$nb = strlen($s);
		$sep = -1;
		$i = 0;
		$j = 0;
		$l = 0;
		$nl = 1;
		while($i<$nb)
		{
			// Get next character
			$c = $s[$i];
			if($c=="\n")
			{
				// Explicit line break
				$this->Cell($w,$h,substr($s,$j,$i-$j),0,2,$alling,false,$link);
				$i++;
				$sep = -1;
				$j = $i;
				$l = 0;
				if($nl==1)
				{
					$this->x = $this->lMargin;
					$w = $this->w-$this->rMargin-$this->x;
					$wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
				}
				$nl++;
				continue;
			}
			if($c==' ')
				$sep = $i;
			$l += $cw[$c];
			if($l>$wmax)
			{
				// Automatic line break
				if($sep==-1)
				{
					if($this->x>$this->lMargin)
					{
						// Move to next line
						$this->x = $this->lMargin;
						$this->y += $h;
						$w = $this->w-$this->rMargin-$this->x;
						$wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
						$i++;
						$nl++;
						continue;
					}
					if($i==$j)
						$i++;
					$this->Cell($w,$h,substr($s,$j,$i-$j),0,2,$alling,false,$link);
				}
				else
				{
					$this->Cell($w,$h,substr($s,$j,$sep-$j),0,2,$alling,false,$link);
					$i = $sep+1;
				}
				$sep = -1;
				$j = $i;
				$l = 0;
				if($nl==1)
				{
					$this->x = $this->lMargin;
					$w = $this->w-$this->rMargin-$this->x;
					$wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
				}
				$nl++;
			}
			else
				$i++;
		}
		// Last chunk
		if($i!=$j)
			$this->Cell($l/1000*$this->FontSize,$h,substr($s,$j),0,0,$alling,false,$link);
	}

	// Public Functions

	function WriteTag($w, $h, $txt, $border=0, $align="J", $fill=false, $padding=0)
	{
		$this->wLine=$w;
		$this->hLine=$h;
		$this->Text=trim($txt);
		$this->Text=preg_replace("/\n|\r|\t/","",$this->Text);
		$this->border=$border;
		$this->align=$align;
		$this->fill=$fill;
		$this->Padding=$padding;

		$this->Xini=$this->GetX();
		$this->href="";
		$this->PileStyle=array();
		$this->TagHref=array();
		$this->LastLine=false;

		$this->SetSpace();
		$this->Padding();
		$this->LineLength();
		$this->BorderTop();

		while($this->Text!="")
		{
			$this->MakeLine();
			$this->PrintLine();
		}

		$this->BorderBottom();
	}
	function WriteTagIdent($w, $h, $txt, $border=0, $align="J", $fill=false, $padding=0)
	{
		$this->wLine=$w;
		$this->hLine=$h;
		$this->Text=trim($txt);
		$this->Text=preg_replace("/\n|\r|\t/","",$this->Text);
		$this->border=$border;
		$this->align=$align;
		$this->fill=$fill;
		$this->Padding=$padding;

		$this->Xini=$this->GetX();
		$this->href="";
		$this->PileStyle=array();
		$this->TagHref=array();
		$this->LastLine=false;

		$this->SetSpace();
		$this->Padding();
		$this->LineLength();
		$this->BorderTop();

		while($this->Text!="")
		{
			$this->MakeLine();
			$this->PrintLine1();
		}

		$this->BorderBottom();
	}
	function SetStyle($tag, $family, $style, $size, $color, $pspace=0, $indent=-1)
	{
		 $tag=trim($tag);
		 $this->TagStyle[$tag]['family']=trim($family);
		 $this->TagStyle[$tag]['style']=trim($style);
		 $this->TagStyle[$tag]['size']=trim($size);
		 $this->TagStyle[$tag]['color']=trim($color);
		 $this->TagStyle[$tag]['indent']=$indent;
		 $this->Pspace = $pspace;
	}


	// Private Functions
    function SetMarginsP(){

    }
	function SetSpace() // Minimal space between words
	{
		$tag=$this->Parser($this->Text);
		$this->FindStyle($tag[2],0);
		$this->DoStyle(0);
		$this->Space=$this->GetStringWidth(" ");
	}


	function Padding()
	{
		if(preg_match("/^.+,/",$this->Padding)) {
			$tab=explode(",",$this->Padding);
			$this->lPadding=$tab[0];
			$this->tPadding=$tab[1];
			if(isset($tab[2]))
				$this->bPadding=$tab[2];
			else
				$this->bPadding=$this->tPadding;
			if(isset($tab[3]))
				$this->rPadding=$tab[3];
			else
				$this->rPadding=$this->lPadding;
		}
		else
		{
			$this->lPadding=$this->Padding;
			$this->tPadding=$this->Padding;
			$this->bPadding=$this->Padding;
			$this->rPadding=$this->Padding;
		}
		if($this->tPadding<$this->LineWidth)
			$this->tPadding=$this->LineWidth;
	}


	function LineLength()
	{
		if($this->wLine==0)
			$this->wLine=$this->w - $this->Xini - $this->rMargin;

		$this->wTextLine = $this->wLine - $this->lPadding - $this->rPadding;
	}


	function BorderTop()
	{
		$border=0;
		if($this->border==1)
			$border="TLR";
		$this->Cell($this->wLine,$this->tPadding,"",$border,0,'C',$this->fill);
		$y=$this->GetY()+$this->tPadding;
		$this->SetXY($this->Xini,$y);
	}


	function BorderBottom()
	{
		$border=0;
		if($this->border==1)
			$border="BLR";
		$this->Cell($this->wLine,$this->bPadding,"",$border,0,'C',$this->fill);
	}


	function DoStyle($tag) // Applies a style
	{
		$tag=trim($tag);
		$this->SetFont($this->TagStyle[$tag]['family'],
			$this->TagStyle[$tag]['style'],
			$this->TagStyle[$tag]['size']);

		$tab=explode(",",$this->TagStyle[$tag]['color']);
		if(count($tab)==1)
			$this->SetTextColor($tab[0]);
		else
			$this->SetTextColor($tab[0],$tab[1],$tab[2]);
	}


	function FindStyle($tag, $ind) // Inheritance from parent elements
	{
		$tag=trim($tag);

		// Family
		if($this->TagStyle[$tag]['family']!="")
			$family=$this->TagStyle[$tag]['family'];
		else
		{
			reset($this->PileStyle);
            foreach ($this->PileStyle as $k=>$val)
			{
				$val=trim($val);
				if($this->TagStyle[$val]['family']!="") {
					$family=$this->TagStyle[$val]['family'];
					break;
				}
			}
		}

		// Style
		$style="";
		$style1=strtoupper($this->TagStyle[$tag]['style']);
		if($style1!="N")
		{
			$bold=false;
			$italic=false;
			$underline=false;
			reset($this->PileStyle);
			foreach ($this->PileStyle as $k=>$val)
			{
				$val=trim($val);
				$style1=strtoupper($this->TagStyle[$val]['style']);
				if($style1=="N")
					break;
				else
				{
					if(strpos($style1,"B")!==false)
						$bold=true;
					if(strpos($style1,"I")!==false)
						$italic=true;
					if(strpos($style1,"U")!==false)
						$underline=true;
				}
			}
			if($bold)
				$style.="B";
			if($italic)
				$style.="I";
			if($underline)
				$style.="U";
		}

		// Size
		if($this->TagStyle[$tag]['size']!=0)
			$size=$this->TagStyle[$tag]['size'];
		else
		{
			reset($this->PileStyle);
			foreach ($this->PileStyle as $k=>$val)
			{
				$val=trim($val);
				if($this->TagStyle[$val]['size']!=0) {
					$size=$this->TagStyle[$val]['size'];
					break;
				}
			}
		}

		// Color
		if($this->TagStyle[$tag]['color']!="")
			$color=$this->TagStyle[$tag]['color'];
		else
		{
			reset($this->PileStyle);
			foreach ($this->PileStyle as $k=>$val)
			{
				$val=trim($val);
				if($this->TagStyle[$val]['color']!="") {
					$color=$this->TagStyle[$val]['color'];
					break;
				}
			}
		}

		// Result
		$this->TagStyle[$ind]['family']=$family;
		$this->TagStyle[$ind]['style']=$style;
		$this->TagStyle[$ind]['size']=$size;
		$this->TagStyle[$ind]['color']=$color;
		$this->TagStyle[$ind]['indent']=$this->TagStyle[$tag]['indent'];
	}


	function Parser($text)
	{
		$tab=array();
		// Closing tag
		if(preg_match("|^(</([^>]+)>)|",$text,$regs)) {
			$tab[1]="c";
			$tab[2]=trim($regs[2]);
		}
		// Opening tag
		else if(preg_match("|^(<([^>]+)>)|",$text,$regs)) {
			$regs[2]=preg_replace("/^a/","a ",$regs[2]);
			$tab[1]="o";
			$tab[2]=trim($regs[2]);

			// Presence of attributes
			if(preg_match("/(.+) (.+)='(.+)'/",$regs[2])) {
				$tab1=preg_split("/ +/",$regs[2]);
				$tab[2]=trim($tab1[0]);
                foreach ($this->PileStyle as $i=>$couple)
				{
					if($i>0) {
						$tab2=explode("=",$couple);
						$tab2[0]=trim($tab2[0]);
						$tab2[1]=trim($tab2[1]);
						$end=strlen($tab2[1])-2;
						$tab[$tab2[0]]=substr($tab2[1],1,$end);
					}
				}
			}
		}
	 	// Space
	 	else if(preg_match("/^( )/",$text,$regs)) {
			$tab[1]="s";
			$tab[2]=' ';
		}
		// Text
		else if(preg_match("/^([^< ]+)/",$text,$regs)) {
			$tab[1]="t";
			$tab[2]=trim($regs[1]);
		}

		$begin=strlen($regs[1]);
 		$end=strlen($text);
 		$text=substr($text, $begin, $end);
		$tab[0]=$text;

		return $tab;
	}


	function MakeLine()
	{
		$this->Text.=" ";
		$this->LineLength=array();
		$this->TagHref=array();
		$Length=0;
		$this->nbSpace=0;

		$i=$this->BeginLine();
		$this->TagName=array();

		if($i==0) {
			$Length=$this->StringLength[0];
			$this->TagName[0]=1;
			$this->TagHref[0]=$this->href;
		}

		while($Length<$this->wTextLine)
		{
			$tab=$this->Parser($this->Text);
			$this->Text=$tab[0];
			if($this->Text=="") {
				$this->LastLine=true;
				break;
			}

			if($tab[1]=="o") {
				array_unshift($this->PileStyle,$tab[2]);
				$this->FindStyle($this->PileStyle[0],$i+1);

				$this->DoStyle($i+1);
				$this->TagName[$i+1]=1;
				if($this->TagStyle[$tab[2]]['indent']!=-1) {
					$Length+=$this->TagStyle[$tab[2]]['indent'];
					$this->Indent=$this->TagStyle[$tab[2]]['indent'];
				}
				if($tab[2]=="a")
					$this->href=$tab['href'];
			}

			if($tab[1]=="c") {
				array_shift($this->PileStyle);
				if(isset($this->PileStyle[0]))
				{
					$this->FindStyle($this->PileStyle[0],$i+1);
					$this->DoStyle($i+1);
				}
				$this->TagName[$i+1]=1;
				if($this->TagStyle[$tab[2]]['indent']!=-1) {
					$this->LastLine=true;
					$this->Text=trim($this->Text);
					break;
				}
				if($tab[2]=="a")
					$this->href="";
			}

			if($tab[1]=="s") {
				$i++;
				$Length+=$this->Space;
				$this->Line2Print[$i]="";
				if($this->href!="")
					$this->TagHref[$i]=$this->href;
			}

			if($tab[1]=="t") {
				$i++;
				$this->StringLength[$i]=$this->GetStringWidth($tab[2]);
				$Length+=$this->StringLength[$i];
				$this->LineLength[$i]=$Length;
				$this->Line2Print[$i]=$tab[2];
				if($this->href!="")
					$this->TagHref[$i]=$this->href;
			 }

		}

		trim($this->Text);
		if($Length>$this->wTextLine || $this->LastLine==true)
			$this->EndLine();
	}


	function BeginLine()
	{
		$this->Line2Print=array();
		$this->StringLength=array();

		if(isset($this->PileStyle[0]))
		{
			$this->FindStyle($this->PileStyle[0],0);
			$this->DoStyle(0);
		}

		if(count($this->NextLineBegin)>0) {
			$this->Line2Print[0]=$this->NextLineBegin['text'];
			$this->StringLength[0]=$this->NextLineBegin['length'];
			$this->NextLineBegin=array();
			$i=0;
		}
		else {
			preg_match("/^(( *(<([^>]+)>)* *)*)(.*)/",$this->Text,$regs);
			$regs[1]=str_replace(" ", "", $regs[1]);
			$this->Text=$regs[1].$regs[5];
			$i=-1;
		}

		return $i;
	}


	function EndLine()
	{
		if(end($this->Line2Print)!="" && $this->LastLine==false) {
			$this->NextLineBegin['text']=array_pop($this->Line2Print);
			$this->NextLineBegin['length']=end($this->StringLength);
			array_pop($this->LineLength);
		}

		while(end($this->Line2Print)==="")
			array_pop($this->Line2Print);

		$this->Delta=$this->wTextLine-end($this->LineLength);

		$this->nbSpace=0;
		for($i=0; $i<count($this->Line2Print); $i++) {
			if($this->Line2Print[$i]=="")
				$this->nbSpace++;
		}
	}


	function PrintLine()
	{
		$border=0;
		if($this->border==1)
			$border="LR";
		$this->Cell($this->wLine,$this->hLine,"",$border,0,'C',$this->fill);
		$y=$this->GetY();
		$this->SetXY($this->Xini+$this->lPadding,$y);

		if($this->Indent!=-1) {
			if($this->Indent!=0)
				$this->Cell($this->Indent,$this->hLine);
			//$this->Indent=-1;
		}

		$space=$this->LineAlign();
		$this->DoStyle(0);
		for($i=0; $i<count($this->Line2Print); $i++)
		{
			if(isset($this->TagName[$i]))
				$this->DoStyle($i);
			if(isset($this->TagHref[$i]))
				$href=$this->TagHref[$i];
			else
				$href='';
			if($this->Line2Print[$i]=="")
				$this->Cell($space,$this->hLine,"         ",0,0,'C',false,$href);
			else
				$this->Cell($this->StringLength[$i],$this->hLine,$this->Line2Print[$i],0,0,'C',false,$href);
		}

		$this->LineBreak();
		if($this->LastLine && $this->Text!="")
			$this->EndParagraph();
		$this->LastLine=false;
	}
	function PrintLine1()
	{
		$border=0;
		if($this->border==1)
			$border="LR";
		$this->Cell($this->wLine,$this->hLine,"",$border,0,'C',$this->fill);
		$y=$this->GetY();
		$this->SetXY($this->Xini+$this->lPadding,$y);

		if($this->Indent!=-1) {
			if($this->Indent!=0)
				$this->Cell($this->Indent,$this->hLine);
			$this->Indent=-1;
		}

		$space=$this->LineAlign();
		$this->DoStyle(0);
		for($i=0; $i<count($this->Line2Print); $i++)
		{
			if(isset($this->TagName[$i]))
				$this->DoStyle($i);
			if(isset($this->TagHref[$i]))
				$href=$this->TagHref[$i];
			else
				$href='';
			if($this->Line2Print[$i]=="")
				$this->Cell($space,$this->hLine,"         ",0,0,'C',false,$href);
			else
				$this->Cell($this->StringLength[$i],$this->hLine,$this->Line2Print[$i],0,0,'C',false,$href);
		}

		$this->LineBreak();
		if($this->LastLine && $this->Text!="")
			$this->EndParagraph();
		$this->LastLine=false;
	}


	function LineAlign()
	{
		$space=$this->Space;
		if($this->align=="J") {
			if($this->nbSpace!=0)
				$space=$this->Space + ($this->Delta/$this->nbSpace);
			if($this->LastLine)
				$space=$this->Space;
		}

		if($this->align=="R")
			$this->Cell($this->Delta,$this->hLine);

		if($this->align=="C")
			$this->Cell($this->Delta/2,$this->hLine);

		return $space;
	}


	function LineBreak()
	{
		$x=$this->Xini;
		$y=$this->GetY()+$this->hLine;
		$this->SetXY($x,$y);
	}


	function EndParagraph()
	{
		$border=0;
		if($this->border==1)
			$border="LR";
		$this->Cell($this->wLine,$this->hLine/2,"",$border,0,'C',$this->fill);
		$x=$this->Xini;
		//dd($this->hLine/2);
		//$y=$this->GetY()+$this->hLine/2;
		$y=$this->GetY();
		//dd($y);
		$this->SetXY($x,$y);
	}

	function SetWidths($w)
	{
	    //Set the array of column widths
	    $this->widths=$w;
	}

	function SetAligns($a)
	{
	    //Set the array of column alignments
	    $this->aligns=$a;
	}

	function Row($data)
	{
	    //Calculate the height of the row
	    $nb=0;
	    for($i=0;$i<count($data);$i++)
	        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
	    $h=5*$nb;
	    //Issue a page break first if needed
	    $this->CheckPageBreak($h);
	    //Draw the cells of the row
	    for($i=0;$i<count($data);$i++)
	    {
	        $w=$this->widths[$i];
	        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
	        //Save the current position
	        $x=$this->GetX();
	        $y=$this->GetY();
	        //Draw the border
	        $this->Rect($x,$y,$w,$h);
	        //Print the text
	        $this->MultiCell($w,5,$data[$i],0,$a);
	        //Put the position to the right of the cell
	        $this->SetXY($x+$w,$y);
	    }
	    //Go to the next line
	    $this->Ln($h);
	}

	function CheckPageBreak($h)
	{
	    //If the height h would cause an overflow, add a new page immediately
	    if($this->GetY()+$h>$this->PageBreakTrigger)
	        $this->AddPage($this->CurOrientation);
	}

	function NbLines($w,$txt)
	{
	    //Computes the number of lines a MultiCell of width w will take
	    $cw=&$this->CurrentFont['cw'];
	    if($w==0)
	        $w=$this->w-$this->rMargin-$this->x;
	    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
	    $s=str_replace("\r",'',$txt);
	    $nb=strlen($s);
	    if($nb>0 and $s[$nb-1]=="\n")
	        $nb--;
	    $sep=-1;
	    $i=0;
	    $j=0;
	    $l=0;
	    $nl=1;
	    while($i<$nb)
	    {
	        $c=$s[$i];
	        if($c=="\n")
	        {
	            $i++;
	            $sep=-1;
	            $j=$i;
	            $l=0;
	            $nl++;
	            continue;
	        }
	        if($c==' ')
	            $sep=$i;
	        $l+=$cw[$c];
	        if($l>$wmax)
	        {
	            if($sep==-1)
	            {
	                if($i==$j)
	                    $i++;
	            }
	            else
	                $i=$sep+1;
	            $sep=-1;
	            $j=$i;
	            $l=0;
	            $nl++;
	        }
	        else
	            $i++;
	    }
	    return $nl;
	}

// Tabla simple
    function BasicTable($header, $data)
    {
        // Cabecera
        foreach($header as $col)
            $this->Cell(40,7,$col,1);
        $this->Ln();
        // Datos
        foreach($data as $row)
        {
            foreach($row as $col)
                $this->Cell(40,6,$col,1);
            $this->Ln();
        }
    }

// Una tabla más completa
    function ImprovedTable($header, $data)
    {
        // Anchuras de las columnas
        $w = array(40, 35, 45, 40);
        // Cabeceras
        for($i=0;$i<count($header);$i++)
            $this->Cell($w[$i],7,$header[$i],1,0,'C');
        $this->Ln();
        // Datos
        foreach($data as $row)
        {
            $this->Cell($w[0],6,$row[0],'LR');
            $this->Cell($w[1],6,$row[1],'LR');
            $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
            $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
            $this->Ln();
        }
        // Línea de cierre
        $this->Cell(array_sum($w),0,'','T');
    }

// Tabla coloreada
    function LineaDeTiempo($header, $data,$especificas, $componentes, $ejecucion, $analitico, $presupuesto)
    {
        // Colores, ancho de línea y fuente en negrita
        $this->SetTextColor(0);
        $this->SetDrawColor(0,0,0);
        $this->SetLineWidth(.2);
        $this->SetFontSize(6.5);
        // Cabecera
        $w_month=16;
        $w_acum=18;
        $w = array(40, 47, $w_acum, $w_acum, $w_acum,
            $w_month, $w_month, $w_month, $w_month, $w_month, $w_month, $w_month, $w_month, $w_month, $w_month, $w_month, $w_month,
            $w_acum,$w_acum, $w_acum+1);
        $size = 4;
        $this->cabeceraLineaDeTeimpo($header,$w,$size);
        // Restauración de colores y fuentes
        $this->SetTextColor(0);
        // Datos
        $fill = false;
        $x1=$this->GetX();
        $big_y=$y=$this->GetY();
        $max_y=$this->GetPageHeight()-($this->lMargin+$this->rMargin);


        foreach($analitico as $comp=>$d_1) {
            if ($comp != 't'&&$comp != 'm') {
                if(!isset($data[$comp]))
                    $data[$comp]=['d'=>0];
                foreach ($d_1 as $esp => $d_2) {
                    if ($esp != 't'&&$esp != 'm'&&!isset($data[$comp][$esp])) {
                            $data[$comp][$esp]=['d'=>0,0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,7=>0,8=>0,9=>0,10=>0,11=>0];
                    }
                }
            }
        }
        foreach($data as $comp=>$d1) {
            if ($comp!='d'&&$comp!='r') {
                $data[$comp]['r']=$this->precount($w[0], $size, 'LR', 'C', (isset($componentes[$comp]))?$componentes[$comp]:'DESCONOCIDO');
                foreach ($d1 as $esp => $d2) {
                    if ($esp != 'd'&&$esp!='r'&&$esp!='fisico'){
                        $data[$comp][$esp]['r']=$this->precount($w[1], $size, 'LR', 'C', $especificas[$esp]);
                        foreach ($d2 as $mes => $d3) {
                            if ($mes !== 'd'&&$mes!='r') {

                            }
                        }

                    }
                }
            }
        }
        $acum_total=[0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,7=>0,8=>0,9=>0,10=>0,11=>0];
        foreach($data as $comp=>$d1) {
            if ($comp!='d'&&$comp!='r'&&isset($analitico[$comp])) {
                $acum_mes_comp=[0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,7=>0,8=>0,9=>0,10=>0,11=>0];
                foreach ($d1 as $esp => $d2) {
                    $x=$x1;
                    $y=$big_y;
                    $this->SetXY($x,$y);
                    if ($esp != 'd'&&$esp!='r'&&$esp!='fisico'&&isset($analitico[$comp][$esp])){
                        $reng=($d1['r']>$d2['r'])?$d1['r']:$d2['r'];
                        $acum=(isset($ejecucion[$comp])&&isset($ejecucion[$comp][$esp]))?$ejecucion[$comp][$esp]:0;
                        $pim = (isset($presupuesto[$comp])&&isset($presupuesto[$comp][$esp]))?$presupuesto[$comp][$esp]->pim:0;
                        list($big_y, $x)=$this->MultiCellAndPoss($w[0], $size, (isset($componentes[$comp]))?$componentes[$comp]:'DESCONOCIDO', 1, 'C', $fill, $x, $big_y, $y, $d1['r'], $reng);
                        list($big_y, $x)=$this->MultiCellAndPoss($w[1], $size, $especificas[$esp], 1, 'L', $fill, $x, $big_y, $y, $d2['r'], $reng);
                        list($big_y, $x)=$this->MultiCellAndPoss($w[2], $size, Money::toMoney($analitico[$comp][$esp]->ana_monto+$analitico[$comp][$esp]->ana_modificaciones,''), 1,  'R', $fill, $x, $big_y, $y, 1, $reng);
                        list($big_y, $x)=$this->MultiCellAndPoss($w[3], $size, Money::toMoney($acum,''), 1,  'R', $fill, $x, $big_y, $y, 1, $reng);
                        list($big_y, $x)=$this->MultiCellAndPoss($w[4], $size, Money::toMoney($pim,''), 1,  'R', $fill, $x, $big_y, $y, 1, $reng);

                        /*foreach ($d2 as $mes => $d3) {
                            if ($mes !== 'd'&&$mes!=='r') {
                                list($big_y, $x)=$this->MultiCellAndPoss($w[$mes + 5], $size, Money::toMoney($d3,'', -1), 1,  'R', $fill, $x, $big_y, $y, 1, $reng);
                                $acum_mes_comp[$mes]+=$d3;
                                $acum_total[$mes]+=$d3;
                            }
                        }*/
                        for ($i=0;$i<12;$i++)
                        {
                            list($big_y, $x)=$this->MultiCellAndPoss($w[$mes + 5], $size, Money::toMoney((isset($d2[$i])?$d2[$i]:0),'', -1), 1,  'R', $fill, $x, $big_y, $y, 1, $reng);
                            $acum_mes_comp[$i]+=(isset($d2[$i])?$d2[$i]:0);
                            $acum_total[$i]+=(isset($d2[$i])?$d2[$i]:0);
                        }

                        list($big_y, $x)=$this->MultiCellAndPoss($w[17], $size, Money::toMoney($analitico[$comp][$esp]->ana_monto+$analitico[$comp][$esp]->ana_modificaciones-$acum,''), 1,  'R', $fill, $x, $big_y, $y, 1, $reng);
                        list($big_y, $x)=$this->MultiCellAndPoss($w[18], $size, Money::toMoney($d2['d'],''), 1,  'R', $fill, $x, $big_y, $y, 1, $reng);
                        list($big_y, $x)=$this->MultiCellAndPoss($w[19], $size, Money::toMoney($d2['d']-$pim,''), 1,  'R', $fill, $x, $big_y, $y, 1, $reng, $max_y, $header,$w);
                }
                }
                $fill = !$fill;
                $x=$x1;
                $y=$big_y;
                $this->SetXY($x,$y);
                $acum=(isset($ejecucion[$comp]))?$ejecucion[$comp]['monto']:0;
                $pim = (isset($presupuesto[$comp]))?$presupuesto[$comp]['t']:0;
                list($big_y, $x)=$this->MultiCellAndPoss($w[0]+$w[1], $size, 'TOTAL : ('.$comp.') '.((isset($componentes[$comp]))?$componentes[$comp]:'DESCONOCIDO'), 1, 'L', $fill, $x, $big_y, $y, 1, 1);
                list($big_y, $x)=$this->MultiCellAndPoss($w[2], $size, Money::toMoney($analitico[$comp]['t']+$analitico[$comp]['m'],''), 1,  'R', $fill, $x, $big_y, $y, 1, 1);
                list($big_y, $x)=$this->MultiCellAndPoss($w[3], $size, Money::toMoney($acum,''), 1,  'R', $fill, $x, $big_y, $y, 1, 1);
                list($big_y, $x)=$this->MultiCellAndPoss($w[4], $size, Money::toMoney($pim,''), 1,  'R', $fill, $x, $big_y, $y, 1, 1);
                for ($i=0;$i<12;$i++){
                    list($big_y, $x)=$this->MultiCellAndPoss($w[$i + 5], $size, Money::toMoney($acum_mes_comp[$i],''), 1,  'R', $fill, $x, $big_y, $y, 1, 1);
                }
                list($big_y, $x)=$this->MultiCellAndPoss($w[17], $size, Money::toMoney($analitico[$comp]['t']+$analitico[$comp]['m']-$acum,''), 1,  'R', $fill, $x, $big_y, $y, 1, 1);
                list($big_y, $x)=$this->MultiCellAndPoss($w[18], $size, Money::toMoney($d1['d'],''), 1,  'R', $fill, $x, $big_y, $y, 1, 1);
                list($big_y, $x)=$this->MultiCellAndPoss($w[19], $size, Money::toMoney($d1['d']-$pim,''), 1,  'R', $fill, $x, $big_y, $y, 1, 1, $max_y, $header,$w);
                $fill = !$fill;
            }
        }
        //$fill = !$fill;
        $x=$x1;
        $y=$big_y;
        $this->SetXY($x,$y);
        $acum=$ejecucion['monto'];
        $pim = $presupuesto['t'];
        $this->SetFont('','B');
        //$this->SetFillColor(0,112,192);
        list($big_y, $x)=$this->MultiCellAndPoss($w[0]+$w[1], $size, 'TOTAL DEL PROYECTO', 1, 'R', $fill, $x, $big_y, $y, 1, 1);
        list($big_y, $x)=$this->MultiCellAndPoss($w[2], $size, Money::toMoney($analitico['t']+$analitico['m'],''), 1,  'R', $fill, $x, $big_y, $y, 1, 1);
        list($big_y, $x)=$this->MultiCellAndPoss($w[3], $size, Money::toMoney($acum,''), 1,  'R', $fill, $x, $big_y, $y, 1, 1);
        list($big_y, $x)=$this->MultiCellAndPoss($w[4], $size, Money::toMoney($pim,''), 1,  'R', $fill, $x, $big_y, $y, 1, 1);
        for ($i=0;$i<12;$i++){
            list($big_y, $x)=$this->MultiCellAndPoss($w[$i + 5], $size, Money::toMoney($acum_total[$i],''), 1,  'R', $fill, $x, $big_y, $y, 1, 1);
        }
        list($big_y, $x)=$this->MultiCellAndPoss($w[17], $size, Money::toMoney($analitico['t']+$analitico['m']-$acum,''), 1,  'R', $fill, $x, $big_y, $y, 1, 1);
        list($big_y, $x)=$this->MultiCellAndPoss($w[18], $size, Money::toMoney($data['d'],''), 1,  'R', $fill, $x, $big_y, $y, 1, 1);
        list($big_y, $x)=$this->MultiCellAndPoss($w[19], $size, Money::toMoney($data['d']-$pim,''), 1,  'R', $fill, $x, $big_y, $y, 1, 1, $max_y, $header,$w);
        $fill = !$fill;
    }


    function Modificatoria($header, $data,$especificas, $componentes, $ejecucion, $analitico, $presupuesto)
    {
        // Colores, ancho de línea y fuente en negrita
        $this->SetTextColor(0);
        $this->SetDrawColor(0,0,0);
        $this->SetLineWidth(.2);
        $this->SetFontSize(7.5);
        // Cabecera
        $w_acum=22;
        $w = array(40, 80, $w_acum, $w_acum, $w_acum,
            $w_acum, $w_acum, $w_acum, 120);
        $size = 4;
        $this->cabeceraLineaDeTeimpo($header,$w,$size);
        // Restauración de colores y fuentes
        $this->SetTextColor(0);
        // Datos
        $fill = false;
        $x1=$this->GetX();
        $big_y=$y=$this->GetY();
        $max_y=$this->GetPageHeight()-($this->lMargin+$this->rMargin);


        foreach($analitico as $comp=>$d_1) {
            if ($comp != 't'&&$comp != 'm') {
                if(!isset($data[$comp]))
                    $data[$comp]=['d'=>0];
                foreach ($d_1 as $esp => $d_2) {
                    if ($esp != 't'&&$esp != 'm'&&!isset($data[$comp][$esp])) {
                        $data[$comp][$esp]=['d'=>0,0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,7=>0,8=>0,9=>0,10=>0,11=>0];
                    }
                }
            }
        }
        foreach($data as $comp=>$d1) {
            if ($comp!='d'&&$comp!='r') {
                $data[$comp]['r']=$this->precount($w[0], $size, 'LR', 'C', (isset($componentes[$comp]))?$componentes[$comp]:'DESCONOCIDO');
                foreach ($d1 as $esp => $d2) {
                    if ($esp != 'd'&&$esp!='r'&&$esp!='fisico'){
                        $data[$comp][$esp]['r']=$this->precount($w[1], $size, 'LR', 'C', $especificas[$esp]);
                        foreach ($d2 as $mes => $d3) {
                            if ($mes !== 'd'&&$mes!='r') {

                            }
                        }

                    }
                }
            }
        }
        $de_acum=0;
        $a_acum=0;
        foreach($data as $comp=>$d1) {
            $de=0;
            $a=0;
            if ($comp!='d'&&$comp!='r'&&isset($analitico[$comp])) {
                foreach ($d1 as $esp => $d2) {
                    $x=$x1;
                    $y=$big_y;
                    $this->SetXY($x,$y);
                    $acum=(isset($ejecucion[$comp])&&isset($ejecucion[$comp][$esp]))?$ejecucion[$comp][$esp]:0;
                    $pim = (isset($presupuesto[$comp])&&isset($presupuesto[$comp][$esp]))?$presupuesto[$comp][$esp]->pim:0;
                    $de +=($d2['d']-$pim<0)?$d2['d']-$pim:0;
                    $a  +=($d2['d']-$pim>0)?$d2['d']-$pim:0;
                    if ($esp != 'd'&&$esp!='r'&&$esp!='fisico'&&isset($analitico[$comp][$esp])&&($d2['d']-$pim!=0)){
                        $reng=($d1['r']>$d2['r'])?$d1['r']:$d2['r'];
                        list($big_y, $x)=$this->MultiCellAndPoss($w[0], $size, (isset($componentes[$comp]))?$componentes[$comp]:'DESCONOCIDO', 1, 'C', $fill, $x, $big_y, $y, $d1['r'], $reng);
                        list($big_y, $x)=$this->MultiCellAndPoss($w[1], $size, $especificas[$esp], 1, 'L', $fill, $x, $big_y, $y, $d2['r'], $reng);
                        list($big_y, $x)=$this->MultiCellAndPoss($w[2], $size, Money::toMoney($analitico[$comp][$esp]->ana_monto+$analitico[$comp][$esp]->ana_modificaciones,''), 1,  'R', $fill, $x, $big_y, $y, 1, $reng);
                        list($big_y, $x)=$this->MultiCellAndPoss($w[3], $size, Money::toMoney($acum,''), 1,  'R', $fill, $x, $big_y, $y, 1, $reng);
                        list($big_y, $x)=$this->MultiCellAndPoss($w[4], $size, Money::toMoney($pim,''), 1,  'R', $fill, $x, $big_y, $y, 1, $reng);
                        list($big_y, $x)=$this->MultiCellAndPoss($w[5], $size, ($d2['d']-$pim<0)?Money::toMoney($d2['d']-$pim,''):'', 1,  'R', $fill, $x, $big_y, $y, 1, $reng);
                        list($big_y, $x)=$this->MultiCellAndPoss($w[6], $size, ($d2['d']-$pim>0)?Money::toMoney($d2['d']-$pim,''):'', 1,  'R', $fill, $x, $big_y, $y, 1, $reng);
                        list($big_y, $x)=$this->MultiCellAndPoss($w[7], $size, Money::toMoney($d2['d'],''), 1,  'R', $fill, $x, $big_y, $y, 1, $reng);
                        list($big_y, $x)=$this->MultiCellAndPoss($w[8], $size, '', 1,  'R', $fill, $x, $big_y, $y, 1, $reng, $max_y, $header,$w);
                    }
                }
                if ($de<0||$a>0) {
                    $de_acum+=$de;
                    $a_acum+=$a;
                    $fill = !$fill;
                    $x = $x1;
                    $y = $big_y;
                    $this->SetXY($x, $y);
                    $acum = (isset($ejecucion[$comp])) ? $ejecucion[$comp]['monto'] : 0;
                    $pim = (isset($presupuesto[$comp])) ? $presupuesto[$comp]['t'] : 0;
                    list($big_y, $x) = $this->MultiCellAndPoss($w[0] + $w[1], $size, 'TOTAL : (' . $comp . ') ' . ((isset($componentes[$comp])) ? $componentes[$comp] : 'DESCONOCIDO'), 1, 'L', $fill, $x, $big_y, $y, 1, 1);
                    list($big_y, $x) = $this->MultiCellAndPoss($w[2], $size, Money::toMoney($analitico[$comp]['t'] + $analitico[$comp]['m'], ''), 1, 'R', $fill, $x, $big_y, $y, 1, 1);
                    list($big_y, $x) = $this->MultiCellAndPoss($w[3], $size, Money::toMoney($acum, ''), 1, 'R', $fill, $x, $big_y, $y, 1, 1);
                    list($big_y, $x) = $this->MultiCellAndPoss($w[4], $size, Money::toMoney($pim, ''), 1, 'R', $fill, $x, $big_y, $y, 1, 1);
                    list($big_y, $x) = $this->MultiCellAndPoss($w[5], $size, ($de < 0) ? Money::toMoney($de, '') : '', 1, 'R', $fill, $x, $big_y, $y, 1, 1);
                    list($big_y, $x) = $this->MultiCellAndPoss($w[6], $size, ($a > 0) ? Money::toMoney($a, '') : '', 1, 'R', $fill, $x, $big_y, $y, 1, 1);
                    list($big_y, $x) = $this->MultiCellAndPoss($w[7], $size, Money::toMoney($d1['d'], ''), 1, 'R', $fill, $x, $big_y, $y, 1, 1);
                    list($big_y, $x) = $this->MultiCellAndPoss($w[8], $size, '', 1, 'R', false, $x, $big_y, $y, 1, 1, $max_y, $header, $w);
                    $fill = !$fill;
                }
            }
        }
        //$fill = !$fill;
        $x=$x1;
        $y=$big_y;
        $this->SetXY($x,$y);
        $acum=$ejecucion['monto'];
        $pim = $presupuesto['t'];
        $this->SetFont('','B');
        //$this->SetFillColor(0,112,192);
        list($big_y, $x)=$this->MultiCellAndPoss($w[0]+$w[1], $size, 'TOTAL DEL PROYECTO', 1, 'R', $fill, $x, $big_y, $y, 1, 1);
        list($big_y, $x)=$this->MultiCellAndPoss($w[2], $size, Money::toMoney($analitico['t']+$analitico['m'],''), 1,  'R', $fill, $x, $big_y, $y, 1, 1);
        list($big_y, $x)=$this->MultiCellAndPoss($w[3], $size, Money::toMoney($acum,''), 1,  'R', $fill, $x, $big_y, $y, 1, 1);
        list($big_y, $x)=$this->MultiCellAndPoss($w[4], $size, Money::toMoney($pim,''), 1,  'R', $fill, $x, $big_y, $y, 1, 1);
        list($big_y, $x)=$this->MultiCellAndPoss($w[5], $size, ($de_acum < 0) ? Money::toMoney($de_acum, ''):'', 1,  'R', $fill, $x, $big_y, $y, 1, 1);
        list($big_y, $x)=$this->MultiCellAndPoss($w[6], $size, ($a_acum > 0) ? Money::toMoney($a_acum, '') : '', 1,  'R', $fill, $x, $big_y, $y, 1, 1);
        list($big_y, $x)=$this->MultiCellAndPoss($w[7], $size, Money::toMoney($data['d'],''), 1,  'R', $fill, $x, $big_y, $y, 1, 1, $max_y, $header,$w);
        $fill = !$fill;
    }
    function LineaDeTiempoResumida($header, $data,$especificas, $componentes, $ejecucion, $analitico, $presupuesto,$secs_func, $unidades_medida)
    {
        // Colores, ancho de línea y fuente en negrita
        $this->SetTextColor(0);
        $this->SetDrawColor(0,0,0);
        $this->SetLineWidth(.2);
        $this->SetFontSize(8);
        // Cabecera
        $w_month=19;
        //$w_acum=23;
        $w = array(70, 22, 22, $w_month,
            $w_month, $w_month, $w_month, $w_month, $w_month, $w_month, $w_month, $w_month, $w_month, $w_month, $w_month, $w_month,
            $w_month);
        $size = 5;
        $this->cabeceraLineaDeTeimpo($header,$w,$size);
        // Restauración de colores y fuentes
        $this->SetTextColor(0);
        // Datos
        $fill = false;
        $x1=$this->GetX();
        $big_y=$y=$this->GetY();
        $max_y=$this->GetPageHeight()-($this->lMargin+$this->rMargin);


        foreach($analitico as $comp=>$d_1) {
            if ($comp != 't') {
                if(!isset($data[$comp]))
                    $data[$comp]=['d'=>0];
                foreach ($d_1 as $esp => $d_2) {
                    if ($esp != 't'&&!isset($data[$comp][$esp])) {
                        $data[$comp][$esp]=['d'=>0,0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,7=>0,8=>0,9=>0,10=>0,11=>0];
                    }
                }
            }
        }
        //dd($analitico);
        foreach($data as $comp=>$d1) {
            if ($comp!='d'&&$comp!='r') {
                $data[$comp]['r']=$this->precount($w[0], $size, 'LR', 'C', (isset($componentes[$comp]))?$componentes[$comp]:'DESCONOCIDO');

            }
        }
        $acum_total=[0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,7=>0,8=>0,9=>0,10=>0,11=>0];
        foreach($data as $comp=>$d1) {
            if ($comp!='d'&&$comp!='r') {
                $acum_mes_comp=[0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,7=>0,8=>0,9=>0,10=>0,11=>0];
                foreach ($d1 as $esp => $d2) {
                    $x=$x1;
                    $y=$big_y;
                    $this->SetXY($x,$y);
                    if ($esp != 'd'&&$esp!='r'){
                        foreach ($d2 as $mes => $d3) {
                            if ($mes !== 'd'&&$mes!=='r') {
                                $acum_mes_comp[$mes]+=$d3;
                                $acum_total[$mes]+=$d3;
                            }
                        }
                    }
                }
                $fill = !$fill;
                $x=$x1;
                $y=$big_y;
                $this->SetXY($x,$y);
                $pim = (isset($presupuesto[$comp]))?$presupuesto[$comp]['t']:0;
                list($big_y, $x)=$this->MultiCellAndPoss($w[0], $size, ((isset($componentes[$comp]))?$componentes[$comp]:'DESCONOCIDO'), 1, 'L', $fill, $x, $big_y, $y, $d1['r'], 2);
                $x2=$x;
                list($big_y, $x)=$this->MultiCellAndPoss($w[1], $size, 'Financiero', 1,  'R', !$fill, $x, $big_y, $y, 1, 1);
                list($big_y, $x)=$this->MultiCellAndPoss($w[2], $size, 'S /', 1,  'C', !$fill, $x, $big_y, $y, 1, 1);
                list($big_y, $x)=$this->MultiCellAndPoss($w[3], $size, Money::toMoney($pim,''), 1,  'R', !$fill, $x, $big_y, $y, 1, 1);
                for ($i=0;$i<12;$i++){
                    list($big_y, $x)=$this->MultiCellAndPoss($w[$i + 4], $size, Money::toMoney($acum_mes_comp[$i],''), 1,  'R', !$fill, $x, $big_y, $y, 1, 1);
                }
                list($big_y, $x)=$this->MultiCellAndPoss($w[16], $size, Money::toMoney($d1['d'],''), 1,  'R', !$fill, $x, $big_y, $y, 1, 1, $max_y, $header,$w);

                $x=$x2;
                $y=$y+5;
                $this->SetXY($x,$y);
                $acum_fisic=0;
                list($big_y, $x)=$this->MultiCellAndPoss($w[1], $size, 'Fisico', 1,  'R', $fill, $x, $big_y, $y, 1, 1);
                $sec_func=isset($secs_func[$comp])?$secs_func[$comp]:null;
                list($big_y, $x)=$this->MultiCellAndPoss($w[2], $size, ($sec_func!=null)?$unidades_medida[(int)$sec_func->UNIDAD_ME2]->NOMBRE:'NO DEFINIDO', 1,  'R', $fill, $x, $big_y, $y, 1, 1);
                list($big_y, $x)=$this->MultiCellAndPoss($w[3], $size, ($sec_func!=null)?Money::toMoney($sec_func->CANTIDAD,'',1,1):'', 1,  'R', $fill, $x, $big_y, $y, 1, 1);
                for ($i=0;$i<12;$i++){
                    list($big_y, $x)=$this->MultiCellAndPoss($w[$i + 4], $size, Money::toMoney((isset($d1['fisico']))?$d1['fisico'][$i]:0,'',1,1), 1,  'R', $fill, $x, $big_y, $y, 1, 1);
                    $acum_fisic+=(isset($d1['fisico']))?$d1['fisico'][$i]:0;
                }
                list($big_y, $x)=$this->MultiCellAndPoss($w[16], $size, Money::toMoney($acum_fisic,''), 1,  'R', $fill, $x, $big_y, $y, 1, 1, $max_y, $header,$w);
                $fill = !$fill;
            }
        }
        //$fill = !$fill;
        $x=$x1;
        $y=$big_y;
        $this->SetXY($x,$y);
        $acum=$ejecucion['monto'];
        $pim = $presupuesto['t'];
        $this->SetFont('','B');
        //$this->SetFillColor(0,112,192);
        list($big_y, $x)=$this->MultiCellAndPoss($w[0]+$w[1]+$w[2]+$w[3], $size, 'TOTAL DEL PROYECTO', 1, 'C', $fill, $x, $big_y, $y, 1, 1);
        for ($i=0;$i<12;$i++){
            list($big_y, $x)=$this->MultiCellAndPoss($w[$i + 4], $size, Money::toMoney($acum_total[$i],''), 1,  'R', $fill, $x, $big_y, $y, 1, 1);
        }
        list($big_y, $x)=$this->MultiCellAndPoss($w[16], $size, Money::toMoney($data['d'],''), 1,  'R', $fill, $x, $big_y, $y, 1, 1, $max_y, $header,$w);
        $fill = !$fill;
    }
    function MultiCellAndPoss($w, $h, $txt, $border, $align, $fill, $x, $big_y, $y, $cur_reng, $max_reng, $max_y=false, $header=[],$wa=[]){
	    $reng_falt=$max_reng-$cur_reng;
	    $antes = (int) ($reng_falt/2);
	    $despues= $reng_falt - $antes+1;
        for ($i=0;$i<$antes;$i++){
            $txt="\n".$txt;
        }
        for ($i=0;$i<$despues;$i++){
            $txt=$txt."\n";
        }

        $this->MultiCell($w, $h, $txt, $border, $align, $fill);
        if (!$max_y) {
            $x += $w;
            $big_y = ($big_y > $this->GetY()) ? $big_y : $this->GetY();
            $this->SetXY($x, $y);
        }else{
            if($big_y>$max_y) {
                $this->AddPage();


                $this->cabeceraLineaDeTeimpo($header,$wa,4);
                $fill = false;

                $big_y=$this->GetY();
            }else
                $this->SetY($big_y);
        }
        return [$big_y, $x];
    }
    function cabeceraLineaDeTeimpo($header,$w,$size){

        // Cabecera
        $this->SetFillColor(189,215,238);
        $this->SetFont('','B');
        for($i=0;$i<count($header);$i++)
            list($big_y, $x)=$this->MultiCellAndPoss($w[$i], 2, utf8_decode($header[$i]), 1, 'C', true, $this->GetX(), $this->GetY(), $this->GetY(), 2, 2);
            //$this->Cell($w[$i],7,$header[$i],1,0,'C',true);
        $this->Ln();
        $this->Ln();
        $this->Ln();
        // Restauración de colores y fuentes
        $this->SetFillColor(224,235,255);
        $this->SetFont('');
    }
    function precount($w, $h, $border=0, $align='J', $txt)
    {
        $count=1;
        // Output text with automatic or explicit line breaks
        if(!isset($this->CurrentFont))
            $this->Error('No font has been set');
        $cw = &$this->CurrentFont['cw'];
        if($w==0)
            $w = $this->w-$this->rMargin-$this->x;
        $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
        $s = str_replace("\r",'',$txt);
        $nb = strlen($s);
        if($nb>0 && $s[$nb-1]=="\n")
            $nb--;
        $b = 0;
        if($border)
        {
            if($border==1)
            {
                $border = 'LTRB';
                $b = 'LRT';
                $b2 = 'LR';
            }
            else
            {
                $b2 = '';
                if(strpos($border,'L')!==false)
                    $b2 .= 'L';
                if(strpos($border,'R')!==false)
                    $b2 .= 'R';
                $b = (strpos($border,'T')!==false) ? $b2.'T' : $b2;
            }
        }
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $ns = 0;
        $nl = 1;
        $ca=[];
        while($i<$nb)
        {
            // Get next character
            $c = $s[$i];
            if($c=="\n")
            {
                // Explicit line break
                if($this->ws>0)
                {
                    $this->ws = 0;
                    $this->_out('0 Tw');
                }
                $count++;
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $ns = 0;
                $nl++;
                if($border && $nl==2)
                    $b = $b2;
                continue;
            }
            if($c==' ')
            {
                $sep = $i;
                $ls = $l;
                $ns++;
            }
            $l += $cw[$c];
            if($l>$wmax)
            {
                // Automatic line break
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                    if($this->ws>0)
                    {
                        $this->ws = 0;
                        $this->_out('0 Tw');
                    }
                    $count++;
                }
                else
                {
                    if($align=='J')
                    {
                        $this->ws = ($ns>1) ? ($wmax-$ls)/1000*$this->FontSize/($ns-1) : 0;
                        $this->_out(sprintf('%.3F Tw',$this->ws*$this->k));
                    }
                    $count++;
                    $i = $sep+1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $ns = 0;
                $nl++;
                if($border && $nl==2)
                    $b = $b2;
            }
            else
                $i++;
        }
        // Last chunk
        if($this->ws>0)
        {
            $this->ws = 0;
            $this->_out('0 Tw');
        }
        if($border && strpos($border,'B')!==false)
            $b .= 'B';
        //$count++;;
        $this->x = $this->lMargin;
        return($count);
    }
}
