<?php
/**
 * Created by PhpStorm.
 * User: ngbamaw
 * Date: 31/12/18
 * Time: 00:37
 */

namespace AppBundle\Representation;

use Knp\Component\Pager\Pagination\SlidingPagination;
use Knp\Component\Pager\Paginator;

class Competences
{
    /**
     * @var array
     */
    public $data;

    /**
     * @var array
     */
    public $meta;

    public function __construct($data, $limit, $currentItems, $total, $currentPage)
    {
        $this->data = $data;

        $this->addMeta('current_page', $currentPage);
        $this->addMeta('limit', $limit);
        $this->addMeta('current_items', $currentItems);
        $this->addMeta('total_items', $total);
    }

    public function addMeta($name, $value)
    {
        if (isset($this->meta[$name])) {
            throw new \LogicException(sprintf('This meta already exists. You are trying to override this meta, use the setMeta method instead for the %s meta.', $name));
        }

        $this->setMeta($name, $value);
    }

    public function setMeta($name, $value)
    {
        $this->meta[$name] = $value;
    }
}