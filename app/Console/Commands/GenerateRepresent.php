<?php

namespace App\Console\Commands;

use App\Represent\Models\RepAction;
use App\Represent\Models\RepColumn;
use App\Represent\Models\RepColumnOption;
use App\Represent\Models\RepColumnType;
use App\Represent\Models\RepModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class GenerateRepresent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'represent:generate ' .
        '{table : DB table name} ' .
        '{--r|represent= : Represent name} ' .
        '{--l|label= : Represent label} ' .
        '{--m|model= : Represent model path} ' .
        '{--c|controller= : Represent controller path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Store in DB represent of model/columns by given table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        //php artisan migrate:fresh --seed &&
        //php artisan represent:generate column_types --model="App\Represent\Models\RepColumnTypes" --controller=None &&
        //php artisan represent:generate models --model="App\Represent\Models\RepModel" --controller=None &&
        //php artisan represent:generate columns --model="App\Represent\Models\RepColumns" --controller=None  &&
        //php artisan represent:generate joins --model="App\Represent\Models\RepJoins" --controller=None &&
        //php artisan represent:generate wheres --model="App\Represent\Models\RepWheres" --controller=None &&
        //php artisan represent:generate actions --model="App\Represent\Models\RepActions" --controller=None &&
        //php artisan represent:generate column_options --model="App\Represent\Models\RepColumnOptions" --controller=None &&
        //php artisan represent:generate domains &&
        //php artisan represent:generate roles &&
        //php artisan represent:generate users

        $table = $this->argument('table');
        $model_name = $this->option('represent') ?? $table;

        // TODO avoid SQL injection
        $exist = DB::select("SHOW TABLES LIKE '{$table}'");

        if (count($exist) == 0) {
            $this->error("Can not find table with name: {$table}");
            return false;
        }

        $model_data = [
            'name'  => $model_name,
            'label' => preg_replace('/_/', ' ', Str::title($model_name)),
            'ref_table' => $table,
            'alias' => $table[0] . '1',
            'col_id' => 'id',
            'col_val' => 'name',
            'model' => $this->option('model')
                ?? 'App\\' . ucfirst(Str::camel(Str::singular($table))),
            'controller' => $this->option('controller')
                ?? 'App\\Http\\Controllers\\' . ucfirst(Str::camel(Str::singular($table))) . 'Controller',
        ];

        // TODO avoid SQL injection
        $fields = DB::select(DB::raw("SHOW FIELDS FROM {$table}"));

        $sort = 0;
        foreach ($fields as $field) {
            $columns_data[$field->Field] = [
                'type_id' => '1', // TextField
                'name' => $model_data['alias'] . '.' . $field->Field,
                'alias' => $field->Field,
                'label' => preg_replace('/_/', ' ', Str::title($field->Field)),
                'popup_values' => '',
                'sort' => $sort++,
                'singular' => '0',
                'required' => $field->Null == 'NO' ? 1 : 0,
                'orderable' => '1',
                'styles' => 'text-center text-nowrap',
                'rules' => ''
            ];

            if (preg_match('/^(text|varchar|char)(\((\d+)\))?$/', $field->Type, $matches)) {
                $columns_data[$field->Field]['rules'] = 'string' . (isset($matches[3]) ? "|max:{$matches[3]}" : '');
            } else if (preg_match('/^(([a-z]+)?int)(\((\d+)\))( unsigned)?$/', $field->Type, $matches)) {
                $columns_data[$field->Field]['rules'] = 'numeric' . (isset($matches[5]) ? "|min:0" : '');
                if ($field->Type == 'tinyint(1)') {
                    $columns_data[$field->Field]['type_id'] = 3; // Dropdown
                    $columns_data[$field->Field]['rules'] = 'boolean';

                }
            } else if (preg_match('/^timestamp$/', $field->Type, $matches)) {
                $columns_data[$field->Field]['rules'] = 'date_format:Y-m-d H:i:s';
                $columns_data[$field->Field]['type_id'] = 6; // DateTime
            }

            if ($field->Key == 'PRI') {
                $model_data['col_id'] = $field->Field;
                $columns_data[$field->Field]['rules'] = '';
                $columns_data[$field->Field]['required'] = 0;
            }
        }

        // TODO avoid SQL injection
        $schema = DB::select(DB::raw("SHOW CREATE TABLE {$table}"));
        preg_match_all(
            '/CONSTRAINT `.*` FOREIGN KEY \(`(.*)`\) REFERENCES `(.*)` \(`.*`\)/',
            ((array)$schema[0])['Create Table'],
            $matches
        );

        foreach ($matches[0] as $key => $match) {
            $columns_data[$matches[1][$key]]['popup_values'] = '@' . $matches[2][$key];
            $columns_data[$matches[1][$key]]['type_id'] = 2; // Dropdown
            $columns_data[$matches[1][$key]]['rules'] = '';
        }

        /*
         * Store columns for model
         */

        $model = RepModel::create($model_data);

        foreach ($columns_data as $name => $data) {
            $model->columns()->save(new RepColumn($data));
        }

        /*
         * Generate actions for model
         */

        $actions_data = [
            ['role_id' => 1, 'name' => 'view',   'state' => 1],
            ['role_id' => 1, 'name' => 'create', 'state' => 1],
            ['role_id' => 1, 'name' => 'edit',   'state' => 1],
            ['role_id' => 1, 'name' => 'delete', 'state' => 1],
        ];

        foreach ($actions_data as $data) {
            $model->actions()->save(new RepAction($data));
        }

        /*
         * Generate column options
         */

        $do_not_edit = ['id', 'updated_at', 'created_at',];

        foreach ($model->columns as $column) {


            $column->options()->save(new RepColumnOption([
                'role_id' => 1,
                'editable' => !in_array($column->alias, $do_not_edit),
                'visible' => 1,
            ]));
        }
    }
}
