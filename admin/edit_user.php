<?php
$pagename= "Users";
$page= 1;
require "includes/header.php";
$cid=$_GET['cid'];
$user= mysqli_query($con,"SELECT * FROM users WHERE id = '$cid'");
$q= mysqli_fetch_array($user);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Edit User Record</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
            <li class="breadcrumb-item">
              <a href="#"> <?php if($pagename){echo $pagename;} ?> </a>
            </li>
            
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
    
    
    
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <!-- Default box -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Edit user records for - <?php echo $q['name']?> </h3>
            </div>

            <div class="card-body">
              <div class="callout with-border">
                
                <div class="box-body no-padding">
                <div class="col-md-10 offset-1">
                      <div class="card">
                        
                        <div class="card-header p-4">
                        <?php 
                          if(!isset($_POST['btn_add'])){
                            echo '<p class="text-danger">
                            <i>Enter New User Details <sub>*</sub></i></p>';
                            
                        ?>
                        <form class="form-horizontal" method="post" action="">
                        <div class="form-group row">
                                  <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                  <div class="col-sm-10">
                                    <input type="text" class="form-control" value="<?php echo $q['name']?>" required name="name" placeholder="Fullname" >
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                  <div class="col-sm-10">
                                    <input type="email" value="<?php echo $q['email']?>" class="form-control" required name="email" placeholder="Email">
                                  </div>
                                </div>
                                
                                <div class="form-group row">
                                  <label for="inputName2" class="col-sm-2 col-form-label"> Rank</label>
                                  <div class="col-sm-10">
                                    <select class="form-control" name="rank" required>
                                    <option value="">--Select Rank--</option>
                                      <option value="2">User rights</option>
                                      <option value="1">Admin rights</option>
                                    </select>
                                  </div>
                                </div>
                                    <i class="text-danger">Leave password blank if you dont want to change password</i>
                                <div class="form-group row">
                                  <label for="inputName2" class="col-sm-2 col-form-label">Password</label>
                                  <div class="col-sm-10">
                                    <input type="password" class="form-control"  name="password" id="mainpass" placeholder="Enter a new password">
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <label for="inputExperience" class="col-sm-2 col-form-label">Confirm Password</label>
                                  <div class="col-sm-10">
                                  <input type="password" id="pass2" 
                                  class="form-control" name="password2" onkeyup='check();' placeholder="Re-enter password">
                                  <span id='message'></span>
                                  </div>
                                
                                  <script type="text/javascript">
                                      var check = function(){
                                        if (document.getElementById('mainpass').value ==
                                        document.getElementById('pass2').value) {
                                          document.getElementById('message').style.color = 'green';
                                          document.getElementById('message').innerHTML = '<i>Good Password Match!</i>';
                                        } else {
                                          document.getElementById('message').style.color = 'red';
                                          document.getElementById('message').innerHTML = '<i>Sorry, password do not match</i>';
                                        }
                                      }
                                  </script>

                                </div>
                                
                                
                                <div class="form-group row">
                                  <div class="offset-sm-3 col-sm-6">
                                    <button type="submit" name="btn_add" class="btn btn-block bg-orange" >Update user Records</button>
                                  </div>
                                </div>
                              </form>
                                <?php
                                }else{
                                        // echo "working";
                                      $ip_address= get_userip();// calling ip address function
                                      //user ip address for local host ipv4
                                      if($ip_address=='::1'){
                                        $ip= "127.0.0.1"; 
                                      }else{
                                      $ip=$ip_address;
                                      }

                                      $name= mysqli_escape_string($con,$_POST['name']);
                                      $email= mysqli_escape_string($con,$_POST['email']);
                                      $password = mysqli_escape_string($con,$_POST['password']);
                                      $rank= mysqli_escape_string($con,$_POST['rank']);
                                        if($rank == 1){
                                          $status="Admin";
                                        }else{
                                          $status="User";
                                        }
                                          $pass= sha1($password);
                                        
                                        date_default_timezone_set("Africa/Lagos");
                                          $last_login= date('Y-m-d H:i:s A');
                                        //check if email already exists
                                          if(empty($password)){
                                            //echo "empty pasword!";
                                            $s = "UPDATE users SET `name`= '$name', `email`='$email', `user_level`='$rank', `status` = '$status' WHERE `id` = '$cid'"; 
                                            $s= mysqli_query($con,$s);
                                            if(mysqli_affected_rows($con)){
                                              echo '<h4 class=" text-success"><i class="fa fa-check"></i> User Record Updated Successful</h4><a href="users.php">Back to Users List</a>';

                                            }else{
                                              echo '<h4 class=" text-danger"><i class="fa fa-check"></i> User record update failed</h4><a href="users.php">Back to Users List</a>';


                                            }
                                          }else{

                                            //echo "pasword update!";
                                            $s = "UPDATE users SET `name`= '$name',`password`='$pass', `email`='$email', `user_level`='$rank', `status` = '$status' WHERE `id` = '$cid'"; 
                                            $s= mysqli_query($con,$s);
                                            if(mysqli_affected_rows($con)){
                                              
                                              echo '<h4 class=" text-success"><i class="fa fa-check"></i> User Record Updated Successful</h4>';

                                            }else{
                                              echo '<h4 class=" text-danger"><i class="fa fa-check"></i> User record update failed</h4>';

                                            }
                                      }
                                  }?>
                                  
                                  
                                

                        </div>
                      </div>
                    </div>


                </div>
                
            
              </div>
            </div>
            <!-- /.callout and card-body -->
           
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->

  </div>
<?php require "includes/footer.php"; ?>


