<?php
require_once 'connec.php';
$pdo = new \PDO(DSN, USER, PASS);

$query = "SELECT * FROM friend";
$statement = $pdo->query($query);
$friends = $statement->fetchAll();

if($_SERVER['REQUEST_METHOD']==='POST')
{
    $data = array_map('trim',$_POST);
    $errors = [];
    if(empty($data['firstname'])){
        $errors [] = 'your firstname is required';
    }
    if(empty($data['lastname'])){
        $errors [] = 'your lastname is required';
    }
    if(empty($error)){
        $firstname = $data['firstname'];
        $lastname = $data['lastname'];
        $query ="INSERT INTO friend (firstname, lastname) VALUES (:firstname,:lastname)";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':firstname',$firstname, \PDO::PARAM_STR);
        $statement->bindValue(':lastname',$lastname, \PDO::PARAM_STR);
        $statement->execute();
        header('location: index.php');
    }
}   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<ul>
<?php foreach($friends as $friend): ?>
    <li><?= $friend['firstname'] . ' ' . $friend['lastname'] ?></li>
    <br/>
<?php endforeach ?>
</ul>


<ul>

<?php if(isset($errors)):?>
    <?php foreach($errors as $error): ?>
        <li><?= $error ?></li>
    <?php endforeach ?>
<?php endif ?>
</ul>


<form action="" method="POST">
    <label for="firstname">Firstname</label>
    <input type="text" name="firstname" id="firstname" require>
    <br/>
    <br/>
    <label for="lastname">Lastname</label>
    <input type="text" name="lastname" id="lastname" require>
    <br/>
    <button>submit</button>
</form>

</body>
</html>
