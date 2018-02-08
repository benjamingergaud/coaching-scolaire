<?php

class AdminController
{

    function httpGetMethod($get)
    {
        $forms = [];
        if (array_key_exists('action', $get)) {

            switch ($get['action']) {


                case "delete":
                    $formModel = new Contact_FormModel();
                    $formModel->deleteById(intval($get['id']));

                    header('Location: index.php?page=Admin');
                    break;
	            case "archive":
		            $formModel = new Contact_FormModel();
		            $formModel->archiveForm(intval($get["id"]));
		            header('Location: index.php?page=Admin');
		            break;
	            case "unarchive":
		            $formModel = new Contact_FormModel();
		            $formModel->unArchiveForm(intval($get["id"]));
		            header('Location: index.php?page=Admin');
		            break;
	            case "download";
		            $formModel = new Contact_FormModel();
		            $form = $formModel->getFormById(intval($get["id"]));
					$fpdf= new tFPDF();
					$fpdf->AddPage();
		            $fpdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
		            $fpdf->SetFont('DejaVu','',18);
		            $fpdf->Cell(0, 10,"Client : ". iconv('UTF-8', 'windows-1252',$form['name']),0,1);
		            $fpdf->Cell(0, 10,"Âge : " .iconv('UTF-8', 'windows-1252',$form['âge']),0,1);
		            $fpdf->Cell(0, 10,"Contact : " .iconv('UTF-8', 'windows-1252',$form['contact']),0,1);
		            $fpdf->Cell(0, 10,"Mail : " .iconv('UTF-8', 'windows-1252',$form['mail']),0,1);
		            $fpdf->Cell(0, 10,"Téléphone : " .iconv('UTF-8', 'windows-1252',$form['number']),0,1);
		            $fpdf->Cell(0, 10,"Ecole: " .iconv('UTF-8', 'windows-1252',$form['school']),0,1);
		            $fpdf->Cell(0, 10,"Niveau d'études : " .iconv('UTF-8', 'windows-1252',$form['niveau_etude']),0,1);
		            $fpdf->MultiCell(0, 10,"Options : " .iconv('UTF-8', 'windows-1252',$form['options']),0,1);
		            $fpdf->MultiCell(0, 10,"Resultats : " .iconv('UTF-8', 'windows-1252',$form['results']),0,1);
		            $fpdf->MultiCell(0, 10,"Motivations : " .iconv('UTF-8', 'windows-1252',$form['motivation']),0,1);
		            $fpdf->MultiCell(0, 10,"Attentes : " .iconv('UTF-8', 'windows-1252',$form['attentes']),0,1);
		            $fpdf->MultiCell(0, 10,"Date : " .iconv('UTF-8', 'windows-1252',$form['post_date']),0,1);
		            $fpdf->Output();
	                break;
            }
        } else {
            $formModel = new Contact_FormModel();
            $forms= $formModel->getForms();  //getArticles
        }
        return [
            'forms' => $forms,
        ];
    }

    function httpPostMethod(array $post)
    {
        return [
            '_form' => "",
        ];
    }
}

