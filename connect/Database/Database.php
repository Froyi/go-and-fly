<?php
class Database
{
    const DATABASE_CONNECTION = [
        'local' => [
            'host' => 'localhost',
            'database' => 'goandfly',
            'user' => 'root',
            'password' => ''
        ],
        'live' => [
            'host' => 'localhost',
            'database' => 'goandfly',
            'user' => 'root',
            'password' => ''
        ]
    ];

    /** local | live */
    const MODUS = 'local';

    /** @var  string $host */
    protected $host;

    /** @var  string $user */
    protected $user;

    /** @var  string $password */
    protected $password;

    /** @var  string $database */
    protected $database;

    /** @var  array $query */
    protected $query;

    /** @var \PDO $connection */
    protected $connection;

    /**
     * Database constructor.
     */
    public function __construct()
    {
        $connection = self::DATABASE_CONNECTION[self::MODUS];

        $this->host = $connection['host'];
        $this->user = $connection['user'];
        $this->password = $connection['password'];
        $this->database = $connection['database'];

        $this->connect();
    }

    /**
     *
     */
    public function connect(): void
    {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->database;
        $this->connection = new PDO($dsn, $this->user, $this->password);
    }

    /**
     * @param string $table
     * @return Query
     */
    public function getNewSelectQuery(string $table): Query
    {
        $query = new Query($table);
        $query->addType(Query::SELECT);

        return $query;
    }

    /**
     * @param string $table
     * @return Query
     */
    public function getNewUpdateQuery(string $table): Query
    {
        $query = new Query($table);
        $query->addType(Query::UPDATE);

        return $query;
    }

    /**
     * @param string $table
     * @return Query
     */
    public function getNewInsertQuery(string $table): Query
    {
        $query = new Query($table);
        $query->addType(Query::INSERT);

        return $query;
    }

    public function getNewDeleteQuery(string $table): Query
    {
        $query = new Query($table);
        $query->addType(Query::DELETE);

        return $query;
    }


    /**
     * @param Query $query
     * @return array
     */
    public function fetchAll(Query $query): array
    {
        $sql = $this->connection->query($query->getQuery());

        return $sql->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param Query $query
     * @return mixed
     */
    public function fetch(Query $query)
    {
        $sql = $this->connection->query($query->getQuery());

        return $sql->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * @param Query $query
     * @return bool
     */
    public function execute(Query $query): bool
    {
        $sql = $this->connection->prepare($query->getQuery());

        return $sql->execute();
    }
}