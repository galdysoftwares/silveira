<?php declare(strict_types = 1);

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class ArrayHelper
{
    public static function chunkFile(string $path, callable $generator, int $chunkSize = 1000): \Generator
    {
        // Abrindo o arquivo
        $file = fopen($path, 'r');
        // Inicializando o array de dados
        $data = [];

        // Lendo o arquivo usar ($row = fgetcsv($file, null, ',')) ou $line = fgetcsv($file) e incrementando o contador ($ii++)
        for ($ii = 0; ($row = fgetcsv($file, null, ',')); $ii++) {
            // Adicionando a linha ao array de dados
            $data[] = $row;

            // Verificando se o array de dados atingiu o tamanho do chunk
            if ($ii % $chunkSize === 0) {
                // Retornando o chunk de dados
                yield $generator($data);
                // Resetando o array de dados
                $data = [];
            }
        }

        // Verificando se ainda há dados no array
        if (!empty($data)) {
            // Retornando o último chunk de dados
            yield $generator($data);
        }

        // Fechando o arquivo
        fclose($file);
    }

    public static function bulkInsertExample()
    {
        //DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // Desabilita as chaves estrangeiras É PERIGOSO
        //DB::statement('ALTER TABLE table_name DISABLE KEYS;');
        $path        = storage_path('app/file.csv');
        $generatoRow = function ($row) {
            return [
                'name'  => $row[0],
                'email' => $row[1],
            ];
        };
        $generator = ArrayHelper::chunkFile($path, $generatoRow, 1000);

        foreach ($generator as $chunk) {
            GaugeReading::insert($chunk); /** @phpstan-ignore-line */
        }
        //DB::statement('ALTER TABLE table_name ENABLE KEYS;');
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $path = DB::getPdo()->quote($path);

        DB::statement("
            LOAD DATA LOCAL INFILE '{$path}'
            INTO TABLE table_name
            FIELDS TERMINATED BY ','
            LINES TERMINATED BY '\n'
            (column1, column2, column3)
        ");
    }
}
