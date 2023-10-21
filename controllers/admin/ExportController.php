<?php 

namespace app\controllers\admin;

use app\core\Application;
use app\core\Controller;
use app\core\Request;

use app\models\Artical;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class ExportController extends Controller {

    //=========Excel Setup==========
    public function excelHeader(){

    }
    public function excelFooter($file ,$name){
        $writer = new Xlsx($file);
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment;filename=\"$name.xlsx\"");
        header("Cache-Control: max-age=0");
        header("Expires: Fri, 11 Nov 2011 11:11:11 GMT");
        header("Last-Modified: ". gmdate("D, d M Y H:i:s") ." GMT");
        header("Cache-Control: cache, must-revalidate");
        header("Pragma: public");
        $writer->save("php://output");
        exit;
    }
    public function artical_excel(Request $request){
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();

        $activeWorksheet->setCellValue('A1', 'Id');
        $activeWorksheet->setCellValue('B1', 'Title');

        $articalModel=new Artical();
        $count = 2;
        foreach ($articalModel->get() as $v) {
            $spreadsheet->getSheet(0)->setCellValue("A" . $count, $v['id']);
            $spreadsheet->getSheet(0)->setCellValue("B" . $count, $v['title']);

            $count++;
        }
        $this->excelFooter($spreadsheet ,'myExcel'.time());
    }
}