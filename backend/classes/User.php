<?php

class User
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::instance();
    }

    public function userData($userId){
        $stmt=$this->pdo->prepare("SELECT * FROM `users` WHERE user_id=:userId");
        $stmt->bindParam(":userId",$userId,PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_OBJ);
        if($stmt->rowCount() != 0){
            return $user;
        } else {
            return false;
        }
    }

    public function create($tableName,$fields=array()){
        $columns=implode(', ',array_keys($fields));
        $values=':'.implode(', :',array_keys($fields));
        $sql="INSERT INTO `{$tableName}` ({$columns}) VALUES ({$values})";
        if($stmt=$this->pdo->prepare($sql)){
            foreach($fields as $key =>$values){
                $stmt->bindValue(":".$key,$values);
            }
            $stmt->execute();
            return $this->pdo->lastInsertId();
        }
    }

    public function get($tableName,$columnName=array(), $fields=array()){
        $targetColumns=implode(', ',array_values($columnName));
        $columns="";
        $i=1;
        foreach ($fields as $name => $values){
            $columns .="{$name}=:{$name}";
            if ($i < count($fields)){
                $columns.=" AND ";
            }
            $i++;
        }
        $sql="SELECT {$targetColumns} FROM `{$tableName}` WHERE {$columns}";
        if ($stmt=$this->pdo->prepare($sql)){
            foreach($fields as $key => $values){
                $stmt->bindValue(":".$key,$values);
            }
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }
    }
}