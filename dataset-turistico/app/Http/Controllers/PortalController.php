<?php

namespace App\Http\Controllers;

use App\Exportacion\Exportador;
use App\Http\Presentadores\AtomoPresentador;
use App\Models\Atomo;
use App\Models\Categoria;
use App\Models\Origen;
use App\Support\ConsultaAtomos;
use App\Support\Estadisticas;
use App\Support\VersionDataset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PortalController extends Controller
{
    public function inicio(Exportador $exportador): View
    {
        $version = VersionDataset::actual();

        $descargas = Cache::rememberForever("portal:descargas:{$version}", fn () => collect(Exportador::ARCHIVOS)
            ->map(fn ($info, $archivo) => [
                'archivo' => $archivo,
                'descripcion' => $info['descripcion'],
                'bytes' => strlen($exportador->contenido($archivo)),
                'url' => route('descargas', $archivo),
            ])->values()->all());

        $ejemplo = Atomo::activos()->has('fotos')->with(AtomoPresentador::RELACIONES)->find(16)
            ?? Atomo::activos()->with(AtomoPresentador::RELACIONES)->first();

        return view('portal.inicio', [
            'totales' => Estadisticas::totales(),
            'version' => $version,
            'actualizado' => VersionDataset::ultimaActualizacion(),
            'descargas' => $descargas,
            'categorias' => Categoria::orderBy('orden')->withCount(['atomos' => fn ($q) => $q->where('activo', true)])->get(),
            'origenes' => Origen::orderBy('id')->withCount(['atomos' => fn ($q) => $q->where('activo', true)])->get(),
            'ejemplo' => $ejemplo ? AtomoPresentador::resumen($ejemplo) : null,
        ]);
    }

    public function explorar(Request $request): View|RedirectResponse
    {
        try {
            $consulta = ConsultaAtomos::aplicar(Atomo::query(), $request);
        } catch (ValidationException) {
            return redirect()->route('portal.explorar')->with('aviso', 'El filtro indicado no existe.');
        }

        return view('portal.explorar', [
            'atomos' => $consulta->with(['origen', 'categorias', 'fotos'])->orderBy('nombre')->paginate(30)->withQueryString(),
            'categorias' => Categoria::orderBy('orden')->get(),
            'origenes' => Origen::orderBy('id')->get(),
            'filtros' => $request->only(['q', 'categoria', 'origen']),
        ]);
    }

    public function atomo(Atomo $atomo): View
    {
        $atomo->load(AtomoPresentador::RELACIONES_COMPLETAS);

        return view('portal.atomo', ['atomo' => $atomo]);
    }

    public function documentacion(): View
    {
        $ejemplo = Atomo::activos()->has('fotos')->with(AtomoPresentador::RELACIONES_COMPLETAS)->find(16)
            ?? Atomo::activos()->with(AtomoPresentador::RELACIONES_COMPLETAS)->first();

        $json = null;
        if ($ejemplo) {
            $datos = AtomoPresentador::completo($ejemplo);
            foreach (['descripcion', 'localizacion', 'como_llegar'] as $campo) {
                $datos[$campo] = $datos[$campo] ? Str::limit($datos[$campo], 70) : null;
            }
            $datos['actividades'] = array_slice($datos['actividades'], 0, 2);
            $datos['fotos'] = array_slice($datos['fotos'], 0, 1);
            $json = json_encode(['datos' => $datos], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        return view('portal.documentacion', [
            'ejemplo' => $ejemplo,
            'json' => $json,
            'categorias' => Categoria::with('subcategorias')->orderBy('orden')->get(),
            'origenes' => Origen::orderBy('id')->get(),
        ]);
    }

    public function acerca(): View
    {
        return view('portal.acerca', ['totales' => Estadisticas::totales()]);
    }
}
