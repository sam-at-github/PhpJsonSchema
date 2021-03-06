<?php

function json_equality_compare_values($a, $b): bool {
  $typeA = gettype($a);
  $typeB = gettype($b);
  if((is_int($a) or is_double($a)) && (is_int($b) || is_double($b))) {
    return $a == $b;
  }
  if($typeA !== $typeB){
    return false;
  }
  if($typeA === 'object') {
    [$a, $b] = count((array)$a) >= count((array)$b) ? [$a, $b] : [$b, $a];
    return traverse_object($a, $b);
  }
  if($typeA === 'array') {
    [$a, $b] = count((array)$a) >= count((array)$b) ? [$a, $b] : [$b, $a];
    return traverse_array($a, $b);
  }
  return $a === $b;
}

function traverse_object(stdClass $a, stdClass $b) {
  foreach ($a as $k => $v) {
    if(isset($b->$k) && json_equality_compare_values($v, $b->$k)) {
      continue;
    } else {
      return false;
    }
  }
  return true;
}

/**
 * Different access syntax for array. Sigh.
 */
function traverse_array(array $a, array $b) {
  foreach ($a as $k => $v) {
    if(isset($b[$k]) && json_equality_compare_values($v, $b[$k])) {
      continue;
    } else {
      return false;
    }
  }
  return true;
}
