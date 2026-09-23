<?php

namespace App\Console\Commands;

use App\Importacion\ImportadorDataset;
use App\Models\Atomo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\Console\Helper\ProgressBar;

class ImportarDataset extends Command
{
    protected $signature = 'dataset:importar
        {--sin-fotos : No copia ni procesa las fotos (mucho más rápido)}
        {--force : No pide confirmación si ya hay datos}';

    protected $description = 'Reconstruye el dataset desde DataSetA.xml y la carpeta del Prototipo 1';

    public function handle(): int
    {
        if (Atomo::query()->exists() && ! $this->option('force')
            && ! $this->confirm('La base ya tiene datos. Se borrarán átomos, eventos, fotos y categorías (los usuarios se conservan). ¿Continuar?')) {
            return self::FAILURE;
        }

        $this->info('Fuente XML: '.config('dataset.fuente_xml'));
        $this->info('Prototipo 1: '.config('dataset.fuente_legado'));

        /** @var ProgressBar|null $barra */
        $barra = null;
        $etapaActual = null;

        $reporte = (new ImportadorDataset(! $this->option('sin-fotos')))->importar(
            function (string $etapa, int $actual, int $total) use (&$barra, &$etapaActual) {
                if ($etapa !== $etapaActual) {
                    $barra?->finish();
                    $this->newLine();
                    $this->line("<comment>{$etapa}</comment>");
                    $barra = $this->output->createProgressBar($total);
                    $etapaActual = $etapa;
                }
                $barra->setProgress($actual);
            }
        );

        $barra?->finish();
        $this->newLine(2);

        Cache::flush();

        $this->table(['Concepto', 'Total'], [
            ['Átomos', $reporte->contador('atomos')],
            ['Eventos', $reporte->contador('eventos')],
            ['Fotos procesadas', $reporte->contador('fotos')],
            ['Fotos no encontradas', $reporte->contador('fotos_no_encontradas')],
            ['Palabras en el diccionario de acentos', $reporte->contador('palabras_en_diccionario')],
            ['Correcciones automáticas', count($reporte->entradas()) - $reporte->porRevisar()],
            ['Puntos por revisar', $reporte->porRevisar()],
        ]);

        $this->info('Reporte completo: '.storage_path('app/reportes/importacion.csv'));

        return self::SUCCESS;
    }
}
