<?php
namespace JsonSchema\Constraint;

use JsonSchema\Constraint\Constraint;
use JsonSchema\Constraint\Exception\ConstraintParseException;

/**
 * The minItems constraint.
 */
class MinItemsConstraint extends Constraint
{
  private $minItems;

  public function __construct($minItems) {
    $this->minItems = (int)$minItems;
  }

  /**
   * @override
   */
  public static function getName() {
  	return 'minItems';
  }

  /**
   * @override
   */
  public function validate($doc, $context) {
    $valid = true;
    if(is_array($doc)) {
      if(count($doc) < $this->minItems) {
        $valid = new ValidationError($this, "Number of items < {$this->minItems}", $context);
      }
    }
    return $valid;
  }

  /**
   * @override
   */
  public static function build($context) {
    $doc = $context->minItems;
    if(!is_int($doc)) {
      throw new ConstraintParseException('The value MUST be an integer.');
    }
    if($doc < 0) {
      throw new ConstraintParseException('This integer MUST be greater than, or equal to 0.');
    }
    return new static($doc);
  }
}
