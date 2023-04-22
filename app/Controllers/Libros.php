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

        $name_validations = [
            'required',
            'min_length[3]'
        ];
        $image_validations = [
            'uploaded[imagen]',
            'mime_in[imagen,image/jpg,image/jpeg,image/png]',
            'max_size[imagen,1024]' // max_size = 1024KB 
        ];

        $validacion = $this->validate([
            'nombre' => $name_validations, 
            'imagen' => $image_validations 
        ]);

        if(!$validacion) {
            session()->setFlashdata('mensaje', 'Error en la creación: revise los datos ingresados');
            return redirect()->back()->withInput();
            // el metodo redirect()->back() vuelve a la URL anterior 
            // agregando el metodo ->withInput() nos sirve para que el metodo old() en la vista se ejecute correctamente (en este ejemplo lo usamos para mantener impreso en el input nombre, el nombre que haya escrito el usuario)
        }

        $imagen = $this->request->getFile('imagen');
        $nuevoNombre = $imagen->getRandomName();
        $imagen->move('../public/uploads', $nuevoNombre);
        // move() guardara un archivo en el servidor (le pasamos la carpeta de destino como primer argumento; si no existe, se crea automaticamente)

        $datos = [
            'nombre' => $nombre,
            'imagen' => $nuevoNombre,
        ];

        $libro->insert($datos);
        // insert() es un metodo de Model, clase heredada por Libro

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
        $datos['libro'] = $libro->where('id', $id)->first();
        $datos['cabecera'] = view('template/cabecera');
        $datos['piepagina'] = view('template/piepagina');
        return view('libros/editar', $datos);
    }
    public function actualizar()
    {
        $id = $this->request->getVar('id');

        $name_validations = [
            'required',
            'min_length[3]'
        ];
        $array_validations['nombre']= $name_validations;
        
        if($_FILES['imagen']['tmp_name']){
            $image_validations = [
                'uploaded[imagen]',
                'mime_in[imagen,image/jpg,image/jpeg,image/png]',
                'max_size[imagen,1024]' // max_size = 1024KB 
            ];
            $array_validations['imagen']= $image_validations;
        }
        
        $validacion = $this->validate($array_validations);

        if(!$validacion) {
            session()->setFlashdata('mensaje', 'Error en la edición: revise los datos ingresados');
            return redirect()->back()->withInput();
        }

        $libro = new Libro();

        $datos['nombre'] = $this->request->getVar('nombre');

        if($_FILES['imagen']['tmp_name']){

            $datos['imagen'] = $nuevoNombre;
            
            // elimino del server imagen anterior
            $datosLibro = $libro->where('id', $id)->first();
            $ruta = "../public/uploads/" . $datosLibro['imagen'];
            unlink($ruta);
            
            // subo al server imagen nueva
            $imagen = $this->request->getFile('imagen');
            $nuevoNombre = $imagen->getRandomName();
            $imagen->move("../public/uploads/", $nuevoNombre);   

        }

        // hago un UPDATE en la BD
        $libro->update($id, $datos);

        return $this->response->redirect(base_url('listar'));
    }
}