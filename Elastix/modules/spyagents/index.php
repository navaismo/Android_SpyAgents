<?php
  /* vim: set expandtab tabstop=4 softtabstop=4 shiftwidth=4:
  Codificación: UTF-8
  +----------------------------------------------------------------------+
  | Elastix version 2.4.0-9                                               |
  | http://www.elastix.org                                               |
  +----------------------------------------------------------------------+
  | Copyright (c) 2006 Palosanto Solutions S. A.                         |
  +----------------------------------------------------------------------+
  | Cdla. Nueva Kennedy Calle E 222 y 9na. Este                          |
  | Telfs. 2283-268, 2294-440, 2284-356                                  |
  | Guayaquil - Ecuador                                                  |
  | http://www.palosanto.com                                             |
  +----------------------------------------------------------------------+
  | The contents of this file are subject to the General Public License  |
  | (GPL) Version 2 (the "License"); you may not use this file except in |
  | compliance with the License. You may obtain a copy of the License at |
  | http://www.opensource.org/licenses/gpl-license.php                   |
  |                                                                      |
  | Software distributed under the License is distributed on an "AS IS"  |
  | basis, WITHOUT WARRANTY OF ANY KIND, either express or implied. See  |
  | the License for the specific language governing rights and           |
  | limitations under the License.                                       |
  +----------------------------------------------------------------------+
  | The Original Code is: Elastix Open Source.                           |
  | The Initial Developer of the Original Code is PaloSanto Solutions    |
  +----------------------------------------------------------------------+
  $Id: index.php,v 1.1 2013-09-30 01:09:36 navaismo info@digital-merge.com Exp $ */
//include elastix framework
include_once "libs/paloSantoGrid.class.php";
include_once "libs/paloSantoForm.class.php";

function _moduleContent(&$smarty, $module_name)
{
    //include module files
    include_once "modules/$module_name/configs/default.conf.php";
    include_once "modules/$module_name/libs/paloSantoSpyAgents.class.php";
    include_once "modules/$module_name/libs/paloSantogridtest.class.php";

    //include file language agree to elastix configuration
    //if file language not exists, then include language by default (en)
    $lang=get_language();
    $base_dir=dirname($_SERVER['SCRIPT_FILENAME']);
    $lang_file="modules/$module_name/lang/$lang.lang";
    if (file_exists("$base_dir/$lang_file")) include_once "$lang_file";
    else include_once "modules/$module_name/lang/en.lang";

    //global variables
    global $arrConf;
    global $arrConfModule;
    global $arrLang;
    global $arrLangModule;
    $arrConf = array_merge($arrConf,$arrConfModule);
    $arrLang = array_merge($arrLang,$arrLangModule);

    //folder path for custom templates
    $templates_dir=(isset($arrConf['templates_dir']))?$arrConf['templates_dir']:'themes';
    $local_templates_dir="$base_dir/modules/$module_name/".$templates_dir.'/'.$arrConf['theme'];

    //conexion resource
    $pDB = new paloDB($arrConf['dsn_conn_database']);
    //$pDB = new paloDB();


    //actions
    $action = getAction();
    //echo $action;
    $content = "";

    switch($action){
        case "save_new":
            $content = saveNewSpyAgents($smarty, $module_name, $local_templates_dir, $pDB, $arrConf);
            break;
	case "delid":
	   $content = deleteID($smarty, $module_name, $local_templates_dir, $pDB, $arrConf);	   
	   break;
	case "selid":
	   $content = getIDCDR($smarty, $module_name, $local_templates_dir, $pDB, $arrConf);	   
	   break;
        default: // view_form
            $content = viewFormSpyAgents($smarty, $module_name, $local_templates_dir, $pDB, $arrConf);
            break;
    }
    return $content;
}


function getIDCDR($smarty, $module_name, $local_templates_dir, $pDB, $arrConf){
    $pSpyAgents = new paloSantoSpyAgents($pDB);
    $cdrid = getParameter("selid");

    $pgridtest = new paloSantogridtest($pDB);

    //begin grid parameters
    $oGrid  = new paloSantoGrid($smarty);
    $oGrid->pagingShow(true); // show paging section.

    $arrColumns = array(_tr("Date"),_tr("Name"),_tr("FixedID"),_tr("SpyedChan"),_tr("FromExt"),);
    $oGrid->setColumns($arrColumns);

    $total   = $pgridtest->getNumgridtest($filter_field, $filter_value);
        $arrData = null;
    if($oGrid->isExportAction()){
        $limit  = $total; // max number of rows.
        $offset = 0;	  // since the start.
    }
    else{
	$limit  = 20;
        $oGrid->setLimit($limit);
        $oGrid->setTotal($total);
        $offset = $oGrid->calculateOffset();
    }

   $sql = "SELECT * FROM Spy_ID_CDR WHERE id=?";
   $arrParam = array($cdrid);
   $arrResult = $pDB->fetchTable($sql,TRUE,$arrParam);

    if(is_array($arrResult)){ // && $total>0){
        foreach($arrResult as $key => $value){
            $arrTmp[0] = $value['date'];
            $arrTmp[1] = $value['name'];
            $arrTmp[2] = $value['id'];
            $arrTmp[3] = $value['spiedchan'];
            $arrTmp[4] = $value['fromext'];
            $arrData[] = $arrTmp;
        }
    }


    $oGrid->setData($arrData);

    $content .= viewFormSpyAgents($smarty, $module_name, $local_templates_dir, $pDB, $arrConf);
    $content .= "<br><p>Spyed Chans by <b>$cdrid</b></p>";
    $content .= $oGrid->fetchGrid();

    return $content;
}

