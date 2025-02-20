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
        $mes=[[1,"ENERO"],[2,"FEBRERO"],[3,"MARZO"],[4,"ABRIL"],[5,"MAYO"],[6,"JUNIO"],[7,"JULIO"],[8,"AGOSTO"],[9,"SEPTIEMBRE"],[10,"OCTUBRE"],[11,"NOVIEMBRE"],[12,"DICIEMBRE"]];
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
            'titulo' => 'required',
            'descripcion'=> 'required',
            'archivo' => 'required|file|mimes:pdf'
        ]);
        //dd($validate);
        
        //asignamos una variable ruta
        $ruta= "";
        //verificamos si el campo archivo tiene un archivo.
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
        $documento = Documento::find($id);
        $url = env('URL_API');
        $http = Http::withoutVerifying();
        $request->validate([
            'titulo' => 'required',
            'descripcion'=> 'required',
            'archivo' => 'file|mimes:pdf'
        ]);
        //verificamos si el campo archivo no tiene un archivo, en el caso de que no reciba algun archivo, se conservara el que ya estaba asociado originalmente.
        if(!$request->hasFile('archivo')){
            $ruta = $documento->archivo;
            //dd($ruta);
        }else{
            //en el caso que el campo 'archivo' contenga un archivo, remplazara al anterior que estaba
            File::delete(public_path('storage/'.$documento->archivo));
            $archivo = $request->file('archivo');
            $nombreNuevo = $request->titulo. ' ' . date('Y');
            $ruta = $archivo->storeAs('documents/'.date('Y'), $nombreNuevo.'.'.$archivo->extension(),'public');
        }
        
        //llamar a la API para actualizar
        $formData=[
            'titulo'=> $request->titulo,
            'descripcion'=> $request->descripcion,
            'archivo'=> $ruta,
        ];
        //dd($formData);
        $response = $http->put($url.'documentos/'. $id ,$formData);
        
        return redirect()->route('documentos.edit',$id)->with('success-update','¡Documendo actualizado con exito!');
    }
    public function cambiarEstado($id){

    }
    
}
