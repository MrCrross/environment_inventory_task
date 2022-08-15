<?php

namespace App\Modules;

use App\Modules\Interfaces\DatabaseMethods;
use PDO;

class Database implements DatabaseMethods
{
    public PDO $connect;
    protected string $table;
    private string $select = '*';
    /**
     * @var string
     */
    private string $join = '';
    /**
     * @var string
     */
    private string $where = '';
    /**
     * @var string
     */
    private string $orderBy = '';
    /**
     * @var string
     */
    private string $limit = '';
    /**
     * @var string
     */
    private string $offset = '';

    private array $operators = ['=', '!=', '<', '>', '<=', '>=', '<>', 'LIKE'];

    protected bool $deleted_at = false;
    protected bool $timestamps = false;

    private bool $query = false;
    private ?object $paginate = null;

    public function __construct()
    {
        try {
            $this->connect = new PDO(DBDRIVER . ':host=' . DBHOST . ';dbname=' . DBNAME . ';charset=' . DBCHARSET . ';', DBUSER, DBPASS);
        } catch (\PDOException $e) {
            die('Нет подключения к базе данных. ' . $e);
        }
        return $this->connect;
    }

    /**
     * @param array $select
     * @return $this
     */
    public function setSelect(array $select): Database
    {
        $this->select= implode(', ',$select);
        return $this;
    }

    public function table(array $table): Database
    {
        $from = '';
        foreach ($table as $key) {
            $from .= $key . ',';
        }
        $this->table = rtrim($from, ',');
        return $this;
    }

    /**
     * @param string $table
     * @param string $col1
     * @param string $operator
     * @param string $col2 Столбец, с которым присоединять
     * @param string $type Тип join INNER, LEFT, RIGHT, LEFT OUTER, RIGHT OUTER
     * @return Database
     */
    public function join(string $table, string $col1, string $operator, string $col2, string $type = 'INNER'): Database
    {
        if (!in_array($operator, $this->operators)) {
            $operator = '=';
        }
        $this->join .= " {$type} JOIN {$table} on {$col1} {$operator} {$col2} ";
        return $this;
    }

    /**
     * @param string $col1
     * @param string $operator
     * @param string $col2
     * @param string $type 'NOT' или ''
     * @param string $andOr 'AND','OR'
     * @return $this
     */
    public function where(string $col1, string $operator, string $col2, string $type = '', string $andOr = 'AND'): Database
    {
        if (!in_array($operator, $this->operators)) {
            $operator = '=';
        }
        if ($this->where !== '') {
            $this->where .= $andOr;
        }
        $this->where .= " {$type} {$col1} {$operator} {$this->checkData($col2)} ";

        return $this;
    }

    /**
     * @param string $col1
     * @param array $keys
     * @param string $type
     * @param string $andOr
     * @return $this
     */
    public function whereIn(string $col1, array $keys,string $type="", string $andOr = 'AND'): Database
    {
        $_keys=[];
        foreach ($keys as $val){
            $_keys[]=is_numeric($val)?$val:$this->checkData($val);
        }
        if ($this->where !== '') {
            $this->where .= $andOr;
        }
        $this->where .= " {$col1} {$type} IN (".implode(", ",$_keys).") ";

        return $this;
    }

    public function orderBy(string $orderBy, string $sort = 'ASC'): Database
    {
        $this->orderBy = $this->orderBy !== '' ? $this->orderBy . " , " . $orderBy . " " . $sort : $orderBy . " " . $sort;
        return $this;
    }

    /**
     * @param int $limit
     * @param int|null $limitEnd
     * @return $this
     */
    public function limit(int $limit, int $limitEnd = null): Database
    {
        $this->limit = !is_null($limitEnd) ? $limit . "," . $limitEnd : $limit;
        return $this;
    }

    /**
     * @param int $offset
     * @return $this
     */
    public function offset(int $offset): Database
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * @param string $column
     * @return Database
     */
    public function count(string $column): Database
    {
        $this->select="COUNT({$column}) AS count_{$column}";
        return $this;
    }

