<?php
/**
 * Created by PhpStorm.
 * User: Walther
 * Date: 12/04/2017
 * Time: 16:15
 */

namespace App\_clases\utilitarios;


class Money {

    private $pence;

    private function __construct($pence)
    {
        $this->pence = (float) $pence;
    }

    public static function fromPounds($pounds)
    {
        return new static($pounds * 100);
    }

    public static function fromPence($pence)
    {
        return new static($pence);
    }

    public function inPence()
    {
        return (string) $this->pence;
    }

    public function inPounds()
    {
        return (string) ( $this->pence / 100 );
    }

    public function inPoundsAndPence()
    {
        return number_format( $this->pence / 100, 2 );
    }
    /**
     * combierte un numero en su precentacion de moneda
     *
     * @param  float  $val
     * @param  string  $symbol
     * @param  int  $r
     * @return string
     * @static
     */
    public static function toMoney($val,$symbol='S/ ',$r=1, $length=2) {
        /*$n = $val;
        $t = ',';
        $sign = ($n < 0) ? '-' : '';
        $i = $n=number_format(abs($n),$r);
        $j = (($j = strlen($i)) > 3) ? $j % 3 : 0;

        return  $symbol.$sign .($j ? substr($i,0, $j) + $t : '').preg_replace('/(\d{3})(?=\d)/',"$1" + $t,substr($i,$j)) ;*/
        /*usamod el metodo isnumeric() para verificar y comprender todos los patrones numericos*/
        $val=(is_numeric($val))?    $val:0;
        /*redondeo manual a 0 para que no muestre -0 en el resultado*/
        $val = ($val>(-1*pow(10,(-$length-1)))&&$val<pow(10,(-$length-1)))?0:$val;
        if ($r==1||$val>0)
            $return = ($val!=''||$val==0)?$symbol.number_format($val, $length, '.', ','):'';
        else
            $return='';
        return $return;
    }
    /**
     * combierte un numero en su precentacion de porcentaje
     *
     * @param  float  $dat
     * @return string
     * @static
     */
    public static function porcentaje( $dat){
        return round($dat*100,2)."%";
    }
    public static function Unidades($num){
     $unidades = [1=>"UN",2=>"DOS",3=>"TRES",4=>"CUATRO",5=>"CINCO",6=>"SEIS",7=>"SIETE",8=>"OCHO",9=>"NUEVE"];

        return isset($unidades[$num])?$unidades[$num]:'';
    }

    public static function Decenas($num){

      $decena =  floor($num/10);
      $unidad =  $num - ($decena * 10);

      switch($decena)
      {
        case 1:   
          switch($unidad)
          {
            case 0: return "DIEZ";
            case 1: return "ONCE";
            case 2: return "DOCE";
            case 3: return "TRECE";
            case 4: return "CATORCE";
            case 5: return "QUINCE";
            default: return "DIECI" . Money::Unidades($unidad);
          }
        case 2:
          switch($unidad)
          {
            case 0: return "VEINTE";
            default: return "VEINTI" . Money::Unidades($unidad);
          }
        case 3: return Money::DecenasY("TREINTA", $unidad);
        case 4: return Money::DecenasY("CUARENTA", $unidad);
        case 5: return Money::DecenasY("CINCUENTA", $unidad);
        case 6: return Money::DecenasY("SESENTA", $unidad);
        case 7: return Money::DecenasY("SETENTA", $unidad);
        case 8: return Money::DecenasY("OCHENTA", $unidad);
        case 9: return Money::DecenasY("NOVENTA", $unidad);
        case 0: return Money::Unidades($unidad);
      }
    }//Unidades()

    public static function DecenasY($strSin, $numUnidades){
      if ($numUnidades > 0)
        return $strSin . " Y " . Money::Unidades($numUnidades);
        else
      return $strSin;
    }//DecenasY()

    public static function Centenas($num){

      $centenas = floor($num / 100);
      $decenas = $num - ($centenas * 100);

      switch($centenas)
      {
        case 1:
          if ($decenas > 0)
            return "CIENTO " . Money::Decenas($decenas);
          return "CIEN";
        case 2: return "DOSCIENTOS " . Money::Decenas($decenas);
        case 3: return "TRESCIENTOS " . Money::Decenas($decenas);
        case 4: return "CUATROCIENTOS " . Money::Decenas($decenas);
        case 5: return "QUINIENTOS " . Money::Decenas($decenas);
        case 6: return "SEISCIENTOS " . Money::Decenas($decenas);
        case 7: return "SETECIENTOS " . Money::Decenas($decenas);
        case 8: return "OCHOCIENTOS " . Money::Decenas($decenas);
        case 9: return "NOVECIENTOS " . Money::Decenas($decenas);
      }

      return Money::Decenas($decenas);
    }//Centenas()

    public static function Seccion($num, $divisor, $strSingular, $strPlural){
      $cientos = floor($num / $divisor);
      $resto = $num - ($cientos * $divisor);
      $letras = "";
    
      if ($cientos > 0){
            //dd($cientos);
        if ($cientos > 1)
          $letras = Money::Centenas($cientos) . " " . $strPlural;
        else
          $letras = (string)$strSingular;
      }
      if ($resto > 0){
        $letras .= "";
        
      }
        
      return $letras;
    }//Seccion()

    public static function Miles($num){
      $divisor = 1000;
      $cientos = floor($num / $divisor);
      $resto = $num - ($cientos * $divisor);
      //dd($num);
      $strMiles = Money::Seccion($num, $divisor, "UN MIL", "MIL");
      $strCentenas = Money::Centenas($resto);

      if($strMiles == "")
        return $strCentenas;

      return $strMiles . " " . $strCentenas;

      //return Seccion(num, divisor, "UN MIL", "MIL") + " " + Centenas(resto);
    }//Miles()

    public static function Millones($num){

      $divisor = 1000000;
      $cientos = floor($num / $divisor);
      $resto = $num - ($cientos * $divisor);

      $strMillones = Money::Seccion($num, $divisor, "UN MILLON", "MILLONES");

      $strMiles = Money::Miles($resto);

      if($strMillones == "")
        return $strMiles;

      return $strMillones . " " . $strMiles;

      //return Seccion(num, divisor, "UN MILLON", "MILLONES") . " " . Miles(resto);
    }//Millones()

    public static function NumeroALetras($num){
        $num = (float)$num;
        $data = [
        'numero'=> $num, 
        'enteros'=> floor($num),
        'centavos'=> (((round($num * 100)) - (floor($num) * 100))),
        'letrasCentavos'=> "",
        'letrasMonedaPlural'=> "SOLES",
        'letrasMonedaSingular'=> "SOL"
      ];
      
      $data['letrasCentavos'] = "Y " . $data['centavos'] . "/100";

      if($data['enteros'] == 0)
        return "CERO " . $data['letrasMonedaPlural'] . " " . $data['letrasCentavos'];
      if ($data['enteros'] == 1)
        return Money::Millones($data['enteros']) . " " . $data['letrasCentavos'] . " " . $data['letrasMonedaSingular'];
      else
        return Money::Millones($data['enteros']) . " " . $data['letrasCentavos'] . " " . $data['letrasMonedaPlural'];
    }//NumeroALetras()

}