function deleteID($smarty, $module_name, $local_templates_dir, $pDB, $arrConf)
{
    $pSpyAgents = new paloSantoSpyAgents($pDB);
    $idtodel = getParameter("delid");

	$sql = "DELETE FROM Spy_ID WHERE id=?";
        $arrParam = array($idtodel);
        $result = $pDB->genQuery($sql,$arrParam);
	echo $result;
        if($result == FALSE){
		$smarty->assign("mb_message","There was an error ".$pDB->errMsg);
        }else{
		$smarty->assign("mb_message","<br>The ID: <b>".$idtodel."</b> has been deleted<br>");
        }

    $content .= viewFormSpyAgents($smarty, $module_name, $local_templates_dir, $pDB, $arrConf);
    return $content;
}

function viewFormSpyAgents($smarty, $module_name, $local_templates_dir, &$pDB, $arrConf)
{
    $pSpyAgents = new paloSantoSpyAgents($pDB);
    $arrFormSpyAgents = createFieldForm();
    $oForm = new paloForm($smarty,$arrFormSpyAgents);

    //begin, Form data persistence to errors and other events.
    $_DATA  = $_POST;
    $action = getParameter("action");
    $id     = getParameter("id");
    $smarty->assign("ID", $id); //persistence id with input hidden in tpl

    if($action=="view")
        $oForm->setViewMode();
    else if($action=="view_edit" || getParameter("save_edit"))
        $oForm->setEditMode();
    //end, Form data persistence to errors and other events.

    if($action=="view" || $action=="view_edit"){ // the action is to view or view_edit.
        $dataSpyAgents = $pSpyAgents->getSpyAgentsById($id);
        if(is_array($dataSpyAgents) & count($dataSpyAgents)>0)
            $_DATA = $dataSpyAgents;
        else{
            $smarty->assign("mb_title", _tr("Error get Data"));
            $smarty->assign("mb_message", $pSpyAgents->errMsg);
        }
    }

    $smarty->assign("SAVE", _tr("Save"));
    $smarty->assign("EDIT", _tr("Edit"));
    $smarty->assign("CANCEL", _tr("Cancel"));
    $smarty->assign("REQUIRED_FIELD", _tr("Required field"));
    $smarty->assign("icon", "images/list.png");

    $htmlForm = $oForm->fetchForm("$local_templates_dir/form.tpl",_tr("SpyAgents"), $_DATA);
    $content = "<form  method='POST' style='margin-bottom:0;' action='?menu=$module_name'>".$htmlForm."</form>";

    $pgridtest = new paloSantogridtest($pDB);
    $filter_field = getParameter("filter_field");
    $filter_value = getParameter("filter_value");

    //begin grid parameters
    $oGrid  = new paloSantoGrid($smarty);
    $oGrid->pagingShow(true); // show paging section.

    $arrColumns = array(_tr("Name"),_tr("FixedID"),_tr("Delete"),);
    $oGrid->setColumns($arrColumns);

    $total   = $pgridtest->getNumgridtest($filter_field, $filter_value);
        $arrData = null;
    if($oGrid->isExportAction()){
        $limit  = $total; // max number of rows.
        $offset = 0;	  // since the start.
    }
    else{
	$limit  = 20;
        $oGrid->setLimit($limit);
        $oGrid->setTotal($total);
        $offset = $oGrid->calculateOffset();
    }

    $query = "SELECT * from Spy_ID";

    $arrResult = $pDB->fetchTable($query,TRUE,$arrParam = NULL);

    if(is_array($arrResult)){ // && $total>0){
        foreach($arrResult as $key => $value){
            $arrTmp[0] = $value['name'];
            $arrTmp[1] = $value['id'];
            $arrTmp[2] = "<a href='?menu=$module_name&delid=".$value['id']."' >Delete ID: ".$value['id']."</a>";
            $arrData[] = $arrTmp;
        }
    }


    $oGrid->setData($arrData);
    $content .= $oGrid->fetchGrid();


	$content .= "<br><br><h3> Report per ID</h3><hr>";
	$content .= "<form id='f3' method='post' action='?menu=$module_name'><select name='selid' id='selid' onchange='this.form.submit()'><option value='-'> -- -- </option>";

	$query2 = "SELECT * from Spy_ID";
	$arrResult = $pDB->fetchTable($query2,TRUE,$arrParam = NULL);
	if(is_array($arrResult)){ // && $total>0){
        	foreach($arrResult as $key => $value){
            		$content .= "<option value='".$value['id']."'>".$value['name']." - ".$value['id']."</option>";
		}
	}

	$content .= "</select></form>";
    return $content;
}

