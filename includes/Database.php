<?php
class Database
{
    private $mysql_obj = null;
    function __construct()
    {

        $this->mysql_obj = new mysqli("localhost", "root", "", "coding_challenge");

        // Check connection
        if ($this->mysql_obj->connect_errno) {
            exit("Failed to connect to MySQL: " . $this->mysql_obj->connect_error);;
        }
    }
    //insert rows to database.
    function insert_rows(array $rows)
    {
        $employee_id = null;
        $event_id = null;
        try {
            foreach ($rows as $key => $row) {
                $exits_employee_id = $this->check_already_exits_employee($row['employee_mail']);

                $event_version = isset($row['version']) ? $row['version'] : null;
                $exits_event_id = $this->check_already_exits_event($row['event_name'], $event_version);
                if (!$exits_employee_id) {
                    $employee_insert_query = "INSERT INTO employees(employee_name, employee_mail) VALUES ('" . $row['employee_name'] . "', '" . $row['employee_mail'] . "')";
                    $this->mysql_obj->query($employee_insert_query);
                    $employee_id = $this->mysql_obj->insert_id;
                } else {
                    $employee_id =  $exits_employee_id;
                }

                if (!$exits_event_id) {

                    $event_insert_query = "INSERT INTO events(event_name, event_date, version) VALUES ('" . $row['event_name'] . "', '" . $row['event_date'] . "', '" . $event_version . "')";
                    $this->mysql_obj->query($event_insert_query);
                    $event_id = $this->mysql_obj->insert_id;
                } else {
                    $event_id = $exits_event_id;
                }

                if (!$this->already_participant($employee_id,  $event_id)) {
                    $this->already_participant($employee_id,  $event_id);
                    $event_participants_query = "INSERT INTO participants(employee_id, event_id, participation_fee) VALUES ('" . $employee_id . "', '" . $event_id . "', '" . $row['participation_fee'] . "')";
                    $this->mysql_obj->query($event_participants_query);
                }
            }
        } catch (Exception $e) {
            exit($e);
        }
    }

    //Already Exite Employee
    function check_already_exits_employee(string $email) : int
    {
        try{
            $select_employee_query = "select employee_id from employees where employee_mail = '".$email."'";
            $result = $this->mysql_obj->query($select_employee_query);
            $row = $result -> fetch_assoc();
            return (isset($row['employee_id']) and !empty($row['employee_id'])) ? $row['employee_id'] : 0; 
        }catch(Exception $e){
            exit($e);
        }
       return 0;
    }

    //Check Already exits Events
    function check_already_exits_event(string $event_name, string $event_version = null) : int
    {
        try{
            $select_employee_query = "select event_id from events where event_name = '".$event_name."' and version='".$event_version."'";
            $result = $this->mysql_obj->query($select_employee_query);
            $row = $result -> fetch_assoc();
            return (isset($row['event_id']) and !empty($row['event_id'])) ? $row['event_id'] : 0; 
        }catch(Exception $e){
            exit($e);
        }
        return 0;
    }
    // already exits participant
    function already_participant( int $employee_id, int $event_id) : int
    {
        try{
           $select_participant_query = "select participation_id  from participants where employee_id = '".$employee_id."' and event_id='".$event_id."'";
            $result = $this->mysql_obj->query($select_participant_query);
            $row = $result -> fetch_assoc();
            return (isset($row['participation_id']) and !empty($row['participation_id'])) ? $row['participation_id'] : 0; 
        }catch(Exception $e){
            exit($e);
        }
        return 0;
    }
    // Get All rows for lisiting
    function get_rows () :array
    {
        try{
            $query = "select employee.*, e.* , participant.participation_fee from employees employee, events e, participants participant where employee.employee_id=participant.employee_id and e.event_id = participant.event_id";
            $result = $this->mysql_obj->query($query);
            $rows =[];
                while($row = $result->fetch_assoc()){
                    $rows[] = $row;
                } 
               
            return $rows;
        }catch(Exception $e){
            exit($e);
        }
        return [];
    }
}
$mysql_obj = new Database();
