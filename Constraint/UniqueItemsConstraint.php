<?php
namespace JsonSchema\Constraint;

use JsonSchema\Constraint\Constraint;
use JsonSchema\Constraint\Exception\ConstraintParseException;

/**
 * The uniqueItems constraint.
 */
class UniqueItemsConstraint extends Constraint
{
  private $unique;

  /**
   * @input $unique Bool whether to apply uniqueness at all.
   */
  public function __construct($unique) {
    $this->unique = (bool)$unique;
  }

  /**
   * @override
   */
  public static function getName() {
    return 'uniqueItems';
  }

  /**
   * @override
   */
  public function validate($doc, $context) {
    $valid = true;
    if(is_array($doc) && $this->unique) {
      $h = [];
      foreach($doc as $v) {
        $sv = serialize($v);
        if(isset($h[$sv])) {
           $valid = new ValidationError($this, "Non unique item $sv found.", $context);
           break;
        }
        $h[$sv] = true;
      }
    }
    return $valid;
  }

  /**
   * @override
   */
  public static function build($context) {
    $doc = $context->uniqueItems;

    if(!is_bool($doc)) {
      throw new ConstraintParseException('The value MUST be a boolean.');
    }

    return new static($doc);
  }
}
