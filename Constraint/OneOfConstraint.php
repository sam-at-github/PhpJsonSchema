<?php
namespace JsonSchema\Constraint;

use JsonSchema\Constraint\SomeOfConstraint;

/**
 */
class OneOfConstraint extends SomeOfConstraint
{
  /**
   * @override
   */
  public static function getName() {
    return 'oneOf';
  }

  /**
   * @override
   */
  public function validate($doc) {
    $valid = new ValidationError($this, "No constraints passed. Exactly one required.");
    $countOf = 0;
    foreach($this->childConstraints as $constraint) {
      $validation = $constraint->validate($doc);
      if(!($validation instanceof ValidationError)) {
        $countOf++;
        if($countOf == 1) {
          $valid = true;
        }
        else if($countOf == 2) {
          $valid = new ValidationError($this, "More than one constraint passed. Exactly one required.");
          break;
        }
      }
    }
    return $valid;
  }
}
