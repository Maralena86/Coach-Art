<?php

declare(strict_types=1);

namespace App\DTO\Admin;

class SearchEventAdminCriteria
{
    public ?string $name ='';

    public ?string $options = '';

    public ?string $status = '';

    public ?array $therapist = [];


    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of options
     */ 
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set the value of options
     *
     * @return  self
     */ 
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of therapist
     */ 
    public function getTherapist()
    {
        return $this->therapist;
    }

    /**
     * Set the value of therapist
     *
     * @return  self
     */ 
    public function setTherapist($therapist)
    {
        $this->therapist = $therapist;

        return $this;
    }
}
