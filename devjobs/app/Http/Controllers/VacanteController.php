<?php

namespace App\Http\Controllers;

use App\Models\Salario;
use App\Models\Vacante;
use App\Models\Categoria;
use App\Models\Ubicacion;
use App\Models\Experiencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class VacanteController extends Controller
{
    // public function __construct()
    // {
    //     // Revisar que el usuario este autenticado u verificado
    //     //$this->middleware(['auth','verified']);
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        //$vacantes = auth()->user()->vacantes;

        // $vacantes = Vacante::where('user_id',auth()->user()->id)->get(); // para obtener todas las vacantes
        // $vacantes = Vacante::where('user_id',auth()->user()->id)->take(3)->get(); // con take le podemos darle un valor el cual es la cantidad que queremos traer
        //$vacantes = Vacante::where('user_id',auth()->user()->id)->simplePaginate(3); //para un paginado mas simple con solo anterior y siguiente
        $vacantes = Vacante::where('user_id',auth()->user()->id)->latest()->paginate(3);// con paginate crearmos una paginacion y el valor es de cuantos queremos mostrar por cada paginacion
        // dd($vacantes);
        
        return view('vacantes.index', compact('vacantes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Consultas
        $categorias = Categoria::all();
        $experiencias = Experiencia::all();
        $ubicaciones = Ubicacion::all();
        $salarios = Salario::all();

        return view('vacantes.create')
        ->with('categorias',$categorias)
        ->with('experiencias',$experiencias)
        ->with('salarios',$salarios)
        ->with('ubicaciones', $ubicaciones);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validacion
        $data = $request->validate([

            'titulo'=>'required|min:8',
            'categoria'=>'required',
            'experiencia'=>'required',
            'ubicacion'=>'required',
            'salario'=>'required',
            'descripcion'=>'required|min:50',
            'imagen' => 'required',
            'skills' => 'required'

        ]);

        // Almacenar en la DB

        auth()->user()->vacantes()->create([
            'titulo' => $data['titulo'],
            'imagen' => $data['imagen'],
            'descripcion' => $data['descripcion'],
            'skills' => $data['skills'],
            'categoria_id' => $data['categoria'],
            'experiencia_id' => $data['experiencia'],
            'ubicacion_id' => $data['ubicacion'],
            'salario_id' => $data['salario'],
        ]);

        return redirect()->action([VacanteController::class,'index']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vacante  $vacante
     * @return \Illuminate\Http\Response
     */
    public function show(Vacante $vacante)
    {
        // para desactivar la vista de la vacante al ponerla inactiva
        if($vacante->activa ===0 )
        {
            return abort(404);
        }

        return view('vacantes.show')->with('vacante',$vacante);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vacante  $vacante
     * @return \Illuminate\Http\Response
     */
    public function edit(Vacante $vacante)
    {
        $this->authorize('view', $vacante);


        // Consultas
        $categorias = Categoria::all();
        $experiencias = Experiencia::all();
        $ubicaciones = Ubicacion::all();
        $salarios = Salario::all();
        
        return view('vacantes.edit')
        ->with('categorias',$categorias)
        ->with('experiencias',$experiencias)
        ->with('salarios',$salarios)
        ->with('ubicaciones', $ubicaciones)
        ->with('vacante',$vacante);

        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vacante  $vacante
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vacante $vacante)
    {

        $this->authorize('update', $vacante);
        // VALIDACION
        $data = $request->validate([

            'titulo'=>'required|min:8',
            'categoria'=>'required',
            'experiencia'=>'required',
            'ubicacion'=>'required',
            'salario'=>'required',
            'descripcion'=>'required|min:50',
            'imagen' => 'required',
            'skills' => 'required'

        ]);

        $vacante->titulo = $data['titulo'];
        $vacante->skills = $data['skills'];
        $vacante->imagen = $data['imagen'];
        $vacante->descripcion = $data['descripcion'];
        $vacante->categoria_id = $data['categoria'];
        $vacante->experiencia_id = $data['experiencia'];
        $vacante->ubicacion_id = $data['ubicacion'];
        $vacante->salario_id = $data['salario'];

        $vacante->save();

        // rediccionar
        return redirect()->action([VacanteController::class,'index']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vacante  $vacante
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vacante $vacante, Request $request ) // request es para saber que estamos enviando al servidor
    {
        $this->authorize('delete', $vacante);

        // return response()->json($request); // Nos muestra el metodo quye estamos evniando en este caso seria el delete que creamos en vue
        //return response()->json($vacante);

        $vacante->delete();
        return response()->json(['mensaje' => 'se elimino la vancate ' . $vacante->titulo]);
    }
    // campos extras
    public function imagen(Request $request){
        $imagen = $request->file('file'); // leemos el archivo
        $nombreImagen = time().'.'. $imagen->extension() ; // tomamos su extension y generamos un nombre basado en la hora que se subio
        $imagen->move(public_path('storage/vacantes'), $nombreImagen);//movemos el archivo asia la carpeta storage
        return response()->json(['correcto'=>$nombreImagen]);
    }

    // Borar imagen via Ajax
    public function borrarimagen(Request $request){
        if($request->ajax()){
            $imagen = $request->get('imagen');

            if(File::exists('storage/vacantes/' . $imagen)){
                File::delete('storage/vacantes/' . $imagen);
            }
            return response('Imagen Elimindo',200);
        }
        

    }
    //Cambia el estado de una vacante

    public function estado(Request $request, Vacante $vacante)
    {
        // Leer nuevo estado y asignarlo
        $vacante->activa = $request->estado;

        // guardarlo en la BD
        $vacante->save();

        return response()->json(['respuesta' => 'Correcto']);
    }

    public function buscar(Request $request)
    {
        // Validar
        $data = $request->validate([
            'categoria' => 'required',
            'ubicacion' => 'required'

        ]);

        // Asignar Valores
        $categoria = $data['categoria'];
        $ubicacion = $data['ubicacion'];


        // Esto where dos veces seria como un and en sql
        $vacantes = Vacante::latest()
        ->where('categoria_id', $categoria)
        ->where('ubicacion_id', $ubicacion)
        ->get();
        

        /* Esto es los mismo que el de arriba
        $vacantes = Vacante::where([
        'categoria_id' => $categoria,
        'ubicacion_id' => $ubicacion
        ])->get();
        */

        /* Este seria con un or en sql, se trae todas los de categoria y ubicacion
        $vacantes = Vacante::latest()
        ->where('categoria_id', $categoria)
        ->orWhere('ubicacion_id', $ubicacion)
        ->get();
        */

        //dd($vacantes);

        return view('buscar.index', compact('vacantes'));
        
    }
    public function resultados()
    {
        return "mostradando resultado";
    }
}
