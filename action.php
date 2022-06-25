<?php

include_once('Classes/database.php');
$dbObj = new Database();

if (isset($_POST['action']) && $_POST['action'] == "insert") {
    $f_name = $_POST['f_name'];
    $l_name= $_POST['l_name'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $dbObj->register($f_name, $l_name, $email, $password);
}

if (isset($_POST['action']) && $_POST['action'] == "view") {
    $output = "";
    $users= $dbObj->read();
    if ($dbObj->totalRowCount() > 0) {
        $output .="<table class='table table-striped table-hover'>
                 <thead>
                   <tr>
                     <th>Id</th>
                     <th>First name</th>
                     <th>Last Name</th>
                     <th>Email</th>
                     <th>Password</th>
                     <th>Action</th>
                
                   </tr>
                 </thead>
                 <tbody>";
        foreach ($users as $user) {
            $output.="<tr>
                     <td>".$user['user_id']."</td>
                     <td>".$user['first_name']."</td>
                      <td>".$user['last_name']."</td>
                     <td>".$user['email']."</td>
                     <td>".$user['password']."</td>
                    
                     <td>
                       <a href='#editModal' style='color:green' data-toggle='modal' 
                       class='editBtn' id='".$user['user_id']. "'><i class='fa fa-pencil'></i></a>&nbsp;
                       <a href='' style='color:#ff0000' class='deleteBtn' id='" .$user['user_id']."'>
                       <i class='fa fa-trash' ></i></a>
                     </td>
                 </tr>";
        }
        $output .= "</tbody>
            </table>";
        echo $output;
    }else{
        echo '<h3 class="text-center mt-5">No records found</h3>';
    }
}

if (isset($_POST['editId'])) {
    $editId = $_POST['editId'];
    $row = $dbObj->getById($editId);
    echo json_encode($row);
}
// Update Record
if (isset($_POST['action']) && $_POST['action'] == "update") {
    $id = $_POST['id'];
    $f_name = $_POST['f_name'];
    $l_name = $_POST['l_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $dbObj->update($id, $f_name, $l_name,$email, $password);
}

if (isset($_POST['deleteBtn'])) {
    $deleteBtn = $_POST['deleteBtn'];
    $dbObj->delete($deleteBtn);
}


?>