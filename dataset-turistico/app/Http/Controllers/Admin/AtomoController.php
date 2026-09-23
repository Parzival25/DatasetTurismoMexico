<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Atomo;
use App\Models\Categoria;
use App\Models\Origen;
use App\Models\Subcategoria;
use App\Support\Texto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AtomoController extends Controller
{
    public function index(Request $request): View
    {
        $consulta = Atomo::query()->with(['origen', 'categorias', 'fotos'])->withCount('fotos');

        if ($texto = trim((string) $request->query('q'))) {
            foreach (explode(' ', Texto::normalizar($texto)) as $termino) {
                $consulta->where('busqueda', 'like', '%'.addcslashes($termino, '%_\\').'%');
            }
        }

        if ($origen = $request->query('origen')) {
            $consulta->where('origen_id', $origen);
        }

        match ($request->query('estado')) {
            'activos' => $consulta->where('activo', true),
            'inactivos' => $consulta->where('activo', false),
            default => null,
        };

        match ($request->query('pendiente')) {
            'sin_fotos' => $consulta->doesntHave('fotos'),
            'sin_coordenadas' => $consulta->whereNull('latitud'),
            'sin_descripcion' => $consulta->whereNull('descripcion'),
            'sin_clasificacion' => $consulta->doesntHave('categorias'),
            default => null,
        };

        return view('admin.atomos.index', [
            'atomos' => $consulta->orderBy('nombre')->paginate(40)->withQueryString(),
            'origenes' => Origen::orderBy('id')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.atomos.formulario', $this->datosFormulario(new Atomo(['activo' => true])));
    }

    public function store(Request $request): RedirectResponse
    {
        $atomo = $this->guardar($request, new Atomo);

        return redirect()->route('admin.atomos.edit', $atomo)->with('exito', 'Átomo creado. Ya puedes agregarle fotos.');
    }

    public function edit(Atomo $atomo): View
    {
        $atomo->load(['fotos', 'actividades', 'categorias', 'subcategorias']);

        return view('admin.atomos.formulario', $this->datosFormulario($atomo));
    }

    public function update(Request $request, Atomo $atomo): RedirectResponse
    {
        $this->guardar($request, $atomo);

        return back()->with('exito', 'Cambios guardados.');
    }

    public function destroy(Atomo $atomo): RedirectResponse
    {
        $atomo->fotos->each->delete();
        $atomo->delete();

        return redirect()->route('admin.atomos.index')->with('exito', "Se eliminó «{$atomo->nombre}».");
    }

    private function datosFormulario(Atomo $atomo): array
    {
        return [
            'atomo' => $atomo,
            'origenes' => Origen::orderBy('id')->get(),
            'categorias' => Categoria::with(['subcategorias' => fn ($q) => $q->orderBy('nombre')])->orderBy('orden')->get(),
        ];
    }

    private function guardar(Request $request, Atomo $atomo): Atomo
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'alpha_dash', 'max:255', Rule::unique('atomos', 'slug')->ignore($atomo->id)],
            'descripcion' => ['nullable', 'string'],
            'localizacion' => ['nullable', 'string'],
            'como_llegar' => ['nullable', 'string'],
            'latitud' => ['nullable', 'required_with:longitud', 'numeric', 'between:-90,90'],
            'longitud' => ['nullable', 'required_with:latitud', 'numeric', 'between:-180,180'],
            'origen_id' => ['nullable', 'exists:origenes,id'],
            'activo' => ['boolean'],
            'categorias' => ['array'],
            'categorias.*' => ['integer', 'exists:categorias,id'],
            'subcategorias' => ['array'],
            'subcategorias.*' => ['integer', 'exists:subcategorias,id'],
            'actividades' => ['nullable', 'string'],
        ], [], [
            'como_llegar' => 'cómo llegar',
            'localizacion' => 'localización',
            'descripcion' => 'descripción',
            'origen_id' => 'origen',
        ]);

        if (empty($datos['slug'])) {
            $usados = Atomo::whereKeyNot($atomo->id)->pluck('slug')->flip()->map(fn () => true)->all();
            $datos['slug'] = Texto::slugUnico($datos['nombre'], $usados);
        }

        $atomo->fill([
            ...collect($datos)->except(['categorias', 'subcategorias', 'actividades'])->all(),
            'activo' => $request->boolean('activo'),
        ]);
        $atomo->save();

        $subcategorias = $datos['subcategorias'] ?? [];
        $categorias = collect($datos['categorias'] ?? [])
            ->merge(Subcategoria::whereIn('id', $subcategorias)->pluck('categoria_id'))
            ->unique()->values()->all();

        $atomo->categorias()->sync($categorias);
        $atomo->subcategorias()->sync($subcategorias);

        $atomo->actividades()->delete();
        $lineas = preg_split('/\R/u', (string) ($datos['actividades'] ?? ''));
        foreach (array_values(array_filter(array_map('trim', $lineas))) as $orden => $actividad) {
            $atomo->actividades()->create(['descripcion' => $actividad, 'orden' => $orden + 1]);
        }

        // Los cambios en relaciones no tocan updated_at; se fuerza para renovar las descargas.
        $atomo->touch();

        return $atomo;
    }
}
