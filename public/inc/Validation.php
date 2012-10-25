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

  public function validateEpithet($input)
  {
    if (!preg_match("/^[A-Za-z0-9-\s]{1,30}$/", $input))
    {
      throw new Exception('Exception when validating type: Epithet. Value is: '.$input);
    } 
    else
    {
      //echo "Returning true<br>";
      return true;
    }
  }

  public function validateId($input)
  {
    if (!preg_match("/^[0-9]{1,4}$/", $input))
    {
      throw new Exception('Exception when validating type: Id. Value is: '.$input);
    } 
    else
    {
      //echo "Returning true<br>";
      return true;
    }
  }

  public function validateCommanderName($input)
  {
    if (!preg_match("/^[A-Za-z0-9-\s]{1,50}$/", $input))
    {
      throw new Exception('Exception when validating type: commanderName. Value is: '.$input);
    } 
    else
    {
      //echo "Returning true<br>";
      return true;
    }
  }

  public function validateTerrainType($input)
  {
  /*
    if (!preg_match("/^[A-Za-z0-9-\s]{1,50}$/", $input))
    {
      echo "Returning false<br>";
      return false;
    } 
    else
    {
      //echo "Returning true<br>";
      return true;
    }
   */
    return true; // will be done later.
  }

  public function validateFilename($input)
  {
  /*
    if (!preg_match("/^[A-Za-z0-9-\s]{1,50}$/", $input))
    {
      echo "Returning false<br>";
      return false;
    } 
    else
    {
      //echo "Returning true<br>";
      return true;
    }
   */
    return true; // will be done later.
  }
  public function validateUnitType($input)
  {
    /*
      // will be done later.
    */
    return true;
  }
  public function validateDirection($input)
  {
    /*
      // will be done later.
    */
    return true;
  }

  public function validateUnitCount($input)
  {
    if (!preg_match("/^[0-9]{1,9}$/", $input))
    {
      throw new Exception('Exception when validating type: UnitCount. Value is: '.$input);
    } 
    else
    {
      //echo "Returning true<br>";
      return true;
    }
  }

  public function validateInitiative($input)
  {
    if (!preg_match("/^[0-9]{1,2}$/", $input))
    {
      throw new Exception('Exception when validating type: UnitCount. Value is: '.$input);
    } 
    else
    {
      //echo "Returning true<br>";
      return true;
    }
  }

public function validateTownName($input)
{
  if (!preg_match("/^[A-Za-z0-9-]{1,30}$/", $input))
  {
    echo "Returning false<br>";
    return false;
  } 
  else
  {
    //echo "Returning true<br>";
    return true;
  }
}  

public function validateModifier($input)
{
/*
  if (!preg_match("/^[A-Za-z0-9-]{1,30}$/", $input))
  {
    echo "Returning false<br>";
    return false;
  } 
  else
  {
    //echo "Returning true<br>";
    return true;
  }
  */
  return true; // will be done later
}

public function validateActionType($input)
{
/*
  if (!preg_match("/^[A-Za-z0-9-]{1,30}$/", $input))
  {
    echo "Returning false<br>";
    return false;
  } 
  else
  {
    //echo "Returning true<br>";
    return true;
  }
  */
  return true; // will be done later

}

public function validateArmyOrTownType($input)
{
  // validates that input is either "town" or "army".
/*
  if (!preg_match("/^[A-Za-z0-9-]{1,30}$/", $input))
  {
    echo "Returning false<br>";
    return false;
  } 
  else
  {
    //echo "Returning true<br>";
    return true;
  }
  */
  return true; // will be done later
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

}