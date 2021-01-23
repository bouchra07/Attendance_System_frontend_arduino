<?php
$login=$_POST['Login'];
$mdp=$_POST['Password'];

$con=mysqli_connect("localhost","pi3","raspberry","Ecole");
$res=mysqli_query($con,"select * from admins");
$t=0;
while ($don=mysqli_fetch_array($res))
{
  if ($don[0]==$login && $don[1]==$mdp)
    $t=1;
}
if($t==1){
session_start();
$_SESSION['login'] = $login;
$_SESSION['password'] = $mdp;
include 'master.php';

}

else
include 'index.php';

?>
