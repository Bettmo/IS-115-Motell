<?php

require_once '../core/Model.php';

class User extends Model
{
    public function createUser($data)
    {
        return $this->insert('users', $data);
    }

    public function findUserByEmail($email)
    {
        return $this->fetch("SELECT * FROM users WHERE email = ?", [$email]);
    }

    public function updateUser($id, $data)
    {
        return $this->update('users', $data, 'id = ?', [$id]);
    }

    public function deleteUser($id)
    {
        return $this->delete('users', 'id = ?', [$id]);
    }
}
