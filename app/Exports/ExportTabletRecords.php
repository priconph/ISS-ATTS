<?php

namespace App\Exports;
use App\Model\Tablet;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
Use \Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Illuminate\Support\Facades\DB;




class ExportTabletRecords implements  FromView, WithTitle, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;

    protected $date;
    protected $tablet_details_deployed;
    protected $tablet_details;
    protected $month;
    protected $year;


    //
    function __construct(
        $date,
        $tablet_details_deployed,
        $tablet_details,
        $month,
        $year

    )

    {
        $this->date = $date;
        $this->tablet_details_deployed = $tablet_details_deployed;
        $this->tablet_details = $tablet_details;
        $this->month = $month;
        $this->year = $year;

    }


        public function view(): View {

                return view('exports.export_tablet_details', ['date' => $this->date]);

        }

        public function title(): string
        {

            $month = $this->month;
            $year = $this->year;

            if($month == '01'){
                $buwan = 'January';
            }

            if($month == '02'){
                $buwan = 'February';
            }

            if($month == '03'){
                $buwan = 'March';
            }

            if($month == '04'){
                $buwan = 'April';
            }

            if($month == '05'){
                $buwan = 'May';
            }

            if($month == '06'){
                $buwan = 'June';
            }

            if($month == '07'){
                $buwan = 'July';
            }

            if($month == '08'){
                $buwan = 'August';
            }

            if($month == '09'){
                $buwan = 'September';
            }

            if($month == '10'){
                $buwan = 'October';
            }

            if($month == '11'){
                $buwan = 'November';
            }

            if($month == '12'){
                $buwan = 'December';
            }
            return ''.$buwan. ' ' .$year.'';
        }


        public function registerEvents(): array
        {

            $tablet_details_deployed = $this->tablet_details_deployed;
            $tablet_details = $this->tablet_details;
            $month = $this->month;
            $year = $this->year;

            $arial_font12_bold = array(
                'font' => array(
                    'name'      =>  'Arial',
                    'size'      =>  13,
                    'bold'      =>  true,
                    // 'color'      =>  'red',
                    // 'italic'      =>  true
                )
            );

            $arial_font16_bold = array(
                'font' => array(
                    'name'      =>  'Arial',
                    'size'      =>  16,
                    'bold'      =>  true,
                    // 'italic'      =>  true
                )
            );

            $arial_font12 = array(
                'font' => array(
                    'name'      =>  'Arial',
                    'size'      =>  12,
                    // 'bold'      =>  true,
                    // 'italic'      =>  true
                )
            );

            $hv_center = array(
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrap' => TRUE
                ]
            );

            $hlv_center = array(
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrap' => TRUE
                ]
            );

            $hrv_center = array(
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_RIGHT,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ]
            );
            $styleBorderBottomThin= [
                'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ];
            $styleBorderAll = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ];

            $hlv_top = array(
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'vertical' => Alignment::VERTICAL_TOP,
                    'wrap' => TRUE
                ]
            );

            $hcv_top = array(
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_TOP,
                    'wrap' => TRUE
                ]
            );


            return [
                AfterSheet::class => function(AfterSheet $event) use (
                    $arial_font12_bold,
                    $hv_center,
                    $hlv_center,
                    $hrv_center,
                    $styleBorderBottomThin,
                    $styleBorderAll,
                    $hlv_top,
                    $hcv_top,
                    $arial_font16_bold,
                    $arial_font12,
                    $tablet_details_deployed,
                    $tablet_details,
                    $month,
                    $year
                ) {

                    $event->sheet->getDelegate()->getRowDimension('2')->setRowHeight(40);
                    $event->sheet->getColumnDimension('A')->setWidth(5);
                    $event->sheet->getColumnDimension('B')->setWidth(15);
                    $event->sheet->getColumnDimension('C')->setWidth(20);
                    $event->sheet->getColumnDimension('D')->setWidth(60);
                    $event->sheet->getColumnDimension('E')->setWidth(12);
                    $event->sheet->getColumnDimension('F')->setWidth(35);
                    $event->sheet->getColumnDimension('G')->setWidth(20);
                    $event->sheet->getColumnDimension('H')->setWidth(30);
                    $event->sheet->getColumnDimension('I')->setWidth(20);
                    $event->sheet->getColumnDimension('J')->setWidth(20);
                    $event->sheet->getColumnDimension('K')->setWidth(60);
                    $event->sheet->getColumnDimension('L')->setWidth(60);


                    if($month == '01'){
                        $buwan = 'JANUARY';
                    }

                    if($month == '02'){
                        $buwan = 'FEBRUARY';
                    }

                    if($month == '03'){
                        $buwan = 'MARCH';
                    }

                    if($month == '04'){
                        $buwan = 'APRIL';
                    }

                    if($month == '05'){
                        $buwan = 'MAY';
                    }

                    if($month == '06'){
                        $buwan = 'JUNE';
                    }

                    if($month == '07'){
                        $buwan = 'JULY';
                    }

                    if($month == '08'){
                        $buwan = 'AUGUST';
                    }

                    if($month == '09'){
                        $buwan = 'SEPTEMBER';
                    }

                    if($month == '10'){
                        $buwan = 'OCTOBER';
                    }

                    if($month == '11'){
                        $buwan = 'NOVEMBER';
                    }

                    if($month == '12'){
                        $buwan = 'DECEMBER';
                    }


                    $event->sheet->getDelegate()->mergeCells('A1:L1');
                    $event->sheet->setCellValue('A1',"List of Company Owned Tablets as of ".$buwan." ".$year."");
                    $event->sheet->getDelegate()->getStyle('A1')->applyFromArray($hv_center);
                    $event->sheet->getDelegate()->getStyle('A1')->applyFromArray($arial_font16_bold);


                    $event->sheet->setCellValue('B2',"Asset Tag");
                    $event->sheet->getDelegate()->getStyle('B2')->applyFromArray($hv_center);
                    $event->sheet->getDelegate()->getStyle('B2')->applyFromArray($arial_font12_bold);

                    $event->sheet->setCellValue('C2',"Brand");
                    $event->sheet->getDelegate()->getStyle('C2')->applyFromArray($hv_center);
                    $event->sheet->getDelegate()->getStyle('C2')->applyFromArray($arial_font12_bold);

                    $event->sheet->setCellValue('D2',"Model");
                    $event->sheet->getDelegate()->getStyle('D2')->applyFromArray($hv_center);
                    $event->sheet->getDelegate()->getStyle('D2')->applyFromArray($arial_font12_bold);

                    $event->sheet->setCellValue('E2',"Capacity (In GB)");
                    $event->sheet->getDelegate()->getStyle('E2')->applyFromArray($hv_center);
                    $event->sheet->getDelegate()->getStyle('E2')->applyFromArray($arial_font12_bold);
                    $event->sheet->getDelegate()->getStyle('E2')->getAlignment()->setWrapText(true);

                    $event->sheet->setCellValue('F2',"Division/Department");
                    $event->sheet->getDelegate()->getStyle('F2')->applyFromArray($hv_center);
                    $event->sheet->getDelegate()->getStyle('F2')->applyFromArray($arial_font12_bold);
                    $event->sheet->getDelegate()->getStyle('F2')->getAlignment()->setWrapText(true);

                    $event->sheet->setCellValue('G2',"Section");
                    $event->sheet->getDelegate()->getStyle('G2')->applyFromArray($hv_center);
                    $event->sheet->getDelegate()->getStyle('G2')->applyFromArray($arial_font12_bold);
                    $event->sheet->getDelegate()->getStyle('G2')->getAlignment()->setWrapText(true);

                    $event->sheet->setCellValue('H2',"Assigned Users");
                    $event->sheet->getDelegate()->getStyle('H2')->applyFromArray($hv_center);
                    $event->sheet->getDelegate()->getStyle('H2')->applyFromArray($arial_font12_bold);
                    $event->sheet->getDelegate()->getStyle('H2')->getAlignment()->setWrapText(true);

                    $event->sheet->setCellValue('I2',"Disposition");
                    $event->sheet->getDelegate()->getStyle('I2')->applyFromArray($hv_center);
                    $event->sheet->getDelegate()->getStyle('I2')->applyFromArray($arial_font12_bold);
                    $event->sheet->getDelegate()->getStyle('I2')->getAlignment()->setWrapText(true);

                    $event->sheet->setCellValue('J2',"Date of Purchase");
                    $event->sheet->getDelegate()->getStyle('J2')->applyFromArray($hv_center);
                    $event->sheet->getDelegate()->getStyle('J2')->applyFromArray($arial_font12_bold);
                    $event->sheet->getDelegate()->getStyle('J2')->getAlignment()->setWrapText(true);

                    $event->sheet->setCellValue('K2',"Remarks 1");
                    $event->sheet->getDelegate()->getStyle('K2')->applyFromArray($hv_center);
                    $event->sheet->getDelegate()->getStyle('K2')->applyFromArray($arial_font12_bold);
                    $event->sheet->getDelegate()->getStyle('K2')->getAlignment()->setWrapText(true);

                    $event->sheet->setCellValue('L2',"Remarks 2");
                    $event->sheet->getDelegate()->getStyle('L2')->applyFromArray($hv_center);
                    $event->sheet->getDelegate()->getStyle('L2')->applyFromArray($arial_font12_bold);
                    $event->sheet->getDelegate()->getStyle('L2')->getAlignment()->setWrapText(true);

                    $start_col = 3;
                    $counter = 1;

                    for ($i=0; $i < count($tablet_details_deployed) ; $i++) {
                        if($tablet_details_deployed[$i]->updated_at != NULL){
                            $event->sheet->getDelegate()->getStyle('B'.$start_col.':L'.$start_col.'')
                            ->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setARGB('FFEA00');
                        }
                        $event->sheet->setCellValue('A'.$start_col,$counter);
                        $event->sheet->setCellValue('B'.$start_col,$tablet_details_deployed[$i]->asset_tag);
                        $event->sheet->setCellValue('C'.$start_col,$tablet_details_deployed[$i]->brand);
                        $event->sheet->setCellValue('D'.$start_col,$tablet_details_deployed[$i]->model);
                        $event->sheet->setCellValue('E'.$start_col,$tablet_details_deployed[$i]->capacity);
                        $event->sheet->setCellValue('F'.$start_col,$tablet_details_deployed[$i]->department);
                        $event->sheet->setCellValue('G'.$start_col,$tablet_details_deployed[$i]->section);
                        $event->sheet->setCellValue('H'.$start_col,$tablet_details_deployed[$i]->assigned_user);

                        if($tablet_details_deployed[$i]->disposition == 1){
                            $disposition = "Deployed";
                            $event->sheet->setCellValue('I'.$start_col,$disposition);
                        }

                        if($tablet_details_deployed[$i]->date_of_purchase == NULL){
                            $puchase_data = "-";
                            $event->sheet->setCellValue('J'.$start_col,$puchase_data);
                        }else{
                            $event->sheet->setCellValue('J'.$start_col,$tablet_details_deployed[$i]->date_of_purchase);
                        }

                        $event->sheet->setCellValue('K'.$start_col,$tablet_details_deployed[$i]->remarks_1);
                        $event->sheet->setCellValue('L'.$start_col,$tablet_details_deployed[$i]->remarks_2);

                        $start_col++;
                        $counter++;

                    }
                    $border_end = $start_col - 1;

                    $event->sheet->getDelegate()->getStyle('A2:L'.$border_end)->applyFromArray($styleBorderAll);
                    $event->sheet->getDelegate()->getStyle('A2:L'.$border_end)->getAlignment()->setWrapText(true);
                    $event->sheet->getDelegate()->getStyle('A2:L'.$border_end)->applyFromArray($hv_center);
                    $event->sheet->getDelegate()->getStyle('A2:L'.$border_end)->applyFromArray($arial_font12);



                    //NOT DEPLOYED

                    $disposition_start_col_title = $border_end + 3;
                    $disposition_start_col = $border_end + 4;
                    $disposition_start_col_data = $border_end + 5;


                    $event->sheet->setCellValue('A'.$disposition_start_col_title,"DECOMMISSIONED, FOR DISPOSAL/DISPOSED, AND DEFECTIVE UNITS");
                    $event->sheet->getDelegate()->getStyle('A'.$disposition_start_col_title)->applyFromArray($arial_font12_bold);

                    $event->sheet->setCellValue('B'.$disposition_start_col,"Asset Tag");
                    $event->sheet->getDelegate()->getStyle('B'.$disposition_start_col)->applyFromArray($hv_center);
                    $event->sheet->getDelegate()->getStyle('B'.$disposition_start_col)->applyFromArray($arial_font12_bold);

                    $event->sheet->setCellValue('C'.$disposition_start_col,"Brand");
                    $event->sheet->getDelegate()->getStyle('C'.$disposition_start_col)->applyFromArray($hv_center);
                    $event->sheet->getDelegate()->getStyle('C'.$disposition_start_col)->applyFromArray($arial_font12_bold);

                    $event->sheet->setCellValue('D'.$disposition_start_col,"Model");
                    $event->sheet->getDelegate()->getStyle('D'.$disposition_start_col)->applyFromArray($hv_center);
                    $event->sheet->getDelegate()->getStyle('D'.$disposition_start_col)->applyFromArray($arial_font12_bold);

                    $event->sheet->setCellValue('E'.$disposition_start_col,"Capacity (In GB)");
                    $event->sheet->getDelegate()->getStyle('E'.$disposition_start_col)->applyFromArray($hv_center);
                    $event->sheet->getDelegate()->getStyle('E'.$disposition_start_col)->applyFromArray($arial_font12_bold);
                    $event->sheet->getDelegate()->getStyle('E'.$disposition_start_col)->getAlignment()->setWrapText(true);

                    $event->sheet->setCellValue('F'.$disposition_start_col,"Division/Department");
                    $event->sheet->getDelegate()->getStyle('F'.$disposition_start_col)->applyFromArray($hv_center);
                    $event->sheet->getDelegate()->getStyle('F'.$disposition_start_col)->applyFromArray($arial_font12_bold);
                    $event->sheet->getDelegate()->getStyle('F'.$disposition_start_col)->getAlignment()->setWrapText(true);

                    $event->sheet->setCellValue('G'.$disposition_start_col,"Section");
                    $event->sheet->getDelegate()->getStyle('G'.$disposition_start_col)->applyFromArray($hv_center);
                    $event->sheet->getDelegate()->getStyle('G'.$disposition_start_col)->applyFromArray($arial_font12_bold);
                    $event->sheet->getDelegate()->getStyle('G'.$disposition_start_col)->getAlignment()->setWrapText(true);

                    $event->sheet->setCellValue('H'.$disposition_start_col,"Assigned Users");
                    $event->sheet->getDelegate()->getStyle('H'.$disposition_start_col)->applyFromArray($hv_center);
                    $event->sheet->getDelegate()->getStyle('H'.$disposition_start_col)->applyFromArray($arial_font12_bold);
                    $event->sheet->getDelegate()->getStyle('H'.$disposition_start_col)->getAlignment()->setWrapText(true);

                    $event->sheet->setCellValue('I'.$disposition_start_col,"Disposition");
                    $event->sheet->getDelegate()->getStyle('I'.$disposition_start_col)->applyFromArray($hv_center);
                    $event->sheet->getDelegate()->getStyle('I'.$disposition_start_col)->applyFromArray($arial_font12_bold);
                    $event->sheet->getDelegate()->getStyle('I'.$disposition_start_col)->getAlignment()->setWrapText(true);

                    $event->sheet->setCellValue('J'.$disposition_start_col,"Date of Purchase");
                    $event->sheet->getDelegate()->getStyle('J'.$disposition_start_col)->applyFromArray($hv_center);
                    $event->sheet->getDelegate()->getStyle('J'.$disposition_start_col)->applyFromArray($arial_font12_bold);
                    $event->sheet->getDelegate()->getStyle('J'.$disposition_start_col)->getAlignment()->setWrapText(true);

                    $event->sheet->setCellValue('K'.$disposition_start_col,"Remarks 1");
                    $event->sheet->getDelegate()->getStyle('K'.$disposition_start_col)->applyFromArray($hv_center);
                    $event->sheet->getDelegate()->getStyle('K'.$disposition_start_col)->applyFromArray($arial_font12_bold);
                    $event->sheet->getDelegate()->getStyle('K'.$disposition_start_col)->getAlignment()->setWrapText(true);

                    $event->sheet->setCellValue('L'.$disposition_start_col,"Remarks 2");
                    $event->sheet->getDelegate()->getStyle('L'.$disposition_start_col)->applyFromArray($hv_center);
                    $event->sheet->getDelegate()->getStyle('L'.$disposition_start_col)->applyFromArray($arial_font12_bold);
                    $event->sheet->getDelegate()->getStyle('L'.$disposition_start_col)->getAlignment()->setWrapText(true);

                    $count = 1;

                    for ($i=0; $i < count($tablet_details) ; $i++) {
                        $event->sheet->setCellValue('A'.$disposition_start_col_data,$count);
                        $event->sheet->setCellValue('B'.$disposition_start_col_data,$tablet_details[$i]->asset_tag);
                        $event->sheet->setCellValue('C'.$disposition_start_col_data,$tablet_details[$i]->brand);
                        $event->sheet->setCellValue('D'.$disposition_start_col_data,$tablet_details[$i]->model);
                        $event->sheet->setCellValue('E'.$disposition_start_col_data,$tablet_details[$i]->capacity);
                        $event->sheet->setCellValue('F'.$disposition_start_col_data,$tablet_details[$i]->department);
                        $event->sheet->setCellValue('G'.$disposition_start_col_data,$tablet_details[$i]->section);
                        $event->sheet->setCellValue('H'.$disposition_start_col_data,$tablet_details[$i]->assigned_user);


                        if($tablet_details[$i]->disposition == 2){
                            $disposition = "Disposed";
                            $event->sheet->getDelegate()->getStyle('B'.$disposition_start_col_data.':L'.$disposition_start_col_data.'')
                            ->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()
                            // ->setARGB('DD4B39');
                            ->setARGB('e09494');
                        }

                        if($tablet_details[$i]->disposition == 3){
                            $disposition = "For Disposal";
                        }

                        if($tablet_details[$i]->disposition == 4){
                            $disposition = "Decomissioned";
                            $event->sheet->getDelegate()->getStyle('B'.$disposition_start_col_data.':L'.$disposition_start_col_data.'')
                            ->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()
                            // ->setARGB('DD4B39');
                            ->setARGB('98ccdc');
                        }

                        if($tablet_details[$i]->disposition == 5){
                            $disposition = "Missing";
                        }

                        $event->sheet->setCellValue('I'.$disposition_start_col_data,$disposition);


                        if($tablet_details[$i]->date_of_purchase == NULL){
                            $puchase_data = "-";
                            $event->sheet->setCellValue('J'.$disposition_start_col_data,$puchase_data);
                        }else{
                            $event->sheet->setCellValue('J'.$disposition_start_col_data,$tablet_details[$i]->date_of_purchase);
                        }

                        $event->sheet->setCellValue('K'.$disposition_start_col_data,$tablet_details[$i]->remarks_1);
                        $event->sheet->setCellValue('L'.$disposition_start_col_data,$tablet_details[$i]->remarks_2);

                        $disposition_start_col_data++;
                        $count++;
                    }

                    $border_end_not_deployed = $disposition_start_col_data - 1;

                    $event->sheet->getDelegate()->getStyle('A'.$disposition_start_col.':L'.$border_end_not_deployed)->applyFromArray($styleBorderAll);
                    $event->sheet->getDelegate()->getStyle('A'.$disposition_start_col.':L'.$border_end_not_deployed)->getAlignment()->setWrapText(true);
                    $event->sheet->getDelegate()->getStyle('A'.$disposition_start_col.':L'.$border_end_not_deployed)->applyFromArray($hv_center);
                    $event->sheet->getDelegate()->getStyle('A'.$disposition_start_col.':L'.$border_end_not_deployed)->applyFromArray($arial_font12);


                    $color_coding_disposed = $border_end_not_deployed + 3;
                    $color_coding_decomissioned = $border_end_not_deployed + 4;

                            $event->sheet->getDelegate()->getStyle('B'.$color_coding_disposed)
                            ->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setARGB('e09494');
                            $event->sheet->setCellValue('C'.$color_coding_disposed,'Disposed');
                            $event->sheet->getDelegate()->mergeCells('C'.$color_coding_disposed.':F'.$color_coding_disposed.'');
                            $event->sheet->getDelegate()->getStyle('B'.$color_coding_disposed.':F'.$color_coding_disposed)->applyFromArray($styleBorderAll);


                            $event->sheet->getDelegate()->getStyle('B'.$color_coding_decomissioned)
                            ->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setARGB('98ccdc');
                            $event->sheet->setCellValue('C'.$color_coding_decomissioned,'Decomissioned');
                            $event->sheet->getDelegate()->mergeCells('C'.$color_coding_decomissioned.':F'.$color_coding_decomissioned.'');
                            $event->sheet->getDelegate()->getStyle('B'.$color_coding_decomissioned.':F'.$color_coding_decomissioned)->applyFromArray($styleBorderAll);

                },
            ];
        }

    }


