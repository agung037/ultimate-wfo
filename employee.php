<?php 
class EmployeeDatabase extends Database {
    public function getEmployees() {
        $query = "SELECT * FROM employees";
        return $this->query($query);
    }

    public function getEmployeeById($id) {
        $query = "SELECT * FROM employee WHERE id = :id";
        return $this->query($query, array('id' => $id));
    }

    public function addEmployee($name, $email, $phone) {
        $query = "INSERT INTO employee (name, email, phone) VALUES (:name, :email, :phone)";
        return $this->query($query, array(
            'name' => $name,
            'email' => $email,
            'phone' => $phone
        ));
    }

    public function updateEmployee($id, $name, $email, $phone) {
        $query = "UPDATE employee SET name = :name, email = :email, phone = :phone WHERE id = :id";
        return $this->query($query, array(
            'id' => $id,
            'name' => $name,
            'email' => $email,
            'phone' => $phone
        ));
    }

    public function deleteEmployee($id) {
        $query = "DELETE FROM employee WHERE id = :id";
        return $this->query($query, array('id' => $id));
    }
}

?>