<?php

namespace App\Http\Helpers;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class RutRule implements ValidationRule
{
  /**
   * Run the validation rule.
   *
   * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
   */
  public function validate(string $attribute, mixed $value, Closure $fail): void
  {
    $run = $value;
    if (!$run) {
			$fail('RUN no es válido.');
			return;
		}
		$r			  = strtoupper(preg_replace('/\.|,|-/',"",$run));
		$sub_run 	= array();
		$sub_run	= substr($r,0,strlen($r)-1);
		if (!is_numeric($sub_run)) {
			$fail('RUN no es válido.');
			return;
		}
		$sub_dv		= substr($r,-1);
		$x			  = 2;
		$s			  = 0;
		for($i=strlen($sub_run)-1;$i>=0;$i--){
			if($x > 7) $x = 2;
			$s += (int) $sub_run[$i] * $x;
			$x++;
		}
		$dv 		  = 11-( $s%11 );
		if ($dv==10) $dv		= "K";
		if ($dv==11) $dv		= "0";
		if ( $dv!=$sub_dv ){
      $fail('RUN no es válido.');
			return;
		}
  }
}
