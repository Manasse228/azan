<?php
include_once 'mvc/controleur/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$file_name= "fields_generer.php";
$base_name = "calen738121";

$pdo = Connection::getConnexion();

function get_tab_field($db_base, $param=""){
    global $pdo;
    $tab = array();
    if($param){
        $requete = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE Table_Type='BASE TABLE' AND TABLE_SCHEMA = :info_db ";
    }else{
        $requete = "SELECT COLUMN_TYPE,DATA_TYPE,COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE Table_Name = :info_db ";
    }

    $req = $pdo->prepare($requete);
    $req->bindValue(':info_db', trim($db_base), PDO::PARAM_STR);
    $req->execute();
    $data = $req->fetchAll(PDO::FETCH_ASSOC);

    if(!$param){
        foreach ($data as  $value) {
            $tab[] = $value;
        }
        return $tab;
    }

    foreach ($data as $key => $value) {
        $tab[] = $value['TABLE_NAME'];
    }
    return $tab;
}

$tables = get_tab_field($base_name, "base");
$file = fopen($file_name, 'w+');

$str = "<?php \n";
foreach ($tables as $table){

    /* Table */
    $str .= "/* \n";
    $str .= "* ******* Table ".$table." ******* \n";
    $str .= "*/ \n";

    $str .= "\n";

    $fields = get_tab_field($table);
    foreach ($fields as $key => $field){

       // $str .= '$param['.$table.'][nom] = "'.$field['COLUMN_NAME'].'"; '."\n";
        $str .= '$param['.$table.']['.$field['COLUMN_NAME'].'][type] = "'.$field['DATA_TYPE'].'"; '."\n";
        if(check_parenthese($field['COLUMN_TYPE'])){
            $field['COLUMN_TYPE'] = get_inside_bracket($field['COLUMN_TYPE']);
            $str .= '$param['.$table.']['.$field['COLUMN_NAME'].'][length] = "'.$field['COLUMN_TYPE'].'"; '."\n";
        }
        $str .= "\n";

    }

    $str .= "\n";

}
$str .= "?>";

fwrite($file,$str);

function check_parenthese($text){
    $j=0;
    $taille = strlen($text);
    for ($i=0;$i<$taille;$i++){
        if($text[$i] == "("  ){
            $j++;
        }
        if($text[$i] == ")"  ){
            $j++;
        }
    }
    return ($j >=2) ? true : false;
}

/*
 * Get value inside bracket
 */
function get_inside_bracket($str){
    $openstrpos  = strpos($str,"(" );
    $closestrpos = strpos($str,")");
    return substr($str, $openstrpos+1, $closestrpos-$openstrpos-1);
}






?>