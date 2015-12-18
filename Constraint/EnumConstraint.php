<?php
namespace JsonSchema\Constraint;

use JsonSchema\Constraint\Constraint;
use JsonSchema\Constraint\Exception\ConstraintParseException;

/**
 */
class EnumConstraint extends Constraint
{
  private $values;

  public function __construct(array $values) {
    $this->values = $values;
  }

  /**
   * @override
   */
  public static function getName() {
  	return 'enum';
  }

  /**
   * @bug does not work for object because compare is by ref.
   * @override
   */
  public function validate($doc, $context) {
    $valid = true;
    if(!in_array($doc, $this->values)) {
      $docStr = self::varDump($doc);
      $enumStr = self::varDump($this->values);
      $valid = new ValidationError($this, "Value '$docStr' not in enumeration '$enumStr'.", $context);
    }
    return $valid;
  }

  /**
   * @todo more robust.
   */
  public static function varDump($var) {
    return json_encode($var);
  }

  /**
   * @override
   */
  public static function canBuild($doc) {
    return is_array($doc) && sizeof($doc) > 0;
  }

  /**
   * @override
   */
  public static function build($doc, $context = null) {
    if(!is_array($doc)) {
      throw new ConstraintParseException('This keyword\'s value MUST be an array');
    }
    if(sizeof($doc) < 1) {
      throw new ConstraintParseException('This keyword\'s value MUST be an array.  This array MUST have at least one element.');
    }
    return new static($doc);
  }
}
