<?php

namespace App\Services;

use \JsonSerializable;

class Payment implements JsonSerializable  {

    public $beneficiaryId;
    public $amount;
    public $myReference;
    public $theirReference;

    public function __construct($beneficiaryId, $amount, $myReference, $theirReference) {
        $this->beneficiaryId = $beneficiaryId;
        $this->amount = $amount;
        $this->myReference = $myReference;
        $this->theirReference = $theirReference;
    }

    public function jsonSerialize(): array {
        return [
            'beneficiaryId' => $this->beneficiaryId,
            'amount' => $this->amount,
            'myReference' => $this->myReference,
            'theirReference' => $this->theirReference,
        ];
    }

}

