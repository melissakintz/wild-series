<?php
namespace App\Service;

class Slugify
{
    public function generate(string $input)
    {

        $input = trim($input);

        $pattern = ['@[éèê]@', '@[\!\?\'\$\."]@', '@[à]@', '@[ç]@', '@[ù]@', '@[\s+-+]@'];
        $replace = ['e','', 'a', 'c', 'u', '-'];
        return preg_replace('@[-]+@','-', strtolower(preg_replace($pattern, $replace, $input)));
    }
}