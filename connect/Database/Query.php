<?php

/**
 * Class Query
 *
 * TYPE | TABLE | WHERE | ORDER | LIMIT
 *
 * @package Project\Module\Database
 */
class Query
{
    const SELECT = 'SELECT ';
    const UPDATE = 'UPDATE ';
    const INSERT = 'INSERT INTO ';
    const DELETE = 'DELETE ';
    const FROM = 'FROM ';
    const WHERE = 'WHERE ';
    const AND = 'AND ';
    const OR = 'OR ';
    const LIMIT = 'LIMIT ';
    const ORDERBY = 'ORDER BY ';
    const ASC = 'ASC';
    const DESC = 'DESC';
    const SET = 'SET ';
    const VALUES = 'VALUES';

    /** @var array $tableArray */
    protected $tableArray = [];

    /** @var  string $type */
    protected $type;

    /** @var array $entityArray */
    protected $entityArray = [];

    /** @var  string $where */
    protected $where;

    /** @var  string $orderBy */
    protected $orderBy;

    /** @var  string $limit */
    protected $limit;

    /** @var  string $set */
    protected $set;

    /** @var array $insert */
    protected $insert = [];

    /**
     * Query constructor.
     * @param string $table
     */
    public function __construct(string $table)
    {
        $this->addTable($table);
    }

    public function addType(string $type): void
    {
        $this->type = $type;
    }

    public function addEntityToType(string $entity): void
    {
        $this->entityArray[] = $entity;
    }

    public function addTable(string $table): void
    {
        $this->tableArray[] = $table;
    }

    public function where(string $entity, string $operator, $value): void
    {
        if (is_string($value) === true) {
            $value = '\'' . $value . '\'';
        }

        $this->where .= self::WHERE . $entity . ' ' . $operator . ' ' . $value . ' ';
    }

    public function andWhere(string $entity, string $operator, $value): void
    {
        if (is_string($value) === true) {
            $value = '\'' . $value . '\'';
        }

        $this->where .= self:: AND . $entity . ' ' . $operator . ' ' . $value . ' ';
    }

    public function orWhere(string $entity, string $operator, $value): void
    {
        if (is_string($value) === true) {
            $value = '\'' . $value . '\'';
        }

        $this->where .= self:: OR . $entity . ' ' . $operator . ' ' . $value . ' ';
    }

    public function set(string $entity, $value = null): void
    {
        if (is_string($value) === true) {
            $value = '\'' . $value . '\'';
        }
        if (!empty($this->set)) {
            $this->set .= ', ';
        }
        if ($value === null) {
            $this->set .= $entity . ' = null ';
        } else {
            $this->set .= $entity . ' = ' . $value . ' ';
        }
    }

    public function insert(string $entity, $value = null): void
    {
        if (!isset($this->insert[$entity])) {
            $this->insert[$entity] = $value;
        }
    }

    public function limit(int $limit): void
    {
        $this->limit = self::LIMIT . $limit;
    }

    public function orderBy(string $entity, string $order): void
    {
        $this->orderBy = self::ORDERBY . ' ' . $entity . ' ' . $order . ' ';
    }

    public function getQuery(): string
    {
        $queryString = '';

        switch ($this->type) {
            case self::SELECT:
                $queryString .= self::SELECT . $this->getEntities();
                $queryString .= self::FROM . $this->getTables();
                $queryString .= $this->where;
                $queryString .= $this->orderBy;
                $queryString .= $this->limit;
                break;
            case self::UPDATE:
                $queryString .= self::UPDATE . $this->getTables();
                $queryString .= self::SET . $this->set;
                $queryString .= $this->where;
                break;
            case self::INSERT:
                $queryString .= self::INSERT . $this->getTables();
                $queryString .= $this->getInserts();
                break;
            case self::DELETE:
                $queryString .= self::DELETE . self::FROM . $this->getTables();
                $queryString .= $this->where;
        }

        return $queryString;
    }

    protected function getEntities(): string
    {
        $entities = '* ';

        if (empty($this->entityArray)) {
            return $entities;
        }

        return implode(',', $this->entityArray) . ' ';
    }

    /**
     * @return string
     */
    protected function getTables(): string
    {
        if (empty($this->tableArray)) {
            throw new \RuntimeException('Es wurde keine Tabelle angegeben!');
        }

        return implode(',', $this->tableArray) . ' ';
    }

    /**
     * @return string
     */
    protected function getInserts(): string
    {
        $entities = '';
        $values = '';
        foreach ($this->insert as $entity => $value) {
            if (!empty($entities)) {
                $entities .= ', ';
                $values .= ', ';
            }

            $entities .= $entity;

            if (is_string($value) === true) {
                $value = '\'' . $value . '\'';
            }

            if ($value === null) {
                $value = 'null';
            }
            $values .= $value;
        }

        return "(" . $entities . ") " . self::VALUES . "(" . $values . ")";
    }
}