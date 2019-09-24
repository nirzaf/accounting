<?php

namespace Modules\Woopra\Http\ViewComposers;

use Auth;
use Illuminate\View\View;

class Header
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->getFactory()->startPush('scripts', view('woopra::script'));
    }
}
