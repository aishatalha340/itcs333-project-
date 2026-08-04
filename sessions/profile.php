<?php
include "../db_connect.php";
session_start();

// if there is no user id in session the  user not login
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

// to take the user id that save in session and add in $user_id.
//WHERE user_id=? to know which user we need to update  their data
$user_id=$_SESSION['user_id'];
    $stmt=$conn->prepare("SELECT full_name,email,password_hash,profile_image FROM users WHERE user_id=?");
    $stmt->execute([$user_id]);
    $user=$stmt->fetch(PDO::FETCH_ASSOC);

    // ITS MEAN IF THE USER DO SUBMIT AND SEND DATA IF YES DO THE CODE OF UPDATE
    //  اوCheck if the user submitted the form using POST method. If yes, process the update.
    // I use post not session because we need to take the new data the user fill it  in form to direct change because in session we need to update it manual 
    //$image_name=$user['profile_image']; نخلي صورة القديمه اذا المستخدم ما اختار صوره جديدة
    //$_FILES['profile_image'جذي ناخذ الملف اللي رفعه المستخدم
    //$_FILES['profile_image']['error'] == 0 انه الرفع مافيه اي مشكله
    //time() . "_" . $_FILES['profile_image']['name'] نسوي اسم جديد للصورة
    //move_uploaded_file() uploads تنقل الصورة من مكانها الى الفولدر 
    // 

    $message="";
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $full_name=$_POST['full_name'];
        $password=$_POST['password'];
        $image_name=$user['profile_image'];
        if(isset($_FILES['profile_image']) && $_FILES['profile_image']['error']==0){
            $image_name=time()."_".$_FILES['profile_image']['name'];
            $target="../uploads/".$image_name;
            move_uploaded_file($_FILES['profile_image']['tmp_name'],$target);
            
        }
        if(empty($full_name)){
            $message="Full name cannot be empty";
        }
        if( !empty($password)&&strlen($password)<8){
            $message="Password must be at least 8 characters";
        }

    /// if(!empty($password)){ المستخدم كتب باسورد جديد فلازم احدث الاسم و الباسورد مع تشفيره طبعاا
    ///the update
    if ($message==""){
        if(!empty($password)){
            $hashedpassword=hash('sha256',$password);
            $stmt=$conn->prepare("UPDATE users SET full_name=?,password_hash=?,profile_image=? WHERE user_id=?");
            $stmt->execute([$full_name,$hashedpassword,$image_name,$user_id]);
            $_SESSION['full_name']=$full_name;///نحديث السشن
            header("location:profile.php");
            exit();
        }else{
            ///اذا خلا الباسورد فاضي 
          $stmt=$conn->prepare("UPDATE users SET full_name=?,profile_image=? WHERE user_id=?");
          $stmt->execute([$full_name,$image_name,$user_id]);
          $_SESSION['full_name']=$full_name;
          header("location:profile.php");
          exit();

        }
        }
    }
    //enctype="multipart/form-data"لان الصورة تعتبر ملف فبدونهاما بيطرش الى php
?>
<!DOCTYPE html>
<html>
    <head></head>
    <body>
        <h2>Edit Profile</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            Full Name:<input type="text" name="full_name" value="<?php echo $user['full_name']; ?>">
            <br><br>
            Email:<input type="email" name="email" value="<?php echo $user['email']; ?>" disabled>
            <br>
            <label>profile Image:</label>
            <input type="file" name="profile_image" id="profile_image">
            <br>
            <?php if(!empty($user['profile_image'])): //هل المستخدم عنده صورة محفوظة?>
            <img id="preview"
             src="../uploads/<?php echo $user['profile_image'];?>" 
             width="120"> 
             <?php else: ?>
                <img id="preview"
                src="" 
                width="120"
              style="display:none;"> 
              <?php endif; ?>

            New Password:<input type="password" name="password"><br><br>
            <button type="submit">Update Profile</button>

        </form>
        <?php 
        if(!empty($message)){
            echo "<p>$message</p>";
        }
         ?>
         <script>
            const imageInput=document.getElementById("profile_image");
            const preview=document.getElementById("preview");
            imageInput.addEventListener("change",function(){
                const file =this.files[0];//جذي خذنا الصورة
                if(file){
                    preview.src=URL.createObjectURL(file);
                    preview.style.display="block";//تطلع الصورة لان قابل كانت none
                }
            });
         </script>
        
    </body>
</html>
