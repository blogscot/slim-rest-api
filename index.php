<?php
require 'vendor/autoload.php';

$app = new \Slim\Slim();

// Database connection
$app->container->singleton('db', function() {
  return new PDO('mysql:host=127.0.0.1;dbname=project', 'root', 'root');
});

$app->get('/', function() use($app) {
    $app->response->setStatus(200);
    echo "Welcome to Slim 3.0 based API";
});

$app->get('/getScore/:id', function ($id) use($app) {

    try {
      $sth = $app->db->prepare("SELECT * FROM students WHERE student_id = :id");

      $sth->bindParam(':id', $id, PDO::PARAM_INT);
      $sth->execute();

      $student = $sth->fetch(PDO::FETCH_ASSOC);

      if($student) {
          $app->response->setStatus(200);
          $app->response()->headers->set('Content-Type', 'application/json');
          echo json_encode($student);
          $app->db = null;
      } else {
          throw new PDOException('No records found.');
      }

  } catch(PDOException $e) {
      $app->response()->setStatus(404);
      echo '{"error":{"text":'. $e->getMessage() .'}}';
  }
});

$app->post('/updateScore', function() use($app) {
    $allPostVars = $app->request->post();
    $score = $allPostVars['score'];
    $id = $allPostVars['id'];

    try {
      $sth = $app->db->prepare("UPDATE students
          SET score = :score
          WHERE student_id = :id");

      $sth->bindParam(':score', $score, PDO::PARAM_INT);
      $sth->bindParam(':id', $id, PDO::PARAM_INT);
      $sth->execute();

      $app->response->setStatus(200);
      $app->response()->headers->set('Content-Type', 'application/json');
      echo json_encode(array("status" => "success", "code" => 1));

    } catch(PDOException $e) {
        $app->response()->setStatus(404);
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->run();

?>
