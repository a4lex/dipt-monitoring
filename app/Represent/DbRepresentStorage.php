<?php


namespace App\Represent;

use DB;
use Exception;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class DbRepresentStorage extends AbstractRepresentStorage
{
    const conf_key = 'represent.table.';

    protected $used_aliases = [];

    public $actions = [];

    function __construct($ident)
    {
        parent::__construct();

        $model = $this->getModel($ident, '');

        $this->name = $model['name'];
        $this->alias = $model['alias'];
        $this->label = $model['label'];
        $this->model = $model['model'];
        $this->col_id = $model['col_id'];
        $this->col_val = $model['col_val'];
        $this->columns = $model['columns'];
        $this->actions = $model['actions'];

        $this->query =  $this->query->table($model['ref_table'], $model['alias']);

        $this->init($model);

    }

    /**
     * Return id column name with table alias prefix
     *
     * @return string
     */
    public function getPrefIdColAlias(): string
    {
        return "{$this->alias}.{$this->col_id}";
    }

    /**
     * Return value column name with table alias prefix
     *
     * @return string
     */
    public function getPrefValColAlias(): string
    {
        return "{$this->alias}.{$this->col_val}";
    }

    /**
     * Return view name for column
     *
     * @param $columnName
     * @return string
     */
    public function getColumnViewName($columnName)
    {
        return $this->columns[$columnName]['view'] ?? '';
    }

    /**
     * Return table-represent view name for column
     *
     * @param $columnName
     * @return string
     */
    public function getTableViewName($columnName)
    {
        return $this->getColumnViewName($columnName) . '-table' ?? '';
    }

    public function getInstance()
    {
        return new $this->model;
    }

    public function can($action)
    {
        return $this->actions[$action] ?? false;
    }

    public function canAny($actions)
    {
        foreach ($actions as $action) {
            if ($this->can($action)) {
                return true;
            }
        }

        return false;
    }

    protected function init($model)
    {
        if ($this->inited)
            return;

        foreach ($model['joins'] as $join) {
            $this->query->join(...$join);
        }

        foreach ($model['wheres'] as $where) {
            $this->query->where(...$where);
        }

        foreach ($model['columns'] as $col) {

            if (Str::startsWith($col['popup_values'], '@')) {

                $subModel = self::getModel($col['popup_values']);

                $this->query->addSelect("{$subModel['alias']}.{$subModel['col_val']} as {$col['alias']}");
                $this->query->addSelect("{$subModel['alias']}.{$subModel['col_id']} as {$col['alias']}_key");

                $this->query->join(
                    "{$subModel['ref_table']} as {$subModel['alias']}",
                    "{$subModel['alias']}.{$subModel['col_id']}",
                    '=', "{$col['name']}"
                );
            } else {
                // TODO Bad style, we should create some another method to make cast
                switch ($col['type_id']) {
                    case '9':
                        $this->query->addSelect(DB::raw("INET_NTOA({$col['name']}) as {$col['alias']}"));
                        break;
                    default:
                        $this->query->addSelect(DB::raw("{$col['name']} as {$col['alias']}"));
                }
            }
        }

        // TODO we need it to prevent situaltion when use dynamic join's columns
        $this->query->joins = array_reverse($this->query->joins ?? []);

        // TODO think about
        // Can be trouble in future and maybe - slow query
        // Need for multi-select from pivote tables and GROUP_CONCAT
        $this->query->groupBy($this->col_id);
//        dd($model, $this->query->toSql());

        $this->inited=true;
    }

    /**
     * Search model in DB by id, name or class
     *
     * @param $ident
     * @return object|null
     * @throws Exception
     */
    protected function getModel($ident, $alias = '')
    {
        // @ - join one to one
        // [] - multiple join through pivot table

        if (preg_match('/^(@|\[\])([\w\-]+)(:([\w\-]+))?$/', $ident, $matches)) {
            $ident = $matches[2];
            $alias = $matches[4] ?? '';
        }

        $model = \App\Represent\Models\RepModel::where(
            (function ($ident) {
                if     (is_int($ident))     { return [['id', '=', $ident]]; }
                elseif (is_string($ident))  { return [['name', '=', $ident]]; }
                else                        { throw new Exception("Unknown identity for search represent in DB"); }
            })($ident))
            ->with([
                'joins',

                'columns' => function($query) {
                    $query->with([
                        'type' => function($query) { },
                        'options' => function($query) {
                            $query->where('column_options.role_id', '=', auth()->user()->role_id);
                        },
                        'visibility' => function($query) {
                            $query->where('column_visibility.user_id', '=', auth()->user()->id);
                        },
                    ])->orderBy('sort');
                },
                'actions' => function($query) {
                    $query->where('actions.role_id', '=', auth()->user()->role_id);
                },
                'wheres' => function($query) {
                    $query->whereIn('wheres.role_id', [0,1]);
                },
            ])
            ->first();

        if (!$model) throw new Exception("Can not find represent in DB by identity: " . strval($ident));

        $model = $model->toArray();

        /*
         * For dynamic joins we need check that we have unique alias
         * For example we can pick something from user table,
         * but it can have reference to the same user-table
         */
        $alias2change = [];

        if ($alias === '') {
            $model['alias'] = $this->getUniqueAlias($model['alias'], $alias2change);
        } else {

            if (in_array($alias, $this->used_aliases)) {
                throw new Exception("Can not use alias: {$alias} - it already in use");
            }

            $alias2change[$model['alias']] = $alias;
            $model['alias'] = $alias;
        }

        $changePref = $this->changeTablePrefix($alias2change);

        /*
         * Prepare joins
         */
        $tmpJoins = [];
        foreach ($model['joins'] as $join) {
            $join['alias'] = $this->getUniqueAlias($join['alias'], $alias2change);

            $tmpJoins[] = [
                "{$join['ref_table']} as {$join['alias']}",
                $changePref($join['col_a']), $join['mode'],
                $changePref($join['col_b']), $join['type'],
            ];
        }
        $model['joins'] = $tmpJoins;

        $model['columns'] = $this->prepareColumns($model['columns'], $changePref);

        $model['wheres'] = $this->prepareWheres($model['wheres'], $changePref);

        $model['actions'] = $this->prepareActions($model['actions']);

//        dd($model);

        return $model;
    }

    /**
     * Replace table prefix in column
     *
     * @param $aliases2change
     * @return \Closure
     */
    protected function changeTablePrefix($aliases2change)
    {
        return function ($colName) use ($aliases2change) {
            if (count($aliases2change) && preg_match('/([\w]+)\.([\w\-]+)/', $colName, $match)) {
                if (array_key_exists($match[1], $aliases2change)) {
                    return $aliases2change[$match[1]] . '.' . $match[2];
                }
            }

            return $colName;
        };
    }

    /**
     * Return uniq alias (that not in use yet)
     *
     * @param string $alias
     * @param array $alias2change
     * @return string
     * @throws Exception
     */
    protected function getUniqueAlias(string $alias, array &$alias2change) : string
    {
        $cast_alias = $alias;
        while (in_array($cast_alias, $this->used_aliases)) {
            // TODO /^(\w+)(\d+)$/ -- not cool, need think
            if(preg_match('/^(\w+)(\d+)$/', $cast_alias, $math)) {
                $cast_alias = $math[1] . ($math[2] + 1);
            }
        }

        if (array_key_exists($cast_alias, $alias2change))
            throw new Exception("Same alias: {$cast_alias} already exist");

        $alias2change[$alias] = $cast_alias;
        $this->used_aliases[] = $cast_alias;

        return $cast_alias;
    }

    protected function prepareColumns($columns, $changePref)
    {
        return array_reduce($columns,
            function ($result, $column) use ($changePref) {
                $column['sql_id'] = $column['id'];
                $column['name'] = $changePref($column['name']);
                $column['editable'] = $column['options'][0]['editable'] ?? false;
                $column['visible'] = $column['visibility'][0]['visible'] ?? true;
                $column['view'] = $column['type']['view'] ?? 'unknown';
                unset($column['visibility']);
                unset($column['options']);
                unset($column['type']);
                $result[$column['alias']] = $column;
                return $result;
            }, array()
        );
    }

    protected function prepareWheres($wheres, $changePref)
    {
        return array_map(function ($where) use ($changePref){
            return [$changePref($where['col_a']), $where['mode'], $changePref($where['col_b'])];
        }, $wheres);
    }

    protected function prepareActions($actions)
    {
        return array_reduce($actions,
            function ($result, $action) {
                $result[$action['name']] = $action['state'] ?? 0;
                return $result;
            }, ['create' => 0, 'view' => 0, 'edit' => 0, 'delete' => 0]
        );
    }
}
