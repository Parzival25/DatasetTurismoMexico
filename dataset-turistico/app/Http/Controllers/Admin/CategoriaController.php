<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Subcategoria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoriaController extends Controller
{
    public const ICONOS = ['sol', 'deporte', 'hoja', 'columna', 'engrane', 'calendario', 'info', 'punto'];

    public function index(): View
    {
        return view('admin.categorias.index', [
            'categorias' => Categoria::orderBy('orden')
                ->withCount('atomos')
                ->with(['subcategorias' => fn ($q) => $q->withCount(['atomos', 'eventos'])->orderBy('id')])
                ->get(),
            'iconos' => self::ICONOS,
        ]);
    }

    public function actualizar(Request $request, Categoria $categoria): RedirectResponse
    {
        $categoria->update($request->validate([
            'nombre' => ['required', 'string', 'max:120'],
            'descripcion' => ['nullable', 'string', 'max:500'],
            'color' => ['required', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'icono' => ['required', 'in:'.implode(',', self::ICONOS)],
        ]));

        return back()->with('exito', "Categoría «{$categoria->nombre}» actualizada.");
    }

    public function crearSubcategoria(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'categoria_id' => ['required', 'exists:categorias,id'],
            'nombre' => ['required', 'string', 'max:120'],
        ]);

        $subcategoria = Subcategoria::create($datos + [
            'id' => (Subcategoria::max('id') ?? 0) + 1,
            'slug' => $this->slugDisponible($datos['nombre']),
        ]);

        return back()->with('exito', "Subcategoría «{$subcategoria->nombre}» creada con el código C2 {$subcategoria->id}.");
    }

    public function actualizarSubcategoria(Request $request, Subcategoria $subcategoria): RedirectResponse
    {
        $subcategoria->update($request->validate([
            'categoria_id' => ['required', 'exists:categorias,id'],
            'nombre' => ['required', 'string', 'max:120'],
        ]));

        return back()->with('exito', "Subcategoría «{$subcategoria->nombre}» actualizada.");
    }

    private function slugDisponible(string $nombre): string
    {
        $base = Str::slug($nombre);
        $slug = $base;
        for ($i = 2; Subcategoria::where('slug', $slug)->exists(); $i++) {
            $slug = "{$base}-{$i}";
        }

        return $slug;
    }
}
