
<?php
session_start();

	require '../Inclu/Admin_Inclu_01b.php';

		require '../Conections/conection.php';

	$db = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
	if (!$db){ die ("Es imposible conectar con la bbdd ".$db_name."</br>".mysqli_connect_error());
				}

$sqld =  "SELECT * FROM `admin` WHERE `Email` = '$_POST[Email]' OR `Usuario` = '$_POST[Usuario]'";
 	
	$qd = mysqli_query($db, $sqld);
	
	$rowd = mysqli_fetch_assoc($qd);

///////////////////////////////////////////////////////////////////////////////////////

if ($_SESSION['Nivel'] == 'admin'){

 					print("Hello ".$_SESSION['Nombre']." ".$_SESSION['Apellidos'].".");
				
					master_index();

							if ($_POST['oculto2']){
								show_form();
								accion_Feedback_Admin_01();
								}
							elseif($_POST['modifica']){
								
									if($form_errors = validate_form()){
										show_form($form_errors);
											} else {
												process_form();
												accion_Feedback_Admin_Recuperar_02();
												}
								
								} else {
											show_form();
									}

				} else { 
					
						print("<table align='center' style=\"margin-top:200px;margin-bottom:200px\">
									<tr align='center'>
										<td>
											<font color='red'>
												<b>
													ACCESO RESTRINGIDO.
												</br></br>
													CONSULTE SUS PERMISOS ADMINISTRATIVOS.
											</font>
										</td>
									</tr>
								</table>");
								
							}

//////////////////////////////////////////////////////////////////////////////////////////////

function validate_form(){
	
	global $sqld;
	global $qd;
	global $rowd;
	
		require '../Inclu/validate.php';	
		
			return $errors;

		}

//////////////////////////////////////////////////////////////////////////////////////////////

function process_form(){
	
	global $db;
	
/*	REFERENCIA DE USUARIO	*/

if (preg_match('/^(\w{1})/',$_POST['Nombre'],$ref1)){	$rf1 = $ref1[1];
														$rf1 = trim($rf1);
														/*print($ref1[1]."</br>");*/
																		}
if (preg_match('/^(\w{1})*(\s\w{1})/',$_POST['Nombre'],$ref2)){	$rf2 = $ref2[2];
																$rf2 = trim($rf2);
																/*print($ref2[2]."</br>");*/
																						}
if (preg_match('/^(\w{1})/',$_POST['Apellidos'],$ref3)){	$rf3 = $ref3[1];
															$rf3 = trim($rf3);
															/*print($ref3[1]."</br>");*/
																		}
if (preg_match('/^(\w{1})*(\s\w{1})/',$_POST['Apellidos'],$ref4)){	$rf4 = $ref4[2];
																	$rf4 = trim($rf4);
																	/*print($ref4[2]."</br>");*/
																						}

global $rf;
$rf = $rf1.$rf2.$rf3.$rf4.$_POST['dni'].$_POST['ldni'];
$rf = trim($rf);

/**************************************/

	$tabla = "<table align='center' style=\"margin-top:20px\">
				<tr>
					<th colspan=3  class='BorderInf'>
						Datos del Admin Recuperado
					</th>
				</tr>
				
				<tr>
					<td width=200px>
						Nombre:
					</td>
					<td width=200px>"
						.$_POST['Nombre'].
					"</td>
					<td rowspan='4' align='center' width='100px'>
						<img src='img_admin/".$_POST['myimg']."' height='120px' width='90px' />
					</td>
				</tr>
				
				<tr>
					<td>
						Apellidos:
					</td>
					<td>"
						.$_POST['Apellidos'].
					"</td>
				</tr>				
				
				<tr>
					<td>
						Tipo Documento:
					</td>
					<td>"
						.$_POST['doc'].
					"</td>
				</tr>				
				
				<tr>
					<td>
						N&uacute;mero:
					</td>
					<td>"
						.$_POST['dni'].
					"</td>
				</tr>				
				
				<tr>
					<td>
						Control:
					</td>
					<td colspan=2>"
						.$_POST['ldni'].
					"</td>
				</tr>				
				
				<tr>
					<td>
						Mail:
					</td>
					<td colspan=2>"
						.$_POST['Email'].
					"</td>
				</tr>
				
				<tr>
					<td>
						Tipo User
					</td>
					<td colspan=2>"
						.$_POST['Nivel'].
					"</td>
				</tr>
				
				<tr>
					<td>
						Referencia Usuario
					</td>
					<td colspan='2'>"
						.$rf.
					"</td>
				</tr>
				
				<tr>
					<td>
						User:
					</td>
					<td colspan=2>"
						.$_POST['Usuario'].
					"</td>
				</tr>
				
				<tr>
					<td>
						Password:
					</td>
					<td colspan=2>"
						.$_POST['Password'].
					"</td>
				</tr>
				
				
				<tr>
				
					<td>
						Dirección:
					</td>
					<td colspan=2>"
						.$_POST['Direccion'].
					"</td>
				</tr>
				
				<tr>
					<td>
						Teléfono 1:
					</td>
					<td colspan=2>"
						.$_POST['Tlf1'].
					"</td>
				</tr>
				
				<tr>
					<td>
						Teléfono 2:
					</td>
					<td colspan=2>"
						.$_POST['Tlf2'].
					"</td>
				</tr>

				<tr>
					<td>
						Last In:
					</td>
					<td colspan=2>"
						.$_POST['lastin'].
					"</td>
				</tr>
				
				<tr>
					<td>
						Last Out:
					</td>
					<td colspan=2>"
						.$_POST['lastout'].
					"</td>
				</tr>
				
				<tr>
					<td>
						Vista Admin:
					</td>
					<td colspan=2>"
						.$_POST['visitadmin'].
					"</td>
				</tr>
								
			</table>	
		";	
		
	global $db_name;

	global $nombre;
	global $apellido;
	
	$nombre = $_POST['Nombre'];
	$apellido = $_POST['Apellidos'];
	
	$sqlc = "INSERT INTO `$db_name`.`admin` SET `ref` = '$rf', `Nivel` = '$_POST[Nivel]', `Nombre` = '$_POST[Nombre]', `Apellidos` = '$_POST[Apellidos]', `myimg` = '$_POST[myimg]', `doc` = '$_POST[doc]', `dni` = '$_POST[dni]', `ldni` = '$_POST[ldni]', `Email` = '$_POST[Email]', `Usuario` = '$_POST[Usuario]', `Password` = '$_POST[Password]', `Direccion` = '$_POST[Direccion]', `Tlf1` = '$_POST[Tlf1]', `Tlf2` = '$_POST[Tlf2]', `lastin` = '$_POST[lastin]', `lastout` = '$_POST[lastout]', `visitadmin` = '$_POST[visitadmin]' ";

	if(mysqli_query($db, $sqlc)){
							print( $tabla );
				} else {
				print("<font color='#FF0000'>
						* ESTOS DATOS NO SON VALIDOS, MODIFIQUE ESTA ENTRADA: </font>
						</br>
						&nbsp;&nbsp;&nbsp;".mysqli_error($db))."
						</br>";
						show_form ();
						global $texerror;
						$texerror = "\n\t ".mysqli_error($db);
							}
							
	$sqlc2 = "DELETE FROM `$db_name`.`feedback` WHERE `feedback`.`ID` = '$_POST[ID]' LIMIT 1 ";

	if(mysqli_query($db, $sqlc2)){
					print("HA BORRADO FEEDBACK ADMIN");
				} else {
				print("<font color='#FF0000'>
						SE HA PRODUCIDO UN ERROR: </font>
						</br>
						&nbsp;&nbsp;$nbsp;".mysqli_error($db))."
						</br>";
							}

			}	

//////////////////////////////////////////////////////////////////////////////////////////////
			
			global $dt;
			$id = $_POST['Id'];

function show_form($errors=''){
	

	$dt = $_POST['doc'];
	
	global $img;
	$img = 	$_POST['myimg'];

/*	REFERENCIA DE USUARIO	*/

if (preg_match('/^(\w{1})/',$_POST['Nombre'],$ref1)){	$rf1 = $ref1[1];
														$rf1 = trim($rf1);
														/*print($ref1[1]."</br>");*/
																		}
if (preg_match('/^(\w{1})*(\s\w{1})/',$_POST['Nombre'],$ref2)){	$rf2 = $ref2[2];
																$rf2 = trim($rf2);
																/*print($ref2[2]."</br>");*/
																						}
if (preg_match('/^(\w{1})/',$_POST['Apellidos'],$ref3)){	$rf3 = $ref3[1];
															$rf3 = trim($rf3);
															/*print($ref3[1]."</br>");*/
																		}
if (preg_match('/^(\w{1})*(\s\w{1})/',$_POST['Apellidos'],$ref4)){	$rf4 = $ref4[2];
																	$rf4 = trim($rf4);
																	/*print($ref4[2]."</br>");*/
																						}

global $rf;
$rf = $rf1.$rf2.$rf3.$rf4.$_POST['dni'].$_POST['ldni'];
$rf = trim($rf);

/*******************************/

	if($_POST['oculto2']){
		

				$defaults = array ( 'ID' => $_POST['ID'],
									'ref' => $_POST['ref'],
									'Nombre' => $_POST['Nombre'],
									'Apellidos' => $_POST['Apellidos'],
									'myimg' => $_POST['myimg'],
									'Nivel' => $_POST['Nivel'],																														
									'doc' => $dt,
									'dni' => $_POST['dni'],
									'ldni' => $_POST['ldni'],
									'Email' => $_POST['Email'],
									'Usuario' => $_POST['Usuario'],
									'Usuario2' => $_POST['Usuario'],
									'Password' => $_POST['Password'],
									'Password2' => $_POST['Password'],
									'Direccion' => $_POST['Direccion'],
									'Tlf1' => $_POST['Tlf1'],
									'Tlf2' => $_POST['Tlf2'],
									'lastin' => $_POST['lastin'],
									'lastout' => $_POST['lastout'],
									'visitadmin' => $_POST['visitadmin'],

																		 );
								   											}
								   
		elseif($_POST['modifica']){
			global $img2;
			$img2 = 'untitled.png';

				$defaults = array ( 'ID' => $_POST['ID'],
									'ref' => $rf,
									'Nombre' => $_POST['Nombre'],
									'Apellidos' => $_POST['Apellidos'],
									'myimg' => $_POST['myimg'],
									'Nivel' => $_POST['Nivel'],																														
									'doc' => $dt,
									'dni' => $_POST['dni'],
									'ldni' => $_POST['ldni'],
									'Email' => $_POST['Email'],
									'Usuario' => $_POST['Usuario'],
									'Usuario2' => $_POST['Usuario2'],
									'Password' => $_POST['Password'],
									'Password2' => $_POST['Password2'],
									'Direccion' => $_POST['Direccion'],
									'Tlf1' => $_POST['Tlf1'],
									'Tlf2' => $_POST['Tlf2'],
									'lastin' => $_POST['lastin'],
									'lastout' => $_POST['lastout'],
									'visitadmin' => $_POST['visitadmin'],
																		 );
												}
	
	if ($errors){
		print("<font color='#FF0000'>* SOLUCIONE ESTOS ERRORES:</font></br>");
		
		for($a=0; $c=count($errors), $a<$c; $a++){
			print("<font color='#FF0000'>** </font>".$errors [$a]."</br>");
			}
		}
		
	$Nivel = array (	'' => 'NIVEL USUARIO',
						'admin' => 'ADMINISTRADOR',
						'userpro' => 'USER PRO',
						'user'  => 'USER BASIC',
															);														

	$doctype = array (	'DNI' => 'DNI/NIF Espa&ntilde;oles',
						'NIE' => 'NIE/NIF Extranjeros',
						'NIFespecial' => 'NIF Persona F&iacute;sica Especial',
						'NIFsa' => 'NIF Sociedad An&oacute;nima',
						'NIFsrl' => 'NIF Sociedad Responsabilidad Limitada',
						'NIFscol' => 'NIF Sociedad Colectiva',
						'NIFscom' => 'NIF Sociedad Comanditaria',
						'NIFcbhy' => 'NIF Comunidad Bienes y Herencias Yacentes',
						'NIFscoop' => 'NIF Sociedades Cooperativas',
						'NIFasoc' => 'NIF Asociaciones',
						'NIFcpph' => 'NIF Comunidad Propietarios Propiedad Horizontal',
						'NIFsccspj' => 'NIF Sociedad Civil, con o sin Personalidad Juridica',
						'NIFee' => 'NIF Entidad Extranjera',
						'NIFcl' => 'NIF Corporaciones Locales',
						'NIFop' => 'NIF Organismo Publico',
						'NIFcir' => 'NIF Congragaciones Instituciones Religiosas',
						'NIFoaeca' => 'NIF Organos Admin Estado y Comunidades Autonomas',
						'NIFute' => 'NIF Uniones Temporales de Empresas',
						'NIFotnd' => 'NIF Otros Tipos no Definidos',
						'NIFepenr' => 'NIF Establecimientos Permanentes Entidades no Residentes',
										);
	
	print("
			<table align='center' border=0>
				<tr>
					<th colspan=2 class='BorderInf'>
						<img src='img_admin/".$defaults['myimg']."' height='44px' width='33px' />
						DATOS DEL ADMIN A RECUPERAR.
					</th>
				</tr>
				
			<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]'>
			
		<input name='ID' type='hidden' value='".$defaults['ID']."' />					
		<input name='myimg' type='hidden' value='".$defaults['myimg']."' />	
		
				<tr>
					<td>	
						<font color='#FF0000'>*</font>
						Referencia User:
					</td>
					<td>
						".$defaults['ref']."
					</td>
				</tr>
					
				<tr>
					<td>	
						<font color='#FF0000'>*</font>
						Nombre:
					</td>
					<td>
		<input type='text' name='Nombre' size=28 maxlength=25 value='".$defaults['Nombre']."' />
					</td>
				</tr>
					
				<tr>
					<td>
						<font color='#FF0000'>*</font>
						Apellidos:
					</td>
					<td>
	<input type='text' name='Apellidos' size=28 maxlength=25 value='".$defaults['Apellidos']."' />
					</td>
				</tr>


				<tr>
					<td>
						<font color='#FF0000'>*</font>
						Tipo Documento:
					</td>
					<td>
		<select name='doc'>");

				foreach($doctype as $option => $label2){
					
					print ("<option value='".$option."' ");
					
					if($option == $defaults['doc']){
															print ("selected = 'selected'");
																								}
													print ("> $label2 </option>");
												}	
						
	print ("</select>
					</td>
				</tr>
					
				
				<tr>
					<td>
						<font color='#FF0000'>*</font>
						N&uacute;mero:
					</td>
					<td>
		<input type='text' name='dni' size=28 maxlength=8 value='".$defaults['dni']."' />
					</td>
				</tr>
				
				<tr>
					<td>
						<font color='#FF0000'>*</font>
						Control::
					</td>
					<td>
		<input type='text' name='ldni' size=28 maxlength=1 value='".$defaults['ldni']."' />
					</td>
				</tr>
				
				<tr>
					<td>
						<font color='#FF0000'>*</font>
						Mail:
					</td>
					<td>
		<input type='text' name='Email' size=52 maxlength=50 value='".$defaults['Email']."' />
					</td>
				</tr>	
				
				
				<tr>
					<td>
						<font color='#FF0000'>*</font>
						Tipo Documento:
					</td>
					<td>
		<select name='Nivel'>");

				foreach($Nivel as $optionnv => $labelnv){
					
					print ("<option value='".$optionnv."' ");
					
					if($optionnv == $defaults['Nivel']){
															print ("selected = 'selected'");
																								}
													print ("> $labelnv </option>");
												}	
						
	print ("</select>
					</td>
				</tr>
					
				<tr>
					<td>
						<font color='#FF0000'>*</font>
						Nombre de Usuario:
					</td>
					<td>
		<input type='text' name='Usuario' size=12 maxlength=10 value='".$defaults['Usuario']."' />
					</td>
				</tr>
				<tr>
					<td>
						<font color='#FF0000'>*</font>
						Confirme el Usuario:
					</td>
					<td>
		<input type='text' name='Usuario2' size=12 maxlength=10 value='".$defaults['Usuario2']."' />
					</td>
				</tr>
							
				<tr>
					<td>
						<font color='#FF0000'>*</font>
						Password:
					</td>
					<td>
		<input type='text' name='Password' size=12 maxlength=10 value='".$defaults['Password']."' />
					</td>
				</tr>

				<tr>
					<td>
						<font color='#FF0000'>*</font>
						Confirme el Password:
					</td>
					<td>
	<input type='text' name='Password2' size=12 maxlength=10 value='".$defaults['Password2']."' />
					</td>
				</tr>

				<tr>
					<td>
						<font color='#FF0000'>*</font>
						Dirección:
					</td>
					<td>
	<input type='text' name='Direccion' size=52 maxlength=60 value='".$defaults['Direccion']."' />
					</td>
				</tr>
				
				<tr>
					<td>
						<font color='#FF0000'>*</font>
						Teléfono 1:
					</td>
					<td>
		<input type='text' name='Tlf1' size=12 maxlength=9 value='".$defaults['Tlf1']."' />
					</td>
				</tr>
				
				<tr>
					<td>
						<font color='#FF0000'>*</font>
						Teléfono 2:
					</td>
					<td>
		<input type='text' name='Tlf2' size=12 maxlength=9 value='".$defaults['Tlf2']."' />
					</td>
				</tr>
				
				<tr>
					<td>
						<font color='#FF0000'>*</font>
						Last In:
					</td>
					<td>
	<input name='lastin' type='hidden' value='".$defaults['lastin']."' />"
	.$defaults['lastin']."</br>
					</td>
				</tr>
				
				<tr>
					<td>
						<font color='#FF0000'>*</font>
						Last Out:
					</td>
					<td>
	<input name='lastout' type='hidden' value='".$defaults['lastout']."' />"
	.$defaults['lastout']."</br>
					</td>
				</tr>
				
				<tr>
					<td>
						<font color='#FF0000'>*</font>
						Visitas Admin:
					</td>
					<td>
	<input name='visitadmin' type='hidden' value='".$defaults['visitadmin']."' />"
	.$defaults['visitadmin']."</br>
					</td>
				</tr>
				
				<tr height=40px>
					<td colspan='2' align='right'>
						<input type='submit' value='RECUPERAR ADMIN' />
						<input type='hidden' name='modifica' value=1 />
						
					</td>
					
		</form>														
			
			</table>				

				"); 

	
	}	

/////////////////////////////////////////////////////////////////////////////////////////////////
	
	function master_index(){
		
				require '../Inclu/Master_Index_Admin.php';
		
				} 

/////////////////////////////////////////////////////////////////////////////////////////////////

function accion_Feedback_Admin_Recuperar_02(){

	global $db;
	global $rowout;
	global $nombre;
	global $apellido;	
	global $texerror;
	global $rf;

	$nombre = $_POST['Nombre'];
	$apellido = $_POST['Apellidos'];
		
	$ActionTime = date('H:i:s');

	global $dir;
	if (($_SESSION['Nivel'] == 'admin') || ($_SESSION['Nivel'] == 'userpro')){ $dir = 'Admin';}
	elseif ($_SESSION['Nivel'] == 'cliente'){ $dir = 'Clientes';}
	elseif (($_SESSION['Nivel'] == 'user') || ($_SESSION['Nivel'] == 'caja')){ $dir = 'User';}

global $text;
$text = "- ADMIN FEEDBACK RECUPERAR 3 ".$ActionTime.". ".$nombre." ".$apellido.".\n\t Ref: ".$rf.". Nivel: ".$_POST['Nivel'].".\n\t User: ".$_POST['Usuario'].". Pass: ".$_POST['Password'];

	$logname = $_SESSION['Nombre'];	
	$logape = $_SESSION['Apellidos'];	
	$logname = trim($logname);	
	$logape = trim($logape);	
	$logdocu = $logname."_".$logape;
	$logdate = date('Y_m_d');
	$logtext = $text.$texerror."\n";
	$filename = "../logs/".$dir."/".$logdate."_".$logdocu.".log";
	$log = fopen($filename, 'ab+');
	fwrite($log, $logtext);
	fclose($log);

	}

/////////////////////////////////////////////////////////////////////////////////////////////////

function accion_Feedback_Admin_01(){

	global $db;
	global $rowout;
	global $nombre;
	global $apellido;
	global $rf;
	
	$rf = $_POST['ref'];
	$nombre = $_POST['Nombre'];
	$apellido = $_POST['Apellidos'];
		
	global $orden;
	$orden = $_POST['Orden'];	

	$ActionTime = date('H:i:s');

	global $dir;
	if (($_SESSION['Nivel'] == 'admin') || ($_SESSION['Nivel'] == 'userpro')){ $dir = 'Admin';}
	elseif ($_SESSION['Nivel'] == 'cliente'){ $dir = 'Clientes';}
	elseif (($_SESSION['Nivel'] == 'user') || ($_SESSION['Nivel'] == 'caja')){ $dir = 'User';}

global $text;
$text = "- ADMIN FEEDBACK RECUPERAR 2 ".$ActionTime.". ".$nombre." ".$apellido.".\n\t Ref: ".$rf.". Nivel: ".$_POST['Nivel'].".\n\t User: ".$_POST['Usuario'].". Pass: ".$_POST['Password'];

	$logname = $_SESSION['Nombre'];	
	$logape = $_SESSION['Apellidos'];	
	$logname = trim($logname);	
	$logape = trim($logape);	
	$logdocu = $logname."_".$logape;
	$logdate = date('Y_m_d');
	$logtext = $text."\n";
	$filename = "../logs/".$dir."/".$logdate."_".$logdocu.".log";
	$log = fopen($filename, 'ab+');
	fwrite($log, $logtext);
	fclose($log);

	}

/////////////////////////////////////////////////////////////////////////////////////////////////
	
	function desconexion(){

			print("<form name='cerrar' action='mcgexit.php' method='post'>
							<tr>
								<td valign='bottom' align='right' colspan='8'>
											<input type='submit' value='Cerrar Sesion' />
								</td>
							</tr>								
											<input type='hidden' name='cerrar' value=1 />
					</form>	
							");
	
			} 
	
/////////////////////////////////////////////////////////////////////////////////////////////////

	require '../Inclu/Admin_Inclu_02.php';
		
?>