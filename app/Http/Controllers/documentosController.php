<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Log;
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
        $meses=[1 =>'ENERO',2=>'FEBRERO',3=>'MARZO',4=>'ABRIL',5=>'MAYO',6=>'JUNIO',7=>'JULIO',8=>'AGOSTO',9=>'SEPTIEMBRE',10=>'OCTUBRE',11=>'NOVIEMBRE',12=>'DICIEMBRE'];
        $usuario = auth()->user();
        //$usuario->assignRole('Administrador');
        //dd($usuario,$usuario->roles);
        $url = env('URL_API');
        $http = Http::withoutVerifying();
        $response = $http->get($url.'documentos');
        $documentos = $response->json();
        //dd($documentos);
        return view('documentos.index',compact('documentos','usuario','meses'));
    }
    public function create(){

        return view("documentos.create");

    }
    public function store(Request $request){
        //Verificar y agregar archivo en base64
        $base64File = $request->input('archivo_base64');
    
           if (!empty($base64File))  {
                $formData['archivo_base64'] = $base64File;
                Log::info('Archivo base64 detectado', [
                    'base64' => $base64File
                ]);
            } else {
                Log::warning('No se detectó archivo base64 o no esta vacio');
            }
        //dd($base64File);
        //obtener el id del usuario autenticado
        $usuario = auth()->user()->id;
        //$ip = request()->ip();
        $ip = $request->ip();
        //$ip = \Request::ip();
         //$ip = \Request::getClientIp(true);
         //$ip = $_SERVER['REMOTE_ADDR'];
        //dd($ip);

        //verificar y guardar el archivo 
        $request->validate([
            'titulo' => 'required|max:60',
            'descripcion'=> 'required|max:150',
            'fecha_hora' => 'required',
            'archivo' => 'required|file|mimes:pdf'
            
        ]);

        $fecha_hora = Carbon::parse($request->fecha_hora)->format('Y-m-d H:i:s');
        //dd($fecha_hora);
        
        //LLamar a la API
        $url = env('URL_API');
        $http = Http::withoutVerifying();
         
        try {
            $formData=[
                'titulo'=> $request->titulo,
                'descripcion'=> $request->descripcion,
                'archivo'=> $base64File,
                'fecha_inicio'=>$fecha_hora,
            ];
            //dd($formData);
            $response = $http->withHeaders([
                'X-User-ID'=> $usuario,
                'X-IP'=> $ip,
            ])->post($url.'documentosStore',$formData);
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
        //obtenemos al usuario
        $usuario = auth()->user()->id;
        //obtenemos la ip
        $ip = $request->ip();
        $url = env('URL_API');
        $http = Http::withoutVerifying();
        //usamos la extension Carbon para obtener la fecha y hora actual perteneciente a Chile
        
        $response_doc = $http->get($url.'documentosShow/'. $id);
        $documento = $response_doc->json();
        

        $request->validate([
            'titulo' => 'required|max:30',
            'descripcion'=> 'required|max:100',
            'archivo' => 'file|mimes:pdf'
        ]);

        //verificamos si el campo archivo no tiene un archivo, en el caso de que no reciba algun archivo, se conservara el que ya estaba asociado originalmente.
        if(!$request->hasFile('archivo')){
            $ruta = $documento['documento']['archivo'];
            
        }else{
            //File::delete(public_path('storage/'.$documento->archivo));
            //en el caso que el campo 'archivo' contenga un archivo, remplazara al anterior que estaba
            $base64File = $request->input('archivo_base64');
    
           if (!empty($base64File))  {
                $formData['archivo_base64'] = $base64File;
                Log::info('Archivo base64 detectado', [
                    'base64' => $base64File
                ]);
            } else {
                Log::warning('No se detectó archivo base64 o no esta vacio');
            }
            $ruta = $base64File;

            // $archivo = $request->file('archivo');
            // $nombreNuevo = $request->titulo. ' ' . $fecha;
            // $ruta = $archivo->storeAs('documents/'.date('Y'), $nombreNuevo.'.'.$archivo->extension(),'public');
        }
        
        if($request->fecha_hora){
            $fecha_hora = Carbon::parse($request->fecha_hora)->format('Y-m-d H:i:s');
            $formData=[
                'titulo'=> $request->titulo,
                'descripcion'=> $request->descripcion,
                'archivo'=> $ruta,
                'fecha_inicio' => $fecha_hora
            ];
            //dd($formData);
        }else{
            $formData=[
                'titulo'=> $request->titulo,
                'descripcion'=> $request->descripcion,
                'archivo'=> $ruta,
            ];
            //dd($formData);
        }
        //dd($formData);
        //llamar a la API para actualizar
        $response = $http->withHeaders([
            'X-User-ID'=> $usuario,
            'X-IP'=> $ip,
        ])->put($url.'documentos/'. $id ,$formData);
        
        return redirect()->route('documentos.edit',$id)->with('success-update','¡Documendo actualizado con exito!');
    }
    
    public function cambiarEstado(Request $request, $id){
    $usuario = auth()->user()->id;
    //dd($usuario.'');
    $ip = request()->ip();
    $url = env('URL_API');
    $http = Http::withoutVerifying();
    $response = $http->withHeaders([
        'X-User-ID' => $usuario,
        'X-IP' => $ip,
    ])->patch($url . 'documentosEstado/' . $id);

    return redirect()->action([documentosController::class, 'index'])->with('success-estado', '¡Documento cerrado con exito!');
    }
}
