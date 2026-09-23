<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Evento;
use App\Support\Texto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EventoController extends Controller
{
    public function index(): View
    {
        $eventos = Evento::with('fotos')->get()
            ->sortBy(fn (Evento $e) => $e->fecha?->format('md') ?? '9999');

        return view('admin.eventos.index', ['eventos' => $eventos]);
    }

    public function create(): View
    {
        return view('admin.eventos.formulario', $this->datosFormulario(new Evento(['activo' => true, 'recurrente' => true])));
    }

    public function store(Request $request): RedirectResponse
    {
        $evento = $this->guardar($request, new Evento);

        return redirect()->route('admin.eventos.edit', $evento)->with('exito', 'Evento creado. Ya puedes agregarle fotos.');
    }

    public function edit(Evento $evento): View
    {
        $evento->load(['fotos', 'subcategorias']);

        return view('admin.eventos.formulario', $this->datosFormulario($evento));
    }

    public function update(Request $request, Evento $evento): RedirectResponse
    {
        $this->guardar($request, $evento);

        return back()->with('exito', 'Cambios guardados.');
    }

    public function destroy(Evento $evento): RedirectResponse
    {
        $evento->fotos->each->delete();
        $evento->delete();

        return redirect()->route('admin.eventos.index')->with('exito', "Se eliminó «{$evento->nombre}».");
    }

    private function datosFormulario(Evento $evento): array
    {
        return [
            'evento' => $evento,
            'categorias' => Categoria::with(['subcategorias' => fn ($q) => $q->orderBy('nombre')])->orderBy('orden')->get(),
        ];
    }

    private function guardar(Request $request, Evento $evento): Evento
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'alpha_dash', 'max:255', Rule::unique('eventos', 'slug')->ignore($evento->id)],
            'descripcion' => ['nullable', 'string'],
            'localizacion' => ['nullable', 'string'],
            'como_llegar' => ['nullable', 'string'],
            'actividades' => ['nullable', 'string'],
            'latitud' => ['nullable', 'required_with:longitud', 'numeric', 'between:-90,90'],
            'longitud' => ['nullable', 'required_with:latitud', 'numeric', 'between:-180,180'],
            'fecha' => ['nullable', 'date'],
            'periodo' => ['nullable', 'string', 'max:255'],
            'recurrente' => ['boolean'],
            'activo' => ['boolean'],
            'subcategorias' => ['array'],
            'subcategorias.*' => ['integer', 'exists:subcategorias,id'],
        ], [], [
            'como_llegar' => 'cómo llegar',
            'localizacion' => 'localización',
            'descripcion' => 'descripción',
        ]);

        if (empty($datos['slug'])) {
            $usados = Evento::whereKeyNot($evento->id)->pluck('slug')->flip()->map(fn () => true)->all();
            $datos['slug'] = Texto::slugUnico($datos['nombre'], $usados);
        }

        $evento->fill([
            ...collect($datos)->except('subcategorias')->all(),
            'activo' => $request->boolean('activo'),
            'recurrente' => $request->boolean('recurrente'),
        ]);
        $evento->save();
        $evento->subcategorias()->sync($datos['subcategorias'] ?? []);
        $evento->touch();

        return $evento;
    }
}