function saveNewSpyAgents($smarty, $module_name, $local_templates_dir, &$pDB, $arrConf)
{
    $pSpyAgents = new paloSantoSpyAgents($pDB);
    $arrFormSpyAgents = createFieldForm();
    $oForm = new paloForm($smarty,$arrFormSpyAgents);

    if(!$oForm->validateForm($_POST)){
        // Validation basic, not empty and VALIDATION_TYPE 
        $smarty->assign("mb_title", _tr("Validation Error"));
        $arrErrores = $oForm->arrErroresValidacion;
        $strErrorMsg = "<b>"._tr("The following fields contain errors").":</b><br/>";
        if(is_array($arrErrores) && count($arrErrores) > 0){
            foreach($arrErrores as $k=>$v)
                $strErrorMsg .= "$k, ";
        }
        $smarty->assign("mb_message", $strErrorMsg);
        $content = viewFormSpyAgents($smarty, $module_name, $local_templates_dir, $pDB, $arrConf);
    }
    else{
        //NO ERROR, HERE IMPLEMENTATION OF SAVE
	$name = getParameter("name");
	$idx = getParameter("idx");
	$sql = "INSERT INTO Spy_ID(name,id) VALUES(?,?)";
	$arrParam = array( $name, $idx );
	$result = $pDB->genQuery($sql,$arrParam);

        if($result == FALSE){
		$smarty->assign("mb_message", "There was an error".$pDB->errMsg);
	}else{
		$smarty->assign("mb_message", "<b>ID added successfully!</b>");

	}
    }
    return $content;
}

function createFieldForm()
{
    $arrOptions = array('val1' => 'Value 1', 'val2' => 'Value 2', 'val3' => 'Value 3');

    $arrFields = array(
            "name"   => array(      "LABEL"                  => _tr("Name"),
                                            "REQUIRED"               => "yes",
                                            "INPUT_TYPE"             => "TEXT",
                                            "INPUT_EXTRA_PARAM"      => "",
                                            "VALIDATION_TYPE"        => "text",
                                            "VALIDATION_EXTRA_PARAM" => ""
                                            ),
            "idx"   => array(      "LABEL"                  => _tr("ID"),
                                            "REQUIRED"               => "yes",
                                            "INPUT_TYPE"             => "TEXT",
                                            "INPUT_EXTRA_PARAM"      => "",
                                            "VALIDATION_TYPE"        => "text",
                                            "VALIDATION_EXTRA_PARAM" => ""
                                            ),

            );
    return $arrFields;
}


function createFieldFilter(){
    $arrFilter = array(
            "name" => _tr("Name"),
            "fixedid" => _tr("FixedID"),
            "delete" => _tr("Delete"),
                    );

    $arrFormElements = array(
            "filter_field" => array("LABEL"                  => _tr("Search"),
                                    "REQUIRED"               => "no",
                                    "INPUT_TYPE"             => "SELECT",
                                    "INPUT_EXTRA_PARAM"      => $arrFilter,
                                    "VALIDATION_TYPE"        => "text",
                                    "VALIDATION_EXTRA_PARAM" => ""),
            "filter_value" => array("LABEL"                  => "",
                                    "REQUIRED"               => "no",
                                    "INPUT_TYPE"             => "TEXT",
                                    "INPUT_EXTRA_PARAM"      => "",
                                    "VALIDATION_TYPE"        => "text",
                                    "VALIDATION_EXTRA_PARAM" => ""),
                    );
    return $arrFormElements;
}





function getAction()
{
    if(getParameter("save_new")) //Get parameter by POST (submit)
        return "save_new";
    else if(getParameter("save_edit"))
        return "save_edit";
    else if(getParameter("delete")) 
        return "delete";
    else if(getParameter("new_open")) 
        return "view_form";
    else if(getParameter("action")=="view")      //Get parameter by GET (command pattern, links)
        return "view_form";
    else if(getParameter("action")=="view_edit")
        return "view_form";
    else if(getParameter("delid"))
        return "delid";
    else if(getParameter("selid"))
        return "selid";
    else
        return "report"; //cancel
}



?>
