<?php

/**
 * TaskRepository.php Repository class extending DbConfig class
 * 
 * PHP Version 7.4.4
 * 
 * @category  PHP_WebApplication_Software
 * @package   SideHustle Todo App
 * @author    SolveStation <hello@solvestation.com>
 * @copyright 2021 SolveStation Technologies
 * @license   SSLIC: https://solvestation.com
 * @link      https://solvestation.com
 */

require_once 'DbConfig.repo.php';

class TaskRepository extends DbConfig
{
    /**
     * Display all records from table
     * 
     * @param $table Table name
     * @param $column Table column to check if value is not null
     * @param $value   Value to check if task is completed or not
     * 
     * @return $row
     */
    public function getAllTask()
    {
        try {
            $this->query("SELECT id, title, detail, created_at, completed FROM task ORDER BY id DESC");
            while ($row = $this->fetchAll()) {
                return $row;
            }
        } catch (PDOException $e) {
            $this->scream("Error:" . $e->getMessage());
        }
    }

    /**
     * Create new todo
     * 
     * @param $title Task title
     * @param $detail Task details
     * 
     * @return bool
     */
    public function addTask(string $title, string $detail)
    {
        try {
            $this->query("INSERT INTO task (title, detail) VALUES(:title, :detail)");
            $this->bind('title', $title);
            $this->bind('detail', $detail);
            $this->execute();
        } catch (PDOException $e) {
            $this->scream("Error:" . $e->getMessage());
        }
        return true;
    }

    /**
     * Display task details
     *
     * @param int $id taskId
     * 
     * @return $result
     */
    public function getTaskDetail(int $id)
    {
        try {
            $this->query("SELECT * FROM task WHERE id = :id");
            $this->bind('id', $id);
            $result = $this->fetch();
        } catch (PDOException $e) {
            $this->scream("Error:" . $e->getMessage());
        }

        return $result;
    }

    /**
     * Edit a task
     *
     * @param array $info Task data entity
     * @param int   $id   Task Id
     * 
     * @return $result
     */
    public function editTask(int $id, string $title, string $detail, int $completed)
    {
        try {
            $this->query("UPDATE task SET title = :title, detail = :detail, completed = :completed WHERE id = :id");
            $this->bind('title', $title);
            $this->bind('detail', $detail);
            $this->bind('completed', $completed);
            $this->bind('id', $id);
            $this->execute();
        } catch (PDOException $e) {
            $this->scream("Error:" . $e->getMessage());
        }
        return true;
    }


    /**
     * Delete from table
     * 
     * @param $table Table name
     * @param $where Table column
     * @param $id Unique record to delete
     */
    public function deleteTask(int $id)
    {
        try {
            $this->query("DELETE FROM task WHERE id = :id");
            $this->bind('id', $id);
            $this->execute();
        } catch (PDOException $e) {
            $this->scream("Error:" . $e->getMessage());
        }

        return true;
    }

    /**
     * Echo strings, numbers etc (Had to create this method coz I hate seeing echo in my code... LOL)
     * 
     * @param $item Item to be echoed
     * 
     * @return void 
     */
    public function scream($item)
    {
        echo $item;
    }

    /**
     * Timeago function to display string of exact period of an action
     *
     * @param string $timestamp current timestamp to convert
     * 
     * @return string $time
     */
    public function timeAgo($timestamp)
    {
        date_default_timezone_set(DBCONFIG::SYSTEM_TIMEZONE);

        $timestamp = strtotime($timestamp) ? strtotime($timestamp) : $timestamp;

        $time = time() - $timestamp;

        switch ($time) {
                //seconds
            case $time <= 60:
                return 'Just Now!';

                //Minutes
            case $time >= 60 && $time < 3600:
                return (round($time / 60) == 1) ? 'a minute ago' :
                    round($time / 60) . ' minutes ago';

                //Hours
            case $time >= 3600 && $time < 86400:
                return (round($time / 3600) == 1) ? 'an hour ago' :
                    round($time / 3600) . ' hours ago';

                //Days
            case $time >= 86400 && $time < 604800:
                return (round($time / 86400) == 1) ? 'a day ago' :
                    round($time / 86400) . ' days ago';

                //Weeks
            case $time >= 604800 && $time < 2600640:
                return (round($time / 604800) == 1) ? 'a week ago' :
                    round($time / 604800) . ' weeks ago';

                //Months
            case $time >= 2600640 && $time < 31207680:
                return (round($time / 2600640) == 1) ? 'a month ago' :
                    round($time / 2600640) . ' months ago';

                //Years
            case $time >= 31207680;
                return (round($time / 31207680) == 1) ? 'a year ago' :
                    round($time / 31207680) . ' years ago';
        }
    }

    /**
     * Checking if a word output is singular or plural
     *
     * @param $variable Counted variable
     * @param $text     Text to return singular or plural
     *
     * @return $text
     */
    public function toQuantity($variable, string $text)
    {
        if ($variable <= 1) {
            return $variable . ' ' . $text;
        } else {
            return $variable . ' ' . $text . 's';
        }
    }

    /**
     * Counting total records from a table
     *
     * @param string $tablename table name to count from
     *
     * @return int total count from DB
     */
    public function countAll($tablename)
    {
        try {
            $this->query("SELECT count(*) FROM $tablename");
            $count = $this->fetchColumn();
        } catch (PDOException $e) {
            $this->scream("Error:" . $e->getMessage());
        }

        return $count;
    }

    /**
     * Count Completed/Incompleted Task
     *
     * @param $table Table name
     * @param $column  Table column
     * @param $value  Column value
     *
     * @return $count
     */
    public function countWhere($table, $column, $value)
    {
        try {
            $this->query("SELECT count(*) FROM $table WHERE $column = :column");
            $this->bind('column', $value);
            $count = $this->fetchColumn();
        } catch (PDOException $e) {
            $this->scream("Error:" . $e->getMessage());
        }

        return $count;
    }

    public function sanitizeInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}
