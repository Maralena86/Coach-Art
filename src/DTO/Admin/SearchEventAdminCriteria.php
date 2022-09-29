<?php

declare(strict_types=1);

namespace App\DTO\Admin;

class SearchEventAdminCriteria
{
    public ?string $name ='';

    public ?string $options = '';

    public ?string $status = '';

    public ?array $therapist = [];

}
