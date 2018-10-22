<?php
include_once 'lib/nusoap.php';
require 'constructor/constructor.php';
$consultalic = new Consulta_RCivil();

$servicio = new soap_server();
$ns = "urn:WebServiceMDPP_RC";
$servicio->configureWSDL("Web-service Registro Civil",$ns);
$servicio->schemaTargetNamespace = $ns;

$servicio->register('Consulta_RCivil.listar', array('numDoc' => 'xsd:string'), array('return' => 'xsd:array'), $ns );

$servicio->service(file_get_contents("php://input"));
?>