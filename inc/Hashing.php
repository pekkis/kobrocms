
<?php
  function produceSalt($saltSize)
  {
    // salt on 12 merkin pituinen
    $source = str_split('abcdefghijklmnopqrstuwvxyz0123456789');
    $maxValue = count($source)-1;
    for($i=0;$i<12;$i++)
    {     
      $arr[] = $source[rand(0, $maxValue)];
    }
    $str = implode('', $arr);
    $hash = sha1($str);
    $salt = substr($hash, 3, $saltSize+3);
    return $salt;
  }
 
  function produceHash($password, $salt = null, $saltSize = "12")
  {
    if($salt == null)
    {
      echo "producing salt<br>";
      $salt = produceSalt($saltSize);   
    }
    $toBeHashed = $salt.$password;
    $hash = sha1($toBeHashed);
    $result = substr($hash, 0, 3).$salt.substr($hash, 3, strlen($hash));
    return $result;  
  }