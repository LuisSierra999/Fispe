<?php 

$host = "localhost";
$usuario = "root";
$password = "";
$basededatos = "api_rest";

//$conexion = new mysqli($host,$usuario,$password,$basededatos);

/*if($conexion->connect_error){
    die ("Conexion no establecida". $conexion_error);
}*/

try {
    $conexion = new PDO("mysql:host=$host;dbname=$basededatos", $usuario, $password);
    // Establecer el modo de error de PDO a excepción
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa";
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}

header("Content-type: application/json");
$metodo= $_SERVER['REQUEST_METHOD'];
//print_r($metodo);

$path = isset($_SERVER['PATH_INFO'])?$_SERVER['PATH_INFO']:'/';

$buscarId = explode('/', $path);

$id = ($path!=='/') ? end($buscarId):null;

switch ($metodo){

    //SELECT usuarios
    case 'GET':
        consultaSelect($conexion);
        break;
    //INSERT
    case 'POST':
        insertar($conexion);
        break;
    //UPDATE
    case 'PUT':
        actualizar($conexion, $id);
        break;
    //DELETE
    case 'DELETE':
        borrar($conexion, $id);
        break;
    default:
        echo "Metodo no permitido";
        break;
}

function consultaSelect($conexion){

    $sql = "SELECT * FROM usuarios";
    $resultado = $conexion->query($sql);

    if($resultado){

        $datos = array();
        while($fila = $resultado->fetch(PDO::FETCH_ASSOC)){
            $datos[] = $fila;

        }
        echo json_encode($datos);
    }
}

function insertar($conexion){

    $dato = json_decode(file_get_contents('php://input'),true);
    $nombre = $dato['nombre']; 
    $apellido = $dato['apellido']; 
    $email = $dato['email'];
    
    $sql = "INSERT INTO usuarios(nombre,apellido,email) Values('$nombre','$apellido','$email')";
    $resultado = $conexion->query($sql);

    if($resultado){
        $dato['id'] = $conexion->lastInsertId();
        //$dato['id'] = $conexion->insert_id;
        echo json_encode($dato);
    }else{
        echo json_encode(array('error'=>'Error al  crear el usuario'));
    }
}

function borrar($conexion, $id){ 

    

    $sql = "DELETE FROM usuarios WHERE id = $id";
    $resultado = $conexion->query($sql);

    if($resultado){
        echo json_encode(array('mensaje' => 'Usuario Eliminado'));
    } else {
        echo json_encode(array('error' => 'Error al eliminar el usuario'));
    }
}

function actualizar($conexion, $id){

    $dato = json_decode(file_get_contents('php://input'),true);
    $nombre = $dato['nombre']; 
    $apellido = $dato['apellido']; 
    $email = $dato['email'];

    echo "El id a editar es: ". $id. " con el dato ". $nombre . ", " . $apellido . ", " . $email;

    //$sql = "UPDATE usuarios SET(nombre,apellido,email) = ('$nombre','$apellido','$email') WHERE id = $id";
    //$resultado = $conexion->query($sql);

    $sql = "UPDATE usuarios SET nombre = :nombre, apellido = :apellido, email = :email WHERE id = :id";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apellido', $apellido);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':id', $id);
    $resultado = $stmt->execute();

    if($resultado){
        echo json_encode(array('mensaje' => 'Usuario Actualizado'));
    } else {
        echo json_encode(array('error' => 'Error al actualizar el usuario'));
    }
}

?>