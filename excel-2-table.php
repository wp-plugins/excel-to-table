<?php
/*
 Plugin Name: Excel to Table
 Plugin URI: N/A
 Description: Actualy this convert a Excel file (up to 2003) in a Html table;
 Version: 1.2
 Author: Miro Barsocchi
 Author URI: http://www.mirobarsa.com
 */
 
require_once 'excel_reader2.php';
error_reporting(E_ERROR | E_WARNING | E_PARSE);
define("DEFAULT_TEMP_FILE",'wp-content'.DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'excel-to-table'.DIRECTORY_SEPARATOR.'excel_file');


function TableDatas($file) {
	$data = new Spreadsheet_Excel_Reader($file);
	$html = $data->dump_clean(true,true);
	$html .= "<p>";
	$html .= $data->dump_clean(true,true,1);
	return $html;
}



function excel_2_table_modify() {
	if(isset($_POST['deletecheck'])) {
		$filesToDelete = $_POST['deletecheck'];
		foreach($filesToDelete as $filename) {
			$realNameFile ="..".DIRECTORY_SEPARATOR.DEFAULT_TEMP_FILE.DIRECTORY_SEPARATOR.$filename; 
			if(file_exists($realNameFile)){
				unlink($realNameFile);
			}
		}
	}
	for ($countFiles = 0; $countFiles < count ($_FILES['upload']['name']); $countFiles++) {
			if($_FILES['upload']['name'][$countFiles] != "") {
				$uploadFileName=$_FILES['upload']['name'][$countFiles];
				$uploadFileNameExtension =substr($uploadFileName,strlen($uploadFileName)-4,strlen($uploadFileName));
				if ($uploadFileNameExtension == ".xls"){
					$excelFileDirectory = "..".DIRECTORY_SEPARATOR.DEFAULT_TEMP_FILE.DIRECTORY_SEPARATOR.$uploadFileName;
					if (!move_uploaded_file ($_FILES['upload']['tmp_name'][$countFiles],$excelFileDirectory)) {
						echo "<p>".$uploadFileName.": Errore di caricamento";
					}
				}else {
					echo "<p>".$uploadFileName.": Formato non riconosciuto!<p>";
				}
			}
	}
	
?>
<div class="wrap">
<div id='icon-options-general' class='icon32'><br />
</div>

<h2>Excel Files</h2>
<br/>
<br/>
</div>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="LCK3HT6AQU56U">
<input type="image" src="https://www.paypalobjects.com/en_US/IT/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/it_IT/i/scr/pixel.gif" width="1" height="1"> Aiuta un piccolo sviluppatore a crescere! 
</form>
<p>
<p>

<form id="champ-settings" enctype="multipart/form-data" action="" method="post">
<table  class="widefat">
  			<thead>
  				<tr>
					<th scope="col" width="15%">Elimina</th>
					<th scope="col" >Nome file</th>
					<th scope="col" >Shortcode</th>
				</tr>
  			</thead>
  			<tbody>
			<?php 
			$excels = glob("..".DIRECTORY_SEPARATOR.DEFAULT_TEMP_FILE.DIRECTORY_SEPARATOR."*.xls");
			if ($excels) {
				$cont =0;
				foreach($excels as $excel) {
					$nameExcel = basename($excel , ".xls");
					$linkForDownload = plugins_url().'/excel-2-table/excel_file/'.$nameExcel.'.xls';
					$class = ('alternate' != $class) ? 'alternate' : ''; ?>
				    <tr>
						<th scope="row" class="check-column">
						<input type="checkbox" name="deletecheck[<?php echo $cont; ?>]" value="<?php echo $nameExcel.".xls";?>"/></th>
						<td><a href="<?php echo $linkForDownload;?>"><?php echo $nameExcel;?></a></td>
						<td>[excel_table fname="<?php echo urlencode($nameExcel);?>"]</a></td>
					</tr>
	 			<?php $cont ++;}?>
				
				<tr><td colspan="2">Per visualizzare i link a tutti i file inserire lo shortcode</td>
				<td> [excel_table]</td>
				</tr>
	 		<?php } else { ?>
				<tr id='no-id'><td scope="row" colspan="5"><em>Nessun file</em></td></tr>
			<?php 
			}
		?>
			
			
			</tbody>
		</table>
		aggiungi/aggiorna (puoi selezionare anche pi&ugrave; file) <input type="file" name="upload[]" multiple>
		<br>
<input type="submit" class="button-secondary action" id="doaction" name="doaction" value="Esegui"/>
</form>
<?php
}

function show_championship_submenu() {
	if(function_exists('add_submenu_page')) {
		add_object_page('excel-2-table','excel-2-table',0,'excel-2-table-mb','excel_2_table_modify');
	}
}

function show_championship_table($atts) {
	global $wp_query;
	$excels = glob(DEFAULT_TEMP_FILE.DIRECTORY_SEPARATOR."*.xls");
	if(isset($atts['fname'])) {
		$filename = urldecode($atts['fname']);
		$filename =DEFAULT_TEMP_FILE.DIRECTORY_SEPARATOR.$filename.".xls";
		if(file_exists($filename)){
			$output = TableDatas($filename);
		}
	}else if (!isset($wp_query->query_vars['girn'])) {
		foreach ($excels as $excel) {
			$link = basename($excel , ".xls");
			$result = get_permalink();
			$cont = urlencode($link);
			$params = array( 'girn' => $cont );
			$result = add_query_arg( $params, $result );
			$output .= "<a href=\"".$result ."\" >".$link."</a>
			<p>";
		}
	}else {
		$rawFileName =$wp_query->query_vars['girn'];
		$fileName = DEFAULT_TEMP_FILE.DIRECTORY_SEPARATOR.urldecode($rawFileName).".xls";
		$output = TableDatas($fileName);
	}
	return $output;
}

function parameter_queryvars_for_me( $qvars ){
	$qvars[] = 'girn';
	return $qvars;
}

add_filter('query_vars', 'parameter_queryvars_for_me' );
add_shortcode( 'excel_table','show_championship_table');
add_action('admin_menu','show_championship_submenu');
?>