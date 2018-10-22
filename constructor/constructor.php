<?php
require_once './clases/conexion.php';
class Consulta_RCivil{
    private $numDoc;
    const TABLA = 'p_usrios';
    public function setNumDoc($numDoc) {return $this->numDoc;}

    public function __construct($numDoc=null){
        $this->numDoc=$numDoc;
    }

    public function listar($numDoc=null){
        $conexionRC= new Conexion();   
        $consulta = $conexionRC->prepare("SELECT no_crto datos,"."h_hrros_mtrmnos.fe_dia_cta fech_Matr, h_hrros_mtrmnos.ho_dia_cta hora_Matr, CASE h_mtrmnios_dtlles.cdgo_estdo_trmte WHEN 30 THEN 'CONTRAJO NUPCIAS' WHEN 31 THEN 'NO SE PRESENTO' WHEN 32 THEN 'CONTRAJO NUPCIAS' ELSE 'PENDIENTE' END AS stadoMatri from ". self::TABLA . " INNER JOIN p_prtcpntes_mtri on p_usrios.cdgo_usrios = p_prtcpntes_mtri.cdgo_usrios INNER JOIN r_mtrmnio_cvil on p_prtcpntes_mtri.cdgo_prtcpntes_mtri = r_mtrmnio_cvil.cdgo_mtrmno_cvil_o OR p_prtcpntes_mtri.cdgo_prtcpntes_mtri = r_mtrmnio_cvil.cdgo_mtrmno_cvil_a INNER JOIN p_ctas_mtrmnos on r_mtrmnio_cvil.cdgo_mtrmnio_cvil = p_ctas_mtrmnos.cdgo_mtrmnio_cvil INNER JOIN h_hrros_mtrmnos on p_ctas_mtrmnos.cdgo_hrros_mtrmnos = h_hrros_mtrmnos.cdgo_hrros_mtrmnos INNER JOIN h_mtrmnios_dtlles ON p_ctas_mtrmnos.cdgo_ctas_mtrmnos = h_mtrmnios_dtlles.cdgo_ctas_mtrmnos AND h_mtrmnios_dtlles.in_esta = 1 WHERE nu_docu = :numDoc");
        $consulta->bindParam(':numDoc',$numDoc);
        $consulta->execute();
        $registro=$consulta->fetchAll(PDO::FETCH_ASSOC);
        if ($registro) {
            return json_encode($registro);
        }else {
            return false;
        }
    }
}
?>