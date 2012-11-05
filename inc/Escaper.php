<?php

class Escaper
{

  
    
  public function escapeHtml($input)
  {
      $escapedData = null;
      for($i=0; $i < strlen($input); $i++)
      {
          if($input[$i] == "<" || $input[$i] == ">" || $input[$i] == "\"" || $input[$i] == "'" || $input[$i] == "&")
          {
              
          }
          else
          {
              $escapedData[] = $input[$i];
          }     
      }
      $result = implode("", $escapedData);
      return $result;
  } 
}