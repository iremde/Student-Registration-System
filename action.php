<?php

//action.php

$connect = new PDO("mysql:host=localhost;dbname=testing", "root", "");
$received_data = json_decode(file_get_contents("php://input"));
$data = array();
if($received_data->action == 'fetchall')
{
 $query = "
 SELECT * FROM tbl_sample 
 ORDER BY id DESC
 ";
 $statement = $connect->prepare($query);
 $statement->execute();
 while($row = $statement->fetch(PDO::FETCH_ASSOC))
 {
  $data[] = $row;
 }
 echo json_encode($data);
}
if($received_data->action == 'insert')
{
 $data = array(
  ':first_name' => $received_data->firstName,
  ':last_name' => $received_data->lastName,
  ':student_id' => $received_data->studentId,
  ':phone_number' => $received_data->phoneNumber,
  ':city' => $received_data->City,
  ':district' => $received_data->District,
  ':descc' => $received_data->Desc,
 );

 $query = "
 INSERT INTO tbl_sample 
 (first_name, last_name, student_id, phone_number, city, district, descc) 
 VALUES (:first_name, :last_name, :student_id, :phone_number, :city, :district, :descc)
 ";

 $statement = $connect->prepare($query);

 $statement->execute($data);

 $output = array(
  'message' => 'Data Inserted'
 );

 echo json_encode($output);
}
if($received_data->action == 'fetchSingle')
{
 $query = "
 SELECT * FROM tbl_sample 
 WHERE id = '".$received_data->id."'
 ";

 $statement = $connect->prepare($query);

 $statement->execute();

 $result = $statement->fetchAll();

 foreach($result as $row)
 {
  $data['id'] = $row['id'];
  $data['first_name'] = $row['first_name'];
  $data['last_name'] = $row['last_name'];
  $data['student_id'] = $row['student_id'];
  $data['phone_number'] = $row['phone_number'];
  $data['city'] = $row['city'];
  $data['district'] = $row['district'];
  $data['descc'] = $row['descc'];
 }

 echo json_encode($data);
}
if($received_data->action == 'update')
{
 $data = array(
  ':first_name' => $received_data->firstName,
  ':last_name' => $received_data->lastName,
  ':student_id' => $received_data->studentId,
  ':phone_number' => $received_data->phoneNumber,
  ':city' => $received_data->City,
  ':district' => $received_data->District,
  ':descc' => $received_data->Desc,
  ':id'   => $received_data->hiddenId
 );

 $query = "
 UPDATE tbl_sample 
 SET first_name = :first_name, 
 last_name = :last_name,
 student_id = :student_id,
 phone_number = :phone_number,
 city = :city,
 district = :district,
 descc = :descc
 WHERE id = :id
 ";

 $statement = $connect->prepare($query);

 $statement->execute($data);

 $output = array(
  'message' => 'Data Updated'
 );

 echo json_encode($output);
}

if($received_data->action == 'delete')
{
 $query = "
 DELETE FROM tbl_sample 
 WHERE id = '".$received_data->id."'
 ";

 $statement = $connect->prepare($query);

 $statement->execute();

 $output = array(
  'message' => 'Data Deleted'
 );

 echo json_encode($output);
}

?>




