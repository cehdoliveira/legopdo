<?php
class local_pdo extends PDO
{
    public function __construct($sys = NULL)
    {
        $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8', constant('cHStr'), constant('cBancoStr'));
        $user = constant('cUserStr');
        $pass = constant('cPassStr');
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        ];
        try {
            parent::__construct($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            die('Erro de conexÃ£o: ' . $e->getMessage());
        }
    }

    public function select(string $fields, string $table, string $options = ''): PDOStatement|false
    {
        $sql = sprintf("SELECT %s FROM %s %s", $fields, $table, $options);
        return $this->my_query($sql);
    }

    public function insert(string $fields, string $table, string $options = ""): PDOStatement|false
    {
        $sql = sprintf("INSERT INTO %s SET %s %s", $table, $fields, $options);
        try {
            $this->beginTransaction();
            $result = $this->my_query($sql);
            $this->commit();
            return $result;
        } catch (PDOException $e) {
            $this->rollBack();
            die("SQL error: $sql \n " . $e->getMessage());
        }
    }

    public function replace(string $fields, string $table): PDOStatement|false
    {
        $sql = sprintf("REPLACE INTO %s SET %s", $table, $fields);
        try {
            $this->beginTransaction();
            $result = $this->my_query($sql);
            $this->commit();
            return $result;
        } catch (PDOException $e) {
            $this->rollBack();
            die("SQL error: $sql \n " . $e->getMessage());
        }
    }

    public function update(string $fields, string $table, string $options = ''): PDOStatement|false
    {
        $sql = sprintf("UPDATE %s SET %s %s", $table, $fields, $options);
        try {
            $this->beginTransaction();
            $result = $this->my_query($sql);
            $this->commit();
            return $result;
        } catch (PDOException $e) {
            $this->rollBack();
            die("SQL error: $sql \n " . $e->getMessage());
        }
    }

    public function delete(string $table, string $options = ''): PDOStatement|false
    {
        $sql = sprintf("DELETE FROM %s %s", $table, $options);
        try {
            $this->beginTransaction();
            $result = $this->my_query($sql);
            $this->commit();
            return $result;
        } catch (PDOException $e) {
            $this->rollBack();
            die("SQL error: $sql \n " . $e->getMessage());
        }
    }

    public function my_query(string $query): PDOStatement|false
    {
        try {
            return $this->query($query);
        } catch (PDOException $e) {
            die("SQL error: $query \n " . $e->getMessage());
        }
    }

    public function recordcount($res): int
    {
        return ($res instanceof PDOStatement) ? $res->rowCount() : 0;
    }

    public function result($res, $name, $position)
    {
        if ($res === false) return false;
        $res->execute();
        $rows = $res->fetchAll();
        if ($position >= count($rows)) return false;
        return $rows[$position][$name] ?? false;
    }

    public function results($res): array
    {
        if ($res instanceof PDOStatement) {
            return $res->fetchAll();
        }
        return [];
    }

    public function fields_config(string $table): array
    {
        $object = [];
        $res = $this->my_query(sprintf("SHOW COLUMNS FROM %s", $table));
        foreach ($this->results($res) as $data) {
            if ($data["Key"] === "PRI") {
                $object[$data["Field"]]["PK"] = true;
            }
            if ($data["Key"] === "UNI") {
                $object[$data["Field"]]["UNI"] = true;
            }
            if (preg_match("/(?P<TYPE>\w+)\((?P<SIZE>.+)\)/", $data["Type"], $match)) {
                $object[$data["Field"]]["type"] = $match["TYPE"];
                $object[$data["Field"]]["size"] = $match["SIZE"];
            } else {
                $object[$data["Field"]]["type"] = $data["Type"];
            }
            if ($data["Default"] !== null) {
                $object[$data["Field"]]["default"] = $data["Default"];
            }
            if ($data["Extra"] === "auto_increment") {
                $object[$data["Field"]]["auto_increment"] = true;
            }
        }
        return $object;
    }

    public function real_escape_string($value): string
    {
        return $this->quote($value);
    }
}
