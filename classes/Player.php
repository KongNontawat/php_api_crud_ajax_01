<?php
require 'Db_conn.php';

class Player extends Db_conn
{
  protected $table_name = 'players';

  public function add($data)
  {
    if (!empty($data)) {
      $fileds = $placholders = [];
      foreach ($data as $field => $value) {
        $fileds[] = $field;
        $placholders[] = ":{$field}";
      }
    }
    $sql = "INSERT INTO {$this->table_name} (" . implode(',', $fileds) . ") VALUES (" . implode(',', $placholders) . ")";
    $stmt = $this->connect()->prepare($sql);
    try {
      $this->connect()->beginTransaction();
      $stmt->execute($data);
      $this->connect()->commit();
      $lastInsertId = $this->connect()->lastInsertId();
      return $lastInsertId;
    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
      $this->connect()->rollBack();
    }
  }

  public function getRows($start = 0, $limit = 4)
  {
    $sql = "SELECT * FROM {$this->table_name} ORDER BY id DESC LIMIT {$start},{$limit}";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      $results = $stmt->fetchAll();
    } else {
      $results = [];
    }
    return $results;
  }

  public function getCount()
  {
    $sql = "SELECT count(*) as pcount FROM {$this->table_name}";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetch();
    return $results['pcount'];
  }

  public function getRow($field, $value)
  {
    $sql = "SELECT * FROM {$this->table_name} WHERE {$field}=:{$field}";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([":{$field}" => $value]);
    if ($stmt->rowCount() > 0) {
      $result = $stmt->fetch();
    } else {
      $result = [];
    }
    return $result;
  }

  public function upload_Photo($file)
  {
    if (!empty($file)) {
      $fileTempPath = $file['tmp_name'];
      $fileName = $file['name'];
      $fileSize = $file['size'];
      $fileType = $file['type'];
      $fileNameCmps = explode('.', $fileName);
      $fileExtension = strtolower(end($fileNameCmps));
      $newFileName = md5(uniqid() . $fileName) . '.' . $fileExtension;
      $allowedExtn = ["jpg", "png", "gif", "jpeg"];
      if (in_array($fileExtension, $allowedExtn)) {
        // $uploadFileDir = '../Image/uploads/';
        $uploadFileDir = getcwd() . '/Image/uploads/';
        $destFilePath = $uploadFileDir . $newFileName;
        if (move_uploaded_file($fileTempPath, $destFilePath)) {
          return $newFileName;
        }
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  public function update($data, $id)
  {
    if (!empty($data)) {
      $fileds = '';
      $x = 1;
      $filedsCount = count($data);
      foreach ($data as $field => $value) {
        $fileds .= "{$field}=:{$field}";
        if ($x < $filedsCount) {
          $fileds .= ", ";
        }
        $x++;
      }
    }
    $sql = "UPDATE {$this->table_name} SET {$fileds} WHERE id=:id";
    $stmt = $this->connect()->prepare($sql);
    try {
      $this->connect()->beginTransaction();
      $data['id'] = $id;
      $stmt->execute($data);
      $this->connect()->commit();
    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
      $this->connect()->rollBack();
    }
  }

  public function deleteRow($id)
  {
    $sql = "DELETE FROM {$this->table_name} WHERE id=:id";
    $stmt = $this->connect()->prepare($sql);
    try {
      $stmt->execute([":id" => $id]);
      if ($stmt->rowCount() > 0) {
        return true;
      }
    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
      return false;
    }
  }

  public function searchPlayer($searchText, $start=0, $limit=4)
  {
    $sql = "SELECT * FROM {$this->table_name} WHERE pname LIKE :search ORDER BY id DESC LIMIT {$start}, {$limit}";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([":search" => "{$searchText}%"]);
    if ($stmt->rowCount() > 0) {
      $result = $stmt->fetchAll();
    } else {
      $result = [];
    }
    return $result;
  }
}
