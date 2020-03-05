<?php

/**
 * GravityPHP is a library that makes writting HTML forms easy
 * 
 * @Author: titaro
 * @Github: github.com/tyroklone
 * @License: None 
 */

// Create the classs
class GravityPHP
{
 # Class properties

 /**
  * Storage array for the entire form
  *
  * @Var Array
  */
 protected $form = [];

 /**
  * Used for tag nesting
  */
 private $return = true;

 /**
  * Storage for the used label
  */
 private $label = [];

 /**
  * Form controller
  *
  * @Var boolean
  */
 private $formChain = true;

 /**
  * Form supplied array storage
  *
  * @Var Array
  */
 protected $formStore = [];

 # Class methods

 /**
  * Method for <head> tag
  */
 public function formTag($formArray = [])
 {
  // We will definately need this later
  $this->formStore = $formArray;

  $formKeep = "<form";
  
  // Loop in the atrributes
  foreach($formArray as $key => $value)
  {
   $formKeep .= ' '.$key.'='.'"'.$value.'"';
  }

  // Close the first half of the tag
  $formKeep .= '>';

  // Do a join
  $formKeep .= join('', $this->form);
  
  //$formKeep = $this->input;

  // Close the form
  $formKeep .= '</form>';

  if($this->formChain === true)
  {
   return $this;
  }
   else
  {
   return $formKeep;
  }
 }

 /**
  * Method for <input> tag
  */
 public function inputTag($inputArray = [])
 {
  $inputKeep = '<input';

  // Loop in the input attributes
  foreach($inputArray as $key => $value)
  {
   $inputKeep .= ' '.$key.'='.'"'.$value.'"';
  }

  // Close the tag
  $inputKeep .= '>';
  if($this->return === true)
  {
   $this->form[] = $inputKeep;
  }

  if($this->return === true)
  {
   return $this;
  }
   else
  {
   return $inputKeep;
  }
 }

 /**
  * Method for line breaks
  */
 public function br($count = null)
 {
  // <br> tag
  $br = '<br>';

  if(!is_null($count))
  {
   // Loop
   for($c = 1; $c <= $count; $c++)
   {
    if($this->return === true)
    {
     $this->form[] = $br;
    }
   }
  }
   else
  {
   $this->form[] = $br;
  }

  if($this->return === true)
  {
   return $this;
  }
   else
  {
   return $br;
  }
 }

 /**
  * Method for labels
  */
 public function labelTag($text = 'GravityPHP', $for = null)
 {
  $labelKeep = '<label';
  if(!is_null($for))
  {
   $labelKeep .= ' for="'.$for.'"';
  }

  // Close the tag
  $labelKeep .= '>';

  // Label text
  $labelKeep .= $text;

  // Close the tag
  $labelKeep .= '</label>';

  // Add to input
  if($this->return === true)
  {
   $this->form[] = $labelKeep;
  }

  if($this->return === true)
  {
   return $this;
  }
   else
  {
   return $labelKeep;
  }
 }

 /**
  * Method for select box
  */
 public function selectTag($selectArray = [], $optionsArray = [])
 {
  $selectKeep = '<select';

  // Loop in the input attributes
  foreach($selectArray as $key => $value)
  {
   $selectKeep .= ' '.$key.'='.'"'.$value.'"';
  }
  
  // Close the tag
  $selectKeep .= '>';

  // Sort the array incase it was sorted wrongly
  ksort($optionsArray);

  // Useless counter
  $cnt = 0;

  // Loop in the options tag
  foreach($optionsArray as $id)
  {
   $check = array_keys($optionsArray);
   $check = $check[$cnt];
   
   // Is it numeric
   if(is_numeric($check))
   {
    if(array_key_exists('text', $id))
    {
     $text = $id['text'];
     unset($id['text']);
    }
     else
    {
     $text = 'GravityPHP';
    }

    foreach($id as $key => $value)
    {
     $selectKeep .= '<option';
     $selectKeep .= ' '.$key.'='.'"'.$value.'"';
     $selectKeep .= '>';
     $selectKeep .= $text;
     $selectKeep .= '</option>';
    }
   }
    else
   {
    die('Non numeric value used to represent options tag in the options array');
   }
   $cnt++;
  }

  // close the select tag
  $selectKeep .= '</select>';

  // upload to the input property :D
  if($this->return === true)
  {
   $this->form[] = $selectKeep;
  }

  if($this->return === true)
  {
   return $this;
  }
   else
  {
   return $selectKeep;
  }
 }

 /**
  * Method for text
  */
 public function text($text)
 {
  if($this->return === true)
  {
   $this->form[] = $text;
  }

  if($this->return === true)
  {
   return $this;
  }
   else
  {
   return $text;
  }
 }

