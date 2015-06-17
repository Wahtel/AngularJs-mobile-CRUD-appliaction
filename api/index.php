<?php
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();

// create new Slim instance
$app = new \Slim\Slim();
$app->get('/users', 'getUsers');
$app->get('/user/:id', 'getUser');
$app->post('/addUser', 'addUser');
$app->put('/edit/:id', 'updateUser');
$app->delete('/users/:id', 'deleteUser');
$app->run();

function getData() {
  $sql = "select * FROM customers ORDER BY id";
  try {
    $db = getConnection();
    $stmt = $db->query($sql);  
    $wines = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    file_put_contents("data.json", json_encode($wines));
  } catch(PDOException $e) {
    echo '{"error":{"text":'. $e->getMessage() .'}}'; 
  }
}

function getUsers() {
  getData();
  $customers = file_get_contents("data.json");
  echo $customers;
}

function addUser() {
  $request = \Slim\Slim::getInstance()->request();
  $user = json_decode($request->getBody());
  $sql = "INSERT INTO customers (name, email, telephone, address, street, city, state, zip) VALUES (:name, :email, :telephone, :address, :street, :city, :state, :zip)";
  try {
    $db = getConnection();
    $stmt = $db->prepare($sql);  
    $stmt->bindParam("name", $user->name);
    $stmt->bindParam("email", $user->email);
    $stmt->bindParam("telephone", $user->telephone);
    $stmt->bindParam("address", $user->address);
    $stmt->bindParam("street", $user->street);
    $stmt->bindParam("city", $user->city);
    $stmt->bindParam("state", $user->state);
    $stmt->bindParam("zip", $user->zip);
    $stmt->execute();
    $user->id = $db->lastInsertId();
    $db = null;
    echo json_encode($user); 
  } catch(PDOException $e) {
    echo '{"error":{"text":'. $e->getMessage() .'}}'; 
  }
}

function getUser($id) {
  $sql = "SELECT * FROM customers WHERE id=:id";
  try {
    $db = getConnection();
    $stmt = $db->prepare($sql);  
    $stmt->bindParam("id", $id);
    $stmt->execute();
    $user = $stmt->fetchObject();  
    $db = null;
    echo json_encode($user); 
  } catch(PDOException $e) {
    echo '{"error":{"text":'. $e->getMessage() .'}}'; 
  }
}

function updateUser($id) {
  $request = \Slim\Slim::getInstance()->request();
  $body = $request->getBody();
  $user = json_decode($body);
  $sql = "UPDATE customers SET name=:name, email=:email, telephone=:telephone, address=:address, street=:street, city=:city, state=:state, zip=:zip WHERE id=:id";
  try {
    $db = getConnection();
    $stmt = $db->prepare($sql);  
    $stmt->bindParam("name", $user->name);
    $stmt->bindParam("email", $user->email);
    $stmt->bindParam("telephone", $user->telephone);
    $stmt->bindParam("address", $user->address);
    $stmt->bindParam("street", $user->street);
    $stmt->bindParam("city", $user->city);
    $stmt->bindParam("state", $user->state);
    $stmt->bindParam("zip", $user->zip);
    $stmt->bindParam("id", $id);
    $stmt->execute();
    $db = null;
    echo json_encode($user); 
  } catch(PDOException $e) {
    echo '{"error":{"text":'. $e->getMessage() .'}}'; 
  }
}

function deleteUser($id) {
  $sql = "DELETE FROM customers WHERE id=:id";
  try {
    $db = getConnection();
    $stmt = $db->prepare($sql);  
    $stmt->bindParam("id", $id);
    $stmt->execute();
    $db = null;
  } catch(PDOException $e) {
    echo '{"error":{"text":'. $e->getMessage() .'}}'; 
  }
}
function getConnection() {
  $dbhost="127.0.0.1";
  $dbuser="root";
  $dbpass="000000";
  $dbname="test_app";
  $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);  
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  return $dbh;
}

?>