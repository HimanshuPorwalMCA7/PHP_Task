<!doctype html>
<html lang="en">
  <head>
    <title>Contact Form</title>
  </head>
  <body>
    <h1>Contact Form</h1>
    <form action="" method="POST">
      Full Name: &nbsp; <input type="text" id="full-name" name="full_name" value="<?php echo isset($_POST['full_name'])?htmlspecialchars($_POST['full_name']):'';?>" placeholder="Enter your Full Name">
      <?php if(!empty($errors['full_name'])|| ($_SERVER["REQUEST_METHOD"]=="POST" && empty($_POST['full_name']))):?>
        <span style="color: red;"><?php echo $errors['full_name'] ??"Full name is Required";?></span>
        <?php endif;?>
      <br><br>
    Phone Number: &nbsp;<input type="text" name="phone_number" value="<?php echo isset($_POST['phone_number'])?htmlspecialchars($_POST['phone_number']):'';?>" placeholder="Enter your Phone Number" >
    <?php if(!empty($errors['phone_number'])|| ($_SERVER["REQUEST_METHOD"]=="POST" && (empty($_POST['phone_number']) ||  preg_match("/^[0-9]{10}$/",$_POST['phone_number'])))):?>
        <span style="color: red;"><?php echo $errors['phone_number'] ??"Phone Number is Required";?></span>
        <?php endif;?>
    
    <br><br>
     Email: &nbsp;&nbsp;&nbsp;&nbsp; <input type="email" name="email" value="<?php echo isset($_POST['email'])?htmlspecialchars($_POST['email']):'';?>" placeholder="Enter your Email" >
     <?php if(!empty($errors['email'])|| ($_SERVER["REQUEST_METHOD"]=="POST" && empty($_POST['email']))):?>
        <span style="color: red;"><?php echo $errors['email'] ??"Email is Required";?></span>
        <?php endif;?>
     <br><br>
      Subject : &nbsp;&nbsp;&nbsp; <input type="text" name="subject" value="<?php echo isset($_POST['subject'])?htmlspecialchars($_POST['subject']):'';?>" placeholder="Enter subject" >
      <?php if(!empty($errors['subject'])|| ($_SERVER["REQUEST_METHOD"]=="POST" && empty($_POST['subject']))):?>
        <span style="color: red;"><?php echo $errors['subject'] ??"Subject is Required";?></span>
        <?php endif;?>
      <br><br>
      Message : &nbsp;&nbsp;&nbsp; <textarea type="text" name="message" value="<?php echo isset($_POST['message'])?htmlspecialchars($_POST['message']):'';?>" placeholder="Enter your Message" ></textarea>
      <?php if(!empty($errors['message'])|| ($_SERVER["REQUEST_METHOD"]=="POST" && empty($_POST['message']))):?>
        <span style="color: red;"><?php echo $errors['message'] ??"message is Required";?></span>
        <?php endif;?>
      <br><br>
        <input type="submit" value="Contact Us">
    </form>

    <?php
    include 'connection.php';
    $errors=array();
    $success= false;
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        $full_name=$_POST['full_name'];
        $phone_number=$_POST['phone_number'];
        $email=$_POST['email'];
        $subject=$_POST['subject'];
        $message=$_POST['message'];
        $localIP=getHostByName(getHostName());

        if(empty($full_name))
        {
            $errors['full_name']="Full Name is Required";
        }
        if(empty($phone_number) ||  preg_match("/^[0-9]{10}$/",$phone_number))
        {
            $errors['phone_number']="invalid phone number";
        
        }
        if(empty($email)|| !filter_var($email,FILTER_VALIDATE_EMAIL)){
            $errors['email']="Invalid eamil address";
        }

        if(empty($subject)){
            $errors['subject']="subject is required";
        }

        if(empty($message)){
            $errors['message']="Message is required";
        }

        if(empty($errors)){
            $full_name=mysqli_real_escape_string($con,$full_name);
            $phone_number=mysqli_real_escape_string($con,$phone_number);
            $email=mysqli_real_escape_string($con,$email);
            $subject=mysqli_real_escape_string($con,$subject);
            $message=mysqli_real_escape_string($con,$message);
             
        $insertQuery="insert into contact_form(full_name,phone_number,email,subject,message,ip_address,submission_time)Values('$full_name','$phone_number','$email','$subject','$message','$localIP',NOW())";
        $res=mysqli_query($con,$insertQuery);
        if($res)
        {
            $success=true;
            $_POST= array();
            $to_email="hpplacement2024@gmail.com"; //owner email
            $subject="New Contact form Submission";
            $body="Name:$full_name \n Phone:$phone_number \n Email:$email \n subject:$subject \n 
            Message:$message \n IPAddress:$localIP \n Submission Time:".date("Y-m-d H:i:s")."\n";
            $headers = "From:$email";
            if(mail($to_email,$subject,$body,$headers))
            {
                echo"<script>alert(Thank You);</script>";
            }
            else
            {
                echo"<script>alert(Error:Email Sending Failed.Please try again Later);</script>";
            }
            echo"<script>window.location.href='index.php'</script>";
        }  
    }
    else
    {
        echo"<script>alert(Error:Data Not inserted);</script>";

    }
}
?>
  </body>
</html>