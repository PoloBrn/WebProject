<?php

namespace MODELE;

interface CRUD
{
    function create($array);
    function update($array);
    function delete($array);
    function get($array);
}