 /**
  * Method for conditions
  */
 public function condition($operation, $true, $false)
 {
  $this->return = false;
  // for some reason this code works and still gives a warning
  $result = ($operation) ? $true($this) : $false($this);
  $this->return = true;
  $this->form[] = $result;

  return $this;
 }

 /**
  * Method to add short tag dynamically
  */
 public function shortTag($tag, $shortArray = [], $content = null)
 {
  $shortKeep = "<$tag";
  if(!empty($shortArray))
  {
   foreach($shortArray as $key => $value)
   {
    $shortKeep .= ' '.$key.'='.'"'.$value.'"';
   }
  }

  $shortKeep .= '>';

  if(!is_null($content))
  {
   $shortKeep .= $content;
  }

  if($this->return === true)
  {
   $this->form[] = $shortKeep;
  }

  if($this->return === true)
  {
   return $this;
  }
   else
  {
   return $shortKeep;
  }
 }

 /**
  * Method to add full tags dynamically
  */
 public function longTag($label = null, $tag = null, $content, $longArray = [])
 {
  if(!preg_match('/[A-z0-9]*/i', $label))
  {
   die('Unsurpported character used as label name.');
  }

  if(!is_null($label))
  {
   $longKeep = "<out-top-$label-@$tag";
  }
   else
  {
   $longKeep = "<$tag";
  }

  if(!empty($longArray))
  {
   foreach($longArray as $key => $value)
   {
    $longKeep .= ' '.$key.'='.'"'.$value.'"';
   }
  }
  
  if(!is_null($label))
  {
   $longKeep .= "@-in-top-$label>";
  }
   else
  {
   $longKeep .= ">";
  }

  // A simple trick
  if(is_string($content))
  {
   $longKeep .= $content;
  }

  if(!is_null($label))
  {
   $longKeep .= "<in-bottom-$label-@/$tag@-out-bottom-$label>";
  }
   else
  {
   $longKeep .= "</$tag>";
  }
  
  if($this->return === true)
  {
   $this->form[] = $longKeep;
  }

  if($this->return === true)
  {
   return $this;
  }
   else
  {
   return $longKeep;
  }
 }

 /**
  * Methode for nesting tags in one another
  * Probably one of the most important method
  */
 public function nest($label, $data, $position = 'IN_TOP')
 {
  if(!preg_match('/[A-z0-9]*/i', $label))
  {
   die('Unsurpported character used as label name.');
  }

  $this->label[] = $label;

  $current = join('', $this->form);

  switch($position)
  {
   case 'IN_TOP':
   $this->return = false;
   $ck = (is_string($data) ? $data : $data($this));
   $replacement = "@-in-top-$label>$ck";
   $nest = str_replace("@-in-top-$label>", $replacement, $current);
   $this->return = true;
   break;
   case 'IN_BOTTOM':
   $this->return = false;
   $ck = (is_string($data) ? $data : $data($this));
   $replacement = "$ck<in-bottom-$label-@";
   $nest = str_replace("<in-bottom-$label-@", $replacement, $current);
   $this->return = true;
   break;
   case 'OUT_TOP':
   $this->return = false;
   $ck = (is_string($data) ? $data : $data($this));
   $replacement = "$ck<out-top-$label-@";
   $nest = str_replace("<out-top-$label-@", $replacement, $current);
   $this->return = true;
   break;
   case 'OUT_BOTTOM':
   $this->return = false;
   $ck = (is_string($data) ? $data : $data($this));
   $replacement = "@-out-bottom-$label>$ck";
   $nest = str_replace("@-out-bottom-$label>", $replacement, $current);
   $this->return = true;
   break;
  }

  unset($this->form);
  $this->form[] = $nest;

  return $this;
 }

 /**
  * Destroyer method
  */
 private function destroy()
 {
  // Reset everything
  // Back to square 1
  $this->form = [];
  $this->formStore = [];
  $this->formChain = true;
 }

 /**
  * A parser for the form
  */
 public function parser()
 {
  $this->formChain = false;

  foreach($this->label as $label)
  {
   $this->form = (array)preg_replace('/[A-z]*-[A-z]*-'.$label.'-@/i', '', join('', $this->form));
   $this->form = (array)preg_replace('/@-[A-z]*-[A-z]*-'.$label.'/i', '', join('', $this->form));
  }

  echo $this->formTag($this->formStore);

  // Do a clean up
  $this->destroy();
 }
}

/**
 * End of code
 * 
 * Feel free to contribute and suggest improvements
 * 
 * GravityPHP v1.0
 */

?>