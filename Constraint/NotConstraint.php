<?php
namespace JsonSchema\Constraint;

/**
 * Not some EmptyConstraint.
 */
class NotConstraint extends Constraint
{
  private $innerConstraint;

  public function __construct(EmptyConstraint $innerConstraint) {
    $this->innerConstraint = $innerConstraint;
  }

  /**
   * @override
   */
  public static function getName() {
  	return 'not';
  }

  /**
   * @override
   */
  public function validate($doc) {
    $valid = true;
    $validation = $this->innerConstraint->validate($doc);
    if(!$validation instanceof ValidationError) {
      $valid = new ValidationError($this, "Validation succeed. Expected failure.");
    }
    return $valid;
  }

  /**
   * @override
   */
  public static function build($doc, $context = null) {
    return new static(EmptyConstraint::build($doc));
  }
}
