<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 11/12/2017
 * Time: 14:27
 */



class Contact_FormModel {

    function updateForm($name, $age, $contact, $mail, $number, $school, $niveau_etude, $options, $results, $motivation, $attentes, $id) {

        $db = new Database();

        return $db->executeSql("UPDATE forms
                    SET  mail=?,attentes=?,contact=?,motivation=?,name=?,number=?,niveau_etude=?,âge=?,school=?,options=?,results =?
                    WHERE id=?", [ $mail,$attentes,$contact,$motivation,$name,$number,$niveau_etude,$age,$school,$options,$results,$id ]);
    }
    function archiveForm($id){
	    $db = new Database();
	    return $db->executeSql("UPDATE forms SET status=1 WHERE id=?" , [$id]);
    }
    function unArchiveForm($id){
	    $db = new Database();
	    return $db->executeSql("UPDATE forms SET status=0 WHERE id=?" , [$id]);
    }
	function addForm($name,$age,$contact,$mail,$number,$school,$niveau_etude,$options,$results,$motivation,$attentes){
    	$db = new Database();
    	return $db->executeSql("INSERT INTO forms ( name, âge, contact, mail, number, school, niveau_etude, options, results, motivation, attentes, post_date)VALUES (?,?,?,?,?,?,?,?,?,?,?,NOW())" ,  [$name,$age,$contact,$mail,$number,$school,$niveau_etude,$options,$results,$motivation,$attentes]);
	}
    function deleteByID($id) {

        $db = new Database();

        $sql = "DELETE FROM forms WHERE id = ?";

        return $db->executeSql($sql, [$id]);
    }

    function getForms(){

        $db = new Database();

        $sql = "SELECT id, post_date, mail,attentes,contact,motivation,name,number,niveau_etude,âge,school,options,results,status 
                FROM forms
                
                ORDER BY status , post_date DESC";

        return $db->fetchAll($sql);
    }



    function getFormById($id) {

        $db = new Database();

        $sql = "SELECT post_date, mail,attentes,contact,motivation,name,number,niveau_etude,âge,school,options,results ,status
                FROM forms 
                WHERE id=?";

        return $db->queryOne($sql, [$id]);

    }
}