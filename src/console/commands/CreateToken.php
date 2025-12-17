<?php

namespace Equidna\KeyGen\console\commands;

use Illuminate\Console\Command;
use Equidna\KeyGen\KeyGen;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

//laravel prompts
use function Laravel\Prompts\note;
use function Laravel\Prompts\text;
use function Laravel\Prompts\search;

class CreateToken extends Command
{
    protected $signature = 'generate-token';
    protected $description = 'generate token';

    public function handle()
    {
        note('Generacion de un token:');
        $nombre = text('Escribe el nombre del token:');
        $token = KeyGen::generateToken($nombre);
        $this->info("¡Listo! El token se genero correctamente << {$token->plainToken} >>");

        $models = $this->getModels();
        $selectedOption = search(
            label: 'Escribe el modelo a asociar',
            options: fn(string $value) => strlen($value) > 0
                ? collect($models)
                ->filter(fn($model) => Str::contains($model, $value, ignoreCase: true))
                ->values()
                ->all()
                : []
        );

        // $allRegisters = $selectedOption::all();
        $tableName = (new $selectedOption)->getTable();
        $columns = Schema::getColumnListing($tableName);
        $registerId = search(
            label: 'Escribe el registro a asociar',
            options: function (string $value) use ($tableName, $columns) {
                if (strlen($value) === 0) {
                    return [];
                }

                return DB::table($tableName)
                    ->whereAny($columns, 'like', '%' . $value . '%')
                    ->limit(10)
                    ->get()
                    ->mapWithKeys(function ($row) use ($columns) {
                        $displayValues = collect($columns)
                            ->map(fn($col) => $row->$col)
                            ->filter()
                            ->all();
                        $displayText = implode(' | ', $displayValues);
                        if (empty($displayText)) {
                            $displayText = "Registro sin datos visibles";
                        }

                        return [$row->{$columns[0]} => "$displayText"];
                    })
                    ->all();
            }
        );
        $register = $selectedOption::findOrFail($registerId);
        $token->attachToken($register);
        $this->info("¡Listo! El token se asigno correctamente al registro<< {$register} >>");
        return 0;
    }

    private function getModels(): Collection
    {
        $models = collect(File::allFiles(app_path()))
            ->map(function ($item) {
                $path = $item->getRelativePathName();
                $class = sprintf(
                    '\%s%s',
                    app()->getNamespace(),
                    strtr(substr($path, 0, strrpos($path, '.')), '/', '\\')
                );

                return $class;
            })
            ->filter(function ($class) {
                $valid = false;

                if (class_exists($class)) {
                    $reflection = new \ReflectionClass($class);
                    $valid = $reflection->isSubclassOf(Model::class) &&
                        !$reflection->isAbstract();
                }

                return $valid;
            });

        return $models->values();
    }
}
