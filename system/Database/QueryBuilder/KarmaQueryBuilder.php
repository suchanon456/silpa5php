<?php
/**
 * KarmaQueryBuilder - Query ที่บันทึกกรรม
 * 
 * สร้าง query ด้วยความรู้สึกและบันทึกการกระทำทั้งหมด
 */

namespace System\Database\QueryBuilder;

class KarmaQueryBuilder
{
    /**
     * เก็บ SQL query
     */
    protected $query = '';

    /**
     * เก็บ bindings
     */
    protected $bindings = [];

    /**
     * บันทึกการกระทำ
     */
    protected $actionLog = [];

    /**
     * สร้าง SELECT query
     */
    public function select($columns = ['*'])
    {
        $columnList = is_array($columns) ? implode(', ', $columns) : $columns;
        $this->query = "SELECT {$columnList}";
        $this->log('select', ['columns' => $columns]);

        return $this;
    }

    /**
     * กำหนด FROM
     */
    public function from($table)
    {
        $this->query .= " FROM {$table}";
        $this->log('from', ['table' => $table]);

        return $this;
    }

    /**
     * เพิ่มเงื่อนไข WHERE
     */
    public function where($column, $operator, $value)
    {
        $this->query .= " WHERE {$column} {$operator} ?";
        $this->bindings[] = $value;
        $this->log('where', ['column' => $column, 'operator' => $operator]);

        return $this;
    }

    /**
     * เพิ่มเงื่อนไข AND
     */
    public function and($column, $operator, $value)
    {
        $this->query .= " AND {$column} {$operator} ?";
        $this->bindings[] = $value;
        $this->log('and', ['column' => $column]);

        return $this;
    }

    /**
     * เพิ่มเงื่อนไข OR
     */
    public function or($column, $operator, $value)
    {
        $this->query .= " OR {$column} {$operator} ?";
        $this->bindings[] = $value;
        $this->log('or', ['column' => $column]);

        return $this;
    }

    /**
     * เรียงลำดับ
     */
    public function orderBy($column, $direction = 'ASC')
    {
        $this->query .= " ORDER BY {$column} {$direction}";
        $this->log('orderBy', ['column' => $column, 'direction' => $direction]);

        return $this;
    }

    /**
     * จำกัดจำนวน
     */
    public function limit($limit)
    {
        $this->query .= " LIMIT {$limit}";
        $this->log('limit', ['limit' => $limit]);

        return $this;
    }

    /**
     * เลื่อนข้อมูล
     */
    public function offset($offset)
    {
        $this->query .= " OFFSET {$offset}";
        $this->log('offset', ['offset' => $offset]);

        return $this;
    }

    /**
     * ดำเนินการ query
     */
    public function execute()
    {
        $this->log('execute', ['query' => $this->query]);
        // TODO: ดำเนินการ query จริง
        return [];
    }

    /**
     * ดึง query string
     */
    public function toSql()
    {
        return $this->query;
    }

    /**
     * ดึง bindings
     */
    public function getBindings()
    {
        return $this->bindings;
    }

    /**
     * บันทึกการกระทำ
     */
    protected function log($action, $details)
    {
        $this->actionLog[] = [
            'action' => $action,
            'details' => $details,
            'timestamp' => microtime(true)
        ];
    }

    /**
     * ดึงบันทึกการกระทำ
     */
    public function getActionLog()
    {
        return $this->actionLog;
    }

    /**
     * ล้างการบันทึก
     */
    public function clearLog()
    {
        $this->actionLog = [];
        return $this;
    }
}
