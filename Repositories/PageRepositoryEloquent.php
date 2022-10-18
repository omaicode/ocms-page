<?php

namespace Modules\Page\Repositories;

use Omaicode\Repository\Eloquent\BaseRepository;
use Omaicode\Repository\Criteria\RequestCriteria;
use Modules\Page\Repositories\PageRepository;
use Modules\Page\Entities\Page;
use Modules\Page\Validators\PageValidator;

/**
 * Class PageRepositoryEloquent.
 *
 * @package namespace Modules\Page\Repositories;
 */
class PageRepositoryEloquent extends BaseRepository implements PageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Page::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
