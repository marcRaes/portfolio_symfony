<?php

namespace App\Interface;

interface ImageHolderInterface
{
    public function getPicture(): ?string;
    public function setPicture(?string $picture): static;
}
