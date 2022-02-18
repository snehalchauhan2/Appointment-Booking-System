<?php

namespace LaraBooking\Repositories\Base;

use LaraBooking\Repositories\Base\Traits\CrudMethods;

abstract class CrudRepository extends BaseRepository
{
    use CrudMethods;
}