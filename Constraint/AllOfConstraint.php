<?php
namespace JsonSchema\Constraint;

use JsonSchema\Constraint\SomeOfConstraint;

/**
 */
class AllOfConstraint extends SomeOfConstraint
{
  /**
   * @override
   */
  public static function getName() {
    return 'allOf';
  }

  /**
   * @override
   */
  public function validate($doc) {
    $valid = true;
    foreach($this->childConstraints as $constraint) {
      $validation = $constraint->validate($doc);
      if($validation instanceof ValidationError) {
        if($valid === true) {
          $valid = new ValidationError($this, "Not all constraints passed. All required to pass.");
        }
        $valid->addChild($validation);
        if(!$this->continueMode()) {
          break;
        }
      }
    }
    return $valid;
  }
}
