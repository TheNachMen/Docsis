<?php

namespace App\Http\Controllers;
use App\Models\Anio;
use App\Models\Documento;
use App\Models\EstadoDocumento;
use App\Models\Mes;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class documentosController extends Controller
{

    //Proteger rutas de documentos mediante un constructor
    
    public function __construct(){
        //$this->middleware('can:documentos.index')->only('index');
        $this->middleware('can:documentos.store')->only('create', 'store');
        $this->middleware('can:documentos.update')->only('update','edit');
    }
    
    public function index()
    {
        $usuario = auth()->user();
        //$usuario->assignRole('Editor');
        //dd($usuario,$usuario->roles);
        $url = env('URL_API');
        //$valor = true;
        //dd($url);
        $http = Http::withoutVerifying();
        $response = $http->get($url.'documentos');
        $documentos = $response->json();
        //dd($documentos);
        return view('documentos.index',compact('documentos','usuario'));
    }
    public function create(){

        return view("documentos.create");

    }
    public function store(Request $request){
        //verificar y guardar el archivo 
        $request->validate([
            'archivo' => 'required|file|mimes:pdf'
        ]);
        $ruta= "";
        if($request->hasFile('archivo')){
            $archivo = $request->file('archivo');
            //dd($archivo);
            $nombreNuevo = $request->titulo. ' ' . date('Y');
            $ruta = $archivo->storeAs('documents/'.date('Y'), $nombreNuevo.'.'.$archivo->extension(),'public');
            //dd($ruta);
        }
        
        //LLamar a la API
        $url = env('URL_API');
        $http = Http::withoutVerifying();
        /*
        $request = Validator::make($request->all(),[
            "titulo"=> "required",
            "descripcion"=> "required",
            "archivo"=> "required",
        ]) ;
         */
         
        try {
            $formData=[
                'titulo'=> $request->titulo,
                'descripcion'=> $request->descripcion,
                'archivo'=> $ruta,
            ];
            //dd($formData);
            $response = $http->post($url.'documentosStore',$formData);
            //dd($response);
            //$resultado = json_decode($response->getBody(),true);

            return redirect()->action([documentosController::class,'index'])->with('success-create','¡Documento Creado con Exito!');
        }catch(\Exception $e){
            return back()->withError('Error al enviar datos'.$e->getMessage());
        }
        
        


    }
    public function edit($id){
        $url = env('URL_API');
        $http = Http::withoutVerifying();
        $response = $http->get($url.'documentosShow/'. $id);
        $documento = $response->json();
        //dd($documento);

        return view('documentos.edit',compact('documento'));
    }
    
    public function update(Request $request, $id){
        //actualizar archivo

        //llamar a la API para actualizar
        $url = env('URL_API');
        $http = Http::withoutVerifying();
        $formData=[
            'titulo'=> $request->titulo,
            'descripcion'=> $request->descripcion,
            'archivo'=> $request->archivo,
        ];
        //dd($formData);
        $response = $http->put($url.'documentos/'. $id ,$formData);
        
        return redirect()->action([documentosController::class,'index'])->with('success-update','¡Documendo actualizado con exito!');
    }
    public function cambiarEstado($id){

    }
    
}
