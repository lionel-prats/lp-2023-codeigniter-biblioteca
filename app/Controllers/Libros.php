<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Libro;

class Libros extends Controller
{
    public function index()
    {
        $libro = new Libro();
        $datos['libros'] = $libro->orderBy('id', 'ASC')->findAll();
        $datos['cabecera'] = view('template/cabecera');
        $datos['piepagina'] = view('template/piepagina');
       
        return view('libros/listar', $datos);
    }
    public function crear()
    {
        $datos['cabecera'] = view('template/cabecera');
        $datos['piepagina'] = view('template/piepagina');
       
        return view('libros/crear', $datos);
    }
    public function guardar()
    {
        $libro = new Libro();

        $nombre = $this->request->getVar('nombre');
        // capturo el input name="nombre"
        // dd($this);
        // $this hace referencia a la instancia de esta mismo controlador (es una clase) Libros
        // request calculo es un atributo de la clase Controller, que puedo accederlo por herencia
        // getVar() calculo es un metodo de la clase Controller, que puedo accederlo por herencia
        // 59'40""

        if($imagen = $this->request->getFile('imagen')) {
            $nuevoNombre = $imagen->getRandomName();
            $imagen->move('../public/uploads', $nuevoNombre);
            // move() guardara un archivo en el servidor (le pasamos la carpeta de destino como primer argumento; si no existe, se crea automaticamente)

            $datos = [
                'nombre' => $nombre,
                'imagen' => $nuevoNombre
            ];

            $libro->insert($datos);
            // insert() es un metodo de Model, clase heredada por Libro
        } 
        return $this->response->redirect(base_url('listar'));
    }
    public function borrar($id = null)
    {
        //dd(base_url('listar'));
        $libro = new Libro();
        $datosLibro = $libro->where('id', $id)->first();
        $ruta = "../public/uploads/" . $datosLibro['imagen'];
        unlink($ruta);
        $libro->where('id', $id)->delete($id);
        return $this->response->redirect(base_url('listar'));
    }
    public function editar($id = null)
    {
        $libro = new Libro();
        $libro_a_editar = $libro->where('id', $id)->first();
        $datos['libro'] = $libro_a_editar;
        $datos['cabecera'] = view('template/cabecera');
        $datos['piepagina'] = view('template/piepagina');
        return view('libros/editar', $datos);
    }
    public function actualizar()
    {
        $libro = new Libro();
        $datos = [
            'nombre' => $this->request->getVar('nombre')
        ];
        $id = $this->request->getVar('id');
        $libro->update($id, $datos);

        /* 
        
        01:37:29 (25)Modificación de datos y de imagen

        */

        return $this->response->redirect(base_url('listar'));
    }
}