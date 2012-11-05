<?php

class Validator
{

  
    
  public function validateUserOrPass($input)
  {
    if (!preg_match("/^[A-Za-z0-9-]{1,30}$/", $input))
    {
      throw new Exception('Exception when validating type: User or Password. Value is: '.$input);
    } 
    else
    {
      //echo "Returning true<br>";
      return true;
    }
  } 

  public function validateTpl($input)
  {
    if ($input == "default" || $input == "thanks" || $input == "edit"
                            || $input == "headlines" || $input == "view" 
                            || $input == "quicksearch" || $input == "search" 
                            || $input == "front" || $input == "news" 
                            || $input == "admin" || $input == "print")
    {
        return true;
    }
    else
    {
        return false;
    }
  }

  public function validateId($input)
  {
    if (!preg_match("/^[0-9]{1,6}$/", $input))
    {
      throw new Exception('Exception when validating type: Id. Value is: '.$input);
    } 
    else
    {
      //echo "Returning true<br>";
      return true;
    }
  }

  public function validateEmailAddress($input)
  {
   if (!filter_var($input, FILTER_VALIDATE_EMAIL))
    {
         echo "email";
        throw new Exception('Exception when validating type: email. Value is: '.$input);
    } 
    else
    {
      //echo "Returning true<br>";
      return true;
    }

  }
  
  public function validateEmailSubject($input)
  {
  
    if (!preg_match("/^[A-Za-z0-9-\s]{1,50}$/", $input))
    {
         echo "emailsubject";
        throw new Exception('Exception when validating type: emailSubjecte. Value is: '.$input);
    } 
    else
    {
      //echo "Returning true<br>";
      return true;
    }
  }

  public function validateEmailMessage($input)
  {
  
    if (!preg_match("/^[A-Za-z0-9-\s]{1,500}$/", $input))
    {
         echo "emailMessage";
        throw new Exception('Exception when validating type: emailMessage. Value is: '.$input);
    } 
    else
    {
      //echo "Returning true<br>";
      return true;
    }
   
  }

 public function validateHash($input)
    {
        if (!preg_match("/^[A-Za-z0-9-]{20,100}$/", $input))
        {
          throw new Exception('Exception when validating type: User or Password. Value is: '.$input);
        } 
        else
        {
          //echo "Returning true<br>";
          return true;
        }
    }
    public function validatePage1Forward($input)
    {
        if ($input == "/?page=1")
        {
            return true;
        }
        else
        {
            return false;
        }
        
    
    }

}