<?php
require_once 'producto.php';
require_once 'IApiOperaciones.php';
//require_once 'MWparaAutentificar.php';

class productosAPI extends producto implements IApiOperaciones
{

    
    public function altaProducto($request, $response, $args) {
        // id-nombre-precio
        $objDelaRespuesta= new stdclass();
        $ArrayDeParametros = $request->getParsedBody();
        //var_dump($ArrayDeParametros);
        if(
            isset($ArrayDeParametros['nombre']) &&
            isset($ArrayDeParametros['precio'])
        ) {
            $producto = new producto();
            
            $producto->nombre = $ArrayDeParametros['nombre'];
            $producto->precio = $ArrayDeParametros['precio'];
        }
        else
        {
            return $response->withJson(array("error" => "Faltan parametros obligatorios del usuario."), 409);
        }
        
        $producto->InsertarParametros();
        
        $objDelaRespuesta->respuesta = "Se guardo el producto.";
        return $response->withJson($objDelaRespuesta, 200);
    }

    public function TraerTodos($request, $response, $args) {
        $todoLosProductos = producto::TraerTodoLosProductos();
        
        $newresponse = $response->withJson($todoLosProductos, 200);
        return $newresponse;
    }

    public function borrarProducto($request, $response, $args) { 
        $ArrayDeParametros = $request->getParsedBody();      // pasar por 'x-www-form-urlencoded'
        $objDelaRespuesta = new stdclass();
        
        if(isset($ArrayDeParametros['id']))
        {
            $id = $ArrayDeParametros['id'];

            $producto = new producto();
            $producto->id = $id;
            $cantidadDeBorrados = $producto->borrarProducto();
            
            $objDelaRespuesta->cantidad = $cantidadDeBorrados;
            if($cantidadDeBorrados > 0)
            {
                $objDelaRespuesta->resultado = "Se ha eliminado el producto exitosamente.";
            }
            else
            {
                $objDelaRespuesta->resultado = "Error: no se pudo eliminar el producto.";
            }
        }
        else
        {
            $objDelaRespuesta->resultado = "No se pasó el ID del producto a eliminar.";

        }

	    $newResponse = $response->withJson($objDelaRespuesta, 200);  
      	return $newResponse;
    }
    
    public function modificarProducto($request, $response, $args) {
        $ArrayDeParametros = $request->getParsedBody();
        $objDelaRespuesta = new stdclass();
        //var_dump($ArrayDeParametros); die();
        
        if(isset($ArrayDeParametros['id']) && isset($ArrayDeParametros['nombre']) &&  isset($ArrayDeParametros['precio']))
        {
            $producto = new producto();
            $producto->id = $ArrayDeParametros['id'];
            $producto->nombre = $ArrayDeParametros['nombre'];
            $producto->precio = $ArrayDeParametros['precio'];
            //var_dump($producto); die();

            $resultado = $producto->ModificarProducto();
            
            if($resultado == false)
                $objDelaRespuesta->error = "No se pudo cambiar el producto.";
            else
                $objDelaRespuesta->respuesta = "Se ha cambiado el producto exitosamente.";
        }
        else
        {
            $objDelaRespuesta->error = "Parametros o valores de producto no validos.";
        }

        $objDelaRespuesta->tarea = "Modificar";
        return $response->withJson($objDelaRespuesta, 200);
    }





}


?>