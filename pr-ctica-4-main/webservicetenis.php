<?php
    require_once 'conexion.php';
    require_once 'lib/nusoap.php';
    //Metodo insertar
    function insertSnikear($marca,$nombre,$precio,$color,$material){
        try{
            $conexion= new Conexion();
            $consulta=$conexion->prepare("INSERT INTO sneaker (Marca,Nombre,Precio,Color,Material)
            VALUES(:marca, :nombre, :precio, :color, :material)");
            $consulta -> bindParam(":marca", $marca, PDO::PARAM_STR);
            $consulta -> bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $consulta -> bindParam(":precio", $precio, PDO::PARAM_INT);
            $consulta -> bindParam(":color", $color, PDO::PARAM_STR);
            $consulta -> bindParam(":material", $material, PDO::PARAM_STR);
            $consulta -> execute();
            $ultimoID = $conexion->lastInsertId();
            return join (",",array($ultimoID));
        }catch (Exception $e){
            return join (",",array(false));
        }
    }
    $server = new nusoap_server();
    $conexion= new Conexion();
    //Metodo de Obtener
    function getSnikear($id){
        try{
            global $conexion;
            $sql = "SELECT * FROM sneaker WHERE ID = :id";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return json($data);
            $conexion = null;
        }catch (Exception $e){
            return join (",",array(false));
        }
    }
    //Metodo de Eliminar
    function DelSnikear($id){
        try{
            global $conexion;
            $sql = "DELETE FROM sneaker WHERE ID = :id";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return json(true);
            $conexion = null;
        }catch (Exception $e){
            return join (",",array(false));
        }
    }
    //Metodo de Actualizar
    function UpdaSnikear($id,$marca,$nombre,$precio,$color,$material){
        try{
            $conexion= new Conexion();
            $consulta=$conexion->prepare("UPDATE sneaker SET Marca='$marca',Nombre='$nombre',Precio='$precio',Color='$color',Material='$material' WHERE ID='$id'");
            $consulta -> bindParam(":id", $id, PDO::PARAM_INT);
            $consulta -> bindParam(":marca", $marca, PDO::PARAM_STR);
            $consulta -> bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $consulta -> bindParam(":precio", $precio, PDO::PARAM_INT);
            $consulta -> bindParam(":color", $color, PDO::PARAM_STR);
            $consulta -> bindParam(":material", $material, PDO::PARAM_STR);
            $consulta -> execute();
            $mensaje='Actualizado';
            return join(",",array($mensaje));
        }catch (Exception $e){
            return join(",",array(false));
        }
    }
    //Registro de INSERTAR del servicio SOAP
    $server = new nusoap_server();
    $server->configureWSDL("webservicetenis","urn:webservicetenis");
    $server->register ("insert_tenis",
    array("marca"=>"xsd:string", "nombre"=>"xsd:string", "precio"=>"xsd:int", "color"=>"xsd:string", "material"=>"xsd:string"),
    array("return"=>"xsd:string"),
    "urn:webservicetenis",
    "urn:webservicetenis#insertar_tenis",
    "rpc",
    "encoded",
    "Metodo que inserta Tenis");
    // Registo de Leer
    $server->register("Get_tenis",
    array("id" => "xsd:string"),  
    array("data" => "xsd:string"),  
    "urn:webservicetenis",   
    "urn:webservicetenis#GetSnikear",
    "rpc",
    "encoded",
    "Metodo que inserta Tenis");
    // Registo de Eliminar
    $server->register("Del_tenis",
    array("id" => "xsd:string"),  
    array("data" => "xsd:string"),  
    "urn:webservicetenis",   
    "urn:webservicetenis#DelSnikear",
    "rpc",
    "encoded",
    "Metodo que elimina Tenis");
    // Registo de Actuallizar
    $server->register("Upda_tenis",
    array("id" => "xsd:int","marca"=>"xsd:string", "nombre"=>"xsd:string", "precio"=>"xsd:int", "color"=>"xsd:string", "material"=>"xsd:string"),
    array("data" => "xsd:string"),  
    "urn:webservicetenis",   
    "urn:webservicetenis#UpdaSnikear",
    "rpc",
    "encoded",
    "Metodo que Actualiza Tenis");
    //Flujo de solo lectura
    $post = file_get_contents('php://input');
    $server->service($post);
?>