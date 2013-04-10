<?php

namespace ILL\DataCiteDOIBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class MetadataIdentifierValidator extends ConstraintValidator
{
	public function __construct($prefix = null)
	{
		$this->prefix = $prefix;
	}

    public function validate($value, Constraint $constraint)
    {
    	if($this->prefix == null) return true;

        if (!preg_match(sprintf('/^(%s\/[-_a-zA-Z0-9.:\+]+)/', addcslashes($this->prefix, ".")), $value, $matches)) {
            $this->context->addViolation($constraint->message, array('%string%' => $value));
        }
    }
}