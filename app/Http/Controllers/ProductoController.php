<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //Este método devuelve una lista de todos los productos almacenados en la base de datos.
    public function index()
    {
        $productos = Producto::all();
        return response()->json($productos);
    }


    /**
     * Store a newly created resource in storage.
     */
    //Este método almacena un nuevo producto en la base de datos.
    public function store(Request $request)
    {
        $producto = new Producto();
        $producto->nombre = $request->input('nombre');
        $producto->descripcion = $request->input('descripcion');
        $producto->precio = $request->input('precio');
        $producto->cantidad = $request->input('cantidad');
        $producto->save();

        return response()->json($producto);
    }


    /**
     * Display the specified resource.
     */
    //Este método devuelve un producto específico de la base de datos.
    public function show($id)
    {
        $producto = Producto::find($id);
        return response()->json($producto);
    }


    /**
     * Update the specified resource in storage.
     */
    //Este método actualiza un producto existente en la base de datos.
    public function update(Request $request, $id)
    {
        $producto = Producto::find($id);
        $producto->nombre = $request->input('nombre');
        $producto->descripcion = $request->input('descripcion');
        $producto->precio = $request->input('precio');
        $producto->cantidad = $request->input('cantidad');
        $producto->save();

        return response()->json($producto);
    }


    /**
     * Remove the specified resource from storage.
     */
    //Este método elimina un producto específico de la base de datos.
    public function destroy($id)
    {
        $producto = Producto::find($id);
        $producto->delete();

        return response()->json('Producto eliminado exitosamente');
    }

    public function actualizarInventario(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        $cantidad = $request->input('cantidad');

        // Verificar si se está aumentando o disminuyendo el inventario
        if ($cantidad > 0) {
            $producto->inventario += $cantidad;
        } else {
            // Verificar que haya suficiente inventario
            if ($producto->inventario < abs($cantidad)) {
                return response()->json(['error' => 'No hay suficiente inventario'], 400);
            }
            $producto->inventario -= abs($cantidad);
        }

        $producto->save();

        return response()->json(['message' => 'Inventario actualizado correctamente'], 200);
    }

    /**
     * Vende una cantidad de productos del inventario de un producto.
     */
    public function vender(Request $request, $id)
    {
        $producto = Producto::find($id);

        // Verificar que la cantidad de productos a vender no supere la cantidad disponible en el inventario
        if ($producto->cantidad < $request->input('cantidad')) {
            return response()->json('La cantidad de productos a vender supera la cantidad disponible en el inventario', 400);
        }

        // Restar la cantidad de productos vendidos del inventario del producto
        $producto->cantidad -= $request->input('cantidad');

        // Actualizar el precio del producto y aplicar el recargo del 13% correspondiente al IVA
        $precioUnitario = $producto->precio + ($producto->precio * 0.13);
        $producto->precio = round($precioUnitario, 2);

        // Guardar los cambios en la base de datos
        $producto->save();

        return response()->json('Producto vendido exitosamente');
    }

}
