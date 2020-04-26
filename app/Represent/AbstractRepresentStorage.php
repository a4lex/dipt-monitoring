<?php


namespace App\Represent;

use DB;
use Exception;


abstract class AbstractRepresentStorage
{


    public $label;

    public $name;

    public $columns = [];

    public $query;

    protected $inited;

    protected $used_aliases = [];

    protected $table;

    protected $alias;

    public $model;

    protected $controller;

    public $col_id;

    public $col_val;


    protected function __construct()
    {
        $this->query = app('db')->connection();
        $this->inited = false;
    }

    /**
     * Proxy non existing method calls to builder class.
     *
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws Exception
     */

    public function __call($name, $arguments)
    {
        if (method_exists($this->query, $name)) {

            if (!$this->inited) $this->init(0);

            return call_user_func_array([$this->query, $name], $arguments);
        } else {
            throw new Exception("Method {$name} does not exist");
        }
    }

    /**
     * Get attributes from builder instance.
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->query->__get($name);
    }

    /**
     * @param $table
     * @param null $alias
     * @return mixed
     */
    protected function table($table, $alias = null)
    {
        if ($alias) $this->used_aliases[] = $alias;

        $this->query =  $this->query->table($table, $alias);

        return $this->query;
    }

    public function find($id) {
        return $this->query->where($this->getPrefIdColName(), '=', $id);
    }

    public function exists($id): bool
    {
//        if (! $this->inited) {
//            $this->newInit($model);
//        }

        // TODO need think about
        //https://stackoverflow.com/questions/30235551/laravel-query-builder-re-use-query-with-amended-where-statement
        $tmpQuery = clone $this->query;

        return $tmpQuery->where($this->getPrefIdColAlias(), $id)
            ->exists();
    }


//    abstract protected function init(int $id);




    /**
     * Factory method, create and return an instance for the Represent Storage engine.
     *
     * @param $source
     * @return static
     */
    public static function create($source)
    {
        return new static($source);
    }

    /***
     * Convert columns name to aliase with writespace
     *
     * @param string $name
     * @return string
     */
    public static function name2alias (string $name)
    {
        return preg_replace('/^([\w\d]+)(\.)(.+)$/', '$1_$3', $name);
    }

    /***
     * Convert columns aliase to name
     *
     * @param  string  $alias
     * @return string
     */
    public static function alias2name (string $alias)
    {
        return preg_replace('/^([\w\d]+)(\_)(.+)$/', '$1.$3', $alias);
    }


//    abstract public function getPrefIdColAlias(): string;
//    abstract public function getPrefValColAlias(): string;

    public function getPrefIdColName()
    {
        return "{$this->alias}.{$this->col_id}";
    }

    public function getPrefValColName()
    {
        return "{$this->alias}.{$this->col_val}";
    }



}