    /**
     * @param int $count
     * @return array|false|string
     */
    public function pagination(int $count)
    {
        $page = 0;
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        }
        $page=$page > 0 ? $page : 1;
        $this->limit = $count;
        $this->offset = ($page - 1) * $count;
        $this->paginate = (object)[
            'current_page' => $page,
            'perv_page' => ($page - 1) <= 0 ? 1 : $page - 1,
            'next_page' => $page + 1,
            'data' => null,
            'count'=>$count
        ];
        return $this->select();
    }

    /**
     * @param string $query
     * @return array|false
     */
    public function fetchAll(string $query)
    {
        if ($this->query) {
            return $query;
        }
        $stmt = $this->connect->prepare($query);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        if (!is_null($this->paginate)) {
            $last_page =intval(intval((new self())->table([$this->table])->count('id')->select()[0]->count_id)/$this->paginate->count);
            $this->paginate->data=$data;
            $this->paginate->last_page=$last_page===0?1:$last_page;
            if($this->paginate->next_page>$this->paginate->last_page){
                $this->paginate->next_page=$this->paginate->last_page;
            }
            $data =$this->paginate;
        }
        $this->reset();
        return $data;
    }

    public function exec(string $query)
    {
        if ($this->query) {
            return $query;
        }
        $status = $this->connect->exec($query);
        if (!$status) {
            $info = $this->connect->errorInfo();
            throw new \PDOException($info[2],$info[1]);
        }
        return $this->connect->lastInsertId();
    }

    public function insert(array $data)
    {
        $query = "INSERT INTO {$this->table}";
        $values = array_values($data);
        if (isset($values[0]) && (is_array($values[0]) or is_object($values[0]))) {
            $values[0]=(array)$values[0];
            $column = implode(', ', array_keys($values[0]));
            $query .= " ( {$column} ) VALUES ";
            foreach ($values as $value) {
                $value=(array)$value;
                $val = implode(', ', array_map([$this, 'checkData'], $value));
                $query .= "({$val}), ";
            }
            $query = trim($query, ', ');
        } else {
            $column = implode(', ', array_keys($data));
            $val = implode(', ', array_map([$this, 'checkData'], $data));
            $query .= "( {$column} ) VALUES ({$val})";
        }

        return $this->exec($query);
    }

    protected function checkData($data)
    {
        return $data === null ? 'NULL' : (
        is_int($data) || is_float($data) ? $data : $this->connect->quote($data));
    }

    /**
     * @return array|false
     */
    public function select()
    {

        $query = "SELECT {$this->select} FROM {$this->table}";
        if ($this->join !== '') {
            $query .= $this->join;
        }
        if ($this->where !== '') {
            $query .= " WHERE " . $this->where;
        }
        if ($this->deleted_at) {
            $query .= $this->where !== '' ? " AND {$this->table}.deleted_at is null" : " WHERE {$this->table}.deleted_at is null";
        }
        if ($this->orderBy !== '') {
            $query .= " ORDER BY " . $this->orderBy;
        }
        if ($this->limit !== '') {
            $query .= " LIMIT " . $this->limit;
        }
        if ($this->offset !== '') {
            $query .= " OFFSET " . $this->offset;
        }

        return $this->fetchAll($query);
    }

    public function update(array $data)
    {
        $query = "UPDATE {$this->table} SET ";
        $values = [];
        foreach ($data as $column => $val) {
            $values[] = "{$column} = {$this->checkData($val)}";
        }
        if ($this->timestamps) {
            $values[] = "updated_at = now()";
        }
        $query .= implode(", ", $values);
        if ($this->where !== '') {
            $query .= " WHERE " . $this->where;
        }

        return $this->exec($query);
    }

    public function delete()
    {
        if ($this->deleted_at) {
            return $this->update([
                'deleted_at' => date('Y-m-d H:i:s')
            ]);
        }
        $query = "DELETE FROM {$this->table} ";
        if ($this->where !== '') {
            $query .= " WHERE " . $this->where;
        }
        if ($this->query) {
            return $query;
        }
        $status=$this->connect->exec($query);
        if (!$status) {
            $info = $this->connect->errorInfo();
            throw new \PDOException($info[2],$info[1]);
        }
        return $status;
    }

    public function query(): Database
    {
        $this->query = true;
        return $this;
    }

    public function reset()
    {
        $this->select = '*';
        $this->join = '';
        $this->where = '';
        $this->limit = '';
        $this->offset = '';
        $this->orderBy = '';
        $this->paginate = null;
        $this->query = false;
    }
}