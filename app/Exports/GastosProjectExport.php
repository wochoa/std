<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Carbon\Carbon;
use Money;
use phpDocumentor\Reflection\Types\Boolean;

class GastosProjectExport implements
    FromCollection,
    WithHeadings,
    WithColumnWidths,
    WithStyles,
    WithColumnFormatting
{
    /**
     * @return \Illuminate\Support\Collection
     */
    private $data;
    private $all;
    private $start_table;

    public function __construct(array $data,  $all = false)
    {
        $this->data = $data;
        $this->all = $all;
        $this->start_table = 2;
        $table = [];
        foreach ($data['presupuesto'] as $id1 => $d1) {
            if ($id1 != 't') {
                $lv1 = $id1;
                $d   = $d1['t'];
                $temp = [
                    $id1,
                    null,
                    null,
                    null,
                ];
                $table[] = array_merge($temp, $this->resumenPim($d));
                foreach ($d1 as $id2 => $d2) {
                    if ($id2 != 't') {
                        $d   = $d2['t'];
                        $lv2 = $lv1 . "-" . $id2;
                        $temp = [
                            null,
                            $d->desc1,
                            null,
                            null,
                        ];
                        $table[] = array_merge($temp, $this->resumenPim($d));
                        foreach ($d2 as $id3 => $d3) {
                            if ($id3 != 't') {
                                $lv3 = $lv2 . "-" . $id3;
                                $d   = $d3['t'];
                                $temp =  [
                                    null,
                                    null,
                                    $d->desc1,
                                    null,
                                ];
                                $table[] = array_merge($temp, $this->resumenPim($d));
                                foreach ($d3 as $id4 => $d4) {
                                    if ($id4 != 't') {
                                        $d = $d4['t'];
                                        $temp = [
                                            null,
                                            null,
                                            null,
                                            $d->desc1,
                                        ];
                                        $table[] = array_merge($temp, $this->resumenPim($d));
                                        if ($this->all) {
                                            foreach ($d4 as $id5 => $d5) {
                                                if ($id5 != 't') {
                                                    $d = $d5['t'];
                                                    $temp = [
                                                        null,
                                                        null,
                                                        null,
                                                        null,
                                                        "CERTIFICADO: " . $d->certificado . "\nMONTO: " . $d->monto_cert . "\nCONCEPTO: " . $d->concepto,
                                                        null,
                                                        null,
                                                    ];
                                                    $table[] = array_merge($temp, $this->resumenCertificado($d));
                                                    foreach ($d5 as $id6 => $d6) {
                                                        if ($id6 != 't') {
                                                            $d = $d6['t'];
                                                            $temp = [
                                                                null,
                                                                null,
                                                                null,
                                                                null,
                                                                null,
                                                                "COMPROMISO: " . $d->compromiso . "\nMONTO: " . $d->monto_comp . "\nCONCEPTO: " . $d->concepto,
                                                                null,
                                                            ];
                                                            $table[] = array_merge($temp, $this->resumenCompromiso($d));
                                                            foreach ($d6 as $id7 => $d7) {
                                                                if ($id7 != 't') {
                                                                    $d = $d7['t'];

                                                                    $table[] = [
                                                                        null,
                                                                        null,
                                                                        null,
                                                                        null,
                                                                        null,
                                                                        null,
                                                                        sprintf("Expediente SIAF: %s \nFecha: %s\nMonto: %s\nProveedor: %s \nCp's:  %s \n\nNotas del Devengado - %s", $d->expediente, $d->fecha, Money::toMoney($d->monto_dev), $d->proveedor, $d->cps, $d->nota_d),
                                                                    ];
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                $first = false;
            }
        }
        $this->data['presupuesto'] = collect($table);
    }
    public function resumenPim($d)
    {
        $temp = [];
        if ($this->all) {
            $temp =  [null, null, null];
        }
        return array_merge($temp, [
            $d->monto_pim,
            $d->monto_cert,
            $d->monto_pim - $d->monto_cert,
            $d->monto_cert / $d->monto_pim,
            $d->monto_comp,
            $d->monto_pim - $d->monto_comp,
            $d->monto_comp / $d->monto_pim,
            $d->monto_dev,
            $d->monto_pim - $d->monto_dev,
            $d->monto_dev / $d->monto_pim,
        ]);
    }
    public function resumenCertificado($d)
    {
        return [
            null,
            null,
            null,
            null,
            $d->monto_comp,
            ($d->monto_cert > 0) ? $d->monto_cert - $d->monto_comp : '',
            ($d->monto_cert > 0) ? $d->monto_comp / $d->monto_cert : '',
            $d->monto_dev,
            ($d->monto_cert > 0) ? $d->monto_cert - $d->monto_dev : '',
            ($d->monto_cert > 0) ? $d->monto_dev / $d->monto_cert : '',

        ];
    }
    public function resumenCompromiso($d)
    {
        return [
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            $d->monto_dev,
            ($d->monto_comp > 0) ? $d->monto_comp - $d->monto_dev : '',
            ($d->monto_comp > 0) ? $d->monto_dev / $d->monto_comp : '',

        ];
    }
    public function collection()
    {
        return $this->data['presupuesto'];
    }
    public function columnWidths(): array
    {
        if ($this->all)
            return ['A' => 10, 'B' => 10, 'C' => 10, 'D' => 55, 'E' => 15, 'F' => 15, 'G' => 15, 'H' => 15, 'I' => 15, 'J' => 15, 'K' => 15, 'L' => 15, 'M' => 15, 'N' => 15, 'O' => 15, 'P' => 15, 'Q' => 15];
        else
            return ['A' => 10, 'B' => 10, 'C' => 10, 'D' => 55, 'E' => 15, 'F' => 15, 'G' => 15, 'H' => 15, 'I' => 15, 'J' => 15, 'K' => 15, 'L' => 15, 'M' => 15, 'N' => 15,];
    }
    public function headings(): array
    {
        if ($this->all)
            return [
                [$this->data['proyecto']->proy_cod_siaf . ' - ' . $this->data['proyecto']->proy_nombre,],
                ['Año', 'Fto', 'Meta', 'Especifica', 'Cert.', 'Comp.', 'EXP_SIAF', 'PIM', 'CERTIFICADO', null, null, 'COMPROMISO', null, null, 'DEVENGADO',],
                [null, null, null, null, null, null, null, null, 'MONTO', 'SALDO', '%', 'MONTO', 'SALDO', '%', 'MONTO', 'SALDO', '%',]
            ];
        else
            return [
                [$this->data['proyecto']->proy_cod_siaf . ' - ' . $this->data['proyecto']->proy_nombre,],
                ['Año', 'Fto', 'Meta', 'Especifica', 'PIM', 'CERTIFICADO', null, null, 'COMPROMISO', null, null, 'DEVENGADO',],
                [null, null, null, null, null, 'MONTO', 'SALDO', '%', 'MONTO', 'SALDO', '%', 'MONTO', 'SALDO', '%',]
            ];
    }
    public function styles(Worksheet $sheet)
    {
        $row = $this->start_table + 1;
        foreach ($this->data['presupuesto'] as $id => $dato) {
            $row++;
            $style = $sheet->getStyle('A' . $row .':' . (($this->all) ? 'Q' : 'N') . $row);
            if ($dato[0] != null) {
                $style->getFill()->setFillType('solid')->getStartColor()->setARGB('a9a9a9');
            } else if ($dato[1] != null) {
                $style->getFill()->setFillType('solid')->getStartColor()->setARGB('c1c1c1');
            } else if ($dato[2] != null) {
                $style->getFill()->setFillType('solid')->getStartColor()->setARGB('d6d6d6');
            } else if ($dato[3] != null) {
                $style->getFill()->setFillType('solid')->getStartColor()->setARGB('e6e6e6');
            } else if ($dato[4] != null) {
                $style->getFill()->setFillType('solid')->getStartColor()->setARGB('efefef');
                $sheet
                    ->mergeCells('E' . $row . ':K' . $row);
            } else if ($dato[5] != null) {
                //$style->getFill()->setFillType('solid')->getStartColor()->setARGB('efefef');
                $sheet
                    ->mergeCells('F' . $row . ':N' . $row);
            } else if ($dato[6] != null) {
                //$style->getFill()->setFillType('solid')->getStartColor()->setARGB('efefef');
                $sheet
                    ->mergeCells('G' . $row . ':Q' . $row);
            }
        }
        $sheet
            ->setTitle('Reporte de Gastos')
            ->mergeCells('I' . $this->start_table . ':K' . $this->start_table)
            ->mergeCells('L' . $this->start_table . ':N' . $this->start_table)
            ->mergeCells('A' . $this->start_table . ':A' . ($this->start_table + 1))
            ->mergeCells('B' . $this->start_table . ':B' . ($this->start_table + 1))
            ->mergeCells('C' . $this->start_table . ':C' . ($this->start_table + 1))
            ->mergeCells('D' . $this->start_table . ':D' . ($this->start_table + 1))
            ->mergeCells('E' . $this->start_table . ':E' . ($this->start_table + 1))
            ->mergeCells('A' . ($this->start_table - 1) . ':N' . ($this->start_table - 1));
        if ($this->all) {
            $sheet
                ->mergeCells('O' . $this->start_table . ':Q' . $this->start_table)
                ->mergeCells('F' . $this->start_table . ':F' . ($this->start_table + 1))
                ->mergeCells('G' . $this->start_table . ':G' . ($this->start_table + 1))
                ->mergeCells('H' . $this->start_table . ':H' . ($this->start_table + 1));
        } else {
            $sheet
                ->mergeCells('F' . $this->start_table . ':H' . $this->start_table);
            }
            $style = $sheet->getStyle('A' . ($this->start_table - 1) . ':N' . ($this->start_table - 1));
            $style->getFont()->setSize(20);
            //$style->getFill()->setFillType('solid')->getStartColor()->setARGB('c1c1c1');

        $headStyle = $sheet->getStyle('A' . ($this->start_table) .':' . (($this->all) ? 'Q' : 'N') . ($this->start_table + 1));
        $headStyle->getFill()->setFillType('solid')->getStartColor()->setARGB('d9edf7');
        $headStyle->getAlignment()->setHorizontal('center')->setVertical('center');
        $tableStyle = $sheet->getStyle('A' . ($this->start_table) . ':'.(($this->all)?'Q':'N') . $row);
        $tableStyle->getBorders()->getAllBorders()->setBorderStyle('thin');
        //$t->getAlignment()->setHorizontal('center')->setVertical('setVertical');
        //CONFIGURANDO MARGENES DE PAGINA
        $margins = $sheet->getPageMargins()
            ->setTop(0.4)
            ->setRight(0.3)
            ->setLeft(0.3)
            ->setBottom(0.4);
        $sheet->setPageMargins($margins);

        $pageSetup = $sheet->getPageSetup()
            ->setOrientation('landscape')
            ->setRowsToRepeatAtTopByStartAndEnd($this->start_table, $this->start_table + 1)
            ->setPaperSize(8);
        $sheet->setPageSetup($pageSetup);

        //dd($sheet->getPageSetup()->getOrientation());
        $sheet->getHeaderFooter()->setOddHeader('&LGobierno Regional Huánuco&RGerencia Regional de Infraestructura');
        $sheet->getHeaderFooter()->setOddFooter('&L Reporte de Gastos de Proyecto de Inversion' . Carbon::now('America/Lima')->toW3cString() . ' &RPagina &P de &N');
    }
    public function columnFormats(): array
    {
        if ($this->all)
            return [
                'E' => '#,##0.00',
                'F' => '#,##0.00',
                'G' => '#,##0.00',
                'H' => '#,##0.00',
                'I' => '#,##0.00',
                'J' => '#,##0.00',
                'K' => '0.00%',
                'L' => '#,##0.00',
                'M' => '#,##0.00',
                'N' => '0.00%',
                'O' => '#,##0.00',
                'P' => '#,##0.00',
                'Q' => '0.00%',
            ];
        else
            return [
                'E' => '#,##0.00',
                'F' => '#,##0.00',
                'G' => '#,##0.00',
                'H' => '0.00%',
                'I' => '#,##0.00',
                'J' => '#,##0.00',
                'K' => '0.00%',
                'L' => '#,##0.00',
                'M' => '#,##0.00',
                'N' => '0.00%',
            ];
    }
}